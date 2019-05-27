<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->helper(['url']);

        $this->checkSession();

        $this->load->library('form_validation');
    }

    private function checkSession() {
        if (is_null($this->session->userdata('user_id')) OR $this->session->userdata('is_admin') === FALSE) {
            redirect('/site/logout');
        }
    }

    public function index() {
        $this->orders();
    }

    public function orders() {
        $this->load->model('Order_model', 'order');
        $orders = $this->order->getAll();
        $this->load->view('base', [
            'view' => 'admin/orders',
            'data' => [
                'page_id' => 'account',
                'subpage_id' => 'orders',
                'orders' => $orders,
            ]
        ]);
    }

    public function order($orderId) {
        $this->load->model('Order_model', 'order');
        $order = $this->order->getById($orderId);
        $orderItems = $this->order->getItems($orderId);
        $this->load->view('base', [
            'view' => 'admin/order',
            'data' => [
                'page_id' => 'account',
                'subpage_id' => 'orders',
                'order' => $order,
                'order_items' => $orderItems
            ]
        ]);
    }

    public function deliverorder() {
        $orderId = $this->input->post('id');
        $this->load->model('Order_model', 'order');
        if ($this->order->setAsDelivered($orderId)) {
            $this->session->set_flashdata('success_message', 'Pedido marcado como enviado correctamente');
            redirect('/admin/orders');
        } else {
            $this->session->set_flashdata('error_message', 'Ups, no se pudo marcar el pedido como enviado');
            redirect('/admin/order/'.$orderId);
        }
    }

    public function storeitems() {
        $this->load->model('Item_model', 'item');

        $items = $this->item->getAll();

        $this->load->view('base', [
            'view' => 'admin/items',
            'data' => [
                'page_id' => 'account',
                'subpage_id' => 'storeitems',
                'items' => $items
            ]
        ]);
    }

    public function registermovie() {
        $this->load->model('MovieDb_model', 'moviedb');
        $this->load->model('Movie_model', 'movie');
        $this->form_validation->set_rules('id', 'Película', 'required');
        $this->form_validation->set_rules(
            'movie', 'película',
            [
                ['registered_movie', function() {
                    if ($this->movie->isRegistered($this->input->post('id'))) {
                        $this->form_validation->set_message('registered_movie', 'La {field} seleccionada ya está registrada');
                        return false;
                    } else {
                        return true;
                    }
                }]
            ]
        );

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('base', [
                'view' => 'admin/register_movie',
                'data' => [
                    'page_id' => 'account',
                    'subpage_id' => 'storeitems',
                    'search_form' => [
                        'action' => 'admin/asyncsearchmovies',
                        'attributes' => [
                            'data-async' => true,
                            'data-results-type' => 'movie',
                            'data-results-dropdown' => '#movie',
                        ]
                    ],
                ]
            ]);
        } else {
            $id = (int) $this->input->post('id');
            $movieData = $this->moviedb->getMovie($id);

            if ($this->movie->create($id, $movieData)) {
                $this->session->set_flashdata('success_message', 'Película registrada correctamente');
                redirect('/admin/createitem/'.$id);
            } else {
                $this->session->set_flashdata('error_message', 'Ups, no se pudo registrar la película. Inténtalo de nuevo.');
                redirect('/admin/registermovie');
            }
        }
    }

    public function createitem($id) {
        $this->edititem($id);
    }

    public function edititem($id) {
        $this->load->model('Item_model', 'item');
        $this->load->model('Movie_model', 'movie');

        $this->form_validation->set_rules('dvdprice', 'Precio DVD', 'numeric|greater_than[0]');
        $this->form_validation->set_rules('blurayprice', 'Precio Blu-Ray', 'numeric|greater_than[0]');
        $this->form_validation->set_rules(
            'price', 'precio',
            [
                ['valid_price', function() {
                    if (empty($this->input->post('dvdprice')) && empty($this->input->post('blurayprice'))) {
                        $this->form_validation->set_message('valid_price', 'Debe indicar al menos el {field} de un formato');
                        return false;
                    } else {
                        return true;
                    }
                }]
            ]
        );

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('base', [
                'view' => 'admin/edit_item',
                'data' => [
                    'page_id' => 'account',
                    'subpage_id' => 'storeitems',
                    'movie' => $this->movie->getById($id),
                    'prices' => $this->item->getPricesByMovieId($id)
                ]
            ]);
        } else {
            $dvdPrice = $this->input->post('dvdprice');
            $bluRayPrice = $this->input->post('blurayprice');
            $doesItemExist = $this->item->doesExist($id);
            $action = $doesItemExist ? 'actualizada' : 'publicada';

            if ($this->item->save($id, $dvdPrice, $bluRayPrice)) {
                $this->session->set_flashdata('success_message', "Película $action correctamente");
                redirect('/admin/storeitems');
            } else {
                $this->session->set_flashdata('error_message', "Ups, no se pudo $action la película. Inténtalo de nuevo.");
                redirect('/admin/createitem/'.$id);
            }
        }
    }

    public function asyncsearchmovies() {
        $this->load->model('MovieDb_model', 'moviedb');
        $this->output->enable_profiler(FALSE);
        $query = $this->input->post('query');
        $response = $this->moviedb->getSearchResults($query, 1);
        $results = [];

        if (!empty($response['results'])) {
            foreach($response['results'] as $result) {
                $results[] = $result;
            }
        }

        echo json_encode($results);
    }
}