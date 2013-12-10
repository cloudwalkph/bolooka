<?php
/*
 * Copyright 2011 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
			
require_once 'api/google-api-php-client/src/apiClient.php';
require_once 'api/google-api-php-client/src/contrib/apiOauth2Service.php';
// session_start();

$client = new apiClient();
$client->setApplicationName("Google UserInfo PHP Starter Application");
// Visit https://code.google.com/apis/console?api=plus to generate your
// oauth2_client_id, oauth2_client_secret, and to register your oauth2_redirect_uri.
if($_SERVER['HTTP_HOST']=='www.bolooka.com') {
	$client->setClientId('1021472772055.apps.googleusercontent.com');
	$client->setClientSecret('O-rR0RcUu8CT8Nry2CNWinxH');
	$client->setRedirectUri(base_url());
} elseif($_SERVER['HTTP_HOST']=='alpha.bolooka.com') {
	$client->setClientId('1021472772055-4gb7rqarn9n0nhk9k9a2ai8t0sor75t1.apps.googleusercontent.com');
	$client->setClientSecret('EC_8h4eNZfBMfTLIsxSGLJHP');
	$client->setRedirectUri(base_url());
} elseif($_SERVER['HTTP_HOST']=='localhost') {
	$client->setClientId('1021472772055-4h9bvepi8vg1m3dcg9ookqp1i8qokdnb.apps.googleusercontent.com');
	$client->setClientSecret('kM7yxw3lGOYy79kQfXa9V5I2');
	$client->setRedirectUri(base_url());
}

$client->setDeveloperKey('AIzaSyCJqFgQDmf-t6aWeyVzhPGOadavi7d0YnI');
$oauth2 = new apiOauth2Service($client);

if (isset($_GET['code'])) {
  $client->authenticate();
  $this->session->userdata['token'] = $client->getAccessToken();
  $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
  $redirect = 'http://' . $_SERVER['HTTP_HOST'];
  header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
}

if (isset($this->session->userdata['token'])) {
 $client->setAccessToken($this->session->userdata['token']);
}

if (isset($_REQUEST['glogout'])) {
  $this->session->unset_userdata['token'];
  $client->revokeToken();
}

if ($client->getAccessToken()) {
  $user = $oauth2->userinfo->get();

  // These fields are currently filtered through the PHP sanitize filters.
  // See http://www.php.net/manual/en/filter.filters.sanitize.php
  $email = filter_var($user['email'], FILTER_SANITIZE_EMAIL);
  $img = filter_var($user['picture'], FILTER_VALIDATE_URL);
  $firstname = filter_var($user['given_name']);
  $lastname = filter_var($user['family_name']);
  $gender = filter_var($user['gender']);
  $guid = filter_var($user['id']);
  
  $personMarkup = "$firstname<br/>$lastname<br/>$email<br/>$gender<br/><div><img src='$img?sz=50'></div>";

  // The access token may have been updated lazily.
  $this->session->userdata['token'] = $client->getAccessToken();
				
	$query = $this->db->query("SELECT * FROM users WHERE email='$email'");
	
	if($query->num_rows() > 0)
	{
		foreach($query->result_array() as $row)
		{
			$uid = $row['uid'];
			$fb_name = $row['first_name'];
		}
		$this->db->query("UPDATE users SET g_id_fk = '$guid' WHERE email like '$email'");
		$this->session_model->create_session($uid, $fb_name);
		redirect('manage');
	}
	else
	{
		redirect(base_url()."?init=$guid&name=$firstname&last=$lastname&email=$email&connect=google");
	}
	
	
} else {
  $authUrl = $client->createAuthUrl();
}
?>
<?php	
	// if(isset($personMarkup)):
	// print $personMarkup
	// endif
?>
<?php
if(isset($authUrl)) {
	print '<a class="login mp_oss_i mp_oss_i_google" href="'.$authUrl.'"><img src="'.base_url().'img/google_icon_drop.png" style="height: 17px; width: 17px;"> Google </a>';
} else {
	print '<a class="logout" href="?glogout"></a>';
}
?>