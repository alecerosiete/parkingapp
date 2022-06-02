<?php

/*
 * CREATE TABLE pc_usergroups (
 *  id VARCHAR(20) PRIMARY KEY,
 *  name VARCHAR(100) NOT NULL,
 *  description TINYTEXT,
 *  role_pub_reports BOOLEAN DEFAULT FALSE,
 *  role_admin_campaigns BOOLEAN DEFAULT FALSE,
 *  role_campaign_approver BOOLEAN DEFAULT FALSE,
 *  role_priv_reports BOOLEAN DEFAULT FALSE,
 *  role_agent BOOLEAN DEFAULT FALSE,
 *  role_admin_companies BOOLEAN DEFAULT FALSE,
 *  role_admin_users BOOLEAN DEFAULT FALSE,
 *  role_admin_agents BOOLEAN DEFAULT FALSE,
 *  role_staff BOOLEAN DEFAULT FALSE,
 *  role_root BOOLEAN DEFAULT FALSE,
 *  registered TIMESTAMP,
 *  updated TIMESTAMP,
 *  UNIQUE (name)
 * ) CHARACTER SET utf8;
 * 
 */

class Usergroups_model extends CI_Model {

  function __construct() {
    parent::__construct();
  }

  /* queries */

  public function find_by_id($id) {
    $query = $this->db->get_where('ms_groups', array('id' => $id));
    return $query->num_rows() == 1 ? $query->row() : null;
  }

  public function find_first($filter = array()) {
    $query = $this->db->get_where('ms_groups', $filter);
    return $query->num_rows() > 0 ? $query->row() : null;
  }

  public function find($filter = null) {
    if ($filter) {
      $query = $this->db->get_where('ms_groups', $filter);
    } else {
      $query = $this->db->get('ms_groups');
    }

    return $query->result();
  }

  /* updates */

  public function insert($data) {
    $filter = array('id', 'name', 'description', 'role_pub_reports', 'role_admin_campaigns',
        'role_campaign_approver', 'role_priv_reports', 'role_admin_companies',
        'role_admin_users', 'role_agent', 'role_admin_agents', 'role_staff', 'role_root');
    db_mapping_and_set($this->db, $data, $filter);

    $this->db->set('registered', 'CURRENT_TIMESTAMP', false);
    $this->db->set('updated', 'CURRENT_TIMESTAMP', false);

    return $this->db->insert('ms_groups');
    
  }

  public function update($id, $data) {
    $filter = array('name', 'description', 'role_pub_reports', 'role_admin_campaigns',
        'role_campaign_approver', 'role_priv_reports', 'role_admin_companies',
        'role_admin_users', 'role_agent', 'role_admin_agents', 'role_staff', 'role_root');
    db_mapping_and_set($this->db, $data, $filter);
    $this->db->set('updated', 'CURRENT_TIMESTAMP', false);

    $this->db->where('id', $id);

    return $this->db->update('ms_groups');
  }

  public function delete($id) {
    $this->db->where('id', $id);
    return $this->db->delete('ms_groups');
  }

}
