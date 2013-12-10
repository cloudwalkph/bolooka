<script src="//platform.twitter.com/anywhere.js?id=KHEan9MZbxqsBYN61W2Wsw&v=1"></script>
<?php
	/* query for pagination ilabas lahat ng data */
	$queryPagination = $this->wall_updates->post_share(0, $wid, $pid);
	
	$userId = $this->session->userdata('uid');
	$userquery = $this->db->query('SELECT * FROM `users` WHERE uid="'.$userId.'"');
	$uQuery = $userquery->row_array();
	
	/* tweet long */
	$wQuery = $this->db->query("SELECT * FROM `websites` WHERE id='".$wid."' ");
	$siteRow = $wQuery->row_array();
	
	$siteUrl = $siteRow['url'];
	
	$this->db->where('id',$pid);
	$pageQuery = $this->db->get('pages');
	$pageRow =  $pageQuery->row_array();
	
	$pageName = $pageRow['name'];
	$pageNameUrl = str_replace(' ','-',$pageName);
?>

<style>
.edit_content_paste {
	border-bottom: 1px solid #ddd;
	margin-bottom: 10px;
	cursor:pointer;
}
.btn_color {
	background: #f16120; /* Old browsers */
	background: -moz-linear-gradient(top,  #f16120 0%, #e75210 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#f16120), color-stop(100%,#e75210)); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top,  #f16120 0%,#e75210 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top,  #f16120 0%,#e75210 100%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top,  #f16120 0%,#e75210 100%); /* IE10+ */
	background: linear-gradient(to bottom,  #f16120 0%,#e75210 100%); /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f16120', endColorstr='#e75210',GradientType=0 ); /* IE6-9 */
	
	text-shadow: none;
	box-shadow: -2px 2px 5px -2px #ddd inset;
	color: #fff;
}
.btn_color:hover {
	background: #e75311; /* Old browsers */
	background: -moz-linear-gradient(top, #e75311 0%, #f16120 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#e75311), color-stop(100%,#f16120)); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top, #e75311 0%,#f16120 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top, #e75311 0%,#f16120 100%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top, #e75311 0%,#f16120 100%); /* IE10+ */
	background: linear-gradient(to bottom, #e75311 0%,#f16120 100%); /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#e75311', endColorstr='#f16120',GradientType=0 ); /* IE6-9 */

	box-shadow: 1px -2px 5px -2px #ddd inset;
	color: #fff;
}
/* .button_group .span12 .submit_post {
	background: #0082EE;
	border-radius: 0px;
	color: white;
	text-shadow: 0px 0px;
}
.button_group .span12 .submit_post:hover {
	background: #ddd;
	color: #08c;
} */
.list_li_blog {
	position: relative;
}
.remove_post {
    position: absolute;
    right: -15px;
	top: -10px;
}
.list_li_blog:hover a img.close_img {
	opacity: 1;
}
.list_li_blog a img.close_img {
	opacity: 0;
	transition: opacity 0.5s;
	-moz-transition: opacity 0.5s; /* Firefox 4 */
	-webkit-transition: opacity 0.5s; /* Safari and Chrome */
	-o-transition: opacity 0.5s; /* Opera */
	cursor: pointer;
}
.comment_button:hover {
	color: #08C;
	cursor:pointer;
}
.fetched_data {
    padding-top: 10px;
}

	/* RESPONSIVE CSS */
	
	@media (max-width: 400px) {
		.media_float {
			float: none !important;
		}
	}
	@media (max-width: 767px)
	{
		.feeds_container {
			border: 0 !important;
		}
	}

</style>
	<div class="container-fluid">
		<div class="row-fluid">
			<legend style="font-family: 'Segoe UI bold'; font-size: 14px;">
				<span class="yalbum" style="text-transform: uppercase;"> Your Blog: </span>
			</legend>
		</div>
<?php 
			$form_attrib = array(
				'name' => 'form_wall',
				'class' => 'imageform fileupload_form'
			);
			echo form_open_multipart(base_url().'wall/upwallimage', $form_attrib);
?>
			<input name="ajax_flag" class="ajax_flag" type="hidden" />
			<input class="text_value" type="hidden" /> 
			<input name="current_img" class="current_img" type="hidden" />
			<div class="row-fluid">
				<div class="span10 offset1 textarea_group">
					<div class="span12 textarea_content" style="">
						<input type="text" name="blog_title" class="span12 blog_title" placeholder="Title">
						<textarea name="text_post" placeholder="Message" class="span12 wall<?php echo $pid; ?> keywall" style="border-radius: 0px 0px 0px 0px; resize: vertical;" required></textarea>
						<div class="fetched_data" style="display: none;">
							<div id="loader" class="loader"></div>
							<div class="ajax_content container-fluid"></div>
						</div>
						<div class="preview"></div>
					</div>
					<div class="row-fluid fileUpload_group" style="margin-top: 60px;">
						<div class="span6" style="margin: 0;">
							<div class="fileupload fileupload-new" data-provides="fileupload">
								<div class="input-append" style="margin-top: 5px;">
									<div class="uneditable-input" style="float: left;">
										<i class="icon-file fileupload-exists"></i> 
										<span class="fileupload-filename"></span>
									</div>
									<span class="btn btn-file fileinput-button">
										<span class="fileupload-new">Select file</span>
										<span class="fileupload-exists">Change</span>
										<input type="file" class="uploadFile" name="uploadFile" accept="image/*"/>
										<input type="hidden" name="website_id" value="<?php echo $wid; ?>">
										<input type="hidden" name="page_id" value="<?php echo $pid; ?>">
									</span>
									<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
								</div>
							</div>
						</div>
					</div>
					<div class="row-fluid button_group">
						<div class="span12">
							<button type="button" id="fb_submit<?php echo $pid; ?>" class="btn pull-right submit_post submit_post<?php echo $pid; ?>" alt="<?php echo $wid; ?>">PUBLISH</button>
							<span class="pull-right loading_state_blog" style="margin-right:10px;"></span>
						</div>
					</div>
				</div>
			</div>
<?php
			echo form_close();
?>
	</div>
<div class="row-fluid feeds_container" style="<?php if($queryPagination->num_rows() > 0){echo 'padding: 20px 0;border: 1px solid #ddd;text-align:center;';} ?>">
	<div class="blog_item<?php echo $pid; ?> container-fluid pagination_blog_content" style="text-align: left;">
<?php
	foreach($queryPagination->result() as $key=>$row)
	{
		$created = $row->created;
		$album_id = $row->album_id;
		$msg_id = $row->msg_id;
		$uid_fk = $row->uid_fk;
		$message = $row->message;
		$description = $row->description;
		$image_name = $row->image_name;
		$images = $row->image;
		$imageUrl = $row->imageUrl;
		$titles = $row->title;
		$url_web = $row->url;
		$title_post = $row->blog_title;
		$detect = $this->video_model->detect_url($url_web);
		
		$this->db->where('msg_id_fk', $msg_id);
		// $this->db->where('uid_fk', $this->session->userdata('uid'));
		$comment_query = $this->db->get('comments');
		
		if($key <= 6)
		{
			$message = str_replace("\n",'</p></p>',html_entity_decode($message));
			echo '
				<div class="well list_li_blog " id="'.$msg_id.'">
					<a class="remove_post">
						<img class="close_img" src="'.base_url('img/close_button.png').'">
					</a>';
			if($title_post)
			{
			echo '
					<h4>'.$title_post.'</h4>
				';
			}
			echo '
					<div class="edit_content_paste">
					<p>'.$message.'</p>
					</div>
			';
			if($imageUrl != ' ' || $imageUrl == 'undefined' || $image_name != '')
			{
				echo '
					<div class="pull-left media_float" style="margin-right:10px;position:relative;">
				';
				if($detect != 'no video')
				{
					echo '
						<span class="play_button" style="cursor:pointer;bottom: 2px;left:2px;position: absolute;background-color: rgba(255, 255, 255, 0.5);padding: 0 10px;">
							<i class="icon-play"></i>
						</span>
					';
				}
				
				if($imageUrl == 'undefined' || $image_name != '') {
					/* detect if image has medium folder*/
					$imageDetect = 'uploads/medium/'.str_replace(" ","_",$image_name);
					if($this->photo_model->image_exists($imageDetect))
					{
						$imageMedium = $imageDetect;
					}else
					{
						if($this->photo_model->image_exists('uploads/'.str_replace(" ","_",$image_name)))
						{
							/* create medium folder*/
							$medium = $this->photo_model->make_medium('uploads/'.str_replace(" ","_",$image_name));
							$imageMedium = $medium;
						}
					}
					echo '<img style="width:67%;" src="'.base_url($imageMedium).'">';
				} else {
					$images = strip_tags(html_entity_decode($images, ENT_QUOTES), '<img>');
					echo $images;
				}
				echo '
					</div>
				';
			}
			
			echo '
				<div style="overflow:hidden;margin-right: 10px;padding-left: 5px;">
			';
			if(($url_web != ' '))
			{
				echo '
					<p style="color:#08C;margin:0;"><a href="'.$url_web.'">'.html_entity_decode($titles).'</a></p> 
					<p class="video_url_link" alt="'.$url_web.'"></p>
					<p>'.html_entity_decode($description).'</p>
				';
			}
			echo '
				</div>
			';
			
			echo '
				<div style="clear:both;"></div>
				<br/>
				<div class="comment_content">
						<p style="border-bottom:1px solid #ddd;padding-bottom: 10px;">
							<strong class="comment_button">'.$comment_query->num_rows().' COMMENT(S) </strong>
						</p>
			';
			
			echo '
					<ul class="media-list" style="display:none;">
			';
			
			
			if($comment_query->num_rows() > 0)
			{
				foreach($comment_query->result() as $comRow)
				{
					$com_id = $comRow->com_id;
					$comment = $comRow->comment;
					$msg_id_fk = $comRow->msg_id_fk;
					$uid_fk = $comRow->uid_fk;
					$created = $comRow->created;
				echo '
					<li class="media">
						<a class="pull-left" href="#" id="'.$com_id.'" alt="'.$msg_id_fk.'">
							<img class="media-object" src="'.base_url('img/no-photo.jpg').'" style="width: 65px;">
						</a>
						<div class="media-body">
							<p>'.$comment.'</p>
							<p style="text-align: right;"><small>'.date('F j, Y',$created).'</small></p>
						</div>
					</li>
				';
				}
			}
			echo'
					</ul>
				</div>
			';
			
			echo '
				</div>
			';
		}
	}
?>
	
	</div>
	<div class="page_navigation" style="display: inline-block;"></div>
<?php
	$num_of_rows = $queryPagination->num_rows();
	$div_rows = $num_of_rows / 6;
	$converted_row = ceil($div_rows); 
	
	if($converted_row > 1)
	{
?>
	<input type="hidden" value="<?php echo $converted_row; ?>" id="total_pages<?php echo $pid; ?>">
	<div class="pagination pagination-centered">
		<ul>
			<li class="prev_page<?php echo $pid; ?>"><a style="cursor:pointer;">PREV</a></li>
			<li class="current_page active"><a  style="cursor:pointer;font-weight: bold;font-size: 30px;">1</a></li>
			<li class="next_page<?php echo $pid; ?>"><a style="cursor:pointer;">NEXT</a></li>
			<li>
				<a style="padding: 0;border:0;">
					<select class="page_num span12" style="margin: 0;">
						<option value="0"></option>
					<?php
						for ($y=1; $y<=$converted_row; $y++)
						{
							echo '<option value="'.$y.'">'.$y.'</option>';
						}
					?>
					</select>
				</a>
			</li>
		</ul>
	</div>
<?php
	}
?>

</div>
<!-- Modal -->
<div id="myModal_delete_post" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header" style="background-color: #f26221;border-bottom:0;">
    <h4 id="myModalLabel_delete_post" style="color:#fff; margin: 5px 0; font-family: 'Segoe UI Semibold'; opacity: 0.7;">Delete Post?</h4>
  </div>
  <div class="modal-footer" style="background-color: #e34e0d;color: #fff;border-top:0;box-shadow: none;border-radius:0;">
	<input class="page_delete_id" type="hidden">
    <button class="btn btn_color delete_post">Delete</button>
    <button class="btn btn_color" data-dismiss="modal" aria-hidden="true">Close</button>
  </div>
</div>
<script>
	
	$(document).ready(function(){
		$('textarea[name="text_post"]').val('');
		$('input[name="blog_title"]').val('');
		$('.ajax_flag').val(0)
		
		/* pagination */
		$('.prev_page<?php echo $pid; ?>').addClass('disabled');

	});
	
	/* edit post */
	$('.blog_item<?php echo $pid; ?>').delegate('.edit_content_paste','click',function(e){
		
		var postHeight = $(this).height();
		var msg_id = $(this).parent().attr('id');
		var textHeight = $(this).height();
		
		/* prevent other click */
		// if($('.edit_show').is(':visible'))
		// {
			// return false;
		// }
		
		createTextarea(msg_id,textHeight,$(this));
		
	});
	
	/* save edited post */
	$('.blog_item<?php echo $pid; ?>').delegate('.save_edit_post','click',function(e){
	
		var text_area = $(this).parents('.edit_show').find('.post_new').val();
		var msg_id = $(this).parents('.list_li_blog').attr('id');
		var dataString = 'message_id='+msg_id+'&message='+text_area;
		var eto = $(this);
		
		$(eto).button('loading');
		$.ajax({
			type: "POST",
			url: '<?php echo base_url(); ?>wall/save_edited_content_post',
			data: dataString,
			success: function(data){
				$(eto).parents('.list_li_blog').find('.edit_content_paste').html(data);
				destroy(eto);
				$(eto).button('reset');
			}
		});
		
	});
	
	/* create edit post content */
	function createTextarea(id,h,el){
		
		$(el).css('cursor','progress');
		var dataString = 'message_id='+id;
		$.ajax({
			type: "POST",
			url: '<?php echo base_url(); ?>wall/edit_content_post',
			data: dataString,
			success: function(html){
				/* hide old post */
				$(el).hide();
				
				$(el).css('cursor','pointer');
				$('<div class="edit_show">'+
					'<textarea class="post_new span12" style="resize:none;">'+html+'</textarea>'+
					'<div class="button_div" style="margin-bottom: 5px;">'+
						'<button class="save_edit_post" data-loading-text="Loading...">Save</button>'+
						'<button onclick="destroy(this)">Cancel</button>'+
					'</div>'+
				  '</div>').insertAfter(el);
				$(el).parent().find('.post_new').height(h);	
			}
		});
		
	}
	
	/* remove edit post text area */
	function destroy(el){
		$(el).parents('.list_li_blog').find('.edit_content_paste').show();
		$(el).parents('.list_li_blog').find('.edit_show').remove();
	}
	/* comments */
	$('.blog_item<?php echo $pid; ?>').delegate('.comment_button','click',function(e){
		
		var eto = $(this);
		$(this).append('<span><img src="<?php echo base_url('img/ajax-loader.gif'); ?>"></span>');
		
		$(eto).children().fadeOut(300);
		$(eto).parents('.comment_content').find('.media-list').toggle();
		
		e.stopImmediatePropagation();
	});
	
	/* PAGINATION */
	$('.pagination').delegate('.page_num', 'change', function(e){
		
		/* enable next/previous button */
		$('.next_page<?php echo $pid; ?>').removeClass('disabled');
		$('.prev_page<?php echo $pid; ?>').removeClass('disabled');
		
		var eto = $(this);
		var p_num = $(eto).val();
		var dataString = 'pid=<?php echo $pid; ?>&wid=<?php echo $wid; ?>&p_num='+p_num;
		
		if(p_num == 0)
		{
			return false;
		}
		
		
		$.ajax({ 
			type: "POST",
			url: "<?php echo base_url(); ?>wall/pagination",
			data: dataString,
			success: function (html) {
				$('.blog_item<?php echo $pid; ?>').hide().html(html).fadeIn(300);
				$(eto).parents('ul').find('.current_page').children().html(p_num);
			}
		});	
		e.stopImmediatePropagation();
	});
	
	$('.pagination').delegate('.prev_page<?php echo $pid; ?>','click',function(e) {
		/* enable next button */
		$('.next_page<?php echo $pid; ?>').removeClass('disabled');
		
		var eto = $(this);
		var p_num = $(this).parent('ul').find('.current_page').children().html();
		var previous = p_num - 1;
		var dataString = 'pid=<?php echo $pid; ?>&wid=<?php echo $wid; ?>&p_num='+previous;
		
		/* if previous button reach the limit */
		if(previous == 0)
		{
			$(eto).addClass('disabled');
			return false;
		}
		
		/* show each item per page */
		$.ajax({ 
			type: "POST",
			url: "<?php echo base_url(); ?>wall/pagination",
			data: dataString,
			success: function (html) {
				$('.blog_item<?php echo $pid; ?>').html(html).fadeOut(200).fadeIn(500);
				$(eto).parent('ul').find('.current_page').children().html(previous);
			}
			
		});
		
		
		
		e.stopImmediatePropagation();
	});
	
	$('.pagination').delegate('.next_page<?php echo $pid; ?>','click',function(e){
		/* enable previous button */
		$('.prev_page<?php echo $pid; ?>').removeClass('disabled');
		
		var eto = $(this);
		var p_num = $(this).parent('ul').find('.current_page').children().html();
		var next = Number(p_num) + 1;
		var total_pages = $('#total_pages<?php echo $pid; ?>').val();
		var dataString = 'pid=<?php echo $pid; ?>&wid=<?php echo $wid; ?>&p_num='+next;

		/* if next button reach the limit */
		if(next > total_pages)
		{
			$(eto).addClass('disabled');
			return false;
		}
		
		/* show each item per page */
		$.ajax({ 
			type: "POST",
			url: "<?php echo base_url(); ?>wall/pagination",
			data: dataString,
			success: function (html) {
				$('.blog_item<?php echo $pid; ?>').html(html).fadeOut(200).fadeIn(500);
				$(eto).parent('ul').find('.current_page').children().html(next);
			}
		});
		
		e.stopImmediatePropagation();
	});
	/* end of pagination */
	
	function get_contentPaste(div) 
	{
		var content = $(div).val(); // Get all the data in the textarea 
		var parentDiv = $(div).parents('.imageform');
		var childrenDiv = $(parentDiv).children().children().children('.textarea_content');
		var buttonGroup = $(parentDiv).children().children('.textarea_group');
		// content = content.replace('www.','http://www.');
		// var url = content.match('(^|[ \t\r\n])((ftp|http|https|gopher|mailto|news|nntp|telnet|wais|file|prospero|aim|webcal):(([A-Za-z0-9$_.+!*(),;/?:@&~=-])|%[A-Fa-f0-9]{2}){2,}(#([a-zA-Z0-9][a-zA-Z0-9$_.+!*(),;/?:@&~=%-]*))?([A-Za-z0-9$_+!*();/?:~-]))');
		var url = content.match(/(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig);

		/* regular expression that will allow us to extract url from the textarea */
		if ((url != null) && (url.length > 0) && $(parentDiv).children('.ajax_flag').val() == 0) { // If there's atleast one url entered in the textarea
				/* ajax_flag ensure that if a url is found and user press spacebar,ajax will trigger only once. */
			$(childrenDiv).children(".fetched_data").slideDown('fast'); // show this div with a 'slidedown' effect - previously hiddden by default
			$(childrenDiv).find('.loader').html('<div class="progress progress-striped active"><div class="bar" style="width: 100%;"></div></div>'); // Add an Ajax loading image similar to facebook
			$(buttonGroup).children(".button_group").children().children(".submit_post").attr('disabled','disabled');
				/* remove button to prevent posting without content */
			$(parentDiv).children('.text_value').val(content); // url stored to input text value
			$.post("../wall/get_content", { url: url[0], pid: '<?php echo $pid; ?>' }, function (response) { // Ajax call using get passing the url extracted from the textarea
					$(childrenDiv).children('.fetched_data').children(".ajax_content").html(response) //Place the response processed by get_content.php and place it in a div with id = ajax_content
					$(childrenDiv).children('.fetched_data').children('.loader').empty(); // remove the ajax loading image now
					/* show button */
					$('img#1').fadeIn(); // Add a fading effect with the first image thumbnail extracted from the external website
					$(parentDiv).children('.current_img').val(1); // Initiate value =1 - this will be used for the next / previous button
					$(buttonGroup).children(".button_group").children().children(".submit_post").removeAttr('disabled');
					$(div).css('border-bottom', 'medium none');
					$(childrenDiv).children('.fetched_data').css('border-color','#ddd').css('border-style','dashed solid solid').css('border-width','1px').css('padding-top', '10px');
			});
			$(parentDiv).children('.ajax_flag').val(1); // Ensure that only once ajax will trigger if a url match is found in the textarea  
		}
	}

	$('.wall<?php echo $pid; ?>').on('paste',function() {
		var trigger = $(this);
		setTimeout(function() { // para magpause ng onti
			get_contentPaste(trigger);
			return false;
		},100);
	});
	
    ///////////////////////////////////////////////////////////////////////	 Next image
    $('form.imageform').delegate('.next','click', function (e) { // when user click on next button
	
		var parentForm = $(e.target).parents('form.imageform');
        var firstimage = parentForm.find('.current_img').val(); // get the numeric value of the current image
        if (firstimage <= parentForm.find('.total_images').val() - 1) // as long as last image has not been reached
        {
            parentForm.find('img.' + firstimage).hide(); // hide the current image to be able to display the next image
            firstimage = parseInt(firstimage) + parseInt(1); // Increment image no so that next image no. can be displayed
            parentForm.find('.current_img').val(firstimage); // Incremented in input tag
            parentForm.find('img.' + firstimage).show(); // show second image
        }
        parentForm.find('.totalimg').html(firstimage + ' of ' + $('.total_images').val()); // Update the current image no display value
    });
    ///////////////////////////////////////////////////////////////////////	 Next image
    ///////////////////////////////////////////////////////////////////////	 prev image
    $('form.imageform').delegate('.prev','click', function (e) { // When user clicks on Previous Button
		var parentForm = $(e.target).parents('form.imageform');
        //Same logic as for Next Button
        var firstimage = parentForm.find('.current_img').val();
        if (firstimage >= 2) {
            parentForm.find('img.' + firstimage).hide();
            firstimage = parseInt(firstimage) - parseInt(1);
            parentForm.find('.current_img').val(firstimage);
            parentForm.find('img.' + firstimage).show();
        }
        parentForm.find('.totalimg').html(firstimage + ' of ' + $('.total_images').val());
    });
	
	$('.blog_item<?php echo $pid; ?>').delegate('.remove_post','click', function(e) {
		var idd = $(this).parent().attr('id');
		$('.page_delete_id').val(idd);
		$('#myModal_delete_post').modal('show');
	});
	
	function post_to_twitter() {
		/* post to twitter */
		twttr.anywhere(function (T) {
			if (T.isConnected()) {
				var tweetMsg = $('textarea.wall<?php echo $pid; ?>').val();

				/* for bitly code */
				var url='<?php echo base_url($siteUrl.'/'.$pageNameUrl); ?>';

				var username="micinfo"; // bit.ly username
				var key="R_a783cdce15538eb1f601bc5b62ef2d61";
				$.ajax({
					url:"http://api.bit.ly/v3/shorten",
					data:{longUrl:url,apiKey:key,login:username},
					dataType:"jsonp",
					success:function(v)
					{
						var bit_url=v.data.url;
						
						if(tweetMsg.length >= 100)
						{
							tweetMsg = tweetMsg.substr(0,100)+'...'+bit_url;
						}else
						{
							tweetMsg = tweetMsg+'...'+bit_url;
						}
						T.Status.update(tweetMsg, {
							success: function (tweet) {
							  alert('message tweet');
							  $('textarea.wall<?php echo $pid; ?>').val('');

							},
							error: function (error) {
							  alert('message not sent');
							  $('textarea.wall<?php echo $pid; ?>').val('');
							}
						});
						
					}
				});
			}else
			{
				$('textarea.wall<?php echo $pid; ?>').val('');
			}
		});
		/* end of posting to twitter */
	}
	
	
	$('.delete_post').on('click',function(e){
		var id = $('.page_delete_id').val();
		var dataString = 'postid='+id;
		$.ajax({ 
			type: "POST",
			url: "<?php echo base_url(); ?>test/deletepost",
			data: dataString,
			success: function (html) {
				$('#'+id).html('');
				$('#'+id).hide();
				$('#myModal_delete_post').modal('hide');
			}
			
		});
		
		e.stopImmediatePropagation();
	});
	
	$('.fetched_data').delegate('.remove','click',function(e){
		var parentForm = $(e.target).parents('form[name="form_wall"]');
		parentForm.find('.ajax_content').empty(); // empty the div with id = ajax_content ( contains previous content fetched via ajax )
		parentForm.find('.fetched_data').css('border', 'none').hide(); // hide the div 
		parentForm.find('textarea').css('border-bottom', '1px solid #CCCCCC'); // hide the div 
		parentForm.find('.ajax_flag').val(0); //reset this to zero
	});
	
	$('.pagination_blog_content').delegate('.play_button','click',function(e){
		$(this).attr('src','<?php echo base_url('img/loading.gif'); ?>');
		var url = $(this).parent().parent().children().children('.video_url_link').attr('alt');
		var eto = $(this).parent();
		
		/* detect if youtube or vimeo */
		var ytLink = url.match('youtube.com');
		var vmLink = url.match('vimeo.com');
		var dailymotionLink = url.match('dailymotion.com/video');
		if(ytLink != null)
		{
			/* for youtube link */
			var convert = url.replace('watch?v=','embed/');
				convert += '?autoplay=1';
			
				/* remove space */
			var sample = convert.replace(' ','');
			
			
			setTimeout(function(){
				$(eto).css('float','none');
				$(eto).html('<iframe src="'+sample+'"></iframe>');
				$('iframe').css('width','100%');
				$('iframe').css('height','500px');
			},500);
		}else if(vmLink != null)
		{
			/* for vimeo link */
			var convert = url.replace('vimeo.com','player.vimeo.com/video');
				convert += '?autoplay=1';
			
				/* remove space */
			var sample = convert.replace(' ','');
			
			
			setTimeout(function(){
				$(eto).css('float','none');
				$(eto).html('<iframe src="'+sample+'"></iframe>');
				$('iframe').css('width','100%');
				$('iframe').css('height','500px');
			},500);
		}else if(dailymotionLink != null)
		{
			/* for dailymotion link */
			var convert = url.replace('dailymotion.com/video','dailymotion.com/embed/video/');
				convert += '?autoplay=1';	
			
			/* remove space */
			var sample = convert.replace(' ','');
			
			setTimeout(function(){
				$(eto).css('float','none');
				$(eto).html('<iframe src="'+sample+'"></iframe>');
				$('iframe').css('width','100%');
				$('iframe').css('height','500px');
			},500);
		}
		
		e.stopImmediatePropagation();
	});
	
	/* facebook post */
	window.fbAsyncInit = function() {
		FB.init({
			appId      : '203727729715737', // App ID
			status     : false, // check login status
			cookie     : true, // enable cookies to allow the server to access the session
			xfbml      : true  // parse XFBML
		});
	};
	
	$('.submit_post').click(function(e){
		
		var parentDiv = $(this).parents('.imageform');
		/* avoid submit_post when loading is show */
		if($(".loader").html() != '')
		{
			return false;
		}
		
		var textarea_content = $('textarea.wall<?php echo $pid; ?>').val(); // get the content of what user typed ( in textarea ) 
		var title_post = $(parentDiv).find('.blog_title').val();
		
		if(textarea_content == '')
		{
			$(this).parents('.textarea_group').find('textarea.wall<?php echo $pid; ?>').focus();
			return false;
		}
		$('.loading_state_blog').html('<img src="<?php echo base_url('img/ajax-loader.gif'); ?>" >');
		// .val().replace(/.+[\\\/]/, "");
		var uploadFile = $(parentDiv).find('.uploadFile').val().replace(/.+[\\\/]/, "");
		var sitetitle = $('div.title').html(); // then get external site title (if there's any )
		var siteurl = $('div.url').html(); // get site url ( if there's any )
		var sitedesc = $('div.desc').html(); // get external site description ( if there's any)
		var current_image_id = $(parentDiv).find('input.current_img').val(); // get the current image thumbnail id (if there's any)
		
		/* detect if link is video */
		var hiddentText = $(parentDiv).find('.text_value').val();
		var youtube = hiddentText.match(/^https?:\/\/(?:www\.)?youtube\.com\/watch\?(?=.*v=((\w|-){11}))(?:\S+)?$/);
		var vimeo = hiddentText.match(/http:\/\/(www\.)?vimeo.com\/(\d+)($|\/)/);
		var dailymotion = hiddentText.match(/http:\/\/www\.dailymotion\.com\/video\/+/);
		var playBtn = '<span class="play_button" style="cursor:pointer;bottom: 2px;left:2px;position: absolute;background-color: rgba(255, 255, 255, 0.5);padding: 0 10px;"><i class="icon-play"></i></span>';
		
		
		if(siteurl == null)
		{
			siteurl = ' ';
		}
		if(sitetitle == null) 
		{
			sitetitle = ' ';
		}
		
		if(sitedesc == null) // if no value retrieved
		{ 
			sitedesc = ' '; //set to blank to prevent 'null' or 'undefined' displayed on page
		}		
		
		// we need that id to post the correct image chosen by user in  wall post
		if (current_image_id) { //make sure id is retrieved successfully
			var current_image_url = $("img." + current_image_id).attr("src"); // get the current image displayed in thumbnail url in "src" tag 
			
			if (current_image_url) { //if there's an image url 
				var image_html = '<img src="'+current_image_url+'" style="width:150px;border:1px solid;">'; // prepare image url 'embeded with appropriate html
			} else { 
				var image_html = ''; //No image to display ( it means that no image url was retrieved from external website , ( ignoring <div class = 'img_attachement> .. </div>	
			}
		} else {
			var current_image_url = ' ';
			if(uploadFile) {
				// uploadFiles = uploadFile.split(" ").join("_");
				// var image_html = '<img style="width:67%;" class="external_pic" src="<?php echo base_url(); ?>uploads/' + uploadFiles + '" />';
				
				$(parentDiv).ajaxForm({
					success: function(html) {
						var object = JSON.parse(html);
						var image_html = '<img style="width:67%;" class="external_pic" src="<?php echo base_url(); ?>uploads/' + object.image + '" />';
						/* show line break */
						textarea_contents = textarea_content.replace(/\n\r?/g, '</p><p>');
						
						if(object.message_id) {
							$('.blog_item<?php echo $pid; ?>').prepend(
								'<div class="well list_li_blog" id="'+object.message_id+'">'+
									'<a class="remove_post"><img class="close_img" src="<?php echo base_url('img/close_button.png'); ?>"></a>'+
									'<h4>'+title_post+'</h4>'+
									'<p>'+textarea_contents+'</p>'+
									'<div style="margin-right:10px;">'+	image_html +
									'</div>'+
								'</div>'
							);
							$('.loading_state_blog').html('');
							$('.list_li_blog:first-child').hide().fadeIn(2000);
							
							/* remove photos in preview */
							$('.preview').html('');
							$(parentDiv).find('.fileupload').addClass('fileupload-new').removeClass('fileupload-exists');
							$(parentDiv).find('.fileupload-filename').html('');
							
							post_to_twitter();
						}
					}
				}).submit();					
			} else {
				var image_html = '';
			}
		}
		
		if(!uploadFile || current_image_id)
		{
			if(youtube == null)
			{
				playBtn = '';
			}
			if(vimeo == null)
			{
				playBtn = '';
			}
			var ID = $(this).attr('alt');
			var message_wall = $('textarea.wall<?php echo $pid; ?>').val();
			var dataString = { 'pid': <?php echo $pid; ?>, 'wall': textarea_content, 'wid': ID, 'image': image_html, 'title': sitetitle, 'url': siteurl, 'desc': sitedesc, 'imageUrl': current_image_url, 'imageName': uploadFile, 'title_post': title_post };

			$.ajax({ 
				type: "POST",
				url: "<?php echo base_url(); ?>wall/insert",
				data: dataString,
				success: function (html) {
					
					/* show line break */
					textarea_contents = textarea_content.replace(/\n\r?/g, '</p><p>');
					
					if(siteurl != null)
					{
						if(youtube != null)
						{
							
							$('.blog_item<?php echo $pid; ?>').prepend(
								'<div class="well list_li_blog" id="'+html+'">'+
									'<a class="remove_post"><img class="close_img" src="<?php echo base_url('img/close_button.png'); ?>"></a>'+
									'<h4>'+title_post+'</h4>'+
									'<p>'+textarea_contents+'</p>'+
									'<div class="pull-left" style="margin-right:10px;position:relative;">'+	playBtn + image_html + '</div>'+
									'<div style="overflow:hidden;margin-right: 10px;">'+
										'<p style="color:#08C;margin:0;"><a href="'+siteurl+'">'+sitetitle+'</a></p>'+
										'<p class="video_url_link" alt="'+siteurl+'"></p>'+
										'<p>'+sitedesc+'</p>'+
									'</div>'+
									'<div style="clear:both;"></div>'+   
								'</div>'
							);  
						}else if(vimeo != null)
						{
							$('.blog_item<?php echo $pid; ?>').prepend(
								'<div class="well list_li_blog" id="'+html+'">'+
									'<a class="remove_post"><img class="close_img" src="<?php echo base_url('img/close_button.png'); ?>"></a>'+
									'<h4>'+title_post+'</h4>'+
									'<p>'+textarea_contents+'</p>'+
									'<div class="pull-left" style="margin-right:10px;position:relative;">'+	playBtn + image_html + '</div>'+
									'<div style="overflow:hidden;margin-right: 10px;">'+
										'<p style="color:#08C;margin:0;"><a href="'+siteurl+'">'+sitetitle+'</a></p>'+
										'<p class="video_url_link" alt="'+siteurl+'"></p>'+
										'<p>'+sitedesc+'</p>'+
									'</div>'+
									'<div style="clear:both;"></div>'+
								'</div>');
						}else
						{
							$('.blog_item<?php echo $pid; ?>').prepend(
								'<div class="well list_li_blog" id="'+html+'" >'+
									'<a  class="remove_post"><img class="close_img" src="<?php echo base_url('img/close_button.png'); ?>"></a>'+
									'<h4>'+title_post+'</h4>'+
									'<p>'+textarea_contents+'</p>'+
									'<div class="pull-left" style="margin-right:10px;margin-left:10px;position:relative;">'+ image_html + '</div>' +
									'<div style="overflow:hidden;margin-right: 10px;">'+
										'<p style="color:#08C;margin:0;"><a href="'+siteurl+'">'+sitetitle+'</a></p>'+
										'<p class="video_url_link" alt="'+siteurl+'"></p>'+
										'<p>'+sitedesc+'</p>'+
									'</div>'+
									'<div style="clear:both;"></div>'+
								'</div>'
							);
						}
					}else
					{
						$('.blog_item<?php echo $pid; ?>').prepend(
							'<li class="well list_li_blog" id="'+html+'">'+
								'<a class="remove_post"><img class="close_img" src="<?php echo base_url('img/close_button.png'); ?>"></a>'+
								'<h4>'+title_post+'</h4>'+
								'<p>'+textarea_contents+'</p>'+					
							'</li>');
					}
					$('.list_li_blog:first-child').hide().fadeIn(2000);
					$('.loading_state_blog').html('');
					
					post_to_twitter();

				}
				
			});
		}
		
		/* remove data after submit */
		$('input.current_img').val('');
		
		$('.ajax_content').empty(); // empty the div with id = ajax_content ( contains previous content fetched via ajax )
		$('.fetched_data').hide(); // hide the div 
		$('.loader').empty(); // remove the ajax loading image now
		$('.ajax_flag').val(0); //reset  this to zero
		$('.uploadFile').val(''); 
		$('.fileupload-preview').html(''); 
		$('.fileupload-new').show(); 
		$('.filechange').hide(); 
		$('.close').html(''); 
		$(".fetched_data").css('border','none');
		$('textarea.wall<?php echo $pid; ?>').val('');
		$(parentDiv).find('.blog_title').val('');
		
<?php 
	if($uQuery['publish_blog'] == 'yes')
	{
?>
		if(textarea_content)
		{
			var link_input = '';
			var pictures = '';
			if(hiddentText)
			{
				link_input = hiddentText;
			}else if(uploadFile)
			{
				pictures = '<?php echo base_url(); ?>uploads/'+uploadFile; 
				link_input = '<?php echo base_url($siteUrl.'/'.url_title($pageRow['name'],'-',true)); ?>'; 
			}else
			{
				pictures = '';
			}

			FB.getLoginStatus(function(response) {
				if (response.status === 'connected') {
					var uid = response.authResponse.userID;
					var accessToken = response.authResponse.accessToken;
					
					if(uid == '<?php echo $uQuery['fb_id_fk']; ?>')
					{	
						FB.api('me/feed', 'post', { message: textarea_content, picture: pictures, link: link_input, name: link_input}, function(response) {
						  if (!response || response.error) {
							// alert('Error occured');
						  } else {
							// alert('Post ID: ' + response.id);
						  }
						});
					}
					
				} else if (response.status === 'not_authorized') {
				  // alert('hindi pumasok');
					/* the user is logged in to Facebook, 
					but has not authenticated your app */
				} else {
				  // alert('hindi login');
					/* the user isn't logged in to Facebook. */
				}
			});
		}
<?php
	}
?>
		e.stopImmediatePropagation();
		return false;
	});
	(function(d){ 
		var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
		js = d.createElement('script'); js.id = id; js.async = true;
		js.src = "//connect.facebook.net/en_US/all.js";
		d.getElementsByTagName('head')[0].appendChild(js);
	}(document));
</script>

	<script>
	  function handleFileSelect(evt) {
		evt.preventDefault;
		evt.stopPropagation;
		
		var parentPage = $(evt.target).parents('.page');
		var files = evt.target.files; // FileList object
		for (var i = 0, f; f = files[i]; i++) {

		  // Only process image files.
		  if (!f.type.match('image.*')) {
			continue;
		  }

		  var reader = new FileReader();

		  // Closure to capture the file information.
		  reader.onload = (function(theFile) {
			return function(e) {
			  // Render thumbnail.
			  var span = document.createElement('span');
			  span.innerHTML = ['<img class="thumb" src="', e.target.result,
								'" title="', escape(theFile.name), '"/>'].join('');
			  parentPage.find('.preview').html(span);
			};
		  })(f);

		  // Read in the image file as a data URL.
		  reader.readAsDataURL(f);
		}
	  }
	  $('.uploadFile').on('change', function(e) {
		handleFileSelect(e);
		// $('.fileUpload_group').slideUp();
	  });
	</script>