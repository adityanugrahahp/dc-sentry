<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Contactless_guest extends MY_Controller {
	// construct
	function __construct(){
		parent::__construct();

		// load model
		$this->load->model('M_visitor');
		$this->load->model('M_user_loket');

		// fomr validation
		$this->load->library('form_validation');
	}

	public function index($token = null){

		$token = decrypt($token);
		if(true){
			// daftar nama lantai
			$opt = [];
			for($i = 1;$i <= 11; $i++){ $opt['Lantai '.$i] = 'Lantai '.$i; }

			$data['tujuan'] 	= $opt;
			$data['id_petugas'] = $token;

			$this->load->view('contactless_guest/V_index', $data);
		}else{
			// redirect ke web pelni
			redirect('https://pelni.co.id');
		}
	}

	function ajax_post_form(){
		$status = false;
		$msg 	= null;
		$access = null;
		$data 	= [];
		$post 	= $this->input->post();

		$this->form_validation->set_rules('nik', 'NIK', 'required|numeric|trim');
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('no_hp', 'No. HP', 'required|trim');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('tujuan', 'Tujuan', 'required');
        $this->form_validation->set_rules('keperluan', 'Keperluan', 'required');
        $this->form_validation->set_rules('jawaban_1', 'Form Kesehatan', 'required|trim');
        $this->form_validation->set_rules('jawaban_2', 'Form Kesehatan', 'required|trim');
        $this->form_validation->set_rules('jawaban_3', 'Form Kesehatan', 'required|trim');
        $this->form_validation->set_rules('jawaban_4', 'Form Kesehatan', 'required|trim');

		if($this->form_validation->run()){
			
			$form_kesehatan = [];
			$kode_akses 	= uniqid();

			// isian form kesehatan
			for($i = 1; $i <= 4; $i++){
				if(isset($post['pertanyaan_'.$i])){
					$temp = [
						'pertanyaan' 	=> $post['pertanyaan_'.$i],
						'jawaban'		=> $post['jawaban_'.$i]
					];

					if(isset($post['keterangan_'.$i])){
						foreach($post['keterangan_'.$i] as $index => $v){
							$temp['keterangan'][] = $v.' <b>'.$post['jawaban_keterangan_'.$i][$index].'</b>';
						}
					}
				}

				$form_kesehatan[] = $temp;
			}

			// dapatkan id kartu virtual
			$db_kartu = $this->M_visitor->get_visitor_card(['no_kartu' => '0000000000']);
			if($db_kartu){
				$id_kartu 	= $db_kartu[0]->id_kartu;

				// dapatkan lokasi ID petugas ini
				$lokasi		= 'N/A';
				$db_user 	= $this->M_user_loket->get_user(['id_user' => $post['id_petugas']]);
				if($db_user){
					$lokasi = $db_user[0]->location_id;
				}
				
				$data = [
					'nik'				=> $post['nik'],
					'nama'				=> strtoupper($post['nama']),
					'alamat'			=> $post['alamat'],
					'no_hp'				=> $post['no_hp'],
					'jenis_kelamin'		=> $post['jenis_kelamin'],
					'tujuan'			=> $post['tujuan'],
					'keperluan'			=> $post['keperluan'],
					'register_time' 	=> date('Y-m-d H:i:s'),
					'lokasi'			=> $lokasi,
					'created_by'		=> $post['id_petugas'],
					'status'			=> 1,
					'flag_approve'		=> 'N',
					'kode_akses'		=> $kode_akses,
					'id_visitor_card'	=> $id_kartu,
					'form_tambahan'		=> json_encode($form_kesehatan)
				];
				
				$db = $this->M_visitor->insert_new_visitor($data);

				if($db){ 
					$status = true; 
					$access = $db;
				}
			}
		}else{
			$msg = str_replace(['<p>', '</p>'], [null, '<br/>'], validation_errors());
		}

		$this->output->set_content_type('application/json')->set_output(json_encode(compact('status', 'msg', 'access')));
	}

	function ajax_check_status(){
		$status 	= false;
		$kategori 	= 'waiting';
		$data 		= [];

		if($post = $this->input->post()){
			// cek apakah visitor ini sudah diijinkan masuk?
			$db = $this->M_visitor->get_visitor_detail(['id' => $post['id'], 'flag_approve' => 'Y']);
			if($db){
				if(! $db[0]->last_seen){
					$status 	= true;
					$kategori 	= 'checkin';
					$data 		= [
						'nama'	=> $db[0]->nama,
						'since'	=> date('d/M/Y - H:i', strtotime($db[0]->register_time)),
						'kode' 	=> $db[0]->kode_akses
					];
				}else{
					$kategori = 'checkout';
				}
			}
		}

		$this->output->set_content_type('application/json')->set_output(json_encode(compact('status', 'kategori', 'data')));
	}
}