<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AntiSpam extends CI_Controller {

  public function __construct() {
    parent::__construct();
  }

  public function index() {
    $this->layout->setDescription(":: ANTISPAM - Okivoice::");
    $this->layout->setTitle(".:: ANTISPAM - Okivoice::.");
    $this->layout->setKeywords("SMS masivos, Okivoice");
    
    $this->layout->view('/antispam');
  }
  
  

}
