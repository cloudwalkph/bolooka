<?php

// Include the YOS library.
require_once 'lib/Yahoo.inc';
// include 'db_config.php';
// session_start();
if($_SERVER['HTTP_HOST']=='www.bolooka.com') {
	define('OAUTH_CONSUMER_KEY', 'dj0yJmk9WHZkdmNRSHA0SnBVJmQ9WVdrOVozRk1ZemQ1TjJzbWNHbzlNVEUyTVRBek16RTJNZy0tJnM9Y29uc3VtZXJzZWNyZXQmeD1lMw--');
	define('OAUTH_CONSUMER_SECRET', 'bd383746f8d3d36d0325cb7263ee91ffb32d289f');
	define('OAUTH_APP_ID', 'gqLc7y7k');
} elseif($_SERVER['HTTP_HOST']=='alpha.bolooka.com') {
	define('OAUTH_CONSUMER_KEY', 'dj0yJmk9ZzNjSUdTa2pwcnBvJmQ9WVdrOVMwMU9WVEJXTlRBbWNHbzlNVFV4TkRVM09UZzJNZy0tJnM9Y29uc3VtZXJzZWNyZXQmeD0yYQ--');
	define('OAUTH_CONSUMER_SECRET', '8c0f76ed4df30246982633bc444ee2e893619ed3');
	define('OAUTH_APP_ID', 'KMNU0V50');
}

$key = $this->uri->uri_string();

if ($key == 'signup/yin') {
    $session = YahooSession::requireSession(OAUTH_CONSUMER_KEY, OAUTH_CONSUMER_SECRET, OAUTH_APP_ID);
    if (is_object($session)) {
        $user = $session->getSessionedUser();
        $profile = $user->getProfile();

        $guid = $profile->guid; // Getting Yahoo ID
		$givenName = $profile->givenName;
		$familyName = $profile->familyName;
		$email = $profile->emails;
		$gender = $profile->gender;
		$birthdate = $profile->birthdate;

		// PARSE THE ITEM TO BE RECORDED //
		if(is_array($email)) 
		{
			$keys = array_keys($email);
			$arr_count = count($email);
			$for_loop = $arr_count-1;
			for($i = 0;$i <= $for_loop; $i++)
			{
				if(isset($email[$keys[$i]]->primary))
				{
					if($email[$keys[$i]]->primary == "1")
					{
						$email = $email[$keys[$i]]->handle;
					}	
				}
			}
		}
		
        // Retriving the user
		$query = $this->db->query("SELECT * FROM users WHERE email='$email'");
		
		if($query->num_rows() > 0)
		{
			foreach($query->result_array() as $row)
			{
				$uid = $row['uid'];
				$fb_name = $row['first_name'];
			}
			$this->db->query("UPDATE users SET y_id_fk = '$guid' WHERE email like '$email'");
			$this->session_model->create_session($uid, $fb_name);
			redirect('dashboard');
		}
		else
		{
			redirect(base_url()."?init=$guid&name=$givenName&last=$familyName&email=$email&connect=yahoo");
		}
    } else {
		echo 'Yahoo Authentication Failed';
	}
}
if ($key == 'signup/yout') {
    // User logging out and Clearing all Session data
    YahooSession::clearSession();
    // unset ($_SESSION['login']);
    // unset($_SESSION['name']);
    // unset($_SESSION['guid']);
    // unset($_SESSION['oauth_provider']);
    // After logout Redirection here
    // header("Location: index.php");
	// $this->session->sess_destroy();
}

?>