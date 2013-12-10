<?php
	/* 
	--product limit rules--
	250 pesos per 5 products
	500 pesos per 12 products
	1000 pesos 25 products 
	
	--free credits--
	15 free products for all catalogue
	1 website
	*/
	
	$this->db->where('user_id', $uid);
	$this->db->where('deleted', 0);
	$query = $this->db->get('websites');
	
	/* get all products per user */
	$getWebsite = 'SELECT id FROM websites WHERE user_id = '.$uid;
	$products_query = $this->db->query('SELECT * FROM products WHERE website_id IN ('.$getWebsite.')');
	
	$free_products = 15;
	$user_product_count = $products_query->num_rows();
	
	$remaining_products = $free_products - $user_product_count;
	
	
	/* Table Credits */
	$this->db->where('user_id', $uid);
	$qcredits = $this->db->get('tbl_credits');
	$rcredits = $qcredits->result_array();
	$str = $this->db->last_query();

	$total_credits = 0; $total_site = 0;

	foreach($rcredits as $credit_info) {
		if($credit_info['action'] === 'add') {
			$total_credits = $total_credits + $credit_info['amount'];
		}
		if($credit_info['action'] === 'buy') {
			$total_credits = $total_credits - $credit_info['amount'];
			if($credit_info['object'] === 'website_1') {
				$total_site = ($total_site + 1);
			}
		}
	}
	

	
?>
<style>
	/* RESPONSIVE CSS */
	@media (max-width: 767px)
	{
		.mobile_view {
			padding: 0 8px;
		}
	}
</style>

<div id="credits" class="container-fluid mobile_view">
	<legend style="font-family: Segoe UI Semibold; font-size: 18px; color: rgb(23, 23, 23);">Credits Infomation</legend>
	<div class="row-fluid">
		<div class="row-fluid">
			<button type="button" class="btn btn-large btn-info" id="add_credits_btn">Buy Credits</button>
			<button type="button" class="btn btn-large btn-info" id="buy_credits_btn">Use Credits</button>
		</div>
		<div class="row-fluid">
			<h4>Credits: <?php echo $total_credits; ?></h4>
			<p>Total websites: <span class="label label-info"><?php echo $query->num_rows(); ?></span></p>
			<p>Remaining websites: <span class="label label-important"><?php echo $total_site; ?></span></p>
			
			<p>Total created products: <span class="label label-info"><?php echo $user_product_count; ?></span></p>
			<p>Remaining free product post: <span class="label label-important"><?php echo $remaining_products; ?></span></p>
		</div>
		<hr style="margin-top:0;"/>
		<div class="accordion" id="accordion2">
			<div class="accordion-group">
				<div class="accordion-heading">
					<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne" style="text-decoration:none;">
						<strong> History </strong>
					</a>
				</div>
				<div id="collapseOne" class="accordion-body collapse">
					<div class="accordion-inner">
						<div class="row-fluid">
<?php
	foreach($rcredits as $c_history)
	{
		$this->db->where('uid', $c_history['user_id']);
		$quser = $this->db->get('users');
		$ruser = $quser->row_array();
		
		if($c_history['action'] === 'add') {
			echo '<div> '. $ruser['name'] . ' added ' .$c_history['amount']. ' credits to his/her account. <small><em> ' . $this->times_model->makeAgo($c_history['timestamp']) . ' </em></small> </div>';
		}
		if($c_history['action'] === 'buy') {
			if($c_history['object'] === 'website_1')
			echo '<div> '. $ruser['name'] . ' bought one(1) website to his/her account. <small><em> ' . $this->times_model->makeAgo($c_history['timestamp']) . ' </em></small> </div>';
		}
		
?>
<?php
	}
?>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<!--Modal credit choose-->
<div id="myModal_choose_credits" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-header title_message" style="background-color: #f26221;border-bottom:0;">
		<h4 id="myModalLabel1" style="color:#fff;font-size: 20px;margin: 5px 0;font-family: 'Segoe UI Semibold';opacity: 0.7;">Credits</h4>
	</div>
	<div class="modal-body" style="background-color: #e34e0d;color: #fff;">
		<div class="row-fluid">
			<div class="span12">
				<br/>
				<span>Enter amount</span>
				<div class="input-prepend input-append" style="margin-bottom: 0;">
				  <span class="add-on" style="color:#000;">Php</span>
				  <input class="span5 text-right" id="appendedPrependedInput" type="text" autocomplete="off">
				  <span class="add-on" style="color:#000;">.00</span>
				</div>
				<button id="add_credit_btn" class="btn pull-right">OK</button>
			</div>
		</div>
			
	</div>
</div>

<!--Modal package choose-->
<div id="myModal_buy_product" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-header title_message" style="background-color: #f26221;border-bottom:0;">
		<h4 id="myModalLabel2" style="color:#fff;font-size: 20px;margin: 5px 0;font-family: 'Segoe UI Semibold';opacity: 0.7;">Credits</h4>
	</div>
	<div class="modal-body" style="background-color: #e34e0d;color: #fff;">
		<div class="row-fluid">
			<p style="margin:0;">250 credits = 5 product post</p>
			<p style="margin:0;">500 credits = 12 product post</p>
			<p style="margin:0;">1000 credits = 25 product post</p>
			<p style="margin:0;">1200 credits = 1 website</p>
		</div>
		<hr>
		<div class="row-fluid">
			<strong>Select package type</strong>
			<div class="row-fluid text-center">
				<div class="span3">
					<div class="thumbnail">
						<span>250</span><br/>
						<button class="btn ucred" id="prod_5" style="margin-bottom:5px;">Select</button>
					</div>
				</div>
				<div class="span3">
					<div class="thumbnail">
						<span>500</span><br/>
						<button class="btn ucred" id="prod_12" style="margin-bottom:5px;">Select</button>
					</div>
				</div>
				<div class="span3">
					<div class="thumbnail">
						<span>1000</span><br/>
						<button class="btn ucred" id="prod_25" style="margin-bottom:5px;">Select</button>
					</div>
				</div>
				<div class="span3">
					<div class="thumbnail">
						<span>1200</span><br/>
						<button class="btn ucred" id="website_1" style="margin-bottom:5px;">Select</button>
					</div>
				</div>
			</div>
		</div>
			
	</div>
</div>

<script>
	$('#add_credits_btn').click(function() {
		$('#myModal_choose_credits').modal('show');
	});

	$('#buy_credits_btn').click(function(){
		$('#myModal_buy_product').modal('show');
	});
	
	$('#add_credit_btn').click(function() {
		var dataString = { user_id: <?php echo $uid; ?>, action: 'add', object: 'credits', amount: $('#appendedPrependedInput').val() };
		$.ajax({
			type: 'post',
			url: '<?php echo base_url(); ?>dashboard/add_credits',
			data: dataString,
			success: function(html) {
				var obj = JSON.parse(html);
				document.location.reload();
			}
		});
	});

	$('.ucred').click(function(){
		var dataString = { user_id: <?php echo $uid; ?>, action: 'buy', object: $(this).attr('id') };
		$.ajax({
			type: 'post',
			url: '<?php echo base_url(); ?>dashboard/use_credits',
			data: dataString,
			success: function(html) {
				var obj = JSON.parse(html);
				document.location.reload();
			}
		});
	});

</script>