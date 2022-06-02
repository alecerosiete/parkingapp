<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class BarcodeReader extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->show_read();
    }

    public function show_read() {
        $this->layout->setLayout('barcode_reader');
        $this->layout->setTitle('ParkingApp :: Lectura de ticket');

        $this->audits_model->insert(
                array(
                    "username" => "Desconocido",
                    "userIp" => "localhost",
                    "activityName" => " Lectura de ticket",
                    "lastQuery" => null,
                    "currentPage" => " Lectura de ticket",
                    "currentMethod" => "Visualizar pagina  Lectura de ticket"
                )
        );

        $this->layout->view("/show_barcode_reader");
    }
	
    /* PROCESO DE SALIDA DEL ESTACIONAMIENTO */    
    public function read($ticketId = null) {
        $activityMessage = "";

        if ($ticketId == null) {
            $ticketId = $this->input->post("ticketId", true);
        }
        if ($ticketId == null) {
          $data =  array("status" => "ERROR","message" => "No se obtuvo el id del ticket via post ");
            echo json_encode($data);
            exit();
          
        }
        
        $companyData = $this->config_model->find_first();
        
        if ($companyData == null) {            
            $data =  array("status" => "ERROR","message" => "No se encontro informacion sobre la empresa ");
            echo json_encode($data);
            exit();
        }        
        
        $verifyOnExit = isset($companyData->verifyOnExit) ? $companyData->verifyOnExit : VERIFY_ON_EXIT;
        $ticketData = $this->reports_model->find_first(array("ticketId" => $ticketId));    
        if($verifyOnExit == 1){
	        /* si fecha/hora de ticket es menor al tiempo libre permitido, dar salida automatica */
	        
	        if ($ticketData == null) {
                if($this->getTicketDiff($ticketId) < $companyData->toExitFree){

                    /* registrar la salida en la base de datos */
                    $r['totalCalculate'] = 0;
                    $r['discount'] = 0;
                    $r['otherPayments'] = 0;
                    $r['totalToPay'] = 0;
                    $r['username'] = "Anonimo";
                    $r['clientId'] =  0;
                    $r['paidOut'] = PAID_OUT_CODE;
                    $r['ticketId'] = $ticketId;
                    $r['rateId'] = "-2"; //salida automatica antes de tiempo 
                    $r['in'] = getBarCodeDate($ticketId);
                    $r['out'] = date("Y-m-d H:i:s");
                    $r['rateName'] = "Salida del estacionmaiento dentro del tiempo permitido";
                    $r['ticketExitStatus'] = 1;
                    $insert_r = $this->reports_model->insert($r);

                    /* liberar la barrera */
                    $this->relayOnExit();
                    $data =  array("status" => "OK", "message" => "El ticket ".$ticketId." ha salido correctamente");
                    $activityMessage = "El ticket ".$ticketId." ha salido correctamente";
                    $this->audits_model->insert(
                            array(
                            "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
                            "userIp" => "localhost",
                            "activityName" => $activityMessage,
                            "lastQuery" => $this->db->last_query(),
                            "currentPage" => "Lectura de ticket de salida",
                            "currentMethod" => "Read"
                            )
                    );
                    echo json_encode($data);
                    exit();
                }else{
                    $data =  array("status" => "ERROR", "message" => "El ticket ".$ticketId." expiro al salir sin pagar o no se cobro en caja");
                    $activityMessage = "El ticket ".$ticketId." Expiro al salir sin pagar o no se cobro en caja";
                    $this->audits_model->insert(
                            array(
                            "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
                            "userIp" => "localhost",
                            "activityName" => $activityMessage,
                            "lastQuery" => $this->db->last_query(),
                            "currentPage" => "Lectura de ticket de salida",
                            "currentMethod" => "Read"
                            )
                    );
                    echo json_encode($data);
                    exit();
                }
            }

            // $ticketData = $this->reports_model->find_first(array("ticketId" => $ticketId));

            $dateDiff = diffDate($ticketData->in, $ticketData->out);

         
            $data = array(
                "companyName" => $companyData->company,
                "companyAddress" => $companyData->address,
                "companyPhone" => $companyData->phone,
                "companyRuc" => $companyData->ruc,
                "timeToGo" => $companyData->timeToGo,
                "verifyOnExit" => $companyData->verifyOnExit,
                "in" => $ticketData->in,
                "out" => $ticketData->out,
                "days" => $dateDiff['days'],
                "hours" => $dateDiff['hours'],
                "minutes" => $dateDiff['mins'],
                "subtotal" => $ticketData->totalCalculate,
                "discount" => $ticketData->discount,
                "total" => $ticketData->totalToPay,
                "rate" => $ticketData->ratePrice,
                "rateType" => $ticketData->rateType,
                "ticketCode" => $ticketData->ticketCode,
                "ticketExitStatus" => isset($ticketData->ticketExitStatus) ? $ticketData->ticketExitStatus : 0,
                "paidOut" => isset($ticketData->paidOut) ? $ticketData->paidOut : 0,
                "registered" => $ticketData->registered
            ); 
            
            $timeToGo = isset($companyData->timeToGo) ? $companyData->timeToGo : TIME_TO_GO;
    
            if($timeToGo > 0){
                if($this->ifExpiredTimeToGo($data)){
                    $activityMessage = "El ticket ".$ticketId." para la salida recientemente expiro";
                    $data =  array("status" => "ERROR", "message" => $activityMessage);
                    $this->audits_model->insert(
                        array(
                        "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
                        "userIp" => "localhost",
                        "activityName" => $activityMessage,
                        "lastQuery" => $this->db->last_query(),
                        "currentPage" => "Lectura de ticket de salida",
                        "currentMethod" => "Read"
                        )
                    );
                   echo json_encode($data);
                   exit();
                }
                
            }
        
            /* verifica si el ticket ya fue utilizado anteriormente para salir */ 
            if($data['ticketExitStatus'] == TICKET_OUT){
               $data =  array("status" => "ERROR", "message" => "El ticket ".$ticketId." ya fue registrado en la salida del estacionamiento");
                $activityMessage = "El ticket ".$ticketId." ya fue registrado en la salida del estacionamiento";
                    $this->audits_model->insert(
                        array(
                        "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
                        "userIp" => "localhost",
                        "activityName" => $activityMessage,
                        "lastQuery" => $this->db->last_query(),
                        "currentPage" => "Lectura de ticket de salida",
                        "currentMethod" => "Read"
                        )
                    );
               echo json_encode($data);
               exit();
            }
        

            /* Verificar que el ticket ya este pagado o haya pasado por caja (Solo si el caje esta conectado con la barrera) */
            if($data['paidOut'] == PAID_OUT_CODE){
              	//ACTUALIZAR estado del ticket a PAGADO:
            	$update = $this->reports_model->update($ticketData->id,array("ticketExitStatus" => TICKET_OUT));
            	//El ticket fue pagado...activar la salida..		     	
                try {
            	    //Activa el relay de la barrera de salida
                    $result = $this->relayOnExit();
                    if($result){
                        $status = "OK";
                        $msg ="Activando la salida.. ticket pagado... ";
                    }else{
                        $status = "Error";
                        $msg ="Ocurrio un error al ejecutar el relay ";
                    }
                } catch (Exception $e) {
                    error_log('Excepcion capturada: relayOnExit con conexion', $e->getMessage(), "\n");
                    $status = "Error";
                    $msg ="Ocurrio un error al ejecutar el relay ";
                } 
                
                $data =  array("status" => $status, "message" => $msg);
                $activityMessage = $msg;
                echo json_encode($data);
                
            }else{
                //No se registro el pago.. pendiente de cobro.. cancelar la salida..
                error_log("No se ha detectado ticket pagado.. no se puede activar la salida..");
                $data= array("status" => "ERROR","message" =>"No se ha detectado ticket pagado.. no se puede activar la salida... ");
                $activityMessage = "No se ha detectado ticket pagado.. no se puede activar la salida.. TICKET: ".$ticketId;
                $this->audits_model->insert(
                    array(
                    "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
                    "userIp" => "localhost",
                    "activityName" => $activityMessage,
                    "lastQuery" => $this->db->last_query(),
                    "currentPage" => "Lectura de ticket de salida",
                    "currentMethod" => "Read"
                    )
                );
                echo json_encode($data);
                exit();
            }	
        }else{
    		//Si no esta conectado con la barrera de salida, directamente marca el ticket como invalido y levanta la barrera
            $insert_result = $this->reports_model->update($ticketData->id,array("ticketExitStatus" => TICKET_OUT));

    		try {
			    //Activa el relay de la barrera de salida
	        	$result = $this->relayOnExit();
    		} catch (Exception $e) {
	        	error_log('Excepcion capturada: relayOnExit sin conexion: ', $e->getMessage(), "\n");
	    	} 
    		    
    	    $data =  array("status" => "OK","message" => "Activando la salida.. ticket pagado... ".$insert_result);
    	    echo json_encode($data);
	    }
          

        $this->audits_model->insert(
            array(
            "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
            "userIp" => "localhost",
            "activityName" => $activityMessage,
            "lastQuery" => $this->db->last_query(),
            "currentPage" => "Lectura de ticket de salida",
            "currentMethod" => "Read"
            )
        );
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
    
   public function relayOnExit(){
    	$relay = new Relay_USB(RELAY_PORT_OUTPUT, RELAY_NUMBER_OUTPUT, "on");

        $result = $relay->exec_relay();

        sleep(BAR_TIME);
        $relay->setAction("off");
  
        $relay->setCommand($relay->getAction());
        
        try{
            $result = $relay->exec_relay();    
        } catch (Exception $e) {
            error_log('Excepcion capturada: relayOnExit con conexion', $e->getMessage(), "\n");
            $result = "Excepcion capturada: relayOnExit con conexion";
        } 
                
    	return $result;
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

    public function onButtonPress(){
	    print  $this->printEntryTicket();
    }

    public function printEntryTicket() {
	    $this->load->library('ticket_printer');

        /* generar el id con formato fecha hora en formato actal */
        /* guardar el nuevo id en la base de datos con estado ingreso */
        /* agregar campos para pesonalizar los mensajes y datos de la empresa */
        /* debe tener un id unico impreso en el ticket: puede ser el id de registro de tickets */

        try {
            $companyData = $this->config_model->find_first();
            $ticketId = $this->getTicketId();
            $in =  getBarCodeDate($ticketId);

            if($in == null){
                return;
            }

            /* Insert entry ticket data */
            $data['ticketId'] = $ticketId;
            $data['entry'] = $in;
            /*$data['totemId'] = "1";
            $data['totemType'] = "I";*/
            $insert_result = $this->entry_tickets_model->insert($data);


            $buffer = array(
                "company" => $companyData->company,
                "ruc" => $companyData->ruc,
                "address" => $companyData->address,
                "phone" => $companyData->phone,
                "id" => $insert_result,
                "in" => $in,
                "defaultPrice" => $companyData->defaultPrice,
                "ticketId" => $ticketId
                ); 
            
            try {             
                // CONFIGURACION PARA WINDOWS			
                $connector = new Mike42\Escpos\PrintConnectors\WindowsPrintConnector("MINIPRINTER");
                $printer = new Mike42\Escpos\Printer($connector);		

                // CONFIGURACION PARA LINUXo
                //$connector = new FilePrintConnector("/dev/usb/lp0");
                        
                    //$printer = new Printer($connector);
                $printer->initialize();
                    $printer->setJustification(1);                
                    $printer->setEmphasis(true);
                $printer->feed(1);
                
                    $printer->text("*******************************\n");
                    $printer->text($companyData->company."\n");                
                    $printer->text("*******************************\n");

                    $printer->setEmphasis(false);
                    $printer->text("RUC: {$companyData->ruc}\n");
                    $printer->text("Direccion: ".$companyData->address."\n");
                    $printer->text("Tel.: ".$companyData->phone."\n");
                    $printer->text("CODIGO #{$insert_result}\n");
                    $printer->feed(1);
                    $printer->text("-------------------------------\n");
                    $printer->text("FECHA/HORA ENTRADA\n");
                    $printer->text("ENTRADA: ".date("d/m/Y H:i:s",strtotime($in))."\n");
                    
                    $printer->setBarcodeTextPosition(2);        
                    $printer->setBarcodeHeight(120);
                    $printer->barcode($ticketId,$printer::BARCODE_CODE39);                
                    $printer->feed(1);
                    $printer->text("-------------------------------\n");
                    //$printer->text("TARIFA: 4000    TOTAL: 4000\n");
                    $printer->feed(2);
                    $printer->text("No pierda su ticket, debe presentar en \ncaja para abonar el importe correspondiente, \nen caso de extravio tiene un costo de \nGs. ".number_format($companyData->defaultPrice,0,",",".")." \n");
                    $printer->feed(2);
                    $printer->text("Gracias por su visita\n");
                    $printer->feed(2);
                    $printer->cut();
                    $printer->close();

            } catch (Exception $e) {
                print "Error! ".$e->getMessage();
                    error_log("Couldn't print to this printer: " . $e->getMessage() . "\n");
            }
        
            //exec("curl http://127.0.0.1/printer/printService.php?p=".rawurlencode(json_encode($buffer)));

            error_log("::::: ON BUTTON PRESS START");
            $relay = new Relay_USB(RELAY_PORT_OUTPUT, RELAY_NUMBER_INCOMING, "on");

            $result = $relay->exec_relay();

            sleep(BAR_TIME);
            $relay->setAction("off");

            $relay->setCommand($relay->getAction());

            try{
                $result = $relay->exec_relay();
                error_log("RESULTADO DE LA ACTIVACION DEL RELAY-- ".$result);
            } catch (Exception $e) {
                    error_log('Excepcion capturada: relayOnExit con conexion', $e->getMessage(), "\n");
            } 
            error_log("::: GO TO PRINT ENTRY TICKET");
            return rawurlencode(json_encode($buffer));
                
        } catch (Exception $e) {
            print "Error! "+$e->getMessage();
                error_log('Excepcion capturada: ', $e->getMessage(), "\n");
        }
    }
    private function getTicketId(){
        return "00".date("YmdHis");
    }

    private function getTicketDiff($ticketId){
        $data['in'] = getBarCodeDate($ticketId);
        $data['out'] = date("Y-m-d H:i:s");
        $dateDiff = $this->diffDate($data['in'], $data['out']);
	$inminutes = @$dateDiff["mins"]+@$dateDiff["hours"]*60;

	return $inminutes ? $inminutes : 0;
    }
}