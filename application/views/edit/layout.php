<style>
#portfolio-filter {
	text-align: center;
}
#portfolio-filter div {
	display: inline-block;
}
#portfolio-filter div a {
    color: #656565;
    font-family: Segoe UI;
    font-size: 12px;
}
#portfolio-list {
    padding: 5px;
}
#portfolio-list div {
    display: inline-block;
	padding: 5px 2px;
}
.current {
	background: #ddd;
}
.save_layout_success {
	display:none;
}
.bg_style {
    background-position: center center;
    background-repeat: no-repeat;
    background-size: cover;
    position: relative;
}
.layouts {
/*     float: left;
    width: calc(100% / 3 - 10px); */
}

</style>
<?php
				$queryWeb = $this->db->where('id',$wid);
				$queryWeb = $this->db->get('websites');
				$rowWeb = $queryWeb->row();
				
				$website_name = $rowWeb->site_name;
				$website_id = $rowWeb->id;
				if($website_name == '')
				{
					$website_name = $rowWeb->url;
				}
?>
			<!--this is for alert-->
			<div class="alert alert-success save_layout_success">
				Saved!
			</div>
				<div class="row-fluid">
<?php
					$form_layout = array('name' => 'form_layout', 'id' => 'form_layout', 'class' => 'form-horizontal');
					echo form_open_multipart('manage/update/layout', $form_layout);
?>
					<div class="span12 head" style="font-family: Segoe UI Semibold;"> Choose Layout: </div>
					<div class="control-group">
						<div class="controls">
							<input type="hidden" name="website_id" value="<?php echo $wid; ?>" />
							<input id="curlay" type="hidden" name="layout" value="<?php echo $rowWeb->layout; ?>" />
						</div>
					</div>
<?php
						$this->db->where('website_id', $wid);
						$queryBg = $this->db->get('design');
						$rowBg = $queryBg->row();

						if($queryBg->num_rows() > 0)
						{
							$backgroundImage = $rowBg->image;
							$imageBg = str_replace('uploads/','uploads/medium/',$rowBg->image);
							if($this->photo_model->image_exists($imageBg))
							{
								$backgroundImage = $imageBg;
							}else
							{
								if($this->photo_model->image_exists($rowBg->image))
								{
									$medium = $this->photo_model->make_medium($rowBg->image);
									$backgroundImage = $medium;
								}
								
							}
							
							if($backgroundImage == '')
							{
								$backgroundImage = 'img/defaultBack.png';
							}
							$bg_id = $rowBg->website_id;
						}
						else
						{
							$backgroundImage = 'img/bolookalogo.png';
						}

?>
						<div class="bgss">
							<div class="thumbnails" style="text-align: center; margin-bottom: 20px;">
<?php
								for($i=1; $i<=3; $i++)
								{
?>
								<div class="span4 bg row layouts" id="layout<?php echo $i; ?>">
										<p>Layout <?php echo $i; ?></p>
										<a class="thumbnail bg_style" alt="layout1" style="background-image: url('<?php echo base_url($backgroundImage); ?>'); <?php echo $rowWeb->layout == 'layout'.$i ? 'box-shadow: 1px 30px 10px -28px;border-color: #08c;' : ''; ?>">
											<img src="<?php echo base_url('img/layout'.$i.'_skin2.png'); ?>" width="100%" alt="<?php echo base_url($backgroundImage); ?>">
										<?php
											echo '
											<h4 style="position: absolute; top: 5px; left: 25px; color: #000;">'.$rowWeb->url.'</h4>
											';
										?>
										</a>
								</div>
<?php
								}
?>
							</div>
							<div class="thumbnails" style="text-align: center; margin-bottom: 20px;">
<?php
								for($i=4; $i<=6; $i++)
								{
?>
								<div class="span4 bg row layouts" id="layout<?php echo $i; ?>">
										<p>Layout <?php echo $i; ?></p>
										<a class="thumbnail bg_style" alt="layout1" style="background-image: url('<?php echo base_url($backgroundImage); ?>'); background-repeat: no-repeat; <?php echo $rowWeb->layout == 'layout'.$i ? 'box-shadow: 1px 30px 10px -28px;border-color: #08c;' : ''; ?>">
											<img src="<?php echo base_url('img/layout'.$i.'_skin2.png'); ?>" width="100%" alt="<?php echo base_url($backgroundImage); ?>">
										<?php
											echo '
											<h4 style="position: absolute; top: 5px; left: 25px; color: #000;">'.$rowWeb->url.'</h4>
											';
										?>
										</a>
								</div>
<?php
								}
