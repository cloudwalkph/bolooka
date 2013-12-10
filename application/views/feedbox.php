<?php
	$thequery = $this->db->query("SELECT * FROM products WHERE id='$prod_id'");
	$result = $thequery->row_array();
?>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.autosize.js"></script>
<style type="text/css">
.star-position
{
	background-position: -38px 0px !important;
}

.star-position2
{
	background-position: -38px 0px !important;
}
.approv
{
	width:50%;
	height:80px;
	background:#ebe8e8;
	float:left;
	cursor:pointer;
	color: #BBB;
}
.approv:hover
{
	background:#d0d0d0;
	color: #BBB;
}

.disapprov
{
	width:50%;
	height:80px;
	background:#bbb;
	float:right;
	cursor:pointer;
	color: #EBE8E8;
}
.disapprov:hover
{
	background:#d4d3d3;
	color: #BBB;
}

.product-rating-holder ul li
{
	line-height: 1.5;
}
.delete_comment
{
	float:right;
	margin-top: 3px;
	margin-right: 4px;
	display: block;
	padding: 1px;
	cursor: pointer;
}
.delete_comment:hover
{
	background:#7f7e7e;
	color:#fff;
}
</style>
<script type="text/javascript">
$(document).ready(function(){
	var docheis = $(document).height();
	var winheis = $(window).height();
	var winScroll = $(window).scrollTop();
	$('.black_overlay_feedbox').css('height',docheis+'px');
	$('.white_content_Outside').css('height',winheis+winScroll+'px');
	$('body').css('overflow','hidden');
	$('.autoresize').css('overflow', 'hidden');
	$(function(){
		$('.autoresize').autosize();
	});
	var datastr = 'star=NULL&product_id=<?php echo $result['id']; ?>&uid=<?php echo $this->session->userdata('uid'); ?>';
		
	/* $.ajax({
		type:"POST",
		url:"<?php echo base_url(); ?>multi/insert_rating",
		data: datastr,
		success: function(html){
			//alert(html);
			if(html == 'you')
			{
				//alert('You already have rate this item.');
				
			}
			else
			{
				
			}
			
		}
	}); */
	<?php
	$uids = $this->session->userdata('uid');
	$pidss = $result['id'];
	$chkquery = $this->db->query("SELECT * FROM product_rating WHERE voter_ip='$uids' AND product_id='$pidss' ORDER BY id DESC LIMIT 1");
	if($chkquery->num_rows() > 0)
	{
		$vote = $chkquery->row_array();
		$vote_num = $vote['rate'];
?>
	var stars_ip = '<?php echo $vote_num; ?>';
	if(stars_ip == 5)
	{
		$('.rate-text').html('Very Good');
		$('.star11').prevAll().andSelf().addClass('star-position');
	}
	if(stars_ip == 4)
	{
		$('.rate-text').html('Good');
		$('.star22').prevAll().andSelf().addClass('star-position');
	}
	if(stars_ip == 3)
	{
		$('.rate-text').html('Average');
		$('.star33').prevAll().andSelf().addClass('star-position');
	}
	if(stars_ip == 2)
	{
		$('.rate-text').html('Poor');
		$('.star44').prevAll().andSelf().addClass('star-position');
	}
	if(stars_ip == 1)
	{
		$('.rate-text').html('Very Poor');
		$('.star55').prevAll().andSelf().addClass('star-position');
	}
<?php
	}
	else
	{
?>
$('.ratings_stars5').hover(
		function() {
		var txtrate = $(this).attr('alt');
			$(this).prevAll().andSelf().addClass('star-position');
			$(this).prevAll().andSelf().css('background-color','transparent');
			$(this).nextAll().removeClass('ratings_vote'); 
			$(this).prevAll().removeClass('ratings_vote'); 
			
		},
		function() {
			$(this).prevAll().andSelf().removeClass('star-position');
			$(this).prevAll().andSelf().css('background-color','');
		}
	);
	$('.star11').mouseenter(function(){
		$('.rate-text').html('Very Good');
	});
	$('.star22').mouseenter(function(){
		$('.rate-text').html('Good');
	});
	$('.star33').mouseenter(function(){
		$('.rate-text').html('Average');
	});
	$('.star44').mouseenter(function(){
		$('.rate-text').html('Poor');
	});
	$('.star55').mouseenter(function(){
		$('.rate-text').html('Very Poor');
	});
	$('.show-text').mouseout(function(){
		$('.rate-text').empty();
	});
	$('.ratings_stars5').bind('click', function() {
		var star = $(this).attr('alt');
		var product_id = $(this).parent().attr('id');
		//alert(star+' '+product_id);
		var datastr = 'star='+star+'&product_id='+product_id+'&uid=<?php echo $this->session->userdata('uid'); ?>';
		
		$(this).prevAll().andSelf().addClass('star-position2');
		$('.itemtorev').removeClass('star11');
		$('.itemtorev').removeClass('star22');
		$('.itemtorev').removeClass('star33');
		$('.itemtorev').removeClass('star44');
		$('.itemtorev').removeClass('star55');
		$('.rate-txt').empty();
		if(star == 5)
		{
			$('.rate-text2').html('Very Good');
			$(this).parent().removeClass('show-text');
		}
		if(star == 4)
		{
			$('.rate-text2').html('Good');
			$(this).parent().removeClass('show-text');
		}
		if(star == 3)
		{
			$('.rate-text2').html('Average');
			$(this).parent().removeClass('show-text');
		}
		if(star == 2)
		{
			$('.rate-text2').html('Poor');
			$(this).parent().removeClass('show-text');
		}
		if(star == 1)
		{
			$('.rate-text2').html('Very Poor');
			$(this).parent().removeClass('show-text');
		}
		//alert(datastr);
		$.ajax({
			type:"POST",
			url:"<?php echo base_url(); ?>multi/insert_rating",
			data: datastr,
			success: function(html){
				//alert(html);
				if(html == 'you')
				{
				//	alert('You already have rate this item.');
				}
				else
				{
					//$('.total-votes').html(html+' votes');
					if(star == 5)
					{
						$('.total-votes5').empty();
						$('.total-votes5').html(html+' votes');
					}
					if(star == 4)
					{
						$('.total-votes4').empty();
						$('.total-votes4').html(html+' votes');
					}
					if(star == 3)
					{
						$('.total-votes3').empty();
						$('.total-votes3').html(html+' votes');
					}
					if(star == 2)
					{
						$('.total-votes2').empty();
						$('.total-votes2').html(html+' votes');
					}
					if(star == 1)
					{
						$('.total-votes1').empty();
						$('.total-votes1').html(html+' votes');
					}
				}
				
			}
		});
	});
<?php
	}
?>
$('.commentProductClass').live('keypress',function(e){
	if(e.keyCode == 13 && !e.shiftKey)
	{
		var commentMsg = $(this).val();
		var prodId = $(this).attr('alt');
		var scrolltops = $('.white_content_Outside').scrollTop();
		var thisdata = 'commentmsg='+commentMsg+'&prodid='+prodId+'&userdata=<?php echo $this->session->userdata('uid'); ?>&site_id=<?php echo $site_id; ?>';
		//alert(commentMsg+' '+prodId);
		//alert('you press enter');
		if(!commentMsg.match(/\S/))
		{
			$(this).val(' ');
			//alert('Please type a comment.');
			return false;
		}
		else
		{
			//alert('meron');
			$(this).val(' ');
			 $.ajax({
				type:'post',
				url: '<?php echo base_url(); ?>multi/catalogcomment',
				data: thisdata,
				success: function(html)
				{
					//alert(html);
					$('.commentProductClass').val(' ');
					$('ul.comment-items-hold').append(html);
					$('.white_content_Outside').scrollTop(scrolltops+100);
					return true;
				}
			});
		}
		
	}
	else
	{
		//alert('you press another key');
	}
});
});
	function addtheclass(x, prod_id)
	{
		//alert(prod_id);
		
		$(x).addClass('commentProductClass');
	}
	
	function removetheclass(x, prod_id)
	{
		$(x).removeClass('commentProductClass');
	}
	function delete_category_comment(x)
	{
		//alert($(x).attr('id'));
		var com_id = $(x).attr('id');
		var datastr = 'com_id='+com_id;
		$(x).parent().hide();
		$.ajax({
			type: 'post',
			url: '<?php echo base_url(); ?>multi/del_cat_comment',
			data: datastr,
			success: function(html)
			{
			
			}
		});
	}
