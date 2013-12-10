<style>
#ff span.btn_follow:before {
	content: 'FOLLOW';
}
#uf span.btn_follow:before {
	content: 'FOLLOWING';
}
#uf span.btn_follow:hover:before {
	content: 'UNFOLLOW';
}
	.media-heading a:hover {
		text-decoration: underline;
		color: #08c;
	}
	.desc span a:hover {
		text-decoration: underline;
		color: #08c;
	}
	/* for carousel */
	.list_carousel {
		width: 100%;
		margin-bottom: 20px;
	}
	.list_carousel li {
		float: left;
		list-style: none;
		width: 420px;
		margin-right: 9px;
		/* width: 359px; */
	}
	.list_carousel ul {
		margin: 0;
		padding: 0;
		list-style: none;
		display: block;
	}
	.list_carousel li img.span6 {
		height: 340px !important;
		width: 100% !important;
	}
	.caroufredsel_wrapper {
		height: 350px !important;
		width: 100% !important;
		margin: 0 !important;
	}
	.prevs {
		float: left;
		margin-left: 10px;
	}
	.nexts {
		float: right;
		margin-right: 10px;
	}
	.clearfix  {
		position: absolute;
		top: 30%;
		bottom: 50%;
		margin: auto;
		width: 117%;
		left: -59px;
		opacity: 0.6;
	}
	.clearfix:hover {
		opacity: 1;
	}
	.left_play {
		-webkit-transform: scaleX(-1);
		-moz-transform: scaleX(-1);
		-ms-transform: scaleX(-1);
		-o-transform: scaleX(-1);
		transform: scaleX(-1);
	}
	.r-web {
		text-align: center;
	}
	/* end of carousel */
	
	
	
	.dashphoto {
		max-height: 200px;
		overflow: hidden;
	}
	.fol-hover, .fol-hover2 {
		cursor:pointer;
	}
	.fol-hover img, .fol-hover2 img{
		max-height: 100%;
	}
	.fol-hover:hover .trans-box, .fol-hover2:hover .trans-box2 {
		display:block;
	}

	.trans-box
	{
		background-color: rgba(250, 230, 221, 0.5);
		border-radius: 4px 4px 4px 4px;
		display: none;
		height: 100%;
		line-height: 85px;
		position: absolute;
		text-align: center;
		top: 0;
		width: 100%;
	}
	.trans-box2
	{
		background-color: rgba(250, 230, 221, 0.5);
		border-radius: 4px 4px 4px 4px;
		display: none;
		height: 100%;
		line-height: 100px;
		position: absolute;
		text-align: center;
		top: 0;
		width: 100%;
	}
	@media (max-width: 767px)
	{
		.ch-feed
		{
			display:inline-table;
		}
	}
	
	.feed-list .span10 img
	{
		border: 4px solid #EAEAEA;
		border-radius: 4px;
		margin-top: 5px;
		margin-right: 10px;
	}
	.feed-list .w-logo img
	{
		max-height: 36px;
		margin-top: 9px;
	}
	.feed-list p.pull-right
	{
		font-size:12px;
		/* margin-top: 25px; */
	}
	.feed-list p
	{
		font-size:13px;
	}
	.feed-list h5 a:hover
	{
		color: #08c;
		text-decoration:underline;
	}
#dash-content .f-head
{
    color: #3590ea;
    font-weight: normal;
}
#dash-content .f-head a
{
	font-family: Segoe UI Bold;
	font-weight: normal;
}
#dash-content .desc {
	font-family: Segoe UI;
	font-weight: normal;
	font-size: 12px;
}
	.feed-list
	{
		margin-bottom:10px;
		border-bottom: 1px solid #CFCFCF;
	}
	.feed-list .w-logo
	{
		border: 1px solid #F1E8E8;
		border-radius: 4px;
		height: 60px;
		text-align:center;
	}
	.feed-list .v-holder
	{
		background-color:#f6f5f0;
	}
	.feed-list p.v-desc, .feed-list h5.v-title
	{
		padding: 1px 17px;
	}
	.feed-list iframe
	{
		height:350px;
		margin-left: 0;
	}
	.feed-list #myCarousel a
	{
		background-color: transparent;
		border-color: transparent;
		color: #C4C4C4;
		margin-top: 1px;
	}
	.loading-bar
	{
		text-align:center;
	}
	.no-feeds, .loading-bar
	{
		display:none;
	}
	.loading-bar button
	{
		background: #FBFBFB;
		box-shadow: none;
		border: 1px solid #E2E2E2;
		text-shadow: none;
		color: #4297EA;
	}