?>
							</div>
						</div>
<?php
	echo form_close();
?>
				</div>
				<hr />
<?php
				$this->db->where('website_id', $wid);
				$queryDes = $this->db->get('design');
				$rowDes = $queryDes->row_array();
				
				$imageDes = $rowDes['image'];
				$bg_settings = json_decode($rowDes['bg_settings']);
?>
<?php			
				$form_attrib = array('name' => 'form_design', 'id' => 'form_design', 'class' => 'form-horizontal fileupload_form');
				echo form_open_multipart('', $form_attrib);
?>

				<div class="row-fluid">
					<div class="head span12">Default Background Image:</div>
					<div class="control-group">
						<div class="controls">
							<input type="hidden" name="website_id" value="<?php echo $wid; ?>" />
							<input id="def_bg" type="hidden" name="def_bg" />
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span11 offset1">
						<div class="control-group">
							<div class="control-label">Upload Background Image:</div>
							<div class="controls">
								<div class="fileupload fileupload-new" data-provides="fileupload">
									<div class="fileupload-new thumbnail" style="max-width: 200px; max-height: 150px;"><img src="<?php echo $imageDes ? base_url().$imageDes : 'http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image'; ?>" /></div>
									<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
									<div>
										<span class="btn btn-file fileinput-button"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span><input type="file" name="upload_bg" accept="image/*" /></span>
										<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="row-fluid wrapper" id="contentWrapper">
					<div class="span12 boundingBox" id="contentSlide">
						<div style="margin-left: 12px;">Or Choose your Background Image: </div>
					<?php 
						$queryImage = $this->db->query("SELECT * FROM backgrounds");
						$queryCategory = $this->db->query("SELECT DISTINCT `category` FROM backgrounds");
					?>
						<div style="margin-top: 20px;">
							<div id="portfolio-filter">
								<div><a href="#all" title="">All</a></div> 
						<?php 
							foreach ($queryCategory->result_array() as $rowCategory)
							{
								$imgCategory = $rowCategory['category'];
								$strReplace = str_replace(' ','',$imgCategory);
						?>
								|   <div><a class="current" href="#<?php echo $strReplace; ?>" title="<?php echo $imgCategory; ?>" rel="<?php echo $imgCategory; ?>"><?php echo $imgCategory; ?></a></div>  
						<?php } ?>

							</div>
						</div>
					</div>
					<div class="container-fluid">
					<div style="overflow-y: auto; overflow-x: hidden; border: 1px solid #ddd; height: 218px;">
						<div id="portfolio-list">
<?php
						foreach ($queryImage->result_array() as $rowImage)
						{
							$imgId = $rowImage['id'];
							$imgCategory = $rowImage['category'];
							$imageSrc = $rowImage['image'];
							$imgName = $rowImage['name'];
							$strReplace = str_replace(' ','',$imgCategory);
?>
							<div class="<?php echo $strReplace; ?>">
<?php
							if($imageSrc) {
?>
								<a id="click" title="">
									<img id="<?php echo $imgId; ?>" class="classImage" style="border: 1px solid #656565" src="<?php echo base_url().'img/backgroundsThumbs/'.$imageSrc; ?>" alt="<?php echo $imageSrc; ?>" /></label>
								</a>
								
						<?php } else { ?>
								<a id="click"><span style="float: right; margin: 52px 51px;">No image</span></a>
						<?php } ?>
							<p><?php echo $imgName; ?></p>
						</div>
<?php					} ?>
						</div>
					</div>
					</div>
						<br/>
						<div class="head">Background: </div>
						<div class="control-group">
							<label class="control-label">Disable Background: </label>
							<div class="controls">
								<label class="radio inline">
									<input type="radio" name="nobg" value="1" <?php echo $rowDes['nobg']==1 || $rowDes['nobg']=='on' ? 'checked' : ''; ?>>
									Yes
								</label>
								<label class="radio inline">
									<input type="radio" name="nobg" value="0" <?php echo $rowDes['nobg']==0 || $rowDes['nobg']=='off' ? 'checked' : ''; ?>>
									No
								</label>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="checkbox">Background Repeat: </label>
							<div class="controls">
								<label class="radio inline">
									<input type="radio" name="bgrepeat" value="1" <?php echo isset($bg_settings->bgrepeat) ? ($bg_settings->bgrepeat==1 ? 'checked': '') : ''; ?>>
									Yes
								</label>
								<label class="radio inline">
									<input type="radio" name="bgrepeat" value="0" <?php echo !isset($bg_settings->bgrepeat) ? 'checked' : ($bg_settings->bgrepeat!=1 ? 'checked': ''); ?>>									
									No
								</label>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="checkbox">Background Color: </label>
							<div class="controls">
								<input type="text" value="<?php echo $rowDes['bgcolor']; ?>" class="span3 color-picker" id="bgcolor" name="bgcolor">
							</div>
						</div>

						<hr />
						
						<div class="head">Body: </div>

						<div class="control-group">
							<label class="control-label" for="checkbox">Font Color: </label>
							<div class="controls">
								<input type="text" class="span3 color-picker" id="font_color" value="<?php echo $rowDes['font_color']; ?>" name="font_color">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="checkbox">Font Style: </label>
							<div class="controls">
								<input type="text" class="span3" id="font_style" value="<?php echo $rowDes['font_style']; ?>" name="font_style">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="checkbox">Font Size: </label>
							<div class="controls">
								<select class="span3" id="font_size" name="font_size">
