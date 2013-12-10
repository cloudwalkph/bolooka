<?php
	$site_status = $this->db->query("SELECT `status` FROM `websites` WHERE `id` = '".$wid."'");
	$status = $site_status->row_array();
	
	if($status['status']==0)
	{
		echo '
			<script>
				$(document).ready(function(){
						$("#popedit").fadeIn(400);
						$("#popedit").fadeOut(400);
						$("#popedit").fadeIn(400);
						$("#popedit").fadeOut(400);
						$("#popedit").fadeIn(400);
						$("#popedit").fadeOut(400);
						$("#popedit").fadeIn(400);	
				});
			</script>
		';
		$this->db->query("UPDATE `websites` SET `status` = '1' WHERE `id` = '".$wid."'");
	}
	
?>
<style>
#nav-top-class {
    position: absolute;
    right: 0;
    top: -63px;
	-webkit-transition: top 0.5s ease 0.1s;
	-o-transition: top 0.5s ease 0.1s;
	-moz-transition: top 0.5s ease 0.1s;
	transition: top 0.5s ease 0.1s;
}

#nav-top-class:hover {
	top: 0;
}

#holder li a.topmenu {
    
    box-shadow: 0 1px 1px 0 rgba(192, 192, 192, 0.75);
    color: #FFFFFF;
    font-family: 'Segoe UI Semibold', 'Tahoma';
    font-size: 13px;
    text-shadow: 0 1px rgba(117, 117, 117, 0.75);
    transition: background 1s ease 0s;

	transition: background 1s;
	-moz-transition: background 1s; /* Firefox 4 */
	-webkit-transition: background 1s; /* Safari and Chrome */
	-o-transition: background 1s; /* Opera */

background: rgb(61,61,61); /* Old browsers */
}

#holder li a.topmenu:hover {
background: rgb(37,37,37); /* Old browsers */
}

#holder li.dropdown.open > .dropdown-toggle, #holder li.dropdown.active > .dropdown-toggle, #holder li.dropdown.open.active > .dropdown-toggle {
background: rgb(78,78,78); /* Old browsers */
background: -moz-linear-gradient(top,  rgba(78,78,78,1) 0%, rgba(56,56,56,1) 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(78,78,78,1)), color-stop(100%,rgba(56,56,56,1))); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  rgba(78,78,78,1) 0%,rgba(56,56,56,1) 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  rgba(78,78,78,1) 0%,rgba(56,56,56,1) 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  rgba(78,78,78,1) 0%,rgba(56,56,56,1) 100%); /* IE10+ */
background: linear-gradient(to bottom,  rgba(78,78,78,1) 0%,rgba(56,56,56,1) 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#4e4e4e', endColorstr='#383838',GradientType=0 ); /* IE6-9 */

    background-color: transparent;
    color: #FFFFFF;
}

#holder.navbar .nav > li > .dropdown-menu:after {
	border-bottom-color: transparent;
}
.c-holder-ul{
background: -moz-linear-gradient(top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.7) 1%, rgba(0,0,0,0.7) 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(0,0,0,0.7)), color-stop(1%,rgba(0,0,0,0.7)), color-stop(100%,rgba(0,0,0,0.7))); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top, rgba(0,0,0,0.7) 0%,rgba(0,0,0,0.7) 1%,rgba(0,0,0,0.7) 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top, rgba(0,0,0,0.7) 0%,rgba(0,0,0,0.7) 1%,rgba(0,0,0,0.7) 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top, rgba(0,0,0,0.7) 0%,rgba(0,0,0,0.7) 1%,rgba(0,0,0,0.7) 100%); /* IE10+ */
background: linear-gradient(to bottom, rgba(0,0,0,0.7) 0%,rgba(0,0,0,0.7) 1%,rgba(0,0,0,0.7) 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#b3000000', endColorstr='#b3000000',GradientType=0 ); /* IE6-9 */

}
.c-holder {
	/* background-color: transparent; */    
    /* background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.7), rgba(20, 20, 20, 0.7)); */
    border-radius: 0 0 0 0;
    color: #FFFFFF;
    width: 244px;
}

.show-cart {
	min-width: 160px;
}
.top-style ul li:hover {
	background:#ec6123;
}
.top-style ul li a.mobile:hover{
	color:white;
}
.top-style ul li a.mobile{
	color:white;
	text-shadow:none;
}

/* hover menu dropdown - css3 style */
#square-bar {
    bottom: -34px;
    position: absolute;
    right: 4px;
	-webkit-transition: opacity 0.5s ease 0.1s;
	-o-transition: opacity 0.5s ease 0.1s;
	-moz-transition: opacity 0.5s ease 0.1s;
	transition: opacity 0.5s ease 0.1s;
}
#square-bar .btn-navbar {
	display: block;
}

