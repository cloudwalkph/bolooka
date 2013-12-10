<style type="text/css">
.fol-hover.fol-hover {
    height: 150px;
    position: relative;
    width: 199px;
}
.followinghover {
    line-height: 150px;
}
.btn.folwing {
    text-transform: uppercase;
}

.tabbable .tab-content .followed img
{
    max-height: 150px;
    max-width: 200px;
}
.tabbable .tab-content .followed
{
/*     background-position: center 4%;
    background-repeat: no-repeat;
    background-size: 89% auto;
    border: 2px solid rgb(225, 225, 225);
    border-radius: 4px 4px 4px 4px;
    box-shadow: 0 0 5px rgb(225, 225, 225);
    float: none;
    height: 150px;
    position: relative;
    text-align: center;
    width: 200px; */
}
.tabbable .tab-content .trans-box
{
    background-color: rgba(250, 230, 221, 0.5);
    display: none;
    height: 100%;
    left: 0;
    margin-left: 0;
    position: absolute;
    text-align: center;
    top: 0;
    width: 100%;
}

.tabbable .tab-content .fol-hover:hover .trans-box {
	display:block;
}
	.tabbable .tab-content .fol-hover, .fol-hover2
	{
		cursor:pointer;
	}

@media (max-width: 767px)
{
	.tabbable .tab-content .followed
	{
		margin-left:0px;
	}
}

	.loading-bar button
	{
		background: #FBFBFB;
		box-shadow: none;
		border: 1px solid #E2E2E2;
		text-shadow: none;
		color: #4297EA;
	}
	
.thumbnails .fol-hover {
	float: none !important; /* to overwrite the default property on the bootstrap stylesheet */
	display: inline-block;
	*display: inline; /* ie7 support */
	zoom: 1;
}
</style>

<div class="container-fluid">
<?php
	$uid = $this->session->userdata('uid');
	
	$this->db->where('user_id', $uid);
	$this->db->where('deleted', 0);
	$querysite = $this->db->get('websites');
	$website = $querysite->result();
?>
<div class="row-fluid tabbable" style="margin-top:10px;">
  <ul class="nav nav-tabs" id="follow_tabs">
<?php
	if($querysite->num_rows() == 0):
?>
    <li><a class="thetab1" href="#tab1" data-toggle="tab" rel="tooltip" data-placement="bottom" data-original-title="Start following">Site Suggestions</a></li>
<?php
	else:
?>
	<li><a class="thetab1" href="#tab1" data-toggle="tab">Site Suggestions</a></li>
<?php
	endif;
?>
    <li class="active"><a class="thetab2" href="#tab2" data-toggle="tab">Following</a></li>
  </ul>
  <div id="follow_container" class="tab-content container-fluid">
    <div class="tab-pane" id="tab1">
      <ul class="row-fluid follow-items thumbnails">
<?php
			/*  UnFollowed website shows here */

			/* end */
?>
      </ul>
		<div class="row-fluid loading-bar" style="margin-top: 15px;text-align:center;">
				<button class="span12 btn btn-primary s-more" style="padding: 10px 0;">Show more &#9660;</button>
		</div>
    </div>
    <div class="tab-pane active" id="tab2">
      <ul class="row-fluid thumbnails following followed-items">
<?php
			/* Followed website shows here */
			$this->db->where('users', $uid);
			$this->db->order_by('id');
			$getwebfollow = $this->db->get('follow');
			if($getwebfollow->num_rows() > 0)
			{
				$resultwebfollow = $getwebfollow->result_array();
				foreach($getwebfollow->result_array() as $resultwebfollow) 
				{
					$this->db->where('id', $resultwebfollow['website_id']);
					$this->db->where('deleted', 0);
					$thequery = $this->db->get('websites');
					if($thequery->num_rows() > 0)
					{
						$resultweb = $thequery->row_array();

						$this->db->where('website_id', $resultwebfollow['website_id']);
						$queryLogo = $this->db->get('logo');
						if($queryLogo->num_rows() > 0)
						{
							$rows3 = $queryLogo->row_array();
							
							$imageSrc = base_url().'uploads/'.str_replace('uploads/','',$rows3['image']);

							if($imageSrc == base_url().'uploads/') {
								$imageSrc = 'http://www.placehold.it/200x120/333333/ffffff&text=no+logo';
							}
						}
						else
						{
							$imageSrc = base_url().'img/Default Profile Picture.jpg';
							echo $thequery['site_name'].'<br/>';
						}
						
						echo '
							<div class="thumbnail followed fol-hover" id="items-'.$resultwebfollow['website_id'].'">
								<img src="'.$imageSrc.'" style="max-height: 150px;">
								<div class="muted" style="background: none repeat scroll 0px 0px white; position: absolute; left: 0px; right: 0px; text-align: center; bottom: 4px; padding: 4px;">'.$resultweb['site_name'].'</div>
								<div class="trans-box btn-color">
									<a class="followinghover" id="uf" alt="'.$resultwebfollow['website_id'].'">
										<span class="btn folwing"> following </span>
									</a>
								</div>
							</div>
						';
					} else {
						/* CAUTION: this deletes old data from follow table */
						$delete_web_follow = array(
							'website_id' => $resultwebfollow['website_id']
						);
						$this->db->delete('follow', $delete_web_follow);
						/* */
					}
				}
			} else {
				echo '<p style="text-align: center;">You have no followed.</p>';
			}
			/* end */
