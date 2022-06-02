<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Clients extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->show_list();
    }

    public function show_list()
    {
        assert_user();
        $this->layout->setDescription("Administracion de Clientes");
        $this->layout->setTitle(".:: Administracion de Clientes ::.");
        $this->layout->css(
            array(
                base_url() . "public/backend/plugins/datatables/dataTables.bootstrap.css",
                base_url() . "public/backend/plugins/iCheck/all.css"
            )
        );
        $this->layout->js(
            array(
                base_url() . "public/backend/plugins/iCheck/icheck.min.js"
            )
        );

        $user = current_user();

        $data = array();
        if (check_role(ROLE_ADMIN)) {
            $data['clients'] = $this->clients_model->find();
        } else {
            $data['clients'] = $this->clients_model->find(array("username" => $user->username));
        }
        $this->audits_model->insert(
            array(
                "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
                "userIp" => current_user_ip(),
                "activityName" => "Listar Clientes",
                "lastQuery" => $this->db->last_query(),
                "currentPage" => "Menu Clientes",
                "currentMethod" => "Listar Clientes"
            )
        );

        $this->layout->view('/clients/list', $data);
    }

    public function show($id = null)
    {
        assert_user();
        assert_existence($id, "/admin.php/clients/show_list", "No se obtuvo el id");

        $this->layout->setDescription("Detalles del cliente");
        $this->layout->setTitle(".:: Datos del cliente ::.");
        $this->layout->css(
            array(
                base_url() . "public/backend/plugins/datatables/dataTables.bootstrap.css",
                base_url() . "public/backend/plugins/iCheck/all.css",
                base_url() . "public/backend/plugins/datetimepicker/bootstrap-datetimepicker.css"
            )
        );

        $this->layout->js(array(
            base_url() . "public/backend/dist/js/pages/dashboard2.js",
            base_url() . "public/backend/dist/js/jsonfinder.js",
            base_url() . "public/backend/plugins/iCheck/icheck.min.js",
            base_url() . "public/backend/plugins/daterangepicker/moment.js",
            base_url() . "public/backend/plugins/datetimepicker/bootstrap-datetimepicker.js",
        ));

        $data = array();

        $vehicles = $this->vehicles_model->find();
        $data['vehicles'] = $vehicles;

        $rates = $this->rates_model->find();
        $data["rates"] = $rates;

        $user = current_user();


        $data['client'] = $this->clients_model->find_by_id($id);

        $this->audits_model->insert(
            array(
                "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
                "userIp" => current_user_ip(),
                "activityName" => "Ver Detalles de Cliente",
                "lastQuery" => $this->db->last_query(),
                "currentPage" => "Menu Clientes",
                "currentMethod" => "Ver Clientes"
            )
        );
        $this->layout->view('/clients/show', $data);
    }

    public function new_client()
    {
        assert_user();

        $this->layout->setDescription("Agregar Nuevo cliente");
        $this->layout->setTitle(".:: Nuevo Cliente ::.");

        $this->layout->js(array(
            base_url() . "public/backend/dist/js/pages/dashboard2.js",
            base_url() . "public/backend/dist/js/jsonfinder.js",
            base_url() . "public/backend/plugins/iCheck/icheck.min.js",
            base_url() . "public/backend/plugins/daterangepicker/moment.js",
            base_url() . "public/backend/plugins/datetimepicker/bootstrap-datetimepicker.js",
        ));

        $this->layout->css(array(
            base_url() . "public/backend/plugins/datetimepicker/bootstrap-datetimepicker.css"
        ));

        $data = array();

        $vehicles = $this->vehicles_model->find();
        $data['vehicles'] = $vehicles;

        $rates = $this->rates_model->find();
        $data["rates"] = $rates;

        $this->audits_model->insert(
            array(
                "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
                "userIp" => current_user_ip(),
                "activityName" => "Visualizar pagina para crear clientes",
                "lastQuery" => $this->db->last_query(),
                "currentPage" => "Menu Clientes",
                "currentMethod" => "Nuevo Cliente"
            )
        );

        $this->layout->view('/clients/new', $data);
    }


    public function create()
    {
        assert_user();

        $mapping = array(
            'name', 'phone', 'email', 'description', 'clientType', 'rfid', 'rate', 'vehicleType',
            'active', 'dateTime'
        );
        $data = input_read_post($this->input, $mapping);

        if ($this->form_validation->run("clients") == FALSE) {
            $this->new_client();
            return;
        }

        $data['username'] = current_user()->username;
        $data['readerType'] = "OUT";
        $datetime = explode(" ",$data['dateTime']);
        $date = $datetime[0];
        $date = str_replace('/', '-', $date);
        $data["expire"] = date('Y-m-d', strtotime($date))." ".$datetime[1];

        $insert_result = $this->clients_model->insert($data);
        if ($insert_result) {
            $this->audits_model->insert(
                array(
                    "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
                    "userIp" => current_user_ip(),
                    "activityName" => "Nuevo cliente creado con exito",
                    "lastQuery" => $this->db->last_query(),
                    "currentPage" => "Menu Clientes",
                    "currentMethod" => "Nuevo Cliente"
                )
            );
            set_volatile_success("Cliente creado con exito");
            redirect(base_url() . "admin.php/clients/show_list");
        } else {
            $this->audits_model->insert(
                array(
                    "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
                    "userIp" => current_user_ip(),
                    "activityName" => "Fallo al crear un nuevo cliente",
                    "lastQuery" => $this->db->last_query(),
                    "currentPage" => "Menu Clientes",
                    "currentMethod" => "Nuevo Cliente"
                )
            );
            set_volatile_error("Ocurrio un error, intente de nuevo o contacte con el administrador");
            $this->new_client();
        }
    }

    public function edit($id = null)
    {
        assert_user();

        assert_existence($id, "/admin.php/clients/show_list", "No se obtuvo el id");

        $mapping = array('name', 'phone', 'email', 'description', 'clientType', 'rfid',
         'rate', 'vehicleType','active','dateTime');
        $data = input_read_post($this->input, $mapping);

        assert_existence($data, "/admin.php/clients/show_list", "No se obtuvo el id");

        if ($this->form_validation->run("clients") == FALSE) {
            $this->show();
            return;
        }

        $datetime = explode(" ",$data['dateTime']);
        $date = $datetime[0];
        $date = str_replace('/', '-', $date);
        $data["expire"] = date('Y-m-d', strtotime($date))." ".$datetime[1];

        if (!isset($data['phone'])) {
            $data['phone'] = "";
        }
        if (!isset($data['email'])) {
            $data['email'] = "";
        }
        if (!isset($data['description'])) {
            $data['description'] = "";
        }
        if (!isset($data['clientType'])) {
            $data['clientType'] = "";
        }

        $update_result = $this->clients_model->update($id, $data);

        if ($update_result) {
            $this->audits_model->insert(
                array(
                    "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
                    "userIp" => current_user_ip(),
                    "activityName" => "Cliente Editado exitosamente",
                    "lastQuery" => $this->db->last_query(),
                    "currentPage" => "Menu Clientes",
                    "currentMethod" => "Editar Cliente"
                )
            );
            set_volatile_success("Cliente Editado exitosamente!");
            redirect("/admin.php/clients/show_list/", 301);
        } else {
            $this->audits_model->insert(
                array(
                    "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
                    "userIp" => current_user_ip(),
                    "activityName" => "Ocurrio un error al tratar de editar",
                    "lastQuery" => $this->db->last_query(),
                    "currentPage" => "Menu Clientes",
                    "currentMethod" => "Editar Cliente"
                )
            );
            set_volatile_error("Ocurrio un error al tratar de editar, intentelo nuevamente");
            redirect("/admin.php/clients/show_list/", 301);
        }
    }

    public function delete($id = null)
    {
        assert_user();
        assert_existence($id, "/admin.php/clients/show_list", "No se obtuvo el id");

        $delete_data = $this->clients_model->find_by_id($id);
        assert_existence($delete_data, "/admin.php/clients/show_list", "Ningun dato para eliminar");
        $delete_result = $this->clients_model->delete($id);
        if ($delete_result) {
            $this->audits_model->insert(
                array(
                    "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
                    "userIp" => current_user_ip(),
                    "activityName" => "Cliente eliminado con exito",
                    "lastQuery" => $this->db->last_query(),
                    "currentPage" => "Menu Clientes",
                    "currentMethod" => "Eliminar Cliente"
                )
            );
            set_volatile_success("Cliente eliminado con exito");
        } else {
            $this->audits_model->insert(
                array(
                    "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
                    "userIp" => current_user_ip(),
                    "activityName" => "Ocurrio un error al tratar de eliminar cliente",
                    "lastQuery" => $this->db->last_query(),
                    "currentPage" => "Menu Clientes",
                    "currentMethod" => "Eliminar Cliente"
                )
            );
            set_volatile_data("Ocurrio un error al tratar de eliminar " . $id);
        }
        redirect(base_url() . "admin.php/clients/show_list");
    }

    public function detail($id = null)
    {
        assert_user();
        assert_existence($id, "/admin.php/clients/show_list", "No se obtuvo el id");

        $this->layout->setDescription("Detalles del cliente");
        $this->layout->setTitle(".:: Datos del cliente ::.");
        $this->layout->css(
            array(
                base_url() . "public/backend/plugins/datatables/dataTables.bootstrap.css",
                base_url() . "public/backend/plugins/iCheck/all.css",
                base_url() . "public/backend/plugins/datetimepicker/bootstrap-datetimepicker.css"
            )
        );

        $this->layout->js(array(
            base_url() . "public/backend/dist/js/pages/dashboard2.js",
            base_url() . "public/backend/dist/js/jsonfinder.js",
            base_url() . "public/backend/plugins/iCheck/icheck.min.js",
            base_url() . "public/backend/plugins/daterangepicker/moment.js",
            base_url() . "public/backend/plugins/datetimepicker/bootstrap-datetimepicker.js",
        ));

        $data = array();

        $vehicles = $this->vehicles_model->find();
        $data['vehicles'] = $vehicles;

        $rates = $this->rates_model->find();
        $data["rates"] = $rates;

        $user = current_user();


        $data['client'] = $this->clients_model->find_by_id($id);

        $this->audits_model->insert(
            array(
                "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
                "userIp" => current_user_ip(),
                "activityName" => "Ver Detalles de Cliente",
                "lastQuery" => $this->db->last_query(),
                "currentPage" => "Menu Clientes",
                "currentMethod" => "Ver Clientes"
            )
        );
        $this->layout->view('/clients/detail', $data);
    }
}
