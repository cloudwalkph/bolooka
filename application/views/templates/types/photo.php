<?php 
/* this if from notification need to be query */

if(isset($_GET['img_id']))
{
	$this->db->like('image_name',$_GET['img_id']);
	$query = $this->db->get('gallery');
	$row_gal = $query->row_array();
	if($query->num_rows() > 0) {
		$image_value = 'files/'.$row_gal['albums'].'/medium/'.$row_gal['image_name'];
	} else {
		$this->db->like('image',$_GET['img_id']);
		$query1 = $this->db->get('gallery');
		$row_gal1 = $query1->row_array();	
		if($query1->num_rows() > 0)
		{
			$image_value = 'files/'.$query1['albums'].'/medium/'.$query1['image'];
		}else
		{
			$image_value = '';
		}
	}
}
?>
<style>
	.s_comments:before {
		content: 'Show Comments';
	}
	.h_comments:before {
		content: 'Hide Comments';
	}

	#light .bottom_bar {
		display: none;
	}
	#light:hover .bottom_bar {
		display: block;
	}
	#light .bottom_bar ul li a {
		text-decoration:none;
		font-weight: bold;
		color:#bbb;
		text-shadow: none;
		font-size: 13px;
		margin-top: 8px;
	}
	#light .bottom_bar ul li a:hover {
		color:#E7E7E7;
		background:rgba(61, 61, 61, 0.8);
		border-radius:8px;
	}

	.show-cmnt .user-pic{		
		width:7%;
		height:30px;
		border: 2px solid white;
	}
	.show-cmnt ul li{
		margin-top: 10px;
	}
	.post-btn .btn-link{
		color:#c8654e;
		text-shadow: 0 1px 1px rgba(200, 101, 78, 0.75);
	}
	.txt-commment-style:focus{
		border-color: rgba(200, 101, 78, 0.8);
		box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075),0 0 8px rgba(200, 101, 78, 0.6);
	}
	.txt-commment-style{
		background: #404040;
		resize: none;
		border-radius: 0px;
		border-top: 2px solid white;
		border-width: 2px 0 0 0;
		/* border:none; */
		width: 97%;
		min-height: 44px;
		margin-bottom: 0px;
		font-size: 12px;
		color: #989898;
		overflow:hidden;
	}
	.post-btn a{
		padding: 1px 12px;
		font-size: 12px;
	}
	.post-btn{
		background: #323232;
		width: 97%;
		padding: 0px 6px;
	}
	.comment_photo {
		position: absolute;
		top: 89%;
		color: #fff;
		right: 5%;
		text-shadow: 0px 0px 6px;
		cursor:pointer;
	}
	.comment_photo:hover {
		text-shadow: 0px 0px 0px;
	}
#photo_container {
	
}
	#light .show_com {
		background:#fff;
		display:none;
		padding: 5px;
		font-size:11px;
	}
</style>
<div id="reponseajax"></div>
<div id="fade" class="black_overlay" onclick = "document.getElementById('light').style.display='none'; document.getElementById('fade').style.display='none';"></div>
<div class="photo_content">
	<!-- Photo item parser here -->
<?php
	echo $photo_content;
?>
</div>
<div id="light" class="row-fluid white_content">
	<a class="close_button" href="javascript:void(0)" onclick = "document.getElementById('light').style.display='none'; document.getElementById('fade').style.display='none';">
		<i class="icon-remove"></i>
	</a>
	<div class="container-fluid">
		<div class="imagepart" id="img-holder">
			<a href = "javascript:void(0)" class="left carousel-control img-ctrl img_ctrl" alt="prev"> &#8249; </a>
			<a href = "javascript:void(0)" class="right carousel-control img-ctrl img_ctrl" alt="next"> &#8250; </a>
		</div>
		<div class="span5 comentpart" id="img-comment" style="display:none; background: #1E1E1E; padding: 8px; border-radius: 10px; overflow:hidden; height:100%;">
			<!--Comment area -->
		</div>
	</div>
	<div class="row-fluid bottom_bar" style="position: absolute;bottom: 0;width: 97%;">
		<div class="container-fluid">
			<ul class="unstyled pull-right">
				<li><a class="btn btn-link s_comments" href="javascript:void(0)"></a></li>
			</ul>
		</div>			
	</div>
	<!--<div class="span4 show_com">sample</div>
	<div class="comment_photo">Comments</div>-->
