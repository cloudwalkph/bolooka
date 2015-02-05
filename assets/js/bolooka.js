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
	
/********** **********/

});

/* Laiza account_settings.php */
function validateEmail(email) {
	var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	return re.test(email);
}

function deactivate_account(el)
{
	$('#myModal_deactivate').modal('hide');
	$('#myModal_deactivate_confirm').modal('show');
}

function deactivate_process()
{
	var user_id = $('.account_password').attr('id');
	var pass = $('.account_password').val();
	var dataString = 'uid='+user_id+'&pass='+pass;
	var base_url = $('#account_settings_base_url').val();
	
	if(pass == '')
	{
		$('.account_password').focus();
		$('.error_msg').html('Please enter your password');
		return false;
	}
	$.ajax({
		type: 'POST',
		url: base_url+'settings/deactivate_account',
		data: dataString,
		success: function(html){
			if(html == 'error')
			{
				$('.error_msg').html('Password did not match');
				$('.account_password').val('');
				$('.account_password').focus();
			}else
			{
				window.location = base_url+'logout';
			}
		}
	
	});
}

/* submit profile form */
$('#submitsett').click(function(e) {
	$("#form_sett").ajaxForm({
		beforeSubmit: function() {
			$('#submitsett').button('loading');				
		},
		success: function(html) {
			$('.message_to_user').html('');
			if(html == 'success'){
				$('.success_profile').show();
				$(window).scrollTop(0);
			}else if(html == 'fail1'){
				$('.message_to_user').html('Password did not match');
				$('.error_profile').show();
				$(window).scrollTop(0);
			}else if(html == 'fail2'){
				$('.message_to_user').html('New password cannot be blank');
				$('.error_profile').show();
				$(window).scrollTop(0);
			}else if(html == 'fail3'){
				$('.message_to_user').html('Current password did not match');
				$('.error_profile').show();
				$(window).scrollTop(0);
			}
			$('#submitsett').button('reset');
		}
		// $('#currPass').val('');
		// $('#newPass').val('');
		// $('#rePass').val('');
	});
});


window.fbAsyncInit = function() {
	FB.init({
		appId      : '203727729715737', // App ID
		// channelUrl : '//WWW.YOUR_DOMAIN.COM/channel.html', // Channel File
		status     : false, // check login status
		cookie     : true, // enable cookies to allow the server to access the session
		xfbml      : true  // parse XFBML
	});
	$('#fb_switch').click(function(){
		var eto = $(this);
		var base_url = $('#account_settings_base_url').val();
		if($('#status_fb').is(':checked') != true)
		{
			FB.login(function(response) {
			
				/* if fb user is authorized  */
				if (response.authResponse) {
					
					console.log('Welcome!  Fetching your information.... ');
					FB.api('/me', function(response) {
						console.log('Good to see you, ' + response.id + '.');
						
						/* check if fb user is already in bolooka user */
						$.post(base_url+"signup/connect_to_fb",
						{
							'id': response.id
						},function(html){
							if(html == 'meron')
							{
								/* sign out the fb account */
								// alert('Facebook account is already used by another bolooka user');
								$('#myModal_switch_fb').modal('show');
								FB.getLoginStatus(function(response) {
									if (response.status === 'connected') {
										FB.logout(function(response) {
											/* user is now logged out */
											$('#status_fb').removeAttr('checked');
										});
									}
								});
							}
							else
							{
								$('#status_fb').attr('checked','checked');
								$('.hide_this_fb').show();
								$('.check_out').attr('checked','checked');
							}							
						});
					});
					
				} else {
					console.log('User cancelled login or did not fully authorize.');
					$('#status_fb').removeAttr('checked');
				}
			},{scope: 'email,user_birthday,publish_stream,offline_access'});
		}else
		{
				$('#myModal_disconnect_fb').modal('show');
				return false;
		}
	});
	
	$('#fb_dis_button').click(function(){
		var base_url = $('#account_settings_base_url').val();
		var dataString = 'uid='+$('#account_settings_uid').val();
		// var dataString = 'uid=<?php echo $uid; ?>';
		$.ajax({
			type: "POST",
			url: base_url+'signup/disconnected_fb',
			data: dataString,
			success: function(html){
				FB.getLoginStatus(function(response) {
					if (response.status === 'connected') {
						var uid = response.authResponse.userID;
						var accessToken = response.authResponse.accessToken;
						
						/* tangal permission mo sa fb bolooka apps */
						FB.api('/me/permissions', 'delete', function() {
								console.log('permission deleted');
						});
						
						/* log out sa fb */
						FB.logout(function(response) {
							// user is now logged out
							$('#myModal_disconnect_fb').modal('hide');
							$('#status_fb').removeAttr('checked');
							$('.hide_this_fb').hide();
						});
						
					} else if (response.status === 'not_authorized') {
					  alert('User not authorized');
						/* the user is logged in to Facebook, 
						but has not authenticated your app */
					} else {

					/* the user isn't logged in to Facebook. */
					}
				});							
			}
		});		
	});
};

