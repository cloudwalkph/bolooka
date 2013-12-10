<?php

class Membership_model extends CI_Model {

	function __construct()
	{
		$this->load->database();
		$this->load->library('encrypt');
		$this->load->model('session_model');
		$this->load->library('session');

		date_default_timezone_set('Asia/Manila');

	}

	function validate_member()
	{
		$this->db->where('email', $this->input->post('email'));
		$query = $this->db->get('users');
		
		if($query->num_rows > 0)
		{
			return $query;
		}
	}
	
	function create_member($oauth_type, $guid, $fname, $lname, $email, $hash, $password, $gender=null, $bday=null, $status=0)
	{
		$new_member_insert_data = array(
			'oauth_type' => $oauth_type,
			'guid' => $guid,
			'name' => $fname . " " . $lname,
			'first_name' => $fname,
			'last_name' => $lname,
			'email' => $email,
			'hash' => $hash,
			'password' => $password,
			'gender' => $gender,
			'dob' => $bday,
			'email_status' => $status,
			'date_registered' => time()
		);
		$insert = $this->db->insert('users', $new_member_insert_data);
		
		$uid = $this->db->insert_id();
		# make default pick-up and meet-up delivery method checked
		$delivery_method = array(
			'pickup' => true,
			'meetup' => true
		);
		$chkssetting = json_encode($delivery_method);
		$payment_settings_data = array(
			'settings' => $chkssetting,
			'user_id' => $uid
		);
		$this->db->insert('checkout_settings', $payment_settings_data);
		
		return $new_member_insert_data;
	}
}