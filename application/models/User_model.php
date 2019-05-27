<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
    }

    public function get($where = [], $multipleRows = false) {
        $this->db
            ->select('users.id, users.email, users.name, users.surname, user_types.name as type, users.address, users.city, users.postal_code, users.phone')
            ->from('users')
            ->join('user_types', 'user_types.id = users.type_id');

        if (!empty($where)) {
            $this->db->where($where);
        }

        $query = $this->db
            ->order_by('users.id')
            ->get();

        return $query->num_rows() > 1 || $multipleRows === true
                ? $query->result_array()
                : $query->row_array();
    }

    public function getById($id) {
        return $this->get(['users.id' => (int) $id]);
    }

    public function getByCredentials($email, $password) {
        return $this->get(['users.email' => $email, 'users.password' => md5($password)]);
    }

    public function isRegistered($email, $password) {
        $user = $this->getByCredentials($email, $password);
        return !empty($user);
    }

    public function isEmailRegistered($email) {
        $user = $this->get(['users.email' => $email]);
        return !empty($user);
    }

    public function create($data) {
        $data['password'] = md5($data['password']);
        $data['type_id'] = USER_TYPE_ID;
        return $this->db->insert('users', $data);
    }

    public function update($userId, $userData) {
        return $this->db->update('users', $userData, ['id' => $userId]);
    }
}