/* Load the SDK Asynchronously */
(function(d){
   var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
   if (d.getElementById(id)) {return;}
   js = d.createElement('script'); js.id = id; js.async = true;
   js.src = "//connect.facebook.net/en_US/all.js";
   ref.parentNode.insertBefore(js, ref);
 }(document));

// jQuery(function () {

	// twttr.anywhere(function (T) {
		// $('#twitter_switch').click(function(){
			// alert('asd');
			// if (T.isConnected()) {
				// $('#twitter_switch').attr('checked','checked');
				// twttr.anywhere.signOut();
			// }else{
				// $('#twitter_switch').removeAttr('checked');
				// T.signIn();
			// } 	
		// });
		
		// /* document ready twitter log in */
		// if (T.isConnected()) {
			
			// $('#twitter_switch').attr('checked','checked');
			
			// /* hover card */
			// var twitterLink = T.currentUser.data('screen_name');
			// $("#twitter_information").html('@'+twitterLink);
			// T("#twitter_information").hovercards({ infer: true });
		// }
		// else
		// {
			// $('#twitter_switch').removeAttr('checked');
			// $("#twitter_information").html('');
		// } 
		
		// /* after twitter log in */
		// T.bind("authComplete", function (e, user) {
			// if (T.isConnected()) {
				/* $('#twitter_switch').attr('checked','checked'); */
				// alert('conn');
			// } else {
				// alert('notconn');
				// $('#twitter_switch').removeAttr('checked');
				// $("#twitter_information").html('');
			// }
			// /* hover card */
			// var twitterLink = T.currentUser.data('screen_name');
			// $("#twitter_information").html('@'+twitterLink);
			// T("#twitter_information").hovercards({ infer: true });
		// });
		
		// /* after twitter log out */
		// T.bind("signOut", function (e) {
			// $('#twitter_switch').removeAttr('checked');
			// $("#twitter_information").html('');
		// });	
	// });
// });

