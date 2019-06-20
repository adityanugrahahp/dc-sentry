<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Management_Controller {

	function __construct(){
		parent::__construct();

		// load model
		$this->load->model('M_visitor');

		// fomr validation
		$this->load->library('form_validation');
	}

	public function index(){
		if(isset($_SESSION['userID'])){
			$data['extraJs'] 	= ["home.js", "capture.js"];
			$data['page_title'] = "Register Visitor";
			$data['page_view'] 	= "home/V_index";
			$this->load->view('layouts/V_master', $data);
		}else{
			redirect('/login');
		}
		
	}

	function ajax_new_visitor(){
		// post only method
		if($this->input->method(FALSE) == 'post'){
			$status = true;
			$error 	= null;

            $this->form_validation->set_rules('nik', 'NIK', 'required|trim');
            $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required|trim');
            $this->form_validation->set_rules('no_hp', 'No. HP', 'required|trim');
            $this->form_validation->set_rules('tujuan', 'Tujuan', 'required|trim');
            $this->form_validation->set_rules('keperluan', 'Keperluan', 'required|trim');
            $this->form_validation->set_rules('alamat', 'Alamat', 'trim');
			$this->form_validation->set_rules('id_visitor_card', 'Visitor Card ID', 'numeric|trim');
			$this->form_validation->set_rules('foto', 'Photo', 'required');
			
			if($this->form_validation->run() != FALSE){
				$data = [
					'register_time' => date('Y-m-d H:i:s'),
					'lokasi'		=> 'KANTOR PUSAT',
					'created_by'	=> $_SESSION['userID'],
					'status'		=> 1
				];

				// cek apakah nomor kartu visitor valid
				$is_valid = $this->M_visitor->get_visitor_card(['no_kartu' => $this->input->post('id_visitor_card')]);
				if($is_valid){
					foreach ($this->input->post() as $i => $v) {
						if($i == 'tgl_lahir'){ if(empty($v)){ continue; } }
						if($i == 'id_visitor_card'){ $data[$i] = $is_valid[0]->id_kartu; continue; }
						$data[$i] = $v;
					}
					
					$data_foto  = $data['foto'];
	
					list($type, $data_foto) = explode(';', $data_foto);
					list(, $data_foto)      = explode(',', $data_foto);
					$data_foto = base64_decode($data_foto);
					$file_path = 'assets/image/photos/'.date('YmdHis').$data['nik'].'.jpg';
					file_put_contents($file_path, $data_foto);
					$data['foto'] = $file_path;
	
	
					// insert to DB
					$db = $this->M_visitor->insert_new_visitor($data);
					if(! $db){
						$status = false;
						$error 	= 'Cannot save data.';
					}
				}else{
					$status = false;
					$error 	= 'Kartu Akses Tidak Terdaftar ('.$this->input->post('id_visitor_card').').';
				}
			}else{
				$status = false;
				$error 	= validation_errors();
			}

			$this->output->set_content_type('application/json')->set_output(json_encode(['status' => $status, 'msg' => $error]));
		}
	}

	function ajax_get_visitor(){
		// get data visitor
		$data 	= [];
		$like 	= [];

		$keyword = $this->input->post("search")['value'];

		$where 	= [
			'date(register_time)' 	=> date('Y-m-d'),
			'status'				=> 1
		];

		// bila user mencari menggunakan keyword
		if($keyword){
			if(is_numeric($keyword)){
				$where['no_kartu'] = $keyword;
			}else{
				$like = ['lower(nama_kartu)' => strtolower($keyword)];
			}
		}

		$db = $this->M_visitor->get_new_visitor($where, $like);
		foreach ($db as $v) {
			// hitung durasi waktu
			$durasi = 0;
			$durasi = $this->_durasi_waktu($v->register_time, date('Y-m-d H:i:s'));

			$action = [
				'<a href="#" class="btn btn-danger btn-xs btn-delete" data-id="'.$v->id.'" title="Checkout Tamu"><i class="fa fa-sign-out fa-fw"></i></a>'
			];

			$foto = (! empty($v->foto)) ? '<img src="'.$v->foto.'" alt="Foto Tamu" height="100" />' : 'N/A';

			$data[] = [
				'foto' 				=> $foto,
				'nama' 				=> "<b>{$v->nama}</b><small class='clearfix'>NIK: {$v->nik}</small>",
				'no_hp'				=> $v->no_hp,
				'register_time' 	=> "<b>".date('d/M/Y, H:i', strtotime($v->register_time))."</b><span class='clearfix' title='Durasi waktu dalam gedung'><i class='fa fa-clock-o fa-fw'></i> {$durasi}</span>",
				'tujuan' 			=> $v->tujuan,
				'keperluan' 		=> $v->keperluan,
				'id_visitor_card'	=> $v->nama_kartu,
				'action'			=> join(" ", $action)
			];
		}

		$output = [
			'draw'				=> $this->input->post('draw'),
			'recordsTotal'		=> 100,
			'recordsFiltered'	=> count($db),
			'data'				=> $data
		];

		$this->output->set_content_type('application/json')->set_output(json_encode($output));
	}

	function ajax_get_visitor_history(){
		// get data visitor
		$data 	= [];

		$where 	= [
			'date(register_time)' => ($this->input->post('tggl')) ? $this->input->post('tggl') : date('Y-m-d'),
		];

		$db = $this->M_visitor->get_new_visitor($where);
		foreach ($db as $v) {
			// hitung berapa lama tamu berada di dalam gedung
			$durasi = 0;
			if(! empty($v->last_seen)){
				$durasi = $this->_durasi_waktu($v->last_seen, $v->register_time);
			}

			$foto = (! empty($v->foto)) ? '<img src="'.$v->foto.'" alt="Foto Tamu" height="100" />' : 'N/A';
			$data[] = [
				'foto' 				=> $foto,
				'nama' 				=> "<b>{$v->nama}</b><small class='clearfix'>NIK: {$v->nik}</small>",
				'no_hp'				=> $v->no_hp,
				'register_time' 	=> date('d/M/Y, H:i', strtotime($v->register_time)),
				'tujuan' 			=> $v->tujuan,
				'keperluan' 		=> $v->keperluan,
				'id_visitor_card'	=> $v->nama_kartu,
				'last_seen' 		=> (! empty($v->last_seen)) ? "<b>".date('d/M/Y, H:i', strtotime($v->last_seen))."</b><span class='clearfix' title='Lama dalam gedung.'><i class='fa fa-clock-o fa-fw'></i>{$durasi}</span>" : '<b class="text-danger">TAMU BELUM CHECKOUT</b>',
			];
		}

		$output = [
			'draw'				=> $this->input->post('draw'),
			'recordsTotal'		=> 100,
			'recordsFiltered'	=> count($db),
			'data'				=> $data
		];

		$this->output->set_content_type('application/json')->set_output(json_encode($output));
	}

	function ajax_checkout(){
		$status = true;
		$error 	= null;

		$db = $this->M_visitor->update_visitor(['id' => $this->input->post('id')], ['status' => 0, 'last_seen' => date('Y-m-d H:i:s'), 'checked_out_by' => $_SESION['userID']]);
		if(! $db){ 
			$status = false;
			$error 	= "Gagal Menghapus Entri";
		}

		$this->output->set_content_type('application/json')->set_output(json_encode(['status' => $status, 'msg' => $error]));
	}

	function ajax_get_current_visitor(){
		$where 	= ['date(register_time)' => date('Y-m-d'), 'status' => 1];
		$db 	= $this->M_visitor->get_new_visitor($where);
		$jumlah	= str_pad(count($db), 3, 0, STR_PAD_LEFT);

		$this->output->set_content_type('application/json')->set_output(json_encode(['jumlah' => $jumlah]));
	}

	function ajax_get_history_visitor(){
		$where 	= ['date(register_time)' => ($this->input->get('tggl')) ? $this->input->get('tggl') : date('Y-m-d')];
		$db 	= $this->M_visitor->get_new_visitor($where);
		$jumlah	= str_pad(count($db), 3, 0, STR_PAD_LEFT);

		$this->output->set_content_type('application/json')->set_output(json_encode(['jumlah' => $jumlah]));
	}

	function ajax_get_card(){
		if($this->input->method(FALSE) == 'post'){
			$status = false;
			$result = 'Tidak Ditemukan';
			$db = $this->M_visitor->get_visitor_card(['no_kartu' => $this->input->post('id')]);
			if($db){
				$status = true;
				$result = $db[0]->nama_kartu;
			}

			$this->output->set_content_type('application/json')->set_output(json_encode(['status' => $status, 'name' => $result]));
		}
	}

	function _durasi_waktu($date1 = null, $date2 = null){
		$output = 0;
		$raw_durasi = abs((new \DateTime($date1))->getTimestamp() - (new \DateTime($date2))->getTimestamp());
		if($raw_durasi / (60 * 60) < 1){
			$output = round($raw_durasi / 60, 1)." menit";
		}else{
			$output = round($raw_durasi / (60 * 60), 1)." jam";
		}
		
		return $output;
	}
}
