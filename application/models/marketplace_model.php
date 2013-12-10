<?php
	class Marketplace_Model extends CI_Model
	{
		
		function getWebsite($id=null, $start=null, $range=null)
		{
			if(isset($id))
			{
				$this->db->where('id', $id);
			}
			$this->db->where('deleted', 0);
			$this->db->order_by('id', 'desc');
			$query = $this->db->get('websites');
			
			return $query;
		}
		
		function getWebsiteLogo($id=null)
		{
			if($id != null)
			{
				$this->db->where('website_id', $id);
			}
			$query = $this->db->get('logo');
			
			return $query;
		}
		
		function getPage($id=null)
		{
			if($id != null)
			{
				$this->db->where('id', $id);
			}
			$query = $this->db->get('pages');
			
			return $query;
		}
		
		/***** market queries *****/
		function getMarket($url=null)
		{
			if($url != null)
			{
				$this->db->where('url', $url);
				$query = $this->db->get('marketgroup');
				if($query->num_rows() == 0)
				{
					$this->db->where('id', $url);
					$query = $this->db->get('marketgroup');
				}
			}
			return $query;			
		}
		
		function getWebMarket($market_id=0)
		{
			$this->db->select("*");
			$this->db->where('deleted', 0);
			$this->db->from('websites');
			if($market_id == 0) {
				$this->db->where('websites.marketplace = 1');
			} else {
				$this->db->join('web_marketgroup', 'websites.id = web_marketgroup.web_id', 'left');
				$this->db->where_in('web_marketgroup.status', array("approved", "accepted", 1));
				$this->db->where('web_marketgroup.marketgroup_id', $market_id);
			}
			$this->db->order_by('date_created', 'desc');
			$query = $this->db->get();

			return $query;
		}
		
		function getMarketProducts($market_id=0, $range=0, $start=0, $section=null, $category=null, $match=null, $orderby='id desc') {
				// $this->db->distinct();
				if($this->db->field_exists('product_desc', 'products')) {
					$this->db->select('products.product_desc');
				} else {
					$this->db->select('products.desc');	
				}
				
				if($this->db->field_exists('product_cover', 'products')) {
					$this->db->select('products.product_cover');
				} else {
					$this->db->select('products.primary');
				}
				
				$this->db->select("products.id, page_id, website_id, websites.url, websites.user_id, websites.site_name, name, products.category, price, stocks, video, published, products.marketplace, products.section, products.date_modified, products.product_posted");
				$this->db->from('products');
				$this->db->where('products.published', 1);

				$this->db->join('websites', 'products.website_id = websites.id', 'left');
				$this->db->where('websites.deleted', 0);

			if($market_id == 0) {
				$this->db->where('websites.marketplace', 1);
				// $this->db->where('products.marketplace', 1);
			} else {
				$this->db->join('web_marketgroup', 'web_marketgroup.web_id = websites.id');
				$this->db->where('web_marketgroup.marketgroup_id', $market_id);
				$this->db->where_in('web_marketgroup.status', array("approved", "accepted", 1));
				$this->db->join('product_moderation', 'products.id = product_moderation.product_id', 'left');
				$this->db->select('product_moderation.disabled');
				// $this->db->having('product_moderation.disabled !=', 1);
			}

			if($section != null && $section != 'undefined') {
				$this->db->like('products.section', $section);
			}

			if($category != null) {
				$this->db->like('products.category', $category);
			}

			if($match != null) {
				$this->db->join('tags', 'products.id = tags.prod_id', 'left');
				$this->db->where('(`products`.`id` LIKE "%'.ltrim($match, 0).'%" OR `name` LIKE "%'.$match.'%" OR `products`.`category` LIKE "%'.$match.'%" OR `tags`.`tag_names` LIKE "%'.$match.'%" OR `websites`.`url` LIKE "%'.$match.'%" OR `websites`.`site_name` LIKE "%'.$match.'%")', null, true);
			}
			
			$this->db->group_by('products.id');

			if($orderby != null) {
				$this->db->order_by($orderby);
			}

			if($range != 0) {
				if($start == 0) {
					$this->db->limit($range);
				} else {
					$this->db->limit($range, max($start, 0));
				}
			}

			$query = $this->db->get();
			// echo $this->db->last_query();
			return $query;
		}
		
		function getMarketplaceProducts($market_id=0, $range=0, $start=0, $section=null, $category=null, $match=null, $orderby='id desc') {
				// $this->db->distinct();
				if($this->db->field_exists('product_desc', 'products')) {
					$this->db->select('products.product_desc');
				} else {
					$this->db->select('products.desc');	
				}
				
				if($this->db->field_exists('product_cover', 'products')) {
					$this->db->select('products.product_cover');
				} else {
					$this->db->select('products.primary');
				}
				
				$this->db->select("products.id, page_id, website_id, websites.url, websites.user_id, websites.site_name, name, products.category, price, stocks, video, published, products.marketplace, products.section, products.date_modified, products.product_posted");
				$this->db->from('products');
				$this->db->where('products.published', 1);

				$this->db->join('websites', 'products.website_id = websites.id', 'left');
				$this->db->where('websites.deleted', 0);

			if($market_id == 0) {
				$this->db->where('websites.marketplace', 1);
				$this->db->where('products.marketplace', 1);
			} else {
				$this->db->join('web_marketgroup', 'web_marketgroup.web_id = websites.id');
				$this->db->where('web_marketgroup.marketgroup_id', $market_id);
				$this->db->where_in('web_marketgroup.status', array("approved", "accepted", 1));
				$this->db->join('product_moderation', 'products.id = product_moderation.product_id', 'left');
				$this->db->select('product_moderation.disabled');
				// $this->db->having('product_moderation.disabled !=', 1);
			}

			if($section != null && $section != 'undefined') {
				$this->db->like('products.section', $section);
			}

			if($category != null) {
				$this->db->like('products.category', $category);
			}

			if($match != null) {
				$this->db->join('tags', 'products.id = tags.prod_id', 'left');
				$this->db->where('(`products`.`id` LIKE "%'.ltrim($match, 0).'%" OR `name` LIKE "%'.$match.'%" OR `products`.`category` LIKE "%'.$match.'%" OR `tags`.`tag_names` LIKE "%'.$match.'%" OR `websites`.`url` LIKE "%'.$match.'%" OR `websites`.`site_name` LIKE "%'.$match.'%")', null, true);
			}
			
			$this->db->group_by('products.id');

			if($orderby != null) {
				$this->db->order_by($orderby);
			}

			if($range != 0) {
				if($start == 0) {
					$this->db->limit($range);
				} else {
					$this->db->limit($range, max($start, 0));
				}
			}

			$query = $this->db->get();
			// echo $this->db->last_query();
			return $query;
		}
		
		function getProductCategories($market_id=0, $section=null)
		{
			$this->db->select('products.category');
			$this->db->from('products');
			$this->db->join('websites', 'products.website_id = websites.id', 'left');
			$this->db->where('websites.deleted', 0);
			if($market_id == 0) {
				$this->db->where('products.marketplace', 1);
			} else {
				$this->db->join('web_marketgroup', 'web_marketgroup.web_id = websites.id', 'left');
				$this->db->where('web_marketgroup.marketgroup_id', $market_id);
				$this->db->where_in('web_marketgroup.status', array("approved", "accepted", 1));
				$this->db->join('product_moderation', 'products.id = product_moderation.product_id', 'left');
				$this->db->select('product_moderation.disabled');
			}
			if($section != null && $section != 'undefined') {
				$this->db->like('products.section', $section);
			}
			$this->db->group_by('products.category');
			$this->db->order_by('products.category');

			$query = $this->db->get();
			// echo $this->db->last_query();
			$result = $query->result_array();
			
			return $query;
		}
		
		function getActiveWebsites($datefrom = null, $dateto = null, $range = 0, $start = 0, $match = null, $orderby='id desc') {
			if($datefrom) {
				$from = strtotime($datefrom);
				$this->db->where('date_created >=', $from);
			}
			if($dateto) {
				$to = strtotime($dateto);
				$this->db->where('date_created <=', $to);
			}
			if($match != null) {			
				$this->db->where('(`url` LIKE "%'.ltrim($match, 0).'%" OR `site_name` LIKE "%'.$match.'%" OR `description` LIKE "%'.$match.'%")', null, true);				
			}
			if($orderby != null) {
				$this->db->order_by($orderby);
			}
			if($range != 0) {
				if($start == 0) {
					$this->db->limit($range);
				} else {
					$this->db->limit($range, max($start, 0));
				}
			}
			$this->db->where('deleted', '0');
			return $this->db->get('websites');		
		}

		/* query for Bolookas Admin */
		function getUsers($datefrom = null, $dateto = null, $range = 0, $start = 0, $match = null, $orderby='uid desc') {
			if($datefrom) {
				$from = strtotime($datefrom);
				$this->db->where('date_registered >=', $from);
			}
			if($dateto) {
				$to = strtotime($dateto);
				$this->db->where('date_registered <=', $to);
			}
			if($match != null) {			
				$this->db->where('(`name` LIKE "%'.ltrim($match, 0).'%" OR `first_name` LIKE "%'.$match.'%" OR `last_name` LIKE "%'.$match.'%" OR `email` LIKE "%'.$match.'%")', null, true);				
			}
			if($orderby != null) {
				$this->db->order_by($orderby);
			}
			if($range != 0) {
				if($start == 0) {
					$this->db->limit($range);
				} else {
					$this->db->limit($range, max($start, 0));
				}
			}
			return $this->db->get('users');
		}
		
		function getWebsites($datefrom = null, $dateto = null, $range = 0, $start = 0, $match = null, $orderby='id desc') {
			if($datefrom) {
				$from = strtotime($datefrom);
				$this->db->where('date_created >=', $from);
			}
			if($dateto) {
				$to = strtotime($dateto);
				$this->db->where('date_created <=', $to);
			}
			if($match != null) {			
				$this->db->where('(`url` LIKE "%'.ltrim($match, 0).'%" OR `site_name` LIKE "%'.$match.'%" OR `description` LIKE "%'.$match.'%")', null, true);				
			}
			if($orderby != null) {
				$this->db->order_by($orderby);
			}
			if($range != 0) {
				if($start == 0) {
					$this->db->limit($range);
				} else {
					$this->db->limit($range, max($start, 0));
				}
			}
			return $this->db->get('websites');		
		}
		
		function getProducts($datefrom = null, $dateto = null, $range = 0, $start = 0, $match = null, $orderby='id desc') {
			if($datefrom) {
				$from = strtotime($datefrom);
				$this->db->where('date_created >=', $from);
			}
			if($dateto) {
				$to = strtotime($dateto);
				$this->db->where('date_created <=', $to);
			}
			if($match != null) {			
				$this->db->where('(`name` LIKE "%'.ltrim($match, 0).'%" OR `section` LIKE "%'.$match.'%" OR `category` LIKE "%'.$match.'%" OR `sub_category` LIKE "%'.$match.'%")', null, true);				
			}
			if($orderby != null) {
				$this->db->order_by($orderby);
			}
			if($range != 0) {
				if($start == 0) {
					$this->db->limit($range);
				} else {
					$this->db->limit($range, max($start, 0));
				}
			}
			return $this->db->get('products');			
		}

	}
?>