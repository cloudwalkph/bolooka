<?php
	class Video_model extends CI_Model 
	{
		function detect_url($location)
		{
			if(preg_match('/http:\/\/www\.youtube\.com\/watch\?v=[^&]+/', $location, $vresult) || preg_match('/https:\/\/www\.youtube\.com\/watch\?v=[^&]+/', $location, $vresult)) { 

				$type= 'youtube';

			  } elseif(preg_match('/http:\/\/(.*?)blip\.tv\/file\/[0-9]+/', $location, $vresult) || preg_match('/https:\/\/(.*?)blip\.tv\/file\/[0-9]+/', $location, $vresult)) {


				  $type= 'bliptv';

			  } elseif(preg_match('/http:\/\/(.*?)break\.com\/(.*?)\/(.*?)\.html/', $location, $vresult) || preg_match('/https:\/\/(.*?)break\.com\/(.*?)\/(.*?)\.html/', $location, $vresult)) {

				  $type= 'break';

			  } elseif(preg_match('/http:\/\/www\.metacafe\.com\/watch\/(.*?)\/(.*?)\//', $location, $vresult) || preg_match('/https:\/\/www\.metacafe\.com\/watch\/(.*?)\/(.*?)\//', $location, $vresult)) {

				  $type= 'metacafe';

			  } elseif(preg_match('/http:\/\/video\.google\.com\/videoplay\?docid=[^&]+/', $location, $vresult) || preg_match('/https:\/\/video\.google\.com\/videoplay\?docid=[^&]+/', $location, $vresult)) {

				  $type= 'google';

			  } elseif(preg_match('/http:\/\/www\.dailymotion\.com\/video\/+/', $location, $vresult) || preg_match('/https:\/\/www\.dailymotion\.com\/video\/+/', $location, $vresult)) {

				  $type= 'dailymotion';

			  } elseif(preg_match('/vimeo/', $location, $vresult)) {

				  $type= 'vimeo';

			  }
			  else
			  {
				$type = 'no video';
			  }
			  
			  return $type;
		}
		
		function getyoutubeid($location)
		{
			$url = $location;
			parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
			return $my_array_of_vars['v'];  
		}
	}
?>