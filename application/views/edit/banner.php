<style>
.deleteImage {
    background-image: url("http://localhost/project-bolooka/img/close_button.png");
    cursor: pointer;
    height: 29px;
    position: absolute;
    right: 0;
    top: 0;
    width: 29px;
}
</style>
<?php
	$this->db->where('website_id', $wid);
	$this->db->order_by('sequence asc');
	$queryBanner = $this->db->get('banner');

				if(isset($_GET['save']))
				{
					if($_GET['save'] == 'banner')
					{
				?>
						<center><div class="confirmSave" style="margin-bottom:35px;">Saved Successfully!</div></center>
				<?php
					} elseif($_GET['save'] == 'deleteAll') {
				?>
						<center><div class="confirmSave" style="margin-bottom:35px;">Successfully Deleted</div></center>
				<?php
					}

				}

					$form_attrib = array('name' => 'form_banner', 'id' => 'form_banner', 'onsubmit' => 'return false', 'class' => 'form-horizontal');
					echo form_open_multipart('test/upload/banner', $form_attrib);
?>
						<input type="hidden" name="website_id" value="<?php echo $wid; ?>">
<?php
					$queryCheckSett = $this->db->query("SELECT * FROM `banner_sett` WHERE `web_id` = '".$wid."'");
					if($queryCheckSett->num_rows() > 0)
					{
						$update_banner_sett = array(
							'speed' => $this->input->post('speed'),
							'enable' => $this->input->post('banner_enable')
						);
						$this->db->where('web_id', $wid);
						$this->db->update('banner_sett', $update_banner_sett);
					}
					else
					{
						$insert_banner_sett = array(
							'web_id' => $wid,
							'speed' => 0,
							'enable' => 0
						);
						$this->db->insert('banner_sett', $insert_banner_sett);
					}
						
							$sett = "SELECT * FROM `banner_sett` WHERE `web_id` = '".$wid."'";
							$querySett = $this->db->query($sett);
							$resultSett = $querySett->row();

?>
							<div class="control-group">
								<label class="control-label">Enable Banner:</label>
								<div class="controls">
									<label class="radio inline">
										<input type="radio" name="banner_enable" value="1" <?php echo isset($resultSett->enable) == 1 ? 'checked="checked"' : ''; ?> /> Yes
									</label>
									<label class="radio inline">
										<input type="radio" name="banner_enable" value="0" <?php echo isset($resultSett->enable) == 0 ? 'checked="checked"' : ''; ?> /> No
									</label>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Transition Speed:</label>
								<div class="controls">
									<input type="number" id="max_speed" min="1" max="60" name="speed" value="<?php echo isset($resultSett->speed) ? $resultSett->speed : 5; ?>" /> seconds <em>(numerical values only)</em>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Upload Images:</label>
								<div class="controls">
									<input type="file" name="imageBanner[]" multiple="multiple" id="imageBanner" />
								
									<input type="hidden" name="websiteId" value="<?php echo $wid; ?>" />
								</div>
							</div>

						<div id="loading"></div>
						<ul id="bannerSort" class="inline">
<?php
						foreach($queryBanner->result() as $row) {
?>
							
								<li>
									<div style="height: 80px; width: 130px; position: relative; overflow: hidden;" class="thumbnail">
									<?php if($row->disable == 'yes') { ?>
										<div style="background-color: rgba(0, 0, 0, 0.3); position: absolute; height: 80px; width: 130px;">
											<div style="position: absolute; font-size: 24px; width: 130px; line-height: 80px; text-align: center; color: rgba(255, 255, 255, 0.5);">
												Disabled
											</div>
										</div>
									<?php } ?>
										<img src="<?php echo base_url().'uploads/'.$row->images; ?>" style="max-height: 80px; max-width: 130px;" />
										<a id="<?php echo $row->id ?>" class="deleteImage" name="buttonB" title="Delete this image"></a>
									</div>
									<input type="hidden" name="<?php echo $row->id ?>" />
								</li>
							
<?php
						}
?>
						</ul>
						<hr />
							<div id="button_holder" style="text-align: right;">
							<?php 
								if($queryBanner->num_rows() > 0)
								{
							?>
									<button name="deleteAll" value="deleteAll" id="delete_button" class="button_design"> delete all </button>
							<?php
								}
							?>
									<button class="button_design" id="save_button" name="buttonB" value="save"> save </button>
							</div>
<?php
	echo form_close();
?>


	<script>
	$(function() {
		$( "#bannerSort" ).sortable({
			revert: true,
			update: function() {
				$('#bannerSort li img').each(function(i,el) {
					el.id = i;
				});
				$('#bannerSort li input').each(function(i,el) {
					i=i+1;
					el.value = i;
				});
				
				var banner_data = $('#form_banner').serialize();
				
				$.ajax({
				  type: "POST",
				  url: "<?php echo base_url(); ?>test/banner_sequence",
				  data: banner_data
				}).done(function( msg ) {
				});
			},
			// placeholder: "ui-state-highlight"
		});
		$( "#bannerSort" ).disableSelection();
		
		$(function() {
			/*
			*   Examples - images
			*/
			setInterval(function(){
				$('.confirmSave').fadeOut(2000);
			},2500);
			
			/* delete banner */
			$('#form_banner').delegate('.deleteImage', 'click', function() {
			
				var id = $(this).attr('id');
				$('#del_banner').val(id);
				confirmdel_banner(this, id);
				
			});
		});
		
		function confirmdel_banner(el, imageId)
		{
			var dataString = { 'bannerId': imageId };
			
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>test/delete_banner",
				data: dataString,
				cache: false,
				success: function(html)
				{
					$(el).parents('li').remove();
				}
			});
		}
		
		$('#form_banner').delegate('#imageBanner', 'change', function() {
			$("#form_banner").ajaxForm({
				type: "POST",
				url: "<?php echo base_url(); ?>test/upload_banner",
				beforeSubmit: function() {
					$('#bannerSort').append('<li class="unloading"><img src="<?php echo base_url('img/loader.gif'); ?>" style="margin: 30px 0px;width: 130px;"></li>');
				},
				success: function(html) {
					$('.unloading').hide();
					$('#bannerSort').append(html);
				}
			}).submit();
		}); 
		
		$('#form_banner').delegate('#save_button', 'click', function() {
			$("#form_banner").ajaxForm({
				type: 'post',
				url: "<?php echo base_url(); ?>test/update_banner",
				success: function(html) {

				}
			}).submit();		
		});
		
		$('#form_banner').delegate('#delete_button', 'click', function() {
			$("#form_banner").ajaxForm({
				type: "POST",
				url: "<?php echo base_url(); ?>test/delete_banner_all",
				success: function(html) {
					window.location = '<?php echo base_url(); ?>dashboard/edit/banner?wid=<?php echo $wid; ?>';
					// alert(html);
				}
			}).submit();		
		});

	});
	</script>
				