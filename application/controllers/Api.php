<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Api
 *
 * @author laksh
 */
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Api extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('wishlistmodel');
        $this->load->model('login_model');
    }

    function index_get() {
        $this->data['list'] = $this->wishlistmodel->allItems();
        $this->load->view('home', $this->data);
    }

    function viewItems_get() {
        $owner_id = $this->get('owner_id');

        if (!$owner_id) {
            $this->response("No owner id found", 400);
            exit;
        }

        $result = $this->wishlistmodel->getItems($owner_id);

        if ($result) {
            $this->response($result, 200);
            exit;
        } else {
            $this->response("Invalid Owner ID", 404);
            exit;
        }
    }

    function addItems_post() {
        $title = $this->post('title');
        $url = $this->post('url');
        $price = $this->post('price');
        $descrip = $this->post('descrip');
        $owner_id = $this->post('owner_id');

        if (!$title || !$url || !$price || !$owner_id) {
            $this->response("Info Error", 400);
        } else {
            $result = $this->wishlistmodel->addItem(array("title" => $title, "descrip" => $descrip, "url" => $url, "price" => $price, "owner_id" => $owner_id));

            if ($result === 0) {
                $this->response("Item couldn't be added to list.", 400);
            } else {
                $this->response("success", 200);
                echo json_encode($result);
            }
        }
    }

    function deleteItem_delete() {
        $id = $this->delete('id');

        if (!$id) {
            $this->response("Parameter missing", 400);
        }

        if ($this->wishlistmodel->deleteItem($id)) {
            $this->response("success", 200);
        } else {
            $this->response("failed", 404);
        }
    }

    function updateItem_put() {

        $id = $this->put('id');
        $descrip = $this->put('descrip');

        if (!$descrip || !$id) {
            $this->response("Please enter a description to update", 400);
        } else {
            $result = $this->wishlistmodel->updateItem($id, array("descrip" => $descrip));
            if ($result === 0) {
                $this->response("Falied to save information, Try again.", 404);
            } else {
                $this->response("success", 200);
            }
        }
    }

    function resgister_post() {

        $username = $this->post('username');
        $password = $this->post('password');

        if (!$username || !$password) {
            $this->response("enter credentails", 400);
        } else {
            $result = $this->login_model->register(array("username" => $username, "password" => $password));
            if ($result === FALSE) {
                $this->response("invalid credentails, Try again.", 404);
            } else {
                $this->response("success", 200);
            }
        }
    }

    function login_post() {

        $username = $this->post('username');
        $password = $this->post('password');

        if (!$username || !$password) {
            $this->response("enter credentails", 400);
        } else {
            $result = $this->login_model->login($username, $password);
            if ($result === FALSE) {
                $this->response("invalid credentails, Try again.", 404);
            } else {
                $this->response("success", 200);
            }
        }
    }

}
