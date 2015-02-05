<?php
	$this->db->select('*');
	$this->db->from('user_marketgroup');
	$this->db->where('user_id', $this->session->userdata('uid'));
	$getGrouId = $this->db->get();
	$groupID = $getGrouId->row_array();
	
	$get_prod_nums = $this->marketplace_model->getMarketProducts($groupID['marketgroup_id']);
	$num_of_prod = $get_prod_nums->num_rows();
?>
<div class="container-fluid">
	<div id="headerArea">
		<div class="uiHeader uiHeaderPage uiHeaderBottomBorder">
			<h2><legend id="msy-web" style="font-family: Segoe UI Semibold; font-size: 18px; color: rgb(23, 23, 23);">Products :</legend></h2>
		</div>
	</div>
	<div id="contentArea">
		<!--<div style="display: inline-block;">
			<span>Filter by: </span>
			<select class="market_select">
				<option>Website...</option>
			</select>
			<select class="market_select">
				<option>Date</option>
			</select>
		</div>-->
		<div style="font-size: 12px; font-family: Segoe UI;">Number of products: &nbsp; <?php echo $num_of_prod > 0 ? $num_of_prod : 'none (0)'; ?></div>
		<div style="margin-top: 30px;">
<?php
		$this->market_model->getProductList($groupID['marketgroup_id']);
?>
		</div>
	</div>
	<input type="hidden" id="market_product_base_url" value="<?php echo base_url() ?>" />
	<input type="hidden" id="" value="" />
</div>
<?php
	if($groupID['role'] != 3)
	{
		$page= "<script type='text/javascript'>page_add_success('OK')</script>";
		echo $page;
	}
?>