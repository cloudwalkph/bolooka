<?php
	echo $holder;
?>
<div class="container logo_design">
	<div class="container-fluid comp_logo">
		<a class="brand logo-style" href="<?php echo base_url().url_title($url); ?>">
			<h1>
<?php
			$maxheight = '100px';
			if($logo->logosize == 1){
				$maxheight = '120px';
			}elseif($logo->logosize == 2){
				$maxheight = '140px';
			}
			if($logo->nologo == '1')
			{
				if($site_name) {
					echo '<span>'.$site_name.'</span>';
				} else {
					echo '<span>'.url_title($url).'</span>';
				}
			}
			else
			{
				if($logo->image != null) {
					echo '<img src="'. base_url().'uploads/'.str_replace('uploads/', '', $logo->image) .'" style="max-height: '.$maxheight.';" alt="'. $site_name .'">';
				} else {
					echo '<span>'.$site_name.'</span>';
				}
			}
?>
			</h1>
		</a>
	</div>
</div>
<div class="">
	<div class="row-fluid">
		<div class="nav_design">
			<div class="container" style="margin: auto; max-width: 1170px; font-family: <?php echo $bg->menu_style;?>;">

<?php
		echo isset($menu) ? $menu : '';
?>
			</div>
		</div>

		<div class="container">
			<div class="container-fluid">
				<div class="<?php echo ($page_type == 'catalogue') || ($page_type == 'photo') ? 'span12': 'span9 content_style'; ?>">
					<div <?php echo ($page_type == 'article') ? 'class="article container-fluid" style="padding: 10px;"': ''; ?>>
<?php
	if('banner' == 'banner') {
		$this->load->view('templates/types/banner');
	}
?>
<?php
	/** top article images **/
	$this->db->where('article_images.page_id', $pid);
	$this->db->where('article_images.image_position', 'top');
	$this->db->from('article_images');
	$this->db->join('gallery', 'gallery.id = article_images.gallery_id', 'left');
	$qarticle_images = $this->db->get();
	if($qarticle_images->num_rows() > 0) {
		$rarticle_images = $qarticle_images->result_array();
?>
    <div id="topCarousel" class="carousel slide">
		<!-- Carousel items -->
		<div class="carousel-inner">
<?php		
		foreach($rarticle_images as $key=>$article_images) {
			$imgpath = 'files/'.$article_images['albums'];
			$img = $imgpath.'/'.$article_images['image_file'];
			$imgsrc = base_url($img);
		
			echo '<div class="'.($key == 0 ? 'active ': '').'item"><img src="'.$imgsrc.'" style="margin: auto;"></div>';
		}
?>
		</div>
<?php
	if($qarticle_images->num_rows() > 1) {
?>
		<a class="carousel-control left" href="#topCarousel" data-slide="prev">&lsaquo;</a>
		<a class="carousel-control right" href="#topCarousel" data-slide="next">&rsaquo;</a>
<?php
	}
?>
    </div>

<?php	
	}
	/** **/
?>
						<div class="row-fluid">
<?php
						echo $content;
?>
						</div>
<?php
	/** bottom article images **/
	$this->db->where('article_images.page_id', $pid);
	$this->db->where('article_images.image_position', 'bottom');
	$this->db->from('article_images');
	$this->db->join('gallery', 'gallery.id = article_images.gallery_id', 'left');
	$qarticle_images = $this->db->get();
	if($qarticle_images->num_rows() > 0) {
		$rarticle_images = $qarticle_images->result_array();
?>
    <div id="bottomCarousel" class="carousel slide">
		<!-- Carousel items -->
		<div class="carousel-inner">
<?php		
		foreach($rarticle_images as $key=>$article_images) {
			$imgpath = 'files/'.$article_images['albums'];
			$img = $imgpath.'/'.$article_images['image_file'];
			$imgsrc = base_url($img);
		
			echo '<div class="'.($key == 0 ? 'active ': '').'item"><img src="'.$imgsrc.'" style="margin: auto;"></div>';
		}
?>
		</div>
<?php
	if($qarticle_images->num_rows() > 1) {
?>
		<a class="carousel-control left" href="#bottomCarousel" data-slide="prev">&lsaquo;</a>
		<a class="carousel-control right" href="#bottomCarousel" data-slide="next">&rsaquo;</a>
<?php
	}
?>
    </div>

<?php	
	}
	/** **/
?>
<?php

		if($pages['social'] == 'on' && $page_type != 'catalogue') {
?>
						<div class="row-fluid" style="margin-top: 10px;">
							<ul class="inline">
<?php
							$this->load->view('templates/addthis');
?>
							</ul>
						</div>
<?php
		}
?>
					</div>
				</div>

<?php
		if($page_type == 'catalogue') {
			if($product || $this->uri->segment(1) == 'cart') {
				$footer_class = 'span12';
			} else {
				$footer_class = 'span9 pull-right';
			}
		} elseif ($page_type == 'photo') {
			$footer_class = 'span12';
		} else {
			$footer_class = 'span9';
		}
?>

<?php
	if($footer->noads == 0) {
?>
				<div class="row-fluid">
					<div class="footer_style <?php echo isset($footer_class) ? $footer_class: ''; ?>">
						<div><?php echo $footer->label; ?></div>
					</div>
				</div>
<?php
	}
?>
			</div>
		</div>
	</div>
</div>