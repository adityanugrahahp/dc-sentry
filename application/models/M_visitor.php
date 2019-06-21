<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_visitor extends CI_Model {


	public function __construct()
	{
		parent::__construct();
	}

	// add new code DM
	function insert_new_visitor($data){
		$query = $this->db->insert('visitor_registration', $data);

		return ($query) ? true : false;
	}

	function get_new_visitor($where = [], $like = null, $limit = null, $offset = null){
		$this->db->select('*');
		$this->db->join('visitor_cards', 'visitor_registration.id_visitor_card = visitor_cards.id_kartu', 'left');
		$this->db->where($where);
		
		if($like){
			$this->db->like($like);
		}

		$this->db->limit($limit, $offset);
		$this->db->order_by('register_time', 'desc');
		$query = $this->db->get('visitor_registration');

		return ($query) ? $query->result() : false;
	}

	function update_visitor($where = [], $data = []){
		$this->db->where($where);
		$query = $this->db->update('visitor_registration', $data);

		return ($query) ? true : false;
	}

	function get_visitor_card($where = []){
		$this->db->where($where);
		$query = $this->db->get('visitor_cards');

		return ($query) ? $query->result() : false;
	}

	function insert_new_card($data){
		$id = 1;
		$this->db->select('id_kartu');
		$this->db->order_by('id_kartu', 'desc');
		$this->db->limit(1);
		$query_current = $this->db->get('visitor_cards');
		if($query_current){ 
			$id = $query_current->result()[0]->id_kartu + 1;
		}

		$data['id_kartu'] = $id;
		$query = $this->db->insert('visitor_cards', $data);

		return ($query) ? $this->db->insert_id() : false;
	}

	// end add new code DM

	public function insert_visitor($data)
	{
		
		$id = 1;
		$this->db->select('id');
		$this->db->order_by('id', 'desc');
		$this->db->limit(1);
		$query_current = $this->db->get('visitor_registration');
		if($query_current->num_rows()>0)
		{
			$id = $query_current->row()+1;
		}

		$data_array = array(
			"id" => $id,
			"nik" => $data["nik"],
			"nama" => $data["nama"],
			"jenis_kelamin" => $data["jenis_kelamin"],
			"tgl_lahir" => $data["tgl_lahir"],
			"no_hp" => $data["no_hp"],
			"alamat" => $data["alamat"],
			"tujuan" => $data["tujuan"],
			"keperluan" => $data["keperluan"],
			"register_time" => date(),
			"id_visitor_card" => $data["id_visitor_card"],
		);
		$this->db->insert('visitor_registration', $data_array);
		return ($this->db->affected_rows() != 1) ? false : true;
	}

	public function login($username,$password)
	{
		$this->db->where('username', $username);
		$this->db->where('password', $password);
		$query = $this->db->get('user_loket');
		if($query->num_rows()>0)
		{
			return array('status'=>'success','status_message'=>'OK','data'=>$query->row_array());
		}
		else
		{
			return array('status'=>'error','invalid credential'=>'OK','data'=>array());
		}
	}

	

}

/* End of file mantrian.php */
/* Location: ./application/models/mantrian.php */