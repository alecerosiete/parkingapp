<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class About_us extends CI_Controller {

  public function __construct() {
    parent::__construct();
  }

  public function index() {
    
    $this->layout->setDescription("Pagina de informacion sobre Nosotros, Giromundo Corporacion Turistica");
    $this->layout->setTitle(".:: Nosotors - Giromundo Corporaci&oacute;n Tur&iacute;stica::.");
    $this->layout->setKeywords("giromundo, corporacion turistica");
    
    $this->layout->view('/about_us');
  }
  
  

}