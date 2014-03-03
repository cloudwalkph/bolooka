<?php
	/* Get Cart Infos */
	$thecart = $this->cart->contents();
	
	/* Get User From Website */
	$this->db->where('id', $wid);
	$ckquery = $this->db->get('websites');
	$webuser = $ckquery->row_array();	
	
	/* get pages type */
	$this->db->where('website_id', $wid);
	$this->db->where('type', 'catalogue');
	$pagesQuery = $this->db->get('pages');
	$pagesRow = $pagesQuery->row_array();
	
	/* Get User Info */
	$this->db->where('uid', $webuser['user_id']);
	$userquery = $this->db->get('users');
	$useresult = $userquery->row_array();

	$seller_email = $useresult['email'];
	
	/* Get Checkout Settings From Profile */
	$this->db->where('user_id', $webuser['user_id']);
	$ckquery = $this->db->get('checkout_settings');
	$cksettings = $ckquery->row_array();
	$chksettings = '';	
	
	/* get payment option  */
	$this->db->where('user_id',$webuser['user_id']);
	$pay_query = $this->db->get('user_payment_option');
	$pay_row = $pay_query->row_array();
	
	/* get bank details  */
	$this->db->where('user_id',$webuser['user_id']);
	$bank_query = $this->db->get('user_bank_details');
	
	/* get delivery method  */
	$this->db->where('user_id',$webuser['user_id']);
	$delivery_query = $this->db->get('user_delivery_method');
	
	
		
	if($this->session->userdata('uid')){
		$this->db->select('users.email, users.first_name, users.last_name, user_profile_info.address, user_profile_info.bday, user_profile_info.mobile_num, user_profile_info.city, user_profile_info.region');
		$this->db->from('users');
		$this->db->join('user_profile_info', 'user_profile_info.user_id = users.uid','left');
		$this->db->where('users.uid', $this->session->userdata('uid'));
		$loginquery = $this->db->get();
		$result = $loginquery->row_array();	
	}

	
	/* Background Color */
	$this->db->where('website_id', $wid);
	$queryDesc = $this->db->get('design');
	$bg = $queryDesc->row();
	
	$total_weight = 0;
	$cart_one = NULL;
	$guest = false;
	
	if($this->input->get('log') AND $this->input->get('log') == 'guest'){
		$guest = true;
	}
	
	if($log_in){
		if(!empty($thecart)){
		// $txnid = md5($this->input->ip_address().time().$wid);
		$txnid = time();
?>
<style type="text/css">
ul.also-like li .pcats{
	font-size: 11px;
	margin-bottom: 0;
}
ul.also-like li h5{
	margin-bottom: 0;
}
ul.also-like li img{
	width: 100px;
	margin-right: 10px;
	height: 84px;
}
ul.also-like li a, ul.feed-area li a{
	color:inherit;
}
ul.feed-area li{
	margin-bottom: 10px;
	padding: 10px;
	background: <?php echo $bg->boxcolor; ?>;
}
ul.also-like li{
	margin-bottom: 10px;
	min-height: 85px;
	padding: 10px;
	background: <?php echo $bg->boxcolor; ?>;
}
ul.also-like, ul.feed-area{
	list-style: none;
	margin-left: 0;
}
</style>
<div class="span12" style="margin-left:0;">
	<div class="row-fluid span8" style="background:<?php echo $bg->boxcolor; ?>;border-radius: 6px;padding: 10px;">
		<div class="row-fluid">
			<table class="table table-bordered" style="width:100%;text-align:center;background: <?php echo $bg->boxcolor; ?>;">
				<caption></caption>
			  <thead>
				<tr>
				  <th style="padding-top: 7px;padding-bottom: 7px;">Product Name</th>
				  <th>Quantity</th>
				  <th>Unit Price</th>
				  <th>Amount</th>
				</tr>
			  </thead>
			  <tbody>
			<?php
			foreach($this->cart->contents() as $items){
				if($this->cart->total_items() == 1){
					$cart_one = $items['id'];
				}
			?>
				<tr style="background: <?php echo $bg->boxcolor; ?>;">					  
				  <td style="padding-top: 5px;padding-bottom: 5px;" class="ship-area-here"><?php echo $items['name']; ?></td>
				  <td><?php echo $items['qty']; ?></td>
				  <td style="text-align: right;">Php <?php echo $this->cart->format_number($items['price']); ?></td>
				  <td style="text-align: right;">Php <?php echo $this->cart->format_number($items['subtotal']); ?></td>
				</tr>
			<?php
				}					
			?>
			  </tbody>
			  <tfoot>
				<tr style="background: <?php echo $bg->boxcolor; ?>;">
					<td colspan="3">Total: </td>
					<td style="text-align: right;">Php <?php echo $this->cart->format_number($this->cart->total()); ?></td>
				</tr>
			  </tfoot>
			</table>
		</div>
		<div class="row-fluid">
			<div class="accordion" id="ck-accordion">
				<div class="accordion-group">
					<div id="stepone" class="accordion-body collapse in">
						<div class="accordion-inner">
							<h4 class="pull-right" style="font-family: Segoe UI Semibold;" id="step-info">Step 1 of 2</h4>

							<legend style="font-family: Segoe UI Semibold; font-size: 18px;color:inherit;margin-top: 15px;">Billing Address: </legend>
							<form class="form-horizontal checkout-form" onsubmit="return false;">
								<input type="hidden" id="guest" name="guest" value="<?php echo $guest ? 1 : $this->session->userdata('uid'); ?>" />						
								<input type="hidden" id="receiver_email" name="receiver_email" value="<?php echo $seller_email; ?>" />						
								<input type="hidden" id="receiver_uid" name="receiver_uid" value="<?php echo $webuser['user_id']; ?>" />						
								<input type="hidden" id="txn_uid" name="txn_uid" value="<?php echo $txnid; ?>" />
								<input type="hidden" id="site_id" name="site_id" value="<?php echo $wid; ?>" />
								<div class="control-group">		
									<label class="control-label" for="fname"></label>
									<div class="controls">		
										<i class="icon-asterisk icon-white"></i> Please fill out all fields.
									</div>
								</div>
								<div class="control-group fname_content">		
									<label class="control-label" for="fname">First Name:</label>
									<div class="controls">		
										<input type="text" class="span8" id="fname" name="fname" placeholder="First Name" required <?php echo $result['first_name'] ? 'READONLY value="'.$result['first_name'].'"' : ''; ?> /> <i class="icon-asterisk icon-white"></i>						
									</div>
								</div>
								<div class="control-group lname_content">		
									<label class="control-label" for="lname">Last Name:</label>
									<div class="controls">		
										<input type="text" class="span8" id="lname" name="lname" placeholder="Last Name" required <?php echo $result['last_name'] ? 'READONLY value="'.$result['last_name'].'"' : ''; ?> /> <i class="icon-asterisk icon-white"></i>
									</div>
								</div>
								<div class="control-group">		
									<label class="control-label" for="email-c">Email:</label>
									<div class="controls">		
										<input type="email" class="span8" id="email-c" name="email-c" placeholder="Email" required <?php echo $result['email'] ? 'READONLY value="'.$result['email'].'"' : ''; ?> /> <i class="icon-asterisk icon-white"></i>
										<div>
											<span id="email_valid" class="help-block" style="display:none;color:inherit;font-style:italic;">Email already exist (please log in as user)</span>
										</div>
									</div>
								</div>
								<div class="control-group">		
									<label class="control-label" for="bdayc">Birthday:</label>
									<div class="controls">		
										<input type="text" class="span8" id="<?php echo isset($result['bday']) ? '' : 'bdayc'; ?>" name="bdayc" placeholder="MM DD, YYYY" required <?php echo isset($result['bday']) ? 'READONLY value="'.date('M d, Y',$result['bday']).'"' : ''; ?> /> <i class="icon-asterisk icon-white"></i>
									</div>
								</div>		
								<div class="control-group add_content">		
									<label class="control-label" for="addr">Address:</label>
									<div class="controls">		
										<textarea id="addr" class="span8" name="addr" placeholder="Address" style="min-height: 86px;" required <?php echo $result['address'] ? 'READONLY' : ''; ?>><?php echo isset($result['address']) ? $result['address'] : ''; ?></textarea> <i class="icon-asterisk icon-white"></i>
									</div>
								</div>		
								<div class="control-group city_content">		
									<label class="control-label" for="city">City:</label>
									<div class="controls">		
										<input type="text" class="span8" id="city" name="city" placeholder="City" <?php echo $result['city'] ? 'READONLY value="'.$result['city'].'"' : ''; ?> />
									</div>
								</div>
								<div class="control-group state_content">		
									<label class="control-label" for="state">State/Province:</label>
									<div class="controls">		
										<input type="text" class="span8" id="state" name="state" placeholder="State/Province"
										<?php
											if($this->session->userdata('uid')){
												if($result['region'] != 0){
													$this->db->where('id', $result['region']);
													$queryregion = $this->db->get('regions');
													$resultregion = $queryregion->row_array();
													
													echo 'READONLY value="'.$resultregion['region'].'"';
												}
											}
										?>
										/>
									</div>
								</div>
								<div class="control-group country_content">		
									<label class="control-label" for="country">Country:</label>
									<div class="controls">		
										<input type="text" class="span8" id="country" name="country" placeholder="Country" required /> <i class="icon-asterisk icon-white"></i>
									</div>
								</div>
								<div class="control-group postal_content">		
									<label class="control-label" for="pzcode">Postal/Zip Code:</label>
									<div class="controls">		
										<input type="number" class="span8" id="pzcode" name="pzcode" placeholder="Postal/Zip Code" />
									</div>
								</div>
								<div class="control-group phone_content">		
									<label class="control-label" for="phone">Contact Number:</label>
									<div class="controls">		
										<input type="text" class="span8" id="phone" name="phone" placeholder="000-00-00" required <?php echo $result['mobile_num'] ? 'READONLY value="'.$result['mobile_num'].'"' : ''; ?> /> <i class="icon-asterisk icon-white"></i>
									</div>
								</div>		
								<div class="control-group">		
									<label class="control-label" style="padding-top:0;">
										<input type="checkbox" name="del_details" id="del_details" style="margin-top: 0;<?php echo $guest == 1 ? 'display: none;' : ''; ?>" checked="checked" />
									</label>
									<div class="controls">		
										<p style="font-size: 12px;">Ship items to the above billing address.</p>
									</div>
								</div>
								<!-- The below input fields are for shipping details -->
								
								<div class="shipfields" style="display: none;">
								<legend style="font-family: Segoe UI Semibold; font-size: 18px;color:inherit;margin-top: 15px;">Shipping Details:</legend>
									<div class="control-group">		
										<label class="control-label" for="sfname">First Name:</label>
										<div class="controls">		
											<input type="text" class="span8" id="sfname" name="sfname" placeholder="First Name">
										</div>
									</div>
									<div class="control-group">		
										<label class="control-label" for="slname">Last Name:</label>
										<div class="controls">		
											<input type="text" class="span8" id="slname" name="slname" placeholder="Last Name">	
										</div>
									</div>	
									<div class="control-group">		
										<label class="control-label" for="saddr">Address:</label>
										<div class="controls">		
											<textarea id="saddr" class="span8" name="saddr" placeholder="Address" style="min-height: 86px;"></textarea>
										</div>
									</div>		
									<div class="control-group">		
										<label class="control-label" for="scity">City:</label>
										<div class="controls">		
											<input type="text" class="span8" id="scity" name="scity" placeholder="City">	
										</div>
									</div>	
									<div class="control-group">		
										<label class="control-label" for="sstate">State/Province:</label>
										<div class="controls">		
											<input type="text" class="span8" id="sstate" name="sstate" placeholder="State/Province">
										</div>
									</div>
									<div class="control-group">		
										<label class="control-label" for="scountry">Country:</label>
										<div class="controls">		
											<input type="text" class="span8" id="scountry" name="scountry" placeholder="Country">	
										</div>
									</div>
									<div class="control-group">		
										<label class="control-label" for="spzcode">Postal/Zip Code:</label>
										<div class="controls">		
											<input type="text" class="span8" id="spzcode" name="spzcode" placeholder="Postal/Zip Code">	
										</div>
									</div>
									<div class="control-group">		
										<label class="control-label" for="sphone">Phone:</label>
										<div class="controls">		
											<input type="text" class="span8" id="sphone" name="sphone" placeholder="Phone">	
										</div>
									</div>	
								</div>
									<div class="control-group">
										<div class="controls">		
											<button type="submit" class="btn btn-warning pull-right" id="step1cont">Continue</button>								
										</div>
									</div>	
							</form>
						</div>
					</div>
				</div>
				<div class="accordion-group">
					<div id="steptwo" class="accordion-body collapse">
						<div class="accordion-inner">
							<h4 class="pull-right" style="font-family: Segoe UI Semibold;" id="step-info">Step 2 of 2</h4>
							<?php
							if(($pay_query->num_rows() > 0 || $bank_query->num_rows() > 0) && $delivery_query->num_rows() > 0)
							{
								
							?>
								<form class="form-horizontal checkout_payment" onsubmit="return false;">
								<legend style="font-family: Segoe UI Semibold; font-size: 18px; color: inherit;">Payment Options</legend>
								<span id="no_payment_options" class="help-block" style="display:none;color:inherit;font-style:italic;">Please choose your Payment Option.</span>
							<?php
								foreach($bank_query->result_array() as $row_bank)
								{
							?>	
									<div class="control-group" style="margin-bottom: 0;">
										<label class="control-label" style="padding-top: 0;">
											<input type="radio" name="payment_options" value="<?php echo $row_bank['bank_name']; ?>" style="margin-top: 0;" />
										</label>							
										<div class="controls">
											<?php echo strtoupper($row_bank['bank_name']); ?>
										</div>				
									</div>
							<?php
								}
							?>
							<?php
								if(isset($pay_row['paypal_email']) && $pay_row['paypal_email'] != '')
								{
							?>
									<div class="control-group" style="margin-bottom: 0;">
										<label class="control-label" style="padding-top: 0;">
											<input type="radio" name="payment_options" value="paypal" style="margin-top: 0;" />
										</label>							
										<div class="controls">
											<?php echo $pay_row['paypal_email']; ?>
										</div>				
									</div>
							<?php
								}
								if(isset($pay_row['gcash']))
								{
							?>
							
									<div class="control-group" style="margin-bottom: 0;">
										<label class="control-label" style="padding-top: 0;">
											<input type="radio" name="payment_options" value="gcash" style="margin-top: 0;" />
										</label>							
										<div class="controls">
											Gcash
										</div>				
									</div>
							<?php
								}
								if(isset($pay_row['smart_money']))
								{
							?>
									<div class="control-group" style="margin-bottom: 0;">
										<label class="control-label" style="padding-top: 0;">
											<input type="radio" name="payment_options" value="smart_money" style="margin-top: 0;" />
										</label>							
										<div class="controls">
											Smart Money
										</div>				
									</div>	
							<?php
								}
							?>
								<legend style="font-family: Segoe UI Semibold; font-size: 18px; color: inherit;">Delivery Method</legend>
								<span id="no_delivery_method" class="help-block" style="display:none;color:inherit;font-style:italic;">Please choose your Delivery Method.</span>
							<?php
								foreach($delivery_query->result_array() as $del_row)
								{
							?>
									<div class="control-group" style="margin-bottom: 0;">
										<label class="control-label" style="padding-top: 0;">
											<input type="radio" name="delivery_method" value="<?php echo $del_row['name']; ?>" style="margin-top: 0;" />
										</label>							
										<div class="controls">
											<?php echo ucwords($del_row['name']); ?>
											<?php echo $del_row['price'] != 0 ? ' - '.$del_row['price'].' Php' : ''; ?>
										</div>
									</div>
							<?php
								}
							?>						
								<div class="control-group">
									<div class="controls">		
										<button type="submit" class="btn btn-warning pull-right" id="step2cont">Complete my purchase</button>								
									</div>
								</div>								
								</form>
							<?php
							} else {
								$complete_purchase_attrib = array(
									'class' => 'form-horizontal',
									'onsubmit' => 'return false'
								);
								echo form_open(base_url('multi/contact_seller'), $complete_purchase_attrib);
							?>
									<legend style="font-family: Segoe UI Semibold; font-size: 18px; color: inherit;">Contact the seller for payment details.</legend>
									<div class="control-group">
										<div class="controls">											
											<button type="submit" class="btn btn-warning" id="contsell">Complete Purchase</button>
										</div>
									</div>
							<?php
								echo form_close();
							}
							?>
						</div><!-- End of Accordion Inner step2 -->
					</div>
				</div>
			</div>			
		</div>
	</div>
		<!-- Start sidebar -->
	<div class="row-fluid span4" style="background:<?php echo $bg->boxcolor; ?>;border-radius: 6px;padding: 10px;">
		<div class="container-fluid" style="margin-bottom: 15px;background: <?php echo $bg->boxcolor; ?>;">	
			<h4>Need Help? <span>Email Us</span></h4>
			<h5><?php echo $seller_email; ?></h5>
		</div>
		<div class="row-fluid box-part">
			<h5>You may also like</h5>
			<ul class="also-like">
		<?php
			$this->db->where('website_id', $wid);
			$this->db->where('published', 1);
			// $this->db->order_by('id', 'desc');
			$this->db->limit(3);
			$query_prod = $this->db->get('products');
			$resultlike = $query_prod->result_array();
			
			$noprimary = 'http://www.placehold.it/150x150/333333/ffffff&text=no+image';
			if($resultlike){
				foreach($resultlike as $rowlike){	
					$this->db->where('id', $rowlike['page_id']);
					$page_query = $this->db->get('pages');
					$row_page = $page_query->row_array();
					
					if($this->db->field_exists('product_cover', 'products')) {
						$cover = $rowlike['product_cover'];
					} else {
						$cover = $rowlike['primary'];
					}
		?>
				<li>
					<img class="pull-left" src="<?php echo base_url('uploads/' . $webuser['user_id'] . '/' . $wid . '/' . $rowlike['page_id'] . '/' . $rowlike['id'] . '/' .$cover); ?>" onerror="this.src='<?php echo $noprimary; ?>'"/>
					<div class="">
						<a href="<?php echo base_url().$url.'/'.$row_page['url'].'/'.url_title($rowlike['name'], '-', TRUE).'/'.$rowlike['id']; ?>">
						<div style="font-size: 0.83em;"><?php echo $rowlike['name']; ?></div>
						</a>
						<p class="pcats"><?php echo $rowlike['category']; ?></p>
						<?php if($rowlike['price'] > 0){ ?>
						<p>Php <?php echo number_format($rowlike['price'], 2); ?></p>		
						<?php } ?>							
					</div>	
				</li>		
		<?php
				}
			}
		?>
			</ul>
		</div>	
	</div>
		<!-- End sidebar -->
</div>
<?php
	// for ($num = 1; $num <= 4; $num++){							
?>
<form id="paypalform" action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_cart">
<input type="hidden" name="upload" value="1">
<input type="hidden" name="business" value="<?php echo isset($pay_row['paypal_email']) ? $pay_row['paypal_email'] : '' ?>">
<?php
	$product_id_array = '';	
	$i = 0;	
	foreach($this->cart->contents() as $items)
	{
		$product_id = $items['id'];
		$product_id_array .= $items['id'].'-'.$items['qty'].',';
		$x = $i + 1;
?>
<input type="hidden" name="item_name_<?php echo $x; ?>" value="<?php echo $items['name']; ?>">
<input type="hidden" name="amount_<?php echo $x; ?>" value="<?php echo $this->cart->format_number($items['price']); ?>">
<input type="hidden" name="quantity_<?php echo $x; ?>" value="<?php echo $items['qty']; ?>">
<?php	
		$i++;
	}
?>
<input type="hidden" name="item_name_<?php echo $x + 1; ?>" value="shipping rate">
<input type="hidden" name="amount_<?php echo $x + 1; ?>" class="shipping_amount" value="">
<input type="hidden" name="quantity_<?php echo $x + 1; ?>" value="1">

<input type="hidden" name="custom" value="<?php echo $txnid; ?>">
<input type="hidden" name="notify_url" value="<?php echo base_url().'multi/paypal_ipn'; ?>">
<input type="hidden" name="return" id="paypal_return2" value="<?php echo base_url().'cart?t=success&s='.$web_url; ?>">
<input type="hidden" name="rm" value="2">
<input type="hidden" name="cbt" value="Return to The Store">
<input type="hidden" name="cancel_return" value="<?php echo base_url().$web_url.'/'.$pagesRow['name']; ?>">
<input type="hidden" name="lc" value="PH">
<input type="hidden" name="currency_code" value="PHP">
</form>
<?php
	// } 
?>
<?php
		}else{
?>
<div class="span12" style="background:<?php echo $bg->boxcolor; ?>;border-radius: 6px;padding: 10px;">
	<div class="row-fluid">
		<h5>Your Shopping Cart is Empty!</h5>
	</div>
</div>
<?php
		}
	}else{
?>
<div class="span12" style="background:<?php echo $bg->boxcolor; ?>;border-radius: 6px;padding: 10px;">
	<div class="row-fluid span8">
	<legend style="font-family: Segoe UI Semibold; font-size: 18px; color: inherit;">Costumer Login</legend>
<?php
	$signin_form_attrib = array(
		'id' => 'sign_buyer',
		'name' => 'gsigh_in',
		'class' => 'form-horizontal'
	);
	echo form_open(base_url('signin'), $signin_form_attrib);
?>	
		<input type="hidden" name="redirect_url" value="<?php echo $this->uri->uri_string(); ?>">
		<div class="control-group">
			<label class="control-label" for="inputEmail" style="font-family: 'Segoe UI';">Email</label>
			<div class="controls">
				<input type="text" id="email" name="email" class="span8" placeholder="Email">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="inputPassword" style="font-family: 'Segoe UI';">Password</label>
			<div class="controls">
				<input type="password" id="password" name="password" class="span8" placeholder="Password">
			</div>
		</div>
		<div class="control-group">
			<div class="controls">
				<button type="submit" class="btn btn-warning">Sign in</button>
			</div>
		</div>
<?php
	echo form_close();
?>
	</div>
	<div class="row-fluid span4">
		<legend style="font-family: Segoe UI Semibold; font-size: 18px; color: inherit;">Sign up</legend>
		<div class="control-group">
			<div class="controls">
				<a class="btn btn-warning" data-toggle="collapse" data-parent="#signtop" href="#collapseThree">Continue Sign up</a>
				<?php echo $log_in; ?>
			</div>
		</div>
	</div>
</div>
<?php
	}
