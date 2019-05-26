<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->helper(['url']);
        $this->load->library('form_validation');
        $this->checkSession();
    }

    private function checkSession() {
        if (is_null($this->session->userdata('user_id')) OR $this->session->userdata('is_admin') === FALSE) {
            redirect('/site/logout');
        }
    }

    public function index() {
        $this->account();
    }

    public function account() {
        $this->orders();
    }

    public function orders() {
        $this->load->model('Order_model', 'order');
        $this->load->view('base', [
            'view' => 'admin/index',
            'data' => [
                'page_id' => 'account',
                'subpage_id' => 'orders'
            ]
        ]);
    }

    public function items() {
        //$this->load->model('Item_model', 'order');
        echo "ok";
    }

    public function users() {

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

        $this->form_validation->set_rules('dvdprice', 'Precio DVD', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('blurayprice', 'Precio Blu-Ray', 'required|numeric|greater_than[0]');

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
                redirect('/admin/items');
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