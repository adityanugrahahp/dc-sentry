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

		$data['extraJs'] 	= ["absenqr/index.js"];
		$data['page_title'] = "Pengaturan Absensi QR";
		$data['page_view'] 	= "absenqr/V_setting";

		$this->load->view('layouts/V_master', $data);
	}

	public function screen($access_key = null){
		// tidak perlu pengecekan session
		$this->load->view('absenqr/index');
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

	function ajax_module_index(){
		// get data visitor
		$data 	= [];
		$like 	= [];

		$keyword 	= $this->input->post("search")['value'];
		$start 		= $this->input->post("start");
		$length 	= $this->input->post("length");

		$where 	= [
			'date(register_time)' 	=> date('Y-m-d'),
			'status'				=> 1
		];

		// data total
		$jum_total = count($this->M_visitor->get_new_visitor($where));

		// bila user mencari menggunakan keyword
		if($keyword){
			if(is_numeric($keyword)){
				$where['no_kartu'] = $keyword;
			}else{
				$like = ['lower(nama_kartu)' => strtolower($keyword)];
			}
		}


		$db = $this->M_visitor->get_new_visitor($where, $like, $length, $start);
		foreach ($db as $v) {
			// hitung durasi waktu
			$durasi = 0;
			$durasi = $this->_durasi_waktu($v->register_time, date('Y-m-d H:i:s'));

			$action = [
				'<a href="#" class="btn btn-danger btn-xs btn-delete" data-id="'.$v->id.'" title="Checkout Tamu"><i class="fa fa-sign-out fa-fw"></i></a>'
			];

			$foto = (! empty($v->foto) && is_file($v->foto)) ? '<img src="'.$v->foto.'" alt="Foto Tamu" height="100" />' : 'N/A';

			$data[] = [
				'foto' 				=> $foto,
				'nama' 				=> "<b>{$v->nama}</b><small class='clearfix'>NIK: {$v->nik}</small>",
				'no_hp'				=> $v->no_hp,
				'register_time' 	=> "<b>".date('d/M/Y, H:i', strtotime($v->register_time))."</b><span class='clearfix' title='Durasi waktu dalam gedung'><i class='fa fa-clock-o fa-fw'></i> {$durasi}</span>",
				'tujuan' 			=> $v->tujuan,
				'keperluan' 		=> $v->keperluan,
				'id_visitor_card'	=> $v->nama_kartu,
				'suhu'              => $v->suhu,
				'action'			=> join(" ", $action)
			];
		}

		$output = [
			'draw'				=> $this->input->post('draw'),
			'recordsTotal'		=> $jum_total,
			'recordsFiltered'	=> $jum_total,
			'data'				=> $data
		];

		$this->output->set_content_type('application/json')->set_output(json_encode($output));
	}

	function _verify_access(){
		if(! isset($_SESSION['userID']) && $this->agent->is_browser()){
			// bila session tidak ada dan diakses melalui browser
			// redirect ke halaman login
			redirect('/login');
		}
	}
}
