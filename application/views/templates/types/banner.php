<?php
	$this->db->where('web_id', $wid);
	$qbanner_sett = $this->db->get('banner_sett');
	
	if($qbanner_sett->num_rows() > 0) {
		$rbanner_sett = $qbanner_sett->row_array();

		if($rbanner_sett['enable'] == 1) {
		
			$this->db->where('website_id', $wid);
			$this->db->order_by('sequence asc');
			$qbanner = $this->db->get('banner');
			$rbanner = $qbanner->result_array();
?>
						<div class="row-fluid">
								<div id="myCarousel" class="carousel slide">
									<ol class="carousel-indicators">
<?php
			foreach($rbanner as $key=>$banner) {
?>
										<li data-target="#myCarousel" data-slide-to="<?php echo $key; ?>" class="<?php echo $key == 0 ? 'active' : ''; ?>"></li>
<?php
			}
?>
									</ol>
									<!-- Carousel items -->
									<div class="carousel-inner">
<?php
			foreach($rbanner as $key=>$banner) {
?>
										<div class="<?php echo $key == 0 ? 'active': ''; ?> item">
											<img alt="" src="<?php echo base_url() . 'uploads/' . $banner['images']; ?>">
											<div class="carousel-caption">This is a caption</div>
										</div>
<?php
			}
?>
									</div>
									<!-- Carousel nav -->
									<a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
									<a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
								</div>
						</div>
						
<?php
		}
	}
?>