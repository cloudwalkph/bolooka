<script>
	$.fx.speeds._default = 1000;
	$(function() {
		$( "#dialog2<?php echo $pid; ?>" ).dialog({
			autoOpen: false,
			show: "blind",
			width: 480,
			height: 350,
			resizable: false,
			modal: true,
			hide: "explode"
		});

		$( "#multi-upload" ).click(function() {
			$( "#dialog2<?php echo $pid; ?>" ).dialog( "open" );
			return false;
		});
	});
	
</script>
<script type="text/javascript">
$(document).ready(function() {
<?php
	if($bago == 'bago')
	{
?>
$( "#dialog2<?php echo $pid; ?>" ).dialog( "open" );
<?php
	}
?>
	var dataString = 'wid=<?php echo $wid; ?>&pid=<?php echo $pid; ?>&albumid=<?php echo $albumId; ?>';
	$('#photoholder2_inside<?php echo $pid; ?>').html('<img style="position: absolute;top: -1px;bottom: -1px;margin: auto;left: -1px;right: -1px;" src="<?php echo base_url(); ?>img/add.gif">');
	$.ajax({
		type: "POST",
		url: "<?php echo base_url(); ?>test/photos/showonly",
		data: dataString,
		success: function(html) {
			
			if(html == 'lana')
			{
				$('#photoholder2_inside<?php echo $pid; ?>').empty();
				$('#photoholder2_inside<?php echo $pid; ?>').html('<p style="text-align: center; font-size: 17px;">You have no photos</p>');
			}
			else
			{
				$('#photoholder2_inside<?php echo $pid; ?>').empty();
				$('#photoholder2_inside<?php echo $pid; ?>').html(html);
			}
		}
	});
});

</script>
<?php
	$query = $this->db->query("SELECT * FROM albums WHERE id='$albumId' ORDER BY id DESC");
	if($query->num_rows() > 0)
	{
		foreach($query->result_array() as $rows)
		{
			$title = $rows['album_name'];
			$discrip = $rows['discrip'];
			$created = $rows['created'];
		}
		
		if($title == NULL)
		{
			$title = "No Title";
		}
		
		if($created == 0)
		{
			$created = time();
		}
	}
?>
<input type="hidden" name="albumpart" value="photospart" id="albumpart" class="albumpart" />
<div id="dialog2<?php echo $pid; ?>" title="Multiple Upload" style="display:none;overflow: hidden;">
	<iframe src="<?php echo base_url(); ?>multi?albumid=<?php echo $albumId; ?>&pid=<?php echo $pid; ?>" width="460px" frameborder="0" height="300px"></iframe>
</div>
<div class="pid" id="<?php echo $pid; ?>"></div>
<div class="wid" id="<?php echo $wid; ?>"></div>
<div class="albumid" id="<?php echo $albumId; ?>"></div>
<form method="post" onsubmit="return false;" name="fotodata<?php echo $pid; ?>" id="fotodata<?php echo $pid; ?>">
<div id="album-top-button">
	<div style="margin: auto; display: inline-block; width: 210px;">
		<input type="text" name="albumname" id="album-title" class="album-title<?php echo $pid; ?>" value="<?php echo $title; ?>" />
		<textarea id="album-desc" class="album-desc<?php echo $pid; ?>" name="albumdes"><?php echo $discrip; ?></textarea>
		<p id="album-date"><?php echo date('l, F j, Y', $created).''; ?></p>
	</div>
	<div style="display: inline-block; vertical-align: top;">
		<ul id="photo-btn">
			<li><span class="button_design" id="multi-upload">upload</span></li>
			<li><button class="button_design save-photos<?php echo $pid; ?>"> save </button></li>
			<li><span class="button_design cancel-photos<?php echo $pid; ?>"> cancel </span></li>
			<li><span class="button_design back-photos<?php echo $pid; ?>"> back </span></li>
			<li><span class="button_design del-album-photos<?php echo $pid; ?>"><img style="vertical-align: middle;" src="<?php echo base_url(); ?>img/trashbtn.png"></span></li>
		</ul>
	</div>
</div>
<div id="photoholder_inside" style="width: 525px; margin: 10px auto;">
	<div id="photoholder2_inside<?php echo $pid; ?>" class="photoholder2_inside">
		
	</div>
</div>
</form>
			
<div align="center" class="last_msg_loader_inside<?php echo $pid; ?>" style="position: relative;"></div>
<div align="center" class="no_more_data_inside<?php echo $pid; ?>" style="position: relative;font-size: 16px;font-family: arial;"></div>