?>
		</ul>			
      </div>
    </div>
 </div>
</div>
 
<script type="text/javascript">
$(function(){
	$('#follow_container').delegate('.folwing', 'click', function(){
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
					el.html('follow').removeClass('btn-danger').addClass('btn-success');
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
					el.html('following').removeClass('btn-success').addClass('btn-danger');
				}
			});		
		}
	});
	
	$('#follow_container').on('mouseenter', '.folwing', function( event ) {
		var ep = $(this).parent();
		if(ep.attr('id') == 'uf') {
			$(this)
				.html('unfollow')
				.addClass('btn-danger');
		} else if(ep.attr('id') == 'ff') {
			$(this)
				.addClass('btn-success');
		}
	}).on('mouseleave', '.folwing', function( event ) {
		var ep = $(this).parent();
		if(ep.attr('id') == 'uf') {
			$(this)
				.html('following')
				.removeClass('btn-danger');
		} else if(ep.attr('id') == 'ff') {
			$(this)
				.removeClass('btn-success');
		}
	});

    $('#follow_tabs a[href="#tab1"]').on('show', function (e) {
		var datastring2 = 'uid=<?php echo $uid; ?>';
		$.ajax({
			type:"POST",
			url:"<?php echo base_url(); ?>test/getUnfollowedSite",
			data:datastring2,
			beforeSend: function() {
				$('.follow-items').html('<p style="text-align: center;"><img src="<?php echo base_url(); ?>img/ajax-loader.gif" /></p>');
			},
			success: function(html){
				if(html == '') {
					$('.follow-items').html('<p style="text-align: center;">You have no items to follow.</p>');
				} else {
					$('.follow-items').html(html);
				}
			}
		});
    })
	
	$('#follow_tabs a[href="#tab2"]').on('show', function (e) {
		var datastring2 = 'uid=<?php echo $uid; ?>';
		$.ajax({
			type:"POST",
			url:"<?php echo base_url(); ?>test/getsite",
			data:datastring2,
			beforeSend: function() {
				$('.followed-items').html('<p style="text-align: center;"><img src="<?php echo base_url(); ?>img/ajax-loader.gif" /></p>');
			},
			success: function(html) {
				if(html != 'lana')
				{
					$('.followed-items').empty();
					$('.followed-items').html(html);
				}
				else
				{
					$('.followed-items').empty();
					$('.followed-items').html('<p style="text-align: center;">You have no followed.</p>');
				}
			}
		});
	});
	
	/* tooltip text for new users */
	$('.thetab1').tooltip('show');
	
		function load_more_follow() 
		{ 
			var ID = $(".follow_item:last").attr("data-lastid");
			var	dataString3 = 'uid=<?php echo $uid; ?>&lastid='+ID;
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>test/getUnfollowedSite",
				data: dataString3,
				cache: false,
				beforeSend: function() {
					$('.loading-bar').html('<p style="text-align: center;"><img src="<?php echo base_url(); ?>img/ajax-loader.gif" /></p>');
				},
				success: function(html)
				{
					if(html == '')
					{
						$('.loading-bar').html('<h5 style="font-weight: normal;">No more website</h5>');
					}
					else
					{
							window.bSuppressScroll = false;
							$(".follow_item:last").after(html);
							$('.loading-bar').empty();
							$('.loading-bar').html('<button class="span12 btn btn-primary s-more">Show more &#9660;</button>');
					}
				}
			}); 
		};

		$('.loading-bar').delegate('.s-more','click',function(){
			load_more_follow();
		});
});
</script>