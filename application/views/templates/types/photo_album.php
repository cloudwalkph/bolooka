<?php
	$photopage = "";

	if($pages['type'] == 'photo')
	{
		if($pages['url'] == null)
		{
			$urlpage = url_title($pages['name'], '-', true);
		}
		else
		{
			$urlpage = $pages['url'];
		}
		$photopage = base_url(url_title($url,'-',true).'/'.$urlpage);
	}
?>
<!--<ul class="breadcrumb">
	<li><a href="<?php //echo $photopage; ?>">Albums</a> <span class="divider">/</span></li>
</ul>-->
<div class="row-fluid photo_title"><p style="margin: 10px 16px 10px;">Photos</p></div>
<div id="photo_container" class="row-fluid">
<?php
	$this->db->where('web_id', $wid);
	$this->db->where('page_id', $pid);
	$this->db->order_by('id desc');
	$qalbums = $this->db->get('albums');

	if($qalbums->num_rows() > 0):
?>
	<ul class="inline album-holder">
<?php
		foreach($qalbums->result_array() as $rows)
		{
			$albumid = $rows['id'];
			if($this->db->field_exists('album_cover', 'albums')) {
				$primary = $rows['album_cover'];
			} else {
				$primary = $rows['primary'];
			}
			
			$this->db->where('albums', $albumid);
			$query_gal = $this->db->get('gallery');
			
				$imagesDir = "files/".$albumid.'/';
				$images = glob($imagesDir . '*.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF}', GLOB_BRACE);
				
				$imgsrc = null;
				$img = $imagesDir.$primary;
				if($this->photo_model->image_exists($img)) {
					$imgsrc = base_url($img);
				} else {
					if(count($images) > 0) {
						$img = $images[0];
						$imgsrc = base_url($img);
					} else {
						$imgsrc = 'http://www.placehold.it/240x240/333333/ffffff&text=image+missing';
					}
				}

				if($query_gal->num_rows() > 0) {
					// if($query_gal->num_rows() == count($images)) {
?>
					<li class="album-listed">
							<a href="<?php echo $photopage.'?albumid='.$albumid; ?>" id="<?php echo $rows['id']; ?>" class="showphoto" style="color: rgb(221, 221, 221); text-decoration: none;">
								<div class="img-div" style="background-image: url('<?php echo $imgsrc; ?>'); background-repeat: no-repeat; background-position: center center; background-size: contain;">
									<div class="row-fluid fadeout" style="background-image: url('<?php echo base_url('img/gradient_bg.png'); ?>'); background-size: cover; height: 100%;">
										<div class="text-center trim" style="border-bottom: 1px solid rgb(221, 221, 221); font-size: 17px; padding: 4px; margin: 4px;">
											<?php echo $rows['album_name']; ?>
										</div>
										<div class="text-center">
											<i class="icon-picture icon-white"></i>
											<p style="font-size: 14px;"><?php echo $query_gal->num_rows(); ?> Photo(s)</p>
										</div>
									</div>
								</div>
							</a>
					</li>
<?php
					// }
				}
		}
?>
	</ul>
<?php
	else:
		if($this->session->userdata('logged_in'))
		{
			$data['saying'] = 'You don&rsquo;t have photo albums yet.';
			$this->load->view('templates/types/no_contents', $data);
		}else
		{
			$data['saying'] = 'No photo albums yet.';
			$this->load->view('templates/types/no_contents', $data);
		}
	endif;
?>
</div>
<script>
$(function() {
	
	$('.showphoto').click(function() {
		// var url = '<?php echo base_url(); ?>multi/viewphotoFE';
		// var datastring = { wid: '<?php echo $wid; ?>', albumid: $(this).attr('id') };
		// $.ajax({
			// type: 'post',
			// url: url,
			// data: datastring,
			// beforeSend: function() {
				// $('.photo_content').html('<p style="text-align: center;"><img src="<?php echo base_url(); ?>img/ajax-loader.gif" /></p>');
			// },
			// success: function(html) {
				// $('.photo_content').empty().html(html);
			// }
		// });
	});
	
});
</script>