<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Configurations extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->show();
    }

    public function show() {
        assert_user();
        assert_role(ROLE_ADMIN);
        $this->layout->setDescription("Configuraciones de la Aplicacion");
        $this->layout->setTitle(".:: Configuraciones de la Aplicacion ::.");
        $this->layout->css(
                array(
                    base_url() . "public/backend/plugins/datatables/dataTables.bootstrap.css",
                    base_url() . "public/backend/plugins/iCheck/all.css")
        );
        $this->layout->js(
                array(
                    base_url() . "public/backend/plugins/iCheck/icheck.min.js")
        );
        
        $user = current_user();
        
        $data = array();
        $data['configurations'] = $this->config_model->find_first();
         $this->audits_model->insert(
            array(
              "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
              "userIp" => current_user_ip(),
              "activityName" => "Visualzando pagina de configuracion de la aplicacion",
              "lastQuery" => $this->db->last_query(),
              "currentPage" => "Menu Sistema",
              "currentMethod" => "Ver configuraciones del sistema"
            )
        );
        $this->layout->view('/configurations/show', $data);
    }


    public function edit() {
        assert_user();
        assert_role(ROLE_ADMIN);
        $mapping = array('defaultPrice','company','address','ruc','phone','timeToGo','verifyOnExit','freeTime','toExitFree');

        $data = input_read_post($this->input, $mapping);
        assert_existence($data, "/admin.php/configurations/show", "No se obtuvo el id");
        
        if ($this->form_validation->run("config") == FALSE) {
            $this->show();
            return;
        }
        
        if(!isset($data['defaultPrice'])){
            $data['defaultPrice'] = 0;
        }
        if(!isset($data['company'])){
            $data['company'] = "";
        }
        if(!isset($data['address'])){
            $data['address'] = "";
        }
        if(!isset($data['phone'])){
            $data['phone'] = "";
        }
        if(!isset($data['ruc'])){
            $data['ruc'] = "";
        }
        if(!isset($data['timeToGo'])){
            $data['timeToGo'] = 0;
        }
        if(!isset($data['verifyOnExit'])){
            $data['verifyOnExit'] = 0;
        }
        if(!isset($data['freeTime'])){
            $data['freeTime'] = 0;
        }
        if(!isset($data['toExitFree'])){
            $data['toExitFree'] = 0;
        }
        
        $update_result = $this->config_model->update(1,$data);
        
        if ($update_result) {
            $this->audits_model->insert(
                array(
                  "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
                  "userIp" => current_user_ip(),
                  "activityName" => "Configuracion Editado exitosamente",
                  "lastQuery" => $this->db->last_query(),
                  "currentPage" => "Menu Sistema",
                  "currentMethod" => "Editar configuraciones del sistema"
                )
            );
            set_volatile_success("Configuracion Editado exitosamente!");
            redirect("/admin.php/configurations/show/" , 301);
        } else {
             $this->audits_model->insert(
                array(
                  "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
                  "userIp" => current_user_ip(),
                  "activityName" => "Ocurrio un error al tratar de editar",
                  "lastQuery" => $this->db->last_query(),
                  "currentPage" => "Menu Sistema",
                  "currentMethod" => "Editar configuraciones del sistema"
                )
            );
            set_volatile_error("Ocurrio un error al tratar de editar, intentelo nuevamente");
            redirect("/admin.php/configurations/show/" , 301);
        }
    }

    public function delete($id = null) {
        assert_user();
        assert_role(ROLE_ADMIN);
        assert_existence($id, "/admin.php/configurations/show", "No se obtuvo el id");

        $delete_data = $this->config_model->find_by_id($id);
        assert_existence($delete_data, "/admin.php/configurations/show", "Ningun dato para eliminar");
        $delete_result = $this->config_model->delete($id);
        if ($delete_result) {
            $this->audits_model->insert(
                array(
                  "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
                  "userIp" => current_user_ip(),
                  "activityName" => "Configuracion eliminado con exito",
                  "lastQuery" => $this->db->last_query(),
                  "currentPage" => "Menu Sistema",
                  "currentMethod" => "Eliminar configuraciones del sistema"
                )
            );
            set_volatile_success("Configuracion eliminado con exito");
        } else {
             $this->audits_model->insert(
                array(
                  "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
                  "userIp" => current_user_ip(),
                  "activityName" => "Ocurrio un error al tratar de eliminar",
                  "lastQuery" => $this->db->last_query(),
                  "currentPage" => "Menu Sistema",
                  "currentMethod" => "Eliminar configuraciones del sistema"
                )
            );
            set_volatile_data("Ocurrio un error al tratar de eliminar " . $id);
        }
        redirect(base_url() . "admin.php/configurations/show");
    }

}
