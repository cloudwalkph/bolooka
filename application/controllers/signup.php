<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SignUp extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('encrypt');
		$this->load->library('session');
		$this->load->model('session_model');
		$this->load->model('membership_model');
		$this->load->library('form_validation');
		$this->load->library('email');
		$this->load->database();
	}

	public function index()
	{
		$fname = $this->input->post('first_name');
		$lname = $this->input->post('last_name');
		$email = $this->input->post('email');
		$pass = $this->input->post('p1');
		$pass2 = $this->input->post('p2');
		$enpass = $this->encrypt->encode($pass);
		$hash = md5($email.time());

		$save = $this->membership_model->create_member(null, null, $fname, $lname, $email, $hash, $enpass);
		
		# Send Email
			$this->sendemail($email, $fname, $hash, $pass);
		
		$data2['firstname'] = $fname;
		$data['body'] = $this->load->view('msgtouser', $data2);
		$this->load->view('dashboard/template', $data);
	}
	
	function first_sign_up() 
	{
		$email = $this->input->post('email1');
		$pass1 = $this->input->post('pass1');
		$pass2 = $this->input->post('pass2');
		
		$this->db->where('email',$email);
		$query = $this->db->get('users');
		
		if($query->num_rows() > 0)
		{
			echo '1';
		}else
		{
			echo '2';
		}
	}
	
	function go_sign_up_form()
	{		
		$data2body['sign_up_form'] = $this->load->view('homepage/sign_up_form', '', TRUE); 
		$this->load->view('homepage', $data2body);		
	}

	function checkEmail() {
		$email = $this->input->post('email');
		$queryEmail = 'SELECT `email` from `users` where `email` = "'.$email.'"';
		$checkEmail = $this->db->query($queryEmail);
		
		if($checkEmail->num_rows() > 0)
		{
			echo 'Email already exists.';
		}
	}
	
	function connected_fb()
	{
		$uid = $this->input->post('uid');
		$query = $this->db->query("SELECT * FROM `users` WHERE uid = '".$uid."' ");
		$queryRows = $query->row_array();
		
		if($queryRows['fb_id_fk'] != '' || $queryRows['fb_id_fk'] != null)
		{
			echo 'meron';
		}else
		{
			echo 'wala';
		}
	}
	
	function connect_to_fb()
	{
		$fid = $this->input->post('id');
		$uid = $this->session->userdata('uid');
		
		$query = $this->db->query("SELECT * FROM `users` WHERE fb_id_fk = ".$fid." ");
		if($query->num_rows() > 0)
		{	
			echo 'meron';
		}else
		{
			$data_update = array(
				'fb_id_fk' => $fid,
				'publish_blog' => 'yes',
				'publish_gallery' => 'yes'
			);
			$this->db->where('uid',$uid);
			$this->db->update('users',$data_update);
			echo 'wala';
		}
	}
	
	function fbcheckEmail()
	{
		$checkEmail = $this->input->post('email');
		$query = $this->db->query("SELECT * FROM users WHERE email LIKE '%".$checkEmail."%' ");
		if($query->num_rows() > 0)
		{
			echo 'email rejected';
		}else
		{
			echo 'email accepted';
		}
	}
	
	function disconnected_fb()
	{
		$uid = $this->input->post('uid');
		$query = $this->db->query("SELECT * FROM `users` WHERE uid = '".$uid."' ");
		if($query->num_rows() > 0)
		{
			$data_update = array(
				'fb_id_fk' => null,
				'publish_blog' => 'no',
				'publish_gallery' => 'no'
			);
			$this->db->where('uid',$uid);
			$this->db->update('users',$data_update);
			
			echo 'success';
		}
	}
	
	function facebook()
	{
		$fbid = $_REQUEST['id'];
		$fbname = $_REQUEST['first_name'];
		$fblastname = $_REQUEST['last_name'];
		$fbemail = $_REQUEST['email'];
		$fbbday = $_REQUEST['bdays'];
		$fbgender = $_REQUEST['gender'];
		$hash = md5($fbemail);
		
		$query = $this->db->query("SELECT * FROM users WHERE fb_id_fk='".$fbid."' ");
		
		if($query->num_rows() > 0)
		{
			foreach($query->result_array() as $row)
			{
				$uid = $row['uid'];
				$fb_name = $row['first_name'];
			}
			$this->session_model->create_session($uid, $fb_name);
		}
		else
		{
			echo 'create new account';
		}
	}
	
	function account($account_type)
	{
		date_default_timezone_set('Asia/Manila');
		
		if($account_type == 'fb')
		{
			/*get all data*/
			$fbid = $this->input->post('fb_id');
			$fbname = $this->input->post('fb_first');
			$fblastname = $this->input->post('fb_last');
			$email = $this->input->post('email');
			$pass = $this->input->post('fb_pass');
			$passEn = $this->encrypt->encode($pass);
			$hash = md5($email.time());
			
			/*check if email already exist*/
			$queryCheck = $this->db->query("SELECT * FROM users WHERE email = '$email'");
			if($queryCheck->num_rows() > 0)
			{
				$emailcheck = $queryCheck->row();
				$emailer = $emailcheck->email;
				$userid = $emailcheck->uid;
				$this->db->query("UPDATE users SET oauth_type = 'facebook', fb_id_fk = '$fbid', password = '$passEn' WHERE email like '$emailer'");
				// $this->session_model->create_session($userid, $fbname);
				echo '1';
			}
			else
			{
				$oauth_type = 'facebook';
				$member_create = array(
					'oauth_type' => $oauth_type,
					'name' => $fbname . " " . $fblastname,
					'first_name' => $fbname,
					'last_name' => $fblastname,
					'email' => $email,
					'hash' => $hash,
					'password' => $passEn,
					'email_status' => '1',
					'date_registered' => time(),
					'date_last_login' => time(),
					'fb_id_fk' => $fbid
				);
				/*insert to users*/
				$insert = $this->db->insert('users', $member_create);
				
				/*query after user save*/
				$this->db->where('email', $email);
				$query = $this->db->get('users');
				foreach($query->result() as $row)
				{
					$uid = $row->uid;
				}			
				
				$this->db->where('id',$fbid);
				$queryFB = $this->db->get('fb_account');
				if($queryFB->num_rows() == 0)
				{
					/*save data to fb_account*/
					$member_account = array(
						'id' => $fbid,
						'user_id_fk' => $uid,
						'email' => $email,
						'first_name' => $fbname,
						'last_name' => $fblastname
					);
					$insert1 = $this->db->insert('fb_account', $member_account);
				}
				
				/*create session id*/
				$this->session_model->create_session($uid, $fbname);
				
				echo 'fb created';
			}
		}
		elseif($account_type == 'yahoo')
		{
			/*get all data*/
			$yid = $this->input->post('y_id');
			$yname = $this->input->post('y_name');
			$ylastname = $this->input->post('y_last');
			$email = $this->input->post('email');
			$pass = $this->input->post('y_pass');
			$passEn = $this->encrypt->encode($pass);
			$hash = md5($email);
			
			$queryCheck = $this->db->query("SELECT * FROM users WHERE email = '$email'");
			if($queryCheck->num_rows() > 0)
			{
				
				$emailcheck = $queryCheck->row();
				$emailer = $emailcheck->email;
				$userid = $emailcheck->uid;
				$this->db->query("UPDATE users SET y_id_fk = '$yid', password = '$passEn' WHERE email like '$emailer'");
				$this->session_model->create_session($userid, $yname);
				echo '1';
			}
			else
			{
				$oauth_type = 'yahoo'; 
				$member_create = array(
					'oauth_type' => $oauth_type,
					'name' => $yname . " " . $ylastname,
					'first_name' => $yname,
					'last_name' => $ylastname,
					'email' => $email,
					'hash' => $hash,
					'password' => $passEn,
					'email_status' => '1',
					'date_registered' => time(),
					'date_last_login' => time(),
					'y_id_fk' => $yid
				);
				
				/*save to users*/
				$insert = $this->db->insert('users', $member_create);
				
				/*query after users save*/
				$this->db->where('email', $email);
				$query = $this->db->get('users');
				foreach($query->result() as $row)
				{
					$uid = $row->uid;
				}			
				
				/*save data to fb_account*/
				$member_account = array(
					'id' => $yid,
					'user_id_fk' => $uid,
					'email' => $email,
					'first_name' => $yname,
					'last_name' => $ylastname
				);
				$insert1 = $this->db->insert('y_account', $member_account);
				
				/*create session id*/
				$this->session_model->create_session($uid, $yname);
				
				echo 'user created';
			}
		}elseif($account_type == 'google')
		{
			/*get all data*/
			$gid = $this->input->post('g_id');
			$gname = $this->input->post('g_name');
			$glastname = $this->input->post('g_last');
			$email = $this->input->post('email');
			$pass = $this->input->post('g_pass');
			$passEn = $this->encrypt->encode($pass);
			$hash = md5($email);
			
			$queryCheck = $this->db->query("SELECT * FROM users WHERE email = '$email'");
			if($queryCheck->num_rows() > 0)
			{
				
				$emailcheck = $queryCheck->row();
				$emailer = $emailcheck->email;
				$userid = $emailcheck->uid;
				$this->db->query("UPDATE users SET oauth_type = 'google', g_id_fk = '$gid', password = '$passEn' WHERE email like '$emailer'");
				$this->session_model->create_session($userid, $gname);
				echo '1';
			}
			else
			{
				$oauth_type = 'google'; 
				$member_create = array(
					'oauth_type' => $oauth_type,
					'name' => $gname . " " . $glastname,
					'first_name' => $gname,
					'last_name' => $glastname,
					'email' => $email,
					'hash' => $hash,
					'password' => $passEn,
					'email_status' => '1',
					'date_registered' => time(),
					'date_last_login' => time(),
					'g_id_fk' => $gid
				);
				
				/*save to users*/
				$insert = $this->db->insert('users', $member_create);
				
				/*query after users save*/
				$this->db->where('email', $email);
				$query = $this->db->get('users');
				foreach($query->result() as $row)
				{
					$uid = $row->uid;
				}			
				
				/*save data to fb_account*/
				$member_account = array(
					'id' => $gid,
					'user_id_fk' => $uid,
					'email' => $email,
					'first_name' => $gname,
					'last_name' => $glastname
				);
				$insert1 = $this->db->insert('g_account', $member_account);
				
				/*create sessaion id*/
				$this->session_model->create_session($uid, $gname);
				
				echo 'user created';
			}
		}else if($account_type == 'msn')
		{
			/*get all data*/
			$msnid = $this->input->post('msn_id');
			$msnname = $this->input->post('msn_name');
			$msnlastname = $this->input->post('msn_last');
			$email = $this->input->post('email');
			$pass = $this->input->post('msn_pass');
			$passEn = $this->encrypt->encode($pass);
			$hash = md5($email);
			
			$queryCheck = $this->db->query("SELECT * FROM users WHERE email = '$email'");
			if($queryCheck->num_rows() > 0)
			{
				
				$emailcheck = $queryCheck->row();
				$emailer = $emailcheck->email;
				$userid = $emailcheck->uid;
				$this->db->query("UPDATE users SET msn_id_fk = '$msnid', password = '$passEn' WHERE email like '$emailer'");
				$this->session_model->create_session($userid, $msnname);
				echo '1';
			}
			else
			{
				$oauth_type = 'msn'; 
				$member_create = array(
					'oauth_type' => $oauth_type,
					'name' => $msnname . " " . $msnlastname,
					'first_name' => $msnname,
					'last_name' => $msnlastname,
					'email' => $email,
					'hash' => $hash,
					'password' => $passEn,
					'email_status' => '1',
					'date_registered' => time(),
					'date_last_login' => time(),
					'msn_id_fk' => $msnid
				);
				
				/*save to users*/
				$insert = $this->db->insert('users', $member_create);
				
				/*query after users save*/
				$this->db->where('email', $email);
				$query = $this->db->get('users');
				foreach($query->result() as $row)
				{
					$uid = $row->uid;
				}			
				
				/*save data to fb_account*/
				$member_account = array(
					'id' => $msnid,
					'user_id_fk' => $uid,
					'email' => $email,
					'first_name' => $msnname,
					'last_name' => $msnlastname
				);
				$insert1 = $this->db->insert('msn_account', $member_account);
				
				/*create sessaion id*/
				$this->session_model->create_session($uid, $msnname);
				
				echo 'user created';
			}
		}
	}
	
	function yin()
	{
		$this->load->file('api/Yahoo_Oauth_YOS/yahoo_connect.php');
	}

	function msn()
	{	
		$msnId = $_REQUEST['id'];
		$firstname = $_REQUEST['first_name'];
		$lastname = $_REQUEST['last_name'];
		$email = $_REQUEST['email'];
		$gender = $_REQUEST['gender'];
		
		$query = $this->db->query("SELECT * FROM users WHERE email='$email'");
		
		if($query->num_rows() > 0)
		{
			$this->db->query("UPDATE users SET oauth_type = 'msn', msn_id_fk = '$msnId' WHERE email like '$email'");

			foreach($query->result_array() as $row)
			{
				$uid = $row['uid'];
				$msn_name = $row['first_name'];
			}
			$this->session_model->create_session($uid, $msn_name);
		}
		else
		{
			echo 'create new account';
		}
	}
	
	function store()
	{
		$this->load->library('encrypt');
		$this->load->view('store_user_data');
	}
	
	function verification_resend($email=null) {
		$email = $this->input->get('email');
		
		$this->db->where('email', $email);
		$queryUser = $this->db->get('users');
		$rowUser = $queryUser->row_array();
		
		if($queryUser->num_rows > 0) {
			$pass = $this->encrypt->decode($rowUser['password']);
			$hash = $rowUser['hash'];
			$fname = $rowUser['first_name'];
		
			$this->sendemail($email, $fname, $hash, $pass);
		}
		redirect(base_url());
	}
	
	function sendemail($email, $fname, $hash, $pass) {
		$this->db->where('email', $email);
		$query = $this->db->get('users');
		
		foreach($query->result() as $row)
		{
			$uid = $row->uid;
		}
					$config['mailtype'] = 'html';
					$config['charset'] = 'iso-8859-1';
					$config['wordwrap'] = TRUE;
					
					$this->email->initialize($config);
		
		$message = '
		<img src="'.base_url().'img/bolooka-logo.png" width="150px" /><br />
		<hr style="color:red;"><br/>
		Hi '.$fname.',<br />
		<br />
		Thank you for signing up at Bolooka!<br />
		<br />
		To activate your account please click the link below:<br />
		<br />
		<a href="'.base_url().'activation/check/'.$uid.'/'.$hash.'">'.base_url().'activation/check/'.$uid.'/'.$hash.'</a><br />
		If the URL above did not redirect you, please copy and paste it to your browser&rsquo;s address bar.<br />
		<br />
		Your log-in details:  <br />
		E-mail Address: '.$email.' <br />
		Password: '.$pass.'<br />
		<br />
		Thanks and long live Pinoy products!<br />
		<br />
		From Bolooka Team
		';

		$this->email->from('info@bolooka.com', 'Bolooka');
		$this->email->to($email); 
		//$this->email->cc('another@another-example.com'); 
		//$this->email->bcc('them@their-example.com'); 

		$this->email->subject('Bolooka Registration Activation');
		$this->email->message($message);	

		$this->email->send();
	}
	
	function sendFacebook($email, $fname, $hash, $pass) {
		
		$this->db->where('email', $email);
		$query = $this->db->get('users');
		
		foreach($query->result() as $row)
		{
			$uid = $row->uid;
		}
		
		$message = 'Hi '.$fname.',

		Your log-in details:  
		E-mail Address: '.$email.' 
		Password: '.$pass.'

		Thanks!
		
		From Bolooka Team
		';

		$this->email->from('info@bolooka.com', 'Bolooka');
		$this->email->to($email); 
		//$this->email->cc('another@another-example.com'); 
		//$this->email->bcc('them@their-example.com'); 

		$this->email->subject('Bolooka Registration Activation');
		$this->email->message($message);	

		$this->email->send();
	}
	
	function email_fb_friends() {
	
		$this->db->where('uid',$this->session->userdata('uid'));
		$user_query = $this->db->get('users');
		$row_user = $user_query->row_array();
		if($user_query->num_rows() > 0)
		{
			$userName = $row_user['name'];
		}else
		{
			$userName = '';
		}
		$fb_id = $this->input->post('fb_id');
		$fb_name = $this->input->post('fb_name');
		
		$id = explode(',',$fb_id);
		$name = explode(',',$fb_name);
		for($x=0; $x < count($id); $x++)
		{
			/* for email notification */
			$this->db->where('id',$id[$x]);
			$query = $this->db->get('fb_account');
			
			$row = $query->row_array();
			if($query->num_rows() > 0)
			{
				if($row['id'] == $id[$x])
				{
					$config['mailtype'] = 'html';

					$this->email->initialize($config);
					
					$message = 'Hi <span style="font-weight:bold;">'.$row['first_name'].'</span>,<br/> 
					
					Your Facebook friend <span style="font-weight:bold;">'.$userName.'</span> just joined Bolooka.<br/> 
					Check Bolooka to find awesome and unique local products in the country 
					
					<a href="'.base_url().'">Go to bolooka</a>';
					
					$this->email->from('info@bolooka.com', 'Bolooka');
					$this->email->to($row['email']);
					$this->email->subject('Your Facebook friend '.$userName.' joined Bolooka');
					$this->email->message($message);
					
					$this->email->send();
				}
			}
			/* end of email notification */
			
			/* for bolooka notification */
			$this->db->where('fb_id_fk',$id[$x]);
			$get_bolooka_user = $this->db->get('users');
			$row_bolooka = $get_bolooka_user->row_array();
			
			if($get_bolooka_user->num_rows() > 0)
			{
				$notify_user = $row_bolooka['uid'];
				$status = 1;
				$action = 'new users';
				$event_user = $this->session->userdata('uid');
				$oras = time();
				
				$data_flag = array(
					'uid' => $event_user,
					'status' => $status,
					'notify' => $notify_user,
					'time' => $oras,
					'action' => $action
				);
				
				$this->db->insert('flag',$data_flag);
			}
			
			/* end of bolooka notification */
		}
	}
}