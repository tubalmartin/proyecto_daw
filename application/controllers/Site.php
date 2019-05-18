<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->helper('url');
        $this->load->helper('date');
        $this->load->helper('text');
        $this->load->model('MovieDb_model');
    }

	public function index()
	{
	    $this->intheaters();
	}

	public function intheaters() {
        $movies = $this->MovieDb_model->getNowPlayingMovies();
        $this->indexView($movies);
    }

    public function upcoming() {
        $movies = $this->MovieDb_model->getUpcomingMovies();
        $this->indexView($movies);
    }

    private function indexView($movies) {
        $this->load->view('base', [
            'view' => 'site/index',
            'data' => [
                'moviedb_search_form' => [
                    'action' => 'site/search',
                    'query' => ''
                ],
                'movies' => $movies
            ]
        ]);
    }

	public function movie($id) {
        $movie = $this->MovieDb_model->getMovie($id);
        $this->load->view('base', [
            'view' => 'site/movie',
            'data' => [
                'movie' => $movie
            ]
        ]);
    }

    public function person($id) {

    }

	public function search()
    {
        $query = $this->input->post('query');
        $results = $this->MovieDb_model->getSearchResults($query);
        $this->load->view('base', [
            'view' => 'site/search',
            'data' => [
                'moviedb_search_form' => [
                    'action' => 'site/search',
                    'query' => $query
                ],
                'results' => $results
            ]
        ]);
    }
}