?>
<div id="puchase_comp" class="modal hide fade" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="background: none repeat scroll 0 0 rgba(255, 255, 255, 0.8);font-family: Segoe UI;border-radius: 0px;">
	<div class="modal-header" style="background: none repeat scroll 0 0 #F26A2C;border-bottom: medium none;color: white;">		
		<h3 id="myModalLabel" style="font-weight: normal;">Processing Order</h3>
	</div>
	<div class="modal-body" style="text-align: center;">
		<h4 id="please_wait">Please wait!</h4>
		<div class="row-fluid show-details" style="display:none;">
			<!--<h6>See details below to process your payments!</h6>-->
			<h6 style="color:#000;">Thank you</h6>
			<h6 style="color:#000;">
				Please check your email to process your payments and also check your transaction from bolooka under of Menu go to <a href="<?php echo base_url('multi/transactions')?>">ORDERS</a>
			</h6>
			<h6 style="color:#000;">Enjoy shopping from bolooka!</h6>
			<!--<form class="form-horizontal">
				<ul id="list-payments" style="margin:0;list-style:none;">
				</ul>
			</form>-->
			<button class="btn btn_color" data-dismiss="modal" aria-hidden="true">Close</button>
		</div>
		<div class="row-fluid" id="inform_buyer" style="display:none;">
			<!--<h6>Your order has been successfully processed!</h6>-->
			<h6>You may also check your email to view your order!</h6>
			<h6>Please direct any questions you have to the <a target="_blank" href="javascript:(void)">store owner</a>.</h6>

			<h6>Thanks for shopping with us online!</h6>
		</div>
	</div>
	<div class="modal-footer" style="background: none repeat scroll 0 0 rgba(255, 255, 255, 0);border: medium none;box-shadow: none;">
		<a class="btn btn-style conshop" style="display:none;" href="<?php echo isset($_GET['s']) ? base_url().$_GET['s'] : ''; ?>">Continue Shopping</a>
	</div>
