<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Rfid_reader extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->show_read();
    }

    public function show_read()
    {
        $this->layout->setLayout('rfid_reader');
        $this->layout->setTitle('ParkingApp :: Lectura de tarjeta');

        $this->audits_model->insert(
            array(
                "username" => "admin@mail.com",
                "userIp" => "localhost",
                "activityName" => " Lectura de tarjeta",
                "lastQuery" => null,
                "currentPage" => " Lectura de tarjeta",
                "currentMethod" => "Visualizar pagina  Lectura de tarjeta"
            )
        );

        $this->layout->view("/show_rfid_reader");
    }
/*
    public function read($rfid = null)
    {
        $activityMessage = "";

        if ($rfid == null) {
            $rfid = $this->input->post("rfid", true);
        }
        if ($rfid == null) {
            $data =  array("status" => "ERROR", "message" => "No se obtuvo el id del ticket via post ");
            echo json_encode($data);
            exit();
        }

        $companyData = $this->config_model->find_first();

        if ($companyData == null) {
            $data =  array("status" => "ERROR", "message" => "No se encontro informacion sobre la empresa ");
            echo json_encode($data);
            exit();
        }


        $client = $this->clients_model->find_first(array("rfid" => $rfid));
        if ($client && $client->readerType == 'OUT') {
            $incoming = $this->goToIn($client);
            if ($incoming) {
                $data =  array("status" => "OK", "message" => "Acceso registrado con exito ");
            } else {
                $data =  array("status" => "ERROR", "message" => "Ocurrio un error al intentar acceder ");
            }
        } else if ($client && $client->readerType == 'IN') {

            $outcoming = $this->onReadOutcomingRfid($client->ticketId);

            if ($outcoming) {
                $data =  array("status" => "OK", "message" => "Salida registradaa con exito ");
                $update_data = array(
                    "ticketCode" => "",
                    "ticketId" => "",
                    "readerType" => 'OUT'
                );

                $insert_result = $this->clients_model->update($client->id,$update_data);
            } else {
                $data =  array("status" => "ERROR", "message" => "Ocurrio un error al intentar Salida ");
            }
        } else {
            $data =  array("status" => "ERROR", "message" => "La tarjeta no ese encuentra registrada ");
        }


        echo json_encode($data);
        exit();
    }
*/
    public function goToOut($rfid = null){
		$activityMessage = "";
        /* PROCESO DE SALIDA DEL ESTACIONAMIENTO */

        if ($rfid == null) {
            $rfid = $this->input->post("rfid", true);
        }
        if ($rfid == null) {
            $data =  array("status" => "ERROR", "message" => "No se obtuvo el id del ticket via post ");
            echo json_encode($data);
            exit();
        }

        $companyData = $this->config_model->find_first();

        if ($companyData == null) {
            $data =  array("status" => "ERROR", "message" => "No se encontro informacion sobre la empresa ");
            echo json_encode($data);
            exit();
        }

		$client = $this->clients_model->find_first(array("rfid" => $rfid));
        if ($client && $client->readerType == 'IN') {

            $outcoming = $this->onReadOutcomingRfid($client->ticketId);

            if ($outcoming) {
                $data =  array("status" => "OK", "message" => "Salida registradaa con exito ");
                $update_data = array(
                    "ticketCode" => "",
                    "ticketId" => "",
                    "readerType" => 'OUT'
                );

                $insert_result = $this->clients_model->update($client->id,$update_data);
            } else {
                $data =  array("status" => "ERROR", "message" => "Ocurrio un error al intentar Salida ");
            }
        } else {
            $data =  array("status" => "ERROR", "message" => "El cliente ya se encuentra fuera o La tarjeta no ese encuentra registrada ");
        }
		error_log("GO TO OUT: ===============================");
		error_log("GO TO OUT: ".$data['message']);
		error_log("GO TO OUT: ===============================");
        echo json_encode($data);
        exit();

    }

    public function goToIn($rfid = null)
    {

        $activityMessage = "";
        /* PROCESO DE ENTRADA AL ESTACIONAMIENTO */

        if ($rfid == null) {
            $rfid = $this->input->post("rfid", true);
        }
        if ($rfid == null) {
            $data =  array("status" => "ERROR", "message" => "No se obtuvo el id del ticket via post ");
            echo json_encode($data);
            exit();
        }

        $companyData = $this->config_model->find_first();

        if ($companyData == null) {
            $data =  array("status" => "ERROR", "message" => "No se encontro informacion sobre la empresa ");
            echo json_encode($data);
            exit();
        }

	$client = $this->clients_model->find_first(array("rfid" => $rfid));

	if ($client && $client->active == 1 && $client->readerType == 'OUT') {
	    /* aqui se valida el estado de la tarjeta del cliente */
	    /* validar si esta dentro de la fecha de validez */
	    /* si esta, entonces permitir la entrada */
	    /* si no, no abrir la barrera */
	    if(!valid_rfid($client)){
		$data =  array("status" => "ERROR", "message" => "Ocurrio un error al intentar acceder: Tarjeta no valida, verificar validez o estado ");
		/* se inhabilita la tarjeta a inactivo */
		$update_data = array(
                    "active" => '0',		    
                );

		$this->clients_model->update($client->id, $update_data);
		error_log("CLIENT INACTIVE: ".$data);
	
		echo json_encode($data);
		exit();
	    }

            $incoming = $this->onReadIncomingRfid($client);
            if ($incoming) {
                $data =  array("status" => "OK", "message" => "Acceso registrado con exito ");
            } else {
                $data =  array("status" => "ERROR", "message" => "Ocurrio un error al intentar acceder ");
            }
        }else{
	    if($client && $client->active == 0){
		    $data =  array("status" => "ERROR", "message" => "El cliente no se encuentra activo");	
	    }else{
		    $data =  array("status" => "ERROR", "message" => "El cliente ya se encuentra adentro o La tarjeta no ese encuentra registrada ");
	    }
	}
       


        error_log("GO TO IN: ===============================");
	error_log("GO TO IN: ".$data);
	error_log("GO TO IN: ===============================");
        echo json_encode($data);
        exit();
    }

    private function valid_rfid($client = null){
	if($client == null){
		return false;
	}

	error_log("Fecha de expiracion de la tarjeta: ".$client->expire);
	error_log("ID de cliente de la tarjeta: ".$client->id);

	/* comparar la fecha establecida de la tarjeta del cliente con la fecha actual para validar */
	/* la fecha se toma hasta la hora */
	$expire = date_format(date_create_from_format('Y-m-d H:i:s', $client->expire), "Y-m-d H:00:00");
	$todays = date("Y-m-d H:00:00");

	$expire_time = strtotime($expire);
	$today_time = strtotime($todays);

	/* 
	   si la fecha es de la tarjeta es menor a la fecha actual, entonces
	   la tarjeta no es valida
	   si no, es correcto, continua con la entrada 
	*/

	if ($expire_time >= $today_time) {
	     return true;
	} else {
	     return false;
	}
    }

    public function onReadIncomingRfid($client = null)
    {
        if ($client == null) {
            return null;
        }

        //activar el relay de entrada..
        error_log("::::: ON BUTTON PRESS START");
        $relay = new Relay_USB(RELAY_PORT_OUTPUT, RELAY_NUMBER_INCOMING, "on");

        $result = $relay->exec_relay();

        sleep(BAR_TIME);
        $relay->setAction("off");

        $relay->setCommand($relay->getAction());

        try {
            $result = $relay->exec_relay();
            error_log("RESULTADO DE LA ACTIVACION DEL RELAY-- " . $result);
        } catch (Exception $e) {
            error_log('Excepcion capturada: relayOnExit con conexion', $e->getMessage(), "\n");
        }
        error_log("::: GO TO PRINT ENTRY TICKET");

        //print  $this->printEntryTicket();
        return $this->registerEntryTicket($client);
    }

    public function onReadOutcomingRfid($ticketId = null)
    {
        if ($ticketId == null) {
            return null;
        }

        $activityMessage = "";

        if ($ticketId == null) {
            $ticketId = $this->input->post("ticketId", true);
        }
        if ($ticketId == null) {
            $data =  array("status" => "ERROR", "message" => "No se obtuvo el id del ticket via post ");
            echo json_encode($data);
            exit();
        }

        $companyData = $this->config_model->find_first();

        if ($companyData == null) {
            $data =  array("status" => "ERROR", "message" => "No se encontro informacion sobre la empresa ");
            echo json_encode($data);
            exit();
        }

        $client = $this->clients_model->find_first(array("ticketId" => $ticketId));
        if ($client == null) {
            return null;
        }

        // $verifyOnExit = isset($companyData->verifyOnExit) ? $companyData->verifyOnExit : VERIFY_ON_EXIT;
        //$ticketData = $this->reports_model->find_first(array("ticketId" => $ticketId));
        //if ($verifyOnExit == 1) {
        /* si fecha/hora de ticket es menor al tiempo libre permitido, dar salida automatica */
        if ($this->getTicketDiff($ticketId) < $companyData->toExitFree) {

            /* registrar la salida en la base de datos */
            $r['totalCalculate'] = 0;
            $r['discount'] = 0;
            $r['otherPayments'] = 0;
            $r['totalToPay'] = 0;
            $r['username'] = "admin@mail.com";
            $r['clientId'] =  $client->id;
            $r['paidOut'] = PAID_OUT_CODE;
            $r['ticketId'] = $ticketId;
            $r['rateId'] = "-2"; //salida automatica antes de tiempo 
			$r['ratePrice'] = $client->rate;
			$r['vehicleType'] = $client->vehicleType;
            $r['in'] = getBarCodeDate($ticketId);
            $r['out'] = date("Y-m-d H:i:s");
            $r['rateName'] = "Salida del estacionmaiento dentro del tiempo permitido";
            $r['ticketExitStatus'] = 1;
            $insert_r = $this->reports_model->insert($r);

            /* liberar la barrera */
            $this->relayOnExit();
            $data =  array("status" => "OK", "message" => "El ticket " . $ticketId . " ha salido correctamente");
            $activityMessage = "El ticket " . $ticketId . " ha salido correctamente";
            $this->audits_model->insert(
                array(
                    "username" => isset(current_user()->username) ? current_user()->username : "admin@mail.com",
                    "userIp" => "localhost",
                    "activityName" => $activityMessage,
                    "lastQuery" => $this->db->last_query(),
                    "currentPage" => "Lectura de ticket de salida",
                    "currentMethod" => "Read"
                )
            );
           return $data;
        
        } else {
            /* si supero el tiempo de salida sin costo, cobrar el correspondiente */
            $calculate_result = $this->calculate(array(
                'ticketId' => $ticketId,
                'vehicleType' => $client->vehicleType,
                'rateId' => $client->rate,
                'clientId' => $client->id,
                'discount' => 0,
                'otherPayments' => 0,
                'missedTicket' => 0,
                'comments' => ""
            ));



            if ($calculate_result) {

                $data =  array("status" => "OK", "message" => "El ticket " . $ticketId . " Fue procesado con exito");
                $activityMessage = "El ticket " . $ticketId . " fue procesado con exito";

                $this->audits_model->insert(
                    array(
                        "username" => isset(current_user()->username) ? current_user()->username : "admin@mail.com",
                        "userIp" => "localhost",
                        "activityName" => $activityMessage,
                        "lastQuery" => $this->db->last_query(),
                        "currentPage" => "Lectura de tarjeta en la salida",
                        "currentMethod" => "Read"
                    )
                );
            } else {

                $this->audits_model->insert(
                    array(
                        "username" => isset(current_user()->username) ? current_user()->username : "admin@mail.com",
                        "userIp" => "localhost",
                        "activityName" => $activityMessage,
                        "lastQuery" => $this->db->last_query(),
                        "currentPage" => "Lectura de tarjeta en la salida",
                        "currentMethod" => "Read"
                    )
                );
                $data =  array("status" => "ERROR", "message" => "El ticket " . $ticketId . " Genero un error al calcular");
                $activityMessage = "El ticket " . $ticketId . " genero un error al calcular";
                return $data;
            }
        }
        /*
            $dateDiff = diffDate($ticketData->in, $ticketData->out);

            $data = array(
                "companyName" => $companyData->company,
                "companyAddress" => $companyData->address,
                "c FompanyPhone" => $companyData->phone,
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
*/
        /* 
            el cliente puede salir sin pasar por caja directamente
            */

        //ACTUALIZAR estado del ticket a PAGADO:
        //$update = $this->reports_model->update($ticketData->id, array("ticketExitStatus" => TICKET_OUT));
        //El ticket fue pagado...activar la salida..		     	
        try {
            //Activa el relay de la barrera de salida
            $result = $this->relayOnExit();
            if ($result) {
                $status = "OK";
                $msg = "Activando la salida.. ticket pagado... ";
            } else {
                $status = "Error";
                $msg = "Ocurrio un error al ejecutar el relay ";
            }
        } catch (Exception $e) {
            error_log('Excepcion capturada: relayOnExit con conexion', $e->getMessage(), "\n");
            $status = "Error";
            $msg = "Ocurrio un error al ejecutar el relay ";
        }

        $data =  array("status" => $status, "message" => $msg);
        $activityMessage = $msg;
        
        /* PARA EL CLIENTE SIEMPRE SE VALIDA LA SALIDA
        } else {
            //Si no esta conectado con la barrera de salida, directamente marca el ticket como invalido y levanta la barrera
            $insert_result = $this->reports_model->update($ticketData->id, array("ticketExitStatus" => TICKET_OUT));

            try {
                //Activa el relay de la barrera de salida
                $result = $this->relayOnExit();
            } catch (Exception $e) {
                error_log('Excepcion capturada: relayOnExit sin conexion: ', $e->getMessage(), "\n");
            }

            $data =  array("status" => "OK", "message" => "Activando la salida.. ticket pagado... " . $insert_result);
            echo json_encode($data);
        }*/


        $this->audits_model->insert(
            array(
                "username" => isset(current_user()->username) ? current_user()->username : "admin@mail.com",
                "userIp" => "localhost",
                "activityName" => $activityMessage,
                "lastQuery" => $this->db->last_query(),
                "currentPage" => "Lectura de ticket de salida",
                "currentMethod" => "Read"
            )
        );

        return $data;

    }

    public function registerEntryTicket($client = null)
    {
        if ($client == null) {
            return null;
        }
        /* generar el id con formato fecha hora en formato actal */
        /* guardar el nuevo id en la base de datos con estado ingreso */
        /* agregar campos para pesonalizar los mensajes y datos de la empresa */
        /* debe tener un id unico impreso en el ticket: puede ser el id de registro de tickets */
        try {
            $companyData = $this->config_model->find_first();
            $ticketId = $this->getTicketId();
            $in =  getBarCodeDate($ticketId);

            if ($in == null) {

                return null;
            }



            /* Insert entry ticket data */
            $data['ticketId'] = $ticketId;
            $data['entry'] = $in;
            $insert_result = $this->entry_tickets_model->insert($data);

            $r['totalCalculate'] = 0;
            $r['discount'] = 0;
            $r['otherPayments'] = 0;
            $r['totalToPay'] = 0;
            $r['username'] = "admin@mail.com";
            $r['clientId'] =  $client->id;
            $r['paidOut'] = PAID_OUT_CODE;
            $r['ticketId'] = $ticketId;
            $r['ticketCode'] = $insert_result;
            $r['rateId'] = "";
            $r['in'] = getBarCodeDate($ticketId);
            $r['out'] = "";
            $r['rateName'] = "Cliente dentro del estacionamiento";
            $r['ticketExitStatus'] = 0;
            //$insert_r = $this->reports_model->insert($r);

            $insert_result = $this->entry_tickets_model->insert($data);
            $insert_data = array(
                "ticketCode" => $insert_result,
                "ticketId" => $ticketId,
                "readerType" => 'IN'
            );

            $insert_result = $this->clients_model->update($client->id, $insert_data);
            if ($insert_result) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            print "Error! " + $e->getMessage();
            error_log('Excepcion capturada: ', $e->getMessage(), "\n");
            return false;
        }
    }
    private function getTicketId()
    {
        return "00" . date("YmdHis");
    }

    private function getTicketDiff($ticketId)
    {
        $data['in'] = getBarCodeDate($ticketId);
        $data['out'] = date("Y-m-d H:i:s");
        $dateDiff = $this->diffDate($data['in'], $data['out']);
        $inminutes = @$dateDiff["mins"] + @$dateDiff["hours"] * 60;

        return $inminutes ? $inminutes : 0;
    }

    private function ifExpiredTimeToGo($data = array())
    {
        $result = false;

        $registered = $data['registered'];
        $now = date("Y-m-d H:i:s");

        $diffDate = diffDate($registered, $now);
        $totalTime = (int)($diffDate['days'] * 24 * 60) + (int)($diffDate['hours'] * 60) + (int)$diffDate['mins'];


        if ($totalTime >= $data["timeToGo"]) {
            $result = true;
        }


        return $result;
    }

    public function relayOnExit()
    {
        $relay = new Relay_USB(RELAY_PORT_OUTPUT, RELAY_NUMBER_OUTPUT, "on");

        $result = $relay->exec_relay();

        sleep(BAR_TIME);
        $relay->setAction("off");

        $relay->setCommand($relay->getAction());

        try {
            $result = $relay->exec_relay();
        } catch (Exception $e) {
            error_log('Excepcion capturada: relayOnExit con conexion', $e->getMessage(), "\n");
            $result = "Excepcion capturada: relayOnExit con conexion";
        }

        return $result;
    }


    private function diffDate($in = null, $out = null)
    {
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

    public function calculate($data = null)
    {
        if ($data == null) {
            return false;
        }

        $data['error'] = "";

        $config = $this->config_model->find_first();
        $data['ratePrice'] = $config->defaultPrice;
        $data['freeTime'] = $config->freeTime;
        $data['amount'] = $config->defaultPrice;
        $data['timeToGo'] = $config->timeToGo;

        if (isset($data['missedTicket']) && $data['missedTicket'] == 1) {
            $data['ticketId'] = "0";
            $data['rateId'] = "-1"; //extravio de ticket
            $data['in'] = date("Y-m-d H:i:s");
            $data['out'] = date("Y-m-d H:i:s");
            $data['rateName'] = "Extravio de Ticket";
            $data['rateType'] = "-1";
            $data['discount'] = 0;
            $data['otherPayments'] = 0;
            $discount = 0;
        } else {

            if (!isset($data['ticketId'])) {
                echo json_encode(array("error" => "No se encontro el codigo de barras"));
                exit();
            } else if (strlen($data['ticketId']) != 16) {
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
            /*$ticket = $this->reports_model->find_first(array("ticketId" => $data['ticketId']));

            if ($ticket != null) {
                echo json_encode(array("error" => "Este numero de ticket ya se ha registrado"));
                exit();
            }*/

            $entryTicket = $this->entry_tickets_model->find_first(array("ticketId" => $data['ticketId']));
            if ($entryTicket != null) {
                $data['ticketCode'] = $entryTicket->id;
            } else {
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

            $amount = $this->rates_model->find_by_id($data['rateId']);
            if ($amount == null) {
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
                if ($discountFreeTime > 0) {
                    $totalTime = $totalTime - $discountFreeTime / 60;
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
                if ($discountFreeTime > 0) {
                    $totalTime = $totalTime - $discountFreeTime / 60;
                }
                $data['amount'] = round($totalTime * $amount->price);
            } else if ($amount->rateType == 3) { /* por dia */
                $totalTime = 0;
                if ($data['days'] == 0) {
                    $data['amount'] = $amount->price;
                }
                if ($data['days'] > 0) {
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
        $data['totalToPay'] = ($data['amount'] + $data['otherPayments']) - $discount;
        $data['username'] = "admin@mail.com";
        $data['clientId'] =  isset($data['clientId']) ? $data['clientId'] : 0;
        $data['paidOut'] = PAID_OUT_CODE;
        $data['ticketExitStatus'] = TICKET_OUT;
        $insert_result = $this->reports_model->insert($data);

        $data['insertId'] = $insert_result;
        $this->audits_model->insert(
            array(
                "username" => isset(current_user()->username) ? current_user()->username : "admin@mail.com",
                "userIp" => 'localhost',
                "activityName" => "Se ha procesado la tarifa con id: " . $data['ticketId'],
                "lastQuery" => $this->db->last_query(),
                "currentPage" => "Menu Inicio",
                "currentMethod" => "Calcular Tarifa"
            )
        );
        return $data;
    }

    private function isFreeTime($data = array())
    {
        $result = false;

        if (isset($data['freeTime']) && !empty($data['freeTime']) && $data['freeTime'] > 0) {
            $totalTime = ($data['days'] * 24) + ($data['hours'] * 60) + $data['minutes'];
            if ($totalTime <= $data['freeTime']) {
                $result = true;
            }
        }

        return $result;
    }
}
