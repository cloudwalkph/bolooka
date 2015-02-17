<style>
/* THIS IS FOR FILE(signtop.php)
------------------------------------------------------------------------------------------------------------- */
#signtop {
    margin-bottom: 0;
    z-index: 1031;
}
#signtop .accordion-group {
	border: none;
	border-radius: 0;
	margin-bottom: 0;
	background: black;
	color: white;
}
#collapseTwo .forgot_span{
	text-align: left;
	/* margin-right: 43px; */
}
#signin_form {
	color: white; 
	text-align: center;
}
/* RESPONSIVE */
@media (max-width: 480px) {  
	.form-inline .email_sign_in, .form-inline .password_sign_in{
		margin-bottom:10px;
	}	
	#collapseTwo .forgot_span{
		text-align: right;
		margin-right: 0;
	}
}
/* END
---------------------------------------------------------------------------------------------------------------- */
</style>
<div id="fb-root"></div>
		<!-- sign in accordion -->
		<div id="signtop" class="row-fluid accordion" style="position: relative;">
			<div class="accordion-group">
				<div id="collapseTwo" class="accordion-body collapse">
				  <div class="accordion-inner">

<?php
						$signin_form_attrib = array(
							'id' => 'signin_form',
							'name' => 'gsigh_in',
							'class' => 'form-inline'
						);
						echo form_open(base_url('signin'), $signin_form_attrib);
?>
							<input type="hidden" name="redirect_url" value="<?php echo $this->uri->uri_string(); ?>">
							<label class="control-label" style="font-family: 'Segoe UI';">Sign in</label>
							<div class="pull-right">
								<a data-toggle="collapse" href="#collapseTwo" data-parent="#signtop" style="text-decoration: none;">
									<img src="<?php echo base_url('img/close_button.png'); ?>">
								</a>
							</div>
							<input type="text" name="email" id="email" placeholder="Email address" class="email_sign_in span2" style="font-family: 'Segoe UI';"/>
							<input type="password" name="password" id="password" placeholder="Password" class="password_sign_in span2" style="font-family: 'Segoe UI';" />
							<button class="btn btn-primary" id="log_in" type="submit">Sign In</button>
							<a data-toggle="collapse" data-parent="#signtop" href="#collapseFour" style="color: #08c">Forgot password?</a>
							<?php if(isset($isHome) != 'yes') { ?>
							<a data-toggle="collapse" data-parent="#signtop" href="#collapseThree" style="color: #08c">New User?</a>
							<?php } ?>
<?php
						echo form_close();
