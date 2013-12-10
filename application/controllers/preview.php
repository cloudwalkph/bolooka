<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Preview extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('session');
		$this->load->database();
		$this->load->model('times_model');
		$this->load->model('video_model');
		$this->load->library('image_lib');
		$this->load->model('colormodel');
		$this->load->library('cart');
		$this->load->model('photo_model');
		$this->load->model('wall_updates');
	}

	public function index()
	{
		$product = null;
		$product_id = null;
		$wid = $this->input->get('wid');
		$logged = $this->session->userdata('logged_in');
		
		if(!$logged)
		{
			redirect(base_url());
		}
		else
		{
			$this->db->where('id', $wid);
			$this->db->where('deleted', 0);
			$query = $this->db->get('websites');
			
			if($query->num_rows() > 0) 
			{
				$data = $query->row_array();
				
				$data['site_id'] = $data['id'];
				
				$this->db->where('website_id', $data['id']);
				if($this->db->field_exists('page_seq', 'pages')) {
					$this->db->order_by('page_seq');
				} else {
					$this->db->order_by('order');
				}
				$queryPage = $this->db->get('pages');
				
				if($queryPage->num_rows() > 0) {

					$data['fpages'] = $queryPage->row();
					$data['pages'] = $queryPage->row_array();

					$data['wid'] = $data['id'];
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
						$data['datablogquery'] = $this->wall_updates->post_share($data['message_id'], $data['wid'], $data['pid']);

						if($data['datablogquery']->num_rows() > 0)
						{
							$queryBlog = $data['datablogquery']->row_array();
							$data['description'] = $queryBlog['message'];
							$data['blog_image'] = $queryBlog['image_name'];
							
						}
						// $data['activepage'] = $data['pages']['id'];
						$data['content'] = $this->load->view('templates/types/blog', $data, TRUE);
						
						
						
					} else if($data['page_type'] == 'photo') {
						$data['activepage'] = $data['pages']['id'];
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
						if($product == null)
						{
							$data['content'] = $this->load->view('templates/types/catalog', $data, TRUE);
						}
						else
						{
							$this->db->where('id', $product_id);
							$prod_query = $this->db->get('products');
							
							if($prod_query->num_rows() > 0)
							{
								$resultProd = $prod_query->row_array();
								
								$this->db->where('product_id', $product_id);
								$this->db->order_by('id', 'desc');
								$this->db->limit(1);
								$pimages = $this->db->get('products_images');							
								$data['site_name'] = $resultProd['name'];
								if($this->db->field_exists('product_desc', 'products')) {
									$data['description'] = strip_tags($resultProd['product_desc']);
								} else {
									$data['description'] = strip_tags($resultProd['desc']);
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
					
					$data['activepid'] = $data['activepage'];
					$data['menu_over'] = $data['bg']->menu_over;
					$data['align'] = 'class="horizontal"';
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

				$data['body'] = $this->load->view('templates/'.$data['layout'], $data, true);
				$this->load->view('templates/layout', $data);
			} else {
				show_404();
			}
		}
	}

	
	
	function show()
	
	{
		$id = $this->uri->segment(3);
		$results  = $this->db->get('gallery');
		$g_comments = $this->db->get('gallery_comment');
		
		
		
		foreach($results->result() as $result)
		
		{
			if($result->id==$id)
			
				{
						$data['image_id'] = $result->id;
						$data['image_title'] = $result->image_name;
						$data['image'] = $result->image;
						$data['desc'] = $result->descrip;
				}
				
		}
		
		
		foreach($g_comments->result() as $g_comment)
		
		{
			
			if($g_comment->gallery_id==$id)
			
				{
				
						$data['gallery_message'] = $g_comment->gallery_message;
				
				}
				
				
			else
			
				{
				
						$data['gallery_message'] = '';
					
				}
		
		}
		
	
		
		
		$this->load->view('templates/types/comment',$data);
	
	}
	
	
	function test()
	
		{
		
			$this->load->file('js/jquery.fancybox-1.3.4/index.html');
		
		}
		
		
	function tesss()
			
			{
				$this->load->view('gallery_comment');
			
			}
		
		function soon()
		
		{
		
			$this->load->view('available-soon');
			
			
		
		}
		
		function page_content()
		
		{
				$this->load->view('templates/types/photo');
		
		}
}

/* End of file preview.php */
/* Location: ./application/controllers/preview.php */