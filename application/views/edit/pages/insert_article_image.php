<div id="article_image_container" style="border: 1px dashed rgb(153, 153, 153); text-align: center; padding: 10px; margin-bottom: 20px;">
	<?php
		$attributes = array('class' => 'article_image_form', 'id' => 'article_image_form', 'name' => 'article_image_form');
		echo form_open_multipart(base_url('manage/upload_article_image'), $attributes);
	?>
		<fieldset>
	<?php /*
			<div class="btn insert_image" type="button" style="position: relative; overflow: hidden;">
				Upload from File
				<input id="upload_article_image" class="upload_article_image" type="file" name="article_images[]" multiple="multiple" style="opacity: 0; position: absolute; top: 0px; left: 0px;" />
			</div>
	*/ ?>
			<button class="btn insert_image show_gallery_modal" data-image-position="<?php echo $position; ?>" type="button">Upload from Gallery</button>
		</fieldset>
	<?php
		echo form_close();
	?>

	<div>
		<ul class="inline albums_container" style="white-space: nowrap; overflow-x: auto;">
	<?php	

		$this->db->where('article_images.page_id', $pid);
		$this->db->where('article_images.image_position', $position);
		$this->db->join('gallery', 'gallery.id = article_images.gallery_id', 'left');
		$qimages = $this->db->get('article_images');
		
		if($qimages->num_rows() > 0) {
			$rimages = $qimages->result_array();
			foreach($rimages as $gallery) {
				$img = 'files/'.$gallery['albums'].'/'.$gallery['image_file'];
				$imgsrc = base_url($img);
	?>
				<li style="vertical-align: text-top;">
					<div style="height: 80px; width: 80px">
						<img src="<?php echo $imgsrc; ?>" alt="<?php echo $gallery['image_name']; ?>" style="max-width: 80px; max-height: 80px;">
					</div>
				</li>
	<?php
			}
		} else {
	?>
			<div style="font-size: 1em;"> No Image/s Selected </div>
<?php
		}
?>
		</ul>
	</div>
</div>