</div>
<div id="myModal_validation_error" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-body" style="background-color: #e34e0d;color: #fff;">
		<p id="error_sign_up" style="font-family: 'Segoe UI Semibold';"></p>
		<div class="pull-right">
			<button class="btn btn_color" data-dismiss="modal" aria-hidden="true">Close</button>
		</div>
	</div>
</div>
<!--<script id="banktemplate" type="text/x-tmpl">
	<li style="border-bottom: 1px solid;background: rgba(20, 20, 20, .1);padding-top: 10px;">
		<div class="control-group" style="margin-bottom:0;">
			<label class="control-label" style="padding-top:0;font-size: 16px;">Bank Name: </label>
			<div class="controls" style="font-size: 16px;text-align: left;">
				${bankname}
			</div>
		</div>
		<div class="control-group" style="margin-bottom:0;">
			<label class="control-label" style="padding-top:0;font-size: 16px;">Account Name: </label>
			<div class="controls" style="font-size: 16px;text-align: left;">
				${actname}
			</div>
		</div>
		<div class="control-group" style="margin-bottom:0;">
			<label class="control-label" style="padding-top:0;font-size: 16px;">Account Number: </label>
			<div class="controls" style="font-size: 16px;text-align: left;">
				${actnum}
			</div>
		</div>
	</li>
