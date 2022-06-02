<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Rates extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->show_list();
    }

    public function show_list() {
        assert_user();
        $this->layout->setDescription("Listado de Tarifas");
        $this->layout->setTitle(".:: Tarifas de Estacionamiento ::.");
        $this->layout->css(
                array(
                    base_url() . "public/backend/plugins/datatables/dataTables.bootstrap.css",
                    base_url() . "public/backend/plugins/iCheck/all.css")
        );
        $this->layout->js(
                array(
                    base_url() . "public/backend/plugins/iCheck/icheck.min.js")
        );
        $data = array();

        $data['rates'] = $this->rates_model->find();
        $this->audits_model->insert(
            array(
              "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
              "userIp" => current_user_ip(),
              "activityName" => "Ver listado de tarifas ",
              "lastQuery" => $this->db->last_query(),
              "currentPage" => "Menu Tarifas",
              "currentMethod" => "Listado de Tarifas"
            )
        );
        $this->layout->view('/rates/list', $data);
    }

    public function show_rate($id = null) {
        assert_user();
        assert_existence($id, "/admin.php/rates/show_list", "No se obtuvo el id");

        $this->layout->setDescription("Menu Tarifas");
        $this->layout->setTitle(".:: Tarifas de Estacionamiento ::.");

        $this->layout->js(array(
            base_url() . "public/backend/dist/js/pages/dashboard2.js",
            base_url() . "public/backend/bootstrap/js/fileinput.min.js",
            base_url() . "public/backend/bootstrap/js/fileinput_locale_es.js",
             base_url() . "public/backend/plugins/iCheck/icheck.min.js"
        ));
        
        $this->layout->css(array(
            base_url() . "public/backend/dist/css/fileinput.min.css",
            base_url() . "public/backend/plugins/iCheck/all.css"
        ));

        $data = array();
        $vehicles = $this->vehicles_model->find();
        $data['vehicles'] = $vehicles;

        
        $profileData = $this->rates_model->find_by_id($id);
        
        assert_existence($profileData, "/admin.php/rates/show_list", "No se encontraron datos para mostrar");
        
        $this->audits_model->insert(
            array(
              "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
              "userIp" => current_user_ip(),
              "activityName" => "Ver detalle de tarifas ",
              "lastQuery" => $this->db->last_query(),
              "currentPage" => "Menu Tarifas",
              "currentMethod" => "Ver Tarifas"
            )
        );
        
        
        $data["rate"] = $profileData;
        $this->layout->view('/rates/show', $data);
    }

    public function new_rate() {
        assert_user();

        $this->layout->setDescription("Agregar Nueva Tarifa");
        $this->layout->setTitle(".:: Nueva Tarifa de Estacionamiento ::.");
        $this->layout->css(
                array(
                    base_url() . "public/backend/plugins/datatables/dataTables.bootstrap.css",
                    base_url() . "public/backend/plugins/iCheck/all.css"
        ));
        
        $this->layout->js(array(
            base_url() . "public/backend/dist/js/pages/dashboard2.js",
            base_url() . "public/backend/plugins/iCheck/icheck.min.js"
        ));

        $vehicles = $this->vehicles_model->find();
        $data['vehicles'] = $vehicles;

        $this->layout->view('/rates/new', $data);
    }

    public function edit($id = null) {
        assert_user();
        assert_existence($id, "/admin.php/rates/show_rate", "No se obtuvo el id");

        $mapping = array('vehicleType', 'rateType', 'name', 'price', 'description');

        $data = input_read_post($this->input, $mapping);

        if ($this->form_validation->run("rate") == FALSE) {
            $this->show_rate($id);
            return;
        }
     
        $update_result = $this->rates_model->update($id, $data);

        if ($update_result) {
           $this->audits_model->insert(
                array(
                  "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
                  "userIp" => current_user_ip(),
                  "activityName" => "Tarifa Editado exitosamente ",
                  "lastQuery" => $this->db->last_query(),
                  "currentPage" => "Menu Tarifas",
                  "currentMethod" => "Editar Tarifas"
                )
            );
            set_volatile_success("Tarifa Editado exitosamente!");
            redirect("/admin.php/rates/show_list" , 301);
        } else {
           $this->audits_model->insert(
                array(
                  "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
                  "userIp" => current_user_ip(),
                  "activityName" => "Ocurrio un error al tratar de editar",
                  "lastQuery" => $this->db->last_query(),
                  "currentPage" => "Menu Tarifas",
                  "currentMethod" => "Editar Tarifas"
                )
            );            
            set_volatile_error("Ocurrio un error al tratar de editar, intentelo nuevamente");
            redirect("/admin.php/rates/edit/" . $id, 301);
        }
    }

    public function create() {
        assert_user();

        $mapping = array('vehicleType', 'rateType', 'name', 'price', 'description');
        $data = input_read_post($this->input, $mapping);

        if ($this->form_validation->run("rate") == FALSE) {
            $this->new_rate();
            return;
        }

        $insert_result = $this->rates_model->insert($data);
        if ($insert_result) {
           $this->audits_model->insert(
                array(
                  "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
                  "userIp" => current_user_ip(),
                  "activityName" => "Tarifa creada con exito",
                  "lastQuery" => $this->db->last_query(),
                  "currentPage" => "Menu Tarifas",
                  "currentMethod" => "Crear nueva Tarifa"
                )
            );              
            set_volatile_success("Tarifa creada con exito");
            redirect(base_url() . "admin.php/rates/show_list");
        } else {
           $this->audits_model->insert(
                array(
                  "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
                  "userIp" => current_user_ip(),
                  "activityName" => "Error al crear tarifa",
                  "lastQuery" => $this->db->last_query(),
                  "currentPage" => "Menu Tarifas",
                  "currentMethod" => "Crear nueva Tarifa"
                )
            );                
            set_volatile_error("Ocurrio un error, intente de nuevo o contacte con el administrador");
            $this->new_rate();
        }
    }

    public function show_update($id = null) {
        assert_user();

        $this->show_rate($id);
    }

    public function delete($id = null) {
        assert_user();
        assert_existence($id, "/admin.php/rates/show_list", "No se obtuvo el id");

        $delete_data = $this->rates_model->find_by_id($id);
        assert_existence($delete_data, "/admin.php/rates/show_list", "Ningun dato para eliminar");
        $delete_result = $this->rates_model->delete($id);
        if ($delete_result) {
           $this->audits_model->insert(
                array(
                  "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
                  "userIp" => current_user_ip(),
                  "activityName" => "Tarifa eliminado con exito",
                  "lastQuery" => $this->db->last_query(),
                  "currentPage" => "Menu Tarifas",
                  "currentMethod" => "Eliminar Tarifa"
                )
            );  
            set_volatile_success("Tarifa eliminado con exito");
        } else {
            $this->audits_model->insert(
                array(
                  "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
                  "userIp" => current_user_ip(),
                  "activityName" => "Ocurrio un error al tratar de eliminar ",
                  "lastQuery" => $this->db->last_query(),
                  "currentPage" => "Menu Tarifas",
                  "currentMethod" => "Eliminar Tarifa"
                )
            ); 
            set_volatile_data("Ocurrio un error al tratar de eliminar " . $id);
        }
        redirect(base_url() . "admin.php/rates/show_list");
    }

}
