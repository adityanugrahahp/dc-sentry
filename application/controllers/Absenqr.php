<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Absenqr extends CI_Controller {

	function __construct(){
		parent::__construct();

		// load library
		$this->load->library('user_agent');
	}

	public function index(){
		// check user access
		$this->_verify_access();

		$data['page_title'] = "Pengaturan Absensi QR";
		$data['page_view'] 	= "absenqr/V_setting";
		$this->load->view('layouts/V_master', $data);

		// $this->load->view('absenqr/index');
	}

	public function screen($access_key = null){
		// tidak perlu pengecekan session
	}

	function ajax_update_qr(){
		// TODO: CURL TO DEVEL
	}

	function ajax_get_latest_attendee(){
		$status = false;
		$data 	= [];
		$msg 	= [];

		if($post = $this->input->post()){
			// post_body
			$header = ['no_tiket' => $no_tiket];
			$rest   = curl_req('post', WS_URL.'ws_events/post_check_validity', $header, [WS_TOKEN_IDEF.': '.WS_TOKEN]);
			if($rest['content']['code'] == 200){
				
			}else{
				$output = ['error' => $rest['content']['message']];
			}
		}

		$this->output->set_content_type('application/json')->set_output(json_encode(compact('status', 'data', 'msg')));
	}

	function _verify_access(){
		if(! isset($_SESSION['userID']) && $this->agent->is_browser()){
			// bila session tidak ada dan diakses melalui browser
			// redirect ke halaman login
			redirect('/login');
		}
	}
}
