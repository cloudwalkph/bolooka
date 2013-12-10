<?php

class Cart_Model extends CI_Model {

	function getcartitems($wid = 0)
	{
		$msg = null;
		if($wid != 0) {
			$thecart = $this->cart->contents();
			$check_items = array();
			if(empty($thecart)){
				$msg = 0;
			}else{
				foreach($this->cart->contents() as $items){
					$this->db->where('id',$items['id']);
					$this->db->where('website_id',$wid);
					$checkproduct = $this->db->get('products');
					if($checkproduct->num_rows() > 0){
						$check_items[] = 'meron';
					}else{
						$check_items[] = 'wala';
					}
				}
				if(in_array('wala', $check_items)){
					$this->cart->destroy();
					$msg = 0;
				}else{
					$msg = $this->cart->total_items();
				}
			}
		}
		return $msg;
	}
	
	function carttotal($wid = 0)
	{
		$msg = null;
		if($wid != 0){
			$thecart = $this->cart->contents();
			$check_items = array();
			if(empty($thecart)){
				$msg = $this->cart->format_number($this->cart->total());
			}else{
				foreach($this->cart->contents() as $items){
					$this->db->where('id', $items['id']);
					$this->db->where('website_id', $wid);
					$checkproduct = $this->db->get('products');
					if($checkproduct->num_rows() > 0){
						$check_items[] = 'meron';
					}else{
						$check_items[] = 'wala';
					}
				}
				if(in_array('wala', $check_items)){
					$this->cart->destroy();
					$msg = 0;
				}else{
					$msg = $this->cart->format_number($this->cart->total());
				}
			}
		}
		return $msg;
	}

}
?>