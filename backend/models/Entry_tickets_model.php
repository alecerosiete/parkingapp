<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Entry_tickets_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function find_by_id($id = null) {
        if($id == null){
            return null;
        }
        $query = $this->db->get_where('entry_tickets', array('id' => $id));
        return $query->num_rows() == 1 ? $query->row() : null;
    }

    public function find_first($filter = array()) {
        if ($filter == null) {
            return null;
        }
        $query = $this->db->get_where('entry_tickets', $filter);
        return $query->num_rows() > 0 ? $query->row() : null;
    }

    public function find($filter = null) {
        if ($filter) {
            $query = $this->db->get_where('entry_tickets', $filter);
        } else {
            $query = $this->db->get('entry_tickets');
        }

        return $query->result();
    }
    public function insert($data) {
        $filter = array('ticketId','entry');
        db_mapping_and_set($this->db, $data, $filter);

        $this->db->insert('entry_tickets');

        return $this->db->insert_id();
    }


    public function find_summary($filter = null){
        // select totemId, totemType, count(*) from entry_tickets where date(entry) = "2022-06-01" group by totemId, totemType ORDER by totemId;
        $this->db->select(" `totemId`, SUM(if(totemType = 'I', 1, 0)) AS TOTEMTYPE_I,  SUM(if(totemType = 'O', 1, 0)) AS TOTEMTYPE_O, count(*) as cant");
        $this->db->from("entry_tickets");
        if($filter){
            $this->db->where($filter);        
        }else{
            $this->db->where(array("date(entry)" => "now()"));        
        }
        
        $this->db->group_by(array("totemId"));
        $this->db->order_by("totemId");
        $query = $this->db->get();
        return $query->result();

    }

    public function update($id, $data) {
        if($id == null){
            return null;
        }
        $filter = array('ticketId','entry');
        db_mapping_and_set($this->db, $data, $filter);
        $this->db->where(array('id' => $id));
        return $this->db->update('entry_tickets');
    }

    public function delete($id) {
        if($id == null){
            return null;
        }
        $this->db->where('id', $id);
        return $this->db->delete('entry_tickets');
    }
}
