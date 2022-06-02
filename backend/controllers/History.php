<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class History extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        assert_user();

        $this->layout->setDescription("Pagina de Historial de SMS");
        $this->layout->setTitle(".:: Historial ::.");

        $this->layout->js(array(
          base_url() . "/public/backend/dist/js/pages/dashboard2.js"
        ));

        //get any data to send message
        $data[] = array();

        $data['user'] = $this->credits_model->get_credit(current_user()->username);
	if(check_role(ROLE_ADMIN)){
             $dolar = $this->exchanges_model->find_by_id(1);
                $data['dolar'] = $dolar;
                $whappendCredit =  get_admin_credit()*$dolar->valor;
                $usersCredit = $this->credits_model->get_credit_sum();
                $data['user']->credit = $whappendCredit-$usersCredit->creditos;
                $this->credits_model->update(current_user()->username, ($data['user']->credit ), DEBIT);

        }

        $this->layout->view('/history/show_main', $data);
    }

    public function show($phoneNumber = null) {
        assert_user();
        $this->layout->setDescription("Pagina de Historial de SMS");
        $this->layout->setTitle(".:: Historial ::.");

        if ($phoneNumber == null) {
            $mapping = array('phoneNumber');
            $post_data = input_read_post($this->input, $mapping);

            assert_existence($post_data, base_url() . "/admin.php/history/");
            if ($this->form_validation->run("history") == FALSE) {
                $this->index();
                return;
            }
        } else {
            $post_data['phoneNumber'] = $phoneNumber;
        }

        $this->layout->js(array(
          base_url() . "public/backend/dist/js/pages/dashboard2.js",
          base_url() . "public/backend/plugins/datatables/dataTables.bootstrap.css",
        ));

        $this->layout->css(array(
          base_url() . "public/backend/plugins/datatables/dataTables.bootstrap.css",
          base_url() . "public/backend/dist/css/AdminLTE.min.css"
        ));

        $data[] = array();
        $data['history'] = $this->outbox_model->find_history(array("username" => current_user()->username, "phoneNumber" => $post_data['phoneNumber']));
        $data['user'] = $this->credits_model->get_credit(current_user()->username);
	if(check_role(ROLE_ADMIN)){
             $dolar = $this->exchanges_model->find_by_id(1);
                $data['dolar'] = $dolar;
                $whappendCredit =  get_admin_credit() * $dolar->valor;
                $usersCredit = $this->credits_model->get_credit_sum();
                $data['user']->credit = $whappendCredit-$usersCredit->creditos;
                $this->credits_model->update(current_user()->username, ($data['user']->credit ), DEBIT);

        }

        $this->layout->view('/history/show_main', $data);
    }

}