</script>
<script id="gstemplate" type="text/x-tmpl">
	<li style="border-bottom: 1px solid;background: rgba(20, 20, 20, .1);padding-top: 10px;">
		<div class="control-group" style="margin-bottom:0;">
			<label class="control-label" style="padding-top:0;font-size: 16px;">${ptype} </label>
			<div class="controls" style="font-size: 16px;text-align: left;">
				${pnumber}
			</div>
		</div>
	</li>
</script>-->
<script type="text/javascript">
$(function(){
	/* log-in submit */
		$('#sign_buyer')
			.ajaxForm({
				// url: '<?php echo base_url('signin'); ?>',
				beforeSubmit: function(formData, jqForm, options) {
					var form = jqForm[0];
					if (!form.email.value || !form.password.value) { 
						return false; 
					}
				},
				success: function(html) {
					// data = JSON.parse(html);
					data = eval('(' + html + ')');
					if(data.code == -1) {
						$('#myModal_validation_error').modal('show');
						$('#error_sign_up').html('Email account not found.');
						return false;
					} else if(data.code == -2) {
						$('#myModal_validation_error').modal('show');
						$('#error_sign_up').html('Email/Password Incorrect.');
						return false;
					} else if(data.code == -3) {
						$('#myModal_validation_error').modal('show');
						$('#error_sign_up').html(
							'Please verify your account. Check your inbox or spam/junk mail. <br>'+
							'<a style="color: #FFFFFF; font-weight: bolder;" href="<?php echo base_url().'signup/verification_resend?email='; ?>'+data.email+'">Click here</a> to resend your verification email.'
						);
						return false;
					} else {
						// if(data.code == undefined) {
							// window.location = "<?php echo base_url(); ?>dashboard";
						// } else {
							window.location.reload(true);
						// }
					}
				}
			});
	/** **/
});
	// $('.cont-guest').on('click',function(){
		// window.location.href = '<?php echo base_url().'cart?t=checkout&s='.$url.'&log=guest'; ?>';
	// });
	
	$('#del_details').on('click', function(){		
		var checked = $(this).is(':checked');
		
		if(checked){
			$('.shipfields').hide();
			$('.fname_content').show().find('input').prop('required', true);		
			$('.lname_content').show().find('input').prop('required', true);		
			$('.add_content').show().find('textarea').prop('required', true);			
			$('.city_content').show().find('input').prop('required', true);			
			$('.state_content').show().find('input').prop('required', true);			
			$('.country_content').show().find('input').prop('required', true);			
			$('.postal_content').show().find('input').prop('required', true);			
			$('.phone_content').show().find('input').prop('required', true);			
		}else{
			$('.shipfields').show();			
			$('.fname_content').hide().find('input').removeAttr('required');			
			$('.lname_content').hide().find('input').removeAttr('required');			
			$('.add_content').hide().find('textarea').removeAttr('required');			
			$('.city_content').hide().find('input').removeAttr('required');			
			$('.state_content').hide().find('input').removeAttr('required');			
			$('.country_content').hide().find('input').removeAttr('required');			
			$('.postal_content').hide().find('input').removeAttr('required');			
			$('.phone_content').hide().find('input').removeAttr('required');			
		}
		
		$('.shipfields input[type=text],.shipfields textarea').each(function() {
            $(this).prop('required', !checked);
        });
	});
	
	$('.checkout-form').submit(function(){
		var guest = $('#guest').val();

		if(guest == 1)
		{
			var answer = true;
			var email = $('#email-c').val().trim();
			var dataString = 'email='+email;
			$.ajax({
				type: 'post',
				url: '<?php echo base_url(); ?>multi/checkexistingemail',
				data: dataString,
				success: function(html){
					if(html == 'exist')
					{
						$('#email_valid').show();
						answer = false;
					}
				}
			});	
			if(answer)
			{
				$("#stepone").collapse('hide');
				$("#steptwo").collapse('show');
				$("#step-info").html('Step 2 of 2');
			}
		}else
		{
			var shipping_details = $('#del_details').attr('checked');		
			var datas = $('.checkout-form').serialize();
			$("#stepone").collapse('hide');
			$("#steptwo").collapse('show');
			$("#step-info").html('Step 2 of 2');
		}
	});
	
	$( "#bdayc" ).datepicker({
		// defaultDate: "+1w",
		changeMonth: true,
		changeYear: true,
		yearRange: "1900:2013",
		dateFormat: "M d, yy"
	});
	$('#contsell').on('click',function(){
		var billing_data = $('.checkout-form').serialize();
		
		$.ajax({
			beforeSend: function() {
				$('#contsell').attr('disabled','disabled');
				$('#puchase_comp').modal('show');
			},
			type: 'post',
			url: '<?php echo base_url(); ?>multi/contact_seller',
			data: billing_data,
			success: function(html){
				$('#please_wait').hide();
				$('.conshop, #inform_buyer').show();
			}
		});
	});
	
	$('#puchase_comp').on('hidden', function () {
		window.location.href = '<?php echo base_url('cart?t=yourcart&s='.$web_url) ?>';
	});
	
	$('#step2cont').on('click',function(){
		var payment_data = $('.checkout_payment').serialize();
		var billing_data = $('.checkout-form').serialize();
		var datastr = payment_data + '&' + billing_data;
		var delivery_method = $('input[name="delivery_method"]:checked').val();
		var payment_options = $('input[name="payment_options"]:checked').val();
		$('#no_delivery_method').hide();
		$('#no_payment_options').hide();
		
		if((payment_options != undefined) && (delivery_method != undefined)){
			$('#step2cont').attr('disabled','disabled');	
			$('#puchase_comp').modal('show');
			// $('#paypalform').submit();return false;
			$.ajax({
				type: 'post',
				url: '<?php echo base_url(); ?>multi/complete_purchases',
				data: datastr,
				success: function(data){
					var obj = JSON.parse(data);
					
					if(obj.type == 'paypal')
					{
						$('.shipping_amount').val(obj.shipping);
						$('#paypalform').submit();
					}else
					{
						$('#please_wait').hide();
						$('.show-details').show();
					}
					
					/* var obj = JSON.parse(data);
					var value = '';
					var gstype = false;
					var paypal = false;
					$.each(obj, function(key, val) {						
						if(key == 'error'){
							$.each(val, function(key2, val2) {
								if(val2 == 'no_payment_options'){
									$('#no_payment_options').show();
								}
								if(val2 == 'no_delivery_method'){
									$('#no_delivery_method').show();
								}
							});
							$('#step2cont').removeAttr('disabled');	
							return false;
						}else if(key == 'bank'){
							$.each(val, function(key3, val3) {
								$("#banktemplate").tmpl(val3).appendTo( "#list-payments" );
							});
						}else if(key == 'pnumber'){
							gstype = true;
						}else if(key == 'paypal'){
							paypal = true;
						}			
					});	
					
					if(gstype == true){
						$("#gstemplate").tmpl(obj).appendTo( "#list-payments" );
					}
					if(paypal == true){
						$('#paypalform1').submit();
					}else{
						$('#please_wait').hide();
						$('.conshop, #inform_buyer, .show-details').show();
					}					 */	
				}
			});
		}else{
			if(payment_options == undefined){
				$('#no_payment_options').show();
			}
			if(delivery_method == undefined){
				$('#no_delivery_method').show();
			}
		}				
	});
</script>