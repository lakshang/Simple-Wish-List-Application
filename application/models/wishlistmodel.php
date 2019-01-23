<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of wishlistmodel
 *
 * @author laksh
 */
class wishlistmodel extends CI_Model {

    //put your code here

    private $table = "list";

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function getItems($owner_id) {
        $this->db->select('id,title,url,price,owner_id');
        $this->db->from($this->table);
        $this->db->where('owner_id', $owner_id);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    public function addItem($data) {
        if ($this->db->insert($this->table, $data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deleteItem($data) {
        $this->db->where('item_id', $data['item_id']);
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

    public function allItems() {
        $this->db->select("*");
        $this->db->from($this->table);

        $res = $this->db->get();
        return $res->result();
        
    }

}
