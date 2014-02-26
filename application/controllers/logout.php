<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class LogOut extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('session');
	}

	public function index()
	{
		$redirect = $this->input->get('url');
		$this->session->sess_destroy();
		// $redirect = $this->input->get('curr_url');
		// $this->load->model('logout');
		redirect($redirect);
	}
	
	public function cart(){
		$this->session->unset_userdata('uid');
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('logged_in');
	}
}