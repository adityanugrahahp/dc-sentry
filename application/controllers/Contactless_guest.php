<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Contactless_guest extends MY_Controller {

	function __construct(){
		parent::__construct();

		// load model
		$this->load->model('M_visitor');

		// fomr validation
		$this->load->library('form_validation');
	}

	public function index($token = null){

		$token = decrypt($token);
		if($token){
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
							$temp['keterangan'][] = $v.' '.$post['jawaban_keterangan_'.$i][$index];
						}
					}
				}

				$form_kesehatan[] = $temp;
			}

			// dapatkan id kartu virtual
			$db_kartu = $this->M_visitor->get_visitor_card(['no_kartu' => '0000000000']);
			if($db_kartu){
				$id_kartu = $db_kartu[0]->id_kartu;
				
				$data = [
					'nik'				=> $post['nik'],
					'nama'				=> $post['nama'],
					'alamat'			=> $post['alamat'],
					'no_hp'				=> $post['no_hp'],
					'jenis_kelamin'		=> $post['jenis_kelamin'],
					'tujuan'			=> $post['tujuan'],
					'keperluan'			=> $post['keperluan'],
					'register_time' 	=> date('Y-m-d H:i:s'),
					'lokasi'			=> 'KANTOR PUSAT',
					'created_by'		=> $post['id_petugas'],
					'status'			=> 1,
					'flag_approve'		=> 'N',
					'kode_akses'		=> $kode_akses,
					'id_visitor_card'	=> $id_kartu,
					'form_tambahan'		=> json_encode($form_kesehatan)
				];
				
				$db = $this->M_visitor->insert_new_visitor($data);
				if($db){ $status = true; }
			}
		}else{
			$msg = str_replace(['<p>', '</p>'], [null, '<br/>'], validation_errors());
		}

		$this->output->set_content_type('application/json')->set_output(json_encode(compact('status', 'msg')));
	}

	// TODO: UNTUK MELAKUKAN PENGECEKAN REGISTRASI APPROVE ATAU TIDAK?
	// BILA APPROVE, MAKA AKAN MUNCUL HALAMAN QR CODENYA YANG NANTI AKAN DI SCAN
	// BILA STATUS SUDAH CHECKOUT MAKA MUNCULKAN HALAMAN TERIMA KASIH DAN MATIKAN SETINTERVAL()
	function ajax_check_status(){

		$this->load->view('contactless_guest/qr_guest');

	}
}