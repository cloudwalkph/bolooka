<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SignIn extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('encrypt');
		$this->load->library('session');
		$this->load->library('email');
		$this->load->model('membership_model');
		$this->load->library('form_validation');
		$this->load->database();
	}
	
	function index()
	{
		$email = $this->input->post('email');
		$pass = $this->input->post('password');
		// $redirect_url = $this->input->post('redirect_url');
		
		$data['email'] = $email;
		
		$this->db->where('email', $email);
		$queryUser = $this->db->get('users');
		$rowUser = $queryUser->row();
		if($queryUser->num_rows > 0) {
			if($pass == $this->encrypt->decode($rowUser->password)) {
				
				/* check if email is verify */
				if($rowUser->email_status == 1) {
					$user = array(
						'uid' => $rowUser->uid,
						'v_email' => $rowUser->email,
						'v_pass' => $this->encrypt->decode($rowUser->password),
						'v_firstName' => $rowUser->first_name
					);

					$this->session_model->create_session($user['uid'], $user['v_firstName']);
					
					$user_log_update = array(
						'date_last_login' => time()
					);
					$this->db->where('uid', $user['uid']);
					$this->db->update('users', $user_log_update);
					
					$data_userlogs = array(
						'user_id' => $user['uid'],
						'date_last_login' => time()
					);
					$this->db->insert('user_logs', $data_userlogs);
					// $data['redirect_url'] = $redirect_url;
				} else if($rowUser->email_status == 2) {
					$data['code'] = '-4'; // deactivated account.
				} else {
					$data['code'] = '-3'; // Please check your email to verify you account.
				}
			} else {
				$data['code'] = '-2'; // Email / Password Incorrect.
			}
		} else {
			$data['code'] = '-1'; //Email account not found.
		}
		echo json_encode($data);
	}
	
	function email_check()
	{
		$email = $this->input->post('email');
		$query = $this->db->query("SELECT * FROM `users` WHERE `email`='$email' LIMIT 1");
		$row = $query->row();
		if($query->num_rows() > 0)
		{
			echo 1;
		}
		else
		{
			echo 0;
		}
	}
	
	function decode($con_pass)
	{
		//$this->encrypt->decode($con_pass);
		echo $this->encrypt->encode($con_pass);
	}
	
	function emailSendPass()
	{
		$email = $this->input->post('email');
		
		/* this is for security code */
		$hash = md5($email.time());
		$data_users = array(
			'hash' => $hash
		);
		$this->db->where('email',$email);
		$this->db->update('users',$data_users);
		
		$query = $this->db->query("SELECT * FROM `users` WHERE `email`='$email' LIMIT 1");
		$row = $query->row();
		$uid = $row->uid;
		
		if($query->num_rows() > 0)
		{
					$config['mailtype'] = 'html';
					$config['charset'] = 'iso-8859-1';
					$config['wordwrap'] = TRUE;
					
					$this->email->initialize($config);
			
			$message = '
				Hi, '. $row->first_name .'<br/>

				You recently asked to reset your Bolooka password.<br/>  
				<a href="'.base_url().'?u='.$uid.'&n='.$hash.'" target="_blank">Change password</a><br/>
				
				Thanks!<br/>
				
				From Bolooka Team
			';
			
			$this->email->from('info@bolooka.com');
			$this->email->to($row->email);   
 
			$this->email->subject('Bolooka Reset Password');
			$this->email->message($message);

			if($this->email->send())
			{
				echo 1;
			}
			else
			{
				echo 0;
			}
		}
	}
	
	function form()
	{
		$this->load->view('homepage/sign_in_form');
	}
}