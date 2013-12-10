<?php
	
	$logged = $this->session->userdata('logged_in');
	if(isset($logged))
	{
		$uid = $this->session->userdata('uid');
		$this->db->where('uid',$uid);
		$query = $this->db->get('users');
		$row = $query->row_array();
	}
?>

<style>
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
#caption {
    color: white;
    /* margin-top: 40px; */
    text-shadow: -1px -1px 0 #999999, 1px -1px 0 #999999, -1px 1px 0 #999999, 1px 1px 0 #999999;
}
.sign_up_words {
	font-family: Segoe UI;
	font-size: 19px;
	color: #fff;
}
.get_free_button {
    font-family: 'Segoe UI';
    font-size: 19px;
    height: 44px;
}
.social_log_in_border li {
    border-bottom: 1px solid #F4F4F4;
    border-top: 1px solid #F9F9F9;
}
.social_log_in_border li a {
	color: #2b8ad3;
	font-size: 10px;
	font-family: Segoe UI;
}
.social_log_in_border li a img {
	margin-right: 10px;
}
.carousel .item {
	height: 500px;
}
.carousel img {
	width: auto;
	height: 500px;
}
.carousel-control {
    top: 55%;
}
.partners:hover {
	filter: url("assets/css/filters.svg#Matrix");
	-webkit-filter: grayscale(0);
}
.font_resize_mobile {
	font-size: 52px; 
	font-family: 'ScalaSans';
}
#videowatch {
	background-image: url("https://img.youtube.com/vi/XV9tO4KPG3o/0.jpg"); 
	position: relative; 
	cursor: pointer; 
	box-shadow: 0px 7px 15px -5px black; 
	height: 354px;
}
.marketplace_picture {
	background-image: url("img/homepage/marketplace_cover2.jpg"); 
	box-shadow: 0px 7px 15px -5px black; 
	border-radius: 3px 3px 3px 3px; 
	position: relative; 
	background-size: cover; 
	height: 354px; 
	background-position: center center;
}


/* RESPONSIVE */
@media (min-width: 768px) and (max-width: 979px) {
	.container.navbar-wrapper {
		margin-bottom: 0;
		width: auto;
	}
	.carousel .item {
		height: 500px;
	}
	.carousel img {
		width: auto;
		height: 500px;
	}
}

@media (max-width: 767px) {
	.carousel .item {
		height: 300px;
	}
	.carousel img {
		height: 300px;
	}
}

@media (max-width: 480px) { 
	.carousel-control {
		top: 20%;
	}
}

/* --------------------android tablet 800px------------- */
@media (max-width: 800px) {
	.get_free_button {
		height: auto;
	}
	.carousel-caption {
		top: 60px !important;
	}
	.fb_sign_up_button {
		margin-top: 10px;
	}
	.sign_up_container_padding {
		width: 100% !important;
	}
}
/* --------------------end tablet----------------------- */

/* --------------------ipad tablet 769px---------------- */
@media (max-width: 769px) {
	.carousel-caption {
		position: static;
	}
	.carousel-control {
		top: 19%;
	}
	#caption {
		display: none;
	}
	#videowatch {
		height: 500px;
		background-repeat: no-repeat;
		background-size: 100% 100%;
		margin-bottom: 20px;
	}
	#signin_form {
		text-align:left;
	}
	#signin_form #email {
		margin-bottom: 10px;
	}
	#signin_form #password {
		margin-bottom: 10px;
	}
	.controls.row-fluid .phone_view_password {
		margin-bottom: 10px;
	}
	.marketplace_button_content {
		top: 3% !important;
	}
}
/* --------------------end tablet----------------------- */

/* --------------------Samsung tablet 600px------------- */
@media (max-width: 600px) {
	
	#videowatch {
		height: 407px;
	}
}
/* --------------------End samsung---------------------- */

/* -------------------for moblie phone 322px------------ */

