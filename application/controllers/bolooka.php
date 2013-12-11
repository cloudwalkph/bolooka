<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bolooka extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->database();
		$this->load->model('session_model');
		$this->load->model('membership_model');
		$this->load->model('colormodel');
		$this->load->library('email');
		$this->load->model('times_model');
		$this->load->library('image_lib');
		$this->load->model('photo_model');
		$this->load->model('video_model');
		$this->load->library('cart');
		$this->load->library('encrypt');

		$this->load->model('marketplace_model');
		$this->load->model('facebook_model');
		$this->load->model('wall_updates');
	}
	
	function index() {
		$this->db->query('
CREATE TABLE IF NOT EXISTS `product_inquiry` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `receiver_email` text NOT NULL,
  `sender_email` text NOT NULL,
  `sender_name` text NOT NULL,
  `subject` text NOT NULL,
  `message` text NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
		');
		// create table product variants
		$this->db->query('
			CREATE TABLE IF NOT EXISTS `product_variants` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`product_id` int(11) NOT NULL,
			`website_id` int(11) NOT NULL,
			`type` varchar(255) DEFAULT NULL,
			`name` varchar(255) DEFAULT NULL,
			`price` int(11) NOT NULL,
			`quantity` int(11) NOT NULL,
			PRIMARY KEY (`id`)
			) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
		');
		if(isset($_GET['bolookas']))
		{
			$this->administrator();
			return false;
		}
		
		/* this is for forgot password */
		if(isset($_GET['u']) && isset($_GET['n']))
		{

			$this->reset_password();
			return false;
		}

		$this->marketplace();
	}

	function home()
	{
		$data2home = null;

			$data2body['sign_in'] = $this->load->view('homepage/sign_in_form', '', TRUE);
		
			$data2body['isHome'] = 'yes';
			
			$data2home['header'] = $this->load->view('homepage/header', $data2body, TRUE);
			$data2home['body'] = $this->load->view('homepage/body', $data2body, TRUE);
			$data2home['footer'] = $this->load->view('homepage/footer', $data2body, TRUE);

			$this->load->view('homepage', $data2home);
	}
	
	function w($web = null, $page = null, $product = null, $product_id = 0)
	{
		$data['url'] = url_title($web, '-', true);
		
		$this->db->where('url', $data['url']);
		$this->db->where('deleted', 0);
		$query = $this->db->get('websites');

		if($query->num_rows() > 0)
		{
			$data = $query->row_array();
			
			if($this->input->get('layout')) {
				$data['layout'] = $this->input->get('layout');
			}
			
			$data['wid'] = $data['id'];
			
			/* get background design */
			$this->db->where('website_id', $data['wid']);
			$queryDesc = $this->db->get('design');
			$data['bg'] = $queryDesc->row();
			/* */
			
			/* get logo settings */
			$this->db->where('website_id', $data['wid']);
			$queryLogo = $this->db->get('logo');
			if ($queryLogo->num_rows() == '0') {
				$queryAdd = "INSERT INTO `logo` (`website_id`) VALUES ('".$data['wid']."')";
				$this->db->query($queryAdd);
			} else {
				$logo = $queryLogo->row();
			}
			$this->db->where('website_id', $data['wid']);
			$queryLogo = $this->db->get('logo');
			$data['logo'] = $queryLogo->row();
			/* */
			
			/* get footer settings */
			$this->db->where('website_id', $data['wid']);
			$qFooter = $this->db->get('footer');
			$data['footer'] = $qFooter->row();			
			/* */
			
			if($page)
			{
				$this->db->where('url', $page);
			}
			$status = array(1, 'publish');
			$this->db->where_in('status', $status);
			if($this->db->field_exists('page_seq', 'pages')) {
				$this->db->order_by('page_seq');
			} else {
				$this->db->order_by('order');
			}
			$this->db->where('website_id', $data['wid']);
			$queryPage = $this->db->get('pages');
			
			if($queryPage->num_rows() == 0) {
				if(isset($page))
				{
					$pageurl = str_replace('-', ' ', $page);
					$this->db->where('name', $pageurl);
				}
				$status = array(1, 'publish');
				$this->db->where_in('status', $status);
				$this->db->where('website_id', $data['wid']);
				if($this->db->field_exists('page_seq', 'pages')) {
					$this->db->order_by('page_seq');
				} else {
					$this->db->order_by('order');
				}
				$queryPage = $this->db->get('pages');
			}
			
			$data['page_type'] = null;
			$data['content'] = null;
			$data['pages'] = null;
			
			if($queryPage->num_rows() > 0) {
				$data['pages'] = $queryPage->row_array();

				$data['pid'] = $data['pages']['id'];
				
				$data['page_url'] = $data['pages']['url'];
				$data['page_type'] = $data['pages']['type'];

				if($data['page_type'] == 'article') {
					$data['activepage'] = $data['pages']['id'];
					$this->db->where('page_id', $data['pid']);
					$queryArticle = $this->db->get('articles');
					if($queryArticle->num_rows() > 0) { // check if exists in article table
						$resultArticle = $queryArticle->row_array();
						$data['content'] = $resultArticle['content'];
					} else { // displays the old content
						$data['content'] = $data['pages']['content'];
					}

				} else if($data['page_type']=='blog') {            // blog content
					$data['activepage'] = $data['pages']['id'];
					
					/* for post sharing */
					if(isset($product)) {
						$data['product'] = $product;
						$product_id = $data['product'];
					}
					
					/* get this query */
					$data['datablogquery'] = $this->wall_updates->post_share($product_id, $data['wid'], $data['pid']);

					if($data['datablogquery']->num_rows() > 0)
					{
						$queryBlog = $data['datablogquery']->row_array();
						$data['description'] = $queryBlog['message'];
						$data['blog_image'] = $queryBlog['image_name'];
					}
					$data['content'] = $this->load->view('templates/types/blog', $data, TRUE);
					
				} else if($data['page_type'] == 'photo') {
					$data['activepage'] = $data['pages']['id'];
					$data['pid'] = $data['pages']['id'];

/* from multi/viewphotoFE */
		if($data['albumid'] = $this->input->get_post('albumid')) {
			if($query->num_rows() > 0) {
				$result = $query->row_array();
				$data['photo_content'] = $this->load->view('templates/types/photolist', $data, true);
			}
		} else {
/* */
					$data['photo_content'] = $this->load->view('templates/types/photo_album', $data, true);
		}					
					$data['content'] = $this->load->view('templates/types/photo', $data, TRUE);
					$data['galleryPage'] = 'picture_frame';
				} else if($data['page_type'] == 'contact_us') {
					$data['activepage'] = $data['pages']['id'];
					$data['content'] = $this->load->view('templates/types/contact_us', $data, TRUE);
				} else if($data['page_type'] == 'catalogue') {
					$data['activepage'] = $data['pages']['id'];
					$data['page_name'] = $data['pages']['name']; 
					$data['web_url'] = $data['url'];

					if($data['pages']['url'] == null){
						$data['page_url'] = url_title($data['pages']['name'],'-',true);
					} else {
						$data['page_url'] = $data['pages']['url'];
					}
							
					$data['product'] = $product;
					$data['product_id'] = $product_id;

					if($product == null) {
						$data['content'] = $this->load->view('templates/types/catalog', $data, TRUE);
					} else {
						$this->db->where('id', $product_id);
						$prod_query = $this->db->get('products');
						
						if($prod_query->num_rows() > 0) {
							$resultProd = $prod_query->row_array();
							
							$this->db->where('product_id', $product_id);
							$this->db->order_by('id');
							$this->db->limit(1);
							$pimages = $this->db->get('products_images');							
							$data['site_name'] = $resultProd['name'];
							if($this->db->field_exists('product_desc', 'products')) {
								$data['description'] = strip_tags(html_entity_decode($resultProd['product_desc'], ENT_QUOTES));
							} else {
								$data['description'] = strip_tags(html_entity_decode($resultProd['desc'], ENT_QUOTES));
							}
							
							$data['productimage'] = null;
							if($pimages->num_rows() > 0)
							{
								$data['prodimgs'] = $pimages->result_array();
								$data['productimage'] = base_url().'uploads/'.$data['user_id'].'/'.$data['id'].'/'.$data['pages']['id'].'/'.$product_id.'/'.$data['prodimgs'][0]['images'];
							}
						}
						$data['content'] = $this->load->view('templates/types/product', $data, TRUE);
					}
				}
				
				$data['activepid'] = $data['activepage'];
				$data['menu_over'] = $data['bg']->menu_over;
				
				/* error catch */
				if($data['layout'] == null) {
					$data['layout'] = 'layout1';
				}
				/* */

				if($data['layout'] == 'layout1' || $data['layout'] == 'layout2') {
					$data['menu'] = $this->load->view('templates/menu.php', $data, true);
				}
				if($data['layout'] == 'layout3' || $data['layout'] == 'layout4') {
					$data['menu'] = $this->load->view('templates/menu3.php', $data, true);
				}
				if($data['layout'] == 'layout5' || $data['layout'] == 'layout6') {
					$data['menu'] = $this->load->view('templates/menu6_5.php', $data, true);
				}
			}
			
			/* for cart holder */
			$this->load->model('cart_model');
			$data['items_cart'] = $this->cart_model->getcartitems($data['wid']);
			
			$data['c_total'] = $this->cart_model->carttotal($data['wid']);
			
			$data['holder'] = $this->load->view('holder', $data, true);
			/* */
				
			if($this->facebook_model->fb_not_visited($data['url'])) {
				$data['fb_message'] = $this->facebook_model->fb_action_visit($data['url']);
			} else {
				$data['fb_message'] = 'site already visited';
			}

			$data['body'] = $this->load->view('templates/'.$data['layout'], $data, true);
			$this->load->view('templates/layout', $data);

		}
		else
		{
			/*** Look in Marketgroup ***/
			$this->load->model('marketplace_model');
			
			$qmarket = $this->marketplace_model->getMarket($web);
			$rmarketRow = $qmarket->row_array();

			$this->marketplace($rmarketRow['id'], $rmarketRow);
		}
	}
	
	function market($market_id = null)
	{

	}
	
	/* some tools */
	
	function pass_encode() {
		$pass = $this->input->get('pass');
		$this->load->library('encrypt');
		
		$data = $this->encrypt->encode($pass);
		echo $data;
	}
	
	function pass_decode() {
		$pass = '';
		$this->load->library('encrypt');

		$data = $this->encrypt->decode($pass);
		echo $data;
	}

	function data_uri() {
		$file = realpath("img/loading.gif");
		$mime = "image/gif";
		$contents = file_get_contents($file);
		$base64 = base64_encode($contents);
		echo "data:$mime;base64,$base64";
	}
	
	/* end some tools */
	
	/* inner pages */
	
	function about_us()
	{
		$data2body[''] = "";
		$data2home['header'] = $this->load->view('homepage/header', $data2body, TRUE);
		$data2home['body'] = $this->load->view('pages/about_us', $data2body, TRUE);
		$data2home['footer'] = $this->load->view('homepage/footer', $data2body, TRUE);

		$data2home['page'] = "inpgs";
		$this->load->view('homepage', $data2home);
	}
	function team()
	{
		$data2body[''] = "";
		$data2home['header'] = $this->load->view('homepage/header', $data2body, TRUE);
		$data2home['body'] = $this->load->view('pages/team', $data2body, TRUE);
		$data2home['footer'] = $this->load->view('homepage/footer', $data2body, TRUE);
		
		$data2home['page'] = "inpgs";
		$this->load->view('homepage', $data2home);
	}
	function press()
	{
		$data2body[''] = "";
		$data2home['header'] = $this->load->view('homepage/header', $data2body, TRUE);
		$data2home['body'] = $this->load->view('pages/press', $data2body, TRUE);
		$data2home['footer'] = $this->load->view('homepage/footer', $data2body, TRUE);
		
		$data2home['page'] = "inpgs";
		$this->load->view('homepage', $data2home);
	}
	function jobs()
	{
		$data2body[''] = "";
		$data2home['header'] = $this->load->view('homepage/header', $data2body, TRUE);
		$data2home['body'] = $this->load->view('pages/jobs', $data2body, TRUE);
		$data2home['footer'] = $this->load->view('homepage/footer', $data2body, TRUE);
		
		$data2home['page'] = "inpgs";
		$this->load->view('homepage', $data2home);
	}
	public function investor()
	{
		$data2body[''] = "";
		$data2home['header'] = $this->load->view('homepage/header', $data2body, TRUE);
		$data2home['body'] = $this->load->view('pages/investor', $data2body, TRUE);
		$data2home['footer'] = $this->load->view('homepage/footer', $data2body, TRUE);
		
		$data2home['page'] = "inpgs";
		$this->load->view('homepage', $data2home);
	}	
	public function features()
	{
		$data2body[''] = "";
		$data2home['header'] = $this->load->view('homepage/header', $data2body, TRUE);
		$data2home['body'] = $this->load->view('pages/features', $data2body, TRUE);
		$data2home['footer'] = $this->load->view('homepage/footer', $data2body, TRUE);
		
		$data2home['page'] = "inpgs";
		$this->load->view('homepage', $data2home);
	}	
	public function faq()
	{
		$data2body[''] = "";
		$data2home['header'] = $this->load->view('homepage/header', $data2body, TRUE);
		$data2home['body'] = $this->load->view('pages/faq', $data2body, TRUE);
		$data2home['footer'] = $this->load->view('homepage/footer', $data2body, TRUE);
		
		$data2home['page'] = "inpgs";
		$this->load->view('homepage', $data2home);
	}	
	public function how_to()
	{
		$data2body[''] = "";
		$data2home['header'] = $this->load->view('homepage/header', $data2body, TRUE);
		$data2home['body'] = $this->load->view('pages/how_to', $data2body, TRUE);
		$data2home['footer'] = $this->load->view('homepage/footer', $data2body, TRUE);
		
		$data2home['page'] = "inpgs";
		$this->load->view('homepage', $data2home);
	}

	public function feedback($action=null)
	{
		if($action == 'submit_feedback') {
			$subject = $this->input->post('subject');
			$name = $this->input->post('name');
			$email = $this->input->post('email');
			$message = $this->input->post('message');
			
			$this->load->library('email');
			
					$config['mailtype'] = 'html';
					$config['charset'] = 'iso-8859-1';
					$config['wordwrap'] = TRUE;
					
					$this->email->initialize($config);
			
			$this->email->from('info@bolooka.com', 'Bolooka Feedback Responder');
			$this->email->to($email);
			// $this->email->cc('info@bolooka.com');
			// $this->email->bcc('them@their-example.com');

			$this->email->subject($subject);
			$this->email->message($message);
			
			if($this->email->send()) {
				echo '1';
			}
			// echo $this->email->print_debugger();
		} else {
			$data2body[''] = "";
			$data2home['header'] = $this->load->view('homepage/header', $data2body, TRUE);
			$data2home['body'] = $this->load->view('pages/feedback', $data2body, TRUE);
			$data2home['footer'] = $this->load->view('homepage/footer', $data2body, TRUE);
			
			$data2home['page'] = "inpgs";
			$this->load->view('homepage', $data2home);
		}
	}
	
	public function contact_us($action=null)
	{
		if($action == 'submit') {
			$subject = $this->input->post('subject');
			$name = $this->input->post('name');
			$email = $this->input->post('email');
			$message = $this->input->post('message');
			
			$this->load->library('email');
			
					$config['mailtype'] = 'html';
					$config['charset'] = 'iso-8859-1';
					$config['wordwrap'] = TRUE;
					
					$this->email->initialize($config);
			
			$this->email->from('info@bolooka.com', 'Bolooka Contact Responder');
			$this->email->to($email);
			// $this->email->cc('info@bolooka.com');
			// $this->email->bcc('them@their-example.com');

			$this->email->subject($subject);
			$this->email->message($message);
			
			if($this->email->send()) {
				echo '1';
			}
			// echo $this->email->print_debugger();		
		} else {
			$data2body[''] = "";
			$data2home['header'] = $this->load->view('homepage/header', $data2body, TRUE);
			$data2home['body'] = $this->load->view('pages/contact_us', $data2body, TRUE);
			$data2home['footer'] = $this->load->view('homepage/footer', $data2body, TRUE);
			
			$data2home['page'] = "inpgs";
			$this->load->view('homepage', $data2home);
		}
	}

	public function partners()
	{
		$data2body[''] = "";
		$data2home['header'] = $this->load->view('homepage/header', $data2body, TRUE);
		$data2home['body'] = $this->load->view('pages/partners', $data2body, TRUE);
		$data2home['footer'] = $this->load->view('homepage/footer', $data2body, TRUE);
		
		$data2home['page'] = "inpgs";
		$this->load->view('homepage', $data2home);
	}
	
		
	function captcha()
	{
		$this->load->helper('captcha_helper');
		$vals = array(
			'word'	 => 'way',
			'img_path'	 => './captcha/',
			'img_url'	 => 'http://example.com/captcha/',
			'font_path'	 => './path/to/fonts/texb.ttf',
			'img_width'	 => '150',
			'img_height' => 30,
			'expiration' => 7200
		);

		$cap = create_captcha($vals);
		echo $cap['image'];
		//$this->load->view('captcha');
	}

	function ps_drop_shadow($angle=0, $distance=0, $spread=0, $size=0, $color="#000", $inner=false) {
		$angle = (180 - $angle) * pi() / 180; // convert to radians
		$h_shadow = round(cos($angle) * $distance);
		$v_shadow = round(sin($angle) * $distance);
		$css_spread = $size * $spread/100;
		$blur = ($size - $css_spread);

		echo "
			-moz-box-shadow: $h_shadow $v_shadow $blur $css_spread $color; <br />
			-webkit-box-shadow: $h_shadow $v_shadow $blur $css_spread $color; <br />
			-o-box-shadow: $h_shadow $v_shadow $blur $css_spread $color; <br />
			box-shadow: $h_shadow $v_shadow $blur $css_spread $color; <br />
		";
	}

	function ps_text_shadow($angle=0, $distance=0, $spread=0, $size=0, $color="#000", $inner=false) {
		$angle = 120;
		$distance = 1;
		$spread = 0;
		$size = 3;
		
		$angle = (180 - $angle) * pi() / 180; // convert to radians
		$h_shadow = round(cos($angle) * $distance);
		$v_shadow = round(sin($angle) * $distance);
		$css_spread = $size * $spread/100;
		$blur = ($size - $css_spread);

		echo "
			text-shadow: $h_shadow $v_shadow $blur $color; <br />
		";
	}
	
	# get users data
	
	function get_user_data() {
		if($this->input->post()) {
			$from = strtotime($this->input->post('from'));
			$to = strtotime($this->input->post('to'));
			
			$this->db->where('date_registered >=', $from);
			$this->db->where('date_registered <=', $to);
		}
		$users['query'] = $this->db->get('users');
		$this->load->view('admin/users', $users);
	}
	
	function administrator() {
		date_default_timezone_set('Asia/Manila');
		$data = null;
		$data2home = null;
		$bolookas = null;
		
			if($this->input->post()) {
				$un = $this->input->post('inputUsername');
				$pw = $this->input->post('inputPassword');
				
				$data['msg'] = 'Access Invalid';
				
				if($un != '' || $pw != '') {
					$this->db->where('email', $un);
					$queryUser = $this->db->get('users');
					if($queryUser->num_rows > 0) {
						$rowUser = $queryUser->row();
						if($pw == $this->encrypt->decode($rowUser->password)) {
							$bolookas = true;
						} else {
							$data['msg'] = 'Account Invalid';
						}
					} else {
						$data['msg'] = 'Account Invalid';
					}
				} else {
					$data['msg'] = 'Fill up the blanks';
				}
			}
			
			if($bolookas == true) {
				$user = array(
					'uid' => $rowUser->uid,
					'v_email' => $rowUser->email,
					'v_pass' => $this->encrypt->decode($rowUser->password),
					'v_firstName' => $rowUser->first_name
				);
				$this->session_model->create_session($user['uid'], $user['v_firstName']);
			} else {
				$data2home['body'] = $this->load->view('admin/login', $data, true);
			}
			
		if($this->session->userdata('logged_in') == 1) {
			$this->db->where('uid', $this->session->userdata('uid'));
			$queryUser = $this->db->get('users');
			if($queryUser->num_rows() > 0) {
				$rowUser = $queryUser->row_array();
				if($rowUser['admin_access'] == 1) {

					$data['range'] = 24; $data['offset'] = 1;
					$start = ($data['range'] * $data['offset']) - $data['range'];

					/* marketplace control */
					$data['queryAllMarketProducts'] = $this->marketplace_model->getMarketProducts();
					
					$data['queryMarketProducts'] = $this->marketplace_model->getMarketProducts(null, $data['range'], $start);
					
					$data['marketplace_control_content'] = $this->load->view('admin/marketplace_control_content', $data, true);
					$data['marketplace_control'] = $this->load->view('admin/marketplace_control', $data, true);
					
					/* websites control */
					$data['queryAllActiveWebsites'] = $this->marketplace_model->getActiveWebsites();
					$data['queryActiveWebsites'] = $this->marketplace_model->getActiveWebsites($this->input->post('webfrom'), $this->input->post('webto'), $data['range'], $start);
					
					$data['websites_control_content'] = $this->load->view('admin/websites_control_content', $data, true);
					$data['websites_control'] = $this->load->view('admin/websites_control', $data, true);
					
					/* users */
					$data['queryAllUsers'] = $this->marketplace_model->getUsers();
					$data['queryUsers'] = $this->marketplace_model->getUsers($this->input->post('userfrom'), $this->input->post('userto'), $data['range'], $start);
					$data['users_content'] = $this->load->view('admin/users_content', $data, true);
					$data['users'] = $this->load->view('admin/users', $data, true);
					
					/* websites */
					$data['queryAllWebsites'] = $this->marketplace_model->getWebsites();
					$data['queryWebsites'] = $this->marketplace_model->getWebsites($this->input->post('webfrom'), $this->input->post('webto'), $data['range'], $start);

					$data['websites_content'] = $this->load->view('admin/websites_content', $data, true);
					$data['websites'] = $this->load->view('admin/websites', $data, true);
					
					/* products */
					$data['queryAllProducts'] = $this->marketplace_model->getProducts();
					$data['queryProducts'] = $this->marketplace_model->getProducts($this->input->post('prodfrom'), $this->input->post('prodto'), $data['range'], $start);
					$data['products_content'] = $this->load->view('admin/products_content', $data, true);
					$data['products'] = $this->load->view('admin/products', $data, true);
					

					$data2home['body'] = $this->load->view('admin/panel', $data, true);
				}
			}
		}

		$this->load->view('homepage', $data2home);
	}
	
	function reset_password()
	{
		$this->load->library('encrypt');
		$user_id = $_GET['u'];
		$user_hash = $_GET['n'];
		
		$data['uid'] = $user_id;
		$data['hash'] = $user_hash;
		
		$data2home['body'] = $this->load->view('forgot_password', $data, true);
		$this->load->view('homepage', $data2home);
	}
	
	function v_pinterest() {
		$this->load->file('api/pinterest-d585d.html');
	}
	
	function marketplace($market_id = 0, $resultShop = null) {
		$shop['resultShop'] = $resultShop;
		if($this->input->get('t'))
		{
			$template = $this->input->get('t');
		} else {
			if($resultShop['template'] == null) {
				$template = '1';
			} else {
				$template = $resultShop['template'];
			}
		}

		$shop['market_id'] = $market_id;
		$shop['section'] = null;
		$shop['items'] = 30;
		$shop['lastitem'] = 2;
		if($this->db->field_exists('product_seq', 'products')) {
			$shop['products'] = $this->marketplace_model->getMarketplaceProducts($market_id, $shop['items'], 0, $shop['section'], null, null, 'products.product_seq');
		} else {
			if($market_id == 0) {
				$shop['products'] = $this->marketplace_model->getMarketplaceProducts($market_id, $shop['items'], 0, $shop['section'], null, null, 'products.order');
			} else {
				$shop['products'] = $this->marketplace_model->getMarketProducts($market_id, $shop['items'], 0, $shop['section'], null, null, 'products.order');
			}
		}
		$shop['all_categs'] = $this->marketplace_model->getProductCategories($market_id);
		$shop['craft_categs'] = $this->marketplace_model->getProductCategories($market_id, 'crafts');
		$shop['food_categs'] = $this->marketplace_model->getProductCategories($market_id, 'food');
		$shop['furniture_categs'] = $this->marketplace_model->getProductCategories($market_id, 'furniture');
		$shop['websites'] = $this->marketplace_model->getWebsite();
		$shop['action'] = 'view';
		$shop['geturl'] = 'getmoreprods';
		
		$shop['content'] = $this->load->view('marketplace/content', $shop, true);
		
		$data['page'] = 'marketplace';
		$data['header'] = '';
		$data['body'] = $this->load->view('marketplace/template'.$template, $shop, true);
		$data['footer'] = $this->load->view('marketplace/footer', $shop, true);
		
		$this->load->view('homepage', $data);

	}
}

/* End of file bolooka.php */
/* Location: ./application/controllers/bolooka.php */