<?php
/* test messaging */
	$this->db->order_by('timestamp');
	$qchat = $this->db->get('chat');
	$rchat = $qchat->result_array();
	
	$chat_form_attrib = array(
		'id' => 'chat_form'
	);
	
	echo form_open('test/chat', $chat_form_attrib);
?>
<input type="hidden" class="from" value="<?php echo $uid; ?>">
<input type="hidden" class="to" value="">
<div class="navbar-fixed-bottom">
	<div class="container pull-right">
		<div style="width: 220px; background-color: rgba(5,5,5,.5); color: white;">
			<div class="text-center">
				Chat
			</div>
			<div id="chat_msg" style="height: 220px; overflow-y: scroll;">
<?php
	foreach($rchat as $chat)
	{
		$this->db->where('uid', $chat['from_user_id']);
		$quser = $this->db->get('users');
		$ruser = $quser->row_array();

		echo '<div>' . $ruser['name'] .': ' . $chat['message'] . '</div>';
	}
?>
			</div>
			<div>
				<input type="text" value="">
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