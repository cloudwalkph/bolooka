<?php

class Session_model extends CI_Model {

	function __construct()
	{
		$this->load->database();
		$this->load->library('session');
	}
	
	function check_session() {
		$this->db->where('session_id', $this->session->userdata('session_id'));
		$query = $this->db->get('ci_sessions');
		if($query->num_rows == 1)
		{
			return true;
		}
	}
	
	function create_session($uid=null, $username=null)
	{
		$newdata = array(
						   'uid' => $uid,
						   'username' => $username,
						   'logged_in' => TRUE
					   );

		$this->session->set_userdata($newdata);
		$data = $this->session->all_userdata();
		
		return $data;
	}
}

?>