<?php
	$uid = $this->session->userdata('uid');
	$this->db->where('uid', $uid);
	$query = $this->db->get('users');
	$users = $query->row_array();
?>
<style>
#bar_holder {
	background-color: #EC6123;
}
.navbar-inner {
	
}
.navbar .nav > li > a {
    color: #FFFFFF;
    font-family: Segoe UI;
    font-size: 12px;
    text-shadow: none;
}
#bar_holder .divider-vertical {
	border-left: 1px solid rgb(225, 86, 24); 
	border-right: 1px solid rgb(247, 108, 44);
}

@keyframes myfirst
{
0% {opacity: 1;}
50% {opacity: 0;}
100% {opacity: 1;}
}

@-moz-keyframes myfirst /* Firefox */
{
0% {opacity: 1;}
50% {opacity: 0;}
100% {opacity: 1;}
}

@-webkit-keyframes myfirst /* Safari and Chrome */
{
0% {opacity: 1;}
50% {opacity: 0;}
100% {opacity: 1;}
}

@-o-keyframes myfirst /* Opera */
{
0% {opacity: 1;}
50% {opacity: 0;}
100% {opacity: 1;}
}

.brand:hover {
animation: myfirst 2s infinite;
-moz-animation: myfirst 2s infinite; /* Firefox */
-webkit-animation: myfirst 2s infinite; /* Safari and Chrome */
-o-animation: myfirst 2s infinite; /* Opera */
}

/**** notifications ****/

#dLabel .icon-play {
	-webkit-transform: rotate(90deg);
	-moz-transform:rotate(90deg);
    -ms-transform:rotate(90deg);
    -o-transform:rotate(90deg);
    transform:rotate(90deg);
}
#dLabel:hover {
	background: #E74A05;
}
#notif:hover {
	background: #E74A05;
}
.icon-bullhorn {
	-webkit-transform:scaleX(-1);
    -moz-transform:scaleX(-1);
    -ms-transform:scaleX(-1);
    -o-transform:scaleX(-1);
    transform:scaleX(-1);
}
.media-body a:hover {
	text-decoration: none;
}

/* this is for scroll bar */
.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar {
	background: #999;
}
.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar:hover {
	background: #999;
}
.mCSB_scrollTools .mCSB_dragger:hover .mCSB_dragger_bar {
	background: #999;
}	
.mCSB_draggerContainer {
	display:none;
}
.mCustomScrollBox:hover .mCSB_draggerContainer {
	display:block;
}
.popup_container {
	padding: 8px 14px;
	background-color: #f7f7f7;
	margin: 0;
	box-shadow: 1px 1px 1px #ddd;
	border: 1px solid rgba(0, 0, 0, 0.2);
	font-size: 11px;
}
.information_alert {
    overflow: hidden;
    width: 40px;
}

.notification_dropdown {
	padding-top: 1px;
	width: 300px;
	max-height: 500px;
	overflow-y:auto;
}
.notification_dropdown p {
	font-size: 10px;
}
.notification_dropdown li {
	border-bottom: 1px solid #e9e9e9;
}
.notification_dropdown li:hover {
	background: #EDEDED;
}
#notif .media {
    margin: 0;
    /* padding: 7px 20px 7px 8px; */
}
.notification_dropdown li a:hover {
	background: #EDEDED;
}
.nav-collapse32 ul li{
	text-align: left;
	padding-left: 2%;
}
.nav-collapse32 ul li:hover{
	background:#c14c18;
}
/**** ****/
.left_menu.dropdown-menu > li > a:hover, .left_menu.dropdown-menu > li > a:focus, .left_menu.dropdown-submenu:hover > a, .left_menu.dropdown-submenu:focus > a {
    background-color: rgb(248, 148, 6);
    background-image: none;
}

