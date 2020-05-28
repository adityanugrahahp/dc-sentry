<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Absenqr extends MY_Controller {

	protected $durasi_expired = 5; // satuan dalam detik

	function __construct(){
		parent::__construct();

		// load library
		$this->load->library(['user_agent']);

		// load models
		$this->load->model('M_absenqr');
	}

	public function index(){
		// check user access
		$this->_verify_access();

		$data['extraJs'] 	= ["absenqr/index.js"];
		$data['page_title'] = "Pengaturan Absensi QR";
		$data['page_view'] 	= "absenqr/V_setting";

		$this->load->view('layouts/V_master', $data);
	}

	public function screen($screen_id = null, $screen_name = null, $access = null){
		
		$is_valid = false;

		// validasi id, nama dan akses layarnya
		if($screen_id && $screen_name && $access){
			$db = $this->M_absenqr->get(null, ['id' => $screen_id, 'token_layar' => $access]);
			if($db){
				// cek apakah judulnya benar?
				if(url_title($db[0]->nama_layar_qr, '-', true) == $screen_name){
					$is_valid = true;
				}
			}
		}

		if(! $is_valid){
			show_error('The page you are trying to access is invalid or you don\'t have sufficient permission level.', 401, 'Invalid Request');
		}

		// tidak perlu pengecekan session
		$this->load->view('absenqr/V_screen');
	}

	function ajax_generate_qr($screen_id = null){
		// check diredis entry untuk layar ini masih sama? kalo masih sama tidak perlu generate
		// INFO: FORMAT QR ADALAH ABSENSI:{tggl_expired (Y-m-d H:i)|id_layar|random_string}(encrypted):PUBLIC_KEY harian
		$status = true;
		$data 	= [];

		// tanggal expired qr code
		$public_key	= uniqid();
		$date_exp 	= new DateTime('+'.$this->durasi_expired.' seconds');
		$payload 	= [$date_exp->format('Y-m-d H:i:s'), $screen_id, uniqid()];
		$e_payload	= encrypt(implode('|', $payload), $public_key);
		$format_qr 	= implode(':', ['ABSENSI', $e_payload, $public_key]);

		$data = [
			'qr' 			=> QR_URL.$format_qr,
			'next_request'	=> $date_exp->format('Y-m-d H:i:s')
		];

		$this->output->set_content_type('application/json')->set_output(json_encode(compact('status', 'data')));
	}

	// TODO: UNTUK MENDAPATKAN LIST SIAPA YANG ABSEN TERKINI
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

		$where = ['lokasi' => 'KANTOR PUSAT'];

		// bila search
		if($keyword != ''){
			$like = ['lower(nama_layar_qr)' => strpos($keyword)];
		}

		$db = $this->M_absenqr->get(null, $where, null, null, ['created_at' => 'desc'], $length, $start, $like);
		foreach($db as $v){

			$aksi = [
				'<a href="'.base_url('absenqr/screen/'.$v->id.'/'.url_title($v->nama_layar_qr, '-', true).'/'.$v->token_layar).'" target="_blank" class="btn btn-xs btn-default" data-id="'.$v->id.'"><i class="fa fa-share fa-fw"></i></a>',
				'<a href="javascript:void(0)" class="btn btn-xs btn-primary btn-edit" data-id="'.$v->id.'"><i class="fa fa-edit fa-fw"></i></a>',
				'<a href="javascript:void(0)" class="btn btn-xs btn-danger btn-delete" data-id="'.$v->id.'"><i class="fa fa-trash fa-fw"></i></a>'
			];

			$data[] = [
				'nama' 			=> $v->nama_layar_qr,
				'lokasi' 		=> '<center>'.$v->lokasi.'</center>',
				'expired' 		=> '<center>'.date('d/m/Y - H:i', strtotime($v->tggl_expired)).'</center>',
				'pesan' 		=> '<center>'.(($v->pesan_layar) ? '<i class="fa fa-check text-success fa-fw"></i>' : null).'</center>',
				'jumlah_scan' 	=> '<center>'.$v->jumlah_scan.'</center>',
				'aksi' 			=> '<center>'.implode(' ', $aksi).'</center>'
			];
		}

		$output = [
			'draw'				=> $this->input->post('draw'),
			'recordsTotal'		=> count($db),
			'recordsFiltered'	=> count($db),
			'data'				=> $data
		];

		$this->output->set_content_type('application/json')->set_output(json_encode($output));
	}

	function ajax_get_item(){
		$status = false;
		$data 	= [];

		if($post = $this->input->post('id')){
			$db = $this->M_absenqr->get(null, ['id' => $post]);
			if($db){
				$status = true;
				$data 	= $db[0];
			}
		}

		$this->output->set_content_type('application/json')->set_output(json_encode(compact('status', 'data')));
	}

	function ajax_post_form(){
		$status = false;
		$msg 	= null;
		$data 	= [];
		$post 	= $this->input->post();

		$this->form_validation->set_rules('nama_layar_qr', 'Nama Layar', 'required|trim');
		$this->form_validation->set_rules('token_layar', 'Kode Akses', 'trim');

		if($this->form_validation->run()){

			// get all items
			foreach($post as $i => $v){
                if ($i == 'id') {continue;}
                $data[$i] = $v;
			}
			
			// bila token display tidak ada, maka tambahkan
			if($post['token_layar'] == ''){
				$data['token_layar'] = $this->_random_string();
			}

            if(! $post['id']) {
                // log & generated token
                $data += [
					'generated_token'	=> uniqid(),
					// 'tggl_expired'		=> '' // TODO: + 1 hari
                    'created_by' 		=> $_SESSION['userID'],
                    'created_at' 		=> date('Y-m-d H:i:s'),
                ];

                $db = $this->M_absenqr->insert(null, $data);
            }else{
                // log
                $data += [
                    'updated_by' 	=> $_SESSION['userID'],
                    'updated_at'	=> date('Y-m-d H:i:s'),
                ];

				$db = $this->M_absenqr->update(null, ['id' => $post['id']], $data);
			}
			
			if($db){ $status = true; }
		}else{
			$msg = str_replace(['<p>', '</p>'], [null, '<br/>'], validation_errors());
		}

		$this->output->set_content_type('application/json')->set_output(json_encode(compact('status', 'msg')));
	}

	function ajax_delete_item(){
        $status = false;

        if($id = $this->input->post('id')){
            $db = $this->M_absenqr->delete(null, ['id' => $id]);
            if($db){ $status = true; }
        }

        $this->output->set_content_type('application/json')->set_output(json_encode(compact('status')));
    }

	// PRIVATE FUNCTIONS
	function _verify_access(){
		if(! isset($_SESSION['userID']) && $this->agent->is_browser()){
			// bila session tidak ada dan diakses melalui browser
			// redirect ke halaman login
			redirect('/login');
		}
	}

	function _random_string($length = 35) {
		$characters 		= '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength 	= strlen($characters);
		$randomString 		= '';

		for($i = 0; $i < $length; $i++){
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}

		return $randomString;
	}
	// END PRIVATE FUNCTIONS
}