#nav-top-class:hover #square-bar {
	opacity: 0;
}
/* */
</style>

	<div id="holder" class="navbar navbar-fixed-top visible-desktop">

			<div class="container" style="position: relative;">
			
				<div class="pull-right" id="nav-top-class">

				<ul class="nav">

					<li><input type="hidden" class="current_page" value="<?php echo current_url(); ?>"></li>
					<?php
						if($this->session->userdata('logged_in')) {

							$the_user = $this->session->userdata('uid');
							$the_website = $wid;
							
							$query = $this->db->query("SELECT * FROM follow WHERE users='$the_user' AND website_id='$the_website'");
							$querySite = $this->db->query("SELECT * FROM websites WHERE user_id='$the_user' AND id='$the_website'");
							
							if($querySite->num_rows() > 0)
							{
								echo '
									<li class="editSite">
										<a class="topmenu" href="'.base_url().'manage/webeditor?wid='.$the_website.'"> <i class="icon-edit icon-white"></i> Edit Website </a>
									</li>
								';
							}
							echo '	<li>
										<a class="topmenu" href="'.base_url().'dashboard"> <i class="icon-cog icon-white"></i> Dashboard </a>
									</li>';

							if ($query->num_rows() > 0)
							{
							   echo '
									<li class="'.$the_user.'" alt="'.$the_website.'">
										<a class="follow topmenu" id="unfollow" style="cursor:pointer;"> <i class="icon-circle-arrow-left icon-white"></i> Unfollow </a>
									</li>
								';
							}
							else
							{
							   echo '
									<li class="'.$the_user.'" alt="'.$the_website.'">
										<a class="follow topmenu" id="follow" style="cursor:pointer;"> <i class="icon-circle-arrow-right icon-white"></i> Follow </a>
									</li>';
							}
						}
						else
						{
							echo '
								<li><a class="topmenu" data-toggle="collapse" data-parent="#signtop" href="#collapseThree"> <i class="icon-pencil icon-white"></i> Register </a></li>
								<li><a class="topmenu" data-toggle="collapse" data-parent="#signtop" href="#collapseTwo"> <i class="icon-check icon-white"></i> Sign in </a></li>
							';
							
						}
					?>

					<li class="dropdown mobile_view">
						<a class="dropdown-toggle show-cart topmenu" data-toggle="dropdown" data-placement="bottom" href="#">
							<i class="icon-shopping-cart icon-white"></i> Cart <i class="pull-right icon-chevron-down icon-white"></i>
							<div class="row-fluid">
								<span class="items_cart"> <?php echo $items_cart ? $items_cart : 0; ?> </span> item(s) - Php <span class="c_total"> <?php echo $c_total ? $c_total : '0.00'; ?> </span> &#9660;
							</div>
						</a>
						
						<div class="popover bottom in" id="popedit" style="top: 94px; left: 48px;">
							<div class="arrow" style="left:86%;"></div>
							<div class="popover-content" style="width: 114px;color: black;">
								Edit Website
							</div>
						</div>
						<div class="popover bottom in" id="popcart" style="top: 94px; left: 48px;">
							<div class="arrow" style="left:86%;"></div>
							<div class="popover-content" style="width: 116px;color: black;">
								Item Added to cart
							</div>
						</div>
						<ul class="dropdown-menu c-holder-ul pull-right" role="menu" aria-labelledby="dLabel">
							<li class="container-fluid c-holder">
							<!-- Cart item list goes here -->
							</li>
						</ul>
					</li>
				</ul>
				<div id="square-bar">
					<button type="button" class="btn btn-navbar">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>

				</div>

			</div><!-- .container -->

	</div>

<div class="navbar">
	<div class="container hidden-desktop">
		<div class="nav-collapse32 collapse top-style" style="background: #000;">
			<div class="navmobile">
			<ul class="nav nav-mobile" style="float:none;margin:0;">
<?php
		if($this->session->userdata('logged_in')){
			$the_user = $this->session->userdata('uid');
?>
				<li style="float:none;">
					<a class="mobile" href="<?php echo base_url(); ?>dashboard"><span><i class="icon-th-list icon-white"></i></span> Dashboard<span><i class="icon-chevron-right icon-white pull-right"></i></span></a>
				</li>
<?php
			if ($query->num_rows() > 0){
		
?>
				<li style="float:none;" class="<?php echo $the_user; ?>" alt="<?php echo $wid; ?>">
					<a class="follow mobile" id="unfollow" style="cursor:pointer;"><span><i class="icon-circle-arrow-left icon-white"></i></span> Unfollow<span><i class="icon-chevron-right icon-white pull-right"></i></span></a>
				</li>
<?php			
			}else{
?>
				<li style="float:none;" class="<?php echo $the_user; ?>" alt="<?php echo $wid; ?>">
					<a class="follow mobile" id="follow" style="cursor:pointer;"><span><i class="icon-circle-arrow-right icon-white"></i></span> Follow<span><i class="icon-chevron-right icon-white pull-right"></i></span></a>
				</li>
<?php
			}
		}else{
?>
				<li style="float:none;">
					<a class="mobile" data-toggle="collapse" data-parent="#signtop" href="#collapseThree"><span><i class="icon-pencil icon-white"></i></span> Register<span><i class="icon-chevron-right icon-white pull-right"></i></span></a>
				</li>
				<li style="float:none;">
					<a class="mobile sign-in-mobile" data-toggle="collapse" data-parent="#signtop" href="#collapseTwo"><span><i class="icon-check icon-white"></i></span> Sign in<span><i class="icon-chevron-right icon-white pull-right"></i></span></a>
				</li>			
<?php
		}
