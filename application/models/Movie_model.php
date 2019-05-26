<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Movie_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
    }

    public function getById($id) {
        $query = $this->db->get_where('movies', ['id' => $id]);

        return $query->num_rows() > 0
            ? $query->row_array()
            : null;
    }

    public function isRegistered($id) {
        return is_array($this->getById($id));
    }

    public function create($id, $data) {
        return $this->db->insert('movies', [
            'id' => $id,
            'name' => $data['title'],
            'image' => $data['poster_path'],
            'release_date' => $data['release_date']
        ]);
    }
}