/*dashboard*/
var bSuppressScroll = false;
$(function() {
	loadfeeds();
	function last_msg_funtion() 
	{
		var dashboard_uid = $("#dashboard_uid").val();
		var dashboard_base_url = $("#dashboard_base_url").val();
		var ID = $(".post_item:last").attr("alt");
		var	dataString3 = 'uid='+dashboard_uid+'&lastId='+ID;
		//alert(ID+ ' '+dataString3);
		$.ajax({
			beforeSend: function() {
				$('.loading-bar').empty().html('<p style="text-align: center;"><img src="'+dashboard_base_url+'img/ajax-loader.gif" /></p>');
			},
			type: "POST",
			url: dashboard_base_url+"dashboard/wallsSecond",
			data: dataString3,
			success: function(html)
			{
				if(html != 'lana')
				{
						window.bSuppressScroll = false;
						$(".post_item:last").after(html);
						$('.loading-bar').empty();
						// $('.loading-bar').html('<button class="span12 btn btn-primary s-more">Show more &#9660;</button>');
						
						/* carousel */
						var width = $('.photoslider').width() / 2;
					$('.photoslider').flexslider({
						animation: "slide",
						controlNav: false,
						animationLoop: false,
						slideshow: false,
						itemWidth: 411,
						itemMargin: 5,
						minItems: 2,
						maxItems: 4,
						move: 1,
						smoothHeight: true
					});

				}
				else
				{
					$('.loading-bar').empty();
					$('.loading-bar').html('<h5>No more post</h5>');
				}
			}
		}); 
	};
	
$(window).scroll(function(){
	var winScroll = $(window).scrollTop();
	var docuHeight = $(document).height();
	var winHeight = $(window).height();			
	var docuHeight_winHeight = docuHeight - winHeight;

	if(winScroll + 100 >= docuHeight_winHeight)
	{
		if(window.bSuppressScroll == false)
		{
			last_msg_funtion();
		
			window.bSuppressScroll = true;
		}
	}
});

function loadfeeds() {
	var dashboard_uid = $("#dashboard_uid").val();
	var dashboard_base_url = $("#dashboard_base_url").val();
	var dataString = 'uid=' + dashboard_uid;
	$.ajax({
		type: "POST",
		url: dashboard_base_url+"dashboard/walls",
		data: dataString,
		beforeSubmit: function() {
			$('#dash-content').html('<p style="text-align: center;"><img src="'+dashboard_base_url+'img/ajax-loader.gif" /></p>');
		},
		success: function(html) {
			if(html == '0')
			{
				$('#dash-content').empty();
				$('.no-feeds').show();
			}
			else
			{
				$('#dash-content').empty();
				$('#dash-content').html(html);
				$('.loading-bar').show();
				$('.photoslider').flexslider({
					animation: "slide",
					controlNav: false,
					animationLoop: false,
					slideshow: false,
					itemWidth: 411,
					itemMargin: 5,
					minItems: 2,
					maxItems: 4,
					move: 1,
					smoothHeight: true
				});
			}
		}
	}); 
}

$('.cover')
	.delegate('.btn_follow', 'click', function(){
	var dashboard_uid = $("#dashboard_uid").val();
	var dashboard_base_url = $("#dashboard_base_url").val();
	var el = $(this),
		ep = $(this).parent(),
		wid = ep.attr('alt');
		
	if(ep.attr('id') == 'uf') {
		var datastring23 = 'userid='+dashboard_uid+'&website='+wid;
		$.ajax({
			type:"POST",
			url: dashboard_base_url+"test/unfollow",
			data:datastring23,
			success: function(html) {
				ep.attr('id', 'ff');
				el.removeClass('btn-danger').addClass('btn-success');
			}
		});
	} else if(ep.attr('id') == 'ff') {
		var datastring23 = 'userid='+dashboard_uid+'&website='+wid;
		$.ajax({
			type:"POST",
			url: dashboard_base_url+"test/unfollow",
			data:datastring23,
			success: function(html){
				ep.attr('id', 'uf');
				el.removeClass('btn-success').addClass('btn-danger');
			}
		});		
	}
});

$('.cover')
.on('mouseenter', '.btn_follow', function( event ) {
	var ep = $(this).parent();
	if(ep.attr('id') == 'uf') {
		$(this).addClass('btn-danger');
	} else if(ep.attr('id') == 'ff') {
		$(this).addClass('btn-success');
	}
})
.on('mouseleave', '.btn_follow', function( event ) {
	var ep = $(this).parent();
	if(ep.attr('id') == 'uf') {
		$(this).removeClass('btn-danger');
	} else if(ep.attr('id') == 'ff') {
		$(this).removeClass('btn-success');
	}
});
});



/* Marketplace */
$('#msy-web').click(function(ev,ui) {
	var marketplace_base_url = $("#marketplace_base_url").val();
	var marketplace_group_id = $("#marketplace_group_id").val();
	if(ev.ctrlKey == true ) {
		if(confirm("Are you sure you want to delete")) {
			var xmlhttp;
			if (window.XMLHttpRequest)
			  {// code for IE7+, Firefox, Chrome, Opera, Safari
			  xmlhttp=new XMLHttpRequest();
			  }
			else
			  {// code for IE6, IE5
			  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			  }
			xmlhttp.onreadystatechange=function()
			  {
			  if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{
					var data = xmlhttp.responseText;
					location.href = 'manage/market';
				}
			  }
			xmlhttp.open("POST",marketplace_base_url+"manage/market/delete",true);
			xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xmlhttp.send("market_id="+marketplace_group_id);
		}
	}
});

