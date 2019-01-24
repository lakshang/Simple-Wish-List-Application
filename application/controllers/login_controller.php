<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class login_controller extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('login_model');
    }

    public function user_post() {
        $username = $this->post('username');
        $password = $this->post('password');
        $name = $this->post('name');
        $descrip = $this->post('descrip');
        if (!$username || !$password || !$name || !$descrip) {
            $this->response("Info Error", 400);
        } else {
            $result = $this->login_model->register(array("username" => $username, "password" => $password, "name" => $name, "description" => $descrip));

            if ($result === 0) {
                $this->response("registration failed", 400);
            } else {
                $result_id = $this->login_model->user_id($username);
                $result_wishlist = $this->login_model->create_wishlist(array("user_id" => $result_id));
                $this->response("registration successful", 200);
                echo json_encode($result, $result_wishlist);
            }
        }
    }

    public function userLogin_post() {

        $username = $this->post('username');
        $password = $this->post('password');

        if (!$username || !$password) {
            $this->response("enter credentails", 400);
        } else {
            $result = $this->login_model->login($username, $password);
            if ($result === FALSE) {
                $this->response("invalid credentails, Try again.", 404);
            } else {
                $result_id = $this->login_model->user_id($username);
                $this->session->set_userdata('user_id', $result_id);
                $this->session->set_userdata('username', $username);
                $this->response("success", 200);
            }
        }
    }

}
