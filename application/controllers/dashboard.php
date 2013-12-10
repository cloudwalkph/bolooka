<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('session');
		$this->load->model('times_model');
		$this->load->model('wall_updates');
		$this->load->library('encrypt');
		$this->load->model('video_model');
		$this->load->model('group_model');
		$this->load->helper('date');
		$this->load->database();
		$this->load->model('photo_model');
		$this->load->model('facebook_model');
	}

	public function index()
	{
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

		if($this->session->userdata('logged_in'))
		{
			$qActive = $this->db->get('bolooka_sessions');
			$rActive = $qActive->result_array();
			
			$data['active'] = $qActive->num_rows();
		
			$data['uid'] = $this->session->userdata('uid');

				$this->load->model('marketplace_model');
				$data['websites'] = $this->marketplace_model->getWebMarket();
				$data['products'] = $this->marketplace_model->getMarketProducts();
				$data['activemenu'] = 'dashboard';
			
				$data['sidebar'] = $this->load->view('dashboard/sidebar', $data, true);
				
				// $data['feeds'] = $this->walls($data['uid']);
				$data['content'] = $this->load->view('manage/dashboard', $data, true);
				
				$data2home['bar_holder'] = $this->load->view('bar_holder', $data, true);
				$data2home['body'] = $this->load->view('manage_account', $data, true);
				$data2home['footer'] = '';
				
					// $this->load->model('favicon_model');
					// $data2home['dynafavicon'] = $this->favicon_model->set_favicon('5');
				
				$this->load->view('dashboard/template', $data2home);
		} else {
			redirect(base_url());
		}
	}
	
	function walls($uid = null) {
		$data['wallUid'] = $this->input->post('uid');
		$data['query'] = $this->wall_updates->wall_blog($data['wallUid'], null, 12);

		$data['noresult'] = 0;
		$this->load->view('dashWall', $data);
	}
	
	function wallsSecond() {
		$data['wallUid'] = $this->input->post('uid');
		$lastId = $this->input->post('lastId');
		$the_user = $this->input->post('uid');
		$limit = 3;

		$data['query'] = $this->wall_updates->wall_blog($data['wallUid'], $lastId, 3);
		$data['noresult'] = "lana";
		$this->load->view('dashWall', $data);
	}

	function update_profile()
	{
		if($button = $this->input->post('button'))
		{
			if($button=='deactivate')
			{
				echo 'account deactivate';
			}
			elseif($button=='profile')
			{
				$data['pass_error'] = '';

				$this->db->where('uid', $this->session->userdata('uid'));
				$query = $this->db->get('users');

				foreach ($query->result() as $row)
				{
					$password = $row->password;
				}

				if($this->input->post('pass')!=null)
				{
					if($this->input->post('pass')==$password)
					{
						if($this->input->post('new_pass')!=null)
						{
							if($this->input->post('new_pass')==$this->input->post('re_pass'))
							{
								$password = $this->input->post('new_pass');
							}
							else
							{
								$data['pass_error'] = 'password not match';
							}
						}
						else
						{
							$data['pass_error'] = 'new password cannot be blank';
						}
					}
					else
					{
						$data['pass_error'] = 'please enter correct password';
					}
				}

				$profile_update_data = array(
					'first_name' => $this->input->post('first_name'),
					'last_name' => $this->input->post('last_name'),
					'email' => $this->input->post('email'),
					'password' => $password
				);

				$this->db->where('uid', $this->session->userdata('uid'));

				$insert = $this->db->update('users', $profile_update_data);

				$data['content'] = $this->load->view('manage_profile', $data, true);
				$data2home['header'] = '';
				$data2home['footer'] = '';
				$data2home['body'] = $this->load->view('manage_account', $data, true);
				
				$this->load->view('homepage', $data2home);

			}
		}
	}
	
	function update_page($curr_page=null, $wid=0)
	{
		$wid = $this->input->post('website_id');

		if($curr_page=='menu')
		{
			$page_id = $this->input->post('pageid');
			
			if($this->input->post('menu')=='type'){
				$type = $this->input->post('type');
				
				$update_pages_array = array(
					'type' => $type
				);
			}
			if($this->input->post('menu')=='name'){
				$name = $this->input->post('name');
				
				$update_pages_array = array(
					'name' => $name,
					'url' => url_title($name,'-',true)
				);
			}
			$this->db->where('id',$page_id);
			$this->db->update('pages',$update_pages_array);
		}
		
		if($curr_page=='status')
		{
			$page_id = $this->input->post('pageid');
			$page_update_data = array (
				'status' => $this->input->post('status')
				);
			$this->db->where('id', $page_id);
			$this->db->update('pages', $page_update_data);
		}
		
		if($curr_page=='order')
		{
			$page_order = $this->input->post('order');
			foreach($page_order as $order => $page_id)
			{
				if($this->db->field_exists('page_seq', 'pages')) {
					$update_order_array = array(
						'page_seq' => $order + 1
					);
				} else {
					$update_order_array = array(
						'order' => $order + 1
					);
				}
				$this->db->where('id', $page_id);
				$this->db->update('pages', $update_order_array);
			}
		}

		/* Update Site Details */
		if($curr_page=='details')
		{
			$new_website_update_data = array(
				'site_name' => $this->input->post('site_name'),
				'business_type' => $this->input->post('business_type'),
				'marketgroup' => $this->input->post('marketgroup'),
				'country' => $this->input->post('country'),
				'description' => $this->input->post('description')
			);

			$this->db->where('id', $wid);
			$this->db->update('websites', $new_website_update_data);
			if($this->input->post('marketgroup') != '0')
			{
				/* check if exists in web_marketgroup */
				$this->db->where('web_id', $wid);
				$query_web_marketgroup = $this->db->get('web_marketgroup');
				$row = $query_web_marketgroup->row_array();
				if($query_web_marketgroup->num_rows() == 0)
				{
					$data_insert_web_marketgroup = array(
					   'web_id' => $wid ,
					   'marketgroup_id' => $this->input->post('marketgroup'),
					   'status' => 'request',
					   'date_added' => time()
					);
					$this->db->insert('web_marketgroup', $data_insert_web_marketgroup);
					
					/* get admin to notify */
					$this->db->where('marketgroup_id',$this->input->post('marketgroup'));
					$this->db->where('role', 1);
					$query_user_marketgroup = $this->db->get('user_marketgroup');
					$user_row = $query_user_marketgroup->row_array();
					
					if($query_user_marketgroup->num_rows() > 0)
					{
						/* for notification */
						$data_insert_flag = array(
							'uid' => $this->session->userdata('uid'),
							'website_id' => $wid,
							'status' => 1,
							'notify' => $user_row['user_id'],
							'action' => 'request',
							'time' => time()
						);
						$this->db->insert('flag', $data_insert_flag);
					}
				}
				elseif($row['marketgroup_id'] != $this->input->post('marketgroup'))
				{
					$data_insert_web_marketgroup = array(
					   'marketgroup_id' => $this->input->post('marketgroup'),
					   'date_added' => time(),
					   'status' => '0',
					);
					$this->db->where('web_id', $wid);
					$this->db->update('web_marketgroup', $data_insert_web_marketgroup);
					
					/* get admin to notify */
					$this->db->where('marketgroup_id',$this->input->post('marketgroup'));
					$this->db->where('role', 1);
					$query_user_marketgroup = $this->db->get('user_marketgroup');
					$user_row = $query_user_marketgroup->row_array();
					
					if($query_user_marketgroup->num_rows() > 0)
					{
						/* for notification */
						$data_insert_flag = array(
							'uid' => $this->session->userdata('uid'),
							'website_id' => $wid,
							'status' => 1,
							'notify' => $user_row['user_id'],
							'action' => 'request',
							'time' => time()
						);
						$this->db->insert('flag',$data_insert_flag);
					}
				}
			} else {
				/* dito function kapag nagselect ulit sa Select.. ang Affiliates */
			}
			// redirect('manage/webeditor?wid='.$wid.'&save=site_details');
			
			// echo 'details saved';
		// }
		
		# Update Logo and Favicon
		
		// if($curr_page == 'logofav') {
			
			$logo_data['nologo'] = 0;
			$logo_data['logosize'] = 0;
			
			if($this->input->post('logosize') != 0) {
				$logo_data['logosize'] = $this->input->post('logosize');
			}
			
			if($this->input->post('nologo') == 1) {
				$logo_data['nologo'] = $this->input->post('nologo');
			}

			if($_FILES['logo']['name'] != '') {
				$uploaded = $this->photo_model->upload('logo');
				$thumbnail = $this->photo_model->make_thumbnail($uploaded['full_path']);
				$medium = $this->photo_model->make_medium($uploaded['full_path']);
				if(isset($uploaded['file_name'])) {
					$logo_data['image'] = $uploaded['file_name'];
					$logo_data['nologo'] = 0;
				}
			}

			$logo_data['position'] = $this->input->post('position');
			$logo_data['color'] = $this->input->post('color');
			
			$this->db->where('website_id', $wid);
			$query = $this->db->get('logo');
			if($query->num_rows() > 0) {
				$this->db->where('website_id', $wid);
				$this->db->update('logo', $logo_data);
			} else {
				$new_logo_update_data['website_id'] = $wid;
				$this->db->insert('logo', $logo_data);
			}

			if($_FILES['favicon']['name'] != '') {
				$uploaded = $this->photo_model->upload('favicon');
				// $thumbnail = $this->photo_model->make_thumbnail($uploaded['full_path']);
				// $medium = $this->photo_model->make_medium($uploaded['full_path']);
				if(isset($uploaded['file_name'])) {
					$website_update_data['favicon'] = $uploaded['file_name'];
					$this->db->where('id', $wid);
					$this->db->update('websites', $website_update_data);
				}
			}

			$save = '?wid='.$wid.'&save=details';
			redirect(base_url().'manage/webeditor'.$save);
		}
		
		/* Update Pages */
		elseif($curr_page=='pages')	{
			$wid = $this->input->post('website_id');
			
			/* Check if all pages are unpublish then return an error */
			$check_publish = $this->db->query("SELECT * FROM `pages` WHERE website_id='$wid'");
			$checkArray = Array();
			if($check_publish->num_rows() > 0)
			{
				foreach($check_publish->result_array() as $row_check)
				{
					if($this->input->post('status'.$row_check['id']) == 'publish')
					{
						$checkArray[] = 'pub';
					}
					else
					{
						$checkArray[] = 'unp';
					}
				}
			}

			/* article submit to page */
			if($this->input->post('type') == 'article')
			{
				$page_id = $this->input->post('page_id');
				$this->db->where('page_id', $page_id);
				$queryArticle = $this->db->get('articles');
				
				/* check if existing in article table */
				$countArticle = $queryArticle->num_rows();
				if($countArticle == 0) {
					$data = array(
					   'page_id' => $page_id
					);
					$this->db->insert('articles', $data);
				}
				/* end */
				
				$article_update_data = array (
					'content' => $this->input->post('content')
				);
				$this->db->where('page_id', $page_id);
				$this->db->update('articles', $article_update_data);
			}

			if($this->input->post('type') == 'contact_us')
			{
				$page_id = $this->input->post('page_id');
				$this->db->where('page_id', $page_id);
				$queryArticle = $this->db->get('contact_us');
				
				/* check if existing in contact_us table */
				$countArticle = $queryArticle->num_rows();
				if($countArticle == 0) {
					$data = array(
					   'page_id' => $page_id
					);
					$this->db->insert('contact_us', $data);
				}
				/* end */
				echo $this->input->post('emailcc'.$page_id);
				$contact_update_data = array(
					'message' => $this->input->post('message'.$page_id),
					'email' => $this->input->post('email'.$page_id),
					'landline' => $this->input->post('landline'.$page_id),
					'mobile' => $this->input->post('mobile'.$page_id),
					'address' => $this->input->post('address'.$page_id),
					'emailcc' => $this->input->post('emailcc'.$page_id),
					'google_map' => $this->input->post('google_map'.$page_id),
					'fb' => $this->input->post('fb'.$page_id),
					'gplus' => $this->input->post('gplus'.$page_id),
					'twitter' => $this->input->post('twitter'.$page_id),
					'linkedin' => $this->input->post('linkedin'.$page_id),
					'instagram' => $this->input->post('instagram'.$page_id),
					'pinterest' => $this->input->post('pinterest'.$page_id),
					'button_bg' => $this->input->post('button_bg'.$page_id),
					'button_hover' => $this->input->post('button_hover'.$page_id)
				);
				$this->db->where('page_id',$page_id);
				$this->db->update('contact_us', $contact_update_data);
			}
		
			// if(in_array('pub', $checkArray))
			// {
				// $this->db->where('website_id', $wid);
				// $query = $this->db->get('pages');
				// foreach($query->result() as $page) {
					
					// $page_update_data = array (
						// /* 'content' => $this->input->post('content'.$page->id), */
						// 'social' => $this->input->post('social'.$page->id),
						// 'status' => $this->input->post('status'.$page->id),
						// 'name' => $this->input->post('menu'.$page->id),
						// 'order' => $this->input->post('seq'.$page->id),
						// 'type' => $this->input->post('type'.$page->id)
						// );
					// $this->db->where('id', $page->id);
					// $this->db->update('pages', $page_update_data);
				// }
				
				// $check = "meron";
			// }
			// else
			// {
				// $check = "wala";
			// }
		}
		
		/* Update Footer */
		elseif($curr_page=='footer')
		{
			$ads = $this->input->post('noads'); 
			if($ads == null)
			{
				$ads = 0;
			}

			$this->db->where('website_id', $wid);
			$new_footer_update_data = array(
				'label' => htmlentities($this->input->post('footer_label')),
				'color' => $this->input->post('footer_color'),
				'bgcolor' => $this->input->post('footer_bgcolor'),
				'noads' => $ads
			);
			$this->db->update('footer', $new_footer_update_data);
			redirect('manage/webeditor/'.$curr_page.'?wid='.$wid);
		}
		
		/* Update Banner */
		elseif($curr_page=='banner')
		{
			$wid = $this->input->post('website_id');
			if($this->input->post('buttonB')=='save') {

				/* upload File */
				 $config['upload_path']   = './uploads/'; //if the files does not exist it'll be created
				 $config['allowed_types'] = 'gif|jpg|png|xls|xlsx|php|pdf';
				 $config['max_size']   = '4000'; //size in kilobytes
				 $config['encrypt_name']  = TRUE;
				 
				$this->load->library('upload', $config);
				
				$field_name = "imageBanner";

				if ( ! $this->upload->do_upload())
				{
					$error = array('error' => $this->upload->display_errors());
					print_r($error);
				}
				else
				{
					$data = array('upload_data' => $this->upload->data());
					print_r($data);
				}

			} else {

				$this->db->where('website_id', $wid);
				$bannerId = $this->input->post('buttonB');
				$delete_banner_id = array('id' => $bannerId);
				$this->db->delete('banner',$delete_banner_id);
			}
		}
		
		/* Update Design */
		elseif($curr_page=='design')
		{
			echo $wid;
		}
	}

	function get_type_content($type) {
		$data['pid'] = $_POST['pid'];
		$this->load->view('edit/pages/'.$type, $data);
	}
	
	function add_page()
	{
		$id = 100;
		echo '

			<div class="group">
				<ul id="'.$id.'" class="page" style="">
					<li class="seq">
						<span id="seq'.$id.'">8</span>
					</li>
					<li class="menu">
						<span class="changename" id="menu'.$id.'">Page'.rand().'</span>
					</li>
					<li class="type">
						<select id="type'.$id.'" name="type'.$id.'" alt="article" onchange="menuoption(this, '.$id.');">
							<option value="article" selected="selected">Article</option>
							<option value="blog" >Blog</option>
							<option value="contact_us" >Contact</option>
							<option value="photo" >Photos</option>
							<option value="catalogue" >Catalogue</option>
						</select>
					</li>
					<li class="social">
						<input id="social'.$id.'" type="checkbox" name="social'.$id.'" style=""/>
					</li>
					<li class="status">
						<select name="status<?php echo $row->id; ?>" class="changestatus">
							<option selected="selected" value="1"> Publish </option>
							<option value="0"> Unpublish </option>
						</select>
					</li>
					<li class="show_editor" alt="article" style="">
						<img src="../../img/editIcon.png" style="height: 15px; width: auto;" />
						<span>Edit</span>
					</li>
					<div id="slide'.$id.'" class="editor" alt="article" style="background: none repeat scroll 0 0 #EEEEEE;">
					</div>
				</ul>
			</div>
		';
	}
	  
	  function imageTitle()
	  {
			$imagetitle = $_POST['imaget'];
			$imageId = $_POST['imageId'];
			$this->db->query("UPDATE gallery SET image_name='$imagetitle' WHERE id='$imageId'");
	  }
	  function imagedc()
	  {
			$imageds = $_POST['imaget'];
			$imageId = $_POST['imageId'];
			$this->db->query("UPDATE gallery SET descrip='$imageds' WHERE id='$imageId'");
	  }
	  
	  
	  
	  
	  function post_album()
	   {
		
		$data['albumid'] = $_POST['aid'];
		$data['pageid'] =  $_POST['aid2'];

		if(isset($_POST['aid3']))
		{
			$data['get_primary'] = $_POST['aid3'];
		}
		else
		{
			$data['get_primary'] = '';
		}
		
		$this->load->view('primarys',$data);
	  
	  }

	function shop()
	{
		$this->load->view('shop');
	}

	//end test
	
	   function cancel_primary($aid,$aid3)
	   
	   {
	   $data['albumid'] = $aid3;
	    $data['pageid'] =  $aid;
		//echo "adsa";
	   
	   }
		
		function deleting_album($aid,$aid2)
		
		{
		
			//$data['$pageid'] = $_POST['aid2'];
			//$data['albumid'] = $_POST['aid']; 
			$data['pageid'] = $aid2;
			$data['albumid'] = $aid;
			//$this->load->view('for_delete',$data);
			$this->load->view('delete_album',$data);
		
		}
			
	function set_primary()
	{
		$this->load->view('primary_set');
	}
	
	function edit_product()
	{
		$data = $this->input->post();
		$data['redo'] = 'edit';
		$this->load->view('edit/pages/add_new_product', $data);
	}
	
	function moderateProd()
	{
		$action = $this->input->post('action');
		$prodId = $this->input->post('prodId');
		
		echo $action . ' ' . $prodId;

		if($action == 'disable')
		{
			$queryProd = $this->db->where('product_id',$prodId);
			$queryProd = $this->db->get('product_moderation');
			if($queryProd->num_rows() > 0)
			{
				$this->db->where('product_id',$prodId);
				$update_data = array(
					'disabled' => 1
				);
				$this->db->update('product_moderation',$update_data);
			}
			else
			{
				$this->db->where('user_id', $this->session->userdata('uid'));
				$queryUserMarket = $this->db->get('user_marketgroup');
				$resultUserMarket = $queryUserMarket->row_array();
				$marketId = $resultUserMarket['marketgroup_id'];
				$insert_data = array(
					'product_id' => $prodId,
					'marketgroup_id' => $marketId,
					'disabled' => 1,
					'time_modified' => time()
				);
				$this->db->insert('product_moderation', $insert_data);
			}
		}
		elseif($action == 'enable')
		{
			$this->db->where('product_id', $prodId);
			$update_data = array(
				'disabled' => 0
			);
			$this->db->update('product_moderation',$update_data);
		}
	}
	
	# edit pages ajax get content
	function get_page_content() {
		$type = $this->input->post('pagetype');
		$data['pid'] = $this->input->post('pid');
		$data['wid'] = $this->input->post('wid');
		$this->load->view('edit/pages/'.$type, $data);
	}
	
	function load_categ($item=null)
	{
		if($item)
		{
			$type = $this->input->post('pagetype');
			$data['pid'] = $this->input->post('pid');
			$data['wid'] = $this->input->post('wid');
			$sort = $this->input->post('item');
			$data['word_set'] = $sort;
			$this->load->view('edit/pages/'.$type, $data);
		} else {
			$type = $this->input->post('pagetype');
			$data['pid'] = $this->input->post('pid');
			$data['wid'] = $this->input->post('wid');
			$data['order'] = $this->input->post('order');
			$sort = $this->input->post('search');
			if($sort == 'all') {
				$data['search'] = 'all';	
			} else {
				$data['search'] = $sort;
			}
			$this->load->view('edit/pages/'.$type, $data);
		}	
	}
	
	function addColorOption()
	{
		$imageId = $this->input->post('image_id');
		$color = $this->input->post('color_name');
		
		$this->db->where('id',$imageId);
		$query = $this->db->get('products_images');
		if($query->num_rows() > 0)
		{
			$this->db->where('id',$imageId);
			
			$array_products_image = array(
				'color_name' => $color
			);
			$this->db->update('products_images',$array_products_image);
		}
		echo $color;
	}
	
	function subcategoryset() {
		$category = $this->input->post('cat_name');
		$pid = $this->input->post('pid');
		$wid = $this->input->post('wid');
		
		$this->db->distinct();
		$this->db->select('sub_category');
		$this->db->where('website_id', $wid);
		$this->db->where('category',$category);
		$null_entry = array('','0');
		$this->db->where_not_in('sub_category',$null_entry);
		$this->db->order_by('sub_category asc');
		$cat_query = $this->db->get('products');
		if($cat_query->num_rows() > 0)
		{
			echo '
				<div class="control-group sub_div">
					<label class="control-label" for="sub_category"> Sub-cateogry: </label>
					<div class="controls">
						<select class="sub_category" id="sub_category" name="sub_category" alt="'.$category.'">
				';
					foreach($cat_query->result_array() as $row)
					{
						echo '
							<option value="'.$row['sub_category'].'">'.$row['sub_category'].'</option>	
						';
					}
			echo '
						</select>
						<button class="btn btn-mini add_sub_categ" style="margin-right:3px;margin-top:2px;">Add</button>
						<button class="btn btn-mini remove_sub_categ" style="margin-right:3px;margin-top:2px;">Remove</button>
					</div>
				</div>
			';
		}else
		{
			echo '
				<div class="control-group sub_div">
					<label class="control-label" for="sub_category"> Sub-cateogry: </label>
					<div class="controls">
						<input type="text" class="sub_category" id="sub_category" name="sub_category" value="">
					</div>
				</div>
			';
		}
		
	}
	
	
	function edit_subcategory() 
	{
		$category = $this->input->post('category');
		$wid = $this->input->post('wid');
		
		$this->db->where('category',$category);
		$this->db->where('website_id',$wid);
		$query = $this->db->get('product_subcategory');
		if($query->num_rows() > 0)
		{
			echo '
				<ul class="sub_item_ul">
			';
			foreach($query->result_array() as $row)
			{
				echo '
					<li><span class="sub_item">'.$row['sub_category'].' </span>&nbsp;<button class="btn btn-mini delete-sub-item">Delete</button></li>
				';
			}
			echo '
				</ul>
			';
		}
	}
	
	function delete_subcategory() 
	{
		$item = $this->input->post('item');
		$this->db->where('sub_category',$item);
		$this->db->delete('product_subcategory');
	}
	
	function uploadproduct()
	{
		$wid = $this->input->post('webId');
		$pid = $this->input->post('page_id');
		$prod_id = $this->input->post('product_id');
		
			$this->db->where('id', $wid);
			$qweb = $this->db->get('websites');
			$rweb = $qweb->row_array();
		$uid = $rweb['user_id'];
		
		if(isset($_FILES['prod_photo']))
		{
			$uploaded = $this->photo_model->multi_upload($prod_id, $pid, $wid, $uid);
			
			$images_arr = array();
			
			if(array_key_exists('success', $uploaded)) {
				foreach($uploaded['success'] as $key => $product) {
					$thumbnail = $this->photo_model->make_thumbnail($product['full_path']);
					$medium = $this->photo_model->make_medium($product['full_path']);
					$thumbs = $this->photo_model->custom_thumbnail($product['full_path'], 120, 120);
					
					$image_arr = array(
						'image' => $product['file_name'],
						'path' => $thumbnail,
						'thumbs' => base_url('uploads/'.$uid.'/'.$wid.'/'.$pid.'/'.$prod_id.'/'.$product['file_name'])
					);

					if($key == 0) {
						
						$new_product_update_data = array('images' => $image_arr['image'], 'website_id' => $wid, 'product_id' => $prod_id, 'page_id' => $pid);
						$this->db->insert('products_images', $new_product_update_data);
						$insertid = $this->db->insert_id();
						$image_arr['prod_id'] = $insertid;
						
						$prod_query = $this->db->query("SELECT * FROM products WHERE id='".$prod_id."' ");
						$rows = $prod_query->row_array();
						if($prod_query->num_rows() > 0)
						{
							if($rows['primary'] == null)
							{
								$this->db->where('id', $prod_id);
								if($this->db->field_exists('product_cover', 'products')) {
									$update_primary = array('product_cover' => $image_arr['image']);
								} else {
									$update_primary = array('primary' => $image_arr['image']);
								}
								$this->db->update('products', $update_primary);
							}
						}
					} else {
						
						$new_banner_update_data = array('images' => $image_arr['image'], 'website_id' => $wid, 'product_id' => $prod_id, 'page_id' => $pid);
						$this->db->insert('products_images', $new_banner_update_data);
					}
					
					array_push($images_arr, $image_arr);
				}
				echo json_encode($images_arr);
			}
		}
	}
	
	function ajaxproduct() {
 			$prod_id = $this->input->post('prod_id');
			$url = $this->input->post('prod_video');
			$wid = $this->input->post('wid');
			$pid = $this->input->post('pid');
			$action = $this->input->post('action');

			// product variants ------------------
			$v_type = $this->input->post('v_type');
			$v_name = $this->input->post('v_name');
			$v_price = $this->input->post('v_price');
			$v_quantity = $this->input->post('v_quantity');
			
			$this->db->where('product_id',$prod_id);
			$this->db->where('website_id',$wid);
			$variant_query = $this->db->get('product_variants');
			
			if(isset($v_name[0]))
			{
				if($variant_query->num_rows() == 0)
				{
					foreach($v_name as $key=>$item)
					{
						// adding data
						$data_variants = array(
							'product_id'=> $prod_id,
							'website_id'=> $wid,
							'type'=> $item,
							'name'=> $v_name[$key],
							'price'=> $v_price[$key],
							'quantity'=> $v_quantity[$key]
						);
						$this->db->insert('product_variants',$data_variants);
					}
				}else
				{
					/* check if variant name already in database then delete data variant table where not in array */
					$array_search = array();
					foreach($v_name as $key=>$item)
					{
						array_push($array_search,$item);
					}
					
					$this->db->where('product_id',$prod_id);
					$this->db->where('website_id',$wid);
					$this->db->where_not_in('name',$array_search);
					$this->db->delete('product_variants');
					
					// adding data
					foreach($v_name as $key=>$item)
					{
						/* get unique identifier */
						$this->db->where('product_id',$prod_id);
						$this->db->where('website_id',$wid);
						$this->db->where('name',$item);
						$vname_query = $this->db->get('product_variants')->num_rows();
						
						$this->db->where('product_id',$prod_id);
						$this->db->where('website_id',$wid);
						$this->db->where('price',$v_price[$key]);
						$vprice_query = $this->db->get('product_variants')->num_rows();
						
						$this->db->where('product_id',$prod_id);
						$this->db->where('website_id',$wid);
						$this->db->where('price',$v_quantity[$key]);
						$vquantity_query = $this->db->get('product_variants')->num_rows();
						
						/* if user add more variants depending to variant name unique */
						if($vname_query == 0)
						{
							$data_variants = array(
								'product_id'=> $prod_id,
								'website_id'=> $wid,
								'type'=> $item,
								'name'=> $v_name[$key],
								'price'=> $v_price[$key],
								'quantity'=> $v_quantity[$key]
							);
							$this->db->insert('product_variants',$data_variants);
						}		
							/* if user edit variants price or quantity */
							if($vprice_query == 0 || $vquantity_query == 0)
							{
								$data = array(
									'price'=>$v_price[$key],
									'quantity'=>$v_quantity[$key]
								);
								
								$this->db->where('product_id',$prod_id);
								$this->db->where('website_id',$wid);
								$this->db->where('name',$item);
								$this->db->update('product_variants',$data);
								
							}
						
					}
					
				}
			}else
			{
				// kapag walang nilagay na variant miski isa
				if($variant_query->num_rows() > 0)
				{
					// delete existing
					$this->db->where('product_id',$prod_id);
					$this->db->where('website_id',$wid);
					$this->db->delete('product_variants');
				}
			}
			
			$time = time();
			$negativealbum = '-1';
			$tag_name = $this->input->post('tags_name');
			
			preg_match('/youtube.com/', $url, $youtube_matches);
			if($youtube_matches != null)
			{
				$v_link = str_replace('watch?v=','embed/',$url);
			}else
			{
				preg_match('/vimeo.com/', $url, $vimeo_matches);
				if($vimeo_matches != null)
				{
					$v_link = str_replace('vimeo.com','player.vimeo.com/video',$url);
				}else
				{
					$v_link = $url;
				}
				
			}
						
			/* Checkout Settings */
			$chkssetting = '';
			if($this->input->post('chkssetting')){
				foreach($this->input->post('chkssetting') as $key => $value){
					$chkssetting .= $key.'-'.$value.',';
				}
			}			
			
			preg_match('/vimeo.com/', $url, $youtube_matches);

	 		parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
			$remove_comma = str_replace(",","",$this->input->post('prod_price'));
			$new_product_insert_data = array(
				'name' => htmlentities($this->input->post('prod_name'), ENT_QUOTES, 'UTF-8'),
				'section' => $this->input->post('prod_section'),
				'category' => $this->input->post('prod_cat'),
				'sub_category' => $this->input->post('sub_category') ? $this->input->post('sub_category') : null,
				'video' => $v_link,
				'price' => $remove_comma,
				'stocks' => $this->input->post('prod_stock'),
				'prod_weight' => $this->input->post('prod_weight'),
				'avail_ship' => $this->input->post('avail_ship'),
				'checkout_settings' => $chkssetting,
				'published' => '1',
				'date_modified' => time()
			);
			
			if($this->db->field_exists('product_desc', 'products')) {
				$new_product_insert_data['product_desc'] = htmlentities($this->input->post('prod_description'), ENT_QUOTES, 'UTF-8');
			} else {
				$new_product_insert_data['desc'] = htmlentities($this->input->post('prod_description'), ENT_QUOTES, 'UTF-8');
			}

			$this->db->where('id', $prod_id);
			$this->db->update('products', $new_product_insert_data);
			
			
			/* save to product_subcategory table */
			if(isset($sub_categ))
			{
				$sub_categ = trim($sub_categ);
				var_dump($sub_categ);

				if($sub_categ != '')
				{
					$this->db->where('website_id',$wid);
					$this->db->where('category',$this->input->post('prod_cat'));
					$this->db->where('sub_category',$sub_categ);
					$query_subcateg = $this->db->get('product_subcategory');
					if($query_subcateg->num_rows() == 0)
					{
						$sub_categ_array = array(
							'website_id' => $wid,
							'page_id' => $pid,
							'category' => $this->input->post('prod_cat'),
							'sub_category' => $sub_categ
						);
						$this->db->insert('product_subcategory',$sub_categ_array);
					}
				}
			}
			
			if($this->input->post('action') == 'insert')
			{
				$this->wall_updates->insert_product($negativealbum, $prod_id, $wid, $pid);
			}
			
			$t_name = explode(',',$tag_name);
			
			$this->db->where('prod_id',$prod_id);
			$query_product = $this->db->get('tags');
			if($query_product->num_rows() > 0)
			{
				$this->db->where('prod_id',$prod_id);
				$this->db->delete('tags');
				if($t_name[0] != '')
				{
					for($x=0; $x < count($t_name); $x++)
					{
						$data_tags = array(
							'prod_id' => $prod_id,
							'tag_names' => $t_name[$x]
							
						);
						$this->db->insert('tags',$data_tags);
					}
				}
			}else
			{
				if($t_name[0] != '')
				{
					for($x=0; $x < count($t_name); $x++)
					{
						$data_tags = array(
							'prod_id' => $prod_id,
							'tag_names' => $t_name[$x]
							
						);
						$this->db->insert('tags',$data_tags);
					}
				}				
			}
		if($action == 'insert') {
			$this->product_fbshare($prod_id);
		}
	}
	
	function product_fbshare($prdid) {
		$queryprod = $this->db->query("SELECT * FROM products WHERE id='$prdid'");
		$resultprod = $queryprod->row_array();
		
		$data['prname'] = 'Posted a new product "'.$resultprod['name'].'" on Bolooka';
		$data['pname'] = $resultprod['name'];
		
		if($this->db->field_exists('product_cover', 'products')) {
			$data['lastimg'] = base_url().'uploads/' . $this->session->userdata('uid') . '/' . $resultprod['website_id'] . '/' . $resultprod['page_id'] . '/' . $resultprod['id'] . '/'. $resultprod['product_cover'];
		} else {
			$data['lastimg'] = base_url().'uploads/' . $this->session->userdata('uid') . '/' . $resultprod['website_id'] . '/' . $resultprod['page_id'] . '/' . $resultprod['id'] . '/'. $resultprod['primary'];
		}
		
		$queryweb = $this->db->query("SELECT * FROM websites WHERE id='".$resultprod['website_id']."'");
		$resultweb = $queryweb->row_array();
		
		$getpage = $this->db->query("SELECT * FROM pages WHERE id='".$resultprod['page_id']."'");
		$resultpage = $getpage->row_array();
		
		$data['url'] = base_url().url_title($resultweb['url'], '-', true).'/'.url_title($resultpage['name'], '-', true).'/'.url_title($resultprod['name'], '-', true).'/'.$prdid;
		$data['caption'] = base_url().$resultweb['url'];
		
		if($this->db->field_exists('product_desc', 'products')) {
			$data['desc'] = strip_tags($resultprod['product_desc']);
		} else {
			$data['desc'] = strip_tags($resultprod['desc']);
		}
		
		$callback = $this->facebook_model->fbshare($data['prname'], $data['pname'], $data['lastimg'], $data['url'], $data['caption'], $data['desc']);
		echo $callback;
	}
	
	function delprod() {
		$id = $this->input->post('prod_id');
		$this->db->where('id', $id);
		$this->db->delete('products');
		
		$this->db->where('product_id', $id);
		$this->db->delete('products_images'); 
		
		$this->wall_updates->delete_blog($id);
	}
	
	function setPrimaryProd() {
		$id = $this->input->post('prod_id');
		$primary = $this->input->post('primary');
		
		if($this->db->field_exists('product_cover', 'products')) {
			$data_products = array( 'product_cover' => $primary );
		} else {
			$data_products = array( 'primary' => $primary );
		}
		$this->db->where('id',$id);
		$this->db->update('products',$data_products);
	}
	
	function del_image_prod() {
		$img_id = $this->input->post('image_id');
		
		/* select products_images  */
		$this->db->where('id', $img_id);
		$this->db->from('products_images');
		$query_images = $this->db->get();
		if($query_images->num_rows() > 0)
		{
			$row = $query_images->row_array();

			
			$this->db->where('id', $row['website_id']);
			$qsite = $this->db->get('websites');
			if($qsite->num_rows() > 0) {
				$rsite = $qsite->row_array();
				$img_folder = 'uploads/' . $rsite['user_id'] . '/' . $rsite['id'] . '/' . $row['page_id'] . '/' . $row['product_id'];
				$img_array = array(
					'base' =>  $img_folder . '/' . $row['images'],
					'medium' => $img_folder . '/medium/' . $row['images'],
					'thumbnail' => $img_folder . '/thumbnail/' . $row['images'],
					's120x120' => $img_folder . '/s120x120/' . $row['images'],
					's180x180' => $img_folder . '/s180x180/' . $row['images'],
					's240x240' => $img_folder . '/s240x240/' . $row['images'],
					's120' => $img_folder . '/s120/' . $row['images']
				);
				foreach($img_array as $img_path) {
					@unlink($img_path);
				}
			}

			$this->db->where('id', $row['product_id']);
			$query_prod = $this->db->get('products');
			if($query_prod->num_rows() > 0)
			{
				$row_prod = $query_prod->row_array();
				if($row['images'] == $row_prod['primary'])
				{
					/* update products if primary is deleted */
					if($this->db->field_exists('product_cover', 'products')) {
						$data_products = array( 'product_cover' => null );
					} else {
						$data_products = array( 'primary' => null );
					}
					$this->db->where('id',$row['product_id']);
					$this->db->update('products', $data_products);
				}
			}
			
			/* delete products_images */
			$this->db->where('id', $img_id);
			$this->db->delete('products_images');
		}
		
	}
	
	function del_new_upload_prod()
	{
		$img_name = $this->input->post('image_name');
		
		/* select products_images  */
		$this->db->where('images', $img_name);
		$query_images = $this->db->get('products_images');
		$row = $query_images->row_array();
		
		if($query_images->num_rows() > 0)
		{
			$this->db->where('id',$row['product_id']);
			$query_prod = $this->db->get('products');
			$row_prod = $query_prod->row_array();
			
			if($row['images'] == $row_prod['primary'])
			{
				/* update products if primary is deleted */
				if($this->db->field_exists('product_cover', 'products')) {
					$data_products = array( 'product_cover' => null );
				} else {
					$data_products = array( 'primary' => null );
				}
				$this->db->where('id',$row['product_id']);
				$this->db->update('products',$data_products);
			}
			/* delete products_images */
			$this->db->where('images', $img_name);
			$this->db->delete('products_images');
		}
		
	}
	
	function publish_unpublish()
	{
		$status = $this->input->post('status');
		$id = $this->input->post('id');
		
		$update_publish_data = array('published' => $status);
		$this->db->where('id', $id);
		$this->db->update('products', $update_publish_data);
		
		echo $id;
	}
	
	function onSocialActive($status=null)
	{
		if($status == 'active')
		{
			$pid = $this->input->post('pid');
			
			$data_update_pages = array(
				'social' => 'on'
			);
			$this->db->where('id',$pid);
			$this->db->update('pages',$data_update_pages);
		}else
		{
			$pid = $this->input->post('pid');
			
			$data_update_pages = array(
				'social' => '0'
			);
			$this->db->where('id',$pid);
			$this->db->update('pages',$data_update_pages);		
		}
	}
	
	function typeaheadColors() {
		$color_array = array(
			'aliceblue',
			'antiquewhite',
			'aqua',
			'aquamarine',
			'azure',
			'black',
			'blue',
			'blueviolet',
			'brown',
			'burlywood',
			'cadetblue',
			'chocolate',
			'coral',
			'cornflowerblue',
			'cornsilk',
			'crimson',
			'cyan',
			'darkblue',
			'darkcyan',
			'darkgoldenrod',
			'darkgray',
			'darkgreen',
			'darkkhaki',
			'darkmagenta',
			'darkolivegreen',
			'darkorange',
			'darkorchid',
			'darkred',
			'darksalmon',
			'darkseagreen',
			'darkslateblue',
			'darkslategray',
			'darkviolet',
			'deeppink',
			'deepskyblue',
			'dimgray',
			'dodgerblue',
			'fuchsia',
			'gold',
			'goldenrod',
			'gray',
			'green',
			'greenyellow',
			'indigo',
			'ivory',
			'khaki',
			'lavender',
			'lavenderblush',
			'lawngreen',
			'lightblue',
			'lightcyan',
			'lightgoldenrodyellow',
			'lightgrey',
			'lightgreen',
			'lightpink',
			'lightsalmon',
			'lightskyblue',
			'lightsteelblue',
			'lightyellow',
			'lime',
			'limegreen',
			'magenta',
			'maroon',
			'orange',
			'orangered',
			'orchid',
			'pink',
			'powderblue',
			'purple',
			'red',
			'salmon',
			'silver',
			'skyblue',
			'snow',
			'steelblue',
			'tomato',
			'violet',
			'white',
			'yellow',
			'yellowgreen',
		);
		echo json_encode($color_array);
	}
	
	function add_credits() {
		extract($this->input->post());
		$insert_data = array(
			'user_id' => $user_id,
			'action' => $action,
			'object' => $object,
			'amount' => $amount,
			'timestamp' => time()
		);
		$this->db->insert('tbl_credits', $insert_data);
		echo json_encode($insert_data);
	}

	function use_credits() {
		extract($this->input->post());
		if($object == 'website_1') {
			$amount = 1200;
		}
		
		$insert_data = array(
			'user_id' => $user_id,
			'action' => $action,
			'object' => $object,
			'amount' => $amount,
			'timestamp' => time()
		);
		$this->db->insert('tbl_credits', $insert_data);
		echo json_encode($insert_data);
	}
	
	function messaging() {
		if($this->session->userdata('logged_in'))
		{
			$qActive = $this->db->get('bolooka_sessions');
			$rActive = $qActive->result_array();
			
			$data['active'] = $qActive->num_rows();
		
			$data['uid'] = $this->session->userdata('uid');

				$this->load->model('marketplace_model');
				$data['websites'] = $this->marketplace_model->getWebMarket();
				$data['products'] = $this->marketplace_model->getMarketProducts();
				$data['activemenu'] = 'messaging';
			
				$data['sidebar'] = $this->load->view('dashboard/sidebar', $data, true);

				$data['content'] = $this->load->view('chat/messaging', $data, true);
				
				$data2home['bar_holder'] = $this->load->view('bar_holder', $data, true);
				$data2home['body'] = $this->load->view('manage_account', $data, true);
				$data2home['footer'] = '';
				
				$this->load->view('dashboard/template', $data2home);
		} else {
			redirect(base_url());
		}		
	}
}


/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */