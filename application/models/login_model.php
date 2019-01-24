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
    private $table_list = "wishlist";

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function register($data) { //username and password are params
        if ($this->db->insert($this->table, $data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function login($username, $password) {
        $this->db->select('user_id,username,password');
        $this->db->from($this->table);
        $this->db->where('username', $username);
        $this->db->where('password', $password);
        $query = $this->db->get();
        
        if ($query->num_rows() == 1) {
//            $userid = $this->db->get()->row()->user_id;
//            $username_ = $this->db->get()->row()->username;
//            $this->session->set_userdata('username', $username_);
//            $this->session->set_userdata('user_id', $userid);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function user_id($username) {
        $this->db->select('user_id');
        $this->db->from($this->table);
        $this->db->where('username', $username);
        $res = $this->db->get()->row()->user_id;
        return $res;
    }

    function create_wishlist($data) {
        if ($this->db->insert($this->table_list, $data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
