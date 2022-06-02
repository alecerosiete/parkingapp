<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Vehicles extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->show_list();
    }

    public function show_list() {
        assert_user();
        $this->layout->setDescription("Listado de Vehiculos");
        $this->layout->setTitle(".:: Administracion de Vehiculos ::.");
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

        $data['vehicles'] = $this->vehicles_model->find();

        $this->audits_model->insert(
            array(
              "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
              "userIp" => current_user_ip(),
              "activityName" => "Visualizar pagina para administrar vehiculos" ,
              "lastQuery" => $this->db->last_query(),
              "currentPage" => "Menu Vehiculos",
              "currentMethod" => "Listar vehiculos"
            )
        );  
        $this->layout->view('/vehicles/list', $data);
    }

    public function show_vehicle($id = null) {
        assert_user();
        assert_existence($id, "/admin.php/vehicles/show_list", "No se obtuvo el id");

        $this->layout->setDescription("Menu vehiculos ");
        $this->layout->setTitle(".:: Vehiculos del Estacionamiento ::.");

        $this->layout->js(array(
            base_url() . "public/backend/dist/js/pages/dashboard2.js",
            base_url() . "public/backend/bootstrap/js/fileinput.min.js",
            base_url() . "public/backend/bootstrap/js/fileinput_locale_es.js",
        ));
        $this->layout->css(array(
            base_url() . "public/backend/dist/css/fileinput.min.css",
        ));

        $data = array();
        $vehicles = $this->vehicles_model->find_by_id($id);
        assert_existence($vehicles, "/admin.php/vehicles/show_list", "No se encontraron datos para mostrar");
        $data["vehicle"] = $vehicles;
        $this->audits_model->insert(
            array(
              "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
              "userIp" => current_user_ip(),
              "activityName" => "Visualizar detalles de vehiculos" ,
              "lastQuery" => $this->db->last_query(),
              "currentPage" => "Menu Vehiculos",
              "currentMethod" => "Ver vehiculos"
            )
        );
        
        $this->layout->view('/vehicles/show', $data);
    }

    public function new_vehicle() {
        assert_user();

        $this->layout->setDescription("Agregar Nuevo Vehiculo");
        $this->layout->setTitle(".:: Nuevo Vehiculo de Estacionamiento ::.");

        $this->layout->js(array(
            base_url() . "/public/backend/dist/js/pages/dashboard2.js"
        ));

        $data = array();
       
        $this->layout->view('/vehicles/new',$data);
    }

    public function edit($id = null) {
        assert_user();
        assert_existence($id, "/admin.php/vehicles/show_list", "No se obtuvo el id");

        $mapping = array('name');

        $data = input_read_post($this->input, $mapping);

        if ($this->form_validation->run("vehicles") == FALSE) {
            $this->show_vehicle($id);
            return;
        }

        $update_result = $this->vehicles_model->update($id,$data);

        if ($update_result) {
        $this->audits_model->insert(
            array(
              "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
              "userIp" => current_user_ip(),
              "activityName" => "Vehiculo Editado exitosamente" ,
              "lastQuery" => $this->db->last_query(),
              "currentPage" => "Menu Vehiculos",
              "currentMethod" => "Editar vehiculos"
            )
        );
            set_volatile_success("Vehiculo Editado exitosamente!");
            redirect("/admin.php/vehicles/edit/" . $id, 301);
        } else {
        $this->audits_model->insert(
            array(
              "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
              "userIp" => current_user_ip(),
              "activityName" => "Ocurrio un error al tratar de editar" ,
              "lastQuery" => $this->db->last_query(),
              "currentPage" => "Menu Vehiculos",
              "currentMethod" => "Editar vehiculos"
            )
        );
            set_volatile_error("Ocurrio un error al tratar de editar, intentelo nuevamente");
            redirect("/admin.php/vehicles/edit/" . $id, 301);
        }
    }

    public function create() {
        assert_user();

        $mapping = array('name');
        $data = input_read_post($this->input, $mapping);

        if ($this->form_validation->run("vehicles") == FALSE) {
            $this->new_vehicle();
            return;
        }

        $insert_result = $this->vehicles_model->insert($data);
        if ($insert_result) {
           $this->audits_model->insert(
            array(
              "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
              "userIp" => current_user_ip(),
              "activityName" => "Vehiculo creado con exito" ,
              "lastQuery" => $this->db->last_query(),
              "currentPage" => "Menu Vehiculos",
              "currentMethod" => "Nuevo vehiculo"
            )
        );
            set_volatile_success("Vehiculo creado con exito");
            redirect(base_url() . "admin.php/vehicles/show_list");
        } else {
            if ($insert_result) {
               $this->audits_model->insert(
                    array(
                      "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
                      "userIp" => current_user_ip(),
                      "activityName" => "Ocurrio un error al crear un nuevo tipo de vehiculo" ,
                      "lastQuery" => $this->db->last_query(),
                      "currentPage" => "Menu Vehiculos",
                      "currentMethod" => "Nuevo vehiculo"
                    )
                );            
                set_volatile_error("Ocurrio un error, intente de nuevo o contacte con el administrador");
                $this->new_vehicle();
            }
         }

    }
    public function show_update($id = null) {
        assert_user();

        $this->show_vehicle($id);
    }

    public function delete($id = null) {
        assert_user();
        assert_existence($id, "/admin.php/vehicles/show_list", "No se obtuvo el id");

        $delete_data = $this->vehicles_model->find_by_id($id);
        assert_existence($delete_data, "/admin.php/vehicles/show_list", "Ningun dato para eliminar");
        $delete_result = $this->vehicles_model->delete($id);
        if ($delete_result) {

           $this->audits_model->insert(
                array(
                  "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
                  "userIp" => current_user_ip(),
                  "activityName" => "Vehiculo eliminado con exito" ,
                  "lastQuery" => $this->db->last_query(),
                  "currentPage" => "Menu Vehiculos",
                  "currentMethod" => "Eliminar vehiculo"
                )
            );              
            set_volatile_success("Vehiculo eliminado con exito");
        } else {
            $this->audits_model->insert(
                array(
                  "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
                  "userIp" => current_user_ip(),
                  "activityName" => "Ocurrio un error al tratar de eliminar, id:". $id ,
                  "lastQuery" => $this->db->last_query(),
                  "currentPage" => "Menu Vehiculos",
                  "currentMethod" => "Eliminar vehiculo"
                )
            ); 
            set_volatile_data("Ocurrio un error al tratar de eliminar " . $id);
        }
        redirect(base_url() . "admin.php/vehicles/show_list");
    }

}
