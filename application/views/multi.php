<style type="text/css">
#uploadButton_drag-and-drop
{
	display:none;
}
</style>
<link rel="stylesheet" href="<?php echo base_url(); ?>uu/universal/style.css">
<link href="<?php echo base_url(); ?>uu/styles.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url(); ?>uu/universal/universalUploader.js"></script>
<div id="universalUploader" >
<noscript>Place standard form with file input here for users who have disabled JS in browser.<br/>
Form snippet:<br/>
<form id="myform" name="myform" action="url to file processing script"  method="post" enctype="multipart/form-data">
<input name="Filedata" type="file"><br>
<input type="submit" value="Upload" />
</form>
</noscript>
</div>	
<script type="text/javascript">
$(document).ready(function() {
	var wid = parent.$('.wid').attr('id');
	var albumid = parent.$('.albumid').attr('id');
	var dataString = 'wids2='+wid+'&albumids2='+albumid;
		//alert('asda');
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>test/donothing",
			data: dataString,
			success: function(html) 
			{
				//alert(html);
			}
		});
});
universalUploader.init({
	//List of uploaders to render
	uploaders: "drag-and-drop, flash, silverlight, classic",
	singleUploader : true,
	width: "440",	
	height: "230",
	//Id of html element where universalUploader should be rendered
	//If not set, document body used  
	holder: "universalUploader",	
	//Url to the swf file
	flash_swfUrl : "<?php echo base_url(); ?>uu/universal/uploaders/ElementITMultiPowUpload.swf",
	//Url to the xap file
	silverlight_xapUrl : "<?php echo base_url(); ?>uu/UltimateUploader.xap",
	//Path to the folder with images (status icons, remove icon) By default images subfolder is used (relative to the html page base path)
	//In these examples we place icons inside universal/images subfolder. 
	imagesPath : "<?php echo base_url(); ?>uu/universal/images/",	
	url: "<?php echo base_url(); ?>multi/upload?albumid=<?php echo $albumid; ?>&pid=<?php echo $pid; ?>"
});

</script>