</div>
<div id="myModalsss" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel">Modal header</h3>
	</div>
	<div class="modal-body">
		<p>One fine body…</p>
	</div>
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
		<button class="btn btn-primary">Save changes</button>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
	<?php
		if(isset($_GET['img_id']))
		{
	?>
			var stageheight = $('#light').height();
			var stagewidth = $('#light').width();
			$('.img-ctrl').hide();
			$('#img-holder').css('height',stageheight+'px');
			$('#img-holder').css('margin-left','0px');		
			$('#img-holder').css('background-image','url(<?php echo base_url($image_value); ?>)');
			$('#img-holder').css('background-position','center center');
			$('#img-holder').css('background-repeat','no-repeat');
			var datastrings = 'image=<?php echo $_GET['img_id'];  ?>';
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
	<?php
		}
	?>
	var windowWidth = $(window).width();
	
	/* for image comments */
	if(windowWidth >=779){
		$('.comment_photo').toggle(function(){
			$('#img-holder').removeClass('row-fluid');
			$('#img-holder').addClass('span7');
			$('.show_com').show();
			
			/* for loading effect */
			$('.show_com').css('text-align','center');
			$('.show_com').html('<img src="<?php echo base_url('img/add.gif'); ?>">');
		},function(){
			$('.show_com').hide();
			$('#img-holder').addClass('row-fluid');
			$('#img-holder').removeClass('span7');
		});
	}else{
		$('.comment_photo').toggle(function(){
			$('#myModalsss').modal('show');
		},function(){
			$('#myModalsss').modal('hide');
		});
	}
	
	$(window).bind("resize",function(){
		var winW = $(this).width();
		if(winW <= 778){
			if($('.show_com').is(":visible") == true){
				$('#myModalsss').modal('show');
				$('.show_com').hide();
			}
		}else{
			// $('#myModalsss').modal('hide');
		}
	});
	
	//resize slider on window resize		
	$(window).bind("resize", resizeWindow);
	function resizeWindow( e ) {
		var stageheight = $('#light').height();
		var stagewidth = $('#light').width();
		var wintop = $(window).scrollTop();
		var winheight = $(window).height();
		var lighttop = winheight * 0.1;
		$('#img-holder').css('height',stageheight+'px');
		$('#img-comment').css('height',stageheight+'px');
		// $('#light').css('top',wintop + lighttop + 'px');
		// $('#fade').css('top',wintop+'px');
	}
	//show comment area
	$('.bottom_bar').delegate('.s_comments','click',function() {
		// alert('awts');
		$(this).addClass('h_comments').removeClass('s_comments');
		$('#img-comment').show();
		$('.imagepart').removeClass('span12');
		$('.imagepart').addClass('span7');
	});
	// Hide comment area
	$('.bottom_bar').delegate('.h_comments','click',function(){
		// alert('awts');
		$(this).addClass('s_comments').removeClass('h_comments');
		$('#img-comment').hide();
		$('.imagepart').removeClass('span7');
		$('.imagepart').addClass('span12');
	});

	$('.img_ctrl').click(function(e) {
		var arr_key = $('#img-holder').attr('alt'),
			imgid = $('#img-holder').attr('data-imgid');
		var albumid = $(this).attr('id'),
			nav = $(this).attr('alt');

		var url = '<?php echo base_url(); ?>multi/navimgs',
			datastring = { 'nav': nav, 'wid': '<?php echo $wid; ?>', 'albumid': albumid, 'arr_key': arr_key };
		$.ajax({
			type: 'post',
			url: url,
			data: datastring,
			beforeSend: function() {
				$('#img-holder').css('background-image','url(<?php echo base_url().'img/add.gif'; ?>)');
				$('#img-holder').css('background-size','contain');
				$('#img-holder').css('background-position','center center');
				$('#img-holder').css('background-repeat','no-repeat');			
			},
			success: function(html) {
				$('#reponseajax').empty().html(html);
			}
		});

		var url = '<?php echo base_url(); ?>test/imagecomment',
			imgdata = { 'nxtimg': nav, 'image': imgid, 'albumid': albumid, 'arr_key': arr_key };
		$.ajax({
			type: 'post',
			url: url,
			data: imgdata,
			beforeSend: function() {
				$('#img-comment').empty();
				$('#img-comment').html('<p style="text-align:center;"><img src="<?php echo base_url().'img/add.gif'; ?>" /></p>');			
			},
			success: function(html){
				$('#img-comment').empty();
				$('#img-comment').html(html);
			}
		});	
	});
});
</script>