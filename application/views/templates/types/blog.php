<style>
	.share_post_link {
		text-decoration:none;
		cursor:pointer;
		color: #000;
	}
	.share_post_link:hover {
		color: #08c;
		text-decoration:none;
	}
</style>
	<input type="hidden" name="page_id" class="page_id" value="<?php echo $pid; ?>" />
	<div class="blog-content-fe">
<?php
	/**** load blog ****/

		$data['query'] = $datablogquery;
		$data['pid'] = $pid;

		if($data['query']->num_rows() > 0)
		{
			$this->load->view('templates/types/load_first.php', $data);
		}
		else
		{
			$this->db->where('id', $wid);
			$queryWeb = $this->db->get('websites');
			$resultWeb = $queryWeb->row_array();
			
			if($this->session->userdata('uid') == $resultWeb['user_id'])
			{
				$data_saying['saying'] = 'You don&rsquo;t have any blog post yet.';
			}
			else
			{
				$data_saying['saying'] = 'No blog post yet.';
			}
			$this->load->view('templates/types/no_contents.php', $data_saying);
		}

	/*****/
?>
	</div>
	<div class="row-fluid last_msg_loader" style="text-align: center;"></div>
<!-- Modal share-->
<div id="myModal_share_post" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-body" style="background-color: #f26221;border-bottom:0;">
		<span style="font-family: 'Segoe UI Semibold';font-size:20px;">Url: </span><input type="text" class="span11" id="share_link_url" value="" style="background: #D8D8D8;">
	</div>
</div>
<script type="text/javascript">
var bSuppressScroll = false;
$(function(){
	function last_msg_funtion()
	{
		var lastId = $(".message_box:last").attr("alt");
			
		if(lastId != undefined) {
		var pid = $('.page_id').val(),
			dataString = { 'pid': pid, 'lastId': lastId, 'wids': <?php echo $wid; ?> };

			$.ajax({
				beforeSend: function() {
					$('div.last_msg_loader').html('<img src="<?php echo base_url(); ?>img/add.gif">');
				},
				type: "POST",
				url: "<?php echo base_url(); ?>multi/load_blog",
				data: dataString,
				cache: false,
				success: function(html)
				{
					if(html == "lana") {
						$('div.last_msg_loader').empty();
						$('div.last_msg_loader').html('<div style="padding: 10px;">No More Post</div>');
					} else {
						$(".message_box:last").after(html);	
						window.bSuppressScroll = false;
						$('div.last_msg_loader').empty();
					}
					// alert(html);
				}
			});
		}
	};
	
	$(document).scroll(function(){
		var i = 0;
		$('.message_box').each(function(e,el){
			i++;
		});
		
		// var winScroll = document.documentElement.scrollTop,
			// docuHeight_winHeight = document.documentElement.scrollTopMax;
		var winScroll = $(window).scrollTop();
		var docuHeight = $(document).height();
		var winHeight = $(window).height();
		var docuHeight_winHeight = docuHeight - winHeight;
		if(winScroll + 100 >= docuHeight_winHeight)
		{
			if(window.bSuppressScroll === false)
			{
				if(!$('.message_id_url').val())
				{
					if(i > 1)			// sharing one post
					{
						last_msg_funtion();
					}
				}
				 window.bSuppressScroll = true;
				
			}
		}
	});

	/* var newwid = $('.g-imgholder').width();
	$('li.g-img2').css('left',newwid+'px');
	//resize slider on window resize		
	$(window).bind("resize", resizeWindow);
		function resizeWindow( e ) {
		var newwid = $('.g-imgholder').width();		
		
	} */
	$('.blog-content-fe').delegate('.share_post_link','click',function(e){
		var content = $(this).parents('.message_box').find('.video_url_link').html();
		var msg_id = $(this).attr('id');
		var url = $(this).attr('alt');
		$('#share_link_url').val(url);
		$('#myModal_share_post').modal('show'); 
	});
	$('.blog-content-fe').delegate('.play_button', 'click', function(e) {
		var msgid = $(this).parent().parent().children('.video_url_link').attr('id');
		var url = $(this).parent().parent().children('.video_url_link').attr('alt');
		var eto = $(this).parent();
		
		/* detect if youtube or vimeo */
		var ytLink = url.match('youtube.com');
		var vmLink = url.match('vimeo.com');
		var dailymotionLink = url.match('dailymotion.com/video');
		if(ytLink != null)
		{
			/* for youtube link */
			var convert = url.replace('watch?v=','/embed/');
				convert += '?autoplay=1';
			
				/* remove space */
			var sample = convert.replace(' ','');
			
			
			setTimeout(function(){
				$('.desc'+msgid).show();
				$(eto).html('<iframe class="span12" style="margin-left:0;" src="'+sample+'"></iframe>');
			},500);
		}else if(vmLink != null)
		{
			/* for vimeo link */
			var convert = url.replace('vimeo.com','player.vimeo.com/video');
				convert += '?autoplay=1';
			
				/* remove space */
			var sample = convert.replace(' ','');
			
			
			setTimeout(function(){
				$('.desc'+msgid).show();
				$(eto).html('<iframe class="span12" style="margin-left:0;" src="'+sample+'"></iframe>');
			},500);
		}else if(dailymotionLink != null)
		{
			/* for dailymotion link */
			var convert = url.replace('dailymotion.com/video','dailymotion.com/embed/video/');
				convert += '?autoplay=1';
			
				/* remove space */
			var sample = convert.replace(' ','');
			
			
			setTimeout(function(){
				$('.desc'+msgid).show();
				$(eto).html('<iframe class="span12" style="margin-left:0;" src="'+sample+'"></iframe>');
			},500);
		}
		
		e.stopImmediatePropagation();
	});
	

	$('.blog-content-fe').delegate('.commentBoxfe', 'keypress', function(e){
		if (e.keyCode == 13 && !e.shiftKey)
		{      
			e.preventDefault();
			var cid = $(".commentBoxfe").attr('alt');
			var message = $(".commentBoxfe").val();

			var dataString = 'msgId=' + cid + '&comm=' + message  + '&wid=<?php echo $wid; ?>';
			if(!message.match(/\S/))
			{
				$(this).val('');
				//alert('Please type a comment.');
				return false;
			}
			else
			{
				//alert('meron');
				$(this).val(' ');
				 $.ajax({
					type:'post',
					url: '<?php echo base_url(); ?>multi/blogcomment2',
					data: dataString,
					success: function(html)
					{
						//alert(html);
						$('.commentBoxfe').val('');
						$('li.load-com').hide();
						$('ul.blog-comment-area'+cid).append(html);
						return true;
					}
				});
			}
		}

		if (e.keyCode == 13 && e.shiftKey)
		{       
		//this is the shift+enter right now it does go to a new line
		//alert("shift+enter was pressed");        
		}  
	});

});
	function showUser2h(x, y)
	{
		$('#blogcom'+y).addClass('commentBoxfe');
	}
	function hideBox(x, y)
	{
		$('#blogcom'+y).removeClass('commentBoxfe');
	}
</script>