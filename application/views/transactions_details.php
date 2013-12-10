<?php
	date_default_timezone_set('Asia/Manila');

	$uid = $this->session->userdata('uid');
	
	/* get transacations_detail for history */
	$this->db->where('status','closed');
	$history_query = $this->db->get('transactions_detail');
	
	/* get transactions_details  for seller*/
	$this->db->where('seller_id',$uid);
	$this->db->where('status','pending');
	$this->db->order_by('purchase_date','desc');
	if($this->input->get('ftxn'))
	{
		$ftxn = $this->input->get('ftxn');
		$this->db->like('txn_id',$ftxn);
	}
	$trans_query = $this->db->get('transactions_detail');
	
	/* get transactions_details for bought items */
	$this->db->select('
		costumer.txn_id,
		transactions_detail.status,
		transactions_detail.delivery_status,
		transactions_detail.seller_id,
		transactions_detail.delivery_cost,
		transactions_detail.delivery_method
	');
	$this->db->where('costumer.account_type',$uid);
	$this->db->where('transactions_detail.status','pending');
	$this->db->order_by('transactions_detail.purchase_date','desc');
	if($this->input->get('ftxn'))
	{
		$ftxn = $this->input->get('ftxn');
		$this->db->like('costumer.txn_id',$ftxn);
	}
	$this->db->from('costumer');
	$this->db->join('transactions_detail','transactions_detail.txn_id = costumer.txn_id');
	$bought_query = $this->db->get();
	
?>
<style type="text/css">
	.btn-style:hover{
		background: rgb(206,73,16); /* Old browsers */
		background: -moz-linear-gradient(top, rgba(206,73,16,1) 37%, rgba(239,96,30,1) 100%); /* FF3.6+ */
		background: -webkit-gradient(linear, left top, left bottom, color-stop(37%,rgba(206,73,16,1)), color-stop(100%,rgba(239,96,30,1))); /* Chrome,Safari4+ */
		background: -webkit-linear-gradient(top, rgba(206,73,16,1) 37%,rgba(239,96,30,1) 100%); /* Chrome10+,Safari5.1+ */
		background: -o-linear-gradient(top, rgba(206,73,16,1) 37%,rgba(239,96,30,1) 100%); /* Opera 11.10+ */
		background: -ms-linear-gradient(top, rgba(206,73,16,1) 37%,rgba(239,96,30,1) 100%); /* IE10+ */
		background: linear-gradient(to bottom, rgba(206,73,16,1) 37%,rgba(239,96,30,1) 100%); /* W3C */
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ce4910', endColorstr='#ef601e',GradientType=0 ); /* IE6-9 */
	}
	.btn-style{
		background: rgb(239,96,30); /* Old browsers */
		background: -moz-linear-gradient(top, rgba(239,96,30,1) 0%, rgba(206,73,16,1) 100%); /* FF3.6+ */
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(239,96,30,1)), color-stop(100%,rgba(206,73,16,1))); /* Chrome,Safari4+ */
		background: -webkit-linear-gradient(top, rgba(239,96,30,1) 0%,rgba(206,73,16,1) 100%); /* Chrome10+,Safari5.1+ */
		background: -o-linear-gradient(top, rgba(239,96,30,1) 0%,rgba(206,73,16,1) 100%); /* Opera 11.10+ */
		background: -ms-linear-gradient(top, rgba(239,96,30,1) 0%,rgba(206,73,16,1) 100%); /* IE10+ */
		background: linear-gradient(to bottom, rgba(239,96,30,1) 0%,rgba(206,73,16,1) 100%); /* W3C */
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ef601e', endColorstr='#ce4910',GradientType=0 ); /* IE6-9 */
		color:#fff;
	}
	
	@media(max-width:800px)
	{
		.table-bordered 
		{
			display: block;
			position: relative;
			width: 100%;
		}
		.table-bordered thead
		{
			display: block;
			float: left;
		}
		.table-bordered thead tr
		{
			display: block;
		}
		.table-bordered thead tr th
		{
			display: block;
			text-align: right;
		}
		.table-bordered tbody
		{
			display: block;
			width: auto;
			position: relative;
			overflow-x: auto;
			white-space: nowrap;
		}
		.table-bordered tbody tr
		{
			display: inline-block;
			vertical-align: top;
			border-left: 1px solid #babcbf;
		}
		.table-bordered tbody td
		{
			border-left: 0;
			border-right: 0;
			border-bottom: 0;
			display: block;
			min-height: 1.25em;
			text-align: left;
		}
		.costTotalRow {
			display:block !important;
			border-top: 2px solid;
			float: left;
		}
	}
