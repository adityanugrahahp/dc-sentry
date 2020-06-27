<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_user_loket extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	function get_user($where = [], $like = [], $limit = null, $offset = 0){
		
		if($where){ $this->db->where($where); }

		if($like){ $this->db->like($like); }

		if($limit && $offset){ 
			$this->db->limit($where); 
		}

		$q = $this->db->get('user_loket');

		return ($q) ? $q->result() : [];
	}
}

/* End of file mantrian.php */
/* Location: ./application/models/mantrian.php */