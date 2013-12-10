<?php
	$this->db->where('page_id', $pid);
	$queryContactUs = $this->db->get('contact_us');
	# if no content in article table will get old content in pages table
	$countContactUs = $queryContactUs->num_rows();
	if($countContactUs == '0') {
		$this->db->where('website_id', $wid);
		$queryContactUs = $this->db->get('pages');
	}else
	{
		
	}
	# end
	$rowContactUs = $queryContactUs->row();
	
	$userId = $this->session->userdata('uid');
	$this->db->where('uid',$userId);
	$queryUser = $this->db->get('users');
	$userRow = $queryUser->row();
	
	$fix_message = "Please feel free to drop us a message and we'll surely get back to you.";
?>

<div class="container-fluid">
	<div class="row-fluid">
		<legend style="font-family: 'Segoe UI bold'; font-size: 14px;">
			<span class="yalbum" style="text-transform: uppercase;"> Your Contact Info: </span>
		</legend>
	</div>
<?php	
	
	$attributes = array('class' => 'contact_us_form form-horizontal', 'id' => 'contact_us_form');
	echo form_open('dashboard/update_page/pages', $attributes);
?>
	
	<div class="alert alert-success alert-block success_contact" style="display: none;">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<h4>Saved!</h4>
	</div>

	<div class="control-group">
		<label class="control-label" for="contact_us_textarea">Message:</label>
		<div class="controls">
			<textarea rows="6" id="contact_us_textarea" class="span8" name="message<?php echo $pid; ?>" maxlength="150" placeholder="Message"><?php echo $rowContactUs->message ? $rowContactUs->message : $fix_message; ?></textarea>
		</div>
	</div>
	<hr>
	<div class="control-group">
		<label class="control-label" for="email">Email:</label>
		<div class="controls">
			<input type="text" id="email" class="span4" name="email<?php echo $pid; ?>" value="<?php echo $rowContactUs->email != '' ? $rowContactUs->email : $userRow->email; ?>">
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="landline">Landline:</label>
		<div class="controls">
			<input type="text" id="landline" class="span4" name="landline<?php echo $pid; ?>" value="<?php echo $rowContactUs->landline; ?>" maxlength="20">
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="mobile">Mobile:</label>
		<div class="controls">
			<input type="text" id="mobile" class="span4" name="mobile<?php echo $pid; ?>" value="<?php echo $rowContactUs->mobile; ?>" maxlength="20">
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="Address">Address:</label>
		<div class="controls">
			<textarea rows="6" type="text" id="Address" class="span8" name="address<?php echo $pid; ?>" maxlength="150"><?php echo $rowContactUs->address; ?></textarea>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="emailcc">Email Address that will receive inquiries:</label>
		<div class="controls">
			<textarea rows="3" class="span8" id="emailcc" name="emailcc<?php echo $pid; ?>" ><?php echo $rowContactUs->emailcc != '' ? $rowContactUs->emailcc : ''; ?></textarea>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="searchTextField">Google map:</label> 
		<div class="controls">
			<input class="span4" type="text" id="searchTextField" name="google_map<?php echo $pid; ?>" value="<?php echo $rowContactUs->google_map; ?>" placeholder="Google Maps Url">
		</div>
	</div>
	<div class="control-group">
		<label class="control-label"></label> 
		<div class="controls">
			<div id="map-canvas" class="span8"style="height: 200px;"></div>
		</div>
	</div>
	<legend style="font-family: 'Segoe UI bold'; font-size: 14px;">
		<span class="yalbum" style="text-transform: uppercase;"> Social Fan Page: </span>
	</legend>
	<div class="control-group">
		<label class="control-label" for="fb">Facebook Fan Page:</label>
		<div class="controls">
			<input type="text" id="fb" class="span4" name="fb<?php echo $pid; ?>" value="<?php echo $rowContactUs->fb; ?>" placeholder="http://www.facebook.com/">
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="gplus">Google+ Page:</label>
		<div class="controls">
			<input type="text" id="gplus" class="span4" name="gplus<?php echo $pid; ?>" value="<?php echo $rowContactUs->gplus; ?>" placeholder="http://www.google.com/">
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="twitter">Twitter:</label>
		<div class="controls">
			<input type="text" id="twitter" class="span4" name="twitter<?php echo $pid; ?>" value="<?php echo $rowContactUs->twitter; ?>" placeholder="http://www.twitter.com/">
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="linkedin">LinkedIn:</label>
		<div class="controls">
			<input type="text" id="linkedin" class="span4" name="linkedin<?php echo $pid; ?>"  value="<?php echo $rowContactUs->linkedin; ?>" placeholder="http://www.linkedin.com/">
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="pinterest">Pinterest:</label>
		<div class="controls">
			<input type="text" id="pinterest" class="span4" name="pinterest<?php echo $pid; ?>"  value="<?php echo isset($rowContactUs->pinterest) ? $rowContactUs->pinterest : ''; ?>" placeholder="http://pinterest.com/">
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="instagram">Instagram:</label>
		<div class="controls">
			<input type="text" id="instagram" class="span4" name="instagram<?php echo $pid; ?>"  value="<?php echo isset($rowContactUs->instagram) ? $rowContactUs->instagram : ''; ?>" placeholder="http://instagram.com/">
		</div>
	</div>
	<legend style="font-family: 'Segoe UI bold'; font-size: 14px;">
		<span class="yalbum" style="text-transform: uppercase;"> Button Design: </span>
	</legend>
	<div class="control-group">
		<label class="control-label" for="button_bg">Button Background:</label>
		<div class="controls">
			<input type="text" id="button_bg" class="span4 color-picker" name="button_bg<?php echo $pid; ?>" value="<?php echo isset($rowContactUs->button_bg) ? $rowContactUs->button_bg : ''; ?>">
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="button_hover">Button Hover:</label>
		<div class="controls">
			<input type="text" id="button_hover" class="span4 color-picker" name="button_hover<?php echo $pid; ?>" value="<?php echo isset($rowContactUs->button_hover) ? $rowContactUs->button_bg : ''; ?>">
		</div>
	</div>
	<div class="control-group">
		<div class="controls">
			<button type="button" class="btn" id="submit_contact_us" value="<?php echo $pid; ?>" >Save </button>
		</div>
	</div>
