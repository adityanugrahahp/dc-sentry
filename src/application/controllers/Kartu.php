<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kartu extends Management_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('M_visitor');
		$this->load->library('form_validation');

		// pengecekan akses user menu
		if(! app_check_access(1)){
			// cek menu_access yang dimiliki user ini apa?
			$ex = explode(', ', $_SESSION['access']);
			if($ex){
				// dapatkan element pertama dari user access, cek di daftar menu
				$menu = app_menu_list();
				if($menu && $menu[$ex[0]]){
					$link = explode('|', $menu[$ex[0]]);
					if($link){
						redirect($link[1]);
					}
				}
			}

			// bila tidak ada access yang sesuai, maka tampilkan halaman error
			show_error('Anda tidak dapat mengakses halaman ini. Hal ini disebabkan karena akun Anda tidak memiliki hak yang sesuai.', 401, 'Terjadi Kesalahan');
		}
	}

	public function index(){
		if(isset($_SESSION['userID'])){
			$opt = [];
			
			// daftar nama lantai
			for($i = 1;$i <= 11; $i++){
				$opt['Lantai '.$i] = 'Lantai '.$i;
			}

			$data['extraJs'] 	= ["kartu.js"];
			$data['page_title'] = "Management Kartu Akses";
			$data['page_view'] 	= "kartu/V_index";
			$this->load->view('layouts/V_master', $data);
		}else{
			redirect('/login');
		}
	}

	function ajax_get_kartu(){
		// get data visitor
		$data 	= [];
		$like 	= [];

		$keyword 	= $this->input->post("search")['value'];
		$start 		= $this->input->post("start");
		$length 	= $this->input->post("length");

		// data total
		$jum_total = count($this->M_visitor->get_visitor_card());

		// bila user mencari menggunakan keyword
		$where = [];
		if($keyword){
			if(is_numeric($keyword)){
				$where['no_kartu'] = $keyword;
			}else{
				$like = ['lower(nama_kartu)' => strtolower($keyword)];
			}
		}

		$db = $this->M_visitor->get_visitor_card($where, $like, $length, $start);
		foreach ($db as $i => $v) {
			$action = [
				'<a href="#" class="btn btn-primary btn-xs btn-edit" data-id="'.$v->id_kartu.'" title="Edit Entri"><i class="fa fa-edit fa-fw"></i></a>',
				'<a href="#" class="btn btn-danger btn-xs btn-delete" data-id="'.$v->id_kartu.'" title="Hapus Entri"><i class="fa fa-trash fa-fw"></i></a>'
			];

			$data[] = [
				'no' 				=> ++$i,
				'kode' 				=> $v->no_kartu,
				'nama'				=> $v->nama_kartu,
				'created_at' 		=> (! empty($v->created_at)) ? date('d/M/Y, H:i', strtotime($v->created_at)) : 'Tidak Ada Data',
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

	function ajax_get_single_kartu(){
		if($this->input->method(FALSE) == 'post'){
			$data 	= [];
			$status = false;

			$db 	= $this->M_visitor->get_visitor_card(['id_kartu' => $this->input->post('id')]);
			if($db){
				$status = true;

				$data['id_kartu'] 	= $db[0]->id_kartu;
				$data['no_kartu'] 	= $db[0]->no_kartu;
				$data['nama_kartu'] = $db[0]->nama_kartu;
			}

			$this->output->set_content_type('application/json')->set_output(json_encode(['status' => $status, 'data' => $data]));
		}
	}

	function ajax_new_kartu(){
		if($this->input->method(FALSE) == 'post'){
			$status = true;
			$error 	= null;

			$this->form_validation->set_rules('no_kartu', 'Kode Kartu', 'required|trim');
            $this->form_validation->set_rules('nama_kartu', 'Nama Kartu', 'required|trim');
            
			if($this->form_validation->run() != FALSE){
				
				$db = false;

				foreach ($this->input->post() as $i => $v) {
					if($i == 'id_kartu'){ continue; }
					if($i == 'nama_kartu'){
						$data[$i] = strtoupper($v);
						continue;
					}

					$data[$i] = $v;
				}
				
				if(! empty($this->input->post('id_kartu'))){
					// insert data baru
					$data['updated_at'] = date('Y-m-d H:i:s');

					$db = $this->M_visitor->update_card(['id_kartu' => $this->input->post('id_kartu')], $data);
				}else{
					// insert data baru
					$data['created_at'] = date('Y-m-d H:i:s');
					
					$db = $this->M_visitor->insert_new_card($data);
				}

				if(! $db){ 
					$status = false;
					$error 	= "Gagal Mengupdate Entri";
				}
			}else{
				$status = false;
				$error 	= validation_errors();
			}

			$this->output->set_content_type('application/json')->set_output(json_encode(['status' => $status, 'msg' => $error]));
		}
	}

	function ajax_delete_kartu(){
		if($this->input->method(FALSE) == 'post'){
			$status = true;
			$error 	= null;

			$db = $this->M_visitor->delete_card($this->input->post('id'));
			if(! $db){ 
				$status = false;
				$error 	= "Gagal Menghapus Entri";
			}
			$this->output->set_content_type('application/json')->set_output(json_encode(['status' => $status, 'msg' => $error]));
		}

	}
}
