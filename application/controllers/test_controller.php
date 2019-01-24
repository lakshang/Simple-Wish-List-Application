<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class test_controller extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('test_model');
        $this->load->model('login_model');
    }

    public function Item_get() {
        $data = $this->test_model->allItems();
        json_encode($data);
        echo json_encode($data);
    }

    public function Item_post() {
        $title = $this->post('title');
        $url = $this->post('url');
        $price = $this->post('price');
        $priority = $this->post('priority');

        if (!$title || !$url || !$price || !$priority) {
            $this->response("Info Error", 400);
        } else {
            $result = $this->test_model->addItem(array("title" => $title, "url" => $url, "price" => $price, "priority" => $priority));

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
