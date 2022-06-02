<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Authentication extends CI_Controller {

  public function __construct() {
    parent::__construct();
  }

  public function index() {
    $this->show_login();
  }

  public function show_login() {
    $this->layout->setLayout('login');
    $this->layout->setTitle('ParkingApp :: Acceso al Sistema');
    
    $this->audits_model->insert(
        array(
          "username" => "Desconocido",
          "userIp" => current_user_ip(),
          "activityName" => "Acceso al sistema",
          "lastQuery" => null,
          "currentPage" => "Pagina de Login",
          "currentMethod" => "Visualizar pagina de acceso de usuarios"
        )
    );
    
    $this->layout->view("/show_login");
  }

  public function login() {
    $mapping = array('username','userpass');
    $data = input_read_post($this->input, $mapping);

    if ($data == null) {
      $this->session->set_flashdata('ControllerMessage', "No se encontraron datos para procesar su acceso");
      redirect(LOGIN_URL, 301);
    }else if(!isset($data['username']) || !isset($data['userpass'])){
        $this->session->set_flashdata('ControllerMessage', "Usuario o Clave no encontrado");
        redirect(LOGIN_URL, 301);
    }

    $user = $this->profiles_model->find_active($data['username'], $data['userpass']);

    if ($user) {
      $user_data = $this->profiles_model->find_first(array("username"=>$user->username));
      $user->user_id = $user_data->id;
      $this->session->set_userdata('masivos');
      $this->session->set_userdata('username', $user->username);
      $this->session->set_userdata('user', $user);
      
        $this->audits_model->insert(
            array(
              "username" => $user->username,
              "userIp" => current_user_ip(),
              "activityName" => "Acceso al sistema exitoso",
              "lastQuery" => $this->db->last_query(),
              "currentPage" => "Pagina de Login",
              "currentMethod" => "Procesando login de usuario"
            )
        );
    
      redirect(base_url().'admin.php/main');
    } else {
         $this->audits_model->insert(
            array(
              "username" => $data['username'],
              "userIp" => current_user_ip(),
              "activityName" => "Acceso al sistema fallido",
              "lastQuery" => $this->db->last_query(),
              "currentPage" => "Pagina de Login",
              "currentMethod" => "Procesando login de usuario"
            )
        );
      $this->session->set_flashdata('ControllerMessage', "Usuario o Contraseña no valido o inactivo");
      redirect(LOGIN_URL, 301);
    }
  }

  public function logout() {
        $referer = (isset($_SERVER['HTTP_REFERER'])) ? strtolower($_SERVER['HTTP_REFERER']) : "error";
       $this->audits_model->insert(
            array(
              "username" => isset(current_user()->username) ? current_user()->username : "Desconocido",
              "userIp" => current_user_ip(),
              "activityName" => "Cerrar sesion",
              "lastQuery" => null,
              "currentPage" => $referer,
              "currentMethod" => "Logout"
            )
        );
    $this->session->sess_destroy();
    redirect(LOGIN_URL, 301);
  }

}