</style>

<div class="container-fluid">
	<h4>Orders</h4>
	<hr class="" style="margin-left:0;" />
	<div class="alert upload-success" style="display:none;">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		Successfully uploaded.
	</div>
	<div class="container-fluid pull-right">
		<form class="form-horizontal text-right search-form-txn" onsubmit="return false;" style="margin: 0;">					
			<div class="input-append">
				<input class="searchtxt" id="appendedInputButtons" type="text" placeholder="Enter transaction number here">
				<button type="submit" class="btn txnbtn">Search</button>
				<a class="btn" href="<?php echo base_url(); ?>multi/transactions">Show All</a>
			</div>					
		</form>
	</div>
	<div class="tabbable trans-table" style="margin-left:0;"> <!-- Only required for left/right tabs -->
		<ul class="nav nav-tabs">
			<li class="active"><a alt="tab1" href="#tab1" data-toggle="tab">Transactions Orders</a></li>
			<li><a alt="tab2" href="#tab2" data-toggle="tab">Bought Items</a></li>
			<li><a alt="tab3" href="#tab3" data-toggle="tab">History</a></li>
		</ul>
		<div class="tab-content">
			<!-- Orders Items Start -->
			<div class="row-fluid tab-pane active" id="tab1">			
				<div class="row-fluid">
					<ul style="margin:0;">
<?php
	if($trans_query->num_rows() > 0)
	{
		foreach($trans_query->result_array() as $trans_row)
		{
?>
						<li style="background: #EEEEEE;padding:5px;margin-bottom: 5px;" class="<?php echo $trans_row['payer_email']; ?>">
							<div class="span8">
								<div class="row-fluid">
									<div class="span3">
										<strong>Transaction No:</strong> 
									</div>
									<div class="span8">
										<a href="#" role="button" class="txn_show" id="<?php echo $trans_row['txn_id']; ?>"><?php echo strtoupper($trans_row['txn_id']); ?></a>
									</div>
								</div>
								<div class="row-fluid">
									<div class="span3">
										<strong>Order date:</strong>
									</div>
									<div class="span8">
										<?php echo date('F j, Y',$trans_row['purchase_date']); ?>
									</div>
								</div>
								<div class="row-fluid">
									<div class="span3">
										<strong>Customer:</strong>
									</div>
									<div class="span8">
										<?php echo $trans_row['payer_email']; ?>
									</div>
								</div>			
							</div>	
							
							<div class="span4">
								<div style="margin-bottom: 4px;">
									<strong>Status:</strong> 
<?php
	if($trans_row['status'] != 'closed')
	{
?>
									<div class="label label-important"><?php echo $trans_row['status']; ?></div>
<?php
	}else{
?>
									<div class="label label-success"><?php echo $trans_row['status']; ?></div>
<?php
	}
?>
								</div>
								<div style="margin-bottom: 4px;">
									<strong>Shipment:</strong>
<?php
	if($trans_row['delivery_status'] == 'not delivered' || $trans_row['delivery_status'] == 'on delivery')
	{
?>
									<button type="button" class="btn btn-mini delivered_proceed" id="<?php echo $trans_row['txn_id']; ?>">Send a Delivery</button>
<?php
	}else
	{
?>
									<div class="label label-success"><?php echo $trans_row['delivery_status']; ?></div>
<?php
	}
?>
								</div>
								<div style="margin-bottom: 4px;">
									<strong>Payment:</strong>
<?php
	if($trans_row['payment_status'] == 'not paid')
	{
?>
									<button type="button" class="btn btn-mini payment_button" alt="<?php echo $trans_row['txn_id']; ?>">Paid?</button>
									<button type="button" class="btn btn-mini payment_notyet" alt="<?php echo $trans_row['txn_id']; ?>">Not yet!</button>
<?php
	}else{
?>
									<div class="label label-success"><?php echo $trans_row['payment_status']; ?></div>
<?php
	}
?>
								</div>
							</div>
							
						<div style="clear:both;"></div>
						</li>
<?php
		}
	}else
	{
?>
						<li style="font-style:italic;">No transactions</li>
<?php
	}
