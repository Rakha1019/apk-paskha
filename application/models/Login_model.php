<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {

    public function cek_login($username, $password)
    {
        $this->db->where('username', $username);
        $this->db->where('password', md5($password)); // Mencocokkan password terenkripsi MD5
        return $this->db->get('admin')->row_array();
    }
}