<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Reports_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function find_by_id($id = null) {
        $query = $this->db->get_where('reports', array('id' => $id));
        return $query->num_rows() == 1 ? $query->row() : null;
    }

    public function find_first($filter = array()) {
        if ($filter == null) {
            return null;
        }
        $query = $this->db->get_where('reports', $filter);
        return $query->num_rows() > 0 ? $query->row() : null;
    }

    public function find($filter = null,$clientsOnly = false) {
        if($clientsOnly){
            $this->db->where('clientId >', 0);
        }else{
            $this->db->where('clientId =', 0);
        }
        
        if ($filter) {
            $query = $this->db->get_where('reports', $filter);
        } else {
            $query = $this->db->get('reports');
        }

        return $query->result();
    }

    public function find_filter($filter = null, $clientsOnly = false) {
        if($clientsOnly){
            $this->db->where('clientId >', 0);
        }else{
            $this->db->where('clientId =', 0);
        }
        
        if ($filter) {
            if(isset($filter['in'])){
                $this->db->where('`in` >=', $filter['in']);
            }
            if(isset($filter['out'])){
                $this->db->where('`out` <=', $filter['out']);
            }
            if(isset($filter['username'])){
                $this->db->where('username =', $filter['username']);
            }
            if(isset($filter['rateType'])){
                $this->db->where('rateType =', $filter['rateType']);
            }
            
            $query = $this->db->get('reports');
        } else {
            $query = $this->db->get('reports');
        }

        return $query->result();
    }
    
    public function insert($data) {
        $filter = array('ticketId','in','out','vehicleType','rateName','rateType', 'ratePrice', 'rateDescription',
        'totalCalculate','discount','otherPayments','totalToPay','username','comments','clientId','ticketCode','paidOut','ticketExitStatus'
        );
        db_mapping_and_set($this->db, $data, $filter);
        $this->db->set('registered',date('Y-m-d H:i:s'));
        $this->db->insert('reports');

        return $this->db->insert_id();
    }

    public function update($id, $data) {
        // TODO actualizar filtro
        $filter = array('paidOut','ticketExitStatus','registered');
        db_mapping_and_set($this->db, $data, $filter);
        $this->db->where(array('id' => $id));
        return $this->db->update('reports');
    }

    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete('reports');
    }
}
