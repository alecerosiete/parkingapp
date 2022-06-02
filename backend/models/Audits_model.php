<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Audits_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function find_by_id($id = null) {
        $query = $this->db->get_where('audits', array('id' => $id));
        return $query->num_rows() == 1 ? $query->row() : null;
    }

    public function find_first($filter = array()) {
        if ($filter == null) {
            return null;
        }
        $query = $this->db->get_where('audits', $filter);
        return $query->num_rows() > 0 ? $query->row() : null;
    }

    public function find($filter = null) {
        if ($filter) {
            $query = $this->db->get_where('audits', $filter);
        } else {
            $query = $this->db->get('audits');
        }

        return $query->result();
    }
    
    public function find_filter($filter){
        if ($filter) {
            if(isset($filter['in'])){
                $this->db->where('`registered` >=', $filter['in']);
            }
            if(isset($filter['out'])){
                $this->db->where('`registered` <=', $filter['out']);
            }
            if(isset($filter['username'])){
                $this->db->where('username =', $filter['username']);
            }
            
        } 
        $query = $this->db->get('audits');
        
        return $query->result();
    }
    
    public function insert($data) {
        $filter = array('activityName','currentPage','currentMethod','userIp','lastQuery','username');
        db_mapping_and_set($this->db, $data, $filter);

        $this->db->insert('audits');

    }


}
