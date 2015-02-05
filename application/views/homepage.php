<!DOCTYPE html> 
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<meta http-equiv="content-type" content="application/x-font-opentype">
	<meta property="fb:app_id" content="203727729715737" />
	<meta property="og:type"   content="bolooka:site" />
	<meta property="og:url"    content="<?php echo current_url(); ?>" /> 
	<meta property="og:title"  content="Bolooka" />
	<meta property="og:image"  content="<?php echo base_url(); ?>img/bolooka-face.jpg" />
	<meta property="og:description"  content="Social eCommerce Platform for Locally Made Products." />
<?php
	if($_SERVER['HTTP_HOST']=='alpha.bolooka.com')
	{
?>
	<meta name="robots" content="noindex, nofollow">
<?php
	}
?>
<?php
	if($_SERVER['HTTP_HOST']=='www.bolooka.com' && !isset($_REQUEST['bolookas']))
	{
?>
	<meta name="google-site-verification" content="PcPW4blc6KnO_pBiA8EyNy6XoFXjjSssdUI-kptYHKM" />
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
	<script type="text/javascript">
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

	<title>Bolooka - Social eCommerce Platform for Locally Made Products</title>
<?php
	} elseif($_SERVER['HTTP_HOST']=='bolooka.com' || $_SERVER['HTTP_HOST']=='alpha.bolooka.com') {
?>
		<title>Alpha Site - Bolooka - Social E-Commerce Platform</title>
<?php
	} elseif($_SERVER['HTTP_HOST']=='localhost' || $_SERVER['HTTP_HOST']=='bolooka.localhost') {
?>
		<title><?php echo isset($page) ? ucfirst($page) : ''; ?> Localhost - Bolooka - Social E-Commerce Platform</title>
<?php
	}
?>
	<meta name="description" content="Bolooka is an e-commerce platform that provides an exclusive marketplace for local merchants and artists who create only the best products in the country. ">

	<link href="<?php echo base_url(); ?>img/favicon.png" rel="icon">
	
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<!-- Stylesheets -->
	<link href="<?php echo base_url() ?>assets/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>assets/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
	<link href="<?php echo base_url() ?>assets/css/bolooka.css" type="text/css" rel="stylesheet">
	<link href="<?php echo base_url() ?>assets/css/new_bolooka.css" type="text/css" rel="stylesheet">
	<link href="<?php echo base_url() ?>assets/css/jquery-ui.css" type="text/css" rel="stylesheet">

	<script src="<?php echo base_url() ?>assets/js/jquery.min.js" type="text/javascript" ></script>
	<script src="<?php echo base_url() ?>assets/js/jquery-ui.min.js" type="text/javascript" ></script>
	<!-- The basic File Upload plugin -->
	<script src="<?php echo base_url() ?>assets/jQuery-File-Upload-master/js/jquery.fileupload.js"></script>
	<!-- The File Upload file processing plugin -->
	<script src="<?php echo base_url() ?>assets/jQuery-File-Upload-master/js/jquery.fileupload-fp.js"></script>
	<!-- The File Upload user interface plugin -->
	<script src="<?php echo base_url() ?>assets/jQuery-File-Upload-master/js/jquery.fileupload-ui.js"></script>
	<!-- The main application script -->
<style>
      /* Sticky footer styles
      -------------------------------------------------- */

      html,
      body {
        height: 100%;
        /* The html and body elements cannot have any padding or margin. */
		padding: 0;
      }

      /* Wrapper for page content to push down footer */
      #wrap {
        min-height: 100%;
        height: auto !important;
        height: 100%;
        /* Negative indent footer by it's height */
        /* margin: 0 auto -38px; */
      }

      /* Set the fixed height of the footer here */
      #push,
      #footer {
        height: 38px;
      }
      #footer {
        /* background-color: #f5f5f5; */
		margin-top: -38px;
      }

      /* Lastly, apply responsive CSS fixes as necessary */
</style>
</head>
<body id="<?php echo isset($page) ? $page : ''; ?>">

<?php 
	if(isset($header))
		echo $header;

	if(isset($body)) {
		// echo '<div id="wrap">';
		echo $body;
		// echo '</div>';
	}

	if(isset($footer))
		echo $footer; 

	if(isset($sign_up_form))
		echo $sign_up_form; 
?>

	<script src="<?php echo base_url() ?>assets/js/jquery.form.js" type="text/javascript" ></script>
	<script src="<?php echo base_url() ?>assets/js/jquery.masonry.min.js" type="text/javascript" ></script>
	<script src="<?php echo base_url() ?>assets/bootstrap/js/bootstrap.min.js" type="text/javascript" ></script>
	<script src="<?php echo base_url() ?>assets/infinite-scroll-master/jquery.infinitescroll.min.js" type="text/javascript" ></script>
	<script src="<?php echo base_url() ?>assets/colorpicker/js/bootstrap-colorpicker.js" type="text/javascript" ></script>
	<script src="<?php echo base_url() ?>assets/js/bolooka.js" type="text/javascript" ></script>
</body>
</html>