<style type="text/css">
	.del-triger
	{
		visibility:hidden;
	}
	.al-holder:hover .del-triger
	{
		visibility:visible;
		position:relative;
	}
</style>
<?php
	$entry = array();
	$i = 0;
	//$query = $this->db->query("SELECT * FROM albums WHERE web_id='$wid'");
	// $query = $this->db->query($thequery);
	if($query->num_rows() > 0)
	{
		$min = $query->num_rows() - 1;
		$source = 'uploads';
		foreach($query->result_array() as $rows)
		{
			if($rows['page_id'] == $pid) {
				$albumid = $rows['id'];
				if($this->db->field_exists('album_cover', 'albums')) {
					$primary = $rows['album_cover'];
				} else {
					$primary = $rows['primary'];
				}
				$n = 0;
				// path to directory to scan
				$imagesDir = "files/".$albumid;
				// check if directory is exist 
				$this->db->where('albums', $rows['id']);
				$qgallery = $this->db->get('gallery');
				

					$images = glob($imagesDir . '/*.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF}', GLOB_BRACE);
					$countimage = 0;
					foreach($qgallery->result_array() as $gallery) {
						foreach($images as $image) {
							$imgpath = pathinfo($image);
							if(array_search($imgpath['basename'], $gallery)) {
								$countimage++;
							}
						}
					}

					if($qgallery->num_rows() > 0) {

						$img = 'files/'.$rows['id'].'/'.$primary;
						if($this->photo_model->image_exists($img)) {
							$imgsrc = base_url($img);
						} else {
							$img = 'files/'.$rows['id'].'/'.$gallery['image_file'];
							if($this->photo_model->image_exists($img)) {
								$imgsrc = base_url($img);
							} else {
								$img = 'files/'.$rows['id'].'/'.$gallery['image_name'];
								if($this->photo_model->image_exists($img)) {
									$imgsrc = base_url($img);
								} else {
									$img = 'files/'.$rows['id'].'/'.$gallery['image'];
									if($this->photo_model->image_exists($img)) {
										$imgsrc = base_url($img);
									} else {
										$img = 'uploads/'.$gallery['image'];
										if($this->photo_model->image_exists($img)) {
											$imgsrc = base_url($img);
										} else {
											$imgsrc = base_url('img/no-photo.jpg');
										}
									}
								}
							}
						}
					} else {
						$imgsrc = base_url('img/no-photo.jpg');
					}

					$alname = preg_replace("/[^a-zA-Z0-9]+/", " ", html_entity_decode($rows['album_name'], ENT_QUOTES));
					if($this->db->field_exists('descrip', 'albums')) {
						$descrip = $rows['descrip'];
					} else {
						$descrip = $rows['discrip'];
					}
					$aldesc = preg_replace("/[^a-zA-Z0-9]+/", " ", html_entity_decode($descrip, ENT_QUOTES));
					
?>
<!--hidden for phone-->
<div class="span4 hidden-phone pull-left al-holder <?php echo $i == $min ? 'lastidhere' : '' ; ?>" id="album-hold<?php echo $albumid; ?>" alt="<?php echo $albumid; ?>" style="margin-left:90px; margin-bottom:20px; text-align: left;">
	<h4 class="trim" style="margin-bottom: 0;"><?php echo $rows['album_name']; ?></h4>
	<h6 style="margin-top: 0;"><?php echo $qgallery->num_rows(); ?> photos </h6>	
	<div style="border: 9px solid #DCDCDC;border-radius: 12px 12px 12px 12px;cursor: pointer;height: 250px;position: relative;width: 250px;">
		<div class="viewpics" data-albumid="<?php echo $albumid; ?>" data-albumname="<?php echo $alname; ?>" data-albumdesc="<?php echo $aldesc; ?>" ondblclick="return false" style="background-image: url('<?php echo $imgsrc; ?>'); background-size:cover; width: 250px; height: 250px; border: 9px solid #CBCBCB; border-radius: 12px; margin-left: -16px; margin-top: -2px;">
		</div>
		<button class="btn btn-danger del-triger" onclick="delalbum(this,<?php echo $albumid; ?>)" style="float: right; right: 5px; position: absolute; top: 5px;"><i class="icon-trash icon-white"></i></button>
	</div>
	
</div>
<!--visible for phone-->
<div class="span4 visible-phone pull-left al-holder <?php echo $i == $min ? 'lastidhere' : '' ; ?>" id="album-hold<?php echo $albumid; ?>" alt="<?php echo $albumid; ?>" style="position:relative;">
	<h4 style="margin-bottom: 0;"><?php echo $rows['album_name']; ?></h4>
	<h6 style="margin-top: 0;"><?php echo $countimage; ?> photos</h6>
	<div class="span12" data-albumid="<?php echo $albumid; ?>" data-albumname="<?php echo $alname; ?>" data-albumdesc="<?php echo $aldesc; ?>" ondblclick="return false">
		<img class="span12" src="<?php echo $imgsrc; ?>">
	</div>
	<button class="btn btn-danger del-triger" onclick="delalbum(this,<?php echo $albumid; ?>)" style="right: 5px; position: absolute; top: 55px;"><i class="icon-trash icon-white"></i></button>
</div>
<?php
			
					$i++;
				// } else {
					// echo '<p style="text-align: center;">You don\'t have album yet.</p>';

			}
		}
	}
