<?php
class Facebook_Model extends CI_Model
{
	function __construct()
	{
	}
	
	function fb_get_fbid() {
		$this->db->where('uid', $this->session->userdata('uid'));
		$quser = $this->db->get('users');
		if($quser->num_rows() > 0) {
			$ruser = $quser->row_array();
			return $ruser['fb_id_fk'];
		}
	}
	
	function fbshare($prname=null, $pname=null, $lastimg=null, $url=null, $caption=null, $desc=null) {
		$this->load->file('api/facebook-php-sdk-master/src/facebook.php');
		$config = array(
			'appId' => '203727729715737',
			'secret' => 'd3488c95ea0bbdc5f51c30108cb41093',
		);
		$facebook = new Facebook($config);		
		$user_id = $facebook->getUser();
		
		$fb_id = $this->fb_get_fbid();
		if($fb_id != 0) {
			try {
				$response = $facebook->api(
					$fb_id.'/feed',
					'POST',
					array(
						'message' => $prname,
						'name' => $pname,
						'picture' => $lastimg,
						'link' => $url,
						'caption' => $caption,
						'description' => strip_tags($desc)
					)
				);
				return '<pre>Post ID: ' . $response['id'] . '</pre>';
			} catch(FacebookApiException $e) {
				return $e->getMessage();
			}
		}		
	}
	
	function fb_action_create($sitename) {
		$this->load->file('api/facebook-php-sdk-master/src/facebook.php');
		$config = array(
			'appId' => '203727729715737',
			'secret' => 'd3488c95ea0bbdc5f51c30108cb41093',
		);
		$facebook = new Facebook($config);
		$user_id = $facebook->getUser();
		
		$fb_id = $this->fb_get_fbid();
		if($fb_id != 0) {
			try {
				$response = $facebook->api(
					$fb_id.'/bolooka:create',
					'POST',
					array(
						'site' => base_url($sitename)
					)
				);
				return '<pre>Post ID: ' . $response['id'] . '</pre>';
			} catch(FacebookApiException $e) {
				return $e->getMessage();
			}
		}
	}
	
	function fb_not_visited($sitename=null) {
		$fb_id = $this->fb_get_fbid();
		if($fb_id != 0) {
			$this->db->where('url', $sitename);
			$qweb = $this->db->get('websites');
			if($qweb->num_rows() > 0) {
				$rweb = $qweb->row_array();
				$webid = $rweb['id'];
				$time = time();
				
				$sql = "SELECT * FROM `fb_visit` WHERE `fb_id` = '$fb_id' AND `website_id` = '$webid'";
				$query = $this->db->query($sql);
				if($query->num_rows() == 0)
				{
					$this->db->query("INSERT INTO fb_visit (`fb_id`, `website_id`, `time`) VALUES('$fb_id','$webid','$time')");
					return true;
				}
			}
		}
	}

	function fb_action_visit($sitename) {
		$this->load->file('api/facebook-php-sdk-master/src/facebook.php');
		$config = array(
			'appId' => '203727729715737',
			'secret' => 'd3488c95ea0bbdc5f51c30108cb41093',
		);
		$facebook = new Facebook($config);
		$user_id = $facebook->getUser();
		
		$fb_id = $this->fb_get_fbid();
		if($fb_id != 0) {
			try {
				$response = $facebook->api(
					$fb_id.'/bolooka:visit',
					'POST',
					array(
						'site' => base_url($sitename)
					)
				);
				return '<pre>Post ID: ' . $response['id'] . '</pre>';
			} catch(FacebookApiException $e) {
				return $e->getMessage();
			}
		}
	}
}
?>