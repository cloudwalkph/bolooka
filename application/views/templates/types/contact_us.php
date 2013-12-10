<?php 
	$this->db->where('page_id', $pid);
	$query = $this->db->get('contact_us');
	
	$this->db->where('website_id', $wid);
	$queryPage = $this->db->get('pages');	
	
	if($query->num_rows() > 0)
	{
		$contact = $query->row();
	}
	else	# check contacts if not found in contact_us table
	{
		$contact = $queryPage->row();
	}
	
	$this->db->where('id', $wid);
	$this->db->where('deleted', 0);
	$getUser = $this->db->get('websites');
	$user = $getUser->row();
	
	$this->db->where('uid', $user->user_id);
	$queryUser = $this->db->get('users');
	$userRow = $queryUser->row();
	
	$this->db->where('id', $pid);
	$queryName = $this->db->get('pages');
	$pageName = $queryName->row();
?>

<style>/*
label {
    font-weight: bold;
    margin: 4px;
    text-align: right;
    width: 110px;
}
input {
    border: medium none;
    border-radius: 12px 12px 12px 12px;
    padding: 6px;
    width: 300px;
	background-color: #E9E9E9;
}
textarea {
    height: 7em;
    margin: 0;
    width: 300px;
}
.contact-buttons a {
    background: none repeat scroll 0 0 #555555;
    border-radius: 15px 15px 15px 15px;
    cursor: pointer;
    display: inline-block;
    margin: 4px;
    padding: 8px;
    text-align: center;
    width: 50px;
}
.contact-buttons a:hover {
    background: none repeat scroll 0 0 #555555;
    border-radius: 15px 15px 15px 15px;
    cursor: pointer;
    display: inline-block;
    margin: 4px;
    padding: 8px;
    text-align: center;
    width: 50px;
	box-shadow: 1px 1px 5px 0px inset;
}
li label {
	text-align: left;
	width: 100%;
} */
<?php
	$button_hover = '#0082ee';
	$button_bg = '#A5A5A5';
	if(isset($contact->button_bg) || isset($contact->button_hover))
	{
		if($contact->button_bg)
		{
			$button_bg = $contact->button_bg;
		}
		
		if($contact->button_hover)
		{
			$button_hover = $contact->button_hover;
		}
	}
?>
.btn_design {
	background: <?php echo $button_bg; ?>;
	color: #fff;
	border-radius: 0px;
	border: 0;
	text-shadow: none;
	
}
.btn_design:hover {
	background: <?php echo $button_hover; ?>;
	color: #fff;

}
.contact_table dd {
    word-wrap: break-word;
}
</style>

	<div class="row-fluid">

		<div class="span7 pull-right" style="margin-bottom: 10px">
			<div style="padding: 10px">
				<h3 style="font-weight: normal; line-height: 1;" class="visible-phone"><?php echo $pageName->name; ?></h3>
