<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DCAuth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->model('M_DCAuth');
        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['url', 'form']);
    }

    public function index()
    {
        // Redirect jika sudah login
        if ($this->session->userdata('dc_logged_in')) {
            $this->redirect_by_role();
            return;
        }

        $data['title'] = 'Login - Data Center Monitoring';
        $this->load->view('V_dclogin', $data);
    }

    public function login()
    {
        // Redirect jika sudah login
        if ($this->session->userdata('dc_logged_in')) {
            $this->redirect_by_role();
            return;
        }

        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $data['error'] = 'Username dan password wajib diisi';
            $this->load->view('V_dclogin', $data);
            return;
        }

        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $user = $this->M_DCAuth->check_user($username);

        if ($user && password_verify($password, $user->password)) {
            // Set session data
            $session_data = [
                'dc_logged_in' => TRUE,
                'dc_id' => $user->id,
                'dc_username' => $user->username,
                'dc_nama_lengkap' => $user->nama_lengkap,
                'dc_role' => $user->role,
                'dc_department' => $user->department ?? 'IT Department'
            ];

            $this->session->set_userdata($session_data);

            // Update last login
            $this->M_DCAuth->update_last_login($user->id);

            // Redirect berdasarkan role
            $this->redirect_by_role();
        } else {
            $data['error'] = 'Username atau password salah';
            $this->load->view('V_dclogin', $data);
        }
    }

    private function redirect_by_role()
    {
        $role = $this->session->userdata('dc_role');

        if ($role == 'staff') {
            redirect('data_center/index_staff');
        } elseif ($role == 'manager') {
            redirect('data_center/index_manager');
        } else {
            redirect('dc-auth');
        }
    }

    public function logout()
    {
        // Clear session data
        $session_data = [
            'dc_logged_in',
            'dc_id',
            'dc_username',
            'dc_nama_lengkap',
            'dc_role',
            'dc_department'
        ];
        $this->session->unset_userdata($session_data);
        $this->session->sess_destroy();

        redirect('dc-auth');
    }
}
