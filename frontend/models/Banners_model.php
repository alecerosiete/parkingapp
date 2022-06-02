<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Banners_model extends CI_Model {

  function __construct() {
    parent::__construct();
  }

  public function find_by_id($id = null) {
    $query = $this->db->get_where('ms_backend_banner', array('id' => $id));
    return $query->num_rows() == 1 ? $query->row() : null;
  }

  public function find_first($filter = array()) {
    if ($filter == null) {
      return null;
    }
    $query = $this->db->get_where('ms_backend_banner', $filter);
    return $query->num_rows() > 0 ? $query->row() : null;
  }

  public function find($filter = null) {
    if ($filter) {
      $query = $this->db->get_where('ms_backend_banner', $filter);
    } else {
      $query = $this->db->get('ms_backend_banners');
    }

    $this->db->order_by("registered", "desc");
    
    return $query->result();
  }

}