?>
					</ul>
				</div>
			</div>
			<!-- Sold Items End -->
			<div class="tab-pane" id="tab2">
				<div class="row-fluid">
					<ul style="margin:0;">
<?php
	if($bought_query->num_rows() > 0)
	{
		$x = 0;
		foreach($bought_query->result_array() as $key => $row)
		{
			/* A variable takes the value of a variable and treats that as the name of a variable */
			$total_cost = 'total'.$x;
			$$total_cost = array();
			
			$this->db->where('txn_id',$row['txn_id']);
			$query_order = $this->db->get('orders_items')->result_array();
	?>
						<li style="background: #EEEEEE;padding:5px;margin-bottom: 5px;">
							<div class="row-fluid">
								<div class="span6">
									<div class="row-fluid">
										<div class="span4"><strong>Transaction No:</strong></div>
										<div class="span6" style="margin:0;color:#0088cc;"><?php echo strtoupper($row['txn_id']); ?></div>
									</div>
								</div>
								<div class="span6">
									<strong>Status:</strong>
<?php
	if($row['status'] != 'closed')
	{
?>
									<div class="label label-important"><?php echo $row['status']; ?></div>
<?php
	}else{
?>
									<div class="label label-success"><?php echo $row['status']; ?></div>
<?php
	}
?>
									<strong>Shipment:</strong>
<?php
	if($row['delivery_status'] == 'on delivery')
	{
?>
										<button type="button" class="btn btn-mini receive_item" id="<?php echo $row['txn_id']; ?>">Received?</button>
<?php
	}else if($row['delivery_status'] == 'delivered')
	{
?>
									<div class="label label-success"><?php echo $row['delivery_status']; ?></div>
<?php 
	}else
	{	
?>
									<div class="label label-important"><?php echo $row['delivery_status']; ?></div>
<?php
	}
?>
								</div>
								
							</div>
							<div class="row-fluid">
								<table class="table table-bordered">
									<thead>
										<th>Product id</th>
										<th>Product name</th>
										<th>Quantity</th>
										<th>Price</th>
										<th>Subtotal</th>
									</thead>
									<tbody>
<?php
			
			foreach($query_order as $row_order)
			{
				${$total_cost}[] = $row_order['subtotal'];
?>
										<tr>
											<td><?php echo str_pad($row_order['product_id'], 7, 0, STR_PAD_LEFT); ?></td>
											<td>
												<span><?php echo $row_order['product_name']; ?></span></br>
												<span>-<?php echo $row_order['variant_name']; ?></span>
											</td>
											<td><?php echo $row_order['qty']; ?></td>
											<td>&#8369;<?php echo $row_order['price']; ?></td>
											<td>&#8369;<?php echo $row_order['subtotal']; ?></td>
										</tr>
<?php
			}
			
			/* add delivery cost to total */
			${$total_cost}[] = $row['delivery_cost'];
?>
										<tr class="costTotalRow">
											<td colspan="4"><strong>Delivery Cost</strong></td>
											<td colspan="4">&#8369;<?php echo number_format($row['delivery_cost'],2); ?></td>
										</tr>
										<tr class="costTotalRow">
											<td colspan="4"><strong>Total</strong></td>
											<td colspan="4"><strong style="font-size: 18px;">&#8369;<?php echo number_format(array_sum(${$total_cost}),2); ?></strong></td>
										</tr>
									</tbody>
								</table>
							</div>
						</li>
<?php
			$x++;
		}
	}else
	{
		echo '<li style="font-style:italic;">No transactions</li>';
	}
