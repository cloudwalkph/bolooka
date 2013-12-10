<!DOCTYPE html> 
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<title>Bolooka - Social E-Commerce Platform</title>
	
	<link href="<?php echo base_url().'img/favicon.png'; ?>" rel="icon">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	 <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

	<!-- Stylesheets -->
	<link href="<?php echo base_url() ?>assets/bootstrap/css/bootstrap.css" rel="stylesheet">
	<link href="<?php echo base_url() ?>assets/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
	<link href="<?php echo base_url() ?>assets/colorpicker/css/colorpicker.css" type="text/css" rel="stylesheet">
	<link href="<?php echo base_url() ?>assets/woothemes-FlexSlider/flexslider.css" type="text/css" rel="stylesheet">

	<link href="<?php echo base_url() ?>assets/css/bolooka.css" type="text/css" rel="stylesheet">
	<link href="<?php echo base_url() ?>assets/css/new_bolooka.css" type="text/css" rel="stylesheet">
	<link href="<?php echo base_url() ?>assets/css/jquery-ui.css" type="text/css" media="all" rel="stylesheet"/>
	<link href="<?php echo base_url() ?>assets/css/jquery.mCustomScrollbar.css" rel="stylesheet">
	<link href="<?php echo base_url() ?>assets/css/pagination.css" type="text/css" rel="stylesheet">

<!-- Bootstrap CSS fixes for IE6 -->
<!--[if lt IE 7]><link rel="stylesheet" href="http://blueimp.github.com/cdn/css/bootstrap-ie6.min.css"><![endif]-->
<!-- Bootstrap Image Gallery styles -->
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap-image-gallery.min.css">
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<link rel="stylesheet" href="<?php echo base_url() ?>assets/jQuery-File-Upload-master/css/jquery.fileupload-ui.css">
<!-- CSS adjustments for browsers with JavaScript disabled -->
<noscript><link rel="stylesheet" href="<?php echo base_url() ?>css/jquery.fileupload-ui-noscript.css"></noscript>
<!-- Shim to make HTML5 elements usable in older Internet Explorer versions -->
<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->

	<!-- JQuery Library -->
<?php
	/* *
	<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
	<script type="text/javascript" src="http://code.jquery.com/ui/jquery-ui-git.js"></script>
	<link rel="stylesheet" href="http://code.jquery.com/ui/jquery-ui-git.css" type="text/css" media="all" />
	/* */
?>
	<script src="<?php echo base_url() ?>assets/js/jquery.min.js" type="text/javascript" ></script>
	
<!--for google maps-->
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <link href="http://code.google.com//apis/maps/documentation/javascript/examples/default.css" rel="stylesheet">
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>
<!--for google maps-->

</head>
<body>
<?php
		// $qActive = $this->db->get('bolooka_sessions');
		// echo '<div class="online text-right well" style="position: fixed; bottom: 0; right: 0;">';
		// echo 'There are '.$qActive->num_rows().' session(s).<br>';
		// foreach($qActive->result_array() as $key=>$value)
		// {
			// $user_data = unserialize($value['user_data']);
			// if(isset($user_data['username'])) {
				// echo '<span>'.$user_data['username'] . ' is online.</span><br/>';
			// }
		// }
		// echo '</div>';
?>
<?php
	if(isset($bar_holder))
		echo $bar_holder;
?>
<?php 
	if(isset($body))
		echo $body;
?>
<?php 
	if(isset($footer))
		echo $footer;
?>

	<script src="<?php echo base_url() ?>assets/js/jquery-ui.min.js" type="text/javascript" ></script>
	<script src="<?php echo base_url() ?>assets/js/jquery.form.js" type="text/javascript" ></script>
	<script src="<?php echo base_url() ?>assets/bootstrap/js/bootstrap.min.js" type="text/javascript" ></script>
	<script src="<?php echo base_url() ?>assets/woothemes-FlexSlider/jquery.flexslider-min.js" type="text/javascript" ></script>
	<script src="<?php echo base_url() ?>assets/colorpicker/js/bootstrap-colorpicker.js" type="text/javascript" ></script>
	<script src="<?php echo base_url() ?>assets/infinite-scroll-master/jquery.infinitescroll.min.js" type="text/javascript" ></script>
	
 	<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.qtip-1.0.0-rc3.min.js"></script>

	<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.oembed.js"></script> 
	<script type="text/javascript" src="<?php echo base_url() ?>assets/js/filterable.pack.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.pajinate.js"></script>
	 
	
	<!--twitter login--> 
	<script src="http://platform.twitter.com/anywhere.js?id=KHEan9MZbxqsBYN61W2Wsw&v=1" type="text/javascript"></script>

<!-- The Templates plugin is included to render the upload/download listings -->
<script src="<?php echo base_url() ?>assets/js/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="<?php echo base_url() ?>assets/js/load-image.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="<?php echo base_url() ?>assets/js/canvas-to-blob.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/bootstrap-image-gallery.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="<?php echo base_url() ?>assets/jQuery-File-Upload-master/js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="<?php echo base_url() ?>assets/jQuery-File-Upload-master/js/jquery.fileupload.js"></script>
<!-- The File Upload file processing plugin -->
<script src="<?php echo base_url() ?>assets/jQuery-File-Upload-master/js/jquery.fileupload-fp.js"></script>
<!-- The File Upload user interface plugin -->
<script src="<?php echo base_url() ?>assets/jQuery-File-Upload-master/js/jquery.fileupload-ui.js"></script>
<!-- The main application script -->
<!-- <script src="assets/jQuery-File-Upload-master/js/main.js"></script> -->
<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE8+ -->
<!--[if gte IE 8]><script src="js/cors/jquery.xdr-transport.js"></script><![endif]-->

	<script type="text/javascript" src="<?php echo base_url();?>assets/js/bolooka.js"></script>
</body>
</html>
