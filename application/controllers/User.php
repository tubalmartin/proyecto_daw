<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->helper(['url']);
        $this->checkSession();
    }

    private function checkSession() {
        if (is_null($this->session->userdata('user_id'))) {
            redirect('/site/logout');
        }
    }

    public function index() {
        echo('User area');
    }
}