/* RESPONSIVE */
@media (max-width: 320px) {
	.notification_dropdown {
		right: -149% !important;
		width: 100%;
		min-width: 299px;
		max-height: none;
	}
}
</style>

	<!-- bar holder start -->
	<div id="bar_holder" class="navbar navbar-fixed-top">
		<div class="">
			<div class="container nav-collapse32 collapse visible-phone" style="background: #d6551c;">
				<ul class="nav" style="margin: 0;text-align: center;float: none;">
					<li style="float: none;">
						<a href="<?php echo base_url(); ?>dashboard"><span><i class="icon-th-list icon-white"></i></span> Dashboard<span><i class="icon-chevron-right icon-white pull-right"></i></span></a>
					</li>
					<li style="float: none;">
						<a href="<?php echo base_url(); ?>manage"><span><i class="icon-edit icon-white"></i></span> Manage e-store<span><i class="icon-chevron-right icon-white pull-right"></i></span></a>
					</li>
					<li style="float: none;">
						<a href="<?php echo base_url(); ?>profile"><span><i class="icon-user icon-white"></i></span> Profile<span><i class="icon-chevron-right icon-white pull-right"></i></span></a>
					</li>
					<li style="float: none;">
						<a href="<?php echo base_url(); ?>test/following"><span><i class="icon-circle-arrow-right icon-white"></i></span> Following<span><i class="icon-chevron-right icon-white pull-right"></i></span></a>
					</li>
					<li style="float: none;">
						<a href="<?php echo base_url(); ?>marketplace"><span><i class="icon-shopping-cart icon-white"></i></span> Shop Now<span><i class="icon-chevron-right icon-white pull-right"></i></span></a>
					</li>
					<li style="float: none;">
						<a href="<?php echo base_url(); ?>settings"><span><i class="icon-wrench icon-white"></i></span> Account Settings<span><i class="icon-chevron-right icon-white pull-right"></i></span></a>
					</li>
					<li style="float: none;">
						<a href="<?php echo base_url(); ?>logout"><span><i class="icon-off icon-white"></i></span> Log Out<span><i class="icon-chevron-right icon-white pull-right"></i></span></a>
					</li>
				</ul>
			</div>
			<div class="container atmediaContainer">
				<button type="button" class="btn btn-navbar visible-phone" data-toggle="collapse" data-target=".nav-collapse32">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<div class="row-fluid">
					<div class="pull-left">
						<a class="brand" href="<?php echo base_url(); ?>dashboard" style="padding-top: 0px; padding-bottom: 0px; margin-top: 4px;">
							<center><img class="brandname" src="<?php echo base_url(); ?>img/dashboard-logo.png" alt="Bolooka"></center>
						</a>
					</div>
					<div class="pull-right">
						<ul class="nav pull-right">
							<li class="hide">
								<a id="chat" href="#">
									<i class="icon-envelope icon-white"></i>
								</a>
							</li>
<script>
$(function() {
	$.ajax({
		beforeSend: function() {
			return 'fetching data...';
		},
		type: 'post',
		url: '<?php echo base_url(); ?>test/get_chat',
		success: function(d) {
			$("a#chat").popover({
				content: d,
				placement:'bottom',
				html:true,
				trigger:'click'
			});
		}
	});

});
</script>
							<li id="notif" class="dropdown">
								<a style="cursor: pointer;" id="notify" class="dropdown-toggle notify" data-toggle="dropdown" role="button">
<?php
									$wQuery = $this->db->query("SELECT * FROM flag WHERE status='1' AND notify='".$uid."' AND action <> 'new user' ");
								
									if($wQuery->num_rows > 0)
									{
										echo '<span class="badge badge-important">'.$wQuery->num_rows.'</span><i class="icon-bullhorn icon-white"></i>';
									}
									else
									{
										echo '<i class="icon-bullhorn icon-white"></i>';
									}
