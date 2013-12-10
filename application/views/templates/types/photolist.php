<?php 

	$photopage = "";
	if($pages['type'] == 'photo')
	{
		if($pages['url'] == null)
		{
			$urlpage = url_title($pages['name'],'-',true);
		}
		else
		{
			$urlpage = $pages['url'];
		}
		$photopage = base_url(url_title($url,'-',true).'/'.$urlpage);
	}
	$this->db->where('id', $albumid);
	// $this->db->where('web_id', $wid);
	$this->db->order_by('id desc');
	$qAlbums = $this->db->get('albums');
	$entry = array();
	if($qAlbums->num_rows() > 0)
	{
		$i = 0;
		$thisresult = $qAlbums->row_array();
		$album_name = $thisresult['album_name'];
		$discrip = $thisresult['discrip'];
?>
<div class="row-fluid photo_title">
	<div class="pull-right" style="margin: 10px;">
		<a class="b2album" href="<?php echo $photopage; ?>">Back to Albums</a>
	</div>
	<h4 style="margin: 10px 10px;"><?php echo $album_name; ?></h4>
<?php
	if($discrip != 0) {
?>
	<p style="margin: 0 10px 10px;"><?php echo $discrip; ?></p>
<?php
	}
?>
</div>
<?php
		//path to directory to scan
		// $width = '';
		// $height = '';
		$imagesDir = "files/".$albumid.'/';
		$images = glob($imagesDir.'*.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF}', GLOB_BRACE);
		$imgcount = count($images);
		$totalcnt = $imgcount - 1 ;
		
		$this->db->where('albums', $albumid);
		$this->db->order_by('sortdata');
		$qgallery = $this->db->get('gallery');

		if($qgallery->num_rows() > 0):
?>
	<ul class="inline text-center photo_holder">
<?php
		foreach($qgallery->result_array() as $key => $gallery)
		{
			$image = null;
			$img = "files/".$albumid.'/medium/' . $gallery['image_file'];
			if($this->photo_model->image_exists($img)) {
				$image = base_url($img);
			} else {
				$img = "files/".$albumid.'/' . $gallery['image_file'];
				if($this->photo_model->image_exists($img)) {
					$medium = $this->photo_model->make_medium($img);
					$image = base_url($medium);
				} else {
			
				$img = "files/".$albumid.'/medium/' . $gallery['image_name'];
				if($this->photo_model->image_exists($img))
				{
				// /* detect if file is duplicate show only original file */
					// $mystring = $img;
					// $findme   = '(1)';
					// $pos = strpos($mystring, $findme);
				// if ($pos === false) {
						$image = base_url($img);
					// $strimage = str_replace($imagesDir, '', $image);
				} else {
					$img = "files/".$albumid.'/medium/' . $gallery['image'];
					if($this->photo_model->image_exists($img)) {
						$image = base_url($img);
					} else {
						$img = 'uploads/'.$gallery['image'];
						if($this->photo_model->image_exists($img)) {

							/* copy photo from uploads to files */
							// $basename = pathinfo($img);
							// $newDir = 'files/'.$albumid.'/';
							// if(!is_dir($newDir))
							// {
							   // mkdir($newDir, 0755, true);
							// }
								// /* convert to md5 then to decimal */
								// $newfilename = $basename['filename'];
								// $newfilename = hash('md5', $newfilename);
								// $newfilename = base_convert($newfilename, 16, 10);
								
								// /* */
							// $newPath = $newDir.$newfilename.'.'.$basename['extension'];
							// if(rename($img, $newPath)) {
								// $img = $newPath;
							// }
							
							// $update_gallery = array(
								// 'image_file' => $newfilename.'.'.$basename['extension'],
							// );
							// $this->db->where('id', $gallery['id']);
							// $this->db->update('gallery', $update_gallery);
							/* */

							$image = base_url($img);
						} else {
							$image = base_url('img/no-photo.jpg');
						}
					}
				}
				}
			}
?>
		<li>
			<div class="photo-listted">
				<a href="javascript:void(0)" alt="<?php echo $img; ?>" class="showimage" data-imgid="<?php echo $gallery['id']; ?>" data-albumid="<?php echo $albumid; ?>" data-key="<?php echo $key; ?>" >
					<div class="">
						<img class="img_photo" src="<?php echo $image; ?>">
					</div>
				</a>
			</div>
		</li>
<?php		
			// }
		}
?>
	</ul>
<?php
		else:
			if($this->session->userdata('logged_in'))
			{
				$data['saying'] = 'You don&rsquo;t have photos yet.';
				$this->load->view('templates/types/no_contents', $data);
			} else {
				$data['saying'] = 'No photos yet.';
				$this->load->view('templates/types/no_contents', $data);
			}
		endif;
	}
	else
	{
		echo '<p>You have no Album.</p>';
	}
?>
</ul>
<script>
$(function() {
	$('.showimage').click(function(e) {
		var x = this;
		var k = $(x).attr('data-key');
		var albumid = $(x).attr('data-albumid');
		var imgid = $(x).attr('data-imgid');
		var image = $(x).find('img').attr('src');
		var stageheight = $('#light').height();
		var datastrings = 'image='+imgid;

			$('.img-ctrl').attr('id', albumid);
			$('#img-holder').css({
				'background-image': 'url("'+image+'")',
				'height': stageheight+'px',
				'background-position': 'center center',
				'background-repeat': 'no-repeat',
				'background-size': 'contain'
			});
			$('#img-holder').attr({
				'alt': k,
				'data-imgid': imgid
			});
			$('#img-comment').css('height', stageheight+'px');
			$('#light').show();
			$('#fade').show();
			$.ajax({
				type: 'post',
				url: '<?php echo base_url(); ?>test/imagecomment',
				data: datastrings,
				success: function(html){
					$('#img-comment').html(html);
				}
			});
	});
});
</script>