<?php
/* test messaging */
	echo $uid;
	$this->db->where('from_user_id', $uid);
	$this->db->or_where('to_user_id', $uid);
	$this->db->order_by('timestamp');
	$qchat = $this->db->get('chat');
	$rchat = $qchat->result_array();
	
	$chat_form_attrib = array(
		'id' => 'chat_form'
	);
	
	echo form_open('test/chat', $chat_form_attrib);
?>
<style>
#messaging ul li:hover {
	background-color: gray;
}
</style>
	<div id="messaging" class="container-fluid mobile_view">
		<div class="row-fluid ch-feed" style="padding-top: 10px;">
			<legend style="margin-bottom: 9px;font-family: Segoe UI Semibold; font-size: 18px; color: rgb(23, 23, 23);">Messaging</legend>			
		</div>
		<div class="row-fluid">
			<div class="span2">
				<ul class="unstyled">
<?php
				foreach($rchat as $chat)
				{
					$this->db->where('uid', $chat['from_user_id']);
					$quser = $this->db->get('users');
					$ruser = $quser->row_array();
?>

					<li>
						<?php echo $ruser['name']; ?>
					</li>
<?php
				}
?>
				</ul>
			</div>
			<div class="span10">
<?php
				foreach($rchat as $chat)
				{
					$this->db->where('uid', $chat['from_user_id']);
					$quser = $this->db->get('users');
					$ruser = $quser->row_array();
?>
				<div class="media">
					<a class="pull-left" href="#">
						<img class="media-object" data-src="holder.js/12x12" alt="<?php echo $ruser['name']; ?>">
					</a>
					<div class="media-body">
						<?php echo $chat['message']; ?>
					</div>
				</div>
<?php
				}
?>
				<div class="row-fluid">
					<textarea class="span12" style="resize: none;"> </textarea>
				</div>
			</div>
		</div>
	</div>
<script>
$(function() {
	$('#chat_form').ajaxForm({
		beforeSend: function(a,b,c) {
			console.log(c);
		},
		type: 'post',
		url: "<?php echo base_url(); ?>",
		success: function(html)
		{
			$('#chat_msg').append('message sent');
		}
	});
});
</script>
<?php
	/**/
?>