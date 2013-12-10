<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page_Content extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('session');
		$this->load->database();
		$this->load->model('video_model');
	}
	
	function index()
	{
		$this->db->where('id', $_POST['page']);
		
		$query = $this->db->get('pages');
		
		$rows = $query->row();
		
		$data['wid'] = $rows->website_id;
		$data['pid'] = $rows->id;
		
		if($rows->type=='article') {
			echo $rows->content;
		} else if($rows->type=='blog') {
			$this->load->view('templates/types/blog', $data);
		} else if($rows->type=='photo') {
			$this->load->view('templates/types/photo', $data);
		} else if($rows->type=='contact_us') {
			$this->load->view('templates/types/contact_us', $data);
		}
		
		// $this->load->view();
	}

}

/* End of file page_content.php */
/* Location: ./application/controllers/page_content.php */