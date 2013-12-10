<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shop extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('wall_updates');
		$this->load->helper(array('form', 'url'));
		$this->load->database();
		$this->load->library('session');
		$this->load->model('marketplace_model');
		$this->load->model('photo_model');
	}

	function index()
	{
		
	}

	function getProds() {
		$shop['market_id'] = $this->input->get_post('market_id');
		$items = $this->input->get_post('items');
		$shop['section'] = $this->input->get_post('section');
		$category = html_entity_decode($this->input->get_post('category'));
		$searchprod = html_entity_decode($this->input->get_post('searchprod'));
		$this->load->model('marketplace_model');
		
		if($this->db->field_exists('product_seq', 'products')) {
			$order = 'products.product_seq';
		} else {
			$order = 'products.order';
		}
		
		if($shop['market_id'] == 0) {
			$shop['products'] = $this->marketplace_model->getMarketplaceProducts($shop['market_id'], $items, 0, $shop['section'], $category, $searchprod, $order);
		} else {
			$shop['products'] = $this->marketplace_model->getMarketProducts($shop['market_id'], $items, 0, $shop['section'], $category, $searchprod, $order);
		}
		$this->load->view('marketplace/content', $shop);
	}
	
	function getmore()
	{
			$data['type'] = $this->input->get_post('type');
			$data['items'] = $this->input->get_post('items');
			$data['lastitem'] = $this->input->get_post('lastitem');
			$data['section'] = $this->input->get_post('section');
			$data['category'] = html_entity_decode($this->input->get_post('category'));
			$data['searchprod'] = html_entity_decode($this->input->get_post('searchprod'));
		
 			// if(is_numeric($data['lastitem'])) {
				if($data['type'] == 'products') {
					$shop['market_id'] = $this->input->get_post('market_id');

					$start = ($data['lastitem'] * $data['items']) - $data['items'];
					
					if($this->db->field_exists('product_seq', 'products')) {
						$order = 'products.product_seq';
					} else {
						$order = 'products.order';
					}
					
					if($shop['market_id'] == 0) {
						$shop['products'] = $this->marketplace_model->getMarketplaceProducts($shop['market_id'], $data['items'], $start, $data['section'], $data['category'], $data['searchprod'], $order);
					} else {
						$shop['products'] = $this->marketplace_model->getMarketProducts($shop['market_id'], $data['items'], $start, $data['section'], $data['category'], $data['searchprod'], $order);
					}
					// $shop['craft_categs'] = $this->marketplace_model->getProductCategories(0, 'crafts');
					// $shop['furniture_categs'] = $this->marketplace_model->getProductCategories(0, 'furniture');
					
					$shop['websites'] = $this->marketplace_model->getWebsite();
					$shop['action'] = 'view';
					$shop['lastitem'] = $data['lastitem'] + 1;
					$shop['geturl'] = 'getmoreprods';
					
					$shop['content'] = $this->load->view('marketplace/content', $shop);
					
					// $data['page'] = 'marketplace';
					// $data['header'] = '';
					// $data['body'] = $this->load->view('marketplace/template', $shop, true);
					// $data['footer'] = '';
				}
			// }

		// $this->load->view('homepage', $data);
	}
	
	function getWebsites() {
		$this->load->model('photo_model');
		$this->load->model('marketplace_model');
		$market_id = $this->input->post('market_id');
		$shop['websites'] = $this->marketplace_model->getWebMarket($market_id);
		$this->load->view('marketplace/websites', $shop);
	}
	
	function loaders()
	{
			echo "<script type = \"text/javascript\">";
			echo "var ID = ".$this->uri->segment(3);
			echo "alert(ID);";		
			echo "</script>";
	}
	
	function moreprods() {
		if($id != null)
		{
			$this->db->where('id', $id);
		}
		$this->db->order_by('id','desc');
		$this->db->where('deleted', 0);
		$query = $this->db->get('websites');
	}
	
	function ces() {
		echo $this->session->userdata('logged_in');
	}
}

/* End of file shop.php */
/* Location: ./application/controllers/shop.php */