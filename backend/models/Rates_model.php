<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Rates_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function find_by_id($id = null) {
        $query = $this->db->get_where('rates', array('id' => $id));
        return $query->num_rows() == 1 ? $query->row() : null;
    }

    public function find_first($filter = array()) {
        if ($filter == null) {
            return null;
        }
        $query = $this->db->get_where('rates', $filter);
        return $query->num_rows() > 0 ? $query->row() : null;
    }

    public function find($filter = null) {
        if ($filter) {
            $query = $this->db->get_where('rates', $filter);
        } else {
            $query = $this->db->get('rates');
        }

        return $query->result();
    }
    public function insert($data) {
        $filter = array('vehicleType','rateType','name', 'price', 'description');
        db_mapping_and_set($this->db, $data, $filter);

        $this->db->insert('rates');

        return $this->db->insert_id();
    }

    public function update($id, $data) {
        // TODO actualizar filtro
        $filter = array('vehicleType','rateType','name', 'price', 'description');
        db_mapping_and_set($this->db, $data, $filter);
        $this->db->where(array('id' => $id));
        return $this->db->update('rates');
    }

    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete('rates');
    }
}
