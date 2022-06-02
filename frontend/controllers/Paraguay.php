<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Paraguay extends CI_Controller {

  public function __construct() {
    parent::__construct();
  }

  public function index() {
        $this->layout->setDescription("Pagina de informacion sobre Paraguay, Giromundo Corporacion Turistica");
    $this->layout->setTitle(".:: Destino Paraguay - Giromundo Corporaci&oacute;n Tur&iacute;stica::.");
    $this->layout->setKeywords("paraguay, turismo en paraguay, turismo en py, vacaciones en paraguay");

    
    $this->layout->view('/paraguay');
  }
  
  

}