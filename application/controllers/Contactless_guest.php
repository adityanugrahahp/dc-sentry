<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Contactless_guest extends MY_Controller {

	public function index(){
		$opt = [];
		// daftar nama lantai
		for($i = 1;$i <= 11; $i++){
			$opt['Lantai '.$i] = 'Lantai '.$i;
		}

			$data['tujuan'] 	= $opt;

		$this->load->view('contactless_guest/index', $data);
	}
}