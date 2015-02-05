
<?php
	date_default_timezone_set('Asia/Manila');
	
	$uid = $this->session->userdata('uid');
	$this->db->where('uid', $uid);
	$query = $this->db->get('users');
	$user = $query->row();

	$profPic = $user->profile_picture;
	$profPic = str_replace(' ','_',$profPic);
	$pub_blog = $user->publish_blog;
	$pub_gal = $user->publish_gallery;
?>
<style type="text/css">

	.btn_color {
		background: #f16120; /* Old browsers */
		background: -moz-linear-gradient(top,  #f16120 0%, #e75210 100%); /* FF3.6+ */
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#f16120), color-stop(100%,#e75210)); /* Chrome,Safari4+ */
		background: -webkit-linear-gradient(top,  #f16120 0%,#e75210 100%); /* Chrome10+,Safari5.1+ */
		background: -o-linear-gradient(top,  #f16120 0%,#e75210 100%); /* Opera 11.10+ */
		background: -ms-linear-gradient(top,  #f16120 0%,#e75210 100%); /* IE10+ */
		background: linear-gradient(to bottom,  #f16120 0%,#e75210 100%); /* W3C */
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f16120', endColorstr='#e75210',GradientType=0 ); /* IE6-9 */
		
		text-shadow: none;
		box-shadow: -2px 2px 5px -2px #ddd inset;
		color: #fff;
	}
	.btn_color:hover {
		background: #e75311; /* Old browsers */
		background: -moz-linear-gradient(top, #e75311 0%, #f16120 100%); /* FF3.6+ */
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#e75311), color-stop(100%,#f16120)); /* Chrome,Safari4+ */
		background: -webkit-linear-gradient(top, #e75311 0%,#f16120 100%); /* Chrome10+,Safari5.1+ */
		background: -o-linear-gradient(top, #e75311 0%,#f16120 100%); /* Opera 11.10+ */
		background: -ms-linear-gradient(top, #e75311 0%,#f16120 100%); /* IE10+ */
		background: linear-gradient(to bottom, #e75311 0%,#f16120 100%); /* W3C */
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#e75311', endColorstr='#f16120',GradientType=0 ); /* IE6-9 */

		box-shadow: 1px -2px 5px -2px #ddd inset;
		color: #fff;
	}
	.deact_button {
		border-radius: 0;
		background: #ddd;
		border: 0;
		text-shadow: 0 0;
	}
	.deact_button:hover {
		background: #08c;
	}
	
button[type=submit] {
	background: #0082EE;
	border-radius: 0;
	border: none;
	text-shadow: 0px 0px;
}
button[type=submit]:hover {
	background: #DDD;
	color: #08c;
}
.head {
	margin-bottom: 20px;
}
.form-horizontal .control-group {
    font-family: Segoe UI;
    font-size: 12px;
    margin-bottom: 10px;
}
.form-horizontal .control-label, .form-horizontal span, .form-horizontal input, .form-horizontal textarea {
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
@media (max-width: 800px)
{
	.onoffswitch {
		float: none;
	}
}
@media (max-width: 320px)
{
	.mobile_margin {
		margin: 0 25px 0 0 !important;
	}
}
</style>

<div class="container-fluid mobile_view">
	<input type="hidden" id="account_settings_uid" value="<?php echo $uid;?>"/>
	<input type="hidden" id="account_settings_base_url" value="<?php echo base_url();?>"/>
	<!--alerts-->
	<div class="alert alert-success success_profile" style="margin-bottom: 0;display:none;">
		<button type="button" class="close" data-dismiss="alert">x</button>
		Saved Successfully!
	</div>
	<!--alerts for password-->
	<div class="alert alert-error error_profile" style="margin-bottom: 0;display:none">
		<button type="button" class="close" data-dismiss="alert">x</button>
		<p class="message_to_user" style="margin:0;"></p>
	</div>

	<legend style="font-family: Segoe UI Semibold; font-size: 18px; color: rgb(23, 23, 23);">Account Settings:</legend>

<?php
		$form_attrib = array(
			'name' => 'form_sett', 
			'id' => 'form_sett',
			'class' => 'form-horizontal'
		);
		echo form_open_multipart('settings/update', $form_attrib);
?>
		<div style="font-family: Segoe UI Semibold;" class="head"> Connect with Social Media: </div>

		<div class="control-group">
			<label class="control-label" for="first_name"> Facebook: </label>
			<div class="controls">
			
				<div class="onoffswitch">
					<input type="checkbox" name="status_fb" class="onoffswitch-checkbox" id="status_fb" <?php echo isset($user->fb_id_fk) == 1 ? 'checked' : ''; ?>>
					<label id="fb_switch" class="onoffswitch-label" for="status_fb">
						<div class="onoffswitch-inner"></div>
						<div class="onoffswitch-switch"></div>
					</label>
				</div>
				<div class="form-inline hide_this_fb" style="<?php echo isset($user->fb_id_fk) ? '' : 'display: none;'; ?>">
					<span class="mobile_margin" style="margin: 0 25px;">Publish: </span><input type="checkbox" class="check_out" name="publish_blog" value="yes" <?php echo $pub_blog == 'yes' ? 'checked="checked"' : ''; ?> style="margin-bottom: 8px;vertical-align: middle;">
					<span style="margin-right: 20px;">Blog</span><input type="checkbox" class="check_out" name="publish_gal" value="yes" <?php echo $pub_gal == 'yes' ? 'checked="checked"' : ''; ?> style="margin-bottom: 8px;vertical-align: middle;">
					<span style="margin-right: 30px;">Gallery</span><a class="btn btn-primary" href="<?php echo base_url(); ?>manage/facebook_page_list" style="border-radius: 0;padding: 4px 15px;"> Find Facebook Friends on Bolooka </a>
				</div>
			</div>
		</div>		
	<hr/>
	
		<div style="font-family: Segoe UI Semibold;" class="head"> Change Password: </div>
		
			<div class="control-group">
				<label class="control-label" for="first_name"> Current: </label>
				<div class="controls">
					<input id="currPass" name="pass" type="password" />
					<span class="help-inline error_com"></span>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="first_name"> New: </label>
				<div class="controls">
					<input id="newPass" name="new_pass" type="password" />
					<span class="help-inline error_com"></span>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="first_name"> Re-type New: </label>
				<div class="controls">
					<input id="rePass" name="re_pass" type="password" />
					<span class="help-inline error_com"></span>
				</div>
			</div>
			
	<hr />
		
		<div class="row-fluid">
			<div class="pull-left deact">
				<a href="#myModal_deactivate" class="btn btn-primary deact_button" data-toggle="modal">Deactivate your account</a>
			</div>
			<div class="pull-right save">
				<button id="submitsett" class="btn btn-primary" type="submit" name="button" value="settings">Save</button>
			</div>
		</div>

	<!--modal-->
	<div id="myModal_disconnect_fb" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
		<!--<div class="modal-header title_message">
			<h3 id="myModalLabel" class="text-warning">Warning!</h3>
		</div>-->
		<div class="modal-body" style="background-color: #e34e0d;color: #fff;">
			<h4 style="color:#fff;margin: 5px 0;font-family: 'ScalaSans Light';opacity: 0.7;">
				If you disconnect your Facebook account, you will not be able to login with Facebook to this bolooka account.
			</h4>
			<p>Are you sure?</p>
			<input class="website_id" name="website_id" type="hidden">
			<p class="pull-right">
				<button class="btn btn_color" id="fb_dis_button" type="button">Yes</button>
				<button class="btn btn_color" data-dismiss="modal" aria-hidden="true" type="button">No</button> 
			</p>
		</div>
	</div>
	
<?php
	echo form_close();
?>
	<!-- Modal deactivate -->
	<div id="myModal_deactivate" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-header" style="background-color: #f26221;border-bottom:0;">
		<h4 id="myModalLabel" style="color:#fff;margin: 5px 0;font-family: 'Segoe UI Semibold';opacity: 0.7;">Deactivate your account</h4>
	  </div>
	  <div class="modal-body" style="background-color: #e34e0d;color: #fff;">
		<p>Are you sure you want to deactivate your account?<br/>Your Social and Connected accounts will be removed</p>
		<p class="pull-right">
			<button class="btn btn_color" type="button" onclick="deactivate_account(this)">Deactivate</button>
			<button class="btn btn_color" data-dismiss="modal" aria-hidden="true">Close</button>
		</p>
	  </div>
	</div>
	
	<!-- Modal deactivate confirmation -->
	<div id="myModal_deactivate_confirm" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-header" style="background-color: #f26221;border-bottom:0;">
		<h4 id="myModalLabel" style="color:#fff;margin: 5px 0;font-family: 'Segoe UI Semibold';opacity: 0.7;">Confirm Password</h4>
	  </div>
	  <div class="modal-body" style="background-color: #e34e0d;color: #fff;">
		<p>Please enter your password</p>
		<p>
			<input type="password" class="account_password" id="<?php echo $user->uid; ?>">
			<span class="error_msg"></span>
		</p>
		<p class="pull-right">
			<button class="btn btn_color" type="button" onclick="deactivate_process(this)">Deactivate</button>
			<button class="btn btn_color" data-dismiss="modal" aria-hidden="true">Close</button>
		</p>
	  </div>
	</div>
	
	<!--switch user fb-->
	<div id="myModal_switch_fb" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-body" style="background-color: #e34e0d;color: #fff;">
		<p style="font-family: 'Segoe UI Semibold';">Facebook account is already used by another bolooka user</p>
		<p class="pull-right">
			<button class="btn btn_color" data-dismiss="modal" aria-hidden="true">Close</button>
		</p>
	  </div>
	</div>	
</div>