?>
				  </div>
				</div>  
			</div>  
			<div class="accordion-group">
				<div id="collapseThree" class="accordion-body collapse">
				
					<!--register-->
					<div class="accordion-inner">
					<?php
						$signtop_form_attrib = array(
								'name' => 'signtopstep',
								'id' => 'signtopstep',
								'class' => 'form-inline container'
							);
						echo form_open(base_url('signup/first_sign_up'),$signtop_form_attrib);
					?>
							<div class="row-fluid">
								<div class="offset4 span4">
									<label class="control-label" style="font-size: 16px; margin-bottom: 0;">Sign up and create a website</label>
									<a data-toggle="collapse" href="#collapseThree" data-parent="#signtop" style="margin-top: 8px;"><img src="<?php echo base_url('img/close_button.png'); ?>"></a>
								</div>
							</div>
							<div class="row-fluid controls">
								<div class="offset4 span4">
									<input class="span12" id="email_signtop" type="text" name="email1" placeholder="Email Address" style="margin-top: 8px;" />
								</div>
							</div>
							<div class="row-fluid controls">
								<div class="offset4 span4">
									<div class="row-fluid">
										<div class="span12">
											<div class="row-fluid">
												<input class="span6" id="password_signtop" type="password" name="pass1" placeholder="Password" style="margin-top: 8px;margin-right: 6px;" />
												<input class="span6" id="retype_signtop" type="password" name="pass2" placeholder="Re-type Password" style="margin-top: 8px;" />
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row-fluid">
								<div class="offset4 span4">
									<button class="btn btn-small btn-primary span12 signtop_free_button" type="submit" style="margin-top: 8px;">GET FREE E-STORE NOW</button>
								</div>
							</div>
						<?php
							echo form_close();
						?>
					</div>
				</div>
			</div>
			<div class="accordion-group">
				<div id="collapseFour" class="accordion-body collapse">
					<div class="accordion-inner">
					<?php
						$forgot_form_attrib = array(
								'id' => 'forgot_form',
								'name' => 'forgot_in',
								'class' => 'form-inline',
								'style' => 'color: white; text-align: center;',
								'onsubmit' => 'return false'
							);
						echo form_open(base_url('signin/email_check'), $forgot_form_attrib);
					?>
						<label class="control-label" style="font-family: 'Segoe UI';">Email address</label>
						<input type="text" name="email" id="emailf" placeholder="Email address" class="span2" style="font-family: 'Segoe UI';" />
						<button class="btn btn-primary" id="forgot_send" type="button">Ok</button>&nbsp;&nbsp;
						<a data-toggle="collapse" href="#collapseFour" data-parent="#signtop"><img src="<?php echo base_url('img/close_button.png'); ?>"></a>
						<span class="help-inline validation_message forgot_error" style="color:red;"></span>
					</form>
						
					</div>
					<div class="container-fluid forgot_email_container" style="width: 34%;margin: 0 auto;text-align:left;box-shadow: 0 0 4px 1px #ddd inset;margin-bottom: 10px;padding: 10px;display:none;">
						<div class="pull-left">Email me a link to reset my password</div>
						<div class="pull-right">
							<button class="btn btn-primary go_to_pass" data-loading-text="Sending">Continue</button>
						</div>
						<div style="clear:both;"></div>
						<input type="text" id="email_catch" disabled>
					</div>
				</div>
			</div>
		</div> <!-- accordion -->
	
	<!--social create account-->
	<?php
		if(isset($_GET['init'])) {
			if($_GET['init'] != '')	{
				$data['init'] = $_GET['init'];
				$data['name'] = $_GET['name'];
				$data['last'] = $_GET['last'];
				$data['email'] = $_GET['email'];
				$data['connect'] = $_GET['connect'];
			}
		} else {
			$data['init'] = '';
			$data['name'] = '';
			$data['last'] = '';
			$data['email'] = '';
			$data['connect'] = '';
		}
	?>
	<div id="myModal_fb" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" style="width: 268px;left:60%;border-radius:0;background: #383838;">
		<div class="modal-header title_message" style="border-bottom:0;">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="padding: 2px 6px;background: #ddd;border-radius: 100px;">&times;</button>
			<p id="myModalLabel" style="color: #ddd;font-family: 'ScalaSans Light';margin-bottom: 0;font-size: 23px;">Create new account</p>
		</div>
		<div class="modal-body" style="text-align: center;">
		<?php echo $this->load->view('homepage/social_create_form_sign_top', $data); ?>
		</div>
	</div>
	
	<!--modal registration validation-->
	<div id="myModal_validation_error" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-body" style="background-color: #e34e0d;color: #fff;">
			<p id="error_sign_up" style="font-family: 'Segoe UI Semibold';"></p>
			<div class="pull-right">
				<button class="btn btn_color" data-dismiss="modal" aria-hidden="true">Close</button>
			</div>
		</div>
	</div>
	
<script>	
	/* document ready */
