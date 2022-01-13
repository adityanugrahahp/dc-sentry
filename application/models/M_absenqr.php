<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_absenqr extends MY_Model {

	public function __construct(){
		parent::__construct();

		$this->tabel 	= 'visitor_qr';
		$this->seq_name	= 'visitor_qr_id_seq';
	}

	// data cabang + kantor pusat
	function get_unit_kerja(){
		$this->db->select('
			utk_kode, 
			utk_ket, 
			flag_level,
			(select count(id) from visitor_qr where lower(lokasi) = lower(utk_ket)) as jumlah_screen
		');
		
		$this->db->where('
			flag_berlaku = \'Y\'
			AND (level2 = \'GPP\' and flag_level = 2) -- PUSAT
			OR (level2 = \'GPC\' and flag_level = 4) -- CABANG
			/** OR (level2 = \'GPK\' and flag_level = 4) -- KAPAL */
		');

		$this->db->group_by('utk_kode, utk_ket, flag_level');
		$this->db->order_by('flag_level, utk_kode', 'ASC');

		$q = $this->db->get('unit_kerja');

		return ($q) ? $q->result() : [];
	}

	// data cabang + kantor pusat
	function get_cabang($where = [], $cab_st_aktif = 'Y'){
		$this->db->select('
			cab_kode, 
			cab_ket, 
			(select count(id) from visitor_qr where lower(lokasi) = lower(cab_ket)) as jumlah_screen
		');
		
		$this->db->where([
			'flag_sdm_berlaku' 	=> 'Y', 
			'cab_st_aktif' 		=> $cab_st_aktif,
			'cab_kode !='		=> '04A'
		]);

		if($where){
			$this->db->where($where);
		}

		$this->db->where('cab_st_kp', 'Y');

		$this->db->order_by('cab_sdm_klass ASC, cab_kode ASC');

		$q = $this->db->get('cabang');

		return ($q) ? $q->result() : [];
	}
}