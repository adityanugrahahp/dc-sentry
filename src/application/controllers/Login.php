<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	private $pepper = 'iAP07hr6UhEZr5LoP950';
	
	function __construct(){
		parent::__construct();

		// library
		$this->load->library('form_validation');

		// models
		$this->load->model('M_visitor');
	}

	public function index(){
		if(! isset($_SESSION['locationID'])){
			// belum login
			$this->load->view('layouts/V_login');
		}else{
			redirect('home');
		}
	}

	public function login_action(){

		$is_valid 	= false;
		$msg 		= null;

		// inputan user
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$this->form_validation->set_rules('username', 'username', 'required');
		$this->form_validation->set_rules('password', 'password', 'required');

		if($this->form_validation->run()){

			// verifikasi username dan login
			$db_user = $this->M_visitor->get_login($username);
			if($db_user){
				// INFO: KOMBINASI: RAW_PASS + CUSTOM SALT + PEPPER
				$hashed = hash_hmac("sha256", $password.$db_user->salt, $this->pepper);
				if(password_verify($hashed, $db_user->password)){

					// set session untuk user ini
					$_SESSION['userID'] 	= $db_user->id_user;
					$_SESSION['userName'] 	= $db_user->username;
					$_SESSION['locationID'] = $db_user->location_id;
					$_SESSION['loket_name'] = $db_user->loket_name;
					$_SESSION['role'] 		= $db_user->role;
					$_SESSION['access']		= $db_user->menu_access;

					$is_valid = true;
				}else{
					$msg = 'Username & Password Tidak Cocok';
				}
			}else{
				$msg = 'Akun Tidak Ditemukan';
			}

			if($is_valid){
				redirect('/');
			}else{
				// redirect ke login
				$this->session->set_flashdata('message', $msg);
				redirect('login');
			}
		}else{
			$this->session->set_flashdata('message', validation_errors());
			redirect('login');
		}
	}

	public function logout()
	{
		unset($_SESSION['userID']);
		unset($_SESSION['locationID']);
		unset($_SESSION['loket_name']);
		unset($_SESSION['userName']);
		unset($_SESSION['access']);
		unset($_SESSION['role']);
		session_destroy();
		
		redirect('login');
	}
}
