<!doctype html>
<html>
<head>
	<link href="<?php echo base_url() ?>assets/bootstrap/css/bootstrap.css" rel="stylesheet">
	<link href="<?php echo base_url() ?>assets/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
	<link href="<?php echo base_url() ?>assets/css/bolooka.css" type="text/css" rel="stylesheet">
	<link href="<?php echo base_url() ?>assets/css/new_bolooka.css" type="text/css" rel="stylesheet">
	<title>Bolooka - Account Activated</title>
</head>
<body style="background:black;">
	<div class="container" style="margin-top: 200px;">
		<div class="row-fluid">
		<div class="span12">
			<div class="offset4 span5" style="margin-left: 30.188034%;background-color: #e34e0d;color: #fff;border-radius: 5px;">
				<div class="container-fluid" style="padding: 5px 20px;">
		<?php
			if($check == 'success')
			{
		?>
			<?php echo $msgtouser; ?>
			<script language="JavaScript" type="text/javascript">  
			var count =6
			var redirect="<?php echo base_url(); ?>dashboard"  
			  
			function countDown(){  
			 if (count <=0){  
			  window.location = redirect;  
			 }else{  
			  count--;  
			  document.getElementById("timer").innerHTML = "You will be redirected after "+count+" seconds."  
			  setTimeout("countDown()", 1000)  
			 }  
			}  
			</script>
			<h4 id="timer" style="color: #BABABA;">
			<script>  
			 countDown();  
			</script> 
			</h4>
		<?php
			}
			else
			{
		?>
			<?php echo $msgtouser; ?>
			<script language="JavaScript" type="text/javascript">  
			var count =6
			var redirect="<?php echo base_url(); ?>"  
			  
			function countDown(){  
			 if (count <=0){  
			  window.location = redirect;  
			 }else{  
			  count--;  
			  document.getElementById("timer").innerHTML = "You will be redirected after "+count+" seconds."  
			  setTimeout("countDown()", 1000)  
			 }  
			}  
			</script>
			<h4 id="timer" style="color: #BABABA;">
			<script>  
			 countDown();  
			</script> 
			</h4>
		<?php
			}
		?>
		
				</div>
			</div>
		</div>
		</div>
	</div>
	<script src="<?php echo base_url() ?>assets/bootstrap/js/bootstrap.min.js" type="text/javascript" ></script>
</body>
</html>
