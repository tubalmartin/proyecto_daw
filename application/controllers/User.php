<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->helper(['url']);

        $this->checkSession();

        $this->load->library('form_validation');
        $this->load->model('User_model', 'user');
        $this->load->model('Order_model', 'order');
    }

    private function checkSession() {
        if (is_null($this->session->userdata('user_id'))) {
            redirect('/site/logout');
        }
    }

    public function index() {
        $user = $this->user->getById($this->session->userdata('user_id'));
        $this->load->view('base', [
            'view' => 'user/personal_data',
            'data' => [
                'page_id' => 'account',
                'subpage_id' => 'personal_data',
                'user' => $user
            ]
        ]);
    }

    public function edit() {
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('name', 'Nombre', 'required');
        $this->form_validation->set_rules('surname', 'Apellidos', 'required');
        $this->form_validation->set_rules('phone', 'Teléfono', 'required|min_length[9]|max_length[12]');
        $this->form_validation->set_rules('address', 'Dirección', 'required');
        $this->form_validation->set_rules('postal_code', 'Código postal', 'required|min_length[5]|max_length[5]');
        $this->form_validation->set_rules('city', 'Ciudad', 'required');

        if ($this->form_validation->run() === FALSE) {
            $user = $this->user->getById($this->session->userdata('user_id'));
            $this->load->view('base', [
                'view' => 'user/edit_personal_data',
                'data' => [
                    'page_id' => 'account',
                    'subpage_id' => 'personal_data',
                    'user_form' => [
                        'action' => '/user/edit',
                        'registration_form' => false,
                        'attributes' => []
                    ],
                    'user' => $user
                ]
            ]);
        } else {
            if ($this->user->update($this->session->userdata('user_id'), $this->input->post())){
                $this->session->set_flashdata('success_message', 'Datos actualizados correctamente');
                redirect('/user');
            } else {
                $this->session->set_flashdata('error_message', 'Ups, no se pudieron actualizar sus datos');
                redirect('/user/edit');
            }
        }
    }

    public function orders() {
        $orders = $this->order->getByUser($this->session->userdata('user_id'));
        $this->load->view('base', [
            'view' => 'user/orders',
            'data' => [
                'page_id' => 'account',
                'subpage_id' => 'orders',
                'orders' => $orders,
            ]
        ]);
    }

    public function order($id) {
        $order = $this->order->getById($id);
        $orderItems = $this->order->getItems($id);
        $this->load->view('base', [
            'view' => 'user/order',
            'data' => [
                'page_id' => 'account',
                'subpage_id' => 'orders',
                'order' => $order,
                'order_items' => $orderItems
            ]
        ]);
    }
}