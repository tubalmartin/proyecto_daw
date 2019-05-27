<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
    }

    public function get($where = [], $multipleRows = false) {
        $this->db
            ->select('orders.*, users.name as user_name, users.surname as user_surname, order_statuses.name as status')
            ->from('orders')
            ->join('order_statuses', 'order_statuses.id = orders.status_id')
            ->join('users', 'users.id = orders.user_id');

        if (!empty($where)) {
            $this->db->where($where);
        }

        $query = $this->db
            ->order_by('orders.date', 'desc')
            ->get();

        return $query->num_rows() > 1 || $multipleRows === true
                ? $query->result_array()
                : $query->row_array();
    }

    public function getItems($orderId, $where =[]) {
        $this->db
            ->select('order_items.*, item_formats.name as movie_format, movies.id as movie_id, movies.name as movie_name, movies.image as movie_image')
            ->from('order_items')
            ->join('items', 'order_items.item_id = items.id')
            ->join('item_formats', 'items.format_id = item_formats.id')
            ->join('movies', 'items.movie_id = movies.id')
            ->where(['order_items.order_id' => (int) $orderId]);

        if (!empty($where)) {
            $this->db->where($where);
        }

        $query = $this->db
            ->order_by('order_items.order_id')
            ->get();

        return $query->result_array();
    }

    public function getById($orderId) {
        return $this->get(['orders.id' => (int) $orderId]);
    }

    public function getAll() {
        return $this->get();
    }

    public function getItemsById($orderId) {
        return $this->get(['order_items.order_id' => (int) $orderId], true);
    }

    public function getByUser($userId) {
        return $this->get(['orders.user_id' => (int) $userId], true);
    }

    public function create($data) {

        $orderCreated = $this->db->insert('orders', [
            'user_id' => (int) $data['user_id'],
            'status_id' => ORDER_PENDING_DELIVERY_ID,
            'total_price' => (float) $data['total']
        ]);

        if ($orderCreated !== true) {
            return false;
        }

        $orderId = $this->db->insert_id();

        $orderItemsRecorded = [];

        foreach ($data['items'] as $item) {
            $orderItemsRecorded[] = $this->db->insert('order_items', [
                'order_id' => (int) $orderId,
                'item_id' => (int) $item['id'],
                'item_qty' => (int) $item['qty'],
                'item_price' => (float) $item['price']
            ]);
        }

        return !in_array(false, $orderItemsRecorded);
    }

    public function setAsDelivered($orderId) {
        return $this->db->update('orders', ['status_id' => ORDER_DELIVERED_ID], ['id' => (int) $orderId]);
    }
}