<script>
	window.fbAsyncInit = function() {
      FB.init({
        appId      : '203727729715737', // App ID
        status     : true, // check login status
        cookie     : true, // enable cookies to allow the server to access the session
        xfbml      : true  // parse XFBML
      });
	
	var status = $('.switch_word').html();
	if(status == 'ON')
	{
		$('.facebook_find_friends').show();
	}else
	{
		$('.facebook_find_friends').hide();
	}

		$('.loading_fb_friends').html('<div class="progress progress-striped active"><div class="bar" style="width: 8%;"></div></div>').slideDown();
		
		/* loading effect */
		setTimeout(function(){
			$('.loading_fb_friends').html('<div class="progress progress-striped active"><div class="bar" style="width: 10%;"></div></div>');
		},500);
		setTimeout(function(){
			$('.loading_fb_friends').html('<div class="progress progress-striped active"><div class="bar" style="width: 20%;"></div></div>');
		},1000);
		setTimeout(function(){
			$('.loading_fb_friends').html('<div class="progress progress-striped active"><div class="bar" style="width: 30%;"></div></div>');
		},1500);
		setTimeout(function(){
			$('.loading_fb_friends').html('<div class="progress progress-striped active"><div class="bar" style="width: 40%;"></div></div>');
		},2000);
		setTimeout(function(){
			$('.loading_fb_friends').html('<div class="progress progress-striped active"><div class="bar" style="width: 50%;"></div></div>');
		},2500);
		setTimeout(function(){
			$('.loading_fb_friends').html('<div class="progress progress-striped active"><div class="bar" style="width: 70%;"></div></div>');
		},3000);
		setTimeout(function(){
			$('.loading_fb_friends').html('<div class="progress progress-striped active"><div class="bar" style="width: 80%;"></div></div>');
		},3500);
		setTimeout(function(){
			$('.loading_fb_friends').html('<div class="progress progress-striped active"><div class="bar" style="width: 90%;"></div></div>');
		},4000);
		setTimeout(function(){
			$('.loading_fb_friends').html('<div class="progress progress-striped active"><div class="bar" style="width: 100%;"></div></div>');
		},4500);
		
		setTimeout(function(){
			FB.getLoginStatus(function(response) {
				if (response.status === 'connected') {
					var uid = response.authResponse.userID;
					var accessToken = response.authResponse.accessToken;
					
					FB.api('me/friends', function(response) {
						if(!response.data)
						{
							$('#contentArea').append("<div style='clear: both;text-align: center;'>the user isn't logged in to Facebook.</div>");
						}
						var namelist = new Array();
						var idlist = new Array();
						
						$(response.data).each(function(event,ui){
							namelist.push(ui.name);
							idlist.push(ui.id);
						});
						
						var dataString = 'fb_id='+idlist+'&fb_name='+namelist;
						$.ajax({
							type: "POST",
							url: '<?php echo base_url(); ?>test/fb_bolooka_list',
							data: dataString,
							success: function(html){
								$('#friend_list_container').append(html);
								$('.loading_fb_friends').html('');
								$('.loading_fb_friends').css('display','none');
							}
						});

					});

				} else if (response.status === 'not_authorized') {
					alert('User not authorized');
					/* the user is logged in to Facebook, 
					but has not authenticated your app */
				} else {

					/* the user isn't logged in to Facebook. */
					$('.loading_fb_friends').css('display','none');
					$('#friend_list_container').append('the user isn\'t logged in to Facebook');
				}
			});
			
		},2500);
	
	$('.button_invite').live('click',function(){
		var facebook_user = $(this).attr('alt');
		var element = $(this);
		FB.ui({
			method: 'feed',
			name: 'Join me on Bolooka',
			link: '<?php echo base_url(); ?>', 
			picture: '<?php echo base_url('img/bolookalogo.png'); ?>',
			to: facebook_user,
			description: 'Bolooka is a social e-commerce web generator that allows online sellers to have their own website and be followed by interested cutomers',
        },function(response) {
			if (response) {
				$(element).parent().fadeOut(800);
			} else {
			  // /* do nothing */
			}
		});
		
	});
};
(function(d){ 
	var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
	js = d.createElement('script'); js.id = id; js.async = true;
	js.src = "//connect.facebook.net/en_US/all.js";
	d.getElementsByTagName('head')[0].appendChild(js);
}(document));
</script>
<style>
	.fbimginvite li {
		list-style: none;
		margin-bottom: 10px;
	}
	.fbimgbolooka li {
		list-style: none;
		margin-bottom: 10px;
	}
	
	/* RESPONSIVE */
	@media (max-width: 767px)
	{
		.mobile_view {
			padding: 0 8px;
		}
	}
</style>
<div class="container-fluid mobile_view">
<legend style="font-family: Segoe UI Semibold; font-size: 18px; color: rgb(23, 23, 23);">Facebook Friends List</legend>

<!--<div id="contentArea">
	<div style="width: 690px;margin: auto;">
		<div class="metal_line"></div>
		<br/>
		<div class="loading_fb_friends" style="display:none;"></div>
		<div id="friend_list_container">
			
		</div>
	</div>
</div>-->
<div class="row-fluid" style="margin-top: 20px;">
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span12">
			<div class="loading_fb_friends" style="display:none;"></div>
				<div class="row-fluid" id="friend_list_container">
				</div>
			</div>
		</div>
	</div>
</div>
</div>