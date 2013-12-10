<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Activation extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('encrypt');
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->database();
		$this->load->model('session_model');
		$this->load->model('membership_model');
		$this->load->library('email');
	}
	function index() {
	
	}
	
	function check($id, $sequence)
	{
		$data['ids'] = $id;
		$data['sequence'] = $sequence;
		//$passwordHash = $this->encrypt->decode($sequence);
		if($id != "")
		{
			$this->db->query("UPDATE `users` SET `email_status`='1' WHERE `uid`='$id' AND `hash`='$sequence'");
			$dbl_check = $this->db->query("SELECT * FROM `users` WHERE `uid`='$id' AND `hash`='$sequence' AND `email_status`='1'");
			if($dbl_check->num_rows() > 0)
			{
				foreach ($dbl_check->result() as $row)
				{
					$uid = $row->uid;
					$username = $row->first_name;
				}
			
				$data['check'] = 'success';
				$data['msgtouser'] = '<h2 style="font-family: \'ScalaSans Light\';font-size: 29px;">Your account has been activated!</h2>';
				$this->session_model->create_session($id, $username);
				$this->load->view('activate', $data);
			}
			else
			{
				$data['check'] = 'failed';
				$data['msgtouser'] = '<h2 style="font-family: \'ScalaSans Light\';font-size: 29px;">Your account could not be activated!</h2><strong style="top: -26px;position: relative;font-size: 13px;font-family:Century Gothic;margin-left:30px;">Please email info@bolooka.com and request for manual activation.</strong><br/>';
				$this->load->view('activate', $data);
			}
		}
	}
}