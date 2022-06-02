<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Destinations_model extends CI_Model {

  function __construct() {
    parent::__construct();
  }

  public function find_first($filter = array()) {
    if ($filter == null) {
      return null;
    }
    $query = $this->db->get_where('gm_destinations_category', $filter);
    return $query->num_rows() > 0 ? $query->row() : null;
  }

  public function find($filter = null) {
    $this->db->from('gm_destinations_category');
    if ($filter) {
      $this->db->where($filter);
    }
    $this->db->order_by("position", "asc");
    $query = $this->db->get();
    
    return $query->result();
  }

}