/*user_manager*/
$(function() {
	$('#contentArea').delegate('.add_user', 'click', function() {
		$('#user_input').show();
	});
	
	$('.search_user').click(function(){
		var user_manager_base_url = $('#user_manager_base_url').val();
		var user_manager_group_id = $('#user_manager_group_id').val();
		var key = $('#email_role').val();
		var dataString = { 'item': key, 'group_id': user_manager_group_id };
		$.ajax({
			type: "POST",
			url: user_manager_base_url+'test/add_role',
			data: dataString,
			success: function(html) {
				$('#search').html(html);
				var windowH = $('table').height();	
				setTimeout(function(){
					$('html, body').animate({ scrollTop: windowH });
				},500);
			}
		});		
	});

	$('.on_add').click(function(){
		var uid = $(this).attr('alt');
		var user_manager_base_url = $('#user_manager_base_url').val();
		var user_manager_group_id = $('#user_manager_group_id').val();
		var type = $(this).parent().parent('tr').children('td').children('.role_type').val();
		
		var dataString = 'uid='+uid+'&type='+type+'&group_id='+user_manager_group_id;
		$.ajax({
			type: "POST",
			url: user_manager_base_url+'test/add_user_role',
			data: dataString,
			success: function(html) {
				$('.add'+uid).parent().parent().fadeOut(1000);
			}
		});
	});

	$('.on_edit').click(function(){
		$(this).html('save');
		$(this).removeClass('on_edit');
		$(this).addClass('on_save');
		$(this).parent().parent('tr').children('.role_status').html(
							'<select class="role_type">'+
								'<option value="1">Administrator</option>'+
								'<option value="2">Moderator</option>'+
								'<option value="3" selected>Member</option>'+
							'</select>'
		);
	});

	$('.on_delete').click(function(){
	
		var user_id = $(this).attr('alt');
		var pass_id = $('.delete_alert').attr('alt',user_id);
		$('#myModal_user_role').modal('show');

	});
	
	$('.delete_alert').click(function(){
		var user_id = $(this).attr('alt');
		var dataString = 'uid='+user_id;
		var user_manager_base_url = $('#user_manager_base_url').val();
		
		$.ajax({
			type: "POST",
			url: user_manager_base_url+'test/delete_role',
			data: dataString,
			success: function(html) {
				window.location.href = user_manager_base_url+'manage/market/user';
			}
		});	
	});
	
	$('#on_save').click(function(){
		$(this).html('edit');
		$(this).removeClass('on_save');
		$(this).addClass('on_edit');
	
		var user_id = $(this).attr('alt');
		var role_type = $(this).parent().parent('tr').children('.role_status').children('.role_type').val();
		var event = $(this).parent().parent('tr');
		var user_manager_base_url = $('#user_manager_base_url').val();
		var user_manager_group_id = $('#user_manager_group_id').val();
		
		var dataString = 'uid='+user_id+'&role_type='+role_type+'&group_id='+user_manager_group_id;	
		
		$.ajax({
			type: "POST",
			url: user_manager_base_url+'test/edit_role',
			data: dataString,
			success: function(html) {
				$(event).children('.role_status').html(html);
			}
		});		
	});
});

/*website.php*/