?>
					</ul>
				</div>
			</div>
			<div class="tab-pane" id="tab3">
				<div class="row-fluid">
					<div class="accordion" id="accordion2">
<?php
	if($history_query->num_rows() > 0)
	{
		$x = 0;
		foreach($history_query->result_array() as $hrow)
		{
			/* A variable takes the value of a variable and treats that as the name of a variable */
			$total_cost = 'total'.$x;
			$$total_cost = array();
			
			$this->db->where('txn_id',$row['txn_id']);
			$query_order = $this->db->get('orders_items')->result_array();
?>
						<div class="accordion-group">
							<div class="accordion-heading">
								<span style="padding-left:5px;">Transaction No.</span>
								<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne" style="display:inline-block;padding: 8px 5px;">
									<?php echo $hrow['txn_id']; ?>
								</a>
								<div class="label label-success">Closed</div>
							</div>
							<div id="collapseOne" class="accordion-body collapse">
								<div class="accordion-inner">
									<div>
										<strong>Order date:&nbsp;</strong>
										<span><?php echo date('F j, Y',$hrow['purchase_date']); ?></span>
									</div>
									<div>
										<strong>Customer Email:&nbsp;</strong>
										<span><?php echo $hrow['payer_email']; ?></span>
									</div>
									<div>
										<strong>Delivery Method:&nbsp;</strong>
										<span><?php echo $hrow['delivery_method']; ?></span>
									</div>
									<div>
										<strong>Payment type:&nbsp;</strong>
										<span><?php echo $hrow['payment_option']; ?></span>
									</div>
									<hr style="margin:10px 0;"/>
									<table class="table table-bordered">
										<thead>
											<th>Product id</th>
											<th>Product name</th>
											<th>Quantity</th>
											<th>Price</th>
											<th>Subtotal</th>
										</thead>
										<tbody>
<?php
			
			foreach($query_order as $row_order)
			{
				${$total_cost}[] = $row_order['subtotal'];
?>
											<tr>
												<td><?php echo str_pad($row_order['product_id'], 7, 0, STR_PAD_LEFT); ?></td>
												<td>
													<span><?php echo $row_order['product_name']; ?></span></br>
													<span>-<?php echo $row_order['variant_name']; ?></span>
												</td>
												<td><?php echo $row_order['qty']; ?></td>
												<td>&#8369;<?php echo $row_order['price']; ?></td>
												<td>&#8369;<?php echo $row_order['subtotal']; ?></td>
											</tr>
<?php
			}
			
			/* add delivery cost to total */
			${$total_cost}[] = $row['delivery_cost'];
?>
											<tr class="costTotalRow">
												<td colspan="4"><strong>Delivery Cost</strong></td>
												<td colspan="4">&#8369;<?php echo number_format($row['delivery_cost'],2); ?></td>
											</tr>
											<tr class="costTotalRow">
												<td colspan="4"><strong>Total</strong></td>
												<td colspan="4"><strong style="font-size: 18px;">&#8369;<?php echo number_format(array_sum(${$total_cost}),2); ?></strong></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
<?php
		}
	}else
	{
		echo '<span style="font-style:italic;">No transactions closed</span>';
	}
