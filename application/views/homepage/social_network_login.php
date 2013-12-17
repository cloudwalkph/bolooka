	<div style="text-align: center;">
		<div id="fb_login" class="fb_bg" style="font-family: 'lucida grande',tahoma,verdana,arial,sans-serif; color: rgb(255, 255, 255); cursor: pointer;">
			<span style="border-right: 1px solid rgb(94, 114, 157); font-weight: 600; vertical-align: middle; font-size: 24px; padding: 0px 6px;"> f </span>
			<span style="border-left: 1px solid rgb(133, 152, 192); vertical-align: middle; text-shadow: -1px -1px 0px rgb(86, 105, 145); font-size: 14px; font-weight: 600; padding: 6px 10px;"> Sign in with Facebook </span>
		</div>

		<div class="btn-group fb_sign_up_button" style="margin: 0px;">
			<button class="btn btn-mini btn-inverse dropdown-toggle" data-toggle="dropdown" style="padding: 5px;">
				<span style="font-size: 20px; vertical-align: middle;"> &#9660; </span>
			</button>
			<ul class="dropdown-menu pull-right social_log_in_border" style="text-align: left; max-width: 128px; padding: 0px; border-radius: 0px 0px 0px 0px;">
			<!-- dropdown menu links -->
				<li><?php $this->load->file('api/Yahoo_Oauth_YOS/index.php'); ?></li>
				<li><?php $this->load->file('api/google-api-php-client/examples/userinfo/index.php'); ?></li>
				<li style="cursor: pointer;"><?php $this->load->file('api/liveservices-LiveSDK-2b505a1/Samples/PHP/OauthSample/default.html'); ?></li>
			</ul>
		</div>
	</div>