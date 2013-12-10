<?php
	class Times_model extends CI_Model 
	{
		
		
		function convert_datetime($str) {
	
   		list($date, $time) = explode(' ', $str);
    	list($year, $month, $day) = explode('-', $date);
    	list($hour, $minute, $second) = explode(':', $time);
    	$timestamp = mktime($hour, $minute, $second, $month, $day, $year);
    	return $timestamp;
		}

		function makeAgo($timestamp) {
		
			$difference = time() - $timestamp;
			$periods = array("sec", "min", "hr", "day", "week", "month", "year", "decade");
			$lengths = array("60","60","24","7","4.35","12","10");
			for($j = 0; $difference >= $lengths[$j]; $j++)
   			$difference /= $lengths[$j];
   			$difference = round($difference);
			if($difference != 1) $periods[$j].= "s";
   			$text = "$difference $periods[$j] ago";
   			return $text;
				
		}
		
		function makeAgoNum($timestamp) {
		
			$difference = time() - $timestamp;
			$periods = array("sec", "min", "hr", "day", "week", "month", "year", "decade");
			$lengths = array("60","60","24","7","4.35","12","10");
			for($j = 0; $difference >= $lengths[$j]; $j++)
   			$difference /= $lengths[$j];
   			$difference = round($difference);
			if($difference != 1) $periods[$j].= "s";
   			$text = $difference;
   			return $difference;
				
		}
		
		function makeAgoPeriod($timestamp) {
		
			$difference = time() - $timestamp;
			$periods = array("sec", "min", "hr", "day", "week", "month", "year", "decade");
			$lengths = array("60","60","24","7","4.35","12","10");
			for($j = 0; $difference >= $lengths[$j]; $j++)
   			$difference /= $lengths[$j];
   			$difference = round($difference);
			if($difference != 1) $periods[$j].= "s";
   			$text = "$periods[$j] ago";
   			return $text;
		}
		
		function makeAgoPeriods($timestamp) {
		
			$difference = time() - $timestamp;
			$periods = array("sec", "min", "hr", "day", "week", "month", "year", "decade");
			$lengths = array("60","60","24","7","4.35","12","10");
			for($j = 0; $difference >= $lengths[$j]; $j++)
   			$difference /= $lengths[$j];
   			$difference = round($difference);
			if($difference != 1) $periods[$j].= "s";
			
			if($periods[$j]<=10)
				{
					$text = "a few seconds ago";
				
				}
			else{
		
   			$text = "$periods[$j] ago";
			
				}
   			return $text;
				
		}
		
		
		
		function get_extension($file_name){

		$ext = explode('.', $file_name);

		$ext = array_pop($ext);

		return strtolower($ext);

		}
		
		function getAgeLong($then) {
			$then_year = date('Y', $then);
			$age = date('Y') - $then_year;
			if(strtotime('+' . $age . ' years', $then) > time()) $age--;
			return $age;
		}
		
		function getAgeShort($then) {
			$then = date('Ymd', $then);
			$diff = date('Ymd') - $then;
			return substr($diff, 0, -4);
		}
		
		
	}
?>