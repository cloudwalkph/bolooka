 <html>
    <head>
      <title>My Facebook Login Page</title>
    </head>
    <body>

    
	  
	  
	  
	  <div id="fb-root"></div>
    <script>
      // Load the SDK Asynchronously
      (function(d){
         var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
         if (d.getElementById(id)) {return;}
         js = d.createElement('script'); js.id = id; js.async = true;
         js.src = "//connect.facebook.net/en_US/all.js";
         ref.parentNode.insertBefore(js, ref);
       }(document));

      // Init the SDK upon load
      window.fbAsyncInit = function() {
        FB.init({
          appId      : '203727729715737', // App ID
		  // channelUrl : '//'+window.location.hostname+'/channel', // Path to your Channel File
          status     : false, // check login status
          cookie     : true, // enable cookies to allow the server to access the session
          xfbml      : true  // parse XFBML
        });
		
		// listen for and handle auth.statusChange events
		FB.Event.subscribe('auth.statusChange', function(response) {
			$('.mp_oss').slideUp();
		  if (response.authResponse) {
			// user has auth'd your app and is logged into Facebook
			FB.api('/me', function(me) {
				if (me) {
					$.post("signup/facebook",
						{
							'id': me.id,
							'first_name': me.first_name,
							'email': me.email,
							'last_name': me.last_name,
							'gender': me.gender,
							'bdays': me.birthday
						},
						function(html)
						{
							window.location = '<?php echo base_url(); ?>/manage';
						}
					);
				}
			});
		  } else {
			// user has not auth'd your app, or is not logged into Facebook
		  }
		});
      }
    </script>
	  

      <div class="fb-login-button">Login with Facebook</div>

    </body>
 </html>