$(function(){
	$('#tooltip_create_button').tooltip({
		html: true,
		trigger: 'click',
		title: 'You have exceeded your website creation limit. Please contact us for more info.',
		delay: { show: 500, hide: 100 }
	});
	$('#website').delegate('.deleteWebsite', 'click', function(e) {
		if(e.shiftKey == true) {
			$.ajax({
				'url': 'manage/del_web',
				'data': {'website_id': $(e.target).attr('alt')},
				'beforeSend': function(a,b,c) {
				},
				'success': function(html) {
					$(e.target).parents('tr').slideUp();
				}
			});
		} else {
			var webId = $(this).attr('alt');
			$('.website_id').val(webId);
			$('#myModal_delete_website').modal('show');
			$('#dwyes').removeAttr('disabled');
			$('#dwyes').text('Yes');
		}
	});
	
	$('#delete_website').ajaxForm({
		url: 'manage/delete_website',
		beforeSubmit: function(formData, jqForm, options) {
			$('#dwyes').attr('disabled','disabled');
			$('#dwyes').html('Loading...');
		},
		success: function(html) {
			location.reload();
		}
	});
	
	$('.restore_website').on('click', function(ev) {
		var website_base_url = $('#website_base_url').val();
		var site_id = $(this).attr('alt'),
			el = $(this);
		$.ajax({
			url: website_base_url+'manage/restore_website',
			type: 'post',
			data: { 'website_id': site_id },
			beforeSend: function() {
				el.parent().hide();
			},
			success: function(html) {
				location.reload();
			}
		});
		ev.stopPropagation();
	});
		
	/* // clear latest tab stored */
	sessionStorage.setItem('lastTab', 'details');
	
	$('.tooltip_sitename').tooltip();

	$('.on_approve').click(function() {	
		var market_website_base_url = $('#market_website_base_url').val();
		var element = $(this);
			web_id = $(this).parents('.asd').attr('id'),
			dataString = { wid: web_id };
			console.log(dataString);
		$.ajax({
			type: "POST",
			url: market_website_base_url+'test/approve_web',
			data: dataString,
			success: function(data) {
				element.addClass('btn-success').text('approved');
			}
		});
	});

	$('.on_reject').click(function() {
		var market_website_base_url = $('#market_website_base_url').val();
		var tr = $(this).parents('.asd'),
			trwid = tr.attr('id'),
			dataString = { 'wid': trwid };
		$.ajax({
			type: "POST",
			url: market_website_base_url+'test/remove_web',
			data: dataString,
			success: function(data) {
				tr.slideUp().remove();
			}
		});
	});

	$('#search_website')
		.bind('keyup',function(e) {
			var market_website_base_url = $('#market_website_base_url').val();
			var marketgroup_id = $('#marketgroup_id').val();
			var x = $(this).val();
			var content = $(this).attr('alt');
			var dataString = { 'content': content, 'search_by': x, 'group_id': marketgroup_id };
			if(e.keyCode == 13)
			{
				$.ajax({
					type: "POST",
					url: market_website_base_url+'test/search_web',
					data: dataString,
					success: function(html) {
						$('.market_table').html(html);
					}
				});
			}
		})
		.click(function() {
			$('.detectName').css('color','#EAB82E');
			setTimeout(function(){
				$('.detectName').css('color','#777');
			},1000);
		});
	
	$('.market_table').delegate('.on_notify','click', function(e) {
		var market_website_base_url = $('#market_website_base_url').val();
		var marketgroup_id = $('#marketgroup_id').val();
		var tr = $(this).parents('.asd');
		var trwid = tr.attr('id');
		var dataString = { 'wid': trwid, 'group_id': marketgroup_id };
		$.ajax({
			type: "POST",
			url: market_website_base_url+'test/on_invite',
			data: dataString,
			success: function(data) {
				if(data == 'success') {
					$(e.target).text('pending').addClass('disabled').removeClass('on_notify');
				}
			}
		});	
	});
	
	$('#search_filter').change(function() {
		var market_website_base_url = $('#market_website_base_url').val();
		var marketgroup_id = $('#marketgroup_id').val();
		var market_website_page_invite_approval = $('#market_website_page_invite_approval').val();
		var val = $(this).val();
		var content = market_website_page_invite_approval;
		var dataString = 'content='+content+'&filter_by='+val+'&group_id='+marketgroup_id;
		$.ajax({
			type: "POST",
			url: market_website_base_url+'test/filter_web',
			data: dataString,
			success: function(html) {
				$('.market_table').html(html);
			}
		});	
	});
	
	function market_product_load_jquery(){
		$('#prod_list').delegate('.prod','click', function(event) {
			var market_product_base_url = $('#market_product_base_url').val();
			var prodId = this.id;
			$(this).children('.offprod').css('display','block');
			$(this).children('.prod_info').css('opacity','0.5');
			$(this).removeClass('prod').addClass;
			$.post( market_product_base_url+'dashboard/moderateProd', {'prodId':prodId, 'action':'disable'},
			function( data ) {
				
			});
		});
	  
		$('#prod_list').delegate('.offprod', 'click', function(event) {
			var prodId = $(this).parent().attr('id');
			$(this).css('display','none');
			$(this).parent().addClass('prod');
			$(this).parent().children('.prod_info').css('opacity','1');
			$.post( market_product_base_url+'dashboard/moderateProd', {'prodId':prodId,'action':'enable'},
			function( data ) {

			});
		});
	}
	
	// market_product_load_jquery();
	
});

$('document').ready(function(e) {
	
	var options = {
		'backdrop':'true',
		'show': false
	};
	$('#contact-modal').modal(options);

	$('#contactForm').submit(function(e) {
		$('#contact-modal').modal('show');
	});
	
	$('#contactSubmit').click(function(e) {
		$('#contact-modal').modal('hide');
		$('#contactForm').ajaxForm({
			// data: {},
			beforeSubmit: function(formData, jqForm, options){

			},
			success: function(html) {
				if(html == 1) {
					$('#alertbox').html('<div class="alert alert-success fade in"><button data-dismiss="alert" class="close" type="button">&times;</button><strong>Email Sent!</strong> We will review your message and get back to you as soon as possible.</div>');
					setTimeout(function () { $('.alert-success').alert('close') }, 5000);
					contactForm.reset();
				}
			}
		}).submit();
	
		if (!e) var e = window.event;
		e.cancelBubble = true;
		if (e.stopPropagation) e.stopPropagation();
	});
});