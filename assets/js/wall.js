// Srinivas Tamada http://9lessons.info
// wall.js

$(document).ready(function() 
{
	// Update Status
	$(".update").bind('paste', function(e)
	{
		var ID = $(this).attr('num');
		var el = $(this);
			setTimeout(function() {
			
				var content = $('.update').val();
				var url = content.match(/https?:\/\/([-\w\.]+)+(:\d+)?(\/([\w/_\.]*(\?\S+)?)?)?/);
				if(url.length > 0) {
					$("#section"+ID).show();
					$("#section"+ID).fadeIn(400).html('<div id="embed"><img src="/img/loading.gif" height="20" width="20" /></div>');
					$("#embed").oembed(el.val());
				}
				return false;
			}, 100);
	});
	
	$(".update_button").live('click', function()
	{
		var ID = $(this).attr('id');
		var updateval = $("#update"+ID).val();
		var dataString = 'update='+ updateval + '&pid=' + ID;
		if(updateval=='') {
			alert("Put text first");
		}
		else
		{
			$("#flash"+ID).show();
			$("#flash"+ID).fadeIn(400).html('Loading Update...');
			$.ajax({
				type: "POST",
				url: "../../wall/message_ajax",
				data: dataString,
				cache: false,
				success: function(html)
				{
					$("#flash"+ID).fadeOut('slow');
					$("#blog_content"+ID).prepend(html);
					$("#update"+ID).val('');
					$("#update"+ID).focus();
					$("#section"+ID).slideUp();

					$("#stexpand"+ID).oembed(updateval);
				}
			});
		}
		return false;
	});
		
	//commment Submint

	$('.comment_button').live("click",function() 
	{
		var ID = $(this).attr("id");

		var comment= $("#ctextarea"+ID).val();
		var dataString = 'comment='+ comment + '&msg_id=' + ID;

		if(comment=='')
		{
			alert("Please Enter Comment Text");
		}
		else
		{
			$.ajax({
				type: "POST",
				url: "wall/comment_ajax",
				data: dataString,
				cache: false,
				success: function(html) {
					$("#commentload"+ID).append(html);
					$("#ctextarea"+ID).val('');
					$("#ctextarea"+ID).focus();
				 }
			 });
		}
		return false;
	});
	// commentopen 
	$('.commentopen').live("click",function() 
	{
		var ID = $(this).attr("id");
		$("#commentbox"+ID).slideToggle('slow');
		return false;
	});	

	// delete comment
	$('.stcommentdelete').live("click",function() 
	{
		var ID = $(this).attr("id");
		var dataString = 'com_id='+ ID;

		if(confirm("Sure you want to delete this update? There is NO undo!"))
		{

			$.ajax({
				type: "POST",
				url: "wall/delete_comment_ajax",
				data: dataString,
				cache: false,
				success: function(html){
					$("#stcommentbody"+ID).slideUp();
				}
			});

		}
		return false;
	});
		// delete update
	$('.stdelete').live("click", function() 
	{
		var ID = $(this).attr("id");
		var dataString = 'msg_id='+ ID;

		if(confirm("Sure you want to delete this update? There is NO undo!"))
		{
			$.ajax({
				type: "POST",
				url: "wall/delete_message_ajax",
				data: dataString,
				cache: false,
				success: function(html) {
					$("#stbody"+ID).slideUp();
				 }
			 });
		}
		return false;
	});
});
