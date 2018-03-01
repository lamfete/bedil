<?php
if(!defined('BASEPATH')) exit('Hacking Attempt');

class M_login extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_login($username, $password, $status) {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('user_login', $username);
        $this->db->where('password', $password);
        $this->db->where('status', $status);

        $query = $this->db->get();

        return $query->num_rows();
    }

    public function get_user_level($username, $password) {
        $this->db->select('user_level_id');
        $this->db->from('user');
        $this->db->where('user_login', $username);
        $this->db->where('password', $password);

        $query = $this->db->get();

        return $query->row();
    }

    public function get_name($username) {
        $this->db->select('user_login');
        $this->db->select('name');
        $this->db->select('user_id');
        $this->db->from('user');
        $this->db->where('user_login', $username);

        $query = $this->db->get();

        return $query->row();
    }
}
?>