<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class index_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('test_model');
    }

    public function index() {
        $this->load->view('login');
    }

    public function wishlist() {
        $this->load->view('test');
    }

    public function logout() {
        setcookie('user_id', null, -1, '/');
        setcookie('username', null, -1, '/');
        redirect(base_url());
    }

}
