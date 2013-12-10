<?php
	$contactus = '';
	$this->db->where('type', 'contact_us');
	$this->db->where('website_id', $wid);
	$queryPage = $this->db->get('pages');
	if($queryPage->num_rows() > 0){
		$resultPage = $queryPage->row_array();
		$contactus = $resultPage['name'];
		$contactus = url_title($contactus);
	}
	$this->db->where('website_id', $wid);
	$queryDesc = $this->db->get('design');
	$bg = $queryDesc->row();
?>
<div class="row-fluid" style="background: <?php echo $bg->boxcolor; ?>;border-radius: 9px;">
	<h3 style="margin-left: 20px;">Your Order Has Been Processed!</h3>
	<h6 style="margin-left: 25px;">Your order has been successfully processed!</h6>
	<h6 style="margin-left: 25px;">Please direct any questions you have to the <a href="<?php echo base_url().$web_url.'/'.$contactus; ?>">store owner</a>.</h6>

	<h6 style="margin-left: 25px;">Thanks for shopping with us online!</h6>
</div>