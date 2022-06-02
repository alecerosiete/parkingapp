<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Groups_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function find_by_id($id = null) {
        $query = $this->db->get_where('ms_whasend_groups', array('id' => $id));
        return $query->num_rows() == 1 ? $query->row() : null;
    }

    public function find_first($filter = array()) {
        if ($filter == null) {
            return null;
        }
        $query = $this->db->get_where('ms_whasend_groups', $filter);
        return $query->num_rows() > 0 ? $query->row() : null;
    }

    public function find($filter = null) {
        $this->db->order_by("registered", "DESC");
        if ($filter) {
            $query = $this->db->get_where('ms_whasend_groups', $filter);
        } else {
            $query = $this->db->get('ms_whasend_groups');
        }

        return $query->result();
    }



    public function insert($data) {
        $filter = array('username','groupName');
        db_mapping_and_set($this->db, $data, $filter);
        $this->db->set("registered", 'CURRENT_TIMESTAMP', FALSE);

        $this->db->insert('ms_whasend_groups');
        return $this->db->insert_id();
    }

    public function update($id, $data) {
        // TODO actualizar filtro
        $filter = array('groupName');
        db_mapping_and_set($this->db, $data, $filter);
        $this->db->where(array('id' => $id));
        return $this->db->update('ms_whasend_groups');
    }

    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete('ms_whasend_groups');
    }
}
