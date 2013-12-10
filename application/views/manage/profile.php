<?php
	if($queryuser->num_rows() > 0) {
		$user = $queryuser->row_array();
		
		$profilePic = 'http://www.placehold.it/164x164/333333/ffffff&text=no+photo';
		if($user['profile_picture'] != null) {
			$profilePic = $user['profile_picture'];
			$profilePic = str_replace(" ", "_", $profilePic);
			$checkPic = 'uploads/'.$user['uid'].'/medium/'.$profilePic;
			
			if($this->photo_model->image_exists($checkPic)) {
				$profilePic = base_url().$checkPic;
			} else {
				$checkPic = 'uploads/'.$user['uid'].'/'.$profilePic;
				if($this->photo_model->image_exists($checkPic)) {
					$profilePic = base_url().$checkPic;
				} else {
					$checkPic = 'uploads/'.$profilePic;
					if($this->photo_model->image_exists($checkPic)) {
						$profilePic = base_url().$checkPic;
					} else {
						$profilePic = 'http://www.placehold.it/164x164/333333/ffffff&text=image+not+found';
					}
				}
			}
		}
		
		$pub_blog = $user['publish_blog'];
		$pub_gal = $user['publish_gallery'];
		
		/* query user info */
		$this->db->where('user_id', $user['uid']);
		$info_query = $this->db->get('user_profile_info');
		if($info_query->num_rows() > 0) {
			$row_info = $info_query->row_array();
		} else {
			$insert_info = array(
				'user_id' => $user['uid']
			);
			$this->db->insert('user_profile_info', $insert_info);
			redirect($this->uri->uri_string());
		}
		
		if(isset($row_info['region']))
		{
			/* query for regions */
			$this->db->where('id',$row_info['region']);
			$region_query = $this->db->get('regions');
			$region_row = $region_query->row_array();
		}


?>

<!--for datepicker css-->
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css" />
<!--for datepicker css-->

<style type="text/css">
.remove_bank_account {
	display:none;
}
.bank_face:hover .remove_bank_account{
	display:block;
}
.bank_face:hover{
	background: none repeat scroll 0 0 rgba(218, 218, 218, 0.5);
}
.bank_face .control-group:last-child {
	border-bottom: 1px solid #C6C6C6;
}
.bank_face .controls:last-child {
	padding-bottom: 5px;
}

/******remove
.bnk-details li ul li, .bnk-details li ul li.save-bank, .bnk-details li ul li.cancel-bank{
	display:none;
}
.bnk-details li ul{
	margin: 0;
	list-style: none;
	/* position: absolute;
    right: 0; */
}
.bnk-details li{
	position:relative;	
}
.bnk-details li:hover{
	background: none repeat scroll 0 0 rgba(218, 218, 218, 0.5);
	border-bottom: 1px solid #C6C6C6;
}
.bnk-details li:hover ul li a{
	text-decoration:none;
}
.bnk-details li:hover ul li{
	display:inline-block;
}
*****/
/* for profile pic delete */
.prof_image_container {
	position: relative;
}
.fileupload img.del_prof_pic {
    cursor: pointer;
    display: none;
    position: absolute;
	right: -16px;
	top: -16px;
	z-index: 1;
}
.fileupload.fileupload-new:hover img.del_prof_pic {
	display: block;
}

/* for datepicker */
#ui-datepicker-div {
	margin-top: 5px;
}

.head {
	margin-bottom: 20px;
}
.form-horizontal .control-group {
    font-family: Segoe UI;
    font-size: 12px;
    margin-bottom: 10px;
}
.form-horizontal .control-label {
	font-size: 12px;
    font-family: Segoe UI Semibold;
}
.help-inline {
	font-family: Segoe UI;
}
input[type="text"] {
	font-size: 12px;
	font-family: Segoe UI;
}
/* CSS ON/OFF Switch */
.onoffswitch {
    position: relative; width: 90px;
    -webkit-user-select:none; -moz-user-select:none; -ms-user-select: none;
    float: left;
}

.onoffswitch .onoffswitch-checkbox {
    display: none;
}

.onoffswitch-label {
    display: block; overflow: hidden; cursor: pointer;
    border: 2px #ddd; border-radius: 20px;
    box-shadow: 1px 2px 3px 0 rgba(0, 0, 0, 0.3) inset;
	margin-bottom: 0;
}

