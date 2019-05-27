<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->library(['session', 'cart']);
        $this->cart->product_name_rules = '\w \-\.\,\:\(\)';

        $this->load->helper(['url', 'date', 'text', 'form']);

        //if (ENVIRONMENT !== 'production') {
          //  $this->output->enable_profiler(TRUE);
        //}
    }

    protected function isUserLoggedIn() {
        return !is_null($this->session->userdata('user_id'));
    }
}