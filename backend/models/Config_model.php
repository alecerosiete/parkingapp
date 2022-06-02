<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Config_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function find_by_id($id = null) {
        $query = $this->db->get_where('config', array('id' => $id));
        return $query->num_rows() == 1 ? $query->row() : null;
    }

    public function find_first($filter = array()) {
         if ($filter) {
            $query = $this->db->get_where('config', $filter);
        } else {
            $query = $this->db->get('config');
        }
        return $query->num_rows() > 0 ? $query->row() : null;
    }

    public function find($filter = null) {
        if ($filter) {
            $query = $this->db->get_where('config', $filter);
        } else {
            $query = $this->db->get('config');
        }

        return $query->result();
    }
    public function insert($data) {
        $filter = array('defaultPrice','company','phone','address','ruc','timeToGo','verifyOnExit','freeTime','toExitFree');
        db_mapping_and_set($this->db, $data, $filter);

        $this->db->insert('config');

        return $this->db->insert_id();
    }

    public function update($id, $data) {
        // TODO actualizar filtro
        $filter = array('defaultPrice','company','phone','address','ruc','timeToGo','verifyOnExit','freeTime','toExitFree');
        db_mapping_and_set($this->db, $data, $filter);
        $this->db->where(array('id' => $id));
        return $this->db->update('config');
    }

    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete('config');
    }
}