<?php if(isset($contact->email) != ' ' || ($contact->email) != '') { ?>
				<dl class="dl-horizontal contact_table">
					<dt>Email: </dt>
					<dd><?php echo $contact->email; ?></dd>
				</dl>
<?php } ?>
<?php if(isset($contact->landline) != ' ' || ($contact->landline) != '') { ?>
				<dl class="dl-horizontal contact_table">
					<dt>Landline: </dt>
					<dd><?php echo $contact->landline; ?></dd>
				</dl>
<?php } ?>
<?php if(isset($contact->mobile) != ' ' || ($contact->mobile) != '') { ?>	
				<dl class="dl-horizontal contact_table">
					<dt>Mobile: </dt>
					<dd><?php echo $contact->mobile; ?></dd>
				</dl>
<?php } ?>
<?php if(isset($contact->address) != ' ' || ($contact->address) != '') { ?>	
				<dl class="dl-horizontal contact_table">
					<dt>Address: </dt>
					<dd><?php echo $contact->address; ?></dd>
				</dl>
<?php } ?>
<?php
		if( $contact->fb || $contact->twitter || $contact->gplus || $contact->linkedin || isset($contact->pinterest) || isset($contact->instagram) ) {
?>
				<dl class="dl-horizontal contact_table">
					<dt>Follow us:</dt>
					<dd>
<?php
					if($contact->fb) {
						if(preg_match_all('#facebook\.com\/(.+)#', $contact->fb, $fbmatch)) {
							$fbresult = $fbmatch[1][0];
						} else {
							$fbresult = url_title($contact->fb);
						}
?>
						<a class="imageLink" href="<?php echo '//facebook.com/'.$fbresult; ?>" target="_blank"><img src="<?php echo base_url() ?>img/c_fb.png"></a>
<?php
					}
					if($contact->twitter) {
						if(preg_match_all('#twitter\.com\/(.+)#', $contact->twitter, $twittermatch)) {
							$twitterresult = $twittermatch[1][0];
						} else {
							$twitterresult = url_title($contact->twitter);
						}
?>
						<a class="imageLink" href="<?php echo '//twitter.com/'.$twitterresult; ?>" target="_blank"><img src="<?php echo base_url() ?>img/c_tw.png"></a>
<?php
					}
					if($contact->gplus) {
						if(preg_match_all('#plus\.google\.com\/(.+)#', ($contact->gplus), $gplusmatch)) {
							$gplusresult = $gplusmatch[1][0];
						} else {
							$gplusresult = url_title($contact->gplus);
						}
?>
						<a class="imageLink" href="<?php echo '//plus.google.com/'.$gplusresult; ?>" target="_blank"><img src="<?php echo base_url() ?>img/c_gp.png"></a>
<?php
					}
					if($contact->linkedin) {
						if(preg_match_all('#linkedin\.com\/(.+)#', ($contact->linkedin), $linkedinmatch)) {
							$linkedinresult = $linkedinmatch[1][0];
						} else {
							$linkedinresult = url_title($contact->linkedin);
						}
?>
						<a class="imageLink" href="<?php echo '//linkedin.com/'.$linkedinresult; ?>" target="_blank"><img src="<?php echo base_url() ?>img/c_li.png"></a>
<?php
					}
					if($contact->pinterest) {
						if(preg_match_all('#pinterest\.com\/(.+)#', $contact->pinterest, $pinterestmatch)) {
							$pinterestresult = $pinterestmatch[1][0];
						} else {
							$pinterestresult = url_title($contact->pinterest);
						}
?>
						<a class="imageLink" href="<?php echo '//pinterest.com/'.$pinterestresult; ?>" target="_blank"><img src="<?php echo base_url() ?>img/pinterest.png" style="height: 24px;"></a>
<?php
					}
					if($contact->instagram) {
						if(preg_match_all('#instagram\.com\/(.+)#', $contact->instagram, $instagrammatch)) {
							$instagramresult = $instagrammatch[1][0];
						} else {
							$instagramresult = url_title($contact->instagram);
						}
?>
						<a class="imageLink" href="<?php echo '//instagram.com/'.$instagramresult; ?>" target="_blank"><img src="<?php echo base_url() ?>img/instagram-icon.png" style="height: 24px;"></a>
<?php
					}
?>
					</dd>
				<?php } ?>
				</dl>
		
				<div class="row-fluid" style="margin-bottom: 5px;">
					<!--<div class="span3"> Store Location : </div><div class="span9" style=""><?php //echo $contact->google_map; ?></div>-->
				</div>
				<div class="row-fluid">
					<input type="hidden" id="g_maps_value" value="<?php echo $contact->google_map; ?>">
					<div id="map_canvas" style="height: 180px;"></div>
				</div>

			</div>
		</div>
		<div class="span5 pull-right">
			<div style="padding: 10px">
				<h3 style="font-weight: normal; line-height: 1;" class="hidden-phone"><?php echo $pageName->name; ?></h3>
				<p style="font-size: 12px; font-weight: bold; line-height: 1;"><?php echo $contact->message ? htmlentities($contact->message) : 'Please feel free to drop us a message and we\'ll surely get back to you.';?></span>
				<form class="contact_submit" name="contact_submit">
					<fieldset>
						<input type="hidden" id="user_email" name="user_email" value="<?php echo $contact->email ? $contact->email : $userRow->email; ?>">
						
						<label for="fname" style="margin:0;">Name: </label>
						<input id="fname" class="span10" name="fname" type="text" placeholder="" required />
						<div class="help-inline"></div>
						
						<label for="cust_email" style="margin:0;">Email: </label>
						<input id="cust_email" class="span10" name="cust_email" type="email" placeholder="" required />
						<span id="email_required" class="help-inline" style="color:red;"></span>
						<span class="help-block"></span>
						
						<label for="subject" style="margin:0;">Subject: </label>
						<input id="subject" class="span10" name="subject" type="text" placeholder="" required />
						<span class="help-inline"></span>
						
						<label for="business_type" style="margin:0;">Message: </label>
						<textarea id="message" class="span10" name="message" rows="5" class="span12" required ></textarea>
						<span class="help-block"></span>
						
						<button type="submit" id="submit" class="btn btn_design" data-loading-text="Sending...">Submit</button>
						<span id="floatingBarsG" class="help-inline" ></span>
					</fieldset>
				</form>
	
			</div>
		</div>

	</div>
	
