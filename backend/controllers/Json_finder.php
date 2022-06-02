<?php

header('Access-Control-Allow-Origin: *');
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Json_finder extends CI_Controller {

    public function __construct() {
        date_default_timezone_set('America/Asuncion');  
        parent::__construct();
    }

    public function index() {
        echo json_encode(array());
    }

    public function find_rates_from_vehicles() {
        assert_user();

        $data = input_read_post($this->input, array('vehicleType'));
        $rates = $this->rates_model->find(array("vehicleType" => $data['vehicleType']));

        $content = array();

        foreach ($rates as $rate) {
            $content[$rate->id] = $rate->name;
        }

        echo json_encode($content);
        exit();
    }

    public function calculate() {
        assert_user();
        
        $data = input_read_post($this->input, array('ticketId', 'vehicleType', 'rateId', 'clientId','discount','otherPayments','missedTicket','comments'));
        $data['error'] = "";
        
	/* Configuraciones generales */
    	$config = $this->config_model->find_first();
    	$data['ratePrice'] = $config->defaultPrice;
    	$data['freeTime'] = $config->freeTime;
        $data['amount'] = $config->defaultPrice;
        $data['timeToGo'] = $config->timeToGo;
        
        if(isset($data['missedTicket']) && $data['missedTicket'] == 1){
            $data['ticketId'] = "0";
            $data['rateId'] = "-1"; //extravio de ticket
            $data['in'] = date("Y-m-d H:i:s");
            $data['out'] = date("Y-m-d H:i:s");
            $data['rateName'] = "Extravio de Ticket";
            $data['rateType'] = "-1";
            $data['discount'] = 0;
            $data['otherPayments'] = 0;
            $discount = 0;
        }else{
        
            if (!isset($data['ticketId'])) {
                echo json_encode(array("error" => "No se encontro el codigo de barras"));
                exit();
            } else if(strlen($data['ticketId']) != 16 ) {
                echo json_encode(array("error" => "El codigo de barras es incorrecto, el formato debe ser: AB10052003270000"));
                exit();
            } else if (!isset($data['vehicleType'])) {
                echo json_encode(array("error" => "No se encontro el tipo de vehiculo"));
                exit();
            } else if (!isset($data['rateId'])) {
                echo json_encode(array("error" => "No se encontro ninguna tarifa asociado al vehiculo"));
                exit();
            }
            
            /* Validacion de registro en caja, solo se puede dar lectura y confirmar el pago del ticket 1 sola vez */
            $ticket = $this->reports_model->find_first(array("ticketId" => $data['ticketId']));

            if($ticket != null){
                echo json_encode(array("error" => "Este numero de ticket ya se ha registrado"));
                exit();
            }
            
            $entryTicket = $this->entry_tickets_model->find_first(array("ticketId" => $data['ticketId']));
            if($entryTicket != null){
              $data['ticketCode'] = $entryTicket->id;
            }else{
              $data['ticketCode'] = 0;              
            }
			
			
            $data['in'] = getBarCodeDate($data['ticketId']);
            
            $data['out'] = date("Y-m-d H:i:s");
            $dateDiff = $this->diffDate($data['in'], $data['out']);
            $data['days'] = $dateDiff['days'];
            $data['hours'] = $dateDiff['hours'];
            $data['minutes'] = $dateDiff['mins'];
            

            $ticketDay = substr($data['ticketId'], 6, 2);
            $ticketHour = substr($data['ticketId'], 8, 2);
            $ticketMin = substr($data['ticketId'], 10, 2);
            $ticketMonth = substr($data['ticketId'], 4, 2);
            $thisDay = date("d");
            $thisHour = date("H");
            $thisMinute = date("i");
            $thisMonth = date("m");
            /*
            if($ticketMonth > $thisMonth){
                echo json_encode(array("error" => "El Mes registrado en el ticket es incorrecto: "));
                exit();
            }else if($ticketDay > $thisDay ){
                echo json_encode(array("error" => "El dia del ticket es incorrecto "));
                exit();
            }else if($ticketHour > $thisHour){
                echo json_encode(array("error" => "La hora registrada en el ticket es incorrecta "));
                exit();
            }else if(($ticketHour == $thisHour) && ($ticketMin > $thisMinute)){
                echo json_encode(array("error" => "El minuto registrado en el ticket es incorrecto"));
                exit();
            }
            */
            $amount = $this->rates_model->find_by_id($data['rateId']);
            if($amount == null){
                echo json_encode(array("error" => "Ocurrio un error al procesar la tarifa, verifique las configuraciones de tarifa"));
                exit();
            }
            
            $data['rateName'] = $amount->name;
            $data['rateType'] = $amount->rateType;
            $data['ratePrice'] = $amount->price;
            $data['vehicleType'] = $amount->vehicleType;
            $data['rateDescription'] = $amount->description;
            
    	    /** Validacion si existe un tiempo de permanencia sin costo **/
            $freeTime = $this->isFreeTime($data);
            
            $discountFreeTime = $data['freeTime']; 
          
            
            if ($amount->rateType == FREE  || $freeTime) {
                $data['amount'] = 0;
            } else if ($amount->rateType == 1) { /* por fraccion */
                $rateFraction = ($amount->price / 4);
                $totalTime = ($data['days'] * 24) + ($data['hours']);
                 if($discountFreeTime > 0){
                    $totalTime = $totalTime - $discountFreeTime/60;
                }
                if ($data['minutes'] <= 15) {
                    $roundMinutes = $rateFraction;
                } else {
                    $roundMinutes = round(($data['minutes'] / 15), 0) * $rateFraction;
                }
               
                $data['amount'] = round(($totalTime * $amount->price) + $roundMinutes);
            } else if ($amount->rateType == 2) { /* por hora */
                $totalTime = ($data['days'] * 24) + ($data['hours']);
                
                if ($data['minutes'] > 0) {
                    $totalTime += 1;
                }
                if($discountFreeTime > 0){
                    $totalTime = $totalTime - $discountFreeTime/60;
                }
                $data['amount'] = round($totalTime * $amount->price);
            } else if ($amount->rateType == 3) { /* por dia */
                $totalTime = 0;
                if ($data['days'] == 0) {
                    $data['amount'] = $amount->price;
                } 
                if($data['days'] > 0){
                    if ($data['hours'] > 0) {
                       $totalTime += 1;
                    }
                    $totalTime += $data['days'];
                
                    $data['amount'] = round($totalTime * $amount->price);
                }
                
            } else if ($amount->rateType == 4) {
                if ($data['days'] < 30) { /* por mes */
                    $data['amount'] = $amount->price;
                } else {
                    $data['amount'] = round(($data['days'] / 30), 0) * $amount->price;
                }
            }
        }
        $data['totalCalculate'] = $data['amount'];
        $discount = isset($data['discount']) ? $data['discount'] : 0;
        $data['discount'] = $discount;
        $data['otherPayments'] = isset($data['otherPayments']) ? $data['otherPayments'] : 0;
        $data['totalToPay'] = ($data['amount']+$data['otherPayments']) - $discount;
        $data['username'] = current_user()->username;
        $data['clientId'] =  isset($data['clientId']) ? $data['clientId'] : 0;
        $data['paidOut'] = PAID_OUT_CODE;

        $insert_result = $this->reports_model->insert($data);
        
        $data['insertId'] = $insert_result;
        $this->audits_model->insert(
            array(
              "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
              "userIp" => current_user_ip(),
              "activityName" => "Se ha procesado la tarifa con id: ".$data['ticketId'],
              "lastQuery" => $this->db->last_query(),
              "currentPage" => "Menu Inicio",
              "currentMethod" => "Calcular Tarifa"
            )
        );
        echo json_encode($data);
        exit();
    }
    
    
    private function ifExpiredTimeToGo($data = array()){
    	$result = false;

        $registered = $data['registered'];
        $now = date("Y-m-d H:i:s");
        
    	$diffDate = diffDate($registered,$now);
    	$totalTime = (int)($diffDate['days']*24*60) + (int)($diffDate['hours']*60) + (int)$diffDate['mins'];
       
    	
		if($totalTime >= $data["timeToGo"]){
			$result = true;
		}	
    
    
    	return $result;	
    }
    
	/*** Si freeTime esta definido y es mayor a cero, se compara en el tiempo de permanencia (tiempo en minutos) ***/
    private function isFreeTime($data = array()){
    	$result = false;
    
    	if(isset($data['freeTime']) && !empty($data['freeTime']) && $data['freeTime'] > 0){
    		$totalTime = ($data['days'] * 24) + ($data['hours']*60) + $data['minutes'];
    		if($totalTime <= $data['freeTime'] ){
    			$result = true;
    		}	
    
    	}
    
    	return $result;	
    }
    
    
    public function cancel(){
        assert_user();
        
        $data = input_read_post($this->input, array('ticketId'));
        $data['error'] = "";
        
        $ticket = $this->reports_model->find_first(array("id" => $data['ticketId'], "username" => current_user()->username));
        if($ticket == null){
            echo json_encode(array("error" => "Ocurrio un error al confirmar esta operacion, verifique el codigo de ticket"));
            exit();
        }
        
        $result = $this->reports_model->delete($ticket->id);
        $this->audits_model->insert(
            array(
              "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
              "userIp" => current_user_ip(),
              "activityName" => "Se ha anulado un cobro de tarifa del ticket: ".$data['ticketId']. " y id interno: ".$ticket->id,
              "lastQuery" => $this->db->last_query(),
              "currentPage" => "Menu Inicio",
              "currentMethod" => "Calcular Tarifa"
            )
        );
        
        $data["error"] = "Ticket eliminado ";
        echo json_encode($data);
        exit();
        
        
    }

    private function getBarCodeDate($barCode = null) {
        if ($barCode == null) {
            return null;
        }

        //AB10052003270000
        $month = substr($barCode, 4, 2);
        $day = substr($barCode, 6, 2);
        $hour = substr($barCode, 8, 2);
        $min = substr($barCode, 10, 2);
        $year = date("Y");
        return $year . "-" . $month . "-" . $day . " " . $hour . ":" . $min . ":" . "00";
    }

    private function diffDate($in = null, $out = null) {
        if ($in == null || $out == null) {
            return null;
        }

        $dteStart = new DateTime($in);
        $dteEnd = new DateTime($out);

        $dteDiff = $dteStart->diff($dteEnd);
        $day = $dteDiff->format("%a");
        /*
        $month = $dteDiff->format("%a");
        
        if($month > 0){
            $daysOfMonth = $dteDiff->format("%t");
        }else{
            $daysOfMonth = 0;
        }
        */
        
        if ($day > 0) {
            $diff = array(
                "days" => $day,
                "hours" => $dteDiff->format("%H"),
                "mins" => $dteDiff->format("%I"),
            );
        } else {
            $diff = array(
                "days" => 0,
                "hours" => $dteDiff->format("%H"),
                "mins" => $dteDiff->format("%I"),
            );
        }

        return $diff;
    }

}
