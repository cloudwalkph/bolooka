<?php

class Registration_Model extends CI_Model {

	function register() {

		if(isset($_POST['save'])) {
			
			extract($_POST);		
									
				$firstname = ucwords(mysql_real_escape_string($firstname));
				$lastname = mysql_real_escape_string($lastname);
				$real_password = mysql_real_escape_string($password);
				$password = md5($password);
				$phone = mysql_real_escape_string($phone);
				$email = mysql_real_escape_string($email);
				$gender = mysql_real_escape_string($gender);
				$birthdate = mysql_real_escape_string($birthdate_year).'-'.mysql_real_escape_string($birthdate_month).'-'.mysql_real_escape_string($birthdate_day);
				$newsletter = mysql_real_escape_string($newsletter);
				$status = '0';
				$verification = $getData->get_rand_id(5);
				$date_added = date('Y-m-d H:i:s');
				$date_updated = date('Y-m-d H:i:s');
				
			$trigger = 0;
					
					/** Validate captcha */
					if (!empty($_REQUEST['captcha'])) {
						if (empty($_SESSION['captcha']) || trim(strtolower($_REQUEST['captcha'])) != $_SESSION['captcha']) {
							echo "<script type=\"text/javascript\">alertUI('capcha','');</script>";
							$trigger = 1;
						}
						unset($_SESSION['captcha']);
					}					
					$checkEmail = "SELECT * FROM  member WHERE email = '".$email."'";
					$result = mysql_query($checkEmail);													
					if(mysql_num_rows($result) >= 1){
						$trigger = 1;
						echo "<script type=\"text/javascript\">alertUI('email-message','');</script>";					
					}
					
			foreach ($_POST as $post => $v){			
				$_SESSION[$post] = $v;	
			}
							
				
			if($trigger == 0){								
				$query =  "INSERT INTO `member`(firstname,lastname,password,phone,email,gender,birthdate,date_added,date_updated,newsletter,verification,status)
							VALUES('$firstname','$lastname','$password','$phone','$email','$gender','$birthdate','$date_added','$date_updated','$newsletter','$verification','$status')";
				$result = mysql_query($query) or die(mysql_error());

	//			$link = mysql_connect('localhost', 'root', '') or die('Could not connect: ' . mysql_error());
	//			//$link = mysql_connect('localhost', 'au2parts_user', '0Ryw0HBmaPQw') or die('Could not connect: ' . mysql_error());				
	//			mysql_select_db('punbb',$link)
	//				or die('Could not select database');

				$link = mysql_connect('localhost', 'au2parts_user', '0Ryw0HBmaPQw')
					or die('Could not connect: ' . mysql_error());
				mysql_select_db('au2parts_punbb',$link)
					or die('Could not select database');
					
				$pun_query =  "INSERT INTO `users`(group_id,username,password,salt,email,realname,email_setting,notify_with_post,show_smilies,show_img,show_avatars,show_sig,access_keys,timezone,language,style)
								VALUES('3','$email','$password','','$email','$firstname','1','0','1','1','1','1','0','0','English','Oxygen')";	
				$result = mysql_query($pun_query) or die(mysql_error());						   
				mysql_close();

				if($result){
					echo "<script type=\"text/javascript\">alertUI('success-message','$aPath');</script>";
					$getData->mailVerification($email,$firstname,$verification,$real_password,'member');
					unset($_SESSION);				
				}else{
					echo "<script type=\"text/javascript\">alertUI('unsuccess-message','$aPath');</script>";
				}
			}
		}
	}
}
?>