<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
       $this->show();
    }

    public function show($id = null) {
         assert_user();

        $this->layout->setDescription("Pagina de Reportes");
        $this->layout->setTitle(".:: Reportes ::.");

        $this->layout->css(
            array(
                base_url() . 'public/backend/dist/css/jquery.dataTables.min.css',
                base_url() . "public/backend/dist/css/buttons.dataTables.min.css",
                base_url() . "public/backend/dist/css/fixedColumns.dataTables.min.css",
                base_url() . "public/backend/plugins/iCheck/all.css"
            ));
        
        $this->layout->js(
            array(
                base_url() . 'public/backend/dist/css/jquery.dataTables.min.css',
                base_url()."public/backend/dist/js/pages/dashboard2.js",
                base_url()."public/backend/dist/js/pdfmake.min.js",
                base_url()."public/backend/dist/js/vfs_fonts.js",
                base_url()."public/backend/dist/js/dataTables.buttons.min.js",
                base_url()."public/backend/dist/js/buttons.flash.min.js",
                base_url()."public/backend/dist/js/jszip.min.js",
                base_url()."public/backend/dist/js/buttons.html5.min.js",
                base_url()."public/backend/dist/js/buttons.print.min.js",
                base_url()."public/backend/dist/js/dataTables.fixedColumns.min.js",
            ));

        //get any data to send message
        $data[] = array();
        if (check_role(ROLE_ADMIN)) {    
            $reports = $this->reports_model->find();
        }else{
            $reports = $this->reports_model->find(array("username"=>current_user()->username));
        }
        $this->audits_model->insert(
            array(
              "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
              "userIp" => current_user_ip(),
              "activityName" => "Visualizar pagina de reportes" ,
              "lastQuery" => $this->db->last_query(),
              "currentPage" => "Reportes",
              "currentMethod" => "Listar registros de entrada y salida"
            )
        );  
        $data['reports'] = $reports;
        $this->layout->view('/reports/list', $data);
    }
    
    
    public function byUsers($id = null) {
        assert_user();
        
        //assert_role(ROLE_ADMIN);
        
        $this->layout->setDescription("Pagina de Reportes");
        $this->layout->setTitle(".:: Reporte por Clientes ::.");

        

        $this->layout->css(
            array(
                
                base_url() . 'public/backend/dist/css/jquery.dataTables.min.css',
                base_url() . "public/backend/dist/css/buttons.dataTables.min.css",
                base_url() . "public/backend/plugins/iCheck/all.css",
                base_url() . "public/backend/plugins/select2/select2.min.css",
                base_url() . "public/backend/dist/css/fixedColumns.dataTables.min.css",
                base_url() . "public/backend/dist/css/daterangepicker.css",
                base_url() . "public/backend/dist/css/AdminLTE.min.css",
            ));
        
        $this->layout->js(
            array(
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
               // InputMask -->
                base_url() . "public/backend/plugins/input-mask/jquery.inputmask.js",
                base_url() . "public/backend/plugins/input-mask/jquery.inputmask.date.extensions.js",
                base_url() . "public/backend/plugins/input-mask/jquery.inputmask.extensions.js",
                base_url() . "public/backend/plugins/daterangepicker/moment.js",
                base_url() . "public/backend/dist/js/daterangepicker.js",
                base_url() . "public/backend/plugins/select2/select2.full.min.js"
        ));

        $data[] = array();
    
        $mapping = array("clientId","daterange","rateType");
        $data = input_read_post($this->input, $mapping);
   
        if(!isset($data['rateType'])){
            $filter['rateType'] = "";
        }
        
        $filter = $data;
        
        if(isset($data['daterange'])){
            $dates = explode(" - ",$data['daterange']);
            if(count($dates) == 2){
                $data['in'] = $dates[0];
                $data['out'] = $dates[1];
            }else{
                set_volatile_error("El rango de fechas que ingreso no es valido");
                $data['filter'] = (object)$filter;
                $this->layout->view('/reports/byUsers', $data);
            }
        }
        
        
        if(check_role(ROLE_ADMIN)){
            $users = $this->profiles_model->find();
            $clients = $this->clients_model->find();
        }else{
            $users = $this->profiles_model->find(array("username" => current_user()->username));
            $data['username'] = current_user()->username;
            $clients = $this->clients_model->find(array("username"=> current_user()->username));
        }

        //$users = $this->profiles_model->find();
        $clientOnly = false;
        $reports = $this->reports_model->find_filter($data,$clientOnly);


        $this->audits_model->insert(
            array(
              "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
              "userIp" => current_user_ip(),
              "activityName" => "Visualizar detalles de reportes por usuario" ,
              "lastQuery" => $this->db->last_query(),
              "currentPage" => "Reportes Por Usuario",
              "currentMethod" => "Ver detalles de registro de entrada y salida por usuario"
            )
        );  
        $data['users'] = $users;
        $data['reports'] = $reports;

        $data['filter'] = (object)$filter;
        $this->layout->view('/reports/byUsers', $data);
    }
    
    public function byClients($id = null) {
        assert_user();
        
       // assert_role(ROLE_ADMIN);
        
        $this->layout->setDescription("Pagina de Reportes");
        $this->layout->setTitle(".:: Reporte por usuarios ::.");

        $this->layout->css(
            array(
                base_url() . 'public/backend/dist/css/jquery.dataTables.min.css',
                base_url() . "public/backend/dist/css/buttons.dataTables.min.css",
                base_url() . "public/backend/plugins/iCheck/all.css",
                base_url() . "public/backend/plugins/select2/select2.min.css",
                base_url() . "public/backend/dist/css/fixedColumns.dataTables.min.css",
                base_url() . "public/backend/dist/css/daterangepicker.css",
                base_url() . "public/backend/dist/css/AdminLTE.min.css",
        
            ));
        
        $this->layout->js(
            array(
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
               // InputMask -->
                base_url() . "public/backend/plugins/input-mask/jquery.inputmask.js",
                base_url() . "public/backend/plugins/input-mask/jquery.inputmask.date.extensions.js",
                base_url() . "public/backend/plugins/input-mask/jquery.inputmask.extensions.js",
                base_url() . "public/backend/plugins/daterangepicker/moment.js",
                base_url() . "public/backend/dist/js/daterangepicker.js",
                base_url() . "public/backend/plugins/select2/select2.full.min.js"
                
        ));

        $data[] = array();
    
        $mapping = array("username","daterange","rateType");
        $data = input_read_post($this->input, $mapping);
   
        if(!isset($data['rateType'])){
            $filter['rateType'] = "";
        }
        
        $filter = $data;
        
        if(isset($data['daterange'])){
            $dates = explode(" - ",$data['daterange']);
            if(count($dates) == 2){
                $data['in'] = $dates[0];
                $data['out'] = $dates[1];
            }else{
                set_volatile_error("El rango de fechas que ingreso no es valido");
                $data['filter'] = (object)$filter;
                $this->layout->view('/reports/byUsers', $data);
            }
        }
        
        if(check_role(ROLE_ADMIN)){
            $users = $this->profiles_model->find();
            $clients = $this->clients_model->find();
        }else{
            $users = $this->profiles_model->find(array("username" => current_user()->username));
            $data['username'] = current_user()->username;
            $clients = $this->clients_model->find(array("username"=> current_user()->username));
        }
        $clientOnly = true;
        $reports = $this->reports_model->find_filter($data,$clientOnly);
        


        $this->audits_model->insert(
            array(
              "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
              "userIp" => current_user_ip(),
              "activityName" => "Visualizar detalles de reportes por usuario" ,
              "lastQuery" => $this->db->last_query(),
              "currentPage" => "Reportes Por Usuario",
              "currentMethod" => "Ver detalles de registro de entrada y salida por usuario"
            )
        );  
        $data['users'] = $users;
        $data['reports'] = $reports;
        $data['clients'] = $clients;

        $data['filter'] = (object)$filter;
        $this->layout->view('/reports/byClients', $data);
    }

    public function delete($id = null) {
        assert_user();
        assert_existence($id, "/admin.php/reports", "No se obtuvo el id");

        $delete_data = $this->reports_model->find_by_id($id);
        assert_existence($delete_data, "/admin.php/reports", "Ningun dato para eliminar");
        $delete_result = $this->reports_model->delete($id);
        if ($delete_result) {

           $this->audits_model->insert(
                array(
                  "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
                  "userIp" => current_user_ip(),
                  "activityName" => "Reporte eliminado con exito" ,
                  "lastQuery" => $this->db->last_query(),
                  "currentPage" => "Menu Reportes",
                  "currentMethod" => "Eliminar Registro"
                )
            );              
            set_volatile_success("Registro eliminado con exito");
        } else {
            $this->audits_model->insert(
                array(
                  "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
                  "userIp" => current_user_ip(),
                  "activityName" => "Ocurrio un error al tratar de eliminar, id:". $id ,
                  "lastQuery" => $this->db->last_query(),
                  "currentPage" => "Menu Reporte",
                  "currentMethod" => "Eliminar Registro"
                )
            ); 
            set_volatile_data("Ocurrio un error al tratar de eliminar " . $id);
        }
        redirect(base_url() . "admin.php/reports");
    }
}
