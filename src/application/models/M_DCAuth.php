<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_DCAuth extends CI_Model
{
    private $table = 'dc_monitoring_users';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function check_user($username)
    {
        $this->db->where('username', $username);
        $this->db->where('is_active', TRUE);
        return $this->db->get($this->table)->row();
    }

    public function update_last_login($user_id)
    {
        $this->db->where('id', $user_id);
        $this->db->update($this->table, [
            'last_login' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function get_user_by_id($user_id)
    {
        $this->db->where('id', $user_id);
        $this->db->where('is_active', TRUE);
        return $this->db->get($this->table)->row();
    }

    public function create_user($data)
    {
        // Hash password sebelum disimpan
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

        return $this->db->insert($this->table, $data);
    }

    public function get_all_users()
    {
        $this->db->select('id, username, nama_lengkap, email, role, department, is_active, last_login, created_at');
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get($this->table)->result();
    }
}
