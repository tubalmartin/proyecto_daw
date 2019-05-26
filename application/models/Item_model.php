<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
    }

    public function get($where = []) {
        $this->db
            ->select('items.id, items.movie_id, items.price, items.format_id, item_formats.name as format_name, movies.name, movies.image, movies.release_date')
            ->from('items')
            ->join('item_formats', 'item_formats.id = items.format_id')
            ->join('movies', 'movies.id = items.movie_id');

        if (!empty($where)) {
            $this->db->where($where);
        }

        $query = $this->db
            ->order_by('movies.release_date')
            ->get();

        return $query->num_rows() > 1
            ? $query->result_array()
            : $query->row_array();
    }

    public function getById($id) {
        return $this->get(['items.id' => (int) $id]);
    }

    public function getAllByFormat($format) {
        return $this->get(['format_id' => $format === 'bluray' ? BLURAY_FORMAT_ID : DVD_FORMAT_ID]);
    }

    public function getPricesByMovieId($movieId) {
        $dvdQuery = $this->db->get_where('items', ['movie_id' => $movieId, 'format_id' => DVD_FORMAT_ID]);
        $bluRayQuery = $this->db->get_where('items', ['movie_id' => $movieId, 'format_id' => BLURAY_FORMAT_ID]);

        return [
            'dvd' => $dvdQuery->num_rows() > 0 ? $dvdQuery->row_array()['price'] : '',
            'bluray' => $bluRayQuery->num_rows() > 0 ? $bluRayQuery->row_array()['price'] : ''
        ];
    }

    public function doesExist($movieId) {
        return !is_null($this->getIdByMovieId($movieId));
    }

    public function getIdByMovieId($movieId, $where = []) {
        $this->db
            ->select('id')
            ->from('items')
            ->where('movie_id', $movieId);

        if (!empty($where)) {
            $this->db->where($where);
        }

        $r = $this->db->get();

        return $r->num_rows() > 0
            ? $r->row()->id
            : null;
    }

    public function save($movieId, $dvdPrice, $bluRayPrice) {
        $dvdId = $this->getIdByMovieId($movieId, ['format_id' => DVD_FORMAT_ID]);
        $bluRayId = $this->getIdByMovieId($movieId, ['format_id' => BLURAY_FORMAT_ID]);
        $dvdData = [
            'movie_id' => $movieId,
            'format_id' => DVD_FORMAT_ID,
            'price' => (float) $dvdPrice
        ];
        $bluRayData = [
            'movie_id' => $movieId,
            'format_id' => BLURAY_FORMAT_ID,
            'price' => (float) $bluRayPrice
        ];

        $q1 = is_null($dvdId)
            ? $this->insert($dvdData)
            : $this->update($dvdId, $dvdData['price']);

        $q2 = is_null($bluRayId)
            ? $this->insert($bluRayData)
            : $this->update($bluRayId, $bluRayData['price']);

        return $q1 && $q2;
    }

    private function insert($data) {
        return $this->db->insert('items', $data);
    }

    private function update($itemId, $price) {
        return $this->db->update('items', ['price' => $price], ['id' => $itemId]);
    }
}