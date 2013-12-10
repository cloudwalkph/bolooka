 <?php
 //Srinivas Tamada http://9lessons.info
//Load latest update 
// error_reporting(0);
// include_once 'includes/db.php';
// include_once 'includes/functions.php';
// include_once 'includes/tolink.php';
$this->load->view('wall/tolink');

// include_once 'includes/time_stamp.php';
$this->load->view('wall/time_stamp');

// include_once 'session.php';
// $Wall = new Wall_Updates();

$update = htmlentities($_POST['update'], ENT_QUOTES);
// $data=$Wall->Insert_Update($uid,$update);
$uid = $_POST['pid'];

$data = $this->Wall_Updates->Insert_Update($uid, $update);

		$msg_id = $data['msg_id'];
		$message = tolink(html_entity_decode($data['message']));
		$time = $data['created'];
		$uid = $data['uid_fk'];
		// $face=$Wall->Gravatar($uid);
		$face = $this->Wall_Updates->Gravatar($uid);
		// $commentsarray=$Wall->Comments($msg_id);

		echo '
		<div class="stbody" id="stbody'.$msg_id.'">
			<div class="stimg">
				<img src="'.$face.'" class="big_face" />
			</div> 
			<div class="sttext">
				<a class="stdelete" href="#" id="'.$msg_id.'" title="Delete update">X</a>
				<b>Username here...</b>'.$message.
				'<div class="sttime">'.time_stamp($time).' | <a href="#" class="commentopen" id="'.$msg_id.'" title="Comment">Comment </a></div> 
				<div id="stexpandbox">
					<div id="stexpand"></div>
				</div>
				<div class="commentcontainer" id="commentload'.$msg_id.'">
					
				</div>
				<div class="commentupdate" style="display:none" id="commentbox'.$msg_id.'">
					<div class="stcommentimg">
						<img src="'.$face.'" class="small_face" />
					</div> 
					<div class="stcommenttext" >
						<form method="post" action="">
							<textarea name="comment" class="comment" maxlength="200"  id="ctextarea'.$msg_id.'"></textarea>
							<br />
							<input type="submit" value=" Comment "  id="'.$msg_id.'" class="comment_button"/>
						</form>
					</div>
				</div>
			</div> 
		</div>
		';
?>