<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of login_model
 *
 * @author laksh
 */
class login_model extends CI_Model {

    private $table = "user";

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function register($data) {
        if ($this->db->insert($this->table, $data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function login($username, $password) {
        $this->db->select('username,password');
        $this->db->from($this->table);
        $this->db->where('username', $username);
        $this->db->where('password', $password);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
