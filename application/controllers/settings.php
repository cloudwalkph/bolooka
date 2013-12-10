<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('encrypt');
		$this->load->library('session');
		$this->load->model('times_model');
		$this->load->model('wall_updates');
		$this->load->model('photo_model');
		$this->load->library('email');
		$this->load->helper('date');
		$this->load->database();
		date_default_timezone_set('Asia/Manila');
	}

	function index() {
		if($this->session->userdata('logged_in')) {
			if(isset($_GET['a'])) {
				if($_GET['a'] == 'update')
				{
					$this->update();
				}
			} else {
				$data['pass_error'] = '';
				$data['activemenu'] = '';
				$data['sidebar'] = $this->load->view('dashboard/sidebar', $data, true);
				$data['content'] = $this->load->view('manage/account_settings', '', true);

				$data2home['bar_holder'] = $this->load->view('bar_holder', '', true);
				$data2home['body'] = $this->load->view('manage_account', $data, true);
				$data2home['footer'] = '';
				
				$this->load->view('dashboard/template', $data2home);
			}
		} else {
			redirect(base_url());
		}
	}
	
	function update()
	{
		$this->load->library('encrypt');
		
		if($button = $this->input->post('button'))
		{
			if($button=='deactivate')
			{
				echo 'account deactivate';
			}
			elseif($button=='settings')
			{
				/* publish */
				$pub_blog = $this->input->post('publish_blog');
				$pub_gal = $this->input->post('publish_gal');
				$userId = $this->session->userdata('uid');
				if(($pub_blog) AND (!$pub_gal))
				{
					$this->db->query('UPDATE users SET publish_blog = "'.$pub_blog.'" WHERE uid = "'.$userId.'"');
					$this->db->query('UPDATE users SET publish_gallery = "no" WHERE uid = "'.$userId.'"');
					
				}
				if(($pub_gal) AND (!$pub_blog))
				{
					$this->db->query('UPDATE users SET publish_gallery = "'.$pub_gal.'" WHERE uid = "'.$userId.'"');
					$this->db->query('UPDATE users SET publish_blog = "no" WHERE uid = "'.$userId.'"');
				}
				if(($pub_blog) AND ($pub_gal))
				{
					$this->db->query('UPDATE `users` SET `publish_blog` = "'.$pub_blog.'", `publish_gallery` = "'.$pub_gal.'" WHERE `uid` = "'.$userId.'"');
				}
				if((!$pub_blog) AND (!$pub_gal))
				{
					$this->db->query('UPDATE `users` SET `publish_blog` = "no", `publish_gallery` = "no" WHERE `uid` = "'.$userId.'"');
				}

				$data['pass_error'] = '';
				
				if($this->input->post('pass')!=null)
				{
					$this->db->where('uid', $this->session->userdata('uid'));
					$query = $this->db->get('users');

					foreach ($query->result() as $row)
					{
						$password = $row->password;
					}
					if($this->input->post('pass')==$this->encrypt->decode($password))
					{
						if($this->input->post('new_pass')!=null)
						{
							if($this->input->post('new_pass') == $this->input->post('re_pass'))
							{
								$password = $this->input->post('new_pass');
								$profile_update_data['password'] = $this->encrypt->encode($password);
								$data['pass_error'] = '';
								$data['save'] = 'success';
							}
							else
							{
								$data['pass_error'] = 'password did not match';
								$data['save'] = 'fail1';
							}
						}
						else
						{
							$data['pass_error'] = 'new password cannot be blank';
							$data['save'] = 'fail2';
						}
					}
					else
					{
						$data['pass_error'] = 'Current password did not match';
						$data['save'] = 'fail3';
					}
					if(isset($profile_update_data['password'])) {
						$this->db->where('uid', $this->session->userdata('uid'));
						$insert = $this->db->update('users', $profile_update_data);
					}
				}

				
				echo $data['save'];
			}
		}
	}
	function deactivate_account() {
		$uid = $this->input->post('uid');
		$pass = $this->input->post('pass');
		
		$this->db->where('uid',$uid);
		$query = $this->db->get('users');
		$user = $query->row();
		
		if($query->num_rows() > 0)
		{
			$currentPass = $this->encrypt->decode($user->password);
			
			if($currentPass == $pass)
			{
				$success = $this->update_account($uid);
				echo $success;
				
			}else
			{
				echo 'error';
			}
		}
	}
	
	function update_account($uid=null) {
		
		$data_users = array(
			'email_status' => '2',
			'fb_id_fk' => null,
			'y_id_fk' => null, 
			'g_id_fk' => null,
			'msn_id_fk' => null 
		);
		$this->db->where('uid',$uid);
		$this->db->update('users',$data_users);
		echo 'success';
		
	}
}