@media (max-width: 979px) and (min-width: 768px)
{
	.r-side .no-feeds .row-fluid p
	{
		line-height: 30px;
	}
}

@media (max-width: 480px)
{
	.content-part {
		margin-top: 0;
	}
}
@media (max-width: 767px)
{
	.mobile_view {
		padding: 0 8px;
	}
}
.item:hover .cover {
	/* display:block; */
	opacity: 1;
	transition: opacity .3s ease-in-out;
	-moz-transition: opacity .3s ease-in-out;
	-webkit-transition: opacity .3s ease-in-out;
}
.item .cover {
	/* display:none; */
	opacity: 0;
}

.photoslider.flexslider {
    // border-color: rgb(221, 221, 221);
    margin: 0 0 10px;
}
.photoslider.flexslider li {
    margin-right: 5px;
}
.photoslider.flexslider .flex-active-slide img {
    cursor: default;
    opacity: 1;
}
.photoslider.flexslider img {
    cursor: pointer;
    display: block;
    min-height: 200px;
}
</style>

	<div id="dashboard" class="container-fluid mobile_view">
		<div class="row-fluid ch-feed" style="padding-top: 10px;">
			<legend style="margin-bottom: 9px;font-family: Segoe UI Semibold; font-size: 18px; color: rgb(23, 23, 23);">Dashboard</legend>			
		</div>
		<div class="row-fluid no-feeds">
			<div class="row-fluid">
				<div class="span12" style="line-height: 30px; color: #909090; font-size: 30px; font-family: ScalaSans Light;">Welcome to Bolooka dashboard! </div>
			</div>
			<div class="row-fluid">
				<div class="span12" style="font-size: 16px; color: rgb(51, 51, 51); font-family: Segoe UI;">You may follow your favorite shops and see their product updates here!</div>
			</div>

			<div class="row-fluid">
				<div class="span12 head" style="font-size: 14px; font-family: Segoe UI Semibold; color: #171717;">Websites to Follow:</div>
<?php
	// $w = 0;
	if($websites->num_rows() > 0) {
?>
				<div class="row-fluid r-web">
					<div id="shop-container">
<?php
		$numwebs = range($min = 0, $websites->num_rows() - 1);
		shuffle($numwebs);
		for($w = 0; $w < $websites->num_rows() && $w < 4; $w++)
		{
				$web = $websites->row_array($numwebs[$w]);
				$query = $this->marketplace_model->getWebsiteLogo($web['id']);
				$result = $query->row_array();
				$img = 'uploads/'.$result['image'];
				if($this->photo_model->image_exists($img)) {
					$imgsrc = base_url($img);
				} else {
					$imgsrc = 'http://www.placehold.it/200x200/333333/ffffff&text=no+image';
				}
?>
						<div id="<?php echo $web['id'] ?>" class="item w1" style="position: relative; width: 196px;">
							<div class="box thumbnail">
								<div class="text-center img_cont" style="height: 120px;">
									<a class = "direct-gallery" target = "_blank" href = "#">
										<img src="<?php echo $imgsrc; ?>" style="max-height:120px;" />
									</a>
								</div>
								<div class="g-description-shop">
									<a href="<?php echo base_url().$web['url']; ?>"><?php echo $web['site_name'] ?></a>
								</div>
							</div>
							<div class="cover" style="background: none repeat scroll 0px 0px rgba(250, 230, 221, 0.5); height: 100%; width: 100%; position: absolute; top: 0px; left: 0px;">
								<div style="margin-top: 50px;">
									<p>
										<a id="ff" alt="<?php echo $web['id']; ?>">
											<span class="btn btn_follow"></span>
										</a>
									</p>
									<p>
										<a class="btn" href="<?php echo base_url().$web['url']; ?>"> VISIT </a>
									</p>
								</div>
							</div>
						</div>
<?php
		}
?>
					</div>
				</div>
				<div class="pull-right">
					<a style="font-size: 12px; font-family: Segoe UI; color: #3590ea;" href="<?php echo base_url(); ?>test/following">View more websites to follow</a>
				</div>
<?php
	} else {
		echo '<div class="span12 r-web lead">No website to display</div>';
	}
