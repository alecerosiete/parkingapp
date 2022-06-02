<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Packages extends CI_Controller {

  public function __construct() {
    parent::__construct();
  }

  public function index($id = null) {
    $this->layout->setDescription("Pagina de Destinos, paquetes de viajes, vacaciones, viajes, vuelos, Giromundo Corporacion Turistica");
    $this->layout->setTitle(".:: Paquetes de Viajes - Giromundo Corporaci&oacute;n Tur&iacute;stica::.");
    $this->layout->setKeywords("vacaciones, viajes al caribe, luna de niel en el caribe, playas increibles, playas, caribe, cancun, riviera maya, vacaciones en cancun, vuelos baratos a cancun, vuelos baratos a riviera maya, paquetes baratos desde paraguay al caribe");

    $this->show_destination($id);
  }

  public function show_package($id = null) {

    $package = $this->packages_model->find_first(array("id"=>$id));
    if(!$package){
      set_volatile_error("No se encontro ningun registro");
      redirect(base_url());
    }

    $data['package'] = $package;

    $this->layout->view('/packages', $data);
  }

}
