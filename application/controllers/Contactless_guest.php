<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Contactless_guest extends MY_Controller {

	function __construct(){
		parent::__construct();

		// load model
		$this->load->model('M_visitor');

		// fomr validation
		$this->load->library('form_validation');
	}

	public function index(){
		$opt = [];
		// daftar nama lantai
		for($i = 1;$i <= 11; $i++){
			$opt['Lantai '.$i] = 'Lantai '.$i;
		}

			$data['tujuan'] 	= $opt;

		$this->load->view('contactless_guest/index', $data);
	}

	// TODO: SUBMIT FORM KE DATABASE
	function ajax_post_form(){
		$status = false;
		$msg 	= null;
		$data 	= [];
		$post 	= $this->input->post();

		$this->form_validation->set_rules('nik', 'NIK', 'required|trim');
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('no_hp', 'No. HP', 'required|trim');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('tujuan', 'Tujuan', 'required');
        $this->form_validation->set_rules('keperluan', 'Keperluan', 'required');
        // $this->form_validation->set_rules('pertanyaan_1', 'Pertanyaan 1');
        // $this->form_validation->set_rules('riwayat_sakit', 'Riwayat Sakit');
        // $this->form_validation->set_rules('pertanyaan_2', 'Pertanyaan 2');
        // $this->form_validation->set_rules('tgl_rapid_test', 'Tanggal Rapid');
        // $this->form_validation->set_rules('hasil', 'Hasil');
        // $this->form_validation->set_rules('pertanyaan_3', 'Pertanyaan 3');
        // $this->form_validation->set_rules('mulai_covid', 'Mulai Covid');
        // $this->form_validation->set_rules('bebas_covid', 'Bebas Covid');
        // $this->form_validation->set_rules('pertanyaan_4', 'Pertanyaan 4');
        // $this->form_validation->set_rules('travel_history', 'Riwayat Perjalanan');

		if($this->form_validation->run()){

			foreach($post as $i => $v){
                if ($i == 'id') {continue;}
                $data[$i] = $v;
			}

                
                $data += [
					'register_time' => date('Y-m-d H:i:s'),
					'lokasi'		=> 'KANTOR PUSAT',
					'created_by'	=> $_SESSION['userID'],
					'status'		=> 1,
					'id_visitor_card'		=> 5,
				];

                $db = $this->M_visitor->insert_new_visitor($data);


			if($db){ $status = true; }

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