?>
					</div>
				</div>
			</div>
		</div>
	</div>

	 
	<!-- Modal -->
	<div id="sendInfoModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
	  <div class="modal-body trans-body-status">
		<p>This will send a message and confirmation to the customer that the item he/she ordered has been delivered</p>
	  </div>
	  <div class="modal-footer" style="border: none;background: rgba(255, 255, 255, 0);box-shadow: none;">
		<button class="btn btn-style" id="proceed_message" style="letter-spacing: 1px;" value="" data-loading-text="Please wait...">Send</button>
		<button class="btn btn-style" data-dismiss="modal" style="letter-spacing: 1px;" aria-hidden="true">Cancel</button>
	  </div>
	</div>
	
	<!-- Modal -->
	<div id="paymentModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
	  <div class="modal-body trans-body-status">
		<p>Are your sure this transaction already paid?</p>
	  </div>
	  <div class="modal-footer" style="border: none;background: rgba(255, 255, 255, 0);box-shadow: none;">
		<button class="btn btn-style" id="payment_success" style="letter-spacing: 1px;" value="" data-loading-text="Please wait...">Yes</button>
		<button class="btn btn-style" data-dismiss="modal" style="letter-spacing: 1px;" aria-hidden="true">No</button>
	  </div>
	</div>
	
	<!-- Modal -->
	<div id="paymentNotyetModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
	  <div class="modal-body trans-body-status">
		<p>Send an email to buyer</p>
	  </div>
	  <div class="modal-body" style="border: none;background: rgba(255, 255, 255, 0);box-shadow: none;">
<?php
	$formToPayAttrib = array(
		'id' => 'submit_to_pay',
		'name' => 'submit_to_pay',
		'class' => 'form-horizontal'
	);
			echo form_open(base_url('multi/email_to_pay'), $formToPayAttrib);
