<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class list_controller extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('test_model');
        $this->load->model('login_model');
    }

    public function Item_get() {
        $id = $_COOKIE['user_id'];
        if (!$id) {
            $this->response("id not specified", 400);
            exit;
        }

        $result = $this->test_model->allItems($id);
//        $nextId = $this->test_model->nextId();

        if ($result) {
//            $id__ = $nextId[0];
//            echo ($id__['auto_increment']);
            $this->response($result, 200);

            exit;
        } else {
            $this->response("Invalid Id", 404);
            exit;
        }
    }

    public function Item_post() {
        $title = $this->post('title');
        $url = $this->post('url');
        $price = $this->post('price');
        $priority = $this->post('priority');
        $user_id = $this->post('user_id');

        if (!$title || !$url || !$price || !$priority || !$user_id) {
            $this->response("Info Error", 400);
        } else {
            $result = $this->test_model->addItem(array("title" => $title, "url" => $url, "price" => $price, "priority" => $priority, "user_id" => $user_id));

            if ($result === 0) {
                $this->response("Item couldn't be added to list.", 400);
            } else {
                $this->response("success", 200);
                echo json_encode($result);
            }
        }
    }

    public function Item_delete($id) {
        if (!$id) {
            $this->response("Parameter missing", 400);
        }

        if ($this->test_model->deleteItem($id)) {
            $this->response("success", 200);
        } else {
            $this->response("failed", 404);
        }
    }

    public function Item_put() {
        $id = $this->put('id');
        $priority = $this->put('priority');

        if (!$id || !$priority) {
            $this->response("Please enter a description to update", 400);
        } else {
            $result = $this->test_model->updateItem($id, array("priority" => $priority));
            if ($result === 0) {
                $this->response("Falied to save information, Try again.", 404);
            } else {
                $this->response("success", 200);
            }
        }
    }

}
