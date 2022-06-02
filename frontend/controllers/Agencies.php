<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Agencies extends CI_Controller {

  public function __construct() {
    parent::__construct();
  }

  public function index() {
    
    $this->layout->setDescription("Pagina de informacion sobre Agencias de Viajes y Turismo, Giromundo Corporacion Turistica");
    $this->layout->setTitle(".:: Agencias de Viajes y Turismo - Giromundo Corporaci&oacute;n Tur&iacute;stica::.");
    $this->layout->setKeywords("giromundo, corporacion turistica, agencias de viaje en paraguay, agencias, turismo");
    
    $this->layout->view('/agencies');
  }
  
  

}