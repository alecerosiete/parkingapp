<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Groups extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->show_list();
    }

    public function show_create() {
        assert_user();
        assert_role(ROLE_ADMIN);
        $this->layout->setDescription("Crear Grupos");
        $this->layout->setTitle(".:: Grupos de WhatsApp ::.");

        $this->layout->js(array(
            base_url() . "public/backend/dist/js/pages/dashboard2.js",
            base_url() . "public/backend/plugins/select2/select2.full.min.js"
        ));
        $this->layout->css(array(
            base_url() . "public/backend/plugins/select2/select2.min.css",
            base_url() . "public/backend/dist/css/AdminLTE.min.css"
        ));



        $data[] = array();
        $country_select = $this->layout->element("country_select", null, true);
        $data['select_country'] = $country_select;

        $data['user'] = $this->credits_model->get_credit(current_user()->username);
        if (check_role(ROLE_ADMIN)) {
            $dolar = $this->exchanges_model->find_by_id(1);
            $data['dolar'] = $dolar;

            $whappendCredit = get_admin_credit() * $dolar->valor;
            $usersCredit = $this->credits_model->get_credit_sum();
            $data['user']->credit = $whappendCredit - $usersCredit->creditos;
            $this->credits_model->update(current_user()->username, ($data['user']->credit), DEBIT);
        }


        $this->layout->view('/groups/show_create', $data);
    }

    public function create() {
        assert_user();
        assert_role(ROLE_ADMIN);
        if ($this->form_validation->run("group") == FALSE) {
            $this->show_create();

            return;
        }

        $mapping = array('groupName', 'phoneNumbers', 'country');
        $data = input_read_post($this->input, $mapping);

        $data['groupId'] = $this->groups_model->insert(array("username" => current_user()->username, "groupName" => $data['groupName']));

        $phoneNumbers = explode("\n", $data['phoneNumbers']);
        $user = current_user();
        $insert_success = 0;
        $insert_error = 0;

        foreach ($phoneNumbers as $phoneNumber) {
            $result = $this->groups_phone_numbers_model->insert(
                    array(
                        "groupId" => $data['groupId'],
                        "phoneNumber" => $phoneNumber
                    )
            );
            if ($result) {
                $insert_success++;
            } else {
                $insert_error++;
            }
        }
        if ($insert_success > 0) {
            set_volatile_success("Grupo creado con exito! " . $insert_success . " numeros cargados.");
        } else {
            set_volatile_error("El grupo no contiene numeros validos");
        }
        redirect(base_url() . "admin.php/groups/show_list");
    }

    public function show_list() {
        assert_user();
        assert_role(ROLE_ADMIN);
        $this->layout->setDescription("Lista de Grupos");
        $this->layout->setTitle(".:: Grupos de WhatsApp ::.");

        $this->layout->js(array(
            base_url() . "public/backend/dist/js/pages/dashboard2.js",
            base_url() . "public/backend/plugins/select2/select2.full.min.js"
        ));
        $this->layout->css(array(
            base_url() . "public/backend/plugins/datatables/dataTables.bootstrap.css",
            base_url() . "public/backend/plugins/select2/select2.min.css",
        ));

        $data[] = array();

        $data['groups'] = $this->groups_model->find(array("username" => current_user()->username));

        $data['user'] = $this->credits_model->get_credit(current_user()->username);
        if (check_role(ROLE_ADMIN)) {
            $dolar = $this->exchanges_model->find_by_id(1);
            $data['dolar'] = $dolar;
            
            $whappendCredit = get_admin_credit() * $dolar->valor;
            $usersCredit = $this->credits_model->get_credit_sum();
            $data['user']->credit = $whappendCredit - $usersCredit->creditos;
            $this->credits_model->update(current_user()->username, ($data['user']->credit), DEBIT);
        }

        $this->layout->view('/groups/show_list', $data);
    }

    public function delete($id = null) {
        assert_user();
        assert_role(ROLE_ADMIN);
        assert_existence($id, base_url() . "/admin.php/groups/show_list", "No se recibio el id del grupo a eliminar");

        $data['group'] = $this->groups_model->find_by_id($id);
        assert_existence($data['group'], base_url() . "/admin.php/groups/show_list", "No existe el grupo que desea eliminar");

        $delete = $this->groups_model->delete($id);

        $delete_group_phone_numbers = $this->groups_phone_numbers_model->delete_by_group($id);

        if ($delete && $delete_group_phone_numbers) {
            set_volatile_success("Grupo eliminado con exito");
        } else {
            set_volatile_error("Ocurrio un error mientras se intentaba eliminar el grupo");
        }

        redirect(base_url() . "/admin.php/groups/show_list");
    }

    public function send($id) {
        assert_user();

        assert_existence($id, base_url() . "/admin.php/groups/show_list", "No se recibio el id del grupo a emvoar");

        $data['group'] = $this->groups_model->find_first(array("id" => $id, "username" => current_user()->username));
        assert_existence($data['group'], base_url() . "/admin.php/groups/show_list", "No existe el grupo que desea Enviar");

        $data["phoneNumbers"] = $this->groups_phone_numbers_model->find(array("groupId" => $id));

        redirect(base_url() . "/admin.php/messages/show_create/" . $data);
    }

    public function show_edit($id = null) {
        assert_user();
        assert_role(ROLE_ADMIN);
        if ($id == null) {
            set_volatile_error("No se encontro el id de grupo para visualizar");
            redirect(base_url() . "/admin.php/groups/show_list");
        }

        $this->layout->setDescription("Editar Grupos");
        $this->layout->setTitle(".:: Grupos de WhatsApp ::.");

        $this->layout->js(array(
            base_url() . "public/backend/dist/js/pages/dashboard2.js",
            base_url() . "public/backend/plugins/select2/select2.full.min.js"
        ));
        $this->layout->css(array(
            base_url() . "public/backend/plugins/select2/select2.min.css",
            base_url() . "public/backend/dist/css/AdminLTE.min.css"
        ));



        $data[] = array();
        $country_select = $this->layout->element("country_select", null, true);
        $data["select_country"] = $country_select;
        $data['group'] = $this->groups_model->find_first(array("id" => $id, "username" => current_user()->username));
        assert_existence($data['group'], base_url() . "/admin.php/groups/show_list", "No existe el grupo que desea visualizar");

        $phoneNumbers = $this->groups_phone_numbers_model->find(array("groupId" => $id));
        $phoneList = array();
        foreach ($phoneNumbers as $phone) {
            array_push($phoneList, $phone->phoneNumber);
        }
        $data["phoneNumbers"] = implode("\n", $phoneList);

        $data['user'] = $this->credits_model->get_credit(current_user()->username);
        if (check_role(ROLE_ADMIN)) {
             $dolar = $this->exchanges_model->find_by_id(1);
                $data['dolar'] = $dolar;
            $whappendCredit = get_admin_credit() * $dolar->valor;
            $usersCredit = $this->credits_model->get_credit_sum();
            $data['user']->credit = $whappendCredit - $usersCredit->creditos;
            $this->credits_model->update(current_user()->username, ($data['user']->credit), DEBIT);
        }


        $this->layout->view('/groups/show_edit', $data);
    }

    public function update($id = null) {
        assert_user();
        assert_role(ROLE_ADMIN);
        assert_existence($id, base_url() . "admin.php/groups/show_list", "Grupo no valido para modificar");

        if ($this->form_validation->run("group") == FALSE) {
            $this->show_create();

            return;
        }

        $mapping = array('groupName', 'phoneNumbers', 'country');
        $data = input_read_post($this->input, $mapping);

        $exist_group = $this->groups_model->find_first(array("id" => $id, "username" => current_user()->username));
        assert_existence($id, base_url() . "admin.php/groups/show_list", "Grupo no valido para modificar");

        $update_result = $this->groups_model->update($id, array("groupName" => $data['groupName']));

        if (!$update_result) {
            set_volatile_error("Error al tratar de actualizar el Grupo, intentelo nuevamente.");
            redirect(base_url() . "admin.php/groups/show_list");
        }

//delete old phone numbers
        $delete_group_phone_numbers = $this->groups_phone_numbers_model->delete_by_group($id);
        if (!$delete_group_phone_numbers) {
            set_volatile_error("Error al tratar de actualizar el Grupo, intentelo nuevamente.");
            redirect(base_url() . "admin.php/groups/show_list");
        }

        $phoneNumbers = explode("\n", $data['phoneNumbers']);
        $user = current_user();
        $insert_success = 0;
        $insert_error = 0;

        foreach ($phoneNumbers as $phoneNumber) {
            $result = $this->groups_phone_numbers_model->insert(
                    array(
                        "groupId" => $id,
                        "phoneNumber" => $phoneNumber
                    )
            );
            if ($result) {
                $insert_success++;
            } else {
                $insert_error++;
            }
        }
        if ($insert_success > 0) {
            set_volatile_success("Grupo actualizado con exito! " . $insert_success . " numeros cargados.");
        } else {
            set_volatile_error("El grupo no contiene numeros validos");
        }
        redirect(base_url() . "admin.php/groups/show_list");
    }

}
