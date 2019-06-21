<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index(){
		$this->load->view('layouts/V_login');
		
	}

	public function login_action()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$this->load->library('form_validation');
        
		$this->load->model('M_visitor');

		$this->form_validation->set_rules('username', 'username', 'required');
		$this->form_validation->set_rules('password', 'password', 'required');

		if ($this->form_validation->run() != FALSE){
			$password 		= md5($password);
			$result_login 	= $this->M_visitor->login($username,$password);
			
			if($result_login['status']=='success'){
				$data = $result_login['data'];

				$_SESSION['userID'] 	= $data['id_user'];
				$_SESSION['userName'] 	= $data['username'];
				$_SESSION['locationID'] = $data['location_id'];
				$_SESSION['loket_name'] = $data['loket_name'];
				$_SESSION['role'] 		= $data['role'];

				redirect('/');
			}else{
				$this->session->set_flashdata('message', $result_login['status_message']);
				redirect('Login');
			}
		}else{
			$this->session->set_flashdata('message', 'username dan password tidak boleh kosong');
			redirect('Login');
		}
	}

	public function logout()
	{
		unset($_SESSION['userID']);
		unset($_SESSION['locationID']);
		unset($_SESSION['userName']);
		unset($_SESSION['loket_name']);
		unset($_SESSION['role']);
		session_destroy();
                redirect('Login');
	}
}
