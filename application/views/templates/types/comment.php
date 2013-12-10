<style type="text/css">
/* Let's get this party started */
::-webkit-scrollbar {
    width: 12px;
}
 
/* Track */
::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3); 
    -webkit-border-radius: 10px;
    border-radius: 10px;
}
 
/* Handle */
::-webkit-scrollbar-thumb {
    -webkit-border-radius: 10px;
    border-radius: 10px;
    background: rgba(168,168,168,0.8); 
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.5); 
}
::-webkit-scrollbar-thumb:window-inactive {
	background: rgba(168,168,168,0.4); 
}
</style>
<?php
	$log = $this->session->userdata('logged_in');
	$profilePic = 'img/no-photo.jpg';
	$username = '';
?>
<div class="row-fluid" style="">
<?php
	if($log){
	/* User Info Query */
	$uid = $this->session->userdata('uid');
	$this->db->where('uid', $uid);
	$query = $this->db->get('users');
	$users = $query->row_array();
	$username = $users['first_name'];
	
	/* Get User Profile Pics */
	$profilePic = 'http://www.placehold.it/160x160/333333/ffffff&text=no+photo';
	if($users['profile_picture'] != null) {
		$profilePic = $users['profile_picture'];
		$profilePic = str_replace(" ","_",$profilePic);
		$checkPic = 'uploads/'.$uid.'/medium/'.$profilePic;
		
		if($this->photo_model->image_exists($checkPic)) {
			$profilePic = base_url().$checkPic;
		} else {
			$checkPic = 'uploads/'.$profilePic;
			if($this->photo_model->image_exists($checkPic)) {
				$profilePic = base_url().$checkPic;
			} else {
				$profilePic = 'http://www.placehold.it/160x160/333333/ffffff&text=image+not+found';
			}
		}
	}
?>
	<table style="width:100%;" cellpadding="0" cellspacing="0">
		<tr style="">
			<td width="8%" align="right" valign="top">
				<div class="" style="background:url(<?php echo $profilePic; ?>);background-position: 50% 50%;background-repeat: no-repeat;background-size: cover;width:90%;height:34px;border: 2px solid white;"></div>
			</td>
			<td width="90%" align="left" valign="top">
				<textarea class="txt-commment-style" id="postcomment" alt="<?php echo $imgid; ?>" placeholder="Write a comment..."></textarea>
				<div class="post-btn" id="postarea">
					<a class="btn btn-link pull-right" id="postcancel" href="javascript:(void);">Cancel</a>
					<span><a class="btn btn-link pull-right" id="postfeed" href="javascript:(void);">Post</a></span>
					<div class="clearfix"></div>
				</div>
			</td>
		</tr>
	</table>
<?php
	}
