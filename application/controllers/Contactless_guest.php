<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Contactless_guest extends MY_Controller {

	public function index(){
		$this->load->view('contactless_guest/index');
	}
}