?>
				<div class="control-group">
					<label class="control-label" for="inputEmail">Subject</label>
					<div class="controls">
						<input type="text" id="inputEmail" name="subject_to_pay">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="inputPassword">Message</label>
					<div class="controls">
						<textarea rows="4" id="inputPassword" placeholder="Message" name="message_to_pay"></textarea>
					</div>
				</div>
				<div class="pull-right">
					<button class="btn btn-style" id="submit_to_buyer" name="submit_to_buyer" type="submit" style="letter-spacing: 1px;" value="" data-loading-text="Please wait...">Send</button>
					<button class="btn btn-style" data-dismiss="modal" style="letter-spacing: 1px;" aria-hidden="true">No</button>
				</div>
			</form>
	  </div>
	</div>
	
	<!-- Modal -->
	<div id="receiveInfoModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
	  <div class="modal-body trans-body-status">
		<p>Did you receive the items you ordered in this transaction?</p>
		<small>Send a notification to the seller</small>
	  </div>
	  <div class="modal-footer" style="border: none;background: rgba(255, 255, 255, 0);box-shadow: none;">
		<button class="btn btn-style" id="proceed_message_receive" style="letter-spacing: 1px;" value="" data-loading-text="Please wait...">Send</button>
		<button class="btn btn-style" data-dismiss="modal" style="letter-spacing: 1px;" aria-hidden="true">Cancel</button>
	  </div>
	</div>
	<!-- Modal -->
	<div id="transmodal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-header" style="background: none repeat scroll 0 0 #F26A2C;border-bottom: medium none;color: white;">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel" style="font-weight: normal;" class="mode-title">Transaction details</h3>
	  </div>
	  <div class="modal-body trans-body-status">
		<p>Please wait...</p>
	  </div>
	</div>
	<!-- Modal -->
	<div id="transmodal2" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="border-radius: 0;background: rgba(255, 255, 255, 0.8);font-family:Segoe UI;">
	  <div class="modal-header" style="background: #F26A2C;color: white;border-bottom: none;">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel" style="font-weight: normal;">Order Slip</h3>
	  </div>
	  <div class="modal-body mode-infoboy" style="font-size: 11px">
		<p>Please wait...</p>
	  </div>
	  <div class="modal-footer" style="border: none;background: rgba(255, 255, 255, 0);box-shadow: none;">
		<button class="btn btn-style" data-dismiss="modal" style="letter-spacing: 1px;" aria-hidden="true">CLOSE</button>
	  </div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('a[rel="tooltip"]').tooltip();
		
		$('a[data-toggle="tab"]').on('shown', function (e) {
			/* save the latest tab; use cookies if you like 'em better: */
			sessionStorage.setItem('lastTab', $(e.target).attr('alt'));
		});

		/* go to the latest tab, if it exists: */
		var lastTab = sessionStorage.getItem('lastTab');
		if (lastTab) {
			$('a[href="#'+lastTab+'"]').tab('show');
		} else {
			$('a[href="#details"]').tab('show');
		}
		
		$('.txn_show').on('click',function(){
			var id = $(this).attr('id');
			$.ajax({
				beforeSend: function() {
					$('#transmodal').modal('show');
				},
				type: 'post',
				url: '<?php echo base_url(); ?>multi/transaction_details',
				data: {'txn_id':id},
				success: function(html){
					$('#transmodal').find('.trans-body-status').html(html);
				}
			});
		});
		
		$('.delivered_proceed').on('click',function(){
			var txnid = $(this).attr('id');
			$('#proceed_message').val(txnid);
			$('#sendInfoModal').modal('show');
		});
		$('#proceed_message').on('click',function(){
			var dis = $(this);
			var txnid = $(this).val();
			$.ajax({
				beforeSend: function(){
					dis.parent().children().button('loading');
				},
				type: 'post',
				url: '<?php echo base_url('multi/delivery_to_buyer') ?>',
				data: {'txnid': txnid},
				success: function(html){
					dis.parent().children().button('reset');
					$('#sendInfoModal').modal('hide');
					
					
				}
			});
		});
		$('.receive_item').on('click',function(){
			var txnid = $(this).attr('id');
			$('#proceed_message_receive').val(txnid);
			$('#receiveInfoModal').modal('show');
		});
		$('#proceed_message_receive').on('click',function(){
			var dis = $(this);
			var txnid = $(this).val();
			$.ajax({
				beforeSend: function(){
					dis.parent().children().button('loading');
				},
				type: 'post',
				url: '<?php echo base_url('multi/delivery_to_buyer/to_seller') ?>',
				data: {'txnid': txnid},
				success: function(html){
					dis.parent().children().button('reset');
					$('#receiveInfoModal').modal('hide');
				
				}
			});
		});
		$('.search-form-txn').on('submit', function(){
			
			var searchitem = $('.searchtxt').val();		
			if(searchitem.trim() != ''){
				$('.searchtxt').val('');
				window.location.href = '<?php echo base_url(); ?>multi/transactions?ftxn='+searchitem;
			}else
			{
				$('.searchtxt').focus();
			}
		});
		$('.payment_button').on('click',function(){
			var txnid = $(this).attr('alt');
			$('#payment_success').val(txnid);
			$('#paymentModal').modal('show');
		});
		$('#payment_success').on('click',function(){
			var txnid = $(this).val();
			var dis = $(this);
			$.ajax({
				beforeSend: function(){
					// dis.parent().children().button('loading');
				},
				type: 'post',
				url: '<?php echo base_url('multi/payment_paid') ?>',
				data: {'txnid': txnid},
				success: function(html){
					$('.payment_button[alt='+txnid+']').parent().html('<strong>Payment:</strong>&nbsp;<div class="label label-success">Paid</div>');
					$('#paymentModal').modal('hide');
				}
			});
			
		});
		$('.payment_notyet').on('click',function(){
			var txnid = $(this).attr('alt');
			$('#submit_to_buyer').val(txnid);
			$('#paymentNotyetModal').modal('show');
		});
		$('#submit_to_pay').ajaxForm({
			beforeSubmit: function(formData, jqForm, options) {
				var form = jqForm[0];
				if (!form.subject_to_pay.value || !form.message_to_pay.value) { 
					return false; 
				}
				$('#submit_to_buyer').button('loading');
				$('button[aria-hidden=true]').button('loading');
			},
			success: function(html) {
				if(html == 'send')
				{
					$('#submit_to_buyer').button('reset');
					$('button[aria-hidden=true]').button('reset');

					$('#paymentNotyetModal').modal('hide');  

				}else
				{
					
				}
			}
		});
	});

</script>
<style type="text/css">
table .title-bought
{
	padding-top: 10px;
	padding-bottom: 10px;
}
table .item-bought
{
	padding-top: 5px;
	padding-bottom: 5px;
	border-bottom: 1px solid #D6CBCB;
}
</style>