?>								
								</a>
								<ul class="container-fluid dropdown-menu notification_dropdown" role="menu" aria-labelledby="dLabel">
									<!-- notification items-->
								</ul>
							</li>
							<li class="hidden-phone"><a href="<?php echo base_url() ?>profile">Mabuhay! <?php echo $users['first_name']; ?></a></li>
							<li class="divider-vertical hidden-phone"></li>
							<li class="hidden-phone"><a href="<?php echo base_url() ?>marketplace" target="_marketplace">Marketplace</a></li>
							<li class="divider-vertical hidden-phone"></li>
							<li class="dropdown hidden-phone">
								<a style="padding-left:10px;padding-right:10px;" href="#" id="dLabel" class="dropdown-toggle" data-toggle="dropdown" role="button">
									<span style="color: rgb(255, 255, 255);"> &#9660; </span>
								</a>
								<ul class="dropdown-menu left_menu pull-right hidden-phone" role="menu" aria-labelledby="dLabel" style="margin-top: -1px;border: 0;">
									<li><a tabindex="-1" href="<?php echo base_url() ?>settings">Account Settings</a></li>
									<li><a tabindex="-1" href="<?php echo base_url(); ?>logout">Log Out</a></li>
									<li class="divider" style="width: 150px;margin-left: 6px;"></li>
									<li><a tabindex="-1" href="#">Help</a></li>
								</ul>
							</li>
							<li class="divider-vertical" style="margin-right: 0;"></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!--<div id="time"></div>-->	
	</div>
	<!-- bar holder end -->

<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.mousewheel.min.js"></script>
<script>
$(function() {

	// $('.notify').load('<?php echo base_url('test/notification'); ?>');
	
	setInterval(function(){
		// $('.notify').load('<?php echo base_url('test/notification'); ?>');
	},2000);
	
	// $('#notify').popover({
		// placement: 'bottom',
		// content: function() {
			// var dataString;
			// $.ajax({
				// url: '<?php echo base_url(); ?>test/notificationItem',
				// data: dataString,
				// done: function(html) {
					// alert(html);
				// }
			// });
		// }
	// });
	
	$('#notif').delegate('.notify', 'click', function(e) {
		
		var notyItem = $(this).parent().find('.notification_dropdown');
		var eto = $(this);
		$('.notification_dropdown').html('<li><div class="progress progress-striped"><div class="bar" style="width: 100%;"></div></div></li>');
		
		getNotiItem(notyItem);
		
		if($('.notification_dropdown').is(':visible') == false)
		{
			notiRead(eto);
		}
	});
	
	function getNotiItem(el)
	{
		$(el).load('<?php echo base_url('test/notificationItem'); ?>');
	}
	
	function notiRead(el)
	{
		$.ajax({
			url: '<?php echo base_url('test/alreadyRead'); ?>',
			success: function(){
				$(el).load('<?php echo base_url('test/notification'); ?>');
			}
		});
		
	}
	
	$('#notif').delegate('.invite_accept', 'click', function(e) {
		var web_id = $(this).attr('alt');
		var dataString = { 'web_id': web_id };
		var id = $(this).parent().parent().attr('alt');
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>test/on_accept",
			data: dataString,
			success: function(html) {
				$('#button_nav'+id).html('<span style="font-size: 12px;color: #DDD;">accepted</span>');
			}
		});
	});

	$('#notif').delegate('.invite_decline', 'click', function(e) {
		var web_id = $(this).attr('alt');
		var parent = $(this).parents('.media');
		var id = parent.attr('alt');
		var dataString = { 'web_id': web_id };
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>test/on_decline",
			data: dataString,
			success: function(html) {
				parent.find('.button_nav').html('<span class="btn btn-small btn-danger disabled">denied</span>').removeClass('.invite_decline');
			}
		});
	});

	function startTime()
	{
		var today=new Date();
		var h=today.getHours();
		var m=today.getMinutes();
		var s=today.getSeconds();
		// add a zero in front of numbers<10
		m=checkTime(m);
		s=checkTime(s);
		$('#time').html(h+":"+m+":"+s);
		t=setTimeout(function(){startTime()},500);
	}
	startTime();

	function checkTime(i)
	{
		if (i<10)
		  {
		  i="0" + i;
		  }
		return i;
	}

});
</script>