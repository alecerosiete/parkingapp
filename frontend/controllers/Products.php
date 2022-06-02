<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

  public function __construct() {
    parent::__construct();
  }

  public function index() {
    $this->layout->setDescription(":: Productos - Okivoice ::");
    $this->layout->setTitle(".:: Productos - Okivoice ::.");
    $this->layout->setKeywords("Okivoice masivos, Okivoice");
    
    $this->layout->view('/productos');
  }
  
  

}
