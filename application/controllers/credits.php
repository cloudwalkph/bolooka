<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Credits extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('encrypt');
		$this->load->library('session');
		$this->load->model('times_model');
		$this->load->library('email');
		$this->load->helper('date');
		$this->load->database();
		$this->load->model('photo_model');
		$this->load->model('times_model');
	}

	function index() {
		$this->db->query('
			CREATE TABLE IF NOT EXISTS `tbl_credits` (
			  `user_id` int(11) NOT NULL,
			  `site_id` int(11) NOT NULL,
			  `action` text NOT NULL,
			  `object` text NOT NULL,
			  `amount` int(11) NOT NULL,
			  `timestamp` int(11) NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=latin1;
		');

		if($this->session->userdata('logged_in')) {
			$data['uid'] = $this->session->userdata('uid');
			$data['activemenu'] = 'credits';
			$data['sidebar'] = $this->load->view('dashboard/sidebar', $data, true);
			$data['content'] = $this->load->view('manage/credits_info', $data, true);

			$data2home['bar_holder'] = $this->load->view('bar_holder', $data, true);
			$data2home['body'] = $this->load->view('manage_account', $data, true);
			$data2home['footer'] = '';
			
			$this->load->view('dashboard/template', $data2home);
		} else {
			redirect(base_url());
		}
	}
}