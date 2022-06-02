<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Destinations extends CI_Controller {

  public function __construct() {
    parent::__construct();
  }

  public function index($id = null) {
    $this->layout->setDescription("Pagina de Destinos, paquetes de viajes, vacaciones, viajes, vuelos, Giromundo Corporacion Turistica");
    $this->layout->setTitle(".:: Destinos - Giromundo Corporaci&oacute;n Tur&iacute;stica::.");
    $this->layout->setKeywords("vacaciones, viajes al caribe, luna de niel en el caribe, playas increibles, playas, caribe, cancun, riviera maya, vacaciones en cancun, vuelos baratos a cancun, vuelos baratos a riviera maya, paquetes baratos desde paraguay al caribe");

    $this->show_destination($id);
  }

  public function show_promotions($id = 1) {
    //$category = $this->destinations_model->find_first(array("id"=>$id));
    
    $promotions = $this->packages_model->find(array("promotion"=>1));
    assert_existence($promotions,"No se encontro ningun paquete");
    $data['packages'] = $promotions;
    $data['category_name'] = "Promociones";
    $this->layout->view("/destinations",$data);

  }

  public function show_destination($id = null) {

    $category = $this->destinations_model->find_first(array("id"=>$id));
    if(!$category){
      set_volatile_error("No se encontro ningun registro");
      redirect(base_url());
    }

    $data['category'] = $category;
    $data['packages'] = $this->packages_model->find(array("category_id" => $category->id));

    $this->layout->view('/destinations', $data);
  }

}
