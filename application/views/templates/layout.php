<?php
	$msgdesc = $description;
	$msg_id = false;
	if(isset($blog_image))
	{
		$logo_img = base_url().'uploads/'.$blog_image;
	} else if($logo->image) {
		$logo_img = base_url().'uploads/'.str_replace('uploads/', '', $logo->image);
	} else {
		$logo_img = base_url().'img/bolooka-face.jpg';
	}

?>	
<!DOCTYPE html>
<html lang="en">
 <head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# bolooka: http://ogp.me/ns/fb/bolooka#">
  <meta property="fb:app_id" content="203727729715737" />
  <meta property="og:type"   content="bolooka:site" /> 
  <meta property="og:url"    content="<?php echo current_url(); ?>" /> 
  <meta property="og:title"  content="<?php echo $site_name;?> Website" />
  <meta property="og:image"  content="<?php echo isset($productimage) ? $productimage : $logo_img; ?>" />
  <meta property="og:description"  content="<?php echo $msgdesc; ?>" />
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php
	if($_SERVER['HTTP_HOST']=='www.bolooka.com' && !isset($_REQUEST['bolookas']))
	{
?>
	<meta name="alexaVerifyID" content="e_WgoNreOiOF_lCZJS-_fMbi5fg" />
	<script type="text/javascript">

	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-7503734-20']);
	  _gaq.push(['_trackPageview']);

	  (function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl'  : 'http://www')  + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();

	</script>
	<!-- <script type="text/javascript">
	var fb_param = {};
	fb_param.pixel_id = '6008314191490';
	fb_param.value = '0.00';
	(function(){
	  var fpw = document.createElement('script');
	  fpw.async = true;
	  fpw.src = '//connect.facebook.net/en_US/fp.js';
	  var ref = document.getElementsByTagName('script')[0];
	  ref.parentNode.insertBefore(fpw, ref);
	})();
	</script>
	<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/offsite_event.php?id=6008314191490&amp;value=0" /></noscript>
	-->
<?php
	}
?>
	<title><?php echo $site_name; ?><?php echo $description ? ' - '.$description : ''; ?></title>
	<meta name="description" content="<?php echo $msgdesc; ?>" />
<!-- to be removed
	<script>document.cookie='resolution='+Math.max(screen.width,screen.height)+'; path=/';</script>
-->
<?php
	if(isset($favicon)) {
		if($this->photo_model->image_exists('uploads/'.$favicon)) {
			$icon = 'uploads/'.$favicon;
		} else {
			$icon = 'img/bolooka_favicon.png';
		}
	} else {
		$icon = 'img/bolooka_favicon.png';
	}
?>
	<link href="<?php echo base_url() . $icon; ?>" type="image/x-icon" rel="shortcut icon">

	<!-- JQuery Library -->
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-ui.min.js"></script>
	<link href="<?php echo base_url() ?>assets/css/jquery-ui.css" type="text/css" media="all" rel="stylesheet"/>
	
	<script src="<?php echo base_url() ?>assets/js/jquery.form.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tmpl.js"></script>

	<!--Michael Codes Dont Erase--
	<script src="assets/js/jquery.scrollTo.js" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" media="screen" href="assets/css/jqslider.css" />
	<!--Michael Codes Dont Erase-->
	
	<!-- Stylesheets -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bolooka.css" type="text/css" media="all" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/new_bolooka.css" type="text/css" media="all" />

	<link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">

	<link href="<?php echo base_url(); ?>assets/woothemes-FlexSlider/flexslider.css" type="text/css" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/template.css" type="text/css">

<!-- sign in accordion -->
<style type="text/css">
body {
<?php
	$bg_settings = json_decode($bg->bg_settings);
	print_r($bg_settings);
	if($bg_settings->nobg=='1'):
?>
	background-color: <?php echo $bg_settings->bgcolor; ?>;
	background-image: none;
<?php
	else:
?>
	background-color: transparent;
	background-image: url("<?php echo site_url().$bg->image; ?>");
	background-attachment: fixed;
	background-position: center;
<?php

		if(!empty($bg->bg_settings)) {
			if($bg_settings->bgrepeat) {
?>
	background-repeat: repeat;
<?php
			} else {
?>
	background-repeat: no-repeat;
	background-size: cover;
<?php
			}
		} else {
?>
	background-size: cover;
	background-repeat: no-repeat;
<?php
		}
	endif;
?>
	font-size: <?php echo $bg->font_size; ?>px;
	font-family: <?php echo $bg->font_style == 'Helvetica' ? 'Segoe UI' : $bg->font_style; ?>;
	color: <?php echo $bg->font_color ? $bg->font_color : '#000'; ?>;
}

/** logo **/
.logo_design {
    margin-bottom: 10px;
	text-align: <?php echo $logo->position; ?>;
}
.comp_logo {

}
design .brand h1{
	display:inline-block;
}
.logo_design .brand {
	color: <?php echo $logo->color; ?>;
    display: inline-block;
    text-decoration: none;
    text-shadow: 0 1px 0 #000000;
}
.logo_design .logo_style, .logo_design .logo-style  {
	/* font-size: 60px; */
}

/** menu **/
.nav_design {
    background-color: <?php echo $bg->menu_bgcolor; ?>;
    background-image: none;
    border: medium none;
    border-radius: 0 0 0 0;
    box-shadow: 0 0 5px 0 <?php echo $bg->menu_bgcolor; ?>;
    margin-bottom: 20px;
}
.nav_design .nav {
	margin: auto;
}
.nav_design .nav > li > a {
    border-radius: 0 0 0 0;
	color: <?php echo $bg->menu_color;?>;
    font-size: 1.1em;
}
.nav > li > a:hover, .nav > li > a:focus {
	background-color: <?php echo $bg->menu_over; ?>;
}
.nav_design .nav > .active > a, .nav_design .nav > .active > a:hover, .nav_design .nav > .active > a:focus {
    background-color: <?php echo $bg->menu_active; ?>;
	color: <?php echo $bg->menu_color;?>;
}
.nav-collapse .nav > li > a:hover, .nav-collapse .nav > li > a:focus, .nav-collapse .dropdown-menu a:hover, .nav-collapse .dropdown-menu a:focus {
	background-color: <?php echo $bg->menu_over; ?>;
}

/* layout3 and layout4 menu style */
.layout3 .circle_container, .layout4 .circle_container {
	background-color: <?php echo $bg->menu_bgcolor; ?>;
}
.layout3 .btn-link:hover, .layout3 .btn-link:focus, .layout4 .btn-link:hover, .layout4 .btn-link:focus {
	color: <?php echo $bg->menu_color; ?>;
	text-decoration: none;
}
.layout3 .menu_list .nav > li > a, .layout4 .menu_list .nav > li > a {
	color: <?php echo $bg->menu_color; ?>;
	display: block;
}
.layout3 .menu_list > ul .active, .layout3 .menu_list li:hover, .layout3 .menu_list li a:hover,
.layout4 .menu_list > ul .active, .layout4 .menu_list li:hover, .layout4 .menu_list li a:hover {
	background-color: <?php echo $bg->menu_over; ?>;
	box-shadow: 0 3px 8px rgba(0, 0, 0, 0.125) inset;
	text-decoration: none;
}


/* layout5 and layout6 menu design */
.layout5 .nav_design, .layout6 .nav_design {
    border-radius: 4px 4px 4px 4px;
}
.nav-tabs.nav-stacked > li > a {
    border: 1px solid transparent;
}
.nav-tabs.nav-stacked > li > a:hover, .nav-tabs.nav-stacked > li > a:focus {
	border-color: <?php echo $bg->menu_bgcolor; ?>;
}
.layout5 .nav_design li:hover a [class^="icon-"], .layout6 .nav_design li:hover a [class^="icon-"],
.layout5 .nav_design li.active a [class^="icon-"], .layout6 .nav_design li.active a [class^="icon-"]
{
	background-image: url("<?php echo base_url(); ?>img/glyphicons-halflings-white.png");
}

/** content **/
.content_style {
	background-color: <?php echo $bg->boxcolor; ?>;
    border-radius: 4px 4px 4px 4px;
	color: <?php echo $bg->font_color;?>;
}

/** footer **/
.footer_style, .footer-style {
    background-color: <?php echo $footer->bgcolor; ?>;
    color: <?php echo $footer->color;?>;
}

/** banner **/
#bannerarea .item
{
	border: 5px solid <?php echo $bg->boxcolor; ?>;
}

/** photo **/
.photo_title {
	background-color: <?php echo $bg->boxcolor; ?>;
}
.photo_content, .photo-content {
	background-color: <?php echo $bg->boxcolor; ?>;
}
.photo_content a.b2album {
	color: <?php echo $bg->menu_color; ?>;
}

/** catalog **/
.product_title {
	background-color: <?php echo $bg->boxcolor; ?>;
}
.catalog_bg, .catalog-bg {
	background: <?php echo $bg->boxcolor; ?>;
	color: <?php echo $bg->font_color;?>;
}
</style>
</head>
<body class="<?php echo $layout; ?> <?php echo $this->session->userdata('logged_in') ? '' : ''; ?>">
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=203727729715737&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<?php $this->load->view('signtop'); ?>
<?php
	echo $body;
?>

	<script type="text/javascript" src="<?php echo base_url(); ?>assets/woothemes-FlexSlider/jquery.flexslider-min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>

	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.oembed.js"></script>
	<!--twitter-->
	<script src="//platform.twitter.com/anywhere.js?id=KHEan9MZbxqsBYN61W2Wsw&v=1"></script>
	
	<!--<script type="text/javascript" src="<?php //echo base_url();?>assets/js/blog.js"></script>-->
	<script type="text/javascript">
	// move this to bolooka.js if ready
		// function ajaxObj( url ) {
			// var x = new XMLHttpRequest();
			// x.open( 'POST', url, true );
			// x.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			// return x;
		// }
		function ajaxReturn(x){
			if(x.readyState == 4 && x.status == 200){
				return true;	
			}
		}
	</script>
</body>
</html>