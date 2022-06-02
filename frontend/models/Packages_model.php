<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Packages_model extends CI_Model {

  function __construct() {
    parent::__construct();
  }

  public function find_by_id($id = null) {
    $query = $this->db->get_where('gm_packages', array('id' => $id));
    return $query->num_rows() == 1 ? $query->row() : null;
  }

  public function find_first($filter = array()) {
    if ($filter == null) {
      return null;
    }
    $query = $this->db->get_where('gm_packages', $filter);
    return $query->num_rows() > 0 ? $query->row() : null;
  }

  public function find($filter = null) {
    if ($filter) {
      $query = $this->db->get_where('gm_packages', $filter);
    } else {
      $query = $this->db->get('gm_packages');
    }

    $this->db->order_by("registered", "desc");
    
    return $query->result();
  }

}