@media (max-width: 322px) {
	.carousel-control {
		top: 14%;
	}
	.font_resize_mobile {
		font-size: 40px; 
	}
	.get_free_button {
		height: auto;
	}
	.carousel-caption {
		padding: 0;
	}
	#videowatch {
		height: 197px;
		background-repeat: no-repeat;
		background-size: 100%;
		margin-bottom: 20px;
	}	
	.marketplace_picture {
		height: 197px;
		background-repeat: no-repeat;
		background-size: 100% 100%;
	}
	.font_resize_mobile {
		font-size: 40px; 
	}
	#caption {
		padding: 10px 0;
	}
	.carousel img {
		height: 158px;
	} 
	.carousel .item {
		height: 158px;
	}
}

/* -------------------end phone-------------------------- */

/* ------------------other view tablet------------------- */
@media (max-width: 1216px) {
	.get_free_button {
		height: auto;
		padding: 3px 12px;
	}
	.fb_sign_up_button {
		margin-top: 10px;
	}
}
/* ------------------end other tablet-------------------- */

#play_btn {
    background-color: rgba(255, 255, 255, 0.5);
    border: 4px solid rgb(221, 221, 221);
    border-radius: 40px 40px 40px 40px;
    bottom: 0;
    font-size: 50px;
    height: 50px;
    left: 0;
    line-height: 50px;
    margin: auto;
    padding: 10px;
    position: absolute;
    right: 0;
    text-align: right;
    top: 0;
    width: 50px;
}
#play_btn:hover {
	border: 8px solid rgb(221, 221, 221);
	color: #555;
}

/* slideshow */
#tech-slideshow {
    height: 200px;
    position: relative;
    overflow: hidden;
}
#tech-slideshow > div {
    height: 200px;
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    
    -moz-transition:  opacity 0.5s ease-out; 
       -o-transition: opacity 0.5s ease-out; 
  -webkit-transition: opacity 0.5s ease-out; 
      -ms-transition: opacity 0.5s ease-out; 

    -webkit-animation: moveSlideshow 60s linear infinite;
    -moz-animation:    moveSlideshow 60s linear infinite;
    
}

@-webkit-keyframes moveSlideshow {
    0% { left: 0; }
    100% { left: -870px; }
}
@-moz-keyframes moveSlideshow {
    0% { left: 0; }
    100% { left: -870px; }
}
/* */

