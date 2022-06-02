<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Clients_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function find_by_id($id = null)
    {
        if ($id == null) {
            return null;
        }
        $query = $this->db->get_where('clients', array('id' => $id));
        return $query->num_rows() == 1 ? $query->row() : null;
    }

    public function find_first($filter = array())
    {
        if ($filter == null) {
            return null;
        }
        $query = $this->db->get_where('clients', $filter);
        return $query->num_rows() > 0 ? $query->row() : null;
    }

    public function find($filter = null)
    {
        if ($filter) {
            $query = $this->db->get_where('clients', $filter);
        } else {
            $query = $this->db->get('clients');
        }

        return $query->result();
    }
    public function insert($data)
    {
        $filter = array('name', 'username', 'phone', 'email', 'description', 
        'clientType','rfid','rate','vehicleType','active','expire');
        db_mapping_and_set($this->db, $data, $filter);

        $this->db->insert('clients');

        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        if ($id == null) {
            return null;
        }
        $filter = array('name', 'phone', 'email', 'description', 'clientType',
        'rfid','ticketId','ticketCode','readerType','rate','vehicleType','active','expire');
        db_mapping_and_set($this->db, $data, $filter);
        $this->db->where(array('id' => $id));
        return $this->db->update('clients');
    }

    public function delete($id)
    {
        if ($id == null) {
            return null;
        }
        $this->db->where('id', $id);
        return $this->db->delete('clients');
    }
}
