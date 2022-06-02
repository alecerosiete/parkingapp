<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        assert_user();

		$this->layout->setTitle('ParkingApp :: Inicio');

        $this->layout->js(array(            
            base_url() . "public/backend/dist/js/pages/dashboard2.js",
            base_url() . "public/backend/dist/js/jsonfinder.js",
            base_url() . "public/backend/plugins/iCheck/icheck.min.js",
            base_url() . "public/backend/plugins/daterangepicker/moment.js",
            base_url() . "public/backend/plugins/datetimepicker/bootstrap-datetimepicker.js",
        ));

        $this->layout->css(array(
            base_url() . "public/backend/plugins/datatables/dataTables.bootstrap.css",
            base_url() . "public/backend/plugins/iCheck/all.css",
            base_url() . "public/backend/plugins/datetimepicker/bootstrap-datetimepicker.css"
        ));

        $data = array();
        
        $vehicles = $this->vehicles_model->find();
        $data['vehicles'] = $vehicles;
        
        $rates = $this->rates_model->find();
        $data["rates"] = $rates;
    
        if(check_role(ROLE_ADMIN)){
            $clients = $this->clients_model->find();
        }else{
            $clients = $this->clients_model->find(array("username"=> current_user()->username));
        }
        
        $data["clients"] = $clients;
        
        $this->audits_model->insert(
            array(
              "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
              "userIp" => current_user_ip(),
              "activityName" => "Visualizacion de Pagina para Calcular tarifa",
              "lastQuery" => $this->db->last_query(),
              "currentPage" => "Menu Inicio",
              "currentMethod" => "Mostrar pantalla para calcular tarifa"
            )
        );
        
        $this->layout->view('/home',$data);
    }
    
    public function printTicket($ticketId = null){
	    /* IMPRESION DE TICKET AL REALIZAR EL PAGO EN CAJA (ciando el cajero selecciona confirmar en la vista) */
		/* se debe imprimir el mismo codigo de barras del ticket de entrada para que el cliente pueda levantar 
		la barrera de salida con el nuevo ticket*/
		/* los datos a mostrar seria con resumen de tarifa y tiempo consumido */

        assert_user();
        
        assert_existence($ticketId, "/admin.php/main", "No se obtuvo el id");

        $ticketData = $this->reports_model->find_by_id($ticketId);
        assert_existence($ticketData, "/admin.php/main", "No se obtuvo el id");
        
        $companyData = $this->config_model->find_first();
        
        $dateDiff = $this->diffDate($ticketData->in, $ticketData->out);
            
        $data = array(
			"ticketId" => $ticketData->ticketId,
			"id" => $ticketData->id,
            "companyName" => $companyData->company,
            "companyAddress" =>$companyData->address,
            "companyPhone" =>$companyData->phone,
            "companyRuc" =>$companyData->ruc,
            "in" => $ticketData->in,
            "out" => $ticketData->out,
			"months" => $dateDiff['months'],
            "days" => $dateDiff['days'],
            "hours" => $dateDiff['hours'],
            "minutes" => $dateDiff['mins'],
            "subtotal" => $ticketData->totalCalculate,
            "discount" => $ticketData->discount,
            "total" =>$ticketData->totalToPay,
            "rate" => $ticketData->ratePrice,
            "rateType" => $ticketData->rateType
            );
        $this->audits_model->insert(
            array(
              "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
              "userIp" => current_user_ip(),
              "activityName" => "Imprime ticket",
              "lastQuery" => $this->db->last_query(),
              "currentPage" => "Menu Inicio",
              "currentMethod" => "Mostrar pantalla para calcular tarifa"
            )
        );
		
		$this->printExitTicket($data);

        //$this->load->view('/reports/printTicket',$data);
         //$this->view('/reports/printTicket');
    }
    
    private function diffDate($in = null, $out = null) {
        if ($in == null || $out == null) {
            return null;
        }

        $dteStart = new DateTime($in);
        $dteEnd = new DateTime($out);

        $dteDiff = $dteStart->diff($dteEnd);
        $day = $dteDiff->format("%D");
        if ($day > 0) {
            $diff = array(
                "days" => $day,
                "hours" => $dteDiff->format("%H"),
                "mins" => $dteDiff->format("%I"),
				"months"  => $dteDiff->format("%m"),
            );
        } else {
            $diff = array(
                "days" => 0,
                "hours" => $dteDiff->format("%H"),
                "mins" => $dteDiff->format("%I"),
				"months"  => 0,
            );
        }

        return $diff;
    }
	
	private function printExitTicket($ticket) {
		
		
			
        try {
            error_log("Intentando importar libreria ESCPOS");
            $companyData = $this->config_model->find_first();
            try {
                //$connector = new Mike42\Escpos\PrintConnectors\WindowsPrintConnector("5850II");
                $connector = new Mike42\Escpos\PrintConnectors\WindowsPrintConnector("MINIPRINTER");
                $printer = new Mike42\Escpos\Printer($connector);
                $printer->setJustification(1);                
                $printer->setEmphasis(true);
                $printer->text("*******************************\n");
                $printer->text("{$companyData->company}\n");                
                $printer->text("*******************************\n");
                $printer->setEmphasis(false);
                $printer->text("RUC: {$companyData->ruc}\n");
                $printer->text("Direccion: ".$companyData->address."\n");
                $printer->text("Tel.: ".$companyData->phone."\n");
                $printer->text("CODIGO #".$ticket['id']."\n");
                $printer->feed(1);
                $printer->text("-------------------------------\n");
                $printer->text("FECHA/HORA ENTRADA\n");
				
                $printer->text("ENTRADA: ".date("d/m/Y H:i:s",strtotime($ticket['in']))."\n");
                $printer->text("SALIDA: ".date("d/m/Y H:i:s",strtotime($ticket['out']))."\n");
				$printer->text("MESES: ".$ticket['months']."\n");
                $printer->text("DIAS: ".$ticket['days']."\n");
                $printer->text("HORAS: ".$ticket['hours']."\n");
                $printer->text("MINUTOS: ".$ticket['minutes']."\n");
                
                $printer->setBarcodeTextPosition(2);        
                
                $printer->barcode($ticket['ticketId'],$printer::BARCODE_ITF);                
                $printer->feed(1);
                $printer->text("-------------------------------\n");
                $printer->text("TARIFA: ".number_format($ticket['rate'],0,",",".")."    TOTAL: ".number_format($ticket['total'],0,",",".")."\n");
                $printer->feed(2);
                //$printer->text("No pierda su ticket, debe presentar en \ncaja para abonar el importe correspondiente, \nen caso de extravio tiene un costo de Gs. {$companyData->defaultPrice} \n");
                //$printer->feed(2);
                $printer->text("Gracias por su visita\n");
                $printer->feed(2);
                $printer->cut();

                $printer->close();

            } catch (Exception $e) {
                error_log("Couldn't print to this printer: " . $e->getMessage() . "\n");
            }
        } catch (Exception $e) {
            error_log('Excepción capturada: ', $e->getMessage(), "\n");
        }
    }

}
