<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Panel extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        assert_user();
        $this->layout->setDescription("Panel de Informacion");
        $this->layout->setTitle(".:: Movimiento del estacionamiento ::.");
        $this->layout->css(
                array(
                    base_url() . "public/backend/plugins/datatables/dataTables.bootstrap.css",
                    base_url() . "public/backend/plugins/iCheck/all.css",
                    base_url() . "public/backend/dist/css/daterangepicker.css",)
        );
        $this->layout->js(
                array(
                    base_url() . "public/backend/plugins/iCheck/icheck.min.js",
                    base_url() . "public/backend/plugins/daterangepicker/moment.js",
                    base_url() . "public/backend/dist/js/daterangepicker.js"
                )
        );
        $data = array();
        $daterange = $this->input->post('daterange', true);
        if(isset($daterange)){
            $dr = explode(" - ", $daterange);
            if(count($dr) == 2){
                $start = DateTime::createFromFormat('d/m/Y', $dr[0])->format('Y-m-d');
                $end = DateTime::createFromFormat('d/m/Y', $dr[1])->format('Y-m-d');
                $filter = array("entry >= " => $start, "entry <= " => $end);
            }
            $data['filter'] =  $daterange;
        }else{
            $filter = null;
        }
        $summary = $this->entry_tickets_model->find_summary($filter);        
        $entrada = 0;
        $salida = 0;
        $dentro = 0;
        foreach($summary as $v){
            $entrada =  $entrada + $v->TOTEMTYPE_I;
            $salida =  $entrada + $v->TOTEMTYPE_O;
            
        }
        $dentro =  $entrada > $salida ? $entrada - $salida : 0;
        $data['hoy'] = array("entrada" => $entrada, "salida" => $salida, "dentro" => $dentro);
        $data['summary'] =  $summary;
        $this->layout->view('/panel/summary', $data);
    }

    



}