$(function(){
	
	/* social form submit */
	$('#social_form_buttons').on('click', function(){
		var eto = $(this);
		var logtype = $('#loginTypes').val();
		var fname = $('#social_firsts').val();
		var lname = $('#social_lasts').val();
		var email = $('#social_emails').val();
		var pass = $('#social_passs').val();
		var confirm = $('#social_confirms').val();
		var social_id = $('#social_ids').val();
		
		/* validation */
		if(!fname)
		{
			$('.validation_message1').html("Required");
			$('.error_validate1').addClass('error');
			return false;
		}
		if(!lname)
		{
			$('.validation_message2').html("Required");
			$('.error_validate2').addClass('error');
			return false;
		}
		if(!email)
		{
			$('.validation_message3').html("Required");
			$('.error_validate3').addClass('error');
			return false;
		}
		if(!pass)
		{
			$('.validation_message4').html("Required");
			$('.error_validate4').addClass('error');
			$('#social_passs').focus();
			return false;
		}
		if(pass.length < 6)
		{
			$('.validation_message4').html("Minimum of 6 character");
			$('.error_validate4').addClass('error');
			return false;
		}		
		if(pass != confirm)
		{
			$('#social_passs').focus();
			$('.validation_message5').html("password not match");
			$('.error_validate5').addClass('error');
			return false;
		}
		
		/* check if email exist */
		var dataParams = 'email='+email;
		$.ajax({
			type: "POST",
			url: '<?php echo base_url(); ?>signup/fbcheckEmail',
			data: dataParams,
			success: function(html) {
				if(html == 'email rejected') {
					$('.validation_message3').html("Email already exist!");
					$('.error_validate3').addClass('error');
					return false;
				} else {
					$(eto).button('loading');
					if(logtype == 'google')
					{
						var $dataString = 'g_name='+fname+'&g_last='+lname+'&email='+email+'&g_pass='+pass+'&g_id='+social_id,
							$url = "signup/account/google";
					}else if(logtype == 'yahoo')
					{
						var $dataString = 'y_name='+fname+'&y_last='+lname+'&email='+email+'&y_pass='+pass+'&y_id='+social_id,
							$url = "signup/account/yahoo";
					}else if(logtype == 'msn')
					{
						var $dataString = 'msn_name='+fname+'&msn_last='+lname+'&email='+email+'&msn_pass='+pass+'&msn_id='+social_id,
							$url = "signup/account/msn";
					}else
					{
						var $dataString = 'fb_first='+fname+'&fb_last='+lname+'&email='+email+'&fb_pass='+pass+'&fb_id='+social_id,
							$url = "signup/account/fb";
					}
						$.ajax({
							type: "POST",
							url: $url,
							data: $dataString,
							success: function(html) {
								if(html == '1')
								{
									/* Account exist */
									window.location = '<?php echo base_url(); ?>dashboard';
								}
								else if(html == 'fb created')
								{
									/* New account created for fb */
									$('#myModal_fb').html(
										'<div class="hero-unit" style="margin-bottom:0;background: #383838;">'+
											'<h3 style="color: #ddd;font-family: \'ScalaSans Light\';">Thank you for signing up, '+fname+'!</h3>'+
											'<div class="progress progress-striped active">'+
												'<div class="bar" style="width: 100%;"></div>'+
											'</div>'+
										'</div>');
										var fb_id = social_id;
										
										/* search fb friends */
										FB.api(fb_id+'/friends', function(response) {
										
											var namelist = new Array();
											var idlist = new Array();
											
											$(response.data).each(function(event,ui){
												namelist.push(ui.name);
												idlist.push(ui.id);
											});
											
											var dataString = 'fb_id='+idlist+'&fb_name='+namelist;
											$.ajax({
												type: "POST",
												url: '<?php echo base_url(); ?>signup/email_fb_friends',
												data: dataString,
												success: function(html){
													// window.location = '<?php echo base_url('dashboard'); ?>';
													setTimeout(function(){
														window.location = '<?php echo base_url('dashboard'); ?>';
													},500);
												}
											});
										
										});
								}
								else
								{
									/* New account created */
									$('#myModal_fb').html(
										'<div class="hero-unit" style="background: #383838;">'+
											'<h3 style="color: #ddd;font-family: \'ScalaSans Light\';">Thank you for signing up, '+fname+'</h3>'+
											'<p>'+
												'<a href="<?php echo base_url(); ?>dashboard" class="btn btn-primary btn-large" style="font-size: 14px;">START SELLING</a>'+
											'</p>'+
										'</div>');
								}
							}
						});
				} //end of else if
			}
		});
	});
	
	/* log-in submit */
		$('#signin_form')
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
					} else if(data.code == -4) {
						$('#myModal_validation_error').modal('show');
						$('#error_sign_up').html(
							'This account has been deactivated <br>'+
							'Please email us at <a href="mailto:info@bolooka.com">info@bolooka.com</a> for your concern'
						);
						return false;
					} else {
						if(data.code == undefined) {
							window.location = "<?php echo base_url(); ?>dashboard";
						} else {
							window.location.reload(true);
						}
					}
				}
			});
	/** **/
	
	/* -----------forgot password-------------- */
		$('#forgot_form').on('keypress',function(e){
			if(e.keyCode == 13)
			{
				$('#forgot_form').ajaxForm({
					beforeSubmit: function(formData, jqForm, options){
						var form = jqForm[0];
						if(form.emailf.value.match("^[_A-Za-z0-9-\\+]+(\\.[_A-Za-z0-9-]+)*@"+"[A-Za-z0-9-]+(\\.[A-Za-z0-9]+)*(\\.[A-Za-z]{2,})$") == null)
						{
							$('#emailf').focus();
							$('.forgot_error').html('Invalid Email!');
							$('.forgot_email_container').hide();
							return false;
						}
					},
					success: function(html){
						if(html == 0)
						{
							$('.forgot_error').html('Email not registered!');
						}else
						{
							$('#email_catch').val($('#emailf').val());
							$('.forgot_email_container').show();
							$('.forgot_error').html('');
							
						}
					}
				}).submit();
			}
		});

		$('#forgot_send').click(function(){
			
			$('#forgot_form').ajaxForm({
				beforeSubmit: function(formData, jqForm, options){
					var form = jqForm[0];
					if(form.emailf.value.match("^[_A-Za-z0-9-\\+]+(\\.[_A-Za-z0-9-]+)*@"+"[A-Za-z0-9-]+(\\.[A-Za-z0-9]+)*(\\.[A-Za-z]{2,})$") == null)
					{
						$('#emailf').focus();
						$('.forgot_error').html('Invalid Email!');
						$('.forgot_email_container').hide();
						reset_forms();
						return false;
					}
				},
				success: function(html){
					if(html == 0)
					{
						$('.forgot_error').html('Email not registered!');
					}else
					{
						$('#email_catch').val($('#emailf').val());
						$('.forgot_email_container').slideDown();
						$('.forgot_error').html('');
					}
				}
			}).submit();
		});

		$('.go_to_pass').click(function(){
			var eto = $(this);
			$(eto).button('loading');
			var email = $('#email_catch').val();
			var dataString = 'email='+email;
			
			$.ajax({
				type: "POST",
				url: "signin/emailSendPass",
				data: dataString,
				success: function(html){
					if(html == 1) {
						$(eto).button('reset');
						$('.forgot_email_container').slideUp();
						$('.forgot_error').html('Email sent');
						$('.forgot_error').css('color','green');
						reset_forms();
					} else {
						$('.forgot_error').html('Email not sent check your connection');
					}
				}
			});
		});
	/* ----------END OF FORGOT PASSWORD----------- */

	/* create you e-store script */
		$('#market-head').delegate('.ces_but', 'click', function() {
			var dataString;
			$.ajax({
				type: "POST",
				url: "shop/ces",
				data: dataString,
				success: function(html) {
					if(html == 1) {
						window.location.href = 'manage/webeditor';
					} else {
						$('#collapseTwo').collapse('show');
					}
				}
			});		
		});
	/* */
		function reset_forms() {
			var length = document.forms.length,
				element = null,
				arr = document.forms;
			for (var i = 0; i < length; i++) {
				element = arr[i];
				element.reset();
			}
		}
});
</script>