<?php
								for($i = 1; $i <= 16; $i++) {
?>
								<option <?php echo $rowDes['font_size'] == $i ? 'selected' : ''; ?> value="<?php echo $i; ?>" ><?php echo $i; ?></option>
<?php
								}
?>
								</select>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="checkbox">Content Box Color: </label>
							<div class="controls">
								<input type="text" class="span3 color-picker" id="boxcolor" value="<?php echo $rowDes['boxcolor']; ?>" name="boxcolor">
							</div>
						</div>
						
						<hr />
						
						<div class="head">Menu: </div>
						
						<div class="control-group">	
							<label class="control-label" for="checkbox">Font Color: </label>
							<div class="controls">
								<input type="text" class="span3 color-picker" id="menu_color" value="<?php echo $rowDes['menu_color']; ?>" name="menu_color">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="checkbox">Font Style: </label>
							<div class="controls">
								<input type="text" class="span3" id="menu_style" value="<?php echo $rowDes['menu_style']; ?>" name="menu_style"/>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="checkbox">Font Size: </label>
							<div class="controls">
								<select class="span3" id="menu_size" name="menu_size">
<?php
								for($i = 1; $i <= 16; $i++) {
?>
								<option <?php echo $rowDes['menu_size'] == $i ? 'selected' : ''; ?> value="<?php echo $i; ?>" ><?php echo $i; ?></option>
<?php
								}
?>
								</select>
							</div>
						</div>
						
						<div class="control-group">
							<label class="control-label" for="checkbox">Background Color: </label>
							<div class="controls">
								<input type="text" class="span3 color-picker" id="menu_bgcolor" value="<?php echo $rowDes['menu_bgcolor']; ?>" name="menu_bgcolor">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="checkbox">Mouse Over: </label>
							<div class="controls">
								<input type="text" class="span3 color-picker" id="menu_over" value="<?php echo $rowDes['menu_over']; ?>" name="menu_over">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="checkbox">Active: </label>
							<div class="controls">
								<input type="text" class="span3 color-picker" id="menu_active" value="<?php echo $rowDes['menu_active']; ?>" name="menu_active">
							</div>
						</div>
						
						<hr>
						
						<?php
							$this->db->where('website_id', $wid);
							$query_footer = $this->db->get('footer');
							$row_footer = $query_footer->row();
						?>
						<div class="head">Footer: </div>

						<div class="control-group">
							<label class="control-label">Disable Footer: </label>
							<div class="controls">
								<label class="radio inline">
									<input type="radio" name="footer_noads" value="1" <?php echo $row_footer->noads == 1 || $row_footer->noads == 'on' ? 'checked' : ''; ?>>
									Yes
								</label>
								<label class="radio inline">
									<input type="radio" name="footer_noads" value="0" <?php echo $row_footer->noads == 0 || $row_footer->noads == 'off' ? 'checked' : ''; ?>>
									No
								</label>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="checkbox">Font Color: </label>
							<div class="controls">
								<input type="text" class="span3 color-picker" id="footer_color" value="<?php echo $row_footer->color; ?>" name="footer_color">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="checkbox">Background Color: </label>
							<div class="controls">
								<input type="text" class="span3 color-picker" id="footer_bgcolor" value="<?php echo $row_footer->bgcolor; ?>" name="footer_bgcolor">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="checkbox">Label: </label>
							<div class="controls">
								<textarea rows="6" type="text" id="footer_label" rows="4" class="span8" name="footer_label"><?php echo $row_footer->label; ?></textarea>
							</div>
						</div>

						<hr>
						
						<div class="control-group">												
							<div class="controls">
								<button type="submit" class="btn" id="reset_design" name="reset_layout" value="reset" data-loading-text="Wait...">Reset</button>
								<button type="submit" class="btn" id="submit_design" data-loading-text="Saving..." value="">Save changes</button>
							</div>
						</div>
				</div>
