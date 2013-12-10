<!doctype html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<!-- Stylesheets -->
    <link href="<?php echo base_url() ?>assets/css/bolooka.css" rel="stylesheet">
	<!-- Bootstrap -->
	<link href="<?php echo base_url() ?>assets/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>assets/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
<style>
body {
	margin: 0;
}
.wrap {
	min-height: 100%;
	height: auto !important;
	height: 100%;
}
#bg404 {
    background-image: url("<?php echo base_url(); ?>img/newBackgrounds/Bolooka-78783544.jpg");
    background-size: cover;
    min-height: 100%;
}
#msg404 {
    bottom: 15%;
}
#msg404bg {
background: -moz-linear-gradient(left,  rgba(83,83,83,1) 0%, rgba(83,83,83,0.5) 90%, rgba(83,83,83,0) 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, right top, color-stop(0%,rgba(83,83,83,1)), color-stop(90%,rgba(83,83,83,0.5)), color-stop(100%,rgba(83,83,83,0))); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(left,  rgba(83,83,83,1) 0%,rgba(83,83,83,0.5) 90%,rgba(83,83,83,0) 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(left,  rgba(83,83,83,1) 0%,rgba(83,83,83,0.5) 90%,rgba(83,83,83,0) 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(left,  rgba(83,83,83,1) 0%,rgba(83,83,83,0.5) 90%,rgba(83,83,83,0) 100%); /* IE10+ */
background: linear-gradient(to right,  rgba(83,83,83,1) 0%,rgba(83,83,83,0.5) 90%,rgba(83,83,83,0) 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#535353', endColorstr='#00535353',GradientType=1 ); /* IE6-9 */

    height: 100px;
}
</style>
</head>
<body>
	<div id="error" class="wrap">
		<div id="bg404" class="row-fluid affix gray">
			
		</div>
		<div id="msg404" class="row-fluid affix">
			<div id="msg404bg" class="container-fluid">
				<div class="pull-left">
					<div style="color: rgb(237, 97, 36); font-size: 90px; font-family: Segoe UI Semibold; line-height: 1">404</div>
				</div>
				<div class="">
					<div style="color: rgb(215, 215, 215); font-family: Segoe UI Light; font-size: 40px; line-height: 1">You seem to have gone off course.</div>
					<div>
						<a onclick="history.go(-1)" style="color: rgb(236, 96, 35); font-family: Segoe UI Light; font-size: 40px; line-height: 1; cursor: pointer;">
							&lt; Click here to go back home
						</a>
					</div>
				</div>
			</div>
			<div class="row-fluid">
				<div class="span4 pull-right" style="padding-top: 25px">
					<a onclick="<?php echo base_url(); ?>" style="cursor: pointer;">
						<img src="<?php echo base_url(); ?>img/homepage_conceptB/logo.png"/>
					</a>
				</div>
			</div>
		</div>
	</div>
</body>
</html>