<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Price extends CI_Controller {

  public function __construct() {
    parent::__construct();
  }

  public function index() {
    $this->layout->setDescription(":: Precios - Okivoice ::");
    $this->layout->setTitle(".:: Precios - Okivoice ::.");
    $this->layout->setKeywords("Okivoice masivos, Okivoice");
    
    $this->layout->view('/price');
  }
  
  

}
