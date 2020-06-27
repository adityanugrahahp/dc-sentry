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

	// tampilan halaman utama
	public function index(){
		if(isset($_SESSION['userID'])){
			$opt = [];
			// daftar nama lantai
			for($i = 1;$i <= 11; $i++){
				$opt['Lantai '.$i] = 'Lantai '.$i;
			}

			$data['tujuan'] 	= $opt;
			$data['extraJs'] 	= ["capture.js", "home.js", "instascan.min.js"];
			$data['page_title'] = "Register Visitor";
			$data['page_view'] 	= "home/V_index";
			$this->load->view('layouts/V_master', $data);
		}else{
			redirect('login');
		}
	}
	
	// untuk mendaftarkan tamu yang masuk ke dalam gedung
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
			// $this->form_validation->set_rules('foto', 'Photo', 'required');
			
			if($this->form_validation->run() != FALSE){
				// preset data array
				$data = [
					'register_time' => date('Y-m-d H:i:s'),
					'lokasi'		=> $_SESSION['locationID'],
					'created_by'	=> $_SESSION['userID'],
					'status'		=> 1
				];

				// cek apakah nomor kartu visitor valid
				$is_valid = $this->M_visitor->get_visitor_card(['no_kartu' => $this->input->post('id_visitor_card')]);
				
				// bila auto new card
				if(AUTO_NEW_CARD){ $is_valid = true; }

				if($is_valid){
					// masukkan data-data visitor untuk disimpan
					foreach ($this->input->post() as $i => $v) {
						if($i == 'id') { continue; }
						if($i == 'tgl_lahir'){ if(empty($v)){ continue; } }
						if($i == 'nama'){ $data[$i] = strtoupper($v); continue; }
						if($i == 'id_visitor_card'){ 
							// bila auto new card
							if(AUTO_NEW_CARD){
								// bila kartu tidak ada maka insert dulu sebegai kartu testing
								$is_valid = $this->M_visitor->get_visitor_card(['no_kartu' => $this->input->post('id_visitor_card')]);
								if(! $is_valid){
									$data_kartu = [
										'no_kartu' 		=> $v,
										'nama_kartu'	=> "VISITOR {$v}"
									];
									$db_card = $this->M_visitor->insert_new_card($data_kartu);
									if($db_card){ $data[$i] = $db_card; }
								}else{
									$data[$i] = $is_valid[0]->id_kartu;	
								}
							}else{
								// pengecekan kartu akses yang sudah ada saja
								$data[$i] = $is_valid[0]->id_kartu;
							}

							continue; 
						}
						$data[$i] = $v;
					}
					
					// data foto merupakan format base64
					$data_foto = $data['foto'];
	
					@list($type, $data_foto) = explode(';', $data_foto);
					@list(, $data_foto)      = explode(',', $data_foto);

					$data_foto = base64_decode($data_foto);
					$file_path = $_SERVER['DOCUMENT_ROOT'].'/assets/image/photos/'.date('YmdHis').$data['nik'].'.jpg';
					file_put_contents($file_path, $data_foto);

					$data['foto'] = str_replace($_SERVER['DOCUMENT_ROOT'].'/', null, $file_path);

					// auto approve
					$data['flag_approve'] = 'Y';

					if(! $this->input->post('id')){
						// bila id tidak ada, maka insert
						// cek apakah nik, id_card, register_time dan status = 1 sdh ada ditabel?
						$where = [
							'nik' 				=> $data['nik'],
							'nama' 				=> $data['nama'],
							'id_visitor_card' 	=> $data['id_visitor_card'],
							'status' 			=> 1,
							'lower(lokasi)' 	=> strtolower($_SESSION['locationID'])
						];

						if($this->M_visitor->get_new_visitor($where)){
							$status = false;
							$error 	= 'Data Sudah Ada. Silakan checkout terlebih dahulu.';
						}else{
							// insert to DB
							$db = $this->M_visitor->insert_new_visitor($data);
							if(! $db){
								$status = false;
								$error 	= 'Cannot save data.';
							}
						}
					}else{
						// bila id ada, maka update entry
						$db = $this->M_visitor->update_visitor(['id' => $this->input->post('id')], ['flag_approve' => 'Y']);
						if(! $db){ 
							$status = false;
							$error 	= 'Cannot approve user.';
						}
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

	// table untuk tamu yang saat ini sedang berada dalam gedung (hari ini)
	function ajax_get_visitor(){
		// get data visitor
		$data 	= [];
		$like 	= [];

		$keyword 	= $this->input->post("search")['value'];
		$start 		= $this->input->post("start");
		$length 	= $this->input->post("length");

		$where 	= [
			'date(register_time)' 	=> date('Y-m-d'),
			'status'				=> 1,
			'lower(lokasi)' 		=> strtolower($_SESSION['locationID'])
		];

		// bila user mencari menggunakan keyword
		if($keyword){
			if(is_numeric($keyword)){
				$like = [
					'no_kartu' 	=> $keyword,
					'no_hp'		=> $keyword
				];
			}else{
				$like = [
					'lower(nama_kartu)' => strtolower($keyword),
					'lower(kode_akses)' => strtolower($keyword),
					'lower(nama)' 		=> strtolower($keyword)
				];
			}
		}

		// data total pengunjung
		$jum_total = count($this->M_visitor->get_new_visitor($where));

		$db = $this->M_visitor->get_new_visitor($where, $like, $length, $start);
		foreach ($db as $v) {
			// hitung durasi waktu
			$durasi = 0;
			$durasi = $this->_durasi_waktu($v->register_time, date('Y-m-d H:i:s'));

			$action = [
				'<a href="#" class="btn btn-primary btn-xs btn-edit" data-id="'.$v->id.'" title="Verifikasi Data Tamu"><i class="fa fa-edit fa-fw"></i></a>',
				'<a href="#" class="btn btn-danger btn-xs btn-delete" data-id="'.$v->id.'" title="Checkout Tamu"><i class="fa fa-sign-out fa-fw"></i></a>'
			];

			// nomor kartu visitor
			$s_no_kartu_visitor 	= $v->nama_kartu;

			// waktu pendaftaran
			$s_waktu_pendaftaran 	= "<b>".date('d/M/Y, H:i', strtotime($v->register_time))."</b><span class='clearfix' title='Durasi waktu dalam gedung'><i class='fa fa-clock-o fa-fw'></i> {$durasi}</span>";

			// bila statusnya belum approve, tampilkan tombol approve dan bukan checkout
			if($v->flag_approve != 'Y'){
				// hilangkan tombol checkout
				unset($action[1]);
				$s_waktu_pendaftaran 	= "<b class='text-warning'>Menunggu</b><span class='clearfix'>{$durasi}</span>";
				$s_no_kartu_visitor 	= '-';
			}else{
				// hilangkan tombol verifikasi
				unset($action[0]);
			}

			$foto = (! empty($v->foto) && is_file($v->foto)) ? '<img src="'.$v->foto.'" alt="Foto Tamu" height="100" />' : 'N/A';

			$data[] = [
				'foto' 				=> $foto,
				'nama' 				=> "<b>{$v->nama}</b><small class='clearfix'>NIK: {$v->nik}</small>",
				'no_hp'				=> $v->no_hp,
				'register_time' 	=> $s_waktu_pendaftaran,
				'tujuan' 			=> $v->tujuan,
				'keperluan' 		=> $v->keperluan,
				'id_visitor_card'	=> $s_no_kartu_visitor,
				'suhu'              => ($v->suhu) ?: '-',
				'action'			=> '<center>'.join(" ", $action).'</center>'
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

	// tabel untuk riwayat tamu sesuai tanggal
	function ajax_get_visitor_history(){
		// get data visitor
		$data 	= [];

		$start 		= $this->input->post("start");
		$length 	= $this->input->post("length");
		$keyword 	= $this->input->post("search")['value'];

		$ex1 = explode('-', $this->input->post('tggl1'));
		$ex2 = explode('-', $this->input->post('tggl2'));

		$tggl_awal 	= (count($ex1) > 1) ? join('-', [$ex1[2], $ex1[0], $ex1[1]]) : date('Y-m-d');
		$tggl_akhir	= (count($ex2) > 1) ? join('-', [$ex2[2], $ex2[0], $ex2[1]]) : date('Y-m-d');

		$where 	= [
			'date(register_time) >=' 	=> $tggl_awal,
			'date(register_time) <=' 	=> $tggl_akhir,
			'lower(lokasi)' 			=> strtolower($_SESSION['locationID'])
		];

		// bila user mencari menggunakan keyword
		$like = null;
		if($keyword){
			if(is_numeric($keyword)){
				$where .= " and (visitor_cards.no_kartu = '{$keyword}'";
				$where .= " or visitor_cards.no_hp = '{$keyword}')";
			}else{
				$like = [
					'lower(nama_kartu)' => strtolower($keyword),
					'lower(kode_akses)' => strtolower($keyword),
					'lower(nama)' 		=> strtolower($keyword)
				];
			}
		}

		// data total pengunjung
		$jum_total = count($this->M_visitor->get_new_visitor($where));

		$db = $this->M_visitor->get_new_visitor($where, $like, $length, $start, 'last_seen');
		foreach ($db as $v) {
			// hitung berapa lama tamu berada di dalam gedung
			$durasi = 0;
			if(! empty($v->last_seen)){
				$durasi = $this->_durasi_waktu($v->last_seen, $v->register_time);
			}

			$action = [];
			if($v->status == 1 && date('Y-m-d', strtotime($v->register_time)) != date('Y-m-d')){
				$action = [
					'<a href="#" class="btn btn-danger btn-xs btn-delete-past" data-id="'.$v->id.'" title="Checkout Tamu"><i class="fa fa-sign-out fa-fw"></i></a>'
				];
			}
			
			// cek apakah foto ada atau tidak di penyimpanan
			$foto = (! empty($v->foto) && is_file($v->foto)) ? '<img src="'.$v->foto.'" alt="Foto Tamu" height="100" />' : 'N/A';

			$data[] = [
				'foto' 				=> $foto,
				'nama' 				=> "<b>{$v->nama}</b><small class='clearfix'>NIK: {$v->nik}</small>",
				'no_hp'				=> $v->no_hp,
				'register_time' 	=> date('d/M/Y, H:i', strtotime($v->register_time)),
				'tujuan' 			=> $v->tujuan,
				'keperluan' 		=> $v->keperluan,
				'id_visitor_card'	=> $v->nama_kartu,
				'suhu'              => $v->suhu,
				'last_seen' 		=> (! empty($v->last_seen)) ? "<b>".date('d/M/Y, H:i', strtotime($v->last_seen))."</b><span class='clearfix' title='Lama dalam gedung.'><i class='fa fa-clock-o fa-fw'></i>{$durasi}</span>" : '<b class="text-danger">TAMU BELUM CHECKOUT</b>',
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

	// tamu checkout dari gedung
	function ajax_checkout(){
		$status = true;
		$error 	= null;
		$where 	= [];

		$last_seen = date('Y-m-d H:i:s');

		// checkout dengan menggunakan id
		if($id = $this->input->post('id')){
			$where = ['id' => $id];
		}

		// checkout dengan menggunakan kode akses (QR Code)
		if($kode_akses = $this->input->post('kode_akses')){
			$where = ['kode_akses' => $kode_akses];
		}

		// bila last_seen ada, maka ini checkout diluar tanggal normal
		if($ls = $this->input->post('last_seen')){
			$ex 	= explode(' ', $ls);
			$ex_d 	= explode('-', $ex[0]);
			$last_seen = date('Y-m-d H:i:s', strtotime($ex_d[2].'-'.$ex_d[0].'-'.$ex_d[1].' '.$ex[1]));
		}

		$db = $this->M_visitor->update_visitor($where, ['status' => 0, 'last_seen' => $last_seen, 'checked_out_by' => $_SESSION['userID']]);
		if(! $db){ 
			$status = false;
			$error 	= "Gagal Menghapus Entri";
		}

		$this->output->set_content_type('application/json')->set_output(json_encode(['status' => $status, 'msg' => $error]));
	}

	// jumlah untuk tamu yang saat ini sedang berada dalam gedung (hari ini)
	function ajax_get_current_visitor(){
		// jumlah pengunjung keseluruhan
		$where 	= ['date(register_time)' => date('Y-m-d'), 'status' => 1, 'flag_approve' => 'Y', 'lower(lokasi)' => strtolower($_SESSION['locationID'])];
		$db 	= $this->M_visitor->get_new_visitor($where);
		$jumlah	= str_pad(count($db), 3, 0, STR_PAD_LEFT);

		// jumlah pengunjung menunggu approval
		$where 	= ['date(register_time)' => date('Y-m-d'), 'status' => 1, 'flag_approve' => 'N', 'lower(lokasi)' => strtolower($_SESSION['locationID'])];
		$db 	= $this->M_visitor->get_new_visitor($where);
		$wait	= str_pad(count($db), 3, 0, STR_PAD_LEFT);

		$output = ['jumlah' => $jumlah, 'waiting' => $wait];

		$this->output->set_content_type('application/json')->set_output(json_encode($output));
	}

	// jumlah untuk riwayat tamu sesuai tanggal
	function ajax_get_history_visitor(){
		$ex1 = explode('-', $this->input->post('tggl1'));
		$ex2 = explode('-', $this->input->post('tggl2'));

		$tggl_awal 	= (count($ex1) > 1) ? join('-', [$ex1[2], $ex1[0], $ex1[1]]) : date('Y-m-d');
		$tggl_akhir	= (count($ex2) > 1) ? join('-', [$ex2[2], $ex2[0], $ex2[1]]) : date('Y-m-d');

		$where 	= "date(register_time) >= date('{$tggl_awal}') and date(register_time) <= date('{$tggl_akhir}')";

		$db 	= $this->M_visitor->get_new_visitor($where);
		$jumlah	= str_pad(count($db), 3, 0, STR_PAD_LEFT);

		$this->output->set_content_type('application/json')->set_output(json_encode(['jumlah' => $jumlah]));
	}

	// untuk memvalidasi apakah kartu akses adalah benar
	function ajax_get_card(){
		if($this->input->method(FALSE) == 'post'){
			$status = false;
			$result = 'Tidak Terdaftar'; 

			// bila auto new card
			if(AUTO_NEW_CARD){
				$status = true;
				$result = 'Kartu Baru - ('.$this->input->post('id').')'; 
			}
			
			$db = $this->M_visitor->get_visitor_card(['no_kartu' => $this->input->post('id')]);
			if($db){
				$status = true;
				$result = $db[0]->nama_kartu;
			}

			$this->output->set_content_type('application/json')->set_output(json_encode(['status' => $status, 'name' => $result]));
		}
	}

	// untuk mendapatkan berapa banyak tamu yang belum checkout di database
	function ajax_get_not_checkout(){
		$result = 0; 
		$status = false;
		$since 	= null;
		
		// hanya post saja
		if($this->input->method(FALSE) == 'post'){
			$where 	= [
				'date(register_time) !='	=> date('Y-m-d'),
				'status'					=> 1,
				'lower(lokasi)' 			=> strtolower($_SESSION['locationID'])
			];
	
			// data total
			$db = $this->M_visitor->get_new_visitor($where, null, null, null, 'register_time', 'asc');
			if($db){
				$status = true;

				// tanggal awal belum checkoutnya itu
				$since 	= date('d-m-Y', strtotime($db[0]->register_time));
			}

			// jumlah tamu belum checkout
			$result = count($db);
		}

		$this->output->set_content_type('application/json')->set_output(json_encode(['status' => $status, 'total' => $result, 'since' => $since]));
	}

	// mendapatakan detail tamu
	function ajax_get_detail_tamu(){
		$status = false;
		$msg 	= null;
		$data 	= [];
		$post 	= $this->input->post();

		if(isset($post['id'])){
			// dapatkan id visitornya
			$id 	= $post['id'];
			$where 	= ['id' => $id];

			$db = $this->M_visitor->get_visitor_detail($where);
			if($db){
				$status = true;
				$data 	= $db[0];

				$html = null;
				if($db[0]->form_tambahan){
					foreach(json_decode($db[0]->form_tambahan) as $i => $v){
						$html .= "<b>".(++$i).". {$v->pertanyaan}</b><br>Respon: {$v->jawaban}<br>";
	
						// keterangan tambahan
						if(isset($v->keterangan) && $v->jawaban == 'Ya'){
							$html .= "Keterangan Tambahan:<br>";
	
							foreach($v->keterangan as $vk){
								$html .= "- {$vk}<br>";
							}
						}
	
						$html .= '<br>';
					}
				}

				$data->{'form'} = $html;

				unset($data->form_tambahan);
			}
		}

		$this->output->set_content_type('application/json')->set_output(json_encode(['status' => $status, 'msg' => $msg, 'data' => $data]));
	}

	// tamu checkout dari gedung
	function ajax_disapprove(){
		$status = false;
		$error 	= null;

		// hapus visitor dengan menggunakan id
		if($id = $this->input->post('id')){
			$db = $this->M_visitor->delete_visitor($id);
			if($db){ 
				$status = true;
			}
		}

		$this->output->set_content_type('application/json')->set_output(json_encode(['status' => $status]));
	}

	// fungsi untuk menghitung durasi antara 2 waktu
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

	public function ajax_get_pegawai()
	{
		$nrp = $this->input->post('nrp');
		$data_raw = $this->M_visitor->get_pegawai($nrp);
		$response = array();
		if($data_raw!=FALSE)
		{
			$data_raw['pslh_tgl_lhr'] = DateTime::createFromFormat('Y-m-d', $data_raw['pslh_tgl_lhr'])->format('m-d-Y');
			$response['status'] = "success";
			$response['message'] = "";
			$response['data'] = $data_raw;
		}
		else
		{
			$response['status'] = "error";
			$response['message'] = "Pegawai tidak ditemukan";
			$response['data'] = [];
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($response));
		
	}

	public function get_existing_visitor()
	{
		$nik = $this->input->post('nik');
		$data_raw = $this->M_visitor->get_existing_visitor($nik);
		$response = array();
		if($data_raw!=FALSE)
		{
			$response['status'] = "success";
			$response['message'] = "";
			$response['data'] = $data_raw;
		}
		else
		{
			$response['status'] = "error";
			$response['message'] = "Visitor tidak ditemukan";
			$response['data'] = [];
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($response));
	}
}
