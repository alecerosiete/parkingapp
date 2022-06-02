<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Audits extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->show_list();
    }

    public function show_list() {
        assert_user();
        assert_role(ROLE_ADMIN);
        $this->layout->setDescription("Listado de Actividades de usuarios");
        $this->layout->setTitle(".:: Auditoria ::.");
        $this->layout->css(
                array(
                    base_url() . 'public/backend/dist/css/jquery.dataTables.min.css',
                    base_url() . "public/backend/dist/css/buttons.dataTables.min.css",
                    base_url() . "public/backend/dist/css/fixedColumns.dataTables.min.css",
                    base_url() . "public/backend/plugins/iCheck/all.css",
                    base_url() . "public/backend/plugins/select2/select2.min.css",
                    base_url() . "public/backend/dist/css/daterangepicker.css",
                    base_url() . "public/backend/dist/css/AdminLTE.min.css",
                    
                ));
        $this->layout->js(
            array(
                    base_url() . "public/backend/plugins/iCheck/icheck.min.js",
                    base_url().'public/backend/dist/js/jquery.dataTables.min.js',
                    base_url()."public/backend/dist/js/pages/dashboard2.js",
                    base_url()."public/backend/dist/js/pdfmake.min.js",
                    base_url()."public/backend/dist/js/vfs_fonts.js",
                    base_url()."public/backend/dist/js/dataTables.buttons.min.js",
                    base_url()."public/backend/dist/js/buttons.flash.min.js",
                    base_url()."public/backend/dist/js/jszip.min.js",
                    base_url()."public/backend/dist/js/buttons.html5.min.js",
                    base_url()."public/backend/dist/js/buttons.print.min.js",
                    base_url()."public/backend/dist/js/dataTables.fixedColumns.min.js",
                    base_url() . "public/backend/plugins/daterangepicker/moment.js",
                    base_url() . "public/backend/dist/js/daterangepicker.js",
                    base_url() . "public/backend/plugins/select2/select2.full.min.js"
            ));
        $data = array();
        if(check_role(ROLE_ADMIN)){
            $users = $this->profiles_model->find();
        }else{
            $users = $this->profiles_model->find(array("username" => current_user()->username));
            $data['username'] = current_user()->username;
        }
        
    
        $mapping = array("username","daterange");
        $data = input_read_post($this->input, $mapping);
   
        if(isset($data['username'])){
            $filter = array("username" => $data['username']);    
        }
        
        if(isset($data['daterange'])){
            $dates = explode(" - ",$data['daterange']);
            if(count($dates) == 2){
                $data['in'] = $dates[0];
                $data['out'] = $dates[1];
            }else{
                set_volatile_error("El rango de fechas que ingreso no es valido");
                $data['filter'] = (object)$filter;
                $this->layout->view('/audits/show_list', $data);
            }
        }
        
        if(isset($data['in'])){
            $filter['in'] = $data['in'];
        }
        
        if(isset($data['out'])){
            $filter['out'] = $data['out'];
        }
        
        
        
        $data['users'] = $users;
        
        /* Realizar la consulta con los filtros enviados */
        $data['audits'] = $this->audits_model->find_filter($filter);

        $this->audits_model->insert(
            array(
              "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
              "userIp" => current_user_ip(),
              "activityName" => "Visualizar pagina de auditoria" ,
              "lastQuery" => $this->db->last_query(),
              "currentPage" => "Menu Auditoria",
              "currentMethod" => "Listar Auditoria"
            )
        );  
        $this->layout->view('/audits/list', $data);
    }
    
    
    public function show(){
        assert_user();
        assert_role(ROLE_ADMIN);
        $this->layout->setDescription("Listado de Actividades de usuarios");
        $this->layout->setTitle(".:: Auditoria ::.");
        $this->layout->css(
                array(
                    base_url() . "public/backend/plugins/datatables/dataTables.bootstrap.css",
                    base_url() . "public/backend/dist/css/buttons.dataTables.min.css",
                    base_url() . "public/backend/dist/css/fixedColumns.dataTables.min.css",
                    base_url() . "public/backend/plugins/iCheck/all.css",
                    base_url() . "public/backend/plugins/select2/select2.min.css",
                    base_url() . "public/backend/dist/css/daterangepicker.css",
                    base_url() . "public/backend/dist/css/AdminLTE.min.css",
                    
                ));
        $this->layout->js(
            array(
                    base_url() . "public/backend/plugins/iCheck/icheck.min.js",
                    base_url().'public/backend/dist/js/jquery.dataTables.min.js',
                    base_url()."public/backend/dist/js/pages/dashboard2.js",
                    base_url()."public/backend/dist/js/pdfmake.min.js",
                    base_url()."public/backend/dist/js/vfs_fonts.js",
                    base_url()."public/backend/dist/js/dataTables.buttons.min.js",
                    base_url()."public/backend/dist/js/buttons.flash.min.js",
                    base_url()."public/backend/dist/js/jszip.min.js",
                    base_url()."public/backend/dist/js/buttons.html5.min.js",
                    base_url()."public/backend/dist/js/buttons.print.min.js",
                    base_url()."public/backend/dist/js/dataTables.fixedColumns.min.js",
                    base_url() . "public/backend/plugins/daterangepicker/moment.js",
                    base_url() . "public/backend/dist/js/daterangepicker.js",
                    base_url() . "public/backend/plugins/select2/select2.full.min.js"
            ));
        $data = array();
        if(check_role(ROLE_ADMIN)){
            $users = $this->profiles_model->find();
            $clients = $this->clients_model->find();
        }else{
            $users = $this->profiles_model->find(array("username" => current_user()->username));
            $data['username'] = current_user()->username;
            $clients = $this->clients_model->find(array("username"=> current_user()->username));
        }
        $data['users'] = $users;
        $data['audits'] = $this->audits_model->find();

        $this->audits_model->insert(
            array(
              "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
              "userIp" => current_user_ip(),
              "activityName" => "Visualizar pagina de auditoria" ,
              "lastQuery" => $this->db->last_query(),
              "currentPage" => "Menu Auditoria",
              "currentMethod" => "Listar Auditoria"
            )
        );  
        $this->layout->view('/audits/show_list', $data);
    }
}