?>
</div>	
<div class="row-fluid show-cmnt" style="overflow-y: auto; height: 80%;">
	<ul style="margin: 0;list-style: none;" id="cmt-feed">
	<?php
		$this->db->where('msg_id_fk',$imgid);
		$this->db->order_by("com_id desc"); 
		$querys = $this->db->get("comments");
		if($querys->num_rows() > 0){
			foreach($querys->result_array() as $rows){
			$usercmt = $rows['uid_fk'];
			$created = $rows['created'];
			$msg_id_fk = $rows['msg_id_fk'];
			$comment = $rows['comment'];
			$com_id = $rows['com_id'];
			
			
			$query3 = $this->db->query("SELECT * FROM users WHERE uid='$usercmt'");
			$users3 = $query3->row_array();
			
			/* Get User Profile Pics */
	$profilePic2 = 'http://www.placehold.it/160x160/333333/ffffff&text=no+photo';
	if($users3['profile_picture'] != null) {
		$profilePic2 = $users3['profile_picture'];
		$profilePic2 = str_replace(" ","_",$profilePic2);
		$checkPic = 'uploads/'.$users3['uid'].'/medium/'.$profilePic2;
		
		if($this->photo_model->image_exists($checkPic)) {
			$profilePic2 = base_url().$checkPic;
		} else {
			$checkPic = 'uploads/'.$profilePic2;
			if($this->photo_model->image_exists($checkPic)) {
				$profilePic2 = base_url().$checkPic;
			} else {
				$profilePic2 = 'http://www.placehold.it/160x160/333333/ffffff&text=image+not+found';
			}
		}
	}
	?>
			<li>
				<div style="border-bottom: 2px solid white;">
					<div class="pull-left user-pic" style="background:url(<?php echo $profilePic2; ?>);background-position: 50% 50%;background-repeat: no-repeat;background-size: cover;"></div>
					<p style="color: #EBEBEB;font-size: 15px;padding: 11px 0px 0px 39px;margin-bottom: 0px;"><?php echo $users3['first_name']; ?> <span style="color: #6D6D6D;font-size: 11px;">says</span><span class="pull-right" style="color: #6D6D6D;font-size: 11px;">11:14 am Feb 22, 2013</span></p>
				</div>
				<div class="row-fluid" style="background: #404040;color: #BABABA;padding: 6px 0px;">
					<p style="margin: 0;margin-left: 11px;font-size: 12px;line-height: 13px;"><?php echo $comment; ?></p>
				</div>
				<div class="row-fluid post-btn" style="width: auto;">
					<a class="btn btn-link pull-right" data-id="<?php echo $com_id; ?>">Like</a>
				</div>
				<div class="clearfix"></div>
			</li>
	<?php
			}
		}
	?>
	</ul>
</div>
<script type="text/javascript">
$(function(){
	$('#postcomment').bind('paste',function(e){
		var heightLimit = 200;
		setTimeout(function() {
			var heighttext = $('#postcomment').scrollTop();
			$('#postcomment').css('height', Math.min(heighttext, heightLimit)+'px');
			return false;
		}, 100);
		
	});
	$("#postcomment").keyup(function(e) {
		var keycode =  e.keyCode ? e.keyCode : e.which;
		while($(this).outerHeight() < this.scrollHeight + parseFloat($(this).css("borderTopWidth")) + parseFloat($(this).css("borderBottomWidth"))) {
			$(this).height($(this).height()+1);
		};
	});
	$('#postfeed').on('click',function(){
		var comentmsg = $('#postcomment').val();
		var imgid = $('#postcomment').attr('alt');
		var msg = comentmsg.replace(/\n\r?/g, '<br />');
		var msgdata = 'comentmsg='+msg+'&imgid='+imgid;
		if(comentmsg != ''){
			$.ajax({
				type:'post',
				url:'<?php echo base_url(); ?>test/imgcoment',
				data:msgdata,
				success:function(html){
					$('#postcomment').val('');
					$('#postcomment').css('height','44px');
					$('ul#cmt-feed').prepend('<li><div style="border-bottom: 2px solid white;"><div class="pull-left user-pic" style="background:url(<?php echo $profilePic; ?>);background-position: 50% 50%;background-repeat: no-repeat;background-size: cover;"></div><p style="color: #EBEBEB;font-size: 15px;padding: 11px 0px 0px 39px;margin-bottom: 0px;"><?php echo $username; ?> <span style="color: #6D6D6D;font-size: 11px;">says</span><span class="pull-right" style="color: #6D6D6D;font-size: 11px;">11:14 am Feb 22, 2013</span></p></div><div class="row-fluid" style="background: #404040;color: #BABABA;padding: 6px 0px;"><p style="margin: 0;margin-left: 11px;font-size: 12px;line-height: 13px;">'+msg+'</p></div><div class="row-fluid post-btn" style="width: auto;"><a class="btn btn-link pull-right" data-id="'+html+'">Like</a></div><div class="clearfix"></div></li>');
				}
			});		
		}		
	});
	$('#postcancel').on('click',function(){
		$('#postcomment').val('');
		$('#postcomment').css('height','44px');
	});
});
</script>