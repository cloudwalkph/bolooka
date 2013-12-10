<?php
				if($this->session->userdata('section') == null || $this->session->userdata('section') == 'furniture')
				{
					$newdata = array('section'  => 'craft');
				}
				else if($this->session->userdata('section') == 'craft')
				{
					$newdata = array('section'  => 'furniture');
				}
				$this->session->set_userdata($newdata);
?>
	<!-- the CSS for Smooth Div Scroll -->
	<link rel="Stylesheet" type="text/css" href="<?php echo base_url() ?>assets/Smooth-Div-Scroll-master/css/smoothDivScroll.css" />
	
	<!-- Styles for my specific scrolling content -->
	<style type="text/css">

		div.slides
		{
			margin: auto;
			overflow: hidden;
			position: relative;
			width: 90%;
		}
		
		/* Replace the last selector for the type of element you have in
		   your scroller. If you have div's use #makeMeScrollable div.scrollableArea div,
		   if you have links use #makeMeScrollable div.scrollableArea a and so on. */
		div.slides div.scrollableArea .scroll_item
		{
			background-color: #FFFFFF;
			float: left;
			margin: 8px;
			position: relative;
			/* If you don't want the images in the scroller to be selectable, try the following
			   block of code. It's just a nice feature that prevent the images from
			   accidentally becoming selected/inverted when the user interacts with the scroller. */
			-webkit-user-select: none;
			-khtml-user-select: none;
			-moz-user-select: none;
			-o-user-select: none;
			user-select: none;
		}
		
		.scroll_item {
			height: 170px;
			width: 120px;
		}
		
		.scroll_item:hover {
		    box-shadow: 0 0 1px 0;
		}

	</style>

		<div id="carousel" class="product-slider container">
			<div class="slides">
			<?php
				$products = $this->marketplace_model->getMarketProducts(0, null, 0, $this->session->userdata('section'));
				if($products->num_rows() > 0)
				{
					$numprods = range($min = 0, $products->num_rows() - 1);
					shuffle($numprods);
					for($p = 0; $p < $products->num_rows() && $p < 16; $p++)
					{
							$prod = $products->row_array($numprods[$p]);
							/* get website */
							$this->db->where('id', $prod['website_id']);
							$this->db->where('deleted', 0);
							$qweb = $this->db->get('websites');
							$rweb = $qweb->row_array();
							
							/* get pages */
							$this->db->where('id',$prod['page_id']);
							$pquery = $this->db->get('pages');
							$prow = $pquery->row_array();
							
							$url = base_url($rweb['url'].'/'.url_title($prow['name'],'-',true).'/'.url_title($prod['name'], '-', true).'/'.$prod['id']);
							
							if($this->db->field_exists('product_cover', 'products')) {
								$img = 'uploads/'.$rweb['user_id'].'/'.$rweb['id'].'/'.$prod['page_id'].'/'.$prod['id'].'/thumbnail/'.$prod['product_cover'];
							} else {
								$img = 'uploads/'.$rweb['user_id'].'/'.$rweb['id'].'/'.$prod['page_id'].'/'.$prod['id'].'/thumbnail/'.$prod['primary'];
							}
							if($this->photo_model->image_exists($img)) {
								$imgsrc = base_url().$img;
							} else {
								$imgsrc = 'http://www.placehold.it/120x80/333333/ffffff&text=image+not+found';
							}
							
							echo '
							<div class="thumbnail scroll_item">
								<div style="text-align: center; margin-bottom: 12px; margin-top: 4px; height: 80px; overflow: hidden;">
									<a href="'.$url.'" target="_blank">
										<img src="'.$imgsrc.'">
									</a>
								</div>
								<div style="position: absolute; bottom: 4px; left: 4px;">
									<div style="font-size: 0.9em; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; width: 116px;">
										<a href="'.$url.'" target="_blank" style="color: inherit;">
											'.$prod['name'].'
										</a>
									</div>
									<div style="font-size: 0.7em; color: rgb(129, 128, 128);">
										<a href="" target="_blank" style="color: inherit;">
											'.$prod['category'].'
										</a>
									</div>
							';

							if($prod['price']) {
								echo '<div style="font-size: 0.8em; color: rgb(53, 144, 234)">&#8369; '.number_format($prod['price'], 2).'</div>';
							} else {
								// echo '<div style="font-size: 0.8em; color: rgb(53, 144, 234)">&nbsp;</div>';
								echo '';
							}
						
							echo '
									<div style="font-size: 0.7em">
										<a style="cursor: pointer;">'.$rweb['site_name'].'</a>
									</div>
								</div>
							</div>
							';
					}
				}
			?>
			</div>
		</div>




	<script src="<?php echo base_url() ?>assets/Smooth-Div-Scroll-master/js/jquery.mousewheel.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url() ?>assets/Smooth-Div-Scroll-master/js/jquery.kinetic.js" type="text/javascript"></script>
	<script src="<?php echo base_url() ?>assets/Smooth-Div-Scroll-master/js/jquery.smoothdivscroll-1.3-min.js" type="text/javascript"></script>
	<script type="text/javascript">
		$(document).ready(function () {
			$("div.slides")
				.smoothDivScroll({
					autoScrollingMode: "onStart", // "always", "onStart"
					autoScrollingDirection: "endlessLoopRight",
					// autoScrollingStep: 1,
					autoScrollingInterval: 10,
					// getContentOnLoad: {
						// method: "getAjaxContent",
						// content: "<?php echo base_url(); ?>test/getprods",
						// manipulationMethod: "addLast",
					// },
					// autoScrollingRightLimitReached: function(eventObj, data) {
						// $(eventObj.target)
							// .smoothDivScroll("stopAutoScrolling")
							// .smoothDivScroll("getAjaxContent", "<?php echo base_url(); ?>test/getprods", "addLast")
							// .smoothDivScroll("startAutoScrolling")
					// },
					jumpedToElementNumber: function(eventObj, data) {
						alert("Scrolled to element id " + data["elementId"]);
					}
				})
				.bind("mouseover", function(){
					$("div.slides").smoothDivScroll("stopAutoScrolling");
				})
				.bind("mouseout", function(){
					$("div.slides").smoothDivScroll("startAutoScrolling");
				})
			
		});
	</script>