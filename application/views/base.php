<?php

$this->load->view('common/html_start');
$this->load->view('common/header');
$this->load->view($view, $data);
$this->load->view('common/footer');
$this->load->view('common/html_end');