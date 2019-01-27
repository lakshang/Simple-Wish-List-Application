<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class test_model extends CI_Model {

    private $table = "list";

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function allItems($user_id) {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('user_id', $user_id);
        $res = $this->db->order_by('priority', 'ASC')->get();
        return $res->result();
    }

    public function addItem($data) {
        if ($this->db->insert($this->table, $data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deleteItem($id) {
        $this->db->where('id', $id);
        if ($this->db->delete($this->table)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function updateItem($id, $data) {
        $this->db->where('id', $id);
        if ($this->db->update($this->table, $data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function nextId() {
        $query = $this->db->query("SELECT `auto_increment` FROM INFORMATION_SCHEMA.TABLES
WHERE TABLE_NAME = 'list'");
        $result = $query->result_array();
        return $result;
    }

}