</form>
</div>
<script>
$('#submit_contact_us').on('click',function(e){
	var page_id = $(this).val();
	var eto = $(this);
	$('#contact_us_form').ajaxForm({
		data: {'page_id':page_id,'type':'contact_us'},
		success: function(html) {
			$('.success_contact').show();
			$('body').animate({scrollTop: $('.contact_us_form').offset().top - 150});
			setTimeout(function(){
				$('.success_contact').fadeOut(800);
			},2000);
		}
	}).submit();
	
	e.stopImmediatePropagation();
});
</script>

<script>
/* google maps js */

	function initialize() {
	  var mapOptions = {
		center: new google.maps.LatLng(-33.8688, 151.2195),
		zoom: 13,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	  };
	  var map = new google.maps.Map(document.getElementById('map-canvas'),
		mapOptions);

	  var input = /** @type {HTMLInputElement} */(document.getElementById('searchTextField'));
	  var autocomplete = new google.maps.places.Autocomplete(input);

	  autocomplete.bindTo('bounds', map);

	  var infowindow = new google.maps.InfoWindow();
	  var marker = new google.maps.Marker({
		map: map
	  });
	  
	  /* set default location */
	  var geocoder = new google.maps.Geocoder();
	  geocoder.geocode( { 'address': input.value}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
			map.fitBounds(results[0].geometry.viewport);
			var markers = new google.maps.Marker({
				map: map,
				position: results[0].geometry.location
			});
			// alert(JSON.stringify(results[0].address_components[2].long_name));
			// infowindow.setContent('<div style="color:#000;"><strong >' + results[0].address_components[2].long_name + '</strong><br>'+ results[0].formatted_address);
			infowindow.open(map, markers);
		}		
	  });
	  
	  /* on change input */
	  google.maps.event.addListener(autocomplete, 'place_changed', function() {
		infowindow.close();
		marker.setVisible(false);
		input.className = '';
		var place = autocomplete.getPlace();

		if (!place.geometry) {
		  // Inform the user that the place was not found and return.
		  input.className = 'notfound';
		  return;
		}

		// If the place has a geometry, then present it on a map.
		if (place.geometry.viewport) {
		  map.fitBounds(place.geometry.viewport);
		} else {
		  map.setCenter(place.geometry.location);
		  map.setZoom(17);  // Why 17? Because it looks good.
		}
		
		marker.setPosition(place.geometry.location);
		marker.setVisible(true);

		var address = '';
		if (place.address_components) {
		  address = [
			(place.address_components[0] && place.address_components[0].short_name || ''),
			(place.address_components[1] && place.address_components[1].short_name || ''),
			(place.address_components[2] && place.address_components[2].short_name || '')
		  ].join(' ');
		}

		// infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
		infowindow.open(map, marker);
	  });

	  /* type of maps (establishment,geocode)*/
	  autocomplete.setTypes(['geocode']);


	}

	google.maps.event.addDomListener(window, 'load', initialize);
</script>
    