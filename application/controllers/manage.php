<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('session');
		$this->load->model('times_model');
		$this->load->model('wall_updates');
		$this->load->library('email');
		$this->load->helper('date');		
		$this->load->database();
		$this->load->library('encrypt');
		$this->load->model('video_model');
		$this->load->model('group_model');
		$this->load->model('photo_model');
		$this->load->model('marketplace_model');
		$this->load->model('gallery_model');
	}
	
	function index() {
		// check missing db
		if (!$this->db->field_exists('menu_style', 'design'))
		{
		   $this->db->query('ALTER TABLE `design` ADD `menu_style` TEXT NULL');
		} 
		if (!$this->db->field_exists('menu_size', 'design'))
		{
		   $this->db->query('ALTER TABLE `design` ADD `menu_size` INT');
		} 
	
		if($this->session->userdata('logged_in')) {
			$data['uid'] = $this->session->userdata('uid');
			$data['activemenu'] = 'manage';
			$data['sidebar'] = $this->load->view('dashboard/sidebar', $data, true);
			$data['content'] = $this->load->view('manage/website', '', true);

			$data2home['bar_holder'] = $this->load->view('bar_holder', $data, true);
			$data2home['body'] = $this->load->view('manage_account', $data, true);
			$data2home['footer'] = '';
			
			$this->load->view('dashboard/template', $data2home);
		} else {
			redirect(base_url());
		}
	}
	
	function update($type=null) {
		/* Update Layout */
		if($type=='layout') {
			$wid = $this->input->post('website_id');
			$layout = $this->input->post('layout');
			$data = array(
				'layout' => $layout
			);
			$query = $this->db->where('id', $wid);
			$result = $this->db->update('websites', $data);
		}
		
		/* Update Design */
		if($type=='design') {
			$wid = $this->input->post('website_id');

			if($this->input->post('reset_layout') == 'reset')
			{
				$this->db->where('website_id', $wid);
				$query = $this->db->get('design');
				
				$data_design = array(
					'nobg' => 0,
					'bgcolor' => '#999',
					'boxcolor' => 'rgba(0,0,0,0.5)',
					'transparency' => '50',
					'font_color' => '#FFF',
					'font_style' => 'Segoe UI',
					'font_size' => '16',
					'menu_color' => '#FFF',
					'menu_style' => 'Segoe UI',
					'menu_size' => '16',
					'menu_bgcolor' => 'rgba(0,0,0,0.5)',
					'menu_over' => '#4b4b4b',
					'menu_active' => '#000'
				);
				$this->db->where('website_id', $wid);
				$this->db->update('design', $data_design);
				echo 'reset';
			}
			else
			{
				$bg_settings = array(
					'nobg' => $this->input->post('nobg'),
					'bgcolor' => $this->input->post('bgcolor'),
					'boxcolor' => $this->input->post('boxcolor'),
					'bgrepeat' => $this->input->post('bgrepeat')
				);
				
				$design_data = array(
					'nobg' => $this->input->post('nobg'),
					'bgcolor' => $this->input->post('bgcolor'),
					'boxcolor' => $this->input->post('boxcolor'),
					'font_color' => $this->input->post('font_color'),
					'font_style' => $this->input->post('font_style'),
					'font_size' => $this->input->post('font_size'),
					'menu_color' => $this->input->post('menu_color'),
					'menu_style' => $this->input->post('menu_style'),
					'menu_size' => $this->input->post('menu_size'),
					'menu_bgcolor' => $this->input->post('menu_bgcolor'),
					'menu_over' => $this->input->post('menu_over'),
					'menu_active' => $this->input->post('menu_active'),
					'bg_settings' => json_encode($bg_settings)
				);
				
				$this->db->where('website_id',$wid);
				$query_design = $this->db->get('design');
				if($query_design->num_rows() > 0) {
					$design_row = $query_design->row();
					$design_data['image'] = $design_row->image;
				}
				
				if($this->input->post('def_bg')) {
					$design_data['image'] = 'img/newBackgrounds/'.$this->input->post('def_bg');
					$design_data['nobg'] = '0';
				}

				if(isset($_FILES['upload_bg']))
				{
					$uploaded = $this->photo_model->upload('upload_bg');
					$thumbnail = $this->photo_model->make_thumbnail($uploaded['full_path']);
					$medium = $this->photo_model->make_medium($uploaded['full_path']);
					if(isset($uploaded['file_name'])) {
						$design_data['image'] = 'uploads/'.$uploaded['file_name'];
						$design_data['nobg'] = '0';
					}
					$callback['uploaded'] = $uploaded;
				}
				
				/* footer */
				$data_footer = array(
					'website_id' => $wid,
					'label' => htmlentities($this->input->post('footer_label'), ENT_QUOTES, 'UTF-8'),
					'color' => $this->input->post('footer_color'),
					'bgcolor' => $this->input->post('footer_bgcolor'),
					'noads' => $this->input->post('footer_noads')
				);

				/* save to database */
				$this->db->where('website_id', $wid);
				$query_design = $this->db->get('design');
				if($query_design->num_rows() > 0) {
					$this->db->where('website_id', $wid);
					$this->db->update('design', $design_data);
				} else {
					$design_data['website_id'] = $wid;
					$this->db->insert('design', $design_data);
				}

				$this->db->where('website_id', $wid);
				$query_footer = $this->db->get('footer');
				if($query_footer->num_rows() > 0) {
					$this->db->where('website_id', $wid);
					$this->db->update('footer',$data_footer);
				} else {
					$this->db->where('website_id', $wid);
					$this->db->insert('footer',$data_footer);
				}

				$callback['thumbs'] = base_url().$design_data['image'];
				$return_data = json_encode($callback);
				echo $return_data;
			}
			
		}
	}
	
	function market($type=null) {
		$market = $this->load->model('market_model');
		
		$data['activemenu'] = 'market';
		
		$data['sidebar'] = $this->load->view('dashboard/sidebar', $data, true);
		$data2home['footer'] = '';
		
		if($this->session->userdata('logged_in')) {
			
			$query = $this->db->query("SELECT * FROM `user_marketgroup` WHERE `user_id` = '".$this->session->userdata('uid')."' ");
			$row = $query->row_array();
			
			if($query->num_rows() > 0) {
				
				if(isset($type))
				{
					if($type == 'user')
					{
						if($query->num_rows() > 0)
						{
							$data['group_id'] = $row['marketgroup_id'];
						}else
						{
							$data['group_id'] = null;
						}
						
						$data['content'] = $this->load->view('manage/user_manager', $data, true);
					}
					elseif($type == 'website')
					{
						$data['content'] = $this->load->view('manage/market_website', '', true);
					}
					elseif($type == 'details')
					{
						if($query->num_rows() > 0) {
							$data['group'] = $row;
						}
						
						$data['content'] = $this->load->view('manage/market_details', $data, true);
					}
					elseif($type == 'product')
					{
						$data['content'] = $this->load->view('manage/market_product', '', true);				
					}
						/* noel secret delete start */
					elseif($type == 'delete') {
						$market_id = $this->input->post('market_id');
						$this->db->where('marketgroup_id',$market_id);
						$tables = array('user_marketgroup', 'web_marketgroup');
						$this->db->delete($tables);
						$this->db->where('id',$market_id);
						$this->db->delete('marketgroup');
					}
						/* noel end */
				} else {
					$this->db->where('user_id',$this->session->userdata('uid'));
					$query = $this->db->get('user_marketgroup');
					if($query->num_rows() > 0)
					{
						$data_update = array(
							'last_visit' => time()
						);
						$this->db->where('user_id',$this->session->userdata('uid'));
						$this->db->update('user_marketgroup', $data_update);
					}
				
					if($query->num_rows() > 0)
					{
						$data['group_id'] = $row['marketgroup_id'];
					}else
					{
						$data['group_id'] = null;
					}
					$data['content'] = $this->load->view('manage/marketplace', $data, true);
				}
			} else {
				$qma = $this->db->query("SELECT `market_access` FROM `users` WHERE `uid` = '".$this->session->userdata('uid')."'");
				if($qma->num_rows() > 0) {
					$rma = $qma->row_array();
					if($rma['market_access'] == 1)
					{
						$market_details['market_access'] = $rma['market_access'];
						$data['content'] = $this->load->view('manage/market_details', $market_details, true);
					}
					else
					{
						redirect(base_url('manage'));
					}
				}
			}
			$data2home['bar_holder'] = $this->load->view('bar_holder', $data, true);
			$data2home['body'] = $this->load->view('manage_account', $data, true);	
			$this->load->view('dashboard/template', $data2home);
		} else {
			redirect(base_url());
		}
	}

	function facebook_page_list() {
		if($this->session->userdata('logged_in')) {
			$data['pass_error'] = '';
			$data['activemenu'] = '';
			$data['sidebar'] = $this->load->view('dashboard/sidebar', $data, true);
			$data['content'] = $this->load->view('manage/facebookpage', $data, true);

			$data2home['header'] = $this->load->view('bar_holder', $data, true);
			$data2home['body'] = $this->load->view('manage_account', $data, true);
			$data2home['footer'] = '';
			
			$this->load->view('homepage', $data2home);
		} else {
			redirect(base_url());
		}
	}
	
	function followers($wid)
	{
		$data['wid'] = $wid;
		$data['activemenu'] = '';
		$data['sidebar'] = $this->load->view('dashboard/sidebar', $data, true);
		$data['content'] = $this->load->view('webfollowers', $data, true);
		
		$data2home['header'] = $this->load->view('bar_holder', $data, true);
		$data2home['body'] = $this->load->view('manage_account', $data, true);
		$data2home['footer'] = '';
		
		$this->load->view('homepage', $data2home);
	}

	function sendFeedback()
	{
		$subject = $this->input->post('subject');
		$message = $this->input->post('message');
			
		$uid = $this->session->userdata('uid');
		$this->db->where('uid', $uid);
		$query = $this->db->get('users');
		
		if($query->num_rows() == 1) {
			$rUser = $query->row_array();

			$name = $rUser['name'];
			$email = $rUser['email'];
			
			$this->load->library('email');
			
					$config['mailtype'] = 'html';
					$config['charset'] = 'iso-8859-1';
					$config['wordwrap'] = TRUE;
					
					$this->email->initialize($config);
			
			$this->email->from($email, $name);
			$list = array('info@bolooka.com');
			$this->email->to($list);   
			// $this->email->cc('another@another-example.com');
			// $this->email->bcc('them@their-example.com');
		
			$this->email->subject($subject);
			$this->email->message($message);

			if($this->email->send())
			{
				echo $this->email->print_debugger();
			} else {
				echo 2;
			}
		}
	}
	
	function marketplace()
	{
		$data2home['header'] = '';
		$data2home['body'] = $this->load->view('manage/products', '', true);
		$data2home['footer'] = '';
		
		$this->load->view('homepage', $data2home);
	}
	
	function inbox()
	{
		if($this->session->userdata('logged_in')) {
			$data['pass_error'] = '';
			$data['content'] = $this->load->view('manage/inbox', $data, true);

			$data2home['header'] = '';
			$data2home['body'] = $this->load->view('manage_account', $data, true);
			$data2home['footer'] = '';
			
			$this->load->view('homepage', $data2home);

		} else {
			redirect(base_url());
		}
	}
	
	function webeditor()
	{
		if($this->session->userdata('logged_in')) {
			$tab = $this->input->post('tab_id');

				if($wdata['wid'] = $this->input->get_post('wid')) {
					$this->db->where('id', $wdata['wid']);
					$qweb = $this->db->get('websites');
					if($rweb = $qweb->row_array()) {
						$wdata['uid'] = $rweb['user_id'];
					}
				} else {
					redirect(base_url()."manage");
				}
				
				$this->db->where('website_id', $wdata['wid']);
				$q = $this->db->get('design');
				$wdata['design_data'] = $q->row_array();
				
				$query = "SELECT * FROM `websites` WHERE `id` = '".$wdata['wid']."'";
				$queryresult = $this->db->query($query);
				$wdata['rowWeb'] = $queryresult->row();

				if($this->session->userdata('uid') === $wdata['rowWeb']->user_id || $this->session->userdata('uid') === '4')
				{
					$edit['details'] = $this->load->view('edit/details', $wdata, true);
					$edit['pages'] = $this->load->view('edit/pages', $wdata, true);
					$edit['layout'] = $this->load->view('edit/layout', $wdata, true);
					$edit['domain'] = $this->load->view('edit/domain', $wdata, true);
					$edit['banner'] = $this->load->view('edit/banner', $wdata, true);
					
					$data['content'] = $this->load->view('edit', $edit, true);
						
					$data['activemenu'] = 'manage';
					$data['sidebar'] = $this->load->view('dashboard/sidebar', $data, true);
					
					$data2home['bar_holder'] = $this->load->view('bar_holder', $data, true);
					$data2home['body'] = $this->load->view('manage_account', $data, true);
					
					$this->load->view('dashboard/template', $data2home);
				}

		} else {
			redirect(base_url());
		}
	}
	
	function get_tab_content() {
		$wdata['wid'] = $this->input->get_post('wid');
		$pages = $this->input->get_post('edit');
		
		$this->db->where('website_id', $wdata['wid']);
		$q = $this->db->get('design');
		$wdata['design_data'] = $q->row_array();
		
		$query = "SELECT * FROM `websites` WHERE `id` = '".$wdata['wid']."'";
		$queryresult = $this->db->query($query);
		$wdata['rowWeb'] = $queryresult->row();

		$data['content'] = $this->load->view('edit/'.$pages, $wdata, true);
		echo $data['content'];
	}
	
	function del_web() {
		$webid = $this->input->get_post('website_id');
		/* delete from tables */
		$tables = array(
			'pages',
			'logo',
			'design',
			'follow'
		);
		$this->db->where('website_id', $webid);
		$this->db->delete($tables);
		
		$this->db->where('id', $webid);
		$this->db->delete('websites');
		
		$websiteQuery = $this->db->query('SELECT * FROM websites WHERE id=\''.$webid.'\'');
		$website = $websiteQuery->row();
		if($websiteQuery->num_rows() > 0)
		{
			$webName = $website->url;
		}
		/* */	
	}

	function delete_website()
	{
		$webid = $this->input->post('website_id');
		
		/* delete website by updating deleted table with time */
		$update_website = array(
			'deleted' => time()
		);
		$this->db->where('id', $webid);
		$this->db->update('websites', $update_website);
		/* */
		
		/* delete this website from marketgroup */
		$marketWebQuery = $this->db->query("SELECT * FROM web_marketgroup WHERE web_id = '".$webid."' ");
		if($marketWebQuery->num_rows() > 0)
		{
			$this->db->where('web_id', $webid);
			$this->db->delete('web_marketgroup');
		}
		/* */
	}
	
	function restore_website() {
		$webid = $this->input->post('website_id');
		$update_website = array(
			'deleted' => 0
		);
		$this->db->where('id', $webid);
		$this->db->update('websites', $update_website);
	}

	 /********** Marketgroup ***********/
	function add_marketgroup()
	{
		$checkname = $this->checkmarketname();
		if($checkname == false || $checkname == $this->input->post('market_id')) {
			
			$marketgroup = array(
				'name' =>  $this->input->post('market_name'),
				'description' => $this->input->post('market_desc'),
				'url' => url_title($this->input->post('market_name'), '-', TRUE),
				'created' => time()
			);

			if(isset($_FILES['market_logo']['name']) != '') {
				$uploaded = $this->photo_model->upload('market_logo');
				// $thumbnail = $this->photo_model->make_thumbnail($uploaded['full_path']);
				// $medium = $this->photo_model->make_medium($uploaded['full_path']);
				if(isset($uploaded['file_name'])) {
					$marketgroup['logo'] = $uploaded['file_name'];
				}
			}

			if(isset($_FILES['market_bg']['name']) != '') {
				$uploaded = $this->photo_model->upload('market_bg');
				// $thumbnail = $this->photo_model->make_thumbnail($uploaded['full_path']);
				// $medium = $this->photo_model->make_medium($uploaded['full_path']);
				if(isset($uploaded['file_name'])) {
					$marketgroup['background'] = $uploaded['file_name'];
				}
			}

			/* edit state */
			
			if($this->input->post('save_edit') == 'edit') {
				$this->db->where('user_id', $this->session->userdata('uid'));
				$querythis = $this->db->get('user_marketgroup');
				$row1 = $querythis->row_array();
				
				if($querythis->num_rows() > 0)
				{
					$this->db->where('id', $row1['marketgroup_id']);
					$this->db->update('marketgroup', $marketgroup);
				}
			} else {

				/* add marketgroup to database */
				$this->db->insert('marketgroup', $marketgroup);
				
				/* connect user to marketgroup */
				$user_market = array(
					'marketgroup_id' => $this->db->insert_id(),
					'role' => '1',
					'date_added' => time()
				);
				
				$this->db->where('user_id', $this->session->userdata('uid'));
				$qum = $this->db->get('user_marketgroup');
					
				if($qum->num_rows() > 0) {
					$this->db->where('user_id', $this->session->userdata('uid'));
					$this->db->update('user_marketgroup', $user_market);
				} else {
					$user_market['user_id'] = $this->session->userdata('uid');
					$this->db->insert('user_marketgroup', $user_market);
				}
			}
		} else {
			echo 'err';
		}
	}
	
	function checkmarketname() {
		/* check if name exists */
		$market_name = $this->input->post('market_name');
		$market_url = url_title($market_name, '-', TRUE);
		
		$this->db->where('url', $market_url);
		$queryMarket = $this->db->get('marketgroup');
		$resultMarket = $queryMarket->row_array();
		

		
		if($queryMarket->num_rows > 0) {
			$id = $resultMarket['id'];
			return $id;
		} else {
			return false;
		}
	}
		
	function add_access2market() {
		$userID = $this->input->post('userID');
		$value = $this->input->post('value');

		$user_market = array(
			'market_access' => $value
		);
		$this->db->where('uid', $userID);
		$this->db->update('users', $user_market);
	}
	
	/********** Marketgroup end **********/
	
	function get_albums() {
		$wid = $this->input->post('wid');
		$qalbum = $this->gallery_model->getAlbums(0, $wid);
		$ralbum = $qalbum->result_array();
		
		echo json_encode($ralbum);
	}
	
	function upload_article_image() {
		$uploaded = $this->photo_model->test_upload();
		if($uploaded['success']) {
			foreach($uploaded['success'] as $image) {
				/* insert to database */
				$insert_data = array(
					'page_id' => $this->input->post('pid'),
					'image_file' => $image['file_name']
				);
				$this->db->insert('article_images', $insert_data);
			}
		}
/*
    [success] => Array
        (
            [0] => Array
                (
                    [file_name] => c8ede94a54e7366b59a588a7ba76f56b.jpg
                    [file_type] => image/jpeg
                    [file_path] => D:/xampp/htdocs/project-bolooka/test_uploads/
                    [full_path] => D:/xampp/htdocs/project-bolooka/test_uploads/c8ede94a54e7366b59a588a7ba76f56b.jpg
                    [raw_name] => c8ede94a54e7366b59a588a7ba76f56b
                    [orig_name] => 2_gallery_page_(C_1)_copy.jpg
                    [client_name] => 2 gallery page (C_1) copy.jpg
                    [file_ext] => .jpg
                    [file_size] => 379.64
                    [is_image] => 1
                    [image_width] => 1350
                    [image_height] => 1080
                    [image_type] => jpeg
                    [image_size_str] => width="1350" height="1080"
                    [error_msg] => 
                )

        )
*/
	}
}