</style>
<div style="padding-bottom: 200px;">
	<div id="fb-root"></div>
	<script>
		window.fbAsyncInit = function() {
		  FB.init({
			appId      : '203727729715737', // App ID
			// channelUrl : '//WWW.YOUR_DOMAIN.COM/channel.html', // Channel File
			status     : false, // check login status
			cookie     : true, // enable cookies to allow the server to access the session
			xfbml      : true  // parse XFBML
		  });
		  
			// listen for and handle auth.statusChange events
			FB.Event.subscribe('auth.statusChange', function(response) {
				if (response.authResponse) {
					// user has auth'd your app and is logged into Facebook
					FB.api('/me', function(me) {
						
					});
				} else {
					/* user has not auth'd your app, or is not logged into Facebook */
				}
			});
			
			/* facebook buttom click */
			$('#fb_login').on('click',function(){
				FB.login(function(response) {
					console.dir(response);
				   if (response.authResponse) {
					 console.log('Welcome!  Fetching your information.... ');
					 FB.api('/me', function(me) {
					   console.log('Good to see you, ' + me.name + '.');
					   if (me) {
							$.post("signup/facebook",
								{
									'id': me.id,
									'first_name': me.first_name,
									'email': me.email,
									'last_name': me.last_name,
									'gender': me.gender,
									'bdays': me.birthday
								},
								function(html)
								{
									if(html == 'create new account')
									{
										$('#social_id').val(me.id);
										$('#loginType').val('facebook');
										/* check if email exist */
										var dataParams = 'email='+me.email;
										$.ajax({
											type: "POST",
											url: '<?php echo base_url(); ?>signup/fbcheckEmail',
											data: dataParams,
											success: function(html) {
												if(html == 'email rejected')
												{
													$('#social_email').val('');
													$('#social_first').val(me.first_name);
													$('#social_last').val(me.last_name);
													
												} else {
													$('#social_email').val(me.email);
													$('#social_first').val(me.first_name);
													$('#social_last').val(me.last_name);
												}
											}
										});
										/* show modal */
										$('#myModal_social').modal('toggle');
									}else
									{
										window.location = '<?php base_url(); ?>dashboard';
									}
									
								});
						}
					 });
				   } else {
					 console.log('User cancelled login or did not fully authorize.');
				   }
				}, {scope: 'email,user_birthday,publish_stream,offline_access'});
			});
		};
		/* Load the SDK Asynchronously */
		  (function() {
			var e = document.createElement('script'); e.async = true;
			e.src = document.location.protocol +
			  '//connect.facebook.net/en_US/all.js';
			document.getElementById('fb-root').appendChild(e);
		  }());
	</script>

		<!-- Carousel ================================================== -->
		<div id="myCarousel" class="carousel slide carousel-fade" style="margin-bottom: 0;">
			<div class="carousel-inner">
				<div class="item active">
					<img src="<?php echo base_url() ?>img/homepage/slide_01.jpg" alt="" style="width: 100%">
				</div>
				<div class="item">
					<img src="<?php echo base_url() ?>img/homepage/slide_02.jpg" alt="" style="width: 100%">
				</div>
				<div class="item">
					<img src="<?php echo base_url() ?>img/homepage/slide_03.jpg" alt="" style="width: 100%">
				</div>
			</div>
			<div class="carousel-caption" style="background-color: transparent; top: 120px;">
				<div class="row-fluid">
				<div class="container">
					<div class="span6">
						<div id="caption" class="offset1 span10" style="font-size: 30px;">
							<span style="font-size: 48px; font-family: 'Champagne&Limousines';"> Easy </span>
							<span style="font-size: 52px; font-family: 'ScalaSans';"> ONLINE Selling</span>
							<span style="font-size: 48px; font-family: 'Champagne&Limousines';"> for </span>
							<span style="font-size: 52px; font-family: 'ScalaSans'"> LOCAL </span>
							<span class="font_resize_mobile"> Entrepreneurs </span>
						</div>
					</div>
	<?php
		if(!$logged)
		{
	?>
					<div class="span6 sign_up_move">
						<div class="row-fluid">
							<div class="span10 offset1">
								<div class="pull-right span9 sign_up_container_padding" style="background: none repeat scroll 0% 0% rgba(0, 0, 0, 0.4); padding: 25px;">
									<?php
										$signup_form_attrib = array(
												'name' => 'sign_up1step',
												'id' => 'sign_up1step',
												'class' => 'form-inline',
												'style' => 'margin: 0;'
											);
										echo form_open(base_url('signup/first_sign_up'),$signup_form_attrib);
									?>
										<div class="control-group">

												<label class="sign_up_words">Sign up and create a website</label>

										</div>
										<div class="control-group">
											<div class="controls row-fluid">
												<input type="text" class="span12 minus_heightMarginBottom_input" name="email1" id="email1" placeholder="Email address" style="font-family: 'Segoe UI'; font-size: 16px; color: rgb(84, 84, 84);">
											</div>
										</div>
										<div class="control-group">
											<div class="controls row-fluid">
												<div class="span6">
													<input type="password" class="span12 minus_heightMarginBottom_input phone_view_password" name="pass1" id="pass1" placeholder="Password" style="font-family: 'Segoe UI'; font-size: 16px; color: rgb(84, 84, 84);">
												</div>
												<div class="span6">
													<input type="password" class="span12 minus_heightMarginBottom_input" name="pass2" id="pass2" placeholder="Retype password" style="font-family: 'Segoe UI'; font-size: 16px; color: rgb(84, 84, 84);">
												</div>
											</div>
										</div>
										<div class="row-fluid" style="text-align: center;">
											<button class="btn btn-primary btn-large get_free_button" id="sign_up" type="submit">GET FREE E-STORE NOW</button>
										</div>
			<?php
								echo form_close();
			?>
									<div style="font-family: 'Segoe UI'; font-size: 18px; color: rgb(255, 255, 255); text-align: center; margin-bottom: 6px;" id="or_seperator">or</div>
									<div style="text-align: center;">
										<div id="fb_login" class="fb_bg" style="font-family: 'lucida grande',tahoma,verdana,arial,sans-serif; color: rgb(255, 255, 255); cursor: pointer;">
											<span style="border-right: 1px solid rgb(94, 114, 157); font-weight: 600; vertical-align: middle; font-size: 24px; padding: 0px 6px;"> f </span>
											<span style="border-left: 1px solid rgb(133, 152, 192); vertical-align: middle; text-shadow: -1px -1px 0px rgb(86, 105, 145); font-size: 14px; font-weight: 600; padding: 6px 10px;"> Sign in with Facebook </span>
										</div>

										<div class="btn-group fb_sign_up_button">
											<button class="btn btn-mini btn-inverse dropdown-toggle" data-toggle="dropdown" style="padding: 5px;">
												<span style="font-size: 20px; vertical-align: middle;"> &#9660; </span>
											</button>
											<ul class="dropdown-menu pull-right social_log_in_border" style="text-align: left; max-width: 128px; padding: 0px; border-radius: 0px 0px 0px 0px;">
											<!-- dropdown menu links -->
												<li><?php $this->load->file('api/Yahoo_Oauth_YOS/index.php'); ?></li>
												<li><?php $this->load->file('api/google-api-php-client/examples/userinfo/index.php'); ?></li>
												<li style="cursor: pointer;"><?php $this->load->file('api/liveservices-LiveSDK-2b505a1/Samples/PHP/OauthSample/default.html'); ?></li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
	<?php
		}
	?>
				</div>
				</div>
			</div>
			<a class="left carousel-control" href="#myCarousel" data-slide="prev">&lsaquo;</a>
			<a class="right carousel-control" href="#myCarousel" data-slide="next">&rsaquo;</a>
		<!-- /.carousel -->
		</div>
		
	<!-- video and marketplace link-->
	<div class="row-fluid" style="background-color: rgb(248, 248, 248);border-bottom: 1px solid #DDD;">
			<div class="container" style="padding-top: 30px; padding-bottom: 30px;">
				<div class="span6">
					<div class="row" style="margin: auto;">
						<div class="span10 offset1" id="video">
							<div id="videowatch">
								<div id="play_btn">
									<span>&#9654;</span>
								</div>
							</div>
						</div>
						<script>
							document.getElementById('videowatch').onclick = function() {
								var wvideo = $('#videowatch').width();
								var hvideo = ($('#videowatch').height());
								document.getElementById('video').innerHTML = '<iframe type="text/html" width="'+wvideo+'" height="'+hvideo+'" src="http://www.youtube.com/embed/XV9tO4KPG3o?autoplay=1" frameborder="0" ></iframe>';
							};
						</script>
					</div>
				</div>
				<div class="span6">
					<div class="row" style="margin: auto;">
						<a href="<?php echo base_url('marketplace'); ?>" target="_marketplace">
							<div class="span10 offset1 marketplace_picture">
								<!--<button class="btn btn-large btn-block btn-primary" type="button" style="bottom: 2%;position: absolute;">VIEW OUR MARKETPLACE</button>-->
								<div class="row-fluid marketplace_button_content" style="position: absolute; top: 9%;">
									<div class="offset1 span10 btn btn-large btn-block btn-primary marketplace_button">VIEW OUR MARKETPLACE</div>
								</div>
							</div>
						</a>
					</div>
				</div>
			</div>
	</div>

	<!-- See why Bolooka.. -->
	<div class="row-fluid">
		<div style="border-top: 1px solid white;position: relative;box-shadow: 0px 12px 11px -16px;">
			<div class="row-fluid">
				<p style="font-family: 'ScalaSans Light'; text-align: center; margin: 23px 0px 39px; font-size: 32px; line-height: 1;">See why Bolooka is for local merchants</p>
				<div class="container" style="padding-top: 2; padding-bottom: 2%;">
					
					<div class="span3 offset1" style="text-align: center;">
						<img src="<?php echo base_url('img/create_website_image.png'); ?>">
						<h4 style="font-family: 'Segoe UI bold';margin-bottom: 0;font-size:16px;">Create a Website</h4>
						<p style="font-family: 'Segoe UI Semibold';color:#5f5f5f;font-size:12px;line-height: 1.2;">Simple, clean and fast</p>
					</div>
					<div class="span4" style="text-align: center;">
						<img src="<?php echo base_url('img/post_marketplace_image.png'); ?>">
						<h4 style="font-family: 'Segoe UI bold';margin-bottom: 0;font-size:16px;">Post in Marketplace</h4>
						<p style="font-family: 'Segoe UI Semibold';color:#5f5f5f;font-size:12px;line-height: 1.2;">Let shoppers see your products</p>
					</div>
					<div class="span3" style="text-align: center;">
						<img src="<?php echo base_url('img/connect_sale_image.png'); ?>" style="height: 83px;">
						<h4 style="font-family: 'Segoe UI bold';margin-bottom: 0;font-size:16px;">Connect and Sell</h4>
						<p style="font-family: 'Segoe UI Semibold';color:#5f5f5f;font-size:12px;line-height:1.2;">Get connected with shoppers who are interested in your products</p>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Partner Organizations -->
	<div class="row-fluid" style='background-image: url("img/homepage/merchants_bg.jpg"); border-bottom: 1px solid rgb(255, 255, 255); height: 196px; overflow: hidden;'>
		<!--
		<div class="container">
				<div style="font-family: 'ScalaSans Light'; text-align: center; margin: 23px 0px 0px; font-size: 28px; line-height: 1;">Partner organizations that support local merchants</div>
				<div class="row-fluid" style="padding-top: 2%; padding-bottom: 2%;">
					<div class="offset4 span2 logo_center text-center">
						<a href="<?php //echo base_url(); ?>emporium" target="_marketplace" class="partners gray" id="upissi" style='height: 104px; width: 104px; display: inline-block; outline: medium none;'>
							<img src="<?php //echo base_url(); ?>img/upissi_logo_color1.png" style="max-width: 104px; max-height: 104px;">
						</a>
					</div>
					<div class="span3 logo_center text-center">
						<a class="partners gray" id="entrepneg" style='background-image: url("img/entrep_logo_colors.png"); display: inline-block; height: 105px; width: 207px;'></a>
					</div>
				</div>
		</div>
		-->
		<?php $this->load->view('homepage/scroll_content'); ?>
	</div>

	<!--Sign up form modal-->
	<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" style="background: #383838;width: 290px;left:60%;">
		<!--<a class="close" data-dismiss="modal" aria-hidden="true">&times;</a>-->
		<div class="modal-header title_message">
			<h3 id="myModalLabel" style="color: #ddd;font-family: 'ScalaSans Light';">Welcome to Bolooka!</h3>
		</div>
		<div class="modal-body">
			<p style="color: #ddd;font-family: 'ScalaSans Light';">Please complete remaining fields</p>
			<?php echo $this->load->view('homepage/sign_up_form'); ?>
		</div>
	</div>

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
	<div id="myModal_social" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" style="width: 268px;left:60%;border-radius:0;background: #383838;">
		<div class="modal-header title_message" style="border-bottom:0;">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="padding: 2px 6px;background: #ddd;border-radius: 100px;">&times;</button>
			<p id="myModalLabel" style="color: #ddd;font-family: 'ScalaSans Light';margin-bottom: 0;font-size: 23px;">Create new account</p>
		</div>
		<div class="modal-body" style="text-align: center;">
		<?php echo $this->load->view('homepage/social_create_form', $data); ?>
		</div>
	</div>
