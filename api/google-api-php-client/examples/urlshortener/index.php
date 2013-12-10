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
session_start();

// require_once '../../src/apiClient.php';
// require_once '../../src/contrib/apiUrlshortenerService.php';
$this->load->file('api/google-api-php-client/src/apiClient.php');
$this->load->file('api/google-api-php-client/src/contrib/apiUrlshortenerService.php');

// Visit https://code.google.com/apis/console to
// generate your client id, client secret, and redirect uri.
$client = new apiClient();
$client->setClientId('1021472772055-4h9bvepi8vg1m3dcg9ookqp1i8qokdnb.apps.googleusercontent.com');
$client->setClientSecret('kM7yxw3lGOYy79kQfXa9V5I2');
$client->setRedirectUri('http://localhost/project-bolooka/');
$service = new apiUrlshortenerService($client);

if (isset($_REQUEST['logout'])) {
  unset($_SESSION['access_token']);
}

if (isset($_GET['code'])) {
  $client->authenticate();
  $_SESSION['access_token'] = $client->getAccessToken();
  $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
  header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
}

if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
  $client->setAccessToken($_SESSION['access_token']);
} else {
  $authUrl = $client->createAuthUrl();
}

if ($client->getAccessToken() && isset($_GET['url'])) {
  // Start to make API requests.
  $url = new Url();
  $url->longUrl = $_GET['url'];
  $short = $service->url->insert($url);
  $_SESSION['access_token'] = $client->getAccessToken();
}
?>
<!doctype html>
<html>
<head><link rel='stylesheet' href='style.css' /></head>
<body>
<header><h1>Google Url Shortener Sample App</h1></header>
<div class="box">
  <div class="request">
    <?php if (isset($authUrl)): ?>
      <a class='login' href='<?php print $authUrl; ?>'>Connect Me!</a>
    <?php else: ?>
      <form id="url" method="GET" action="<?php base_url(); ?>test/url_shortener/index.php">
        <input name="url" class="url" type="text">
        <input type="submit" value="Shorten">
      </form>
      <a class='logout' href='?logout'>Logout</a>
    <?php endif ?>
  </div>

  <?php if (isset($short)): ?>
    <div class="shortened">
      <pre><?php var_dump($short); ?></pre>
    </div>
  <?php endif ?>
</div>
</body></html>
