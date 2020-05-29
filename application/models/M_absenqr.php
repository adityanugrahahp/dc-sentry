<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_absenqr extends MY_Model {

	public function __construct(){
		parent::__construct();

		$this->tabel 	= 'visitor_qr';
		$this->seq_name	= 'visitor_qr_id_seq';
	}
}