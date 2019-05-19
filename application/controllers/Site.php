<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->library('pagination');
        $this->load->helper('url');
        $this->load->helper('date');
        $this->load->helper('text');
        $this->load->model('MovieDb_model');
    }

	public function index()
	{
	    $this->nowplaying();
	}

	public function nowplaying($page = 1) {
        $response = $this->MovieDb_model->getNowPlayingMovies($page);
        $this->initPagination('/site/nowplaying/', $response['total_pages']);
        $this->indexView($response['results'], 'home', 'nowplaying');
    }

    public function upcoming($page = 1) {
        $response = $this->MovieDb_model->getUpcomingMovies($page);
        $this->initPagination('/site/upcoming/', $response['total_pages']);
        $this->indexView($response['results'], 'home','upcoming');
    }

    public function popular($page = 1) {
        $response = $this->MovieDb_model->getPopularMovies($page);
        $this->initPagination('/site/popular/', $response['total_pages']);
        $this->indexView($response['results'], 'home','popular');
    }

    public function toprated($page = 1) {
        $response = $this->MovieDb_model->getTopRatedMovies($page);
        $this->initPagination('/site/toprated/', $response['total_pages']);
        $this->indexView($response['results'], 'home','toprated');
    }

    private function initPagination($base_url, $total_pages, $config = []) {
        $this->pagination->initialize(array_merge([
            'base_url' => site_url($base_url),
            'use_page_numbers' => true,
            'total_rows' => $total_pages,
            'per_page' => 1,
            'full_tag_open' => '<nav class="d-inline-block"><ul class="pagination">',
            'full_tag_close' => '</ul></nav>',
            'first_link' => 'Primero',
            'first_tag_open' => '<li class="page-item">',
            'first_tag_close' => '</li>',
            'last_link' => 'Último',
            'last_tag_open' => '<li class="page-item">',
            'last_tag_close' => '</li>',
            'next_link' => 'Siguiente &raquo;',
            'next_tag_open' => '<li class="page-item">',
            'next_tag_close' => '</li>',
            'prev_link' => 'Anterior &laquo;',
            'prev_tag_open' => '<li class="page-item">',
            'prev_tag_close' => '</li>',
            'num_tag_open' => '<li class="page-item">',
            'num_tag_close' => '</li>',
            'cur_tag_open' => '<li class="page-item active"><a class="page-link" href="#">',
            'cur_tag_close' => '</a></li>',
            'attributes' => array('class' => 'page-link')
        ], $config));
    }

    private function indexView($movies, $page_id, $subpage_id) {
        $this->load->view('base', [
            'view' => 'site/index',
            'data' => [
                'page_id' => $page_id,
                'subpage_id' => $subpage_id,
                'search_form' => [
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
                'page_id' => 'home',
                'search_form' => [
                    'action' => 'site/search',
                    'query' => ''
                ],
                'movie' => $movie
            ]
        ]);
    }

    public function person($id) {
        $person = $this->MovieDb_model->getPerson($id);
        $this->load->view('base', [
            'view' => 'site/person',
            'data' => [
                'page_id' => 'home',
                'search_form' => [
                    'action' => 'site/search',
                    'query' => ''
                ],
                'person' => $person
            ]
        ]);
    }

	public function search($query = '', $page = 1)
    {
        $queryPost = $this->input->post('query');

        if (!is_null($queryPost)) {
            $query = $queryPost;
        }

        $response = $this->MovieDb_model->getSearchResults($query, $page);
        $this->initPagination('/site/search/'.$query.'/', $response['total_pages'], ['uri_segment' => 4]);
        $this->load->view('base', [
            'view' => 'site/search',
            'data' => [
                'page_id' => 'home',
                'search_form' => [
                    'action' => 'site/search',
                    'query' => $query
                ],
                'results' => $response['results']
            ]
        ]);
    }
}
