<?php
define('FACEBOOK_APP_ID', '203727729715737'); // Place your App Id here
define('FACEBOOK_SECRET', 'd3488c95ea0bbdc5f51c30108cb41093'); // Place your App Secret Here

// No need to change the function body
function parse_signed_request($signed_request, $secret) {
	list($encoded_sig, $payload) = explode('.', $signed_request, 2);
	// decode the data
	$sig = base64_url_decode($encoded_sig);
	$data = json_decode(base64_url_decode($payload), true);
	
	if (strtoupper($data['algorithm']) !== 'HMAC-SHA256') {
		error_log('Unknown algorithm. Expected HMAC-SHA256');
		return null;
	}

	// check sig
	$expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
	if ($sig !== $expected_sig) {
		error_log('Bad Signed JSON signature!');
		return null;
	}
	return $data;
}

function base64_url_decode($input) {
	return base64_decode(strtr($input, '-_', '+/'));
}

 // if ($_REQUEST) {

	// session_start();

	$response = parse_signed_request($_REQUEST['signed_request'], FACEBOOK_SECRET);

	$name = $response["registration"]["name"];
	$first_name = $response["registration"]["first_name"];
	$last_name = $response["registration"]["last_name"];
	$email = $response["registration"]["email"];
	$password = $response["registration"]["password"];
	$business_type = $response["registration"]["business_type"];
	$guid = $response["user_id"];
	
	// Retriving the user
	$query = mysql_query("SELECT uid, first_name from users where guid = '$guid' and oauth_type = 'facebook'") or die (mysql_error());
	$result = mysql_fetch_array($query);

	if (empty($result)) {
		// user not present in Database. Store a new user and Create new account for him
		$query = mysql_query("INSERT INTO users (oauth_type, guid, name, first_name, last_name, email, password, business_type) VALUES ('facebook', '$guid', '$name', '$first_name', '$last_name', '$email', '$password', '$business_type')") or die (mysql_error());
		$query = mysql_query("SELECT uid, first_name from users where guid = '$guid' and oauth_type = 'facebook'") or die (mysql_error());
		$result = mysql_fetch_array($query);
	}
	
	// Creating session variable for User
	// $_SESSION['login'] = true;
	// $_SESSION['name'] = $result['name'];
	// $_SESSION['guid'] = $result['guid'];
	// $_SESSION['oauth_provider'] = 'facebook';
	
	// echo '<a href="javascript:window.close();">Close This Window</a>';
	$this->session_model->create_session($result['guid'], $result['name']);
	redirect('dashboard');

// } else {
	// echo '$_REQUEST is empty';
// }
?>