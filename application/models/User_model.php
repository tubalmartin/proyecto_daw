<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
    }

    public function isRegistered($email, $password) {
        $user = $this->getByCredentials($email, $password);
        return $user !== null;
    }

    public function getByCredentials($email, $password) {
        $md5Password = md5($password);
        $query = $this->db
            ->select('users.id, users.name, user_types.name as type')
            ->from('users')
            ->join('user_types', 'user_types.id = users.type_id')
            ->where(['email' => $email, 'password' => $md5Password])
            ->get();

        return $query->num_rows() > 0
            ? $query->row_array()
            : null;
    }

    public function create() {

    }

    public function update() {

    }
}