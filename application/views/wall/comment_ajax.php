
 <?php
 //Srinivas Tamada http://9lessons.info
//Load latest comment 
// error_reporting(0);
// include_once 'includes/db.php';
// include_once 'includes/functions.php';
// include_once 'includes/tolink.php';
$this->load->view('wall/tolink');

// include_once 'includes/time_stamp.php';
$this->load->view('wall/time_stamp');

// include_once 'session.php';

// $Wall = new Wall_Updates();
if(isSet($_POST['comment']))
{
	// $uid = $this->session->userdata('uid');
	$comment = htmlentities($_POST['comment'], ENT_QUOTES);
	$msg_id = $_POST['msg_id'];
	$ip = $_SERVER['REMOTE_ADDR'];
	$cdata = $this->Wall_Updates->Insert_Comment($msg_id, $comment);
	if($cdata)
	{	
		$com_id = @$cdata['com_id'];
		$comment = tolink(htmlentities(@$cdata['comment'] ));
		$time = @$cdata['created'];
		$username = @$cdata['first_name'];
		$uid = @$cdata['uid_fk'];
		$cface = $this->Wall_Updates->Gravatar($uid);

		echo '
		<div class="stcommentbody" id="stcommentbody'.$com_id.'">
			<div class="stcommentimg">
				<img src="'.$cface.'" class="small_face" />
			</div> 
			<div class="stcommenttext">
				<a class="stcommentdelete" href="#" id='.$com_id.'>X</a>
				<b>'.$username.'</b> '.$comment.'
				<div class="stcommenttime">'.time_stamp($time).'</div> 
			</div>
		</div>
		';
	}
}
?>
