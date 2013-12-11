<?php
	echo $this->load->view('signtop');
?>
<style>
/* bootstrap mod to show menu on hover instead of click */
.dropdown-menu .sub-menu {
  position: absolute;
  top: 0;
  left: 100%;
  margin-top: -1px;
  visibility: hidden;
}
.dropdown-menu li:hover .sub-menu {
  visibility: visible;
}
.dropdown:hover .dropdown-menu {
  display: block;
}
/* reduce margin to eliminate the chance of the menu going away as you are relying on :hover */
.nav-tabs .dropdown-menu, .nav-pills .dropdown-menu, .navbar .dropdown-menu {
  margin-top: 0;
}
.categs.dropdown-menu > li > a:hover, .categs.dropdown-menu > li > a:focus, .categs.dropdown-submenu:hover > a, .categs.dropdown-submenu:focus > a {
	background-color: #f89406;
	background-image: none;
}
.categs.dropdown-menu > .active > a, .categs.dropdown-menu > .active > a:hover, .categs.dropdown-menu > .active > a:focus {
	background-color: #faa732;
	background-image: -moz-linear-gradient(top,#fbb450,#f89406);
	background-image: -webkit-gradient(linear,0 0,0 100%,from(#fbb450),to(#f89406));
	background-image: -webkit-linear-gradient(top,#fbb450,#f89406);
	background-image: -o-linear-gradient(top,#fbb450,#f89406);
	background-image: linear-gradient(to bottom,#fbb450,#f89406);
}
.p_cont {
    margin: 0 auto;
    opacity: 0;
    padding-bottom: 38px;
    text-align: center;
	-webkit-transition: opacity 1s ease 0s;
	   -moz-transition: opacity 1s ease 0s;
	    -ms-transition: opacity 1s ease 0s;
	     -o-transition: opacity 1s ease 0s;
	        transition: opacity 1s ease 0s;
}


/* -----------------------RESPONSIVE MARKETPLACE----------------------------  */
@media (max-width: 769px) {
	body {
		margin: 0 -20px;
	}
}
/* */
</style>
	<div id="wrap">

	<div id="market-head" class="navbar">
		  <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		  </a>
		<div class="row-fluid">
			<div class="header_top">
				<div class="span2">
					<a href="<?php echo base_url('home'); ?>" style="">
						<img class="brand" src="<?php echo base_url() . (isset($resultShop['logo']) ? 'uploads/'.str_replace('uploads/', '', $resultShop['logo']) : 'img/homepage/logo.png'); ?>" onerror="this.src='http://www.placehold.it/192x192/333333/ffffff&text=no+image'"/>
					</a>
				</div>
				
				<div class="pull-right">
<?php
				if(current_url() != base_url().'home')
				{
?>
					<div>
						<ul class="inline">
							<li class="fb_bg fb_button_log" style="font-family: 'lucida grande',tahoma,verdana,arial,sans-serif; color: rgb(255, 255, 255); cursor: pointer;">
								<span style="font-weight: 600; padding: 0px 6px; border-right: 1px solid rgb(94, 114, 157); font-size: 24px; vertical-align: text-top;"> f </span>
								<span style="text-shadow: -1px -1px 0px rgb(86, 105, 145); font-weight: 600; padding: 7px 5px; border-left: 1px solid rgb(133, 152, 192); font-size: 12px; vertical-align: text-top;">Sign in <span class="hidden-phone">with Facebook</span></span>
							</li>
						<?php /*
							<li class="btn-group fb_sign_up_button">
								<button class="btn btn-mini btn-inverse dropdown-toggle" data-toggle="dropdown" style="padding: 5px;">
									<span style="font-size: 20px; vertical-align: middle;"> &#9660; </span>
								</button>
								<ul class="dropdown-menu pull-right social_log_in_border">
								<!-- dropdown menu links -->
									<li><?php $this->load->file('api/Yahoo_Oauth_YOS/index.php'); ?></li>
									<li><?php $this->load->file('api/google-api-php-client/examples/userinfo/index.php'); ?></li>
									<li style="cursor: pointer;"><?php $this->load->file('api/liveservices-LiveSDK-2b505a1/Samples/PHP/OauthSample/default.html'); ?></li>
								</ul>
							</li>
							*/ ?>
						</ul>
					</div>
<?php
				}
?>
				</div>
			
				<div class="span7">
					<div>
						<div class="row-fluid nav-hold nav-collapse collapse" style="margin-left: 30px;">
							<ul id="m_sg" class="nav menu-top">
								<li><a href="<?php echo base_url('home'); ?>" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Home</a></li>
<?php
						$logged = $this->session->userdata('logged_in');
						if(!$logged):
?>
								<li><a data-toggle="collapse" data-parent="#signtop" href="#collapseThree" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Register</a></li>
<?php
						endif;
?>
								<li><a href="<?php echo base_url('blog'); ?>" target="_blank" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'"> Blog </a></li>
<?php
						if(!$logged):
?>
								<li><a data-toggle="collapse" data-parent="#signtop" href="#collapseTwo" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Sign In</a></li>
<?php
						endif;
?>
<?php
						
						if($logged):
?>
								<li><a href="<?php echo base_url() ?>dashboard" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Dashboard</a></li>
								<li><a href="<?php echo base_url() ?>logout?url=<?php echo current_url() ?>" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Log-out</a></li>
<?php
						endif;
?>									
								<li class="hide"><a class="thelast" href="#contact">Help</a></li>
							</ul>
						</div>
						
						<form class="form-inline" method="post" onsubmit="return false;">
							<div class="row-fluid">
								<div class="span8 btn-group pull-left text-right" style="margin-bottom: 10px">
									<div class="row-fluid input-append">

										<input class="span9 search-input search_text" id="appendedInputButton" type="text" placeholder="I'm looking for...">
										<button class="btn s-btn-2 search_but btn-warning get_prod_btn" id="click-search">SEARCH</button>

									</div>
								</div>
								<div class="span4 btn-group pull-right text-right">
									<div>
										<button type="button" class="btn ces_but">CREATE YOUR E-STORE</button>
									</div>
								</div>
							</div>
						</form>
							
					</div>
				</div><!--/.nav-collapse -->
			</div>
		</div>
		
		<!-- Navigation Bar -->
			<div id="m_nav" class="row-fluid">
				
				<ul class="nav nav-pills big-bar offset4">
<?php
	if(isset($craft_categs)) {
?>
					<li class="dropdown">
						<a id="craft" class="mktmnu dropdown-toggle get_prod_btn" style="cursor: pointer;"> Crafts </a>
	<?php
							if($craft_categs->num_rows() > 0)
							{
								echo '<ul class="categs dropdown-menu" role="menu" aria-labelledby="dLabel">';
								$half   = floor($craft_categs->num_rows()/2);
								$count  = 0;
								foreach($craft_categs->result_array() as $resultCateg)
								{
									if($resultCateg['category'] != null)
									{
										if(isset($resultCateg['disabled']) == 1)
										{}
										else
										{
											echo '<li class="categ"><a tabindex="-1" style="cursor: pointer;" title="'.$resultCateg['category'].'">'.ucfirst($resultCateg['category']).'</a></li>
											';
										}
									}
								}
								echo '</ul>';
							}
	?>
					</li>
					<li class="disabled hidden-phone">
						<a>&#9679;</a>
					</li>
<?php
	}
	if(isset($food_categs)) {
?>
					<li class="dropdown">
						<a id="food" class="mktmnu dropdown-toggle get_prod_btn" style="cursor: pointer;"> Food </a>
	<?php
							if($food_categs->num_rows() > 0)
							{
								echo '<ul class="categs dropdown-menu" role="menu" aria-labelledby="dLabel">';
								$half   = floor($craft_categs->num_rows()/2);
								$count  = 0;
								foreach($food_categs->result_array() as $resultCateg)
								{
									if($resultCateg['category'] != null)
									{
										if(isset($resultCateg['disabled']) == 1)
										{}
										else
										{
											echo '<li class="categ"><a tabindex="-1" style="cursor: pointer;" title="'.$resultCateg['category'].'">'.ucfirst($resultCateg['category']).'</a></li>
											';
										}
									}
								}
								echo '</ul>';
							}
	?>
					</li>
					<li class="disabled hidden-phone">
						<a>&#9679;</a>
					</li>
<?php
	}
	if(isset($furniture_categs)) {
?>
					<li class="dropdown">
						<a id="furniture" class="mktmnu dropdown-toggle get_prod_btn" style="cursor: pointer;"> Furniture </a>
	<?php
							if($furniture_categs->num_rows() > 0)
							{
								echo '<ul class="categs dropdown-menu" role="menu" aria-labelledby="dLabel">';
								$half   = floor($furniture_categs->num_rows()/2);
								$count  = 0;
								foreach($furniture_categs->result_array() as $resultCateg)
								{
									if($resultCateg['category'] != null)
									{
										if(isset($resultCateg['disabled']) == 1)
										{}
										else
										{
											echo '<li class="categ"><a tabindex="-1" style="cursor: pointer;" title="'.$resultCateg['category'].'">'.$resultCateg['category'].'</a></li>
											';
										}
									}
								}
								echo '</ul>';
							}
	?>
					</li>
					<li class="disabled hidden-phone">
						<a>&#9679;</a>
					</li>
<?php
	}
?>
					<!--
					<li>
						<a id="hot" class="mktmnu" style="cursor: pointer;"> Hot </a>
					</li>
					<li class="disabled">
						<a>&#9679;</a>
					</li>
					-->
					<li>
						<a id="latest_website" class="mktmnu" style="cursor: pointer;"> Latest Websites </a>
					</li>	
				</ul>
			</div>
		<!-- End Navigation Bar -->
	</div>
	
	<!-- body -->
	<div id="shop-container" style='padding-top: 20px;'>
		<div class = "content-wrapper">
			<div class = "shop_body">
				<ul id="p_cont" class="p_cont" style="">
<?php 
				echo $content;
?>
				</ul>
				<div class="text-center navigation hide">
					<a class="btn first" href="<?php echo base_url().'shop/getmore?type=products&section='.$section.'&item='.$lastitem; ?>">Next</a>
				</div>

			</div>
		</div>
	</div>
<!--
		<div class="hide footer-grad" id="footer" style="background-color: rgb(0, 0, 0); height: 46px; position: relative;">
			<div style="position: absolute; height: 91px; width: 93px; left: 2px; border-radius: 10px 10px 0px 0px; background: none repeat scroll 0px 0px rgb(238, 238, 238); border: 1px solid rgb(127, 124, 124); bottom: 0px; box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.75); display: block;" id="back-top">
				<a style="font-weight: bold; width: 55px; display: block; margin: 25% auto; cursor: pointer; font-size: 16px;">Scroll To Top</a>
			</div>
			<div style="left: 0px; right: 0px; margin: auto; top: 0px; bottom: 0px; text-align: center; position: absolute; height: 18px;">
				<span id="nomore" style="font-weight: 600; color: rgb(255, 255, 255); font-size: 16px; text-transform: uppercase;"></span>
			</div>
		</div>
-->
	<!-- MODAL -->
	<div id="myModal_alert_error" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-body" style="background-color: #e34e0d;color: #fff;">
			<p class="error_word" style="font-family: 'Segoe UI Semibold';"></p>
			<div class="pull-right">
				<button class="btn btn-warning" data-dismiss="modal" aria-hidden="true">Close</button>
			</div>
		</div>
	</div>	
	<!--Sign up form modal-->
	<div id="myModal_registration" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" style="background: #383838;width: 290px;left:60%;">
		<div class="modal-header title_message">
			<h3 id="myModalLabel" style="color: #ddd;font-family: 'ScalaSans Light';">Welcome to Bolooka!</h3>
		</div>
		<div class="modal-body">
			<p style="color: #ddd;font-family: 'ScalaSans Light';">Please complete remaining fields</p>
			<?php echo $this->load->view('homepage/sign_up_form'); ?>
		</div>
	</div>
	<!-- End of Body -->

	</div>
<script>
$(function(){

	var $container = $('.p_cont'),
		colW = 222,
		columns = 6;
		  
	sessionStorage.removeItem('searchvalue');
	sessionStorage.removeItem('category');
	sessionStorage.removeItem('section');
	sessionStorage.lastitem = 2;
	sessionStorage.section = 'craft';
		  
	window.getNewElements = function getNewElements(e) {
		tempSection = sessionStorage.section;
		if(($(window).scrollTop() + 1000) >= ($(document).height() - $(window).height()))
		{
			$(window).unbind('scroll');
			var items = document.getElementsByClassName('item'),
				dataString = { 'market_id': <?php echo isset($resultShop['id']) ? $resultShop['id'] : 0; ?>, 'type': 'products', 'items': <?php echo $items; ?>, 'lastitem': sessionStorage.lastitem, 'category': sessionStorage.category, 'section': sessionStorage.section, 'searchprod': sessionStorage.searchvalue };
			$.ajax({
				url: '<?php echo base_url(); ?>shop/getmore',
				type: 'get',
				data: dataString,
				beforeSend: function(a,b) {
					$(window).unbind('scroll');
					$('.nomore').html('<img src="data:image/gif;base64,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" >').show();
				},
				success: function(newElements) {
					if(newElements) {
						if(tempSection == sessionStorage.section) {
							var $newElems = $( newElements );	// hide new items while they are loading
							$newElems.hide().imagesLoaded(function() {	// ensure that images load before adding to masonry layout
								$container
									.append( $newElems )
									.masonry( 'appended', $newElems, true ).show()
								$('.nomore').empty();
							}).show();
							sessionStorage.lastitem = Number(sessionStorage.lastitem) + 1;
							$(window).bind('scroll', getNewElements);
						}
					} else {
						$('.nomore').html('<em>Last Item Reached.</em>').slideUp(2000);
						$(window).unbind('scroll');
					}
				}
			});
		}
	}

	$container.imagesLoaded(function(){
		$container
			.masonry({
				itemSelector: '.item',
				isFitWidth: true,
				isAnimated: false
			})
			.css('opacity', 1)
		$(window).bind('scroll', getNewElements);
	});
	
	function xhrgetprod(id) {
		var mydata = new Object();
		mydata.market_id = '<?php echo isset($resultShop['id']) ? $resultShop['id'] : 0; ?>';
		mydata.items = '<?php echo $items; ?>';
		if(id == 'click-search') {
			mydata.searchprod = sessionStorage.searchvalue;
		} else {
			mydata.section = id;
		}

		$.ajax({
			beforeSend: function() {
				$(window).unbind('scroll');
				$container.empty();
				$('.nomore').html('<img src="data:image/gif;base64,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" >');
			},
			type: 'get',
			url: '<?php echo base_url(); ?>shop/getProds',
			data: mydata,
			success: function(newElements) {
				if(newElements == 0) {
					var noresult = 	'<div style="position: absolute; top: 0px; bottom: 0px; left: 0px; right: 0px; display: block; height: 17px; text-align: center;">'+
									'<span style="font-size: 15px; text-transform: uppercase;">'+
									'No Result Found.'+
									'</span>'+
									'</div>';
					$container.html(noresult);
					$('.nomore').empty();
				} else {
					var $newElems = $( newElements );
					$container.hide().html($newElems);
					$newElems.imagesLoaded( function() { // apply width to container manually
						$container
							.masonry({itemSelector : '.item', isFitWidth: true})
							.show()
							.masonry('reload') // then trigger relayout
						$('.nomore').empty();
						$(window).bind('scroll', getNewElements);
					});
				}
			}
		});		
	}
	
	function getProds(e) {
		var id = $(e.target).attr('id');
		sessionStorage.removeItem('searchvalue');
		sessionStorage.removeItem('category');
		sessionStorage.lastitem = 2;
		
		$('li.active').removeClass('active');

		if(id == 'click-search') {
			sessionStorage.removeItem('section');
			var text = $('.search_text').val();
			sessionStorage.searchvalue = text;
		} else {
			sessionStorage.section = id;
			$(e.target).addClass('active');
			$(e.target).parents('li').addClass('active');
		}
		$(window).unbind('scroll');
		xhrgetprod(id);
	}
	
	$('.get_prod_btn').bind('click', getProds);

	$('.categ').click(function(e){
		var category = $(this).find('a').attr('title');
		sessionStorage.section = $(this).parents('.dropdown').find('.mktmnu').attr('id');
		sessionStorage.removeItem('searchvalue');
		sessionStorage.lastitem = 2;
		sessionStorage.category = category;
		$(window).unbind('scroll');
		$.ajax({
			beforeSend: function() {
				$(window).unbind('scroll');
				$container.empty();
				$('.nomore').html('<img src="data:image/gif;base64,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" >');
			},
			type: "get",
			url: "<?php echo base_url(); ?>shop/getProds",
			data: { 'market_id': <?php echo isset($resultShop['id']) ? $resultShop['id'] : 0; ?>, 'items': <?php echo $items; ?>, 'category': category, 'section': sessionStorage.section },
			success: function(newElements) {
				var $newElems = $( newElements );
				$newElems.imagesLoaded( function() { // apply width to container manually
					$container
						.html(newElements)
						.masonry({itemSelector : '.item', isFitWidth: true})
						.masonry('reload') // then trigger relayout
					$('.nomore').empty();
					$(window).bind('scroll', getNewElements);
				});
				$('li.active').removeClass('active');
				$(e.target).addClass('active');
				$(e.target).parents('li').addClass('active');
			}
		});
	});

	$('#latest_website').click(function(e){
		sessionStorage.lastitem = 2;
		sessionStorage.section = 'website';
		$.ajax({
			beforeSend: function() {
				$(window).unbind('scroll');
				$container.empty();
				$('.nomore').html('<img src="data:image/gif;base64,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" >')
			},
			url: '<?php echo base_url(); ?>shop/getWebsites',
			type: 'post',
			data: { 'market_id': <?php echo isset($resultShop['id']) ? $resultShop['id'] : 0; ?>, 'items': <?php echo $items; ?> },
			success: function(newElements) {
				var $newElems = $( newElements );
				$newElems.imagesLoaded( function() { // apply width to container manually
					$container
						.html($newElems)
						.masonry({itemSelector : '.item', isFitWidth: true})
						.masonry('reload') // then trigger relayout
					$('.nomore').empty();
					$(window).bind('scroll', getNewElements);
				});
				$('li.active').removeClass('active');
				$(e.target).addClass('active');
				$(e.target).parents('li').addClass('active');
			}
		});
	});
	
	// hide #back-top first
	$("#back-top").hide();
	
	// fade in #back-top
	$(function () {
		$(document).scroll(function () {
			if ($(this).scrollTop() > 100) {
				$('#back-top').fadeIn();
			} else {
				$('#back-top').fadeOut();
			}
		});

		// scroll body to 0px on click
		$('#back-top a').click(function () {
			$('body,html').animate({
				scrollTop: 0
			}, 800);
		});
	});

	/* registration form sign up */
	$('#signtopstep').ajaxForm({
		beforeSubmit: function(formData, jqForm, options){
			var form = jqForm[0];
			if (!form.email1.value) { 
				$('.error_word').html('Email required');
				$('#myModal_alert_error').modal('show');
				return false;
			} else if(!form.pass1.value) {
				$('.error_word').html('Enter your password');
				$('#myModal_alert_error').modal('show');
				return false;
			} else {
				/* email match */
				if(form.email1.value.match("^[_A-Za-z0-9-\\+]+(\\.[_A-Za-z0-9-]+)*@"+"[A-Za-z0-9-]+(\\.[A-Za-z0-9]+)*(\\.[A-Za-z]{2,})$") == null)
				{
					$('.error_word').html('Invalid Email');
					$('#myModal_alert_error').modal('show');
					return false;
				}
				else if(form.pass1.value != form.pass2.value)
				{
					$('.error_word').html('Password did not match');
					$('#myModal_alert_error').modal('show');
					return false;	
				}
			}
		},
		success: function(html){
			if(html == 1)
			{
				$('.error_word').html('Email already exist!');
				$('#myModal_alert_error').modal('show');
				return false;
			} else {
				
				$('#emailmodal').val($('#email_signtop').val());
				$('#p1').val($('#password_signtop').val());
				$('#myModal_registration').modal('show');
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
});
</script>