?>
			</div>

			<div class="row-fluid">
				<div class="span12" style="font-size: 14px; font-family: Segoe UI Semibold; color: #171717;">Recently Listed in our Marketplace:</div>

<?php
	if($products->num_rows() > 0)
	{
?>
				<div class="row-fluid r-web">
					<div id="shop-container">
<?php
		$numprods = range($min = 0, $products->num_rows() - 1);
		shuffle($numprods);
		for($p = 0; $p < $products->num_rows() && $p < 4; $p++)
		{
				$prod = $products->row_array($numprods[$p]);
				/* get website */
				$this->db->where('id', $prod['website_id']);
				$this->db->where('deleted', 0);
				$quser = $this->db->get('websites');
				$ruser = $quser->row_array();
				
				/* get pages */
				$this->db->where('id',$prod['page_id']);
				$pquery = $this->db->get('pages');
				$prow = $pquery->row_array();
				
				if($this->db->field_exists('product_cover', 'products')) {
					$img = 'uploads/'.$ruser['user_id'].'/'.$ruser['id'].'/'.$prod['page_id'].'/'.$prod['id'].'/medium/'.$prod['product_cover'];
				} else {
					$img = 'uploads/'.$ruser['user_id'].'/'.$ruser['id'].'/'.$prod['page_id'].'/'.$prod['id'].'/medium/'.$prod['primary'];
				}
				if($this->photo_model->image_exists($img)) {
					$imgsrc = base_url($img);
				} else {
					$imgsrc = 'http://www.placehold.it/200x200/333333/ffffff&text=no+image';
				}
?>
						<div class="item w1" style="position: relative; width: 196px; vertical-align: top;">
							<div class="box">
								<div class="text-center img_cont">
									<a class = "direct-gallery" target = "_blank" href = "#">
										<img src="<?php echo $imgsrc; ?>" style="height:150px;" />
									</a>
								</div>
								<div class="g-description-shop trim"><?php echo $prod['name']; ?></div>
								<div style="position: relative; text-align: left;">
									<span class="p-category" style="font-size: 9px; font-family: Segoe UI; color: rgb(129, 128, 128);"><span style="font-style: italic;"><?php echo $prod['category']; ?></span></span>
									<?php if($prod['price'] > 0): ?>
									<span style="font-size: 10px; font-family: Segoe UI; color: rgb(53, 144, 234); right: 0px; position: absolute;">&#8369; <?php echo number_format($prod['price'],2); ?></span>
									<?php endif; ?>
								</div>						
							</div>
							<div class="cover" style="background: none repeat scroll 0% 0% rgba(250, 230, 221, 0.5); position: absolute; left: 0px; top: 0px; height: 100%; width: 100%;">
								<div>
									<a style="margin-top: 95px;" target="_blank" class="btn ff" id="ff" href="<?php echo base_url($ruser['url'].'/'.url_title($prow['name'], '-', TRUE).'/'.url_title($prod['name'],'-',true).'/'.$prod['id']); ?>">SHOP NOW</a>
								</div>
							</div>								
						</div>
<?php
		}
?>
					</div>
				</div>
				<div class="pull-right">
					<a style="font-size: 12px; font-family: Segoe UI; color: #3590ea;" href="<?php echo base_url(); ?>marketplace">View more in marketplace</a>
				</div>		
<?php
	} else {
		echo '<div class="row-fluid r-web lead">No products to display</div>';
	}
?>
			</div>
		</div>

		<div class="row-fluid" id="dash-content">
<?php
			// echo $feeds;
?>
			<!-- The Feed(s) goes here -->
		</div>
		<div class="row-fluid loading-bar">
			<!-- <button class="span12 btn btn-primary s-more" style="padding: 10px 0;">Show more &#9660;</button> -->
		</div>

	</div>

