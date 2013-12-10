<?php
// error_reporting(0);
// include_once 'includes/db.php';

// include_once 'includes/functions.php';

// include_once 'includes/tolink.php';

// include_once 'includes/time_stamp.php';

// include_once 'session.php';
$newdata = array(
                   'uid'  => '1',
               );
$this->session->set_userdata($newdata);
$data['uid'] = $this->session->userdata('uid');

// $Wall = new Wall_Updates();
// $updatesarray=$Wall->Updates($uid);
$data['updatesarray'] = $this->Wall_Updates->Updates($this->session->userdata('uid'));

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Version 3.0</title>
<link href="css/wall.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
 <script type="text/javascript" src="js/jquery.oembed.js"></script>
 <script type="text/javascript" src="js/wall.js"></script>
</head>
<body>
	<div id="wall_container">
				<form method="post" action="">
		<div id="updateboxarea">
			<h4>What's up?</h4>
			<div>
					<textarea cols="30" rows="4" name="update" id="update" maxlength="200" ></textarea>
					<br />
					<input type="hidden" autocomplete="off" class="mentionsHidden" name="xhpc_message" value="" />
			</div>
			<div id="section" style="border: 1px solid #000">

			</div>
					<input type="submit"  value=" Update "  id="update_button"  class="update_button"/>
			
		</div>
				</form>
		<div id='flashmessage'>
			<div id="flash" align="left"  ></div>
		</div>
		<div id="content">

	<?php
		$this->load->view('wall/load_messages', $data);
	?>
		</div>

	</div>
</body>
</html>
