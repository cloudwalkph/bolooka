<style>
.btn_add_album {
background: #e1e1e1; /* Old browsers */
background: -moz-linear-gradient(top,  #e1e1e1 0%, #929292 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#e1e1e1), color-stop(100%,#929292)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #e1e1e1 0%,#929292 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #e1e1e1 0%,#929292 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #e1e1e1 0%,#929292 100%); /* IE10+ */
background: linear-gradient(to bottom,  #e1e1e1 0%,#929292 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#e1e1e1', endColorstr='#929292',GradientType=0 ); /* IE6-9 */

    border-radius: 15px 15px 15px 15px;
    font-family: Century Gothic;
    font-size: 15px;
    font-weight: bold;
    padding: 5px;
}
</style>
<?php $this->load->model('times_model');  ?>
	<input type="hidden" name="albumpart" value="albumpart" id="albumpart" class="albumpart" />
	<div class="c-al" style="display:none;">
		<div id="dialog<?php echo $pid;?>-form" title="Create new album:" style="font-size: 62.5%;">
			<p class="validateTips"></p>
			<form>
			<fieldset>
				<label class="al_name" style="font-size: 14px;margin-bottom: 5px;text-align: left;width: 131px;" for="albumnames<?php echo $pid;?>">Album Name</label>
				<input style="padding: 3px 2px;height: 16px;width: 307px;font-size: 14px;" type="text" name="albumnames<?php echo $pid;?>" id="albumnames<?php echo $pid;?>" class="text ui-widget-content ui-corner-all" />
				<label style="font-size: 14px;margin-top: 11px;text-align: left;width: 180px;" for="albumdesrip">Album Description</label> 
				
				<textarea name="albumdesrip<?php echo $pid;?>" id="albumdesrip<?php echo $pid;?>" style="padding-top: 3px;padding-left: 2px;resize:none;height: 104px;margin-left: 1px;margin-top: 7px;width: 308px;font-size: 16px;" class="text ui-widget-content ui-corner-all title-textarea"></textarea>
			</fieldset>
			</form>
		</div>
	</div>
	<div id="album-top-button">
		<div style="float: left;">
			<span style="font-size: 21px; font-family: Century Gothic; font-weight: bold;">Your Album :</span>
		</div>
		<div style="float: right;">
			<div id="create-user2<?php echo $pid;?>" class="btn_add_album create-user2">
				<span>+ add album</span>
			</div>
		</div>
	</div>
	<div  id="photoholder">
		<div id="photoholder2<?php echo $pid;?>" class="photoholder2" style="margin: auto; width: 525px;">
		</div>
		<div id="clear"></div>
	</div>
		
	<div align="center" class="last_msg_loader<?php echo $pid;?>" style="position: relative;"></div>
	<div align="center" class="no_more_data<?php echo $pid;?>" style="position: relative;font-size: 16px;font-family: arial;"></div>
<script>
	$( "#dialog<?php echo $pid;?>:ui-dialog" ).dialog( "destroy" );
	
	var albumnames = $( "#albumnames<?php echo $pid;?>" );
	var	ogallery = $( ".only-gallery" );
	var	albumdesrip = $( "#albumdesrip<?php echo $pid;?>" );
	
	$( "#dialog<?php echo $pid;?>-form" ).dialog({
		autoOpen: false,
		resizable: false,
		width: 345,
		modal: true,
		buttons: {
			"Create an Album": function() {
				var bValid = true;
				//alert('aid=create-album2&pid=<?php echo $pid; ?>&alname=' + albumnames.val() + '&aldesc=' + albumdesrip.val());
				if ( bValid ) {
					var dataString = 'aid=create-album2&wid=<?php echo $wid; ?>&pid=<?php echo $pid; ?>&albumname=' + albumnames.val() + '&albumdesc=' + albumdesrip.val();
					
					//$('#photo' + ogallery.val()).html('<img src="<?php echo base_url(); ?>img/bigLoader.gif" />');
					
					$.ajax({
							type: "POST",
							url: "<?php echo base_url(); ?>test/create_new_album",
							data: dataString,
							cache: false,
							success: function(html)
							{
								albumnames.val('');
								albumdesrip.val('');
								$('#album-holder<?php echo $pid; ?>').empty();
								$('#album-holder<?php echo $pid; ?>').html(html);
							}
						});
						$( this ).dialog( "close" );

				}
			},
			Cancel: function() {
				$( this ).dialog( "close" );
			}
		},
		close: function() {

		}
	});

$(function() {
	var dataString = 'wid=<?php echo $wid; ?>&pid=<?php echo $pid; ?>';
	$('#photoholder2<?php echo $pid;?>').html('<img style="position: absolute;top: -1px;bottom: -1px;margin: auto;left: -1px;right: -1px;" src="<?php echo base_url(); ?>img/bigLoader.gif">');
	$.ajax({
		type: "POST",
		url: "<?php echo base_url(); ?>test/albums",
		data: dataString,
		success: function(html) {
		
			if(html == 'lana')
			{
				$('#photoholder2<?php echo $pid;?>').empty();
				window.bSuppressScroll = true;
				$('#photoholder2<?php echo $pid;?>').html('<p class="no-album-created">You have no album</p>');
			}
			else
			{
				$('#photoholder2<?php echo $pid;?>').empty();
				window.bSuppressScroll = false;
				$('#photoholder2<?php echo $pid;?>').html(html);
			}
			
		}
	});

	$( "#create-user2<?php echo $pid;?>" )
		.click(function() {
			$( "#dialog<?php echo $pid;?>-form" ).dialog('open');
		});
});
</script>