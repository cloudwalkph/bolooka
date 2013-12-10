<!DOCTYPE html>
<html lang="en">
 <head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# lw_bolooka: http://ogp.me/ns/fb/lw_bolooka#">
  <meta property="fb:app_id" content="203727729715737" /> 
  <meta property="og:type"   content="lw_bolooka:site" /> 
  <meta property="og:url"    content="<?php echo base_url() . url_title($url); ?>" /> 
  <meta property="og:title"  content="<?php echo $site_name; ?> Website" />
  <meta property="og:image"  content="<?php echo $queryLogo->num_rows() > 0 ? base_url($logo->image) : ''; ?>" />
  <meta property="og:decription"  content="<?php echo $site_name; ?>" /> 
	<meta charset="utf-8">
	<title><?php echo $site_name; ?><?php echo $description ? ' - '.$description : ''; ?></title>	
	<meta name="description" content="<?php echo $description; ?>" />
	<script>document.cookie='resolution='+Math.max(screen.width,screen.height)+'; path=/';</script>

	<link href="<?php echo base_url(); ?><?php echo $fav ? 'uploads/'.$fav : 'img/favicon.png'; ?>" type="image/x-icon" rel="shortcut icon">

	<script type="text/javascript" src="<?php echo base_url()?>js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url()?>css/blitzer/jquery-ui-1.8.23.custom.css" type="text/css" media="all" />

	<!--<script src="js/jqbanner.js" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" media="screen" href="css/jqbanner.css" />-->
	<!--Michael Codes Dont Erase--
	<script src="js/jquery.scrollTo.js" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" media="screen" href="css/jqslider.css" />
	<!--Michael Codes Dont Erase-->

	<script src="<?php echo base_url(); ?>js/bolooka.js" type="text/javascript"></script>

	<script type="text/javascript" src="<?php echo base_url()?>js/jquery.fancybox-1.3.4/fancybox/jquery.mousewheel-3.0.4.pack.js"/></script>
	<?php /*?><link type="text/css" rel="stylesheet" href="<?php echo base_url()?>js/jquery.fancybox-1.3.4/style.css" /><?php */?>
	<link type="text/css" rel="stylesheet" href="<?php echo base_url()?>js/jquery.fancybox-1.3.4/fancybox/jquery.fancybox-1.3.4.css" />
	<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.oembed.js"></script>
	<!--twitter-->
	<script src="//platform.twitter.com/anywhere.js?id=KHEan9MZbxqsBYN61W2Wsw&v=1"></script>
	
	<script src="<?php echo base_url('js/jquery.form.js'); ?>"></script>
	
	<script type="text/javascript" src="<?php echo base_url(); ?>js/blog.js"></script>
	
	<!-- Stylesheets -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/bolooka.css" type="text/css" media="all" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/template.css" type="text/css" media="all" />

</head>
<body class="lay1 <?php echo $this->session->userdata('logged_in') ? '' : ''; ?>">

<?php
	echo $layout;
?>

</body>
</html>