<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Faqs extends CI_Controller {

  public function __construct() {
    parent::__construct();
  }

  public function index() {
    $this->layout->setDescription(":: FAQS - Okivoice ::");
    $this->layout->setTitle(".:: FAQS - Okivoice ::.");
    $this->layout->setKeywords("Okivoice masivos, Okivoice");
    
    $this->layout->view('/faqs');
  }
  
  

}