<div id="csConfirm" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="background: none repeat scroll 0 0 rgba(255, 255, 255, 0.8);font-family: Segoe UI;border-radius: 0px;">
	<div class="modal-header" style="background: none repeat scroll 0 0 #F26A2C;border-bottom: medium none;color: white;">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-white"></i></button>
		<h3 id="myModalLabel" style="font-weight: normal;">Contact Seller</h3>
	</div>
	<div class="modal-body">
		<h4>Your Message has been sent!</h4>
	</div>
	<div class="modal-footer" style="background: none repeat scroll 0 0 rgba(255, 255, 255, 0);border: medium none;box-shadow: none;">
		<button class="btn btn-style" data-dismiss="modal" aria-hidden="true">Close</button>
	</div>
</div>

<!--for google maps-->
<script type="text/javascript"src="http://maps.googleapis.com/maps/api/js?sensor=true"></script>
<script>
$(document).ready(function(){

	var geocoder;
	var map;
	
	initialize();
	
	/* initialize google maps */
	function initialize() {
		var mapOptions = {
			center: new google.maps.LatLng(-34.397, 100.644),
			zoom: 15,
			mapTypeId: google.maps.MapTypeId.ROADMAP  
		};

		map = new google.maps.Map(document.getElementById("map_canvas"),
		mapOptions);
		geocoder = new google.maps.Geocoder();
		
		var infowindow = new google.maps.InfoWindow();
		
		addAddress(infowindow);
	}

	/* get map location */
	function addAddress(t) {
		var address = document.getElementById('g_maps_value').value;
		if (address != 0 && address != '') {
			geocoder.geocode( { 'address': address }, function(results, status) {
				console.log(results);
				if (status == google.maps.GeocoderStatus.OK) {
					map.setCenter(results[0].geometry.location);
					var marker = new google.maps.Marker({
					map: map,
						position: results[0].geometry.location
					});
					map.setZoom(11);
					t.setContent('<div style="color:#000;"><strong >' + results[0].address_components[0].long_name + '</strong><br>'+ results[0].formatted_address);
					t.open(map, marker);
				} else {
					console.log('Geocode was not successful for the following reason: ' + status);
					if(status == 'ZERO_RESULTS')
					{
						$('#map_canvas').html('No result');
						$('#map_canvas').hide();
					}
				}
			});
		} else {
			$('#map_canvas').hide();
		}

	}
	
	$('.contact_submit').ajaxForm({
		type: "POST",
		url: "<?php echo base_url(); ?>test/contact_us",
		data: { pid: '<?php echo $pid; ?>'},
		beforeSubmit: function() {
			$('#submit').button('loading');
		},
		success: function(html) {
			if(html == '') {
				$('#floatingBarsG')
					.html('Sending failed! connection interupt')
					.fadeOut(3000);
			} else {
				$('#csConfirm').modal('show');
				$('#floatingBarsG')
					.html('Email Sent!')
					.fadeOut(3000);
			}
			$('.contact_submit')[0].reset();
			$('#submit').button('reset');
		}
	});
});
</script>