<?php
				echo form_close();
?>
    <div id="layout_loading_modal" class="modal hide fade">
		<div class="modal-body">
			<p>Saving please wait...</p>
		</div>
    </div>
<style>
	.bg {
		text-align:center;
	}
	.bg:hover {
		cursor:pointer
	}
	.bg div img {
		width: 100%;
	}
</style>
<script>
	$(document).ready(function(){

		$('.bg').click(function(){
			var bg = $(this);
			$('.bg').children('.thumbnail').css('box-shadow','none').css('border-color','#fff');
			bg.children('.thumbnail').css('box-shadow', '1px 30px 18px -28px').css('border-color', '#08c');
			$('#curlay').val(bg.attr('id'));
			$("#form_layout").ajaxForm().submit();
		});
		
		$('.classImage').click(function(){
			$('.classImage').css('box-shadow','none');
			$(this).css('box-shadow','0 6px 7px -4px #000000');
			
			var imageName = $(this).attr('alt');
			// var imageSource = '<img style="max-height: 150px;" src="<?php echo base_url(); ?>img/newBackgrounds/'+imageName+'" />';
			// $('.fileupload-preview').html(imageSource);
			
			// $('#upload_bg').removeClass('fileupload-new').addClass('fileupload-exists');
			$('#def_bg').val(imageName);
			// $('.currentLabel').html('Selected background');
		});
			
		$("#form_design").ajaxForm({
			beforeSubmit: function(el, i) {
				$('#layout_loading_modal').modal({
					backdrop: 'static',
					keyboard: 'false'
				});
			},
			url: '<?php echo base_url(); ?>manage/update/design',
			type: 'post',
			data: undefined,
			success: function(html) {
				if(html == 'reset') {
					location.reload();
				} else {
					var obj = JSON.parse(html);
					if(typeof obj.uploaded === 'string') {
						alert(obj.uploaded);
					}
					$("#layout").find('.fileupload').removeClass('fileupload-exists').addClass('fileupload-new');
					$("#layout").find('a.thumbnail').css('background-image', 'url('+obj.thumbs+')');
					$("#layout").find('.fileupload-new.thumbnail img').attr('src', obj.thumbs);
					$('body, html').animate({
						scrollTop:0
					},500,function(){
						$('.save_layout_success').show();
						setTimeout(function(){
							$('.save_layout_success').hide();
						},2000);
					});
					form_design.upload_bg.value = '';
					form_design.def_bg.value = '';
				}
				$('#layout_loading_modal').modal('hide');
			}
		});
			
			/* di pa gumagana down here */
			
			/* hover image */
			$('.image').hover(function(e) {
				xOffset = 150;
				yOffset = -450;
				var thisScr = $(this).attr('alt');
				var thisAlt = $(this).attr('src');
				$('.hasLeftCol').append("<p id='preview1' style='background-image: url("+thisScr+"); background-size: cover;'><img src='"+ thisAlt +"' alt='Image preview' /></p>");
				$("#preview1")
					.css("top",(e.pageY - xOffset) + "px")
					.css("left",(e.pageX + yOffset) + "px")
					.fadeIn("slow");
			},function(){
				var thisid = $(this).attr('id');
				$('.bg'+thisid).css('box-shadow','none');
				$('#preview1').remove();
			});
			$('.image').mousemove(function(e){
				$('#preview1')
					.css("top",(e.pageY - xOffset) + "px")
					.css("left",(e.pageX + yOffset) + "px");
			});
	});

</script>