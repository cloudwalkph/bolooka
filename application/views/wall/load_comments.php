 <?php
	//Srinivas Tamada http://9lessons.info
	//Loading Comments link with load_updates.php 
	if(isSet($commentsarray))
	foreach($commentsarray as $cdata)
	{
		$com_id = $cdata['com_id'];
		$comment = tolink(htmlentities($cdata['comment'] ));
		$time = $cdata['created'];
		$uid = $cdata['uid_fk'];
		$cface = $this->Wall_Updates->Gravatar($uid);
		$uid = $this->session->userdata('uid');
?>
		<div class="stcommentbody" id="stcommentbody<?php echo $com_id; ?>">
			<div class="stcommentimg">
				<img src="<?php echo $cface; ?>" class='small_face'/>
			</div> 
			<div class="stcommenttext">
				<a class="stcommentdelete" href="#" id='<?php echo $com_id; ?>' title='Delete Comment'>X</a>
				<!--<b>Username</b>--> <?php echo $comment; ?>
				<div class="stcommenttime" style="color: #999999;" ><?php time_stamp($time); ?></div> 
			</div>
		</div>
<?php 
	}
?>