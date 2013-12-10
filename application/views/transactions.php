<?php
	date_default_timezone_set('Asia/Manila');
		
	if($this->input->get('ftxn')){
		$ftxn = $this->input->get('ftxn');
		$query = $this->db->query("SELECT * FROM transactions WHERE txn_id LIKE '%$ftxn%' ORDER BY id DESC");
	}else{
		$query = $this->db->query("SELECT * FROM transactions ORDER BY id DESC");
	}
	$uid = $this->session->userdata('uid');
	$if_yours = false;
	$if_me = array();
	$i = 1;
	$pr_weight = Array();
	$overall = Array();
	$i = 1;
	$ship_cost = 0;
?>
<style type="text/css">
	.trans-table table tr td
	{
		text-align:center;
		vertical-align: middle;
		padding: 3px;
	}
	.trans-table table tr td.outside
	{
		padding: 4px 2px;
	}
	.row-style{
		border:1px solid #c0bebf;
	}
	.row-subtitle{
		background:#f6f6f6;
		color:#595959;
	}
	.row-subcolor{
		background:#efefef;
	}
	.remove-margin{
		margin-bottom: 0;
	}
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
		<li class="active"><a href="#tab1" data-toggle="tab">Sold Items</a></li>
		<li><a href="#tab2" data-toggle="tab">Bought Items</a></li>
		<li><a href="#tab3" data-toggle="tab">History</a></li>
	  </ul>
	  <div class="tab-content">
	<!-- Sold Items Start -->
		<div class="row-fluid tab-pane active" id="tab1">			
			<table width="100%" cellspacing="0" cellpadding="0" class="table">
				<tr style="color: #fff;background: #9E9E9E;border:1px solid #c0bebf;">
					<td height="40" width="10%">Date Sold</td>
					<td width="10%">Transaction No.</td>
					<td width="15%">Costumer</td>
					<td width="40%" colspan="4">Status</td>
					<td width="10%">Receipt</td>
					<td width="15%">Sub Total</td>
				</tr>
				<?php
					if($query->num_rows() > 0){
						foreach($query->result_array() as $result){
							$prd_ary = rtrim($result['product_id_array'], ',');
							$prd_ary   = explode(',',$prd_ary);
						if(strlen($result['txn_id']) == 17){	
							foreach($prd_ary as $prd_info2){
								$prd_id = substr($prd_info2, 0, strrpos( $prd_info2, '-' ));
								$this->db->where('id', $prd_id);
								$get_the_product = $this->db->get('products');
								
								if($get_the_product->num_rows() > 0){
									foreach($get_the_product->result_array() as $prduct){
										$web_id = $prduct['website_id'];
										$pr_weight[$result['id']][] = $prduct['prod_weight'];
										$this->db->where('id',$prduct['website_id']);
										$this->db->where('user_id',$this->session->userdata('uid'));
										$get_the_website = $this->db->get("websites");
										if($get_the_website->num_rows() > 0){
											$if_yours = true;
											$if_me[] = true;
										}
									}//end foreach
								}
							}//end foreach
							
							$this->db->where('txn_id', $result['txn_id']);
							$getconfirm = $this->db->get('confirm_orders');
							$resultconfirm = $getconfirm->row_array();
							
							$this->db->where('txn_id', $result['txn_id']);
							$getcontumer = $this->db->get('costumer');
							$resultcostumer = $getcontumer->row_array();
							
							$subtotal =  str_replace(',','',$result['mc_gross']);
							
						
							if($if_yours){
								$overall[] = $subtotal;								
								if((($resultconfirm['payopt'] == 'pay_email') AND (!empty($result['verify_sign']))) OR ($resultconfirm['payopt'] != 'pay_email')){
				?>
							<tr style="font-size: 11px;" class="<?php echo $i % 2 == 0 ? 'row-subcolor' : ''; ?>">
								<td rowspan="2" class="row-style"><?php echo $resultconfirm['payopt'] == 'pay_email' ? $result['payment_date'] : date('M d, Y',$result['payment_date']) ; ?></td>
								<td rowspan="2" class="row-style">
									<a style="padding-top: 0;padding-bottom: 0;font-size: 11px;" href="#transmodal2" role="button" onclick="gettxn2(this)" alt='<?php echo $result['txn_id']; ?>' data-toggle="modal">
										<?php echo $result['txn_id']; ?>
									</a>
								</td>
								<td rowspan="2" class="row-style">
									<?php echo $result['first_name'].' '.$result['last_name']; ?>
								</td>
								<td height="30" class="row-style row-subtitle">Shipped</td>
								<td class="row-style row-subtitle">Received</td>
								<td class="row-style row-subtitle">Payments</td>
								<td class="row-style row-subtitle">Transaction</td>
								<td class="row-style" rowspan="2" style="border-width: 1px 1px 0 1px;">
									<?php 
										if($resultcostumer['account_type'] == 0){ 
											if(!empty($resultconfirm['receiptfile'])){
									?>
									<a class="receipt_prev" alt="<?php echo !empty($resultconfirm['receiptfile']) ? base_url().'uploads/'.$resultcostumer['user_id'].'/'.$resultconfirm['receiptfile'] : '' ; ?>" style="color: #000; text-decoration: none; cursor: pointer">
										Receipt
									</a>									
									<?php 
											}else{
												echo 'No Receipt';
											}
										}else{ 
									?>
										Guest Costumer
									<?php } ?>									
									<div class="receipt_preview container" style="display:none;"></div>
								</td>
								<td class="row-style row-subtitle">Real</td>
							</tr>
							<tr style="font-size: 11px;" class="<?php echo $i % 2 == 0 ? 'row-subcolor' : ''; ?>">
								<td height="50" class="row-style">
									<form class="form-inline" id="frm_<?php echo $result['txn_id']; ?>" style="margin: 0;display: none;">
										<label class="radio">
											<input type="radio" name="opt" onclick="shipchoice(this.value, '<?php echo $result['txn_id']; ?>')" value="1" />Yes
										</label>
										<label class="radio">
											<input type="radio" name="opt" onclick="shipchoice(this.value, '<?php echo $result['txn_id']; ?>')" value="0" />No
										</label>		
									</form>
									<?php echo isset($resultconfirm['delivery_status']) && $resultconfirm['delivery_status'] != '' ? str_replace('No','<span class="no-opt'.$result['txn_id'].'" onclick="hideno(this,\''.$result['txn_id'].'\')">No</span>',$resultconfirm['delivery_status']) : '<span class="no-opt'.$result['txn_id'].'" onclick="hideno(this,\''.$result['txn_id'].'\')">No</span>'; ?>
								</td>
								<td class="row-style">
									<?php echo $resultconfirm['received'] == 1 ? 'Yes' : 'No'; ?>
								</td>
								<td class="row-style" style="border-width: 1px 1px 0 1px;">
									<?php
										if($resultconfirm['payopt'] == 'pay_email'){
											echo 'Paid';
										}else{
											if(($resultconfirm['received'] == 1) AND ($resultconfirm['delivery_status'] !='')){
												echo 'Paid';
											}else{
												if(isset($resultconfirm['payment_status']) && $resultconfirm['payment_status'] == 'Paid'){
													echo 'Paid';
												}else{
									?>
										<form style="margin: 0;" onsubmit="return false;">
											<input type="hidden" name="txnname" id="txnname" value="<?php echo $result['txn_id']; ?>" />
											<select name="pay_status" id="pay_status" style="width: 86px;margin: 0;">
												<option value="Unpaid">Unpaid</option>
												<option value="Paid">Paid</option>
											</select>
											<input type="submit" name="submit" onclick="updatepaid(this)" class="icon-refresh" value="" style="width: 14px;border: none;" />
										</form>
									<?php
												}
											}
										}
									?>
								</td>
								<td class="row-style" style="border-width: 1px 1px 0 1px;">
									<?php
										if(($resultconfirm['received'] == 1) AND ($resultconfirm['delivery_status'] !='')){
											echo 'Close';
										}else{
											echo 'Open';
										}
									?>
								</td>								
								<td class="row-style" style="border-width: 1px 1px 0 1px;">&#8369; <?php echo number_format($subtotal, 2); ?></td>
							</tr>
				<?php
								}
							}
							
						}
							$if_yours = false;
							$if_me[] = false;
							$i++;
						}//end foreach
					}
					if(!in_array(true, $if_me)){
				?>
				<tr class="row-style">
					<td colspan="8" height="40"><p style="margin-top: 10px;text-align: center;">You have no orders.</p></td>
				</tr>
				<?php
				}
				?>				
				<tr>
					<td style="border:none;" height="40" colspan="7"></td>
					<td style="border:1px solid #c0bebf;background:#dee8f2;">Total: </td><td style="border:1px solid #c0bebf;background:#dee8f2;"><strong>&#8369; <?php echo number_format(array_sum($overall),2); ?></strong></td>
				</tr>
			</table>
		</div>
	<!-- Sold Items End -->
		<div class="tab-pane" id="tab2">
	<!-- Bought Items Start Here -->
		<table width="100%" cellspacing="0" cellpadding="0">
			<tr style="color: #fff;background: #9E9E9E;border:1px solid #c0bebf;">
				<td height="40" width="15%">Date Bought</td>
				<td width="20%">Transaction No.</td>
				<td width="20%">Item(s)</td>
				<td width="30%" colspan="3">Status</td>
				<td width="15%">Total Amount</td>
			</tr>
			<?php
				$ii = 1;
				$yours = array();
				$buyeruser = $this->session->userdata('uid');
				$this->db->where('uid', $buyeruser);
				$getUserInfo = $this->db->get('users');
				$getUserInfoResult = $getUserInfo->row_array();
				
				if($query->num_rows() > 0){
					foreach($query->result_array() as $resultBuyr){
						if(strlen($resultBuyr['txn_id']) == 17){
							$this->db->where('txn_id', $resultBuyr['txn_id']);
							$getcsinfo = $this->db->get('costumer');
							$getcsresut = $getcsinfo->row_array();
							
							$this->db->where('txn_id', $resultBuyr['txn_id']);
							$getconfirmBuyr = $this->db->get('confirm_orders');
							$resultconfirmBuyr = $getconfirmBuyr->row_array();
							//echo $resultconfirmBuyr['id'].'<br/>';
							if(($resultconfirmBuyr['costumers_email'] == $getUserInfoResult['email']) AND ($getcsresut['user_id'] != 'guest')){							
								
								if($resultconfirmBuyr['txn_id'] == $resultBuyr['txn_id']){
				?>
				<tr style="font-size: 11px;" class="<?php echo $ii % 2 == 0 ? 'row-subcolor' : ''; ?>">
					<td rowspan="2" class="row-style"><?php echo $resultconfirmBuyr['payopt'] == 'pay_email' ? $resultBuyr['payment_date'] : date('M d, Y',$resultBuyr['payment_date']) ; ?></td>
					<td rowspan="2" class="row-style"><?php echo $resultBuyr['txn_id']; ?></td>
					<td rowspan="2" class="row-style"><a class="btn btn-link" style="padding-top: 0;padding-bottom: 0;font-size: 11px;" href="#transmodal2" role="button" onclick="gettxn2(this)" alt='<?php echo $resultBuyr['txn_id']; ?>' data-toggle="modal">View</a></td>
					<td height="30" class="row-style row-subtitle">Shipped</td>
					<td class="row-style row-subtitle">Received</td>
					<td class="row-style row-subtitle">Upload Receipt</td>
					<td class="row-style" rowspan="2">P<?php echo number_format($resultBuyr['mc_gross'], 2); ?></td>
				</tr>	
				<tr style="font-size: 11px;" class="<?php echo $ii % 2 == 0 ? 'row-subcolor' : ''; ?>">
					<td height="50" class="row-style">		
						<?php echo isset($resultconfirmBuyr['delivery_status']) && $resultconfirmBuyr['delivery_status'] != '' ? $resultconfirmBuyr['delivery_status'] : 'No'; ?>
					</td>
					<td class="row-style">
						<form class="form-inline" id="frmb_<?php echo $resultBuyr['txn_id']; ?>" style="margin: 0;display: none;">
							<label class="radio">
								<input type="radio" name="opt" onclick="rechoice(this.value, '<?php echo $resultBuyr['txn_id']; ?>')" value="1" />Yes
							</label>
							<label class="radio">
								<input type="radio" name="opt" onclick="rechoice(this.value, '<?php echo $resultBuyr['txn_id']; ?>')" value="0" />No
							</label>		
						</form>	
						<?php
							if(isset($resultconfirmBuyr['delivery_status']) && $resultconfirmBuyr['delivery_status'] != ''){						
								echo isset($resultconfirmBuyr['received']) && $resultconfirmBuyr['received'] != 0 ? str_replace('1','Yes',$resultconfirmBuyr['received']) : '<span class="no-optb'.$resultBuyr['txn_id'].'" onclick="rehideno(this,\''.$resultBuyr['txn_id'].'\')">No</span>';
							}else{
								echo 'No';
							}
						?>	
					</td>
					<td class="row-style">
	<?php			
				$form_attrib = array('name' => 'form_receipt', 'id' => 'form_receipt', 'class' => 'fileupload_form form_receipt');
				echo form_open_multipart('', $form_attrib);
	?>		
					<input type="hidden" name="txn_id" value="<?php echo $resultBuyr['txn_id']; ?>" />
							<div class="control-group">
								<div class="controls">
									<div class="fileupload fileupload-new" data-provides="fileupload">
										<div class="fileupload-new thumbnail" style="max-width: 100px; max-height: 100px;position:relative;" >
											<img src='<?php echo $resultconfirmBuyr['receiptfile'] ? base_url().'uploads/'.$buyeruser.'/'.$resultconfirmBuyr['receiptfile'] : 'http://www.placehold.it/100x100/EFEFEF/AAAAAA&text=no+image' ?>' />									
										</div>
										<div id="receiptfile-preview" style="max-width: 100px; max-height: 100px;" class="fileupload-preview fileupload-exists thumbnail">
										</div>										
										<div>
											<span class="btn btn-file fileinput-button">
												<span class="fileupload-new">Select image</span>
												<span class="fileupload-exists">Change</span>
												<input type="file" name="receiptfile" id="receiptfile" accept="image/*">
											</span>
											<a type="button" class="btn fileupload-exists" data-dismiss="fileupload" style="float:left; margin-right: 4px">Remove</a>
										</div>
									</div>
								</div>
							</div>
							<div class="control-group">
								<div class="controls">
									<button type="submit" class="btn update">Upload</button>
								</div>
							</div>
						</form>
					</td>
				</tr>	
				<?php
									$yours[] = true;
									$ii++;
								}
							}
						}
					}
					if(!in_array(true, $yours)){
						echo '<tr>
							<td colspan="5" align="center">You have no item.</td>
						</tr>';
					}
				}else{
			?>
			<tr>
				<td colspan="5" align="center">You have no item.</td>
			</tr>
			<?php } ?>
		</table>
	<!-- Bought Items Ends Here -->
		</div>
		<div class="tab-pane" id="tab3">
	<!-- History Start  -->
			<table width="100%" cellspacing="0" cellpadding="0">
				<tr style="color: #fff;background: #9E9E9E;border:1px solid #c0bebf;">
					<td height="40" width="15%">Date</td>
					<td width="20%">Transaction No.</td>
					<td width="20%">Type</td>
					<td width="15%">Status</td>
					<td width="15%">Receipt</td>					
					<td width="15%">Total Amount</td>
				</tr>
			<?php
				$cc = 0;
				$pr_weight_h = array();
				$if_me_h = array();
				$allover = array();
				if($query->num_rows() > 0){
					foreach($query->result_array() as $resulthistory){
						$prd_aryh = rtrim($resulthistory['product_id_array'], ',');
						$prd_aryh   = explode(',',$prd_aryh);
						$buy = false;
						
						if(strlen($resulthistory['txn_id']) == 17){
						
							foreach($prd_aryh as $prd_info_history){
								$prd_id_h = substr($prd_info_history, 0, strrpos( $prd_info_history, '-' ));
								$this->db->where('id', $prd_id_h);
								$product_h = $this->db->get('products');
							
								if($product_h->num_rows() > 0){
									foreach($product_h->result_array() as $prduct_h){
										$web_id = $prduct_h['website_id'];
										$pr_weight_h[$resulthistory['id']][] = $prduct_h['prod_weight'];
										$this->db->where('id',$prduct_h['website_id']);
										$this->db->where('user_id',$this->session->userdata('uid'));
										$get_the_website = $this->db->get("websites");
										$if_yours_h = false;
										if($get_the_website->num_rows() > 0){
											$if_yours_h = true;
											$if_me_h[] = true;
										}
									}//end foreach
								}
							}//end foreach
							
							$this->db->where('txn_id', $resulthistory['txn_id']);
							$getcon = $this->db->get('confirm_orders');
							$resultcon = $getcon->row_array();
							
							$subtotal_h =  str_replace(',','',$resulthistory['mc_gross']);
														
							
							if(($if_yours_h) OR ($resultcon['costumers_email'] == $getUserInfoResult['email'])){					
								
								if($resultcon['costumers_email'] == $getUserInfoResult['email']){
									$buy = true;
								}
							
								if(($resultcon['received'] == 1) AND ($resultcon['delivery_status'] == 'Yes') AND ($resultcon['payment_status'] == 'Paid')){
									$allover[] = $subtotal_h;
			?>
						<tr style="font-size: 11px;" class="<?php echo $cc % 2 == 0 ? 'row-subcolor' : ''; ?>">
							<td><?php echo $resultcon['payopt'] == 'pay_email' ? $resulthistory['payment_date'] : date('M d, Y',$resulthistory['payment_date']) ; ?></td>
							<td><?php echo $resulthistory['txn_id']; ?></td>
							<td><?php echo $buy ? 'Bought Item(s)' : 'Sold Item(s)' ; ?></td>
							<td>Close</td>
							<td>Receipt</td>
							<td>&#8369; <?php echo number_format(array_sum($allover),2); ?></td>
						</tr>
			<?php	
									$cc++;
								}
							}	
						}
					}
				}
			?>
			</table>
	<!-- History End  -->
		</div>
	  </div>
	</div>

	 
	<!-- Modal -->
	<div id="transmodal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel" class="mode-title">Modal header</h3>
	  </div>
	  <div class="modal-body trans-body-status">
		<p>Please wait...</p>
	  </div>
	  <div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
		<button class="btn btn-primary save-change">Save changes</button>
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
	
	$('.form_receipt').ajaxForm({
		url: '<?php echo base_url().'test/uploadreceipt' ?>',
		type: 'post',
		success: function(data) {
			$('.upload-success').show();
		}
	});
	
	$('a.receipt_prev').popover({
		placement: 'top',
		trigger:'hover',
		html: true,
		content: function(e){
			var imageSrc = $(this).attr('alt');
			$(this).parent().find('.receipt_preview').html('<img src="'+imageSrc+'">');
			return $(this).parent().find('.receipt_preview').html();
		}
	});
});
	

	function updatepaid(x){
		var parentform = $(x).parents('form');		
		var txnvalue = parentform.find('#txnname').val();
		var pay_status = parentform.find('#pay_status').val();
		var datastr = 'pay_status='+pay_status+'&txnvalue='+txnvalue;
		
		$.ajax({
			type: 'post',
			url: '<?php echo base_url(); ?>test/updatepaid',
			data: datastr,
			success: function(html){
				window.location.reload();
			}
		});
	}
	$('.search-form-txn').on('submit', function(){
		var searchitem = $('.searchtxt').val();		
		if(searchitem.trim() != ''){
			$('.searchtxt').val('');
			window.location.href = '<?php echo base_url(); ?>multi/transactions?ftxn='+searchitem;
		}
	});
	
	function rechoice(choice, txn) {
		$.ajax({
			type: 'post',
			url: '<?php echo base_url(); ?>multi/updaterecord',
			data: 'value='+choice+'&txnid='+txn,
			success: function(html)
			{
				$('#frmb_'+txn).hide();
				$('.no-optb'+txn).show();
				//alert(html);
				if(choice == 1)
				{
					$('.no-optb'+txn).html('Yes');
				}
				else
				{
					$('.no-optb'+txn).html('No');
				}
			}
		});
	}
	function shipchoice(choice, txn) {
		//alert(choice);
		$.ajax({
			type: 'post',
			url: '<?php echo base_url(); ?>multi/save_ship',
			data: 'ship='+choice+'&txnid='+txn,
			success: function(html){
				$('#frm_'+txn).hide();
				$('.no-opt'+txn).show();
				if(choice == 1)
				{
					$('.no-opt'+txn).html('Yes');
				}
				else
				{
					$('.no-opt'+txn).html('No');
				}
				
			}
		});
		
	}
	function hideno(x, txn) {
		$(x).hide();
		$('#frm_'+txn).show();
	}
	function rehideno(x, txn) {
		$(x).hide();
		$('#frmb_'+txn).show();
	}
	
	function gettxn2(x)
	{
		var txnid = $(x).attr('alt');
		var url = '<?php echo base_url(); ?>multi/trans_info';
		var datastring = 'txnid='+txnid;
		/* */
		$.ajax({
			url: url,
			data: datastring,
			type: 'post',
			success: function(html) {
				$('.mode-infoboy').html(html);
			}
		});
		/* */
		// var ajax = ajaxObj(url);
		// ajax.onreadystatechange = function(){
			// if(ajaxReturn(ajax) == true) {
				// $('.mode-infoboy').html(ajax.responseText);
			// }
		// }
		// ajax.send(datastring);
		/* */
	}
	function gettxn(x)
	{
		var txn = $(x).attr('alt');
		$('.mode-title').html(txn);
		var datastring = 'txnid='+txn;
		$.ajax({
			type: 'post',
			url: '<?php echo base_url(); ?>multi/trans_status',
			data: datastring,
			success: function(html)
			{
				$('.trans-body-status').html(html);
			}
		});
	}
	$('.save-change').on('click',function(){
		var txn = $('.mode-title').html();
		var pay_value = $('.pay_status'+txn).val();
		var del_value = $('.del_status'+txn).val();
		var datas = 'del_status='+del_value+'&pay_status='+pay_value+'&txn='+txn;
		$.ajax({
			type: 'post',
			url: '<?php echo base_url(); ?>multi/save_order_status',
			data: datas,
			success: function(html)
			{
				$('#transmodal').modal('hide');
			}
		});
	});
	
	$('.xend-btn').click(function(){
		var data = '';
		$.ajax({
			type: 'post',
			url: '<?php echo base_url(); ?>multi/xendcreate',
			data: data,
			success: function(html)
			{
				//alert(html);
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