</div>
<script type="text/javascript">
$(function(){
	// /* carousel */
	// $('.carousel').carousel({
	  // interval: 3000,
	  // pause: "hover"
	// });
	// /* reponsive */
	// var x = 0;
	// $('.flexslider').flexslider({
		// animation: "slide",
		// controlNav: false,
		// animationLoop: true,
		// slideshow: true,
		// slideshowSpeed: 3000,
		// maxItems: 6,
		// itemWidth: 100
	// });
	
	$(document).scroll(function(){
		var winScroll = $(window).scrollTop();
		
		if(winScroll >= 73)
		{
			$('.navbar-fixed-top').slideUp('fast');
		}else if(winScroll <= 1)
		{
			$('.navbar-fixed-top').slideDown('fast');
		}
	});
	
<?php
	if(isset($_GET['init']))
	{
		if($_GET['init'] != '')
		{
			echo '$("#myModal_social").modal("toggle");';
		}
	}
?>
	
	/* sign-up submit */
		$('#sign_up1step').ajaxForm({
			beforeSubmit: function(formData, jqForm, options){
				var form = jqForm[0];
				if (!form.email1.value) { 
					$('#error_sign_up').html('<strong>Key-in your email ad</strong>');
					$('#myModal_validation_error').modal('toggle');
					return false;
				} else if(!form.pass1.value) {
					$('#error_sign_up').html('<strong>Key-in your password</strong>');
					$('#myModal_validation_error').modal('toggle');
					return false;
				} else {
					/* email match */
					if(form.email1.value.match("^[_A-Za-z0-9-\\+]+(\\.[_A-Za-z0-9-]+)*@"+"[A-Za-z0-9-]+(\\.[A-Za-z0-9]+)*(\\.[A-Za-z]{2,})$") == null)
					{
						$('#error_sign_up').html('<strong>Please enter a valid email</strong>');
						$('#myModal_validation_error').modal('toggle');
						return false;
					}
					else if(form.pass1.value != form.pass2.value)
					{
						$('#error_sign_up').html('<strong>Password did not match!</strong>');
						$('#myModal_validation_error').modal('toggle');
						return false;	
					}
				}
			},
			success: function(html){
				if(html == 1)
				{
					$('#email1').focus();
					$('#error_sign_up').html('<strong>Email already exist</strong>');
					$('#myModal_validation_error').modal('toggle');
					return false;
				} else {
					$('#email').val($('#email1').val());
					$('#p1').val($('#pass1').val());
					
					/* for sign up form passing previous data */
					$('#emailmodal').val($('#email1').val());
					$('#password').val($('#pass1').val());
					
					/* show modal */
					$('#myModal').modal('toggle');
				}
			}
		});
	
	/* proceed button for sign_up_form (modal) */
	$('#form_submit_button').on('click',function() {
		var fname = $('#first_name').val();
		var lname = $('#last_name').val();
		if(!fname || !lname)
		{
			$('.validation_message').html("Required");
			$('.error_validate').addClass('error');
			return false;
		}
	});	
	
	/* proceed button for social_create_form */
	$('#social_form_button').on('click', function(){
		var eto = $(this);
		var logtype = $('#loginType').val();
		var fname = $('#social_first').val();
		var lname = $('#social_last').val();
		var email = $('#social_email').val();
		var pass = $('#social_pass').val();
		var confirm = $('#social_confirm').val();
		var social_id = $('#social_id').val();
		
		/* validation */
		if(pass.length < 6)
		{
			$('.validation_message4').html("Minimum of 6 character");
			$('.error_validate4').addClass('error');
			return false;
		}
		if(!fname)
		{
			$('.validation_message1').html("Required");
			$('.error_validate1').addClass('error');
			return false;
		}else if(!lname)
		{
			$('.validation_message2').html("Required");
			$('.error_validate2').addClass('error');
			return false;
		}else if(!email)
		{
			$('.validation_message3').html("Required");
			$('.error_validate3').addClass('error');
			return false;
		}else if(!pass)
		{
			$('.validation_message4').html("Required");
			$('.error_validate4').addClass('error');
			$('#social_pass').focus();
			return false;
		}
		
		if(pass != confirm)
		{
			$('#social_pass').focus();
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
									$('#myModal_social').html(
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
									$('#myModal_social').html(
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
});
</script>