?>
				<li style="float:none;">
					<a class="mobile" href="<?php echo base_url(); ?>marketplace"><span><i class="icon-shopping-cart icon-white"></i></span> Marketplace<span><i class="icon-chevron-right icon-white pull-right"></i></span></a>
				</li>
			</ul>			
			</div>
		</div>
		
			<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse32">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>			
	</div>
</div>
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
<script type="text/javascript">

/* detect if class="c-holder-ul" is visible */
// $(document).click(function(e){
    // var myTarget = $(".c-holder-ul");
	// if(myTarget.is(':visible') == true)
	// {
		// $("#holder .nav").css("top","-63px");
		// $('#square-bar').css('visibility','visible');
		// $('#square-bar').show();
	// }
// });

$(document).ready(function(){

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

// $('#square-bar').mouseenter(function() {
	// $(this).css('visibility','hidden');
	// $("#holder .nav").css("top","0");
	// $('#popedit').hide();
	// $("#popcart").hide();
	
// });
// $('#nav-top-class').mouseleave(function() {
	// if($('.c-holder-ul').is(':visible') == true)
	// {
		// return false;
	// }
  // $('#square-bar').css('visibility','visible');
  // $("#holder .nav").css("top","-63px");
  // $('#square-bar').show();
// });

	/* shopping cart */
	$('#popedit, #popcart').on('click', function(e) {
		$(this).hide();
	});
	// $('.show-cart').on('click', function(e) {	
		// $('#square-bar').hide();
	// });
	$('.show-cart').click(function(){
		var tdatatring = 'urls=<?php echo $url; ?>';
		$.ajax({
			type:'post',
			url:'<?php echo base_url(); ?>multi/topcart',
			data: tdatatring,
			beforeSubmit: function(html) {
				$('.c-holder').html('<p style="text-align: center;"><img src="<?php echo base_url(); ?>img/ajax-loader.gif" /></p>');
			},
			success: function(html)
			{
				$('.c-holder').empty();
				$('.c-holder').html(html);
			}
		});
	});

	var thedatatring = 'urls=<?php echo $url; ?>&wid=<?php echo $wid; ?>';
	// Get Total Cart Items
	$.ajax({
		type:'post',
		url:'<?php echo base_url(); ?>multi/getcartitems',
		data: thedatatring,
		success: function(html)
		{
			// alert(html);
			$('.items-cart').html(html);
		}
	});
	/* Get Total Cart Price */
	$.ajax({
		type:'post',
		url:'<?php echo base_url(); ?>multi/carttotal',
		data: thedatatring,
		success: function(html){
			if(html == ''){
				$('.c-total').html('0.00');
			}else{
				$('.c-total').html(html);
			}
		}
	});
	/* Remove Item */
	$('#holder').delegate('.remove-item', 'click', function() {
		var prod_id = $(this).attr('alt');
		var datas = 'prod_id='+prod_id;
		$.ajax({
			type:'post',
			url:'<?php echo base_url(); ?>multi/removecart',
			data: datas,
			success: function(html)	{
				// Get Total Cart Items
				$.ajax({
					type:'post',
					url:'<?php echo base_url(); ?>multi/getcartitems',
					data: datas,
					success: function(html3) {
						//alert(html);
						$('.items_cart').html(html3);
					}
				});
				// Get Total Cart Price
				$.ajax({
					type:'post',
					url:'<?php echo base_url(); ?>multi/carttotal',
					data: datas,
					success: function(html2) {
						if(html == ' ')	{
							$('.c_total').html('0.00');
						} else {
							$('.c_total').html(html2);
						}
					}
				});
			}
		});
	});
	
	/* */
	
	/** Follow Website **/
	$('.follow').click(function(){
		var page_url = $('.current_page').val();
		var action = $(this).attr('id');
		var uid = $(this).parent().attr('class');
		var wid = $(this).parent().attr('alt');
		var dataString = 'uid='+uid+'&website_id='+wid+'&siteurl='+page_url;
		
		$.ajax({
			type:'POST',
			url:'<?php echo base_url(); ?>test/'+action,
			data: dataString,
			success: function(html)
			{
				window.location.reload();
			}
		});
	});

	$('#signtop').on('show',function(){
		$(window).scrollTop(0);
	});
});
</script>