</script>
<div style="width:770px;height:auto;">
	<div id="fadeclose" style="float: right;margin-top: 8px;background: #565656;color: white;padding: 2px 6px;margin-bottom: 19px;cursor:pointer;">
		<p id="fadeclose" style="margin:0;">Close<?php
			//echo $this->session->userdata('uid').'>>>';
			//echo $result['id'];
		?>
		</p>
	</div>
	<table style="width: 100%;clear: right;">
		<tr>
			<td valign="top" style="width: 30%;padding-top: 46px;">
				<div id="prod-hold" style="width: 93%;height: auto;background: white;padding: 6px 6px;box-shadow: 1px 1px 13px #565656;">
					<h1 style="color: #565656;font-family: century gothic;"><?php echo $result['name']; ?></h1>
					<div class="product-rating-holder" style="margin-left: 32px;">
						<ul>
							<?php
								$ratequery = $this->db->query("SELECT * FROM product_rating WHERE product_id='$prod_id' AND rate='5'");
								$ratequery4 = $this->db->query("SELECT * FROM product_rating WHERE product_id='$prod_id' AND rate='4'");
								$ratequery3 = $this->db->query("SELECT * FROM product_rating WHERE product_id='$prod_id' AND rate='3'");
								$ratequery2 = $this->db->query("SELECT * FROM product_rating WHERE product_id='$prod_id' AND rate='2'");
								$ratequery1 = $this->db->query("SELECT * FROM product_rating WHERE product_id='$prod_id' AND rate='1'");
							?>
							<li>
								<div class="rate-info" id="">
									<div class="star-5 ratings_stars rate-highlight" alt="5"></div>
									<div class="star-4 ratings_stars rate-highlight" alt="4"></div>
									<div class="star-3 ratings_stars rate-highlight" alt="3"></div>
									<div class="star-2 ratings_stars rate-highlight" alt="2"></div>
									<div class="star-1 ratings_stars rate-highlight" alt="1"></div>
									<div class="total-votes5"><?php echo $ratequery->num_rows(); ?> votes</div>
								</div>
							</li>
							<li>
								<div class="rate-info" id="">
									<div class="star-5 ratings_stars rate-highlight" alt="5"></div>
									<div class="star-4 ratings_stars rate-highlight" alt="4"></div>
									<div class="star-3 ratings_stars rate-highlight" alt="3"></div>
									<div class="star-2 ratings_stars rate-highlight" alt="2"></div>
									<div class="star-1 ratings_stars" alt="1"></div>
									<div class="total-votes4"><?php echo $ratequery4->num_rows(); ?> votes</div>
								</div>
							</li>
							<li>
								<div class="rate-info" id="">
									<div class="star-5 ratings_stars rate-highlight" alt="5"></div>
									<div class="star-4 ratings_stars rate-highlight" alt="4"></div>
									<div class="star-3 ratings_stars rate-highlight" alt="3"></div>
									<div class="star-2 ratings_stars" alt="2"></div>
									<div class="star-1 ratings_stars" alt="1"></div>
									<div class="total-votes3"><?php echo $ratequery3->num_rows(); ?> votes</div>
								</div>
							</li>
							<li>
								<div class="rate-info" id="">
									<div class="star-5 ratings_stars rate-highlight" alt="5"></div>
									<div class="star-4 ratings_stars rate-highlight" alt="4"></div>
									<div class="star-3 ratings_stars" alt="3"></div>
									<div class="star-2 ratings_stars" alt="2"></div>
									<div class="star-1 ratings_stars" alt="1"></div>
									<div class="total-votes2"><?php echo $ratequery2->num_rows(); ?> votes</div>
								</div>
							</li>
							<li>
								<div class="rate-info" id="">
									<div class="star-5 ratings_stars rate-highlight" alt="5"></div>
									<div class="star-4 ratings_stars" alt="4"></div>
									<div class="star-3 ratings_stars" alt="3"></div>
									<div class="star-2 ratings_stars" alt="2"></div>
									<div class="star-1 ratings_stars" alt="1"></div>
									<div class="total-votes1"><?php echo $ratequery1->num_rows(); ?> votes</div>
								</div>
							</li>
						</ul>
					</div>
					<hr style="width: 176px;"/>
					<div class="p-descrip" style="text-align: justify;padding: 0px 5px;font-size: 11px;line-height: 1.3;word-break:break-all;"><?php echo $result['desc']; ?></div>
				</div>
			</td>
			<td valign="top" style="background:white;min-height:500px;box-shadow: 1px 1px 13px #565656;">
				<div style="background: #565656;color: white;padding: 4px 6px;">
					<p style="margin:0;">Feedback</p>
				</div>
				<div>
					<h2 style="font-family: century gothic;font-size: 26px;margin: 0;margin-left: 33px;margin-top: 8px;">Rate this!!</h2>
					<div class="rate-info show-text" id="<?php echo $result['id']; ?>" style="margin-left: 76px;width: auto;height: auto;">
						<div class="star-5 star55 ratings_stars5 itemtorev" alt="1" style="width:40px;height:40px;position: relative;z-index: 1;"></div>
						<div class="star-4 star44 ratings_stars5 itemtorev" alt="2" style="width:40px;height:40px;position: relative;z-index: 1;"></div>
						<div class="star-3 star33 ratings_stars5 itemtorev" alt="3" style="width:40px;height:40px;position: relative;z-index: 1;"></div>
						<div class="star-2 star22 ratings_stars5 itemtorev" alt="4" style="width:40px;height:40px;position: relative;z-index: 1;"></div>
						<div class="star-1 star11 ratings_stars5 itemtorev" alt="5" style="width:40px;height:40px;position: relative;z-index: 1;"></div>
						<div class="rate-txt"><div class="rate-text" style="font-size: 31px;font-family: century gothic;position: relative;left: 14px;z-index: 0;"></div></div>
						<div class="rate-text2" style="font-size: 31px;font-family: century gothic;position: relative;left: 14px;z-index: 0;"></div>
					</div>
				</div>
				<div style="clear:both;"></div>
				<div style="width:100%;height:88px;">
					<div class="approv">
						<div style="float: left;font-family: century gothic;font-size: 35px;margin-left: 14px;margin-top: 16px;">
							<p style="margin:0;">Approved</p>
						</div>
						<div style="float: right;margin-right: 14px;margin-top: 4px;">
							<img src="<?php echo base_url(); ?>img/like.png" style="width:53px;" />
						</div>
					</div>
					<div class="disapprov">
						<div style="float: left;margin-left: 14px;margin-top: 18px;">
							<img src="<?php echo base_url(); ?>img/dislike.png" style="width:53px;" />
						</div>
						<div style="font-family: century gothic;font-size: 29px;float: right;margin-top: 18px;margin-right: 13px;">
							<p style="margin:0;">Disapproved</p>
						</div>
					</div>
				</div>
				<div style="clear:both;"></div>
				<div style="width:100%;">
					<div style="float: left;width: 50%;text-align: right;color: #BBB;font-family: century gothic;font-size: 13px;">
						<p style="margin:0;margin-right: 8px;">2,569 Approved</p>
					</div>
					<div style="float: right;width: 50%;color: #BBB;font-family: century gothic;font-size: 13px;">
						<p style="margin:0;margin-left: 8px;">1,500 Disapproved</p>
					</div>
				</div>
				<div style="clear:both;"></div>
				<div style="width: 97%;height: 15px;background: #ECEBEB;margin: 0 auto;margin-top: 9px;">
				</div>
				<div style="clear:both;"></div>
				<div style="width: 97%;margin: 0 auto;">
					<ul class="comment-items-hold" style="margin: 0;">
					<?php
						$thecomments = $this->db->query("SELECT * FROM comments WHERE msg_id_fk='$prod_id' ORDER BY com_id ASC");
						if($thecomments->num_rows() > 0)
						{
							foreach($thecomments->result_array() as $therow)
							{
								$commentId = $therow['com_id'];
								$commentmsg = $therow['comment'];
								$commentuser = $therow['uid_fk'];
								$this->db->where('uid', $commentuser);
								$queryusers = $this->db->get('users');
								$theusers = $queryusers->row_array();
								$profPicss = $theusers['profile_picture'];
								$profPicss = str_replace(' ','_',$profPicss);
								$this->db->where('id', $site_id);
								$this->db->where('deleted', 0);
								$querywebsite = $this->db->get('websites');
								$thewebsite = $querywebsite->row_array();
								
					?>
						<li class="list-cat-comment" id="<?php echo $commentId; ?>" style="background: #ECEBEB;margin-top: 1px;min-height: 66px;">
						<?php if($thewebsite['user_id'] == $this->session->userdata('uid')){ ?>
							<span class="delete_comment" onclick="delete_category_comment(this)" id="<?php echo $commentId; ?>">X</span>
						<?php } ?>
							<img src="<?php echo $profPicss ? base_url().'uploads/'.$profPicss : 'broken.jpg'; ?>" onerror="this.src='<?php echo base_url(); ?>img/followBolookaIcon.png'" style="margin: 3px;width:53px;float: left;max-height:58px;" />
							<div style="padding: 4px 15px;text-align: justify;">
								<p style="margin:0;font-size: 11px;line-height: 1.1;color: #474747;"><span style="color: #252525;font-weight: bold;font-size: 12px;padding-right: 9px;"><?php echo $theusers['name']; ?></span><?php echo $commentmsg; ?></p>
							</div>
						</li>
					<?php
							}
						}
					?>
					</ul>
					<div style="background: #ECEBEB;min-height: 59px;margin-bottom: 20px;margin-top: 5px;">
						<?php
							$uid = $this->session->userdata('uid');
							$this->db->where('uid', $uid);
							$query = $this->db->get('users');
							$users = $query->row_array();
							$profPic = $users['profile_picture'];
							$profPic = str_replace(' ','_',$profPic);
							//$filelocation = base_url().'uploads/'.$profPic;
						?>
						<img src="<?php echo $profPic ? base_url().'uploads/'.$profPic : 'broken.jpg'; ?>" onerror="this.src='<?php echo base_url(); ?>img/followBolookaIcon.png'" style="width:53px;float: left;max-height:58px;" />
						<div style="text-align: justify;">
							<textarea class="autoresize" style="border-radius: 0px;width: 438px;margin-left: 7px;margin-top: 8px;background-color: white;" name="type-here" alt="<?php echo $prod_id; ?>" onfocus="addtheclass(this, <?php echo $prod_id; ?>)" onblur="removetheclass(this, <?php echo $prod_id; ?>)" placeholder="Write a Comment..."></textarea>
						</div>
					</div>
				</div>
			</td>
		</tr>
	</table>
</div>