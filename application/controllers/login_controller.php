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

        if (!$username || !$password) {
            $this->response("Info Error", 400);
        } else {
            $result = $this->login_model->register(array("username" => $username, "password" => $password));

            if ($result === 0) {
                $this->response("registration failed", 400);
            } else {
                $this->response("registration successful", 200);
                echo json_encode($result);
            }
        }
    }

}