?>

<script>

	$('.viewpics').on('click', function(ev) {
		ev.preventDefault;
		ev.stopPropagation;
		var pageid = $(this).parents('.page').attr('id');
		var parentpic = $(this).parents('.page'),
			albumid = $(this).attr('data-albumid'),
			albumname = $(this).attr('data-albumname'),
			albumdesc = $(this).attr('data-albumdesc'),
			dataalbum = {
				'wid': '<?php echo $wid; ?>',
				'pid': '<?php echo $pid; ?>',
				'albumid': albumid,
				'albumname': albumname,
				'albumdesc': albumdesc
			}
		$.ajax({
			type: 'post',
			url: '<?php echo base_url(); ?>test/viewpics',
			data: dataalbum,
			beforeSend: function() {
				$(parentpic).find('#nameAlbum').val(albumname);
				$(parentpic).find('#descAlbum').val(albumdesc);
				$(parentpic).find('#idAlbum').val(albumid);

				$(parentpic).find('#old_alname_text').val(albumname);
				$(parentpic).find('#old_aldes_text').val(albumdesc);
				$(parentpic).find('.album-titles').html(albumname);
				$(parentpic).find('.album-description').html(albumdesc);

				$(parentpic).find('.c_album').hide();
				$(parentpic).find("#uploadalbum").collapse('hide');
			},
			success: function(html)
			{
				// $.ajax({
					// url: $(parentpic).find('.albumpage_form').fileupload('option', 'url'),
					// dataType: 'json',
					// context: $(parentpic).find('.albumpage_form')[0]
				// }).done(function (result) {
					// $(this).fileupload('option', 'done')
						// .call(this, null, {result: result});
				// });
				
				$(parentpic).find('.edit-album-name').show();
				$(parentpic).find("#multi-album").collapse('show');
				$(parentpic).find('.b-to-album').show();
				
				$(parentpic).find('.gallery-upload').html(html);
				$(parentpic).find('.file-list').attr('id', 'file-list_'+albumid);
			}
		});
	});
	
	function delalbum(x, albumid)
	{		
		var parentpic = $(x).parents('.page').attr('id');
		var dataalbum = { 'wid': '<?php echo $wid; ?>', 'albumid': albumid };
		$('#Modal_album_delete').modal('show');
		$('#del_album_page').val(albumid);
		$('#parentpic_album').val(parentpic);
		/* $.ajax({
			type: 'post',
			url: '<?php echo base_url(); ?>test/deletealbum',
			data: dataalbum,
			success: function(html)
			{
				$('#'+parentpic).find('#album-hold'+albumid).hide();
			}
		}); */
	}
</script>