<html>
<head>
<script src="<?php echo base_url(); ?>js/jquery.js" type="text/javascript"></script>



<script>
var refreshId = setInterval(function()
		{
			 $('#responsecontainers').hide();
			$('#responsecontainer').load('<?php echo base_url()?>dashboard/test').show();
			 
		},5000);
</script>

</head>


<style>
#responsecontainer:first-child{
display:block;

}


</style>


<body>
<?php $loginLog = $this->db->get('albums');?>
<div id="responsecontainers">
<?php foreach($loginLog->result() as $recentLogin): ?>
	
	<div><?php echo $recentLogin->id ?></div>
	 
<?php endforeach?> 
</div>
		<div id="responsecontainer"></div>
</body>

</html>