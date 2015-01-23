/* Bolooka JavaScripts */
$(function () {

	/* reload page in tab focus */
		// window.addEventListener('focus', function() {
			// window.location.reload();
		// });
	/* */
	
	/* File Upload Script with Bootstrap Design */
		$('.fileupload_form').fileupload({
			replaceFileInput: false,
			dataType: 'json',
			uploadTemplateId: '',
			downloadTemplateId: '',
			add: function (e, data) {
				this.$element = $(e.target).find('.fileupload');
				this.$input = data.fileInput;
				this.$hidden = this.$element.find('a.fileupload-exists');
				// this.name = this.$hidden.attr('name')
				
				// if(this.$hidden.attr('name') != null) 
					// this.$input.attr('name', this.name)
					// this.$hidden.attr('name', '')
				console.log(this.$input);

				if(data.files[0].size < 2097152) {
					previewPhoto(data);
					$(data.fileInput).parents('.fileupload').addClass('fileupload-exists').removeClass('fileupload-new');
					$(data.fileInput).parents('.fileupload').find('.help-inline').text('');
				} else {
					this.$input.val('');
					$(data.fileInput).parents('.fileupload').addClass('fileupload-new').removeClass('fileupload-exists');
					$(data.fileInput).parents('.fileupload').find('.help-inline').text('File size exceeded.').show().fadeOut(5000);
				}
			},
			done: function (e, data) {
				// data.context.text('Upload finished.');
			}
		});
		
		$('a.fileupload-exists').click(function(e) {
			this.$element = $(e.target).parents('.fileupload');
			this.$preview = this.$element.find('.fileupload-preview');
			this.$filename = this.$element.find('.fileupload-filename');
			this.$hidden = this.$element.find('a.fileupload-exists');
			this.$input = this.$element.find(':file');
			// this.name = this.$input.val('name');
			// this.$hidden.attr('name', this.name);
			
			// this.$input.attr('name', '');
			
		  this.$input.val('');
		  this.$preview.html('');
		  this.$filename.html('');
		  this.$element.addClass('fileupload-new').removeClass('fileupload-exists');
		  this.$element.find('.help-inline').text('File size exceeded.').text('');
		  return false;
		});

		function previewPhoto(data) {
			for (var i = 0, f; f = data.files[i]; i++) {
			  if (!f.type.match('image.*')) {
				continue;
			  }
			  var reader = new FileReader();
			  reader.onload = (function(theFile) {
				return function(e) {
				  /* for image view */
				  var span = document.createElement('span');
				  span.innerHTML = ['<img src="', e.target.result,
									'" title="', escape(theFile.name), '"/>'].join('');
				  $(data.fileInput).parents('.fileupload').find('.fileupload-preview').html(span);
				  
				  /* for filename view */
				  var imageName = document.createElement('span');
				  imageName.innerHTML = [escape(theFile.name)].join('');
				  $(data.fileInput).parents('.fileupload').find('.fileupload-filename').html(imageName);
				};
			  })(f);
			  reader.readAsDataURL(f);
			}
		}
	/* */
	
	/* bootstrap colorpicker */
		$('.color-picker')
			.colorpicker({
				format: 'rgba'
			})
			.on('changeColor', function(ev) {
			/* ev.parentNode.backgroundColor = ev.color.toHex(); */
			});
	/* */
	
	/* (signtop.php) - start */
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

/********** (signtop.php) - end **********/

/*  */

/*  */
});
	