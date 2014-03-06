<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Create extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('session');
		$this->load->database();
		$this->load->model('photo_model');
	}

	public function index()
	{
	}
	
	function site()
	{
		if(!$this->session->userdata('logged_in')) {
			redirect(base_url());
			exit(0);
		}
			
		$site['username'] = $this->session->userdata('username');

		$data['content'] = $this->load->view('create/site', $site, true);
		
		$data['activemenu'] = 'manage';
		$data['sidebar'] = $this->load->view('dashboard/sidebar', $data, true);
		$data['bar_holder'] = $this->load->view('bar_holder', $data, true);
		$data['body'] = $this->load->view('manage_account', $data, true);
		$data['footer'] = '';
		
		$this->load->view('dashboard/template', $data);
	}
	
}

/* End of file create.php */
/* Location: ./application/controllers/create.php */