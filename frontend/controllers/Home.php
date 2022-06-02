<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

  public function __construct() {
    parent::__construct();
  }

  public function index() {
	/* SE REDIRIGE AL BACKEND */
	redirect(base_url()."admin.php");
    $this->layout->setDescription(":: Bienvenidos - ParkingApp ::");
    $this->layout->setTitle(".:: Bienvenidos - ParkingApp ::.");
    $this->layout->setKeywords("Estacionamiento, ParkingApp");

    $this->layout->view('/home');
  }
  
  

}
