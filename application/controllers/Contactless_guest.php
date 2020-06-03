<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Contactless_guest extends MY_Controller {

	public function index(){
		$this->load->view('contactless_guest/index');
	}

	// TODO: SUBMIT FORM KE DATABASE
	function ajax_post_form(){
		$status = false;
		$msg 	= null;
		$data 	= [];
		$post 	= $this->input->post();

		$this->form_validation->set_rules('nama_layar_qr', 'Nama Layar', 'required|trim');
		$this->form_validation->set_rules('token_layar', 'Kode Akses', 'trim');

		if($this->form_validation->run()){

		}else{
			$msg = str_replace(['<p>', '</p>'], [null, '<br/>'], validation_errors());
		}

		$this->output->set_content_type('application/json')->set_output(json_encode(compact('status', 'msg')));
	}

	// TODO: UNTUK MELAKUKAN PENGECEKAN REGISTRASI APPROVE ATAU TIDAK?
	// BILA APPROVE, MAKA AKAN MUNCUL HALAMAN QR CODENYA YANG NANTI AKAN DI SCAN
	// BILA STATUS SUDAH CHECKOUT MAKA MUNCULKAN HALAMAN TERIMA KASIH DAN MATIKAN SETINTERVAL()
	function ajax_check_status(){

	}
}