<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends MY_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('MovieDb_model', 'moviedb');
    }

	public function index() {
	    $this->nowplaying();
	}

	public function nowplaying($page = 1) {
        $response = $this->moviedb->getNowPlayingMovies($page);
        $this->initPagination('/site/nowplaying/', $response['total_pages']);
        $this->indexView($response['results'], 'home', 'nowplaying');
    }

    public function upcoming($page = 1) {
        $response = $this->moviedb->getUpcomingMovies($page);
        $this->initPagination('/site/upcoming/', $response['total_pages']);
        $this->indexView($response['results'], 'home','upcoming');
    }

    public function popular($page = 1) {
        $response = $this->moviedb->getPopularMovies($page);
        $this->initPagination('/site/popular/', $response['total_pages']);
        $this->indexView($response['results'], 'home','popular');
    }

    public function toprated($page = 1) {
        $response = $this->moviedb->getTopRatedMovies($page);
        $this->initPagination('/site/toprated/', $response['total_pages']);
        $this->indexView($response['results'], 'home','toprated');
    }

    private function initPagination($base_url, $total_pages, $config = []) {
        $this->load->library('pagination');
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
            'attributes' => ['class' => 'page-link']
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
                    'attributes' => []
                ],
                'movies' => $movies
            ]
        ]);
    }

	public function movie($id) {
        $movie = $this->moviedb->getMovie($id);
        $this->load->view('base', [
            'view' => 'site/movie',
            'data' => [
                'page_id' => 'home',
                'search_form' => [
                    'action' => 'site/search',
                    'attributes' => []
                ],
                'movie' => $movie
            ]
        ]);
    }

    public function person($id) {
        $person = $this->moviedb->getPerson($id);
        $this->load->view('base', [
            'view' => 'site/person',
            'data' => [
                'page_id' => 'home',
                'search_form' => [
                    'action' => 'site/search',
                    'attributes' => []
                ],
                'person' => $person
            ]
        ]);
    }

	public function search($query = '', $page = 1) {
        $queryPost = $this->input->post('query');

        if (!is_null($queryPost)) {
            $query = $queryPost;
        }

        $response = $this->moviedb->getSearchResults($query, $page);
        $this->initPagination('/site/search/'.$query.'/', $response['total_pages'], ['uri_segment' => 4]);
        $this->load->view('base', [
            'view' => 'site/search',
            'data' => [
                'page_id' => 'home',
                'search_form' => [
                    'action' => 'site/search',
                    'attributes' => []
                ],
                'results' => $response['results']
            ]
        ]);
    }

    public function login() {
        $this->load->library('form_validation');
        $this->load->model('User_model', 'user');

        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Contraseña', 'required');
        $this->form_validation->set_rules(
            'user', 'email y/o contraseña',
            [
                ['valid_user', function() {
                    if ($this->user->isRegistered($this->input->post('email'), $this->input->post('password'))) {
                        return true;
                    } else {
                        $this->form_validation->set_message('valid_user', 'El {field} introducido es incorrecto');
                        return false;
                    }
                }]
            ]
        );

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('base', [
                'view' => 'site/login',
                'data' => [
                    'page_id' => 'login'
                ]
            ]);
        } else {
            $this->_login($this->input->post('email'), $this->input->post('password'));
        }
    }

    private function _login($email, $pass) {
        $user = $this->user->getByCredentials($email, $pass);
        $this->session->set_userdata([
            'is_admin' => $user['type'] === 'admin',
            'user_id' => $user['id'],
            'user_name' => $user['name'],
            'user_type' => $user['type']
        ]);
        $redirectUri = !is_null($this->session->userdata('post_login_url'))
            ? $this->session->userdata('post_login_url')
            : '/site';

        redirect($redirectUri);
    }

    public function logout() {
        $_SESSION = [];

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        $this->session->sess_destroy();

        $this->index();
    }

    public function register() {
        $this->load->library('form_validation');
        $this->load->model('User_model', 'user');

        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('name', 'Nombre', 'required');
        $this->form_validation->set_rules('surname', 'Apellidos', 'required');
        $this->form_validation->set_rules('phone', 'Teléfono', 'required|min_length[9]|max_length[12]');
        $this->form_validation->set_rules('address', 'Dirección', 'required');
        $this->form_validation->set_rules('postal_code', 'Código postal', 'required|min_length[5]|max_length[5]');
        $this->form_validation->set_rules('city', 'Ciudad', 'required');
        $this->form_validation->set_rules(
            'user', 'usuario',
            [
                ['valid_user', function() {
                    if ($this->user->isEmailRegistered($this->input->post('email'))) {
                        $this->form_validation->set_message('valid_user', 'El {field} introducido ya está registrado');
                        return false;
                    } else {
                        return true;
                    }
                }]
            ]
        );

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('base', [
                'view' => 'site/register',
                'data' => [
                    'page_id' => 'register',
                    'user_form' => [
                        'action' => '/site/register',
                        'registration_form' => true,
                        'attributes' => [],
                        'submit_button_text' => 'Registrarse'
                    ],
                    'user' => []
                ]
            ]);
        } else {
            if ($this->user->create($this->input->post())){
                $this->session->set_flashdata('success_message', 'Usuario registrado correctamente');
                $this->_login($this->input->post('email'), $this->input->post('password'));
            } else {
                $this->session->set_flashdata('error_message', 'Ups, no se pudo completar el registro');
                redirect('/site/register');
            }
        }
    }

    public function store($format = 'bluray') {
        $this->load->model('Item_model', 'item');

        $items = $this->item->getAllByFormat($format);

        $this->load->view('base', [
            'view' => 'site/store',
            'data' => [
                'page_id' => 'store',
                'subpage_id' => $format,
                'items' => $items
            ]
        ]);
    }

    public function addtocart() {
        $this->load->model('Item_model', 'item');

        if (empty($this->input->post('id'))) {
            redirect('/site/store');
        }

        $itemId = $this->input->post('id');
        $item = $this->item->getById($itemId);

        if ($this->cart->insert([
            'id' => $itemId,
            'qty' => $this->input->post('qty'),
            'price' => $item['price'],
            'name' => $item['name'],
            'image' => $item['image'],
            'format' => $item['format_name'],
            'movie_id' => $item['movie_id']
        ])) {
            $this->session->set_flashdata('success_message', "Película añadida a la cesta correctamente");
        } else {
            $this->session->set_flashdata('error_message', "Ups, no se pudo añadir la película a la cesta");
        }

        redirect('/site/store');
    }

    public function cart() {
        $this->load->view('base', [
            'view' => 'site/cart',
            'data' => [
                'page_id' => 'cart'
            ]
        ]);
    }

    public function updatecart() {
        if ($this->cart->update([
            'rowid' => $this->input->post('rowid'),
            'qty' => $this->input->post('qty')
        ])) {
            $this->session->set_flashdata('success_message', "Cesta actualizada correctamente");
        } else {
            $this->session->set_flashdata('error_message', "Ups, no se pudo actualizar la cesta");
        }

        redirect('/site/cart');
    }

    public function checkout() {
        if ($this->isUserLoggedIn()) {
            $this->load->model('User_model', 'user');
            $this->session->unset_userdata('post_login_url');
            $user = $this->user->getById($this->session->userdata('user_id'));

            $this->load->view('base', [
                'view' => 'site/checkout',
                'data' => [
                    'page_id' => 'store',
                    'user' => $user
                ]
            ]);
        } else {
            $this->session->set_flashdata('warn_message', 'Debes iniciar sesión o <a href="'.site_url('/site/register').'">registrarte</a> para continuar');
            $this->session->set_userdata('post_login_url', '/site/checkout');
            redirect('/site/login');
        }
    }

    public function order() {
        if ($this->isUserLoggedIn()) {
            $this->load->model('Order_model', 'order');
            if ($this->order->create([
                'user_id' => $this->session->userdata('user_id'),
                'items' => $this->cart->contents(),
                'total' => $this->cart->total()
            ])) {
                $this->session->set_flashdata('success_message', "Pedido realizado correctamente");
                $this->cart->destroy();
                redirect('/user/orders');
            } else {
                $this->session->set_flashdata('error_message', "Ups, no se pudo realizar el pedido");
                redirect('/site/checkout');
            }
        } else {
            $this->session->set_userdata('post_login_url', '/site/checkout');
            $this->login();
        }
    }
}
