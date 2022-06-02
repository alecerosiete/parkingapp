<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Profiles_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function find_by_id($id) {
        $query = $this->db->get_where('ms_users', array('id' => $id));
        return $query->num_rows() == 1 ? $query->row() : null;
    }

    public function find_first($filter = array()) {
        $query = $this->db->get_where('ms_users', $filter);
        return $query->num_rows() > 0 ? $query->row() : null;
    }

    public function find($filter = null) {
        if ($filter) {
            $query = $this->db->get_where('ms_users', $filter);
        } else {
            $query = $this->db->get('ms_users');
        }

        return $query->result();
    }

    public function find_with_groups($filter) {
        $this->db->select('*');
        $this->db->from('ms_users');
        $this->db->join('ms_groups', 'ms_users.usergroup = ms_groups.id');

        if ($filter) {
            $this->db->where($filter);
        }

        $query = $this->db->get();
        return $query->result();
    }

    public function find_active($username, $pw) {

        $this->db->select('*');
        $this->db->from('ms_users');
        $this->db->join('ms_groups', 'ms_users.usergroup = ms_groups.id');
        $this->db->where(array('username' => $username, 'userpass' => md5($pw), 'active' => 1));
        $query = $this->db->get();
        return $query->num_rows() == 1 ? $query->row() : null;
    }

    public function find_session($username) {
        $this->db->select('*');
        $this->db->from('ms_users');
        $this->db->join('ms_groups', 'ms_users.usergroup = ms_groups.id');
        $this->db->where(array('username' => $username, 'active' => 1));
        $query = $this->db->get();
        return $query->num_rows() == 1 ? $query->row() : null;
    }

    public function insert($data) {
        $filter = array('username', 'usergroup', 'fullname', 'phone','avatar');
        db_mapping_and_set($this->db, $data, $filter);
        $this->db->set('userpass', md5($data['userpass']));
        $this->db->set('active', 1);
        $this->db->set('registered', 'CURRENT_TIMESTAMP', false);
        $this->db->set('last_update', 'CURRENT_TIMESTAMP', false);

        return $this->db->insert('ms_users');
    }

    public function update($data) {
        $filter = array('usergroup', 'fullname', 'phone','avatar');
        db_mapping_and_set($this->db, $data, $filter);
        $this->db->set('last_update', 'CURRENT_TIMESTAMP', false);

        $this->db->where('id', $data['id']);

        return $this->db->update('ms_users');
    }

    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete('ms_users');
    }

    public function update_mypass($id, $oldpass, $newpass) {
        $this->db->set('userpass', md5($newpass));
        $this->db->set('last_update', 'CURRENT_TIMESTAMP', false);
        $this->db->where(array('username' => $id, 'userpass' => md5($oldpass)));

        return $this->db->update('ms_users');
    }

    public function change_password($id, $newpass) {
        $this->db->set('userpass', md5($newpass));
        $this->db->set('last_update', 'CURRENT_TIMESTAMP', false);
        $this->db->where(array('id' => $id));

        return $this->db->update('ms_users');
    }

    public function update_userpass($username, $newpass) {

        $this->db->set('userpass', md5($newpass));
        $this->db->set('last_update', 'CURRENT_TIMESTAMP', false);
        $this->db->where('username', $username);
        return $this->db->update('ms_users');
    }

}