.onoffswitch-inner {
    width: 200%; margin-left: -100%;
    -moz-transition: margin 0.3s ease-in 0s; -webkit-transition: margin 0.3s ease-in 0s;
    -o-transition: margin 0.3s ease-in 0s; transition: margin 0.3s ease-in 0s;
}

.onoffswitch-inner:before, .onoffswitch-inner:after {
    float: left; width: 50%; height: 30px; padding: 0; line-height: 30px;
    font-size: 18px; color: white; font-family: Trebuchet, Arial, sans-serif; font-weight: bold;
    -moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box;
}

.onoffswitch-inner:before {
    content: "ON";
    padding-left: 10px;
    background-color: rgba(196,179,148,0.3); color: #ff7800;
}

.onoffswitch-inner:after {
    content: "OFF";
    padding-right: 10px;
    background-color: rgba(196,179,148,0.3); color: #9a8e76;
    text-align: right;
}

.onoffswitch-switch {
    width: 22px; margin: 4px;
    border: 2px solid #DFDFDF; border-radius: 20px;
    position: absolute; top: 0; bottom: 0; right: 56px;
    -moz-transition: all 0.3s ease-in 0s; -webkit-transition: all 0.3s ease-in 0s;
    -o-transition: all 0.3s ease-in 0s; transition: all 0.3s ease-in 0s;
	
background: #dfdfdf;
background: -moz-linear-gradient(top,  #dfdfdf 0%, #ffffff 100%);
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#dfdfdf), color-stop(100%,#ffffff));
background: -webkit-linear-gradient(top,  #dfdfdf 0%,#ffffff 100%);
background: -o-linear-gradient(top,  #dfdfdf 0%,#ffffff 100%);
background: -ms-linear-gradient(top,  #dfdfdf 0%,#ffffff 100%);
background: linear-gradient(to bottom,  #dfdfdf 0%,#ffffff 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#dfdfdf', endColorstr='#ffffff',GradientType=0 );

    box-shadow: 0 1px white inset;
}
.onoffswitch-switch:after {
	content: "";
	font-size: inherit;
	font-family: Myriad Pro;
}

.onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-inner {
    margin-left: 0;
}

.onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-switch {
    right: 0px; 
}
/* RESPONSIVE */
@media (max-width: 767px)
{
	.mobile_view {
		padding: 0 8px;
	}
}
</style>

<div class="container-fluid mobile_view">
	<legend style="font-family: Segoe UI Semibold; font-size: 18px; color: rgb(23, 23, 23);">Profile</legend>
	<!--alerts-->
	<div class="alert alert-success success_profile" style="margin-bottom: 0;display:none;">
		<!--<button type="button" class="close" data-dismiss="alert">x</button>-->
		Saved!
	</div>
	<!--alerts for password-->
	<div class="alert alert-error error_profile" style="margin-bottom: 0;display:none">
		<button type="button" class="close" data-dismiss="alert">x</button>
		<p class="message_to_user" style="margin:0;"></p>
	</div>
	
<?php
		$form_attrib = array(
			'name' => 'form_prof', 
			'id' => 'form_prof',
			'class' => 'form-horizontal fileupload_form'
		);
		echo form_open_multipart('profile/update', $form_attrib);
?>
			<div class="control-group">
				<div class="controls">
					<input id="profile_pic" type="hidden" name="profile_pic">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Profile Picture:</label>
				<div class="controls">
					<div class="fileupload fileupload-new" data-provides="fileupload" style="display: inline-block;position:relative;">
						<?php
							if($profilePic != '')
							{
						?>
							<img class="del_prof_pic" src="<?php echo base_url('img/close_button.png'); ?>">
						<?php
							}
						?>
						<div class="fileupload-new thumbnail prof_image_container" style="max-width: 200px; max-max-height: 500px;">
							<img src="<?php echo $profilePic; ?>">
						
						</div>
						<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 500px; line-height: 20px;"></div>
						<div>
							<span class="btn btn-file fileinput-button">
								<span class="fileupload-new">Select image</span>
								<span class="fileupload-exists">Change</span>
									<input type="file" name="upload_image" id="upload_image" accept="image/*"/>
								</span>
								<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
						</div>
					</div>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="first_name">First Name:</label>
				<div class="controls">
					<input type="text" class="span3" id="first_name" placeholder="First Name" name="first_name" value="<?php echo $user['first_name']; ?>" required>
				</div>
			</div>
			
			<div class="control-group">
				<label class="control-label" for="last_name">Last Name:</label>
				<div class="controls">
					<input type="text" class="span3" id="last_name" placeholder="Last Name" name="last_name" value="<?php echo $user['last_name']; ?>" required>
				</div>
			</div>
			
			<div class="control-group">
				<label class="control-label">Email:</label>
				<div class="controls">
					<span class="help-inline" style="padding-top: 5px;"><?php echo $user['email']; ?></span>
				</div>
			</div>
			
			<!--<div class="control-group">
				<label class="control-label"> Paypal Email: </label>
<?php
				// $query22 = $this->db->query("SELECT * FROM paypal_account WHERE user_id='$uid' ORDER BY id LIMIT 1");
				// if($query22->num_rows() > 0)
				// {
					// $paypal_email = $query22->row_array();
				// }
?>
				<div class="controls">
					<input id="old_paypal_text" type="hidden" value="<?php //echo isset($paypal_email['paypal_email']) ? $paypal_email['paypal_email'] : 'No Email'; ?>">
					<span id="paypal_text" class="help-inline" style="padding-top: 5px;"><?php //echo isset($paypal_email['paypal_email']) ? $paypal_email['paypal_email'] : 'No Email'; ?></span>
				</div>
			</div>-->
	
			<hr>
			
			<div class="control-group">
				<label class="control-label">Age:</label>
				<div class="controls">
					<span class="help-inline" style="padding-top: 5px;">
<?php
						if($row_info['bday']) {
							$age = $this->times_model->getAgeLong($row_info['bday']);
							echo $age == 0 ? 'less than a year' : $age . ' years';
						}
?>
					</span>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Birthday:</label>
				<div class="controls">
				<?php
					if(isset($row_info['bday']) AND $row_info['bday'] != 0)
					{
						echo '<input type="text" id="bdate" class="span3 bdate" name="bdate" value="'.date('M j, Y',$row_info['bday']).'">';
					}else
					{
						echo '<input type="text" id="bdate" class="span3 bdate" name="bdate" value="">';
					}
				?>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Gender:</label>
				<div class="controls">
					<select id="sex" name="sex" class="span3">
					<?php
						if(isset($row_info['sex']))
						{
							if($row_info['sex'] == 1)
							{
								echo '<option value="1">Male</option>';
								echo '<option value="2">Female</option>';
							}else if($row_info['sex'] == 2)
							{
								echo '<option value="2">Female</option>';
								echo '<option value="1">Male</option>';
							}else 
							{
								echo '<option value="0">Select...</option>';
								echo '<option value="1">Male</option>';
								echo '<option value="2">Female</option>';
							}
						}else
						{
					?>
						<option value="0">Select...</option>
						<option value="1">Male</option>
						<option value="2">Female</option>
					<?php
						}
					?>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Address:</label>
				<div class="controls">
					<textarea rows="4" class="span5" name="address"><?php echo isset($row_info['address']) ? $row_info['address'] : ''; ?></textarea>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="region">Region:</label>
				<div class="controls">
					<select id="region" name="region" class="span3">
				<?php
					if(isset($row_info['region']) AND $row_info['region'] != 0):
				?>
						<option value="<?php echo $row_info['region'] != 0 ? $row_info['region'] : 0; ?>"><?php echo isset($region_row['region']) ? $region_row['region'] : ''; ?></option>
				<?php
					else:
				?>
						<option value="0">Select...</option>
				<?php
					endif;
				?>
			<?php
				if(isset($row_info['region']))
				{
					$this->db->not_like('id',$row_info['region']);
				}
				$get_region = $this->db->get('regions');
				foreach($get_region->result_array() as $r_row)
				{
					echo '<option value="'.$r_row['id'].'">'.$r_row['region'].'</option>';
				}
			?>
						
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">City:</label>
				<div class="controls">
					<select id="city" name="city" class="span3">
						<option value="<?php echo isset($row_info['city']) ? $row_info['city'] : '0'; ?>">
							<?php 
								if($row_info['city']) {
									echo $row_info['city'];
								} else {
									echo 'Select...';
								}
							?>
						</option>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Mobile Number:</label>
				<div class="controls">
					<input type="text" id="mobile" class="span3" name="mobile" value="<?php echo isset($row_info['mobile_num']) ? $row_info['mobile_num'] : ''; ?>">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Landline Number:</label>
				<div class="controls">
					<input type="text" id="Landline" class="span3" name="Landline" value="<?php echo isset($row_info['landline']) ? $row_info['landline'] : ''; ?>">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Fax Number:</label>
				<div class="controls">
					<input type="text" id="fax" class="span3" name="fax" value="<?php echo isset($row_info['fax_num']) ? $row_info['fax_num'] : ''; ?>">
				</div>
			</div>
<!-- checkout settings start -->						
			<legend style="font-family: Segoe UI Semibold; font-size: 18px; color: rgb(23, 23, 23);">Payment Options</legend>
			
			<div class="control-group bank_details_container">
				<label class="control-label" for="bnk1" style="padding-top: 0;"><b style="font-size:13px;">Bank Details</b></label>							
				<div class="controls">					
					<!--<span><input type="checkbox" name="chkssetting[bank]" id="bnk1" value="true" <?php //echo isset($bank) ? 'checked="checked"' : ''; ?> style="vertical-align: top;" /></span>-->
				</div>				
			</div>
<?php
	if($bank_details_array->num_rows() > 0)
	{
		foreach($bank_details_array->result_array() as $bank_row)
		{
			echo '
				<div class="bank_face">
					<button type="reset" class="remove_bank_account btn pull-right active_action_button">Remove</button>
					<div class="control-group" style="margin-bottom:0;padding-top: 5px;">
						<label class="control-label" style="padding-top:0;">Bank Name: </label>
						<div class="controls">
							<span>'.$bank_row['bank_name'].'</span>
							<input type="text" name="user_bankname[]" class="user_bankname" value="'.$bank_row['bank_name'].'" style="display:none;">
						</div>
					</div>
					<div class="control-group" style="margin-bottom:0;padding-top: 5px;">
						<label class="control-label" style="padding-top:0;">Account Name: </label>
						<div class="controls">
							<span>'.$bank_row['account_name'].'</span>
							<input type="text" name="user_acctname[]" class="user_acctname" value="'.$bank_row['account_name'].'" style="display:none;">
						</div>
					</div>
					<div class="control-group" style="margin-bottom:0;padding-top: 5px;">
						<label class="control-label" style="padding-top:0;">Account Number: </label>
						<div class="controls">
							<span>'.$bank_row['account_number'].'</span>
							<input type="text" name="user_acctnum[]" class="user_acctnum" value="'.$bank_row['account_number'].'" style="display:none;">
						</div>
					</div>
				</div>
			';
?>
		
<?php
		}
	}
?>
			<div class="control-group addbankpart" style="margin-top: 15px;">
				<label class="control-label" for="bnkname1">Bank Name: </label>
				<div class="controls">
					<input type="text" name="bnkname1" class="span3" id="bnkname1" />
					<span class="help-inline hide">Required.</span>
				</div>
			</div>
			<div class="control-group addbankpart">
				<label class="control-label" for="actname1">Account Name: </label>
				<div class="controls">
					<input type="text" name="actname1" class="span3" id="actname1" />
					<span class="help-inline hide">Required.</span>
				</div>
			</div>		
			<div class="control-group addbankpart">
				<label class="control-label" for="actnum1">Account Number: </label>
				<div class="controls">
					<input type="text" name="actnum1" class="span3" id="actnum1" />
					<span class="help-inline hide">Required.</span>
				</div>
			</div>
			<div class="control-group" style="margin-bottom: 20px;">
				<div class="controls">
					<a class="btn btn-primary bnk-add-acc active_action_button">Add Account</a>
				</div>				
			</div>
<?php
	$paypal_email ='';
	$gcash_num ='';
	$smart_num ='';
	if($payment_option_array->num_rows() > 0)
	{
		$row_payment = $payment_option_array->row_array();
		$paypal_email = $row_payment['paypal_email'];
		$gcash_num = $row_payment['gcash'];
		$smart_num = $row_payment['smart_money'];
	}
?>
			<div class="control-group">
				<label class="control-label" for="mail_paypal">Paypal Email: </label>
				<div class="controls">
					<input type="email" name="mail_paypal" class="span3" id="mail_paypal" value="<?php echo $paypal_email; ?>" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="gnum">Gcash Mobile Number: </label>
				<div class="controls">
					<input type="text" name="gnum" class="span3" id="gnum" value="<?php echo $gcash_num; ?>" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="snum" style="font-size: 11px;">Smart Money Mobile Number: </label>
				<div class="controls">
					<input type="text" name="snum" class="span3" id="snum" value="<?php echo $smart_num; ?>" />
				</div>
			</div>	

			<legend style="font-family: Segoe UI Semibold; font-size: 18px; color: rgb(23, 23, 23);margin-top: 20px;">Delivery Method</legend>
<?php
	$meetup_check = false;
	$pickup_check = false;
	if($delivery_method_array->num_rows() > 0)
	{
		foreach($delivery_method_array->result_array() as $i)
		{
			$key = array_search('meetup',$i);
			$key2 = array_search('pickup',$i);
			if($key)
			{
				$meetup_check = true;
			}
			if($key2)
			{
				$pickup_check = true;
			}
		}
		
		
	}
?>			
			<div class="control-group">
				<label class="control-label" for="pickup" style="padding-top: 0;">Pick-up</label>							
				<div class="controls">
					<span>
						<input type="checkbox" <?php echo $pickup_check ? 'checked' : ''; ?> name="chkssetting[]" class="checkbox_each" id="pickup" value="pickup" style="vertical-align: top;" />
					</span>		
					<input type="checkbox" name="method_price[]" class="span2" placeholder="Delivery Charges" value="0" <?php echo $pickup_check ? 'checked' : ''; ?> style="display:none;">
				</div>					
			</div>
			<div class="control-group">
				<label class="control-label" for="meetup" style="padding-top: 0;">Meet-up</label>							
				<div class="controls">
					<span>
						<input type="checkbox" <?php echo $meetup_check ? 'checked' : ''; ?> name="chkssetting[]" class="checkbox_each" id="meetup" value="meetup" style="vertical-align: top;" />
					</span>
					<input type="checkbox" name="method_price[]" class="span2" placeholder="Delivery Charges" value="0" <?php echo $meetup_check ? 'checked' : ''; ?> style="display:none;">
				</div>			
			</div>	
<?php
	if($delivery_method_array->num_rows() > 0)
	{
		foreach($delivery_method_array->result_array() as $delmethod)
		{
			if($delmethod['name'] != 'meetup' && $delmethod['name'] != 'pickup')
			{
				echo '
				<div class="control-group">
					<label class="control-label" for="meetup" style="padding-top: 0;">'.$delmethod['name'].'</label>							
					<div class="controls">
						<span>
							<input type="checkbox" name="chkssetting[]" class="checkbox_each" id="'.$delmethod['name'].'" value="'.$delmethod['name'].'" style="vertical-align: top;" checked />
						</span>
						<div>
							<small>Delivery Cost</small><br/>
							<input type="text" name="method_price[]" class="span2" placeholder="Delivery Cost" value="'.($delmethod['price'] ? $delmethod['price'] : '').'">
						</div>
					</div>			
				</div>	
				';
			}
		}
	}
?>

			<ul class="d_other" style="margin: 0;list-style: none;">
				
			</ul>			
			<div class="control-group other-delivery">			
				<label class="control-label"><b style="font-size:13px;">Other Method:</b> </label>	
				<div class="controls">
					<div class="input-append">
						<input name="del_value" class="span2 del_value" id="appendedInputButton" type="text">
						<a class="btn adddelivery">Add</a>
					</div>
				</div>
			</div>				
<!-- checkout settings end -->			
			<hr>
			
			<div class="control-group">
				<label class="control-label" for="first_name"> Date Registered: </label>
				<div class="controls">
					<span class="help-inline" style="padding-top: 5px;"><?php echo date('M j, Y g:i:s a', $user['date_registered']); ?></span>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="first_name"> Date Last Logged In: </label>
				<div class="controls">
					<span class="help-inline" style="padding-top: 5px;"><?php echo $user['date_last_login'] == 0 ? 'no data yet' : date('M j, Y g:i:s a', $user['date_last_login']); ?></span>
				</div>
			</div>
	<hr>
			
		<div class="row-fluid">
			<div class="pull-right save">
				<button id="submitprof" class="btn" type="submit" name="button" value="profile">Save</button>
			</div>
		</div>

<?php
	echo form_close();
?>
</div>
<!-- Modal Delete Website-->
<div id="myModal_delete_prof_pic" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-header title_message" style="background-color: #f26221;border-bottom:0;">
		<h4 id="myModalLabel" style="color:#fff;font-size: 20px;margin: 5px 0;font-family: 'Segoe UI Semibold';opacity: 0.7;">Are you sure you want to remove this picture?</h4>
	</div>
	<div class="modal-footer" style="background-color: #e34e0d;color: #fff;border-top:0;box-shadow: none;border-radius:0;">
		<button id="<?php echo $user['uid']; ?>" class="btn btn_color del_button_pic">Delete</button>
		<button class="btn btn_color" data-dismiss="modal" aria-hidden="true">Close</button>
	</div>
</div>
<!-- Modal Remove Banks
<div id="remove_bank" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="background: none repeat scroll 0 0 rgba(255, 255, 255, 0.8);font-family: Segoe UI;border-radius: 0px;">
	<div class="modal-header" style="background: none repeat scroll 0 0 #F26A2C;border-bottom: medium none;color: white;">		
		<h3 id="myModalLabel" style="font-weight: normal;">Remove Bank Account</h3>
	</div>
	<?php
		// $remove_bank_attrib = array(
			// 'id' => 'remove_bank_form'
		// );
		// echo form_open('profile/remove_bank', $remove_bank_attrib);
	?>
	<div class="modal-body" style="text-align: center;">
	
		<div class="row-fluid" id="inform_buyer">
			<h4>Remove this Bank Account?</h4>
		</div>
	</div>
	<input type="hidden" name="rev_key" id="rev_key" />
	<div class="modal-footer" style="background: none repeat scroll 0 0 rgba(255, 255, 255, 0);border: medium none;box-shadow: none;">
		<button class="btn btn-style remove_yes" type="reset">Yes</button><a class="btn btn-style remove_no" data-dismiss="modal" aria-hidden="true">No</a>
	</div>
	</form>
</div>-->
<script type="text/javascript">
$(function(){
		$('#form_prof').delegate('.checkbox_each','click',function(){
			var del_val = $(this).val();
			if($(this).is(':checked'))
			{
				if(del_val == 'pickup')
				{
					$(this).parent().parent().find('input').prop('checked',true);
					
				}else if(del_val == 'meetup')
				{
					$(this).parent().parent().find('input').prop('checked',true);
					
				}
			}else
			{
				if(del_val == 'pickup')
				{
					$(this).parent().parent().find('input').prop('checked', false);
					
				}else if(del_val == 'meetup')
				{
					$(this).parent().parent().find('input').prop('checked', false);
					
					
				}
			}
		});
		$('.other-delivery').delegate('.adddelivery','click',function(){
			var success = true;
			var del_value = $('.del_value').val().trim();
			
			/* prevent same name */
			$('.checkbox_each').each(function(i,el){
				if($(el).val() == del_value)
				{
					success = false;
				}
			});
			
			if(success == true)
			{
				if(del_value != ''){
					$('.del_value').val('');
					$.ajax({
						type: 'post',
						url: '<?php echo base_url(); ?>profile/otherdelivery',
						data: {'other_name':del_value},
						success: function(html) {
							del_value.replace(" ","_")
							$('.d_other').append(
							'<li><div class="control-group">'+
								'<label class="control-label" for="'+del_value.replace(" ","_")+'" style="padding-top: 0;">'+
									del_value+
								'</label>'+
								'<div class="controls">'+
									'<span><input type="checkbox" name="chkssetting[]" id="'+del_value.replace(" ","_")+'" value="'+del_value+'" style="vertical-align: top;" class="checkbox_each" checked /></span>'+
									'<div>'+
										'<small>Delivery Cost</small><br/>'+
										'<input type="text" name="method_price[]" class="span2" placeholder="Delivery Cost" value="">'+
									'</div>'+
								'</div>'+
								'</div>'+
							'</li>');
							// window.location.reload();
						}
					});
				}
			}
		});
		/* delete profile pic */
		$('.controls').delegate('.del_prof_pic','click',function(){
			$('#myModal_delete_prof_pic').modal('show');
		});

		$('.del_button_pic').click(function(){
			var id = $(this).attr('id'); 
			onDeletePic(id)
		});
		
		function onDeletePic(id)
		{
			var dataString = 'uid='+id;
			$.ajax({
				type: 'post',
				url: '<?php echo base_url(); ?>profile/removeProfilePicture',
				data: dataString,
				success: function(html)
				{
					window.location = self.location;
				}
			});
			
		}
		
		$('#region').on('change',function(){
			var region_id = $(this).val();
			citysearch(region_id)
		});
		
		
		function citysearch(i) {
			var dataString = 'id='+i;
			$.ajax({
				type: 'post',
				url: '<?php echo base_url(); ?>profile/city_list',
				data: dataString,
				success: function(html)
				{
					$('#city').html(html);
				}
			});
		}

		function validateEmail(email) {
			var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			return re.test(email);
		}
		
		/* datepicker */
		$( ".bdate" ).datepicker({
			// defaultDate: "+1w",
			changeMonth: true,
			changeYear: true,
			yearRange: "1900:2013",
			dateFormat: "M d, yy"
		});
		
		
		$('#form_prof').delegate('#save-paypal','click',function(e){
			var email = $('.email_paypal').val();
			var datastring = 'user_id=<?php echo $this->session->userdata('uid'); ?>&email='+email;
			var ckemail = validateEmail(email);
			if(ckemail)
			{
				$.ajax({
					type: 'post',
					url: '<?php echo base_url(); ?>multi/recordpaypal',
					data: datastring,
					success: function(html)
					{
						$('#paypal_text').html(email).attr('class', 'help-inline').css('padding-top','5px');
						$('#old_paypal_text').val(email);
					}
				});
			}
			
			e.stopPropagation;
			e.preventDefault;
		});
		
		$(document).click(function(e) {
		
			var element = e.target;
			
			if(element.id == 'paypal_text')
			{
				var p_email = $(element).html();
				if(element.className == 'help-inline')
				{
					$(element).attr('class','edit-paypal').css('padding','0');

					$(element).html('<div class="input-append"><input class="email_paypal" id="appendedInputButton" type="email" value="'+p_email+'"><button id="save-paypal" class="btn btn-primary save-paypal" type="button">Save</button></div>');
					$('.email_paypal').focus();
				}
			}
			else if(element.className != 'email_paypal' && element.id != 'save-paypal')
			{
				var p_email = $('#old_paypal_text').val();
				$('#paypal_text').html(p_email).attr('class', 'help-inline').css('padding-top','5px').css('padding-left','5px');					
			}
			
			e.preventDefault;
			e.stopPropagation;
		});

	/* submit profile form */
		$("#form_prof").ajaxForm({
			beforeSubmit: function(html) {
				$('#submitprof').attr('disabled','disabled');
				$('#submitprof').button('loading');
			},
			success: function(html) {
				
				var obj = JSON.parse(html);
				$('#profile_pic').val(obj.image);
				if(obj.image)
				{
					$('#imgprofile').attr('src', obj.image);
					$("#form_prof").find('.thumbnail img:first-child').attr('src', obj.image);
					$('.fileupload').addClass('fileupload-new').removeClass('fileupload-exists');
				}
				$('#submitprof').button('reset');
				$('body, html').animate({
				  scrollTop:0
				 },500,function(){
				  $('.success_profile').show();
				  setTimeout(function(){
				   $('.success_profile').hide();
				  },2000);
				 });
			}
		});	

	$('.bnk-add-acc').on('click',function(){
		var bnkname = $('#bnkname1').val().toUpperCase();
		var accname = $('#actname1').val();
		var accnum = $('#actnum1').val();
		var validate = true;
		
		if((bnkname.trim() == '') || (accname.trim() == '') || (accnum.trim() == '')){
			$('.addbankpart').find('.help-inline').removeClass('hide');
		}else
		{
			$('.user_bankname').each(function(i, el){
				if($(el).val().trim() == bnkname)
				{
					validate = false;
				}
			});
			if(validate == false)
			{
				$('#bnkname1').val('').focus();	
			}else
			{
				insertbankHtml(bnkname.trim(),accname.trim(),accnum.trim());
				$('#bnkname1').val('');
				$('#actname1').val('');
				$('#actnum1').val('');
			}
		}		
	});
	$('#form_prof').delegate('.bank_face','click',function(){
		
		$(this).find('input[type="text"]').show();
		$(this).find('span').hide();
	
		
	});
	$('#form_prof').delegate('.remove_bank_account','click',function(){
		$(this).parent('.bank_face').remove();
	});
	function insertbankHtml(bnkname,accname,accnum) {
		var el = '';
		el += '<div class="bank_face">';
		el += '<button type="reset" class="remove_bank_account btn pull-right active_action_button">Remove</button>';
		el += '<div class="control-group" style="margin-bottom:0;padding-top: 5px;">';
		el += 	'<label class="control-label" style="padding-top:0;">Bank Name: </label>';
		el += 		'<div class="controls">';
		el += 			'<span>'+bnkname+'</span>';
		el += 			'<input type="text" name="user_bankname[]" class="user_bankname" value="'+bnkname+'" style="display:none;">';
		el += 		'</div>';
		el += '</div>';
		el += '<div class="control-group" style="margin-bottom:0;padding-top: 5px;">';
		el += 	'<label class="control-label" style="padding-top:0;">Account Name: </label>';
		el += 		'<div class="controls">';
		el += 			'<span>'+accname+'</span>';
		el += 			'<input type="text" name="user_acctname[]" class="user_acctname" value="'+accname+'" style="display:none;">';
		el += 		'</div>';
		el += '</div>';
		el += '<div class="control-group" style="margin-bottom:0;padding-top: 5px;">';
		el += 	'<label class="control-label" style="padding-top:0;">Account Number: </label>';
		el += 		'<div class="controls" style="padding-bottom: 5px;">';
		el += 			'<span>'+accnum+'</span>';
		el += 			'<input type="text" name="user_acctnum[]" class="user_acctnum" value="'+accnum+'" style="display:none;">';
		el += 		'</div>';
		el += '</div>';
		el += '</div>';
		$(el).insertAfter('.bank_details_container');
	}
	// $('#remove_bank_form').ajaxForm({
		// beforeSubmit: function(formData, jqForm, options) {
			// $('.remove_no, .remove_yes').attr('disabled','disabled');
		// },
		// success: function(html) {
			// location.reload();
		// }
	// });
	
});
function banksettings(x, type, key){
	var parent = $(x).parents('li'),
		bankname = parent.find('.bn p').html(),
		actname = parent.find('.an p').html(),
		actnum = parent.find('.anum p').html(),
		bankname_past = parent.find('.bn p').attr('alt'),
		actname_past = parent.find('.an p').attr('alt'),
		actnum_past = parent.find('.anum p').attr('alt'),
		bnknameEdit = parent.find('.bn p #bnknameEdit').val(),
		actnameEdit = parent.find('.an p #actnameEdit').val(),
		actnumEdit = parent.find('.anum p #actnumEdit').val(),
		datatring = 'actnum_past='+actnum_past+'&bncname='+bnknameEdit+'&actname='+actnameEdit+'&actnum='+actnumEdit;
	
	switch(type){
		case 'edit':
			parent.find('.edit-bank').html('<a class="btn btn-link active_action_button" onclick="banksettings(this,\'save\','+key+')">Save</a>');
			parent.find('.remove-bank').html('<a class="btn btn-link active_action_button" onclick="banksettings(this, \'cancel\','+key+')">Cancel</a>');
			parent.find('.bn p').html('<input type="text" name="bnknameEdit" id="bnknameEdit" value="'+bankname+'" />');
			parent.find('.an p').html('<input type="text" name="actnameEdit" id="actnameEdit" value="'+actname+'" />');
			parent.find('.anum p').html('<input type="text" name="actnumEdit" id="actnumEdit" value="'+actnum+'" />');
		break;
		case 'remove':
			// alert('remove');
			$('#remove_bank').modal('show');
			$('#rev_key').val(key);
		break;
		case 'save':
			
			// alert(datatring);
			$.ajax({
				type:'post',
				url:'<?php echo base_url(); ?>profile/updatebank',
				data: datatring,
				success:function(data){
					parent.find('.bn p').attr('alt', bnknameEdit);
					parent.find('.an p').attr('alt', actnameEdit);
					parent.find('.anum p').attr('alt', actnumEdit);
					parent.find('.edit-bank').html('<a class="btn btn-link active_action_button" onclick="banksettings(this, \'edit\','+key+')">Edit</a>');
					parent.find('.remove-bank').html('<a class="btn btn-link active_action_button" onclick="banksettings(this, \'remove\','+key+')">Remove</a>');
					parent.find('.bn p').html(bnknameEdit);
					parent.find('.an p').html(actnameEdit);
					parent.find('.anum p').html(actnumEdit);
				}
			});
		break;
		case 'cancel':
			parent.find('.edit-bank').html('<a class="btn btn-link active_action_button" onclick="banksettings(this, \'edit\','+key+')">Edit</a>');
			parent.find('.remove-bank').html('<a class="btn btn-link active_action_button" onclick="banksettings(this, \'remove\','+key+')">Remove</a>');
			parent.find('.bn p').html(bankname_past);
			parent.find('.an p').html(actname_past);
			parent.find('.anum p').html(actnum_past);
		break;
	}
}
</script>
<?php
	} else {
		echo 'No User exists!';
	}
?>