<script type="text/javascript">
var bSuppressScroll = false;
$(function() {
	loadfeeds();
		
	function last_msg_funtion() 
	{
		var ID = $(".post_item:last").attr("alt");
		var	dataString3 = 'uid=<?php echo $uid; ?>&lastId='+ID;
		//alert(ID+ ' '+dataString3);
		$.ajax({
			beforeSend: function() {
				$('.loading-bar').empty().html('<p style="text-align: center;"><img src="<?php echo base_url(); ?>img/ajax-loader.gif" /></p>');
			},
			type: "POST",
			url: "<?php echo base_url(); ?>dashboard/wallsSecond",
			data: dataString3,
			success: function(html)
			{
				if(html != 'lana')
				{
						window.bSuppressScroll = false;
						$(".post_item:last").after(html);
						$('.loading-bar').empty();
						// $('.loading-bar').html('<button class="span12 btn btn-primary s-more">Show more &#9660;</button>');
						
						/* carousel */
						var width = $('.photoslider').width() / 2;
					$('.photoslider').flexslider({
						animation: "slide",
						controlNav: false,
						animationLoop: false,
						slideshow: false,
						itemWidth: 411,
						itemMargin: 5,
						minItems: 2,
						maxItems: 4,
						move: 1,
						smoothHeight: true
					});

				}
				else
				{
					$('.loading-bar').empty();
					$('.loading-bar').html('<h5>No more post</h5>');
				}
			}
		}); 
	};

	$(window).scroll(function(){
		var winScroll = $(window).scrollTop();
		var docuHeight = $(document).height();
		var winHeight = $(window).height();			
		var docuHeight_winHeight = docuHeight - winHeight;

		if(winScroll + 100 >= docuHeight_winHeight)
		{
			if(window.bSuppressScroll == false)
			{
				last_msg_funtion();
			
				window.bSuppressScroll = true;
			}
		}
	});
	
	function loadfeeds() {
		var dataString = 'uid=' + <?php echo $uid; ?>;
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>dashboard/walls",
			data: dataString,
			beforeSubmit: function() {
				$('#dash-content').html('<p style="text-align: center;"><img src="<?php echo base_url(); ?>img/ajax-loader.gif" /></p>');
				// $('.loading-bar').show();
			},
			success: function(html) {
				if(html == '0')
				{
					$('#dash-content').empty();
					$('.no-feeds').show();
				}
				else
				{
					$('#dash-content').empty();
					$('#dash-content').html(html);
					$('.loading-bar').show();
					$('.photoslider').flexslider({
						animation: "slide",
						controlNav: false,
						animationLoop: false,
						slideshow: false,
						itemWidth: 411,
						itemMargin: 5,
						minItems: 2,
						maxItems: 4,
						move: 1,
						smoothHeight: true
					});
				}
			}
		}); 
	}
	
	$('.cover')
	.delegate('.btn_follow', 'click', function(){
		var el = $(this),
			ep = $(this).parent(),
			wid = ep.attr('alt');
			
		if(ep.attr('id') == 'uf') {
			var datastring23 = 'userid=<?php echo $uid; ?>&website='+wid;
			$.ajax({
				type:"POST",
				url:"<?php echo base_url().'test/unfollow'; ?>",
				data:datastring23,
				success: function(html) {
					ep.attr('id', 'ff');
					el.removeClass('btn-danger').addClass('btn-success');
				}
			});
		} else if(ep.attr('id') == 'ff') {
			var datastring23 = 'userid=<?php echo $uid; ?>&website='+wid;
			$.ajax({
				type:"POST",
				url:"<?php echo base_url().'test/follow'; ?>",
				data:datastring23,
				success: function(html){
					ep.attr('id', 'uf');
					el.removeClass('btn-success').addClass('btn-danger');
				}
			});		
		}
	});
	
	$('.cover')
	.on('mouseenter', '.btn_follow', function( event ) {
		var ep = $(this).parent();
		if(ep.attr('id') == 'uf') {
			$(this).addClass('btn-danger');
		} else if(ep.attr('id') == 'ff') {
			$(this).addClass('btn-success');
		}
	})
	.on('mouseleave', '.btn_follow', function( event ) {
		var ep = $(this).parent();
		if(ep.attr('id') == 'uf') {
			$(this).removeClass('btn-danger');
		} else if(ep.attr('id') == 'ff') {
			$(this).removeClass('btn-success');
		}
	});
});
</script>