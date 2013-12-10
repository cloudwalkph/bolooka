<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url', 'cookie'));
		$this->load->library('email');
		$this->load->model('times_model');
		$this->load->model('video_model');
		$this->load->model('wall_updates');
		$this->load->helper('date');
		$this->load->library('image_lib');
		$this->load->library('cart');
		$this->load->database();	
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->model('session_model');
		$this->load->model('membership_model');
		$this->load->model('photo_model');

		$this->load->model("paging_feedback");
		$this->load->library("pagination");
		$this->load->model('colormodel');
		$this->load->model('marketplace_model');
		$this->load->model('gallery_model');
	}

	function index()
	{
		// $data['content'] = $this->load->view('manage_dashboard', '', true);

		if($this->input->post('manage')=='dashboard')
		{
			$this->load->view('manage_dashboard');
		}
		elseif($this->input->post('manage')=='website')
		{
			$this->load->view('manage_website');
		}
		elseif($this->input->post('manage')=='profile')
		{
			$data['pass_error'] = '';
			$this->load->view('manage_profile', $data);
		}
		else {
			redirect(base_url().'manage');
		}
		// $this->load->view('manage_account', $data);
		
		
	}
	
	function title_notify()
	{
		$uid = $this->session->userdata('uid');
		$query = $this->db->query("SELECT * FROM flag WHERE status='1' AND notify='".$uid."' ");
		if($query->num_rows() > 0)
		{
			$num_notify = $query->num_rows();

			echo '('.$num_notify.') Bolooka - Social E-Commerce Platform';
		}else
		{
			$num_notify = '';
			
			echo 'Bolooka - Social E-Commerce Platform';
		}
	}
	
	function notification()
	{
	
		$uid = $this->session->userdata('uid');
		
		$wQuery = $this->db->query("SELECT * FROM flag WHERE notify='".$uid."' ");
		$wQuery2 = $this->db->query("SELECT * FROM flag WHERE status='1' AND notify='".$uid."' AND action <> 'new user' ");
		$rowQuery = $wQuery->row_array();

			
		if($wQuery2->num_rows > 0)
		{
			// if($rowQuery['uid'] != $uid)
			// {
				// echo '<span id="notifyUser"><span class="num-notify"><span style="position: relative;left: 2px;">'.$wQuery2->num_rows.'</span></span><img src="'.base_url().'img/notification_logo.png" style="width: 20px;"></span>';
				echo '<span class="badge badge-important">'.$wQuery2->num_rows.'</span><i class="icon-bullhorn icon-white"></i>';
			// }
		}
		else
		{
			echo '<i class="icon-bullhorn icon-white"></i>';
		}
	}
	
	function popupNotification() 
	{
		$uid = $this->session->userdata('uid');
		
		$this->db->where('notify',$uid);
		$this->db->where('status',1);
		$this->db->where('action','new users');
		$query = $this->db->get('flag');
		$row = $query->row_array();
		
		if($query->num_rows() > 0)
		{
			$id = $row['uid'];
			$this->db->where('uid',$id);
			$query_user = $this->db->get('users');
			$row_user = $query_user->row_array();
			 
			echo '<img id="'.$row['id'].'" class="close_popup_not" src="'.base_url('img/close_button.png').'" style="cursor:pointer;float: right;margin-top: -10px;margin-right: -12px;">';
			echo '<p class="popup_container">Your facebook friend <strong>'.$row_user['name'].'</strong> joined Bolooka</p>';
		}
	}
	
	function notificationItem_new()
	{
		echo '
			<ul class="media-list" style="margin-left: 0;">
				<li class="media" style="margin-bottom: 10px;">
					<a class="pull-left" href="#" style="margin-right: 10px;">
						<img src="'.base_url().'img/no-photo.jpg" class="media-object" width="50" height="50">
					</a>
					<div class="media-body" style="overflow: hidden;">
						<p>
							<strong>Media heading</strong>
							Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo.
							Cras purus odio, vestibulum in vulputate at, tempus viverra turpis.
						</p>		
					</div>
				</li>
			</ul>		
		';
	}
	
	function notificationItem()
	{
		echo '<li class="container-fluid" style="font-weight: bold; font-size: 11px;"><span>Notifications</span></li>';
		
		$uid = $this->session->userdata('uid');
	
		$wQuery = $this->db->query("SELECT * FROM flag WHERE notify='".$uid."' ORDER BY `time` DESC ");
		if($wQuery->num_rows() > 0)
		{
			foreach($wQuery->result_array() as $row2)
			{
				$status_flag = $row2['status'];
				$other_uid = $row2['uid'];
				$website_id = $row2['website_id'];
				$flag_id = $row2['id'];
				$action = $row2['action'];
				$time = $row2['time'];
				$msg_id = $row2['msg_id'];
				$return = $row2['callback'];
				$page_id = $row2['page_id'];
				$img_id = $row2['img_id'];
				$to_notify = $row2['notify'];
				$prod_id = $row2['prod_id'];
				
				/* time */
				$timeLine = $this->times_model->makeAgoPeriod($time);
				$timeLineNum = $this->times_model->makeAgoNum($time);
				
				$whole_time = $timeLineNum.' '.$timeLine;
				
				$prodQuery = $this->db->query("SELECT * FROM products WHERE id='".$prod_id."'");
				$prodRow = $prodQuery->row_array();
				
				$userQuery = $this->db->query("SELECT * FROM users WHERE uid='".$other_uid."' ");
				$userRow = $userQuery->row_array();
				
				if($website_id)
				{
					$webQuery = $this->db->query("SELECT * FROM websites WHERE id='".$website_id."' ");
					$webRow = $webQuery->row_array();
				}
				
				if(isset($webRow['user_id']))
				{
					$userQuery1 = $this->db->query("SELECT * FROM users WHERE uid='".$webRow['user_id']."' ");
					$userRow1 = $userQuery1->row_array();
				}
				
				if($page_id)
				{
					$pageQuery = $this->db->query("SELECT * FROM pages WHERE id='".$page_id."' ");
					$pageRow = $pageQuery->row_array();
				}
				$albumQuery = $this->db->query("SELECT * FROM gallery WHERE id='".$img_id."' ");
				$albumRow = $albumQuery->row_array();
				
				
				/* link to */
				$goTo = '';
				$comment = '';
				
				/* flag status */
				if($status_flag == 1)
				{
					$css = 'style="background: #EDEDED;"';
				}else
				{
					$css = '';
				}
				
				/* time ago */
				if($whole_time != '2 weeks ago')
				{
					$profile_pic = 'uploads/'.$userRow['uid'].'/'.$userRow['profile_picture'];
					if($this->photo_model->image_exists($profile_pic)) {
						$image = base_url() . $profile_pic;
					} else {
						$image = 'http://www.placehold.it/45x34/AAAAAA/EFEFEF&text=no+image';						
					}
					
					$button = '';
						/* type of action */
						if($action == 'follow')
						{
							$comment = ' followed your website ';
							$goTo = base_url().'manage/followers/'.$website_id;

						}
						else if($action == 'unfollow')
						{
							$goTo = base_url().'manage/followers/'.$website_id;
							$comment = ' unfollow your website ';
						}
						else if($action == 'blog')
						{
							$goTo = base_url().$webRow['url'].'/'.url_title($pageRow['name'],'-',true).'?msg_id='.$msg_id;

							if($return == 'reply') {
								$comment = ' also commented on his/her post ';
							} else if($return == 'reply to owner') {
								$comment = ' commented on your post.';
							} else {
								$comment = ' also commented on '.$userRow1['first_name']. '&rsquo;s post ';
							}
							$button = '';
						}
						else if($action == 'photo')
						{
							$goTo = base_url().$webRow['url'].'/'.url_title($pageRow['name'],'-',true).'?img_id='.$albumRow['id'];

							if($return == 'reply') {
								$comment = ' also commented on his/her photo ';
							} else if($return == 'reply to owner') {
								$comment = ' commented on your photo.';
							} else {
								$comment = ' also commented on '.$userRow1['first_name']. '&rsquo;s photo ';
							}
							
						}
						else if($action == 'approved')
						{
							$usermarketgroup_query = $this->db->query("SELECT * FROM web_marketgroup WHERE web_id = ".$website_id." ");
							$usermarketgroup_row = $usermarketgroup_query->row_array();
								
							if($usermarketgroup_query->num_rows() > 0) {
								$marketgroup_query = $this->db->query("SELECT * FROM marketgroup WHERE id=".$usermarketgroup_row['marketgroup_id']." ");
								$marketgroup_row = $marketgroup_query->row_array();
								
								$comment = 'Your website '.$webRow['url'].' has been accepted by '.$marketgroup_row['name'].' group';
								$image = base_url().'img/info_icon.png';
							}
						}
						else if($action == 'invite' || $action == '0')
						{
							/* get the marketplace name */
							$usermarketgroup_query = $this->db->query("SELECT * FROM web_marketgroup WHERE web_id = ".$website_id." ");
							
							if($usermarketgroup_query->row_array() > 0) {
								$usermarketgroup_row = $usermarketgroup_query->row_array();
								$marketgroup_query = $this->db->query("SELECT * FROM marketgroup WHERE id=".$usermarketgroup_row['marketgroup_id']." ");
								$marketgroup_row = $marketgroup_query->row_array();	
								
								$comment = 'Your website '.$webRow['url'].' was invited to join '.$marketgroup_row['name'].'.';
								$image = base_url().'img/info_icon.png';
								$button = '
										<div class="button_nav" style="text-align: right;margin-bottom: 10px;margin-right: 5px;">
											<div class="btn invite_accept" alt="'.$website_id.'"> accept </div>
											<div class="btn invite_decline" alt="'.$website_id.'"> decline </div>
										</div>							
								';
							}
						}
						else if($action == 'accepted')
						{
							$comment = 'Your website '.$webRow['url'].' has been accepted';
							$image = base_url().'img/info_icon.png';
							$button = '<div id="button_nav'.$flag_id.'" style="text-align: right;margin-right: 5px;"><span style="font-size: 12px;color: #DDD;">accepted</span></div>';
						}
						else if($action == 'decline')
						{
							/* get the marketplace name */
							$usermarketgroup_query = $this->db->query("SELECT * FROM web_marketgroup WHERE web_id = ".$website_id." ");
							$usermarketgroup_row = $usermarketgroup_query->row_array();
							
							$marketgroup_query = $this->db->query("SELECT * FROM marketgroup WHERE id=".$usermarketgroup_row['marketgroup_id']." ");
							$marketgroup_row = $marketgroup_query->row_array();
						
							$comment = 'Your website "'.$webRow['url'].'" was not accepted by "'.$marketgroup_row['name'].'".';
							$image = base_url().'img/info_icon.png';
							$button = '<div id="button_nav'.$flag_id.'" style="text-align: right;margin-right: 5px;"><span class="btn btn-small btn-danger disabled">denied</span></div>';
						}
						else if($action == 'request')
						{
							/* get the marketplace name */
							$usermarketgroup_query = $this->db->query("SELECT * FROM `web_marketgroup` WHERE `web_id` = ".$website_id." ");
							$usermarketgroup_row = $usermarketgroup_query->row_array();
								
							$marketgroup_query = $this->db->query("SELECT * FROM marketgroup WHERE id=".$usermarketgroup_row['marketgroup_id']." ");
							$marketgroup_row = $marketgroup_query->row_array();

							if(isset($webRow['site_name']))
							{
								$comment = 'submitted &ldquo;'.$webRow['site_name'].'&rdquo; website to join in &ldquo;'.$marketgroup_row['name'].'&rdquo; group.';
								$image = base_url().'img/info_icon.png';
								
								/* if website user rechoose marketgroup */
								
								$this->db->where('user_id', $this->session->userdata('uid'));
								$this->db->where('marketgroup_id', $usermarketgroup_row['marketgroup_id']);
								$rechooseQuery = $this->db->get('user_marketgroup');
								if($rechooseQuery->num_rows() > 0)
								{
									$goTo = base_url('manage/market/website');
								}
							} elseif(isset($webRow['url']))	{
								$comment = $webRow['url'].' website wants to join in '.$marketgroup_row['name'].' Group';
								$goTo = base_url('manage/market/website');
							} else {
								$comment = 'website has been deleted';
							}
						}
						else if($action == 'email')
						{
							$image = base_url().'img/info_icon.png';
							$comment = ' sent you an email.';
						}
						else if($action == 'product')
						{
							$goTo = base_url().$webRow['url'].'/'.$pageRow['name'].'/'.$prodRow['name'].'/'.$prod_id;
							if($return == 'reply') {
								$comment = ' also commented on his/her product. ';
							} else if($return == 'reply to owner') {
								$comment = ' commented on your product.';
							} else {
								$comment = ' also commented on '.$userRow1['first_name']. '&rsquo;s product. ';
							}
						}
						else if($action == 'new users')
						{
							$goTo = '#';
							$image = base_url().'img/info_icon.png';
							$comment = 'Your facebook friend '.$userRow['first_name'].' has joined in bolooka';
						}
						
					echo '
							<li class="media" alt="'.$flag_id.'" '.$css.'>
								<a  href="'.$goTo.'" alt="'.$flag_id.'" style="padding:5px;color: #747272;">
									<img class="media-object pull-left information_alert" src="'.$image.'" style="max-width: 66px; max-height: 66px;padding-right:5px;">
									<div class="media-body">
										<h6 style="margin:0;">
											'.(isset($userRow['name']) ? $userRow['name'] : "").'
										</h6>
										<small style="color: #747272;">'.$comment.'</small>
										<div class="muted" style="font-size: 11px;">'.$this->times_model->makeAgo($time).'</div>
										'.(isset($button) ? $button : "").'
									</div>
								</a>
							</li>
					';
							
				}
			}
		} else {
			echo '<li class="text-center" style="text-align: center;padding: 10px;font-family: Segoe UI Semibold;">No notification</li>';
		}
		
		// echo '</ul>';
		// echo '<div id="see_all" >See All</div>';
	}
	
	function alreadyRead()
	{
		$id = $this->session->userdata('uid');
		$this->db->query("UPDATE flag SET status = 0 WHERE notify='".$id."' ");
	}
	
	public function blog()
	{
		$this->load->view('manage_dashboard');
	}
	
	public function y()
	{
		$this->load->file('Yahoo_Oauth_YOS/yahoo_connect.php');
	}
	
	// function websiteView()
	// {
		// $data['content'] = $this->load->view('manage_website', '', true);
		// $this->load->view('manage_account', $data);
	// }
	
	function upload_banner()
	{
		$wid = $this->input->post('website_id');
		$dir = 'banner';
		if($_FILES)
		{
			$noBanner = $this->input->post('noBanner');
			
			if($noBanner == null)
			{
				$noBanner = 'no';
			}

			$uploaded = $this->photo_model->multi_upload();
			
			if(array_key_exists('success', $uploaded)){
				foreach($uploaded['success'] as $banner)
				{
					$background = $banner['file_name'];
					$new_banner_update_data = array('disable' => $noBanner,'images' => $background, 'website_id' => $wid);
					$this->db->insert($dir, $new_banner_update_data);
					
					$inserted_id = $this->db->insert_id();
					
					$this->db->where('website_id', $wid);
					$query = $this->db->get('banner');
					$row = $query->row_array();  
					
					echo '<li>';
					echo '<div style="height: 80px; width: 130px; position: relative; overflow: hidden;" class="thumbnail">';
					echo '<img src="'.base_url().'uploads/'.$background.'" style="" />';
					echo '<a id="'.$inserted_id.'" class="deleteImage" name="buttonB" ></a>';
					echo '</div>';
					echo '</li>';
				}
			}
		}
	}
	
    function update_banner()
	{
		$wid = $this->input->post('website_id');

		$queryCheckSett = $this->db->query("SELECT * FROM `banner_sett` WHERE `web_id` = '".$wid."'");
		if($queryCheckSett->num_rows() > 0)
		{
			$update_banner_sett = array(
				'speed' => $this->input->post('speed'),
				'enable' => $this->input->post('banner_enable')
			);
			$this->db->where('web_id', $wid);
			$this->db->update('banner_sett', $update_banner_sett);
		}
		else
		{
			$insert_banner_sett = array(
				'web_id' => $wid,
				'speed' => $this->input->post('speed'),
				'enable' => $this->input->post('banner_enable')
			);
			$this->db->insert('banner_sett', $insert_banner_sett);
		}
	}
	
	function delete_banner()
	{
		$banner_id = $this->input->post('bannerId');
		
		$this->db->where('id', $banner_id);
		$qbanner = $this->db->get('banner');
		$rbanner = $qbanner->result_array();
		
		foreach($rbanner as $banner) {
			$banner_dir = 'uploads';
			$banner_path = $banner_dir.'/'.$banner['images'];
			unlink($banner_path);
		}

		$this->db->where('id', $banner_id);
		$this->db->delete('banner');
	}

	function delete_banner_all()
	{
		$this->db->where('website_id', $this->input->post('websiteId'));
		$this->db->delete('banner');
	}

	function delete_logo()
	{
		$logoId = $this->input->post('logoId');

		$this->db->where('website_id', $logoId);
		$this->db->delete('logo');
	}
	
	function uploadwall() {
		$this->load->model('Photo_Model');
		$uploaded = $this->Photo_Model->upload();
	}
	
	function uploadImage()
	{
		if($_FILES['uploadProfile'])
		{
			$this->load->model('Photo_Model');
			$uploaded = $this->Photo_Model->upload();
			
			echo '<img src="../uploads/'.$uploaded['success'][0]['file_name'].'" style="border: thin ridge #999999;padding: 5px;width: 150px;height: 150px;">';
		}
	}
	
	function delete_picture()
	{
		$id = $this->input->post('picture_id');
		
		$this->db->query('UPDATE users SET profile_picture ="" WHERE uid="'.$id.'"');
	}
	
	function create_new_album()
	{
		$data['pid'] = $this->input->post('pid');
		$data['wid'] = $this->input->post('wid');
		$alname = $this->input->post('albumname');
		$aldesc = $this->input->post('albumdesc');
		$time = time();
		
		$inId = $this->gallery_model->insertGallery($data['wid'], $data['pid'], $alname, $aldesc);
		$data['albumId'] = $inId;
		$data['bago'] = 'bago';
		$this->load->view('viewalbum', $data);
	}
	
	function donothing()
	{
		$wid = $_POST['wids2'];
		$albumid = $_POST['albumids2'];
		$sesalbumid = $this->session->userdata('albumids2');
		
		if(!isset($sesalbumid))
		{
			$this->session->set_userdata('wids2', $wid);
			$this->session->set_userdata('albumids2', $albumid);
		}
		else
		{
			if($sesalbumid != $wid)
			{
				$this->session->unset_userdata('wids2');
				$this->session->unset_userdata('albumids2');
				$this->session->set_userdata('wids2', $wid);
				$this->session->set_userdata('albumids2', $albumid);
			}
		}
	}
	
	function viewimage()
	{
		$data['imgId'] = $this->input->post('imgId');
		$data['albumId'] = $this->input->post('albumId');
		$data['stagewid'] = $this->input->post('stagewid');
		$data['winhei'] = $this->input->post('winhei');
		$data['pid'] = $this->input->post('page_id');
		
		$this->load->view('viewimage',$data);
	}
	
	function checkpass($pass) {
		$this->load->library('encrypt');
		$this->load->database();

		$md_pass = $this->encrypt->encode($pass);
		
		$query = mysql_query("SELECT * FROM users WHERE password='$md_pass'");
		
		$result= mysql_num_rows($query);
		
		if($result > 0)
		{
			echo "Password match!";
		}
		else
		{
			echo "Password not match";
		}
	}
	
	function makeAgo($timestamp){
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
	
	function deletepost()
	{
		$postId = $this->input->post('postid');
		$this->wall_updates->delete_blog(null, null, $postId);
		$this->deletecomment($postId);
	}
	
	function deletecomment($postId)
	{
		/* delete by updating comments on this post */
		$arr_comments = array(
			'deleted' => time()
		);
		$this->db->where('msg_id_fk', $postId);
		$this->db->update('comments', $arr_comments);		
	}
	
	function contact_us() {
		if($this->input->post()) {
			
			// not needed // $user_email = $this->input->post('user_email');
			$fname = $this->input->post('fname');
			$email = $this->input->post('cust_email');
			$subj = $this->input->post('subject');
			$message = $this->input->post('message');
			// $wid = $this->input->post('wid');
			$pid = $this->input->post('pid');
			
			$this->db->where('id', $pid);
			$qpages = $this->db->get('pages');
			$rpages = $qpages->row_array();
			
			$wid = $rpages['website_id'];

			$this->db->where('id', $wid);
			$query = $this->db->get('websites');
			$rwebsite = $query->row_array();

			$user_id = $rwebsite['user_id'];

			/* get email cc */
				$this->db->where('page_id', $pid);
				$query_contact_us = $this->db->get('contact_us');
				if($query_contact_us->num_rows() > 0) {
					$row_contact = $query_contact_us->row_array();
					$user_email = $row_contact['email'];
				} else {
					$user_email = $rpages['email'];
				}
				
				if($user_email == '0' || trim($user_email) == null) {
					$this->db->where('uid', $user_id);
					$quser = $this->db->get('users');
					$ruser = $quser->row_array();
					$user_email = $ruser['email'];
				}
			/* */
			
			$this->db->where('website_id', $wid);
			$qlogo = $this->db->get('logo');
			$rlogo = $qlogo->row_array();
			
			$imagelogo = "";
			$img = 'uploads/'.$wid.'/'.$rlogo['image'];
			if($this->photo_model->image_exists($img)) {
				$imagelogo = base_url($img);
			} else {
				$img = 'uploads/'.$rlogo['image'];
				if($this->photo_model->image_exists($img)) {
					$imagelogo = base_url($img);
				}
			}
			
			if($this->session->userdata('uid')) {
				/* insert to flag */
				$data_insert_flag = array(
					'uid' => $this->session->userdata('uid'),
					'website_id' => $wid,
					'status' => 0,
					'notify' => $rwebsite['user_id'],
					'action' => 'email',
					'time' => time()
				);
				$this->db->insert('flag', $data_insert_flag);
				$insert_id = $this->db->insert_id();
			}
				
			$this->load->library('email');
			
					$config['mailtype'] = 'html';
					$config['charset'] = 'iso-8859-1';
					$config['wordwrap'] = TRUE;
					
					$this->email->initialize($config);
			
			$this->email->from($email, $fname);
			$this->email->to($user_email);
			
			if( isset($row_contact['emailcc']) ) {
				$this->email->cc($row_contact['emailcc']);
			}
			$this->email->bcc('info@bolooka.com');
			$this->email->subject($subj);
			
			/* check if affiliated to marketgroup */
				$this->db->where('web_id', $wid);
				$status_array = array('approved', 'accepted', '1');
				$this->db->where_in('status', $status_array);
				$qweb_marketgroup = $this->db->get('web_marketgroup');
				if($qweb_marketgroup->num_rows() > 0) {
					$rweb_marketgroup = $qweb_marketgroup->row_array();
					$this->db->where('id', $rweb_marketgroup['marketgroup_id']);
					$qmarketgroup = $this->db->get('marketgroup');
					$rmarketgroup = $qmarketgroup->row_array();
					
					$site = $rmarketgroup['name'];
					$url = base_url(url_title($rmarketgroup['url']));
				} else {
					$site = 'Bolooka';
					$url = '';
				}
			/* */
			
			
			$message2send = 
				$user_email.
				' via '.$site.': <br>'.
				'&ldquo;'. $message . ' &rdquo;<br>'.
				'<br>'.
				'<hr>'.
				'<a href="'.base_url(url_title($rwebsite['url'], '-', true)).'" title="'.$rwebsite['site_name'].'"> '.$rwebsite['site_name'].' </a> <br>'.
				'<br>'.
				'<a href="'.base_url($url).'"> '.$site.' </a>'
			;
			$this->email->message($message2send);
			
			echo $message2send;

			if($this->email->send())
			{
				/* for notification */
				if($this->session->userdata('uid')) {
					/* update to flag */
					$data_update_flag = array(
						'status' => 1
					);
					$this->db->where('id', $insert_id);
					$this->db->update('flag', $data_update_flag);
					echo $insert_id;
				} else {
					echo 0;
				}
			} else {
				/* echo $this->email->print_debugger(); */
			}
		} else {
			// redirect(base_url());
		}
	}

	function comValidation(){
		$com_name = $this->input->post('comName');
		
		$query = $this->db->query("SELECT * FROM websites WHERE site_name='$com_name'");
		
		if($query->num_rows() > 0)
		{
			echo 1;
		}
		else
		{
			echo 0;
		}
	}
	
	function namecheapapi(){
		$username = "noel1231";
		
		// Load the rest client spark
		$this->load->spark('restclient/2.1.0');

		// Load the library
		$this->load->library('rest');

		// Run some setup
		$this->rest->initialize(array('server' => 'http://twitter.com/'));

		// Pull in an array of tweets
		$tweets = $this->rest->get('statuses/user_timeline/'.$username.'.xml');
		
		echo $tweets;
	}
	
	
	
	function testers()
	{
		$this->load->view('testfb');;
	}
	
	function following()
	{		
		if($this->session->userdata('logged_in')) {
			$data['activemenu'] = 'following';
			$data['sidebar'] = $this->load->view('dashboard/sidebar', $data, true);
			$data['content'] = $this->load->view('follow', '', true);
			
			$data2home['bar_holder'] = $this->load->view('bar_holder', $data, true);
			$data2home['body'] = $this->load->view('manage_account', $data, true);
			$data2home['footer'] = '';
			
			$this->load->view('dashboard/template', $data2home);
		} else {
			redirect(base_url());
		}
	}
	
	function getsite()
	{
		$uid = $this->input->post('uid');
		$this->db->where('users', $uid);
		$this->db->order_by('id');
		$getwebfollow = $this->db->get('follow');
		if($getwebfollow->num_rows() > 0)
		{
			$resultwebfollow = $getwebfollow->result_array();
			foreach($getwebfollow->result_array() as $resultwebfollow) 
			{
				$this->db->where('id', $resultwebfollow['website_id']);
				$thequery = $this->db->get('websites');
				if($thequery->num_rows() > 0)
				{
					$resultweb = $thequery->row_array();

					$this->db->where('website_id', $resultwebfollow['website_id']);
					$queryLogo = $this->db->get('logo');
					if($queryLogo->num_rows() > 0)
					{
						$rows3 = $queryLogo->row_array();
						if($rows3['image']){
							$imageSrc = base_url().'uploads/'.str_replace('uploads/','',$rows3['image']);
						} else {
							$imageSrc = 'http://www.placehold.it/200x120/333333/ffffff&text=no+logo';
						}
							
						echo '
							<div class="thumbnail followed fol-hover" id="items-'.$resultwebfollow['website_id'].'">
								<img src="'.$imageSrc.'" style="max-height: 150px;">
								<div class="muted" style="background: none repeat scroll 0px 0px white; position: absolute; left: 0px; right: 0px; text-align: center; bottom: 4px; padding: 4px;">'.$resultweb['site_name'].'</div>
								<div class="trans-box btn-color">
									<a class="followinghover" id="uf" alt="'.$resultwebfollow['website_id'].'">
										<span class="btn folwing"> following </span>
									</a>
								</div>
							</div>
							';
					}
					else
					{
						$imageSrc = base_url().'img/Default Profile Picture.jpg';
						echo $thequery['site_name'].'<br/>';
					}
				}
			}
		}
		else
		{
			echo '<p style="text-align: center;">You have no followed.</p>';
		}
	}
	
	function getUnfollowedSite()
	{
		$uid = $this->input->post('uid');
		$i = 1;
		if($this->input->post('lastid')) {
			$lastid = $this->input->post('lastid');
			$this->db->where('id <', $lastid);
		}
			$this->db->where('deleted', 0);
			$this->db->where('marketplace', 1); 
			$this->db->order_by('id', 'desc');
			$thequery = $this->db->get('websites');
		
		if($thequery->num_rows() > 0)
		{
			foreach($thequery->result_array() as $rows)
			{
				$wid = $rows['id'];
				$site_name = $rows['site_name'];
				
				$getwebfollow = $this->db->query("SELECT * FROM follow WHERE users='$uid' AND website_id='$wid' ORDER BY id");
				if($getwebfollow->num_rows() == 0)
				{
					if($i <= 12){
						$queryLogo = $this->db->query("SELECT * FROM logo WHERE website_id ='$wid'");
						if($queryLogo->num_rows() > 0)
						{
							$rows3 = $queryLogo->row_array();
							if($rows3['image']){
								$imageSrc = base_url().'uploads/'.str_replace('uploads/','',$rows3['image']);
							} else {
								$imageSrc = 'http://www.placehold.it/200x120/333333/ffffff&text=no+logo';
							}
								$wala[] = 'meron';
						}
						else
						{
							$imageSrc = base_url().'img/no-photo.jpg';
						}
						
						echo '
							<div class="thumbnail follow_item fol-hover" id="items2-'.$wid.'" data-lastid="'.$wid.'">
								<img src="'.$imageSrc.'" style="max-height: 150px;">
								<div class="muted" style="background: none repeat scroll 0px 0px white; position: absolute; left: 0px; right: 0px; text-align: center; bottom: 4px; padding: 4px;">'.$site_name.'</div>
								<div class="trans-box btn-color">
									<a class="followinghover" id="ff" alt="'.$wid.'">
										<span class="btn folwing"> follow </span>
									</a>
								</div>
							</div>
							';
						$i++;
					}
				}
			}
		}
	}
	
	function follow()
	{
		if($this->input->post('website'))
		{
			$wbids = $_POST['website'];
			$usids = $_POST['userid'];
			
			
			$selectMuna = $this->db->query("SELECT * FROM follow WHERE users='$usids' AND website_id='$wbids'");
			$theResult = $selectMuna->num_rows();
			if($theResult == 0)
			{
				$insert_to_follow = array(
					'users' => $usids,
					'website_id' => $wbids,
					'time' => time()
				);
				$this->db->insert('follow', $insert_to_follow);
			}
		}
		
		if($this->input->post('siteurl'))
		{
			$uid = $this->input->post('uid');
			$website_id = $this->input->post('website_id');

			$selectMuna = $this->db->query("SELECT * FROM follow WHERE users='$uid' AND website_id='$website_id'");
			$theResult = $selectMuna->num_rows();
			if($theResult == 0)
			{
				$insert_to_follow = array(
					'users' => $uid,
					'website_id' => $website_id,
					'time' => time()
				);
				$this->db->insert('follow', $insert_to_follow);
				
				$queryUser = $this->db->query("SELECT * FROM websites WHERE id = '".$website_id."' ");
				$rowUser = $queryUser->row_array();
				
				$insert_to_flag = array(
					'uid' => $uid,
					'website_id' => $website_id,
					'status' => 1,
					'notify' => $rowUser['user_id'],
					'action' => 'follow',
					'time' => time()
				);
				$this->db->insert('flag', $insert_to_flag);
			}
			
		}
	}
	
	function unfollow()
	{
		if($this->input->post('website'))
		{
			$wb = $this->input->post('website');
			$userid = $this->input->post('userid');
			$delete_follow = array(
				'users' => $userid,
				'website_id' => $wb
			);
			$this->db->delete('follow', $delete_follow);
			
			/* if(!$query)
			{
				echo "not delete";
			}
			else
			{ */
				/* echo "deleted<br />";
				echo $userid."<br />"; */
				echo $wb;
			/* } */
		}

		if($this->input->post('siteurl'))
		{
			$uid = $this->input->post('uid');
			$website_id = $this->input->post('website_id');
			$times = time();
			$action = 'unfollow';
			
			$delete_follow = array(
				'users' => $uid,
				'website_id' => $website_id
			);
			$this->db->delete('follow', $delete_follow);
			
			/* for notification */
			// $queryUser = $this->db->query("SELECT * FROM websites WHERE id = '".$website_id."' ");
			// $rowUser = $queryUser->row_array();
			
			// $queryFlag = $this->db->query("INSERT INTO flag (uid, website_id, status, notify, action, time) VALUES('$uid','$website_id',1,'".$rowUser['user_id']."','".$action."','".$times."')");
		}	

	}
	
	function follows()
	{
		$this->load->view('groups');
	}
	
	function previewImg() {
		$valid_formats = array("jpg", "png", "gif", "bmp");
		if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
		{
			$name = $_FILES['imageBanner']['name'];
			$size = $_FILES['imageBanner']['size'];
			if(strlen($name))
				{
				$this->load->model('Photo_Model');
				$uploaded = $this->Photo_Model->upload();
				foreach($uploaded['success'] as $imgBanner) {
					
echo '
								<li style="position: relative; float: left;">
									<img height=50px src="'.base_url('uploads').'/'.$imgBanner['file_name'].'"  class="preview">
								</li>

';
				}
				}
				
			else
				echo "Please select image..!";
				
			exit;
		}
	}
	
	function banner_sequence() {
		foreach($_POST as $key=>$data)
		{
			if($key != 'websiteId' || $key != 'speed') {
				$queryUpdateBanner = "UPDATE `banner` SET `sequence`='".$data."' WHERE `id`='".$key."'";
				$this->db->query($queryUpdateBanner);
			}
		}
	}
	
	function product_search()
	{
		// $search_item =  $this->input->post('item');
		$search_item =  htmlentities($this->input->post('item'));
		$pid =  $this->input->post('pid');
		$wid =  $this->input->post('wid');
		$type = $this->input->post('type');
		// getpage_name
		$this->db->where('website_id', $wid);
		if($this->db->field_exists('page_seq', 'pages')) {
			$this->db->order_by('page_seq');
		} else {
			$this->db->order_by('order');
		}
		$queryPage = $this->db->get('pages');
		$resultPage = $queryPage->row_array();
		
		$this->db->where('id', $pid);
		$queryPageName = $this->db->get('pages');
		$resultPageName = $queryPageName->row_array();
		
	/* 	if($resultPage['type'] == 'catalogue')
		{ */
			$pgname = $resultPageName['name'];
		/* } */
		//getweb_url
		$this->db->where('id', $resultPage['website_id']);
		$this->db->where('deleted', 0);
		$queryWebs = $this->db->get('websites');
		$resultWebs = $queryWebs->row_array();
		$web_url = $resultWebs['url'];
		if($type == 'search_categ')
		{
			if($search_item == 'all')
			{
				$query1 = $this->db->query("SELECT * FROM products WHERE page_id='".$pid."' AND published = 1");
			}
			else
			{
				$query1 = $this->db->query("SELECT * FROM products WHERE page_id='".$pid."' AND category='".$search_item."' AND published = 1 ");
			}
			
			if($query1->num_rows() > 0)
			{
				foreach($query1->result_array() as $row1)
				{
					$primary = base_url('img/bolookalogo.png');

						if($this->db->field_exists('album_cover', 'albums')) {
							$primary = base_url().'uploads/'.$row1['album_cover'];
						} else {
							$primary = base_url().'uploads/'.$row1['primary'];
						}

					$name = $row1['name'];
					echo '
						<li>
							<a style="text-decoration:none;" href="'.base_url().$web_url.'/'.$pgname.'/'.str_replace(' ', '-',$name).'">
								<div class="box-white">
									<div class="box-white2">
										<img src="'.$primary.'"/>
									</div>	
									<div class="title-name" style="font-style:normal;">'.$name.'</div>
									<div class="pro-price" style="font-style:normal;"><span style="font-size: 9px;"></span> '.number_format($row1['price'],2).' PHP</div>
								</div>
							</a>
						</li>
					';				
				}
			}
		}
		else
		{
			$query = $this->db->query('SELECT * FROM products WHERE page_id="'.$pid.'" AND website_id="'.$wid.'" ');
			if($query->num_rows() > 0)
			{
				foreach($query->result_array() as $row)
				{
					$name = $row['name'];
					$pos = strpos($name, $search_item);
					
					if(strripos($name, $search_item) ===false)
					{
						/* DO NOTHING */
						$pair[] = 'wala';
					}
					else
					{
						$pair[] = 'meron';
						if($this->db->field_exists('album_cover', 'albums')) {
							$cover = 'uploads/'.$row['album_cover'];
						} else {
							$cover = 'uploads/'.$row['primary'];
						}
						$imgsrc = base_url($cover);
						echo '
							<li>
								<a style="text-decoration:none;" href="'.base_url().$web_url.'/'.$pgname.'/'.str_replace(' ', '-',$name).'">
									<div class="box-white">
										<div class="box-white2">
											<img src="'.$imgsrc.'"/>
										</div>	
										<div class="title-name" style="font-style:normal;">'.$name.'</div>
										<div class="pro-price" style="font-style:normal;"><span style="font-size: 9px;"></span> '.number_format($row['price'],2).' PHP</div>
									</div>
								</a>
						  </li>
						';
					}
				}
				if(in_array('meron', $pair))
				{
					unset($pair);
				}
				else
				{
					echo '<li><span style="font-size: 15px;">No result found!</span></li>';
				}
			}
		
		}
	}
	

	
	function approve_web()
	{
		$uid = $this->session->userdata('uid');
		$wid = $this->input->post('wid');
		
		/* get user id to notify */
		
		$this->db->where('id', $wid);
		$queryweb = $this->db->get('websites');
		
		if($queryweb->num_rows() > 0) {
			$data_update['status'] = 'approved';
			$this->db->where('web_id', $wid);
			$this->db->update('web_marketgroup', $data_update);

			$rowWeb = $queryweb->row_array();
			
			/* insert notification */
			
			// $data_insert_flag = array(
				// 'uid' => $uid,
				// 'website_id' => $wid,
				// 'status' => 1,
				// 'notify' => $rowWeb['user_id'],
				// 'action' => 'approved',
				// 'time' => $time
			// );
			
			// $this->db->insert('flag',$data_insert_flag);
		}
	}
	
	function on_invite()
	{
		if($this->session->userdata('logged_in') == 1) {
			$wid = $this->input->post('wid');
			$group_id = $this->input->post('group_id');
			$uid = $this->session->userdata('uid');
			$time_action = time();
			
			/* get user id to notify */
			
			$this->db->where('id',$wid);
			$this->db->where('deleted', 0);
			$queryweb = $this->db->get('websites');
			$webRow = $queryweb->row_array();
			
			/* insert notification */
			
			$data_insert_flag = array(
				'uid' => $uid,
				'website_id' => $wid,
				'status' => 1,
				'notify' => $webRow['user_id'],
				'action' => 'invite',
				'time' => $time_action
			);
			$this->db->insert('flag', $data_insert_flag);
			
			// /* check if website id has already saved */
			
			// $this->db->where('web_id',$wid);
			// $this->db->where('marketgroup_id',$group_id); 
			// $query_check = $this->db->get('web_marketgroup');

			// if($query_check->num_rows() > 0)
			// {
				// /* update to web_marketgroup */
				// $data_insert = array(
				   // 'web_id' => $wid ,
				   // 'marketgroup_id' => $group_id,
				   // 'status' => 'invite',
				   // 'date_added' => $time_action
				// );
				
				// $this->db->where('web_id',$wid);
				// $this->db->update('web_marketgroup', $data_insert);
			// }else
			// {
				/* insert to web_marketgroup */
				$data_insert = array(
				   'web_id' => $wid ,
				   'marketgroup_id' => $group_id,
				   'status' => 'invite',
				   'date_added' => $time_action
				);
				
				$this->db->insert('web_marketgroup', $data_insert);
			// }
			echo 'success';
		}
	}
	
	function remove_web() /* marketgroup */
	{
		$wid = $this->input->post('wid');
		
		$this->db->where('web_id', $wid);
		$this->db->delete('web_marketgroup');

		$this->db->where('website_id', $wid);
		$this->db->delete('flag');
		
		$data_update_website['marketgroup'] = NULL;
		$this->db->where('id', $wid);
		$this->db->update('websites', $data_update_website);
	}
	
	function search_web()
	{
		echo '
		<tr>
			<th class="hidden-phone hidden-tablet">Logo</th>
			<th>Company Name</th>
			<th class="hidden-phone hidden-tablet">Type of Business</th>
			<th class="hidden-phone hidden-tablet">Country</th>
			<th class="hidden-phone hidden-tablet">Business Description</th>
			<th class="hidden-phone hidden-tablet">Site Owner</th>
			<th>&nbsp;</th>
		</tr>
		';
	
		$search_by = $this->input->post('search_by');
		$group_id = $this->input->post('group_id');
		$content = $this->input->post('content');
		
		/* user role */
		$queryRole = $this->db->query("SELECT * FROM user_marketgroup WHERE user_id = '".$this->session->userdata('uid')."' AND marketgroup_id = '".$group_id."' ");
		$rowRole = $queryRole->row_array();
		
		if($content == 'invite')
		{
			$queryWebgroup = "SELECT `web_id` FROM `web_marketgroup` WHERE `marketgroup_id` IS NOT NULL AND status <> 'decline' ";
			$query = $this->db->query("SELECT * FROM websites WHERE id NOT IN (".$queryWebgroup.") ORDER BY id DESC");
		}else
		{
			$queryWebgroup = "SELECT `web_id` FROM `web_marketgroup` WHERE `marketgroup_id` = '".$group_id."' AND status <> 'rejected' ";
			$query = $this->db->query("SELECT * FROM websites WHERE id IN (".$queryWebgroup.") AND site_name LIKE '%".$search_by."%' ORDER BY id DESC");
		}
		if($query->num_rows() > 0)
		{
			
			foreach($query->result_array() as $row)
			{
				$logo_pic = $row['logo'];
				$name = $row['site_name'];
				
				if($name)
				{
					$site_name = $row['site_name'];
				}
				else
				{
					$site_name = $row['url'];
				}
				$search_items = $row['url'].'-'.$row['site_name'];
				
				if($logo_pic)
				{
					$image = base_url("uploads/".$logo_pic);
				}else
				{
					$image = base_url("img/Default Profile Picture.jpg");
				}
			
				$query_business = $this->db->query("SELECT * FROM business_categories WHERE Category = '".$row['business_type']."' ");
				$row_buss = $query_business->row_array();
				
				$query_webStatus = $this->db->query("SELECT * FROM `web_marketgroup` WHERE `marketgroup_id` = '".$group_id."' AND web_id = '".$row['id']."' ");
				$rowStatus = $query_webStatus->row_array();
				
				$query_user = $this->db->query("SELECT * FROM users WHERE uid = '".$row['user_id']."' ");
				$row_user = $query_user->row_array();
				
				if($row_user['profile_picture'])
				{
					$prof_pic = base_url('uploads/'.$row_user['profile_picture']);
				}else
				{
					$prof_pic = base_url("img/Default Profile Picture.jpg");
				}
				
				$posted = strpos($site_name, $search_by);
			
				if(strripos($search_items, $search_by) ===false)
				{
					/* DO NOTHING */
					$paire[] = 'wala';
				}
				else
				{
					$paire[] = 'meron';
						echo '
					<tr class="asd" id="'.$row['id'].'">
						<td class="hidden-phone hidden-tablet">
							<img src="'.$image.'" style="height: 32px; width: 32px; border: 1px solid;" />
						</td>
						<td>
							<div style="text-overflow: ellipsis;overflow: hidden;white-space: nowrap;max-width: 78px;">'.$site_name.'</div>
						</td>
						<td class="hidden-phone hidden-tablet">
							<div style="width: 150px;text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">'.$row_buss['Description'].'</div>
						</td>
						<td class="hidden-phone hidden-tablet">
							<div style="max-width: 100px;">'.$row['country'].'</div>
						</td>
						
						<td class="hidden-phone hidden-tablet">
							<div style="width:100px;text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">'.$row['description'].'</div>
						</td>
						<td class="hidden-phone hidden-tablet">
							<div>
								<img src="'.$prof_pic.'" style="width: 25px;height: 25px;border: 1px solid;vertical-align: top;" />
								<div style="width:80px;text-overflow: ellipsis;">'.$row_user['name'].'</div>
							</div>
						</td>
					';
					if($content == 'invite')
					{
						echo '
							<td>
								<div style="width: 122px;">
							';
						if(isset($rowStatus['status']))
						{
							if($rowStatus['status'] == 'decline')
							{
								echo '
										<button class="btn" style="background: #EE0707;color: white;">denied</button>
									';
							}	
						}
						/* show this button if user role is not view */
						if($rowRole['role'] != 3)
						{
						echo '
									<button id="notify'.$row['id'].'" class="btn on_notify" alt="'.$row['id'].'">notify</button>
							';
						}	
						echo '
								</div>
							</td>
						</tr>
						';
					}else
					{
						echo '
							<td>
							';
						if($rowStatus['status'] == 'approved')
						{
							echo '
										<button class="btn" style="background: green;color: white;">approved</button>
								';
						}else if($rowStatus['status'] == 'invite')
						{
							echo '
										<button class="btn" style="background: #EE0707;color: white;">pending</button>
								';
						}else if($rowStatus['status'] == 'accepted')
						{
							echo '
										<button class="btn" style="background: green;color: white;">accepted</button>
								';
						}else if($rowStatus['status'] == 'decline')
						{
							echo '
										<button class="btn" style="background: #EE0707;color: white;">denied</button>
								';
						}else
						{
							/* show this button if user role is not view */
							if($rowRole['role'] != 3)
							{
							echo '
										<button id="on_aprrove" class="btn">approve</button>
								';
							}
						}
							/* show this button if user role is not view */
							if($rowRole['role'] != 3)
							{
							echo '
										<button id="on_reject" class="btn">reject</button>
								</td>
							</tr>
							';	
							}
					}
					
				}
			}//foreach end
				if(in_array('meron', $paire))
				{
					unset($paire);
				}
				else
				{
					echo '<td colspan="8">No result found!3</td>';
				}
		}
		else
		{
			echo '<td colspan="8">No result found!2</td>';
		}
	}
	
	function filter_web()
	{
	
		echo '
		<tr>
			<th class="hidden-phone hidden-tablet">Logo</th>
			<th>Company Name</th>
			<th class="hidden-phone hidden-tablet">Type of Business</th>
			<th class="hidden-phone hidden-tablet">Country</th>
			<th class="hidden-phone hidden-tablet">Business Description</th>
			<th class="hidden-phone hidden-tablet">Site Owner</th>
			<th>&nbsp;</th>
		</tr>
		';
		
		$filter_by = $this->input->post('filter_by');
		$group_id = $this->input->post('group_id');
		$content = $this->input->post('content');
		
		/* user role */
		$queryRole = $this->db->query("SELECT * FROM user_marketgroup WHERE user_id = '".$this->session->userdata('uid')."' AND marketgroup_id = '".$group_id."' ");
		$rowRole = $queryRole->row_array();
		
		if($content == 'invite')
		{
			$queryWebgroup = "SELECT `web_id` FROM `web_marketgroup` WHERE `marketgroup_id` IS NOT NULL AND status <> 'decline' ";
			$query = $this->db->query("SELECT * FROM websites WHERE id NOT IN (".$queryWebgroup.") ORDER BY ".$filter_by." ASC");
		}
		else
		{
			$queryWebgroup = "SELECT `web_id` FROM `web_marketgroup` WHERE `marketgroup_id` = '".$group_id."' AND status <> 'rejected' ";
			$query = $this->db->query("SELECT * FROM websites WHERE id IN (".$queryWebgroup.") ORDER BY ".$filter_by." ASC");
		}
		
		if($query->num_rows() > 0)
		{
			foreach($query->result_array() as $row)
			{
			
				$logo_pic = $row['logo'];
				$name = $row['site_name'];
				
				if($name)
				{
					$site_name = $row['site_name'];
				}
				else
				{
					$site_name = '';
				}
				
				if($logo_pic)
				{
					$image = base_url("uploads/".$logo_pic);
				}else
				{
					$image = base_url("img/Default Profile Picture.jpg");
				}
				
				$query_business = $this->db->query("SELECT * FROM business_categories WHERE Category = '".$row['business_type']."' ");
				$row_buss = $query_business->row_array();
				
				$query_webStatus = $this->db->query("SELECT * FROM `web_marketgroup` WHERE `marketgroup_id` = '".$group_id."' AND web_id = '".$row['id']."' ");
				$rowStatus = $query_webStatus->row_array();
				if(isset($row_buss['Description']))
				{
					$business_description = $row_buss['Description'];
				}else
				{
					$business_description = '';
				}
				
				$query_user = $this->db->query("SELECT * FROM users WHERE uid = '".$row['user_id']."' ");
				$row_user = $query_user->row_array();
				
				if($row_user['profile_picture'])
				{
					$prof_pic = base_url('uploads/'.$row_user['profile_picture']);
				}else
				{
					$prof_pic = base_url("img/Default Profile Picture.jpg");
				}
				
				echo '
					<tr class="asd" id="'.$row['id'].'">
						<td class="hidden-phone hidden-tablet">
							<img src="'.$image.'" style="height: 32px; width: 32px; border: 1px solid;" />
						</td>
						<td>
							<div style="text-overflow: ellipsis;overflow: hidden;white-space: nowrap;max-width: 78px;">'.$site_name.'</div>
						</td>
						<td class="hidden-phone hidden-tablet">
							<div style="width: 150px;text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">'.$business_description.'</div>
						</td>
						<td class="hidden-phone hidden-tablet">
							<div style="max-width: 100px;">'.$row['country'].'</div>
						</td>
						
						<td class="hidden-phone hidden-tablet">
							<div style="width:100px;text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">'.$row['description'].'</div>
						</td>
						<td class="hidden-phone hidden-tablet">
							<div>
								<img src="'.$prof_pic.'" style="width: 25px;height: 25px;border: 1px solid;vertical-align: top;" />
								<div style="width:80px;text-overflow: ellipsis;">'.$row_user['name'].'</div>
							</div>
						</td>
				';
				if($content == 'invite')
				{
					echo '
						<td>
							<div style="width: 122px;">
						';
					if(isset($rowStatus['status']))
					{
						if($rowStatus['status'] == 'decline')
						{
							echo '
									<button class="btn" style="background: #EE0707;color: white;">denied</button>
								';
						}
					
					}
					if($rowRole['role'] != 3)
					{
					echo '
								<button id="notify'.$row['id'].'" class="btn on_notify" alt="'.$row['id'].'">notify</button>
						';
					}	
					echo '
							</div>
						</td>
					</tr>
					';
				}else
				{
					echo '
						<td>
						';
					if($rowStatus['status'] == 'approved')
					{
						echo '
									<button class="btn" style="background: green;color: white;">approved</button>
							';
					}else if($rowStatus['status'] == 'invite')
					{
						echo '
									<button class="btn" style="background: #EE0707;color: white;">pending</button>
							';
					}else if($rowStatus['status'] == 'accepted')
					{
						echo '
									<button class="btn" style="background: green;color: white;">accepted</button>
							';
					}else
					{
						if($rowRole['role'] != 3)
						{
						echo '
									<button id="on_aprrove" class="btn" >approve</button>
							';
						}
					}
					
					if($rowRole['role'] != 3)
					{
						echo '
									<button id="on_reject" class="btn" >reject</button>
							</td>
						</tr>
						';	
					}
				}
			}
		}
	}
	
	function on_accept()
	{
		$wid = $this->input->post('web_id');
		
		$data_update_web_market['status'] = 'accepted';
		$this->db->where('web_id', $wid);
		$this->db->update('web_marketgroup',$data_update_web_market);
		
		/* for flag notification */
		$data_update_flag['action'] = 'accepted';
		$this->db->where('website_id',$wid);
		$this->db->where('action','invite');
		$this->db->update('flag', $data_update_flag);
		
		echo 'accepted';
	}	
	
	function on_decline()
	{
		$wid = $this->input->post('web_id');
		
		$data_update_web_market['status'] = 'decline';
		$this->db->where('web_id',$wid);
		$this->db->update('web_marketgroup',$data_update_web_market);
		
		/* for flag notification */
		$data_update_flag['action'] = 'decline';
		$this->db->where('website_id',$wid);
		$this->db->where('action','invite');
		$this->db->update('flag', $data_update_flag);
		
		echo 'declined';
	}
	
	function add_role()
	{
		$key_search = $this->input->post('item');
		$gid = $this->input->post('group_id');
		
		$query = $this->db->query("SELECT * FROM `users` WHERE (name LIKE '%".$key_search."%' OR email LIKE '%".$key_search."%') AND `uid` NOT IN (SELECT `user_id` FROM `user_marketgroup`)");
		
		echo '
			<thead>
				<tr>
					<th>Name</th>
					<th>Email</th>
					<th>Role</th>
					<th>Date Registered</th>
					<th></th>
				</tr>
			</thead>
		';
		
		if($query->num_rows() > 0)
		{
			echo '
			<tbody >
			';
			foreach($query->result_array() as $row)
			{
				echo '
					<tr>
						<td>'.$row['name'].'</td>
						<td>'.$row['email'].'</td>
						<td>
							<select class="role_type">
								<option value="1">Administrator</option>
								<option value="2">Moderator</option>
								<option value="3" selected>Member</option>
							</select>
						</td>
						<td>'.date('F j, Y g:i a', $row['date_registered']).'</td>
						<td style="padding-right:0px;"><button class="btn on_add add'.$row['uid'].'" alt="'.$row['uid'].'">add</button></td>
						<td>&nbsp;</td>
					</tr>
				';
			}
			echo '
			</tbody>
			';
		}
		else
		{
			echo 'No data to display.';
		}
	}
	
	function add_user_role()
	{
		$uid = $this->input->post('uid');
		$type = $this->input->post('type');
		$gid = $this->input->post('group_id');
		
		$this->db->where('user_id',$uid);
		$query = $this->db->get('user_marketgroup');
		if($query->num_rows() > 0)
		{
			echo 'This is already in group';
			
		}else
		{
			$data_insert_user_marketgroup = array(
				'user_id' => $uid,
				'marketgroup_id' => $gid,
				'role' => $type,
				'date_added' => time()
			);
			
			$this->db->insert('user_marketgroup',$data_insert_user_marketgroup);
			
			echo 'This user has been added';
		}
		
	}
	
	function delete_role()
	{
		$uid = $this->input->post('uid');
		
		$query = $this->db->query("SELECT * FROM user_marketgroup WHERE user_id = '".$uid."' ");
		if($query->num_rows() > 0)
		{
			$this->db->where('user_id',$uid);
			$this->db->delete('user_marketgroup');
		}
		
	}
	
	function edit_role()
	{
		$uid = $this->input->post('uid');
		$role_type = $this->input->post('role_type');
		$gid = $this->input->post('group_id');
		
		$data_update_user_marketgroup['role'] = $role_type;
		
		$this->db->where('user_id',$uid);
		$this->db->update('user_marketgroup',$data_update_user_marketgroup);
		
		if($role_type == 1)
		{
			echo 'Administrator';
		}else if($role_type == 2)
		{
			echo 'Moderator';
		}else if($role_type == 3)
		{
			echo 'Member';
		}
	}
	
	function store() {
		$social = $this->input->post('social');
		for($x = 0; $x < 7; $x++)
		{
			if(in_array($x,$social))
			{
				echo $x . ' kita<br />';
			}
		}
	}
	
	function prodImage_seq() {
		$image_name = $this->input->post('img_name');
		$seq = $this->input->post('seq_id');
		
		/* this is to make it an array */
		$prod_name = explode(',',$image_name);
		$seq_prod = explode(',',$seq);
		
		for($x=0; $x < count($seq_prod); $x++) 
		{
			$data_product_images = array(
				'seq' => $seq_prod[$x]
			);
			$this->db->where('images',$prod_name[$x]);
			$this->db->update('products_images',$data_product_images);
		}
	}
	
	function fb_bolooka_list()
	{
		$fb_id = $this->input->post('fb_id');
		$fb_name = $this->input->post('fb_name');
		
		/* this is to make it an array */
		$id = explode(',',$fb_id);
		$name = explode(',',$fb_name);
		
		/* bolooka friend group */
		echo '<div class="span6">';
		echo  '<h4>Bolooka Friends</h4>';
		echo '	<ul class="fbimgbolooka" style="margin:0;">';
		for($x=0; $x < count($id); $x++)
		{
			
			$this->db->where('fb_id_fk',$id[$x]);
			$query = $this->db->get('users');
			$row = $query->row_array();
			if($query->num_rows() > 0)
			{
				if($row['fb_id_fk'] == $id[$x])
				{
					echo '
						<li style="text-align: center;padding: 0 5px 5px 0;box-shadow: 1px 3px 5px -3px rgba(0,0,0,0.25);">
							<div class="row-fluid">
								<div class="span12">
									<div class="row-fluid">
										<div class="span2">
											<img src="http://graph.facebook.com/'.$id[$x].'/picture?type=square" />
										</div>
										<div class="span5">
											<p class="invidual_list">'.$name[$x].'</p>
										</div>
									</div>
								</div>
							</div>
						</li>
					';
				}
			}			
		}
		echo '</ul>';
		echo '</div>'; 
		
		/* facebook friends group not in bolooka list */
		echo '<div class="span6">';
		echo  '<h4>Invite Friends</h4>';
		echo '	<ul class="fbimginvite" style="margin:0;">';
		for($x=0; $x < count($id); $x++)
		{
			
			$this->db->where('fb_id_fk',$id[$x]);
			$query = $this->db->get('users');
			$row = $query->row_array();
			if($query->num_rows() == 0)
			{
				echo '
					<li style="text-align: center;padding: 0 5px 5px 0;box-shadow: 1px 3px 5px -3px rgba(0,0,0,0.25);">
						<div class="row-fluid">
							<div class="span12">
								<div class="row-fluid">
									<div class="span2" style="text-align:left;">
										<img src="http://graph.facebook.com/'.$id[$x].'/picture?type=square" />
									</div>
									<div class="span4" style="text-align:center;">
										<p class="invidual_list">'.$name[$x].'</p>
									</div>
									<div class="span3" style="text-align:center;line-height: 40px;">
										<button class="btn button_invite" alt="'.$id[$x].'">Invite</button>
									</div>
								</div>
							</div>
						</div>
					</li>
				';
			}			
		}
		echo '</ul>';
		echo '</div>';
		
	}
	
	function viewalbum()
	{
		$data['wid'] = $this->input->post('wid');
		$data['pid'] = $this->input->post('pid');

		$data['query'] = $this->gallery_model->getAlbums(0, $data['wid']);

		// $getquery = $this->gallery_model->getAlbums(0, $wid);
		// $chkquery = $this->gallery_model->getAlbums(0, $wid, $pid);
		// if($chkquery->num_rows() != $getquery->num_rows()) {

			// foreach($getquery->result_array() as $thedata){
				// $chek_value = false == $thedata['page_id'];
				// if($chek_value){
					// $updata = array(
						// "page_id" => $pid
					// );
					// $this->db->where('id',$thedata['id']);
					// $this->db->update('albums',$updata);
				// }
			// }
		// }
		$this->load->view('viewalbum', $data);
	}
	
	function viewpics() {
		$data = $this->input->post();
		$this->load->view('edit/pages/albumpage', $data);
	}
	
	
	function viewalbumsecond()
	{
		$data['wid'] = $_POST['wid'];
		$lastId = $_POST['lastId'];
		
		$limitQuery = "SELECT * FROM `albums` WHERE web_id='".$data['wid']."' AND `id` < '$lastId' ORDER BY `id` DESC LIMIT 4";
		$data['thequery'] = "SELECT * FROM `albums` WHERE web_id='".$data['wid']."' AND `id` < '$lastId' ORDER BY `id` DESC LIMIT 4";
		$queryalbum = $this->db->query($limitQuery);
		if($queryalbum->num_rows() > 0)
		{
			$this->load->view('viewalbum', $data);
		}
		else
		{
			echo 'lana';
		}
	}
	
	function create_new_album2()
	{
		$data['wid'] = $this->input->post('wid');
		$data['pid'] = $this->input->post('pid');
		$data['albumname'] = $this->input->post('albumname');
		$data['albumdesc'] = $this->input->post('albumdesc');

		$data['albumid'] = $this->gallery_model->insertAlbums($data['wid'], $data['pid'], $this->input->post('albumname'), $this->input->post('albumdesc'));
		$data['bago'] = 'bago';
		// $this->session->set_userdata('myalbumid', $data['albumId']);
		// $this->session->set_userdata('widsite', $data['wid']);
		// echo $this->session->userdata('myalbumid');
		
		$this->load->view('edit/pages/albumpage', $data);
	}
	
	function setalbumsession()
	{
		$data['albumid'] = $this->input->post('albumid');
		$data['wid'] = $this->input->post('wid');
		
		// $data['pid'] = $pid;
		// $this->load->view('edit/pages/albumpage', $data);

		// $this->session->set_userdata('myalbumid', $data['albumid']);
		// $this->session->set_userdata('widsite', $data['wid']);
	}
	
	function unsetalbumsession()
	{
		// $this->session->unset_userdata('myalbumid');
		// $this->session->unset_userdata('widsite');
	}
	
	function deleteDir($dirPath){
		if (! is_dir($dirPath)) {
        throw new InvalidArgumentException("$dirPath must be a directory");
		}
		if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
			$dirPath .= '/';
		}
		$files = glob($dirPath . '*', GLOB_MARK);
		foreach ($files as $file) {
			if (is_dir($file)) {
				$this->deleteDir($file);
			} else {
				unlink($file);
			}
		}
		rmdir($dirPath);
	}

	function deletealbum()
	{
		$wid = $_POST['wid'];
		$albumid = $_POST['albumid'];
		$pid = $_POST['pid'];
		
		$getFromMessage = $this->wall_updates->select_album_blog($wid, $albumid);

		if($getFromMessage->num_rows() > 0)
		{
			foreach($getFromMessage->result_array() as $mesrow)
			{
				$msgid = $mesrow['msg_id'];
				
				$this->db->query("DELETE FROM comments WHERE msg_id_fk='$msgid'");
			}
			$this->db->query("DELETE FROM gallery WHERE albums='$albumid' AND web_id='$wid'");
			$this->db->query("DELETE FROM albums WHERE id='$albumid' LIMIT 1");

			$this->wall_updates->delete_blog(0, $albumid);
		}
		else
		{
			$this->db->query("DELETE FROM gallery WHERE albums='$albumid' AND web_id='$wid'");
			$this->db->query("DELETE FROM albums WHERE id='$albumid' LIMIT 1");
			
			$this->wall_updates->delete_blog(0, $albumid);
		}
		$dirPath = 'files/'.$albumid;
		$this->deleteDir($dirPath);
		$thequery = "SELECT * FROM albums WHERE web_id='".$wid."' AND page_id='".$pid."' ORDER BY id DESC LIMIT 4";
		$chkquery = $this->db->query($thequery);
		echo $chkquery->num_rows();
	}
	
	function updatealbum()
	{
		$albumid = $_POST['albumid'];
		$desirename = $_POST['desirename'];
		$desiredesc = $_POST['desiredesc'];
		
		$this->db->query("UPDATE `albums` SET `album_name`='$desirename', `discrip`='$desiredesc' WHERE `id`='$albumid'");
	}
	
	function recordalbumseq()
	{
		$sequence = $this->input->post('sequence');
		$albumid = $this->input->post('albumid');
		foreach($sequence as $order => $imageid)
		{
			$update_array = array(
				'sortdata' => $order,
				'image' => $order
			);
			$this->db->where('albums', $albumid);
			$this->db->where('id', $imageid);
			$this->db->update('gallery', $update_array);
			// echo $this->db->last_query();
		}
	}
	
	function upalbumname()
	{
		$albumid = $_POST['albumid'];
		$album_name = $_POST['album_name'];
		$albmdesc = $_POST['albmdesc'];
		$this->db->query("UPDATE albums SET album_name='$album_name', discrip='$albmdesc' WHERE id='$albumid'");
	}
	
	// function post_comments() 
	// {
		// $msg_id = $this->input->post('msg_id');
		// $this->db->where('msg_id_fk',$msg_id);
		// $query_comments = $this->db->get('comments');
		
		// if($query_comments->num_rows() > 0)
		// {
			// echo '<ul class="media-list">';
			// foreach($query_comments->result_array() as $row)
			// {
				// $com_id = $row['com_id'];
				// $comment = $row['comment'];
				// $msg_id_fk = $row['msg_id_fk'];
				// $uid_fk = $row['uid_fk'];
				// $created = $row['created'];
				
				// echo '
				// <li class="media">
					// <a class="pull-left" href="#">
						// <img class="media-object" src="'.base_url('img/no-photo.jpg').'" style="width: 50px;max-height:60px;">
					// </a>
					// <div class="media-body">
						// <p>'.$comment.'</p>
					// </div>
					// <small class="pull-right">'.$this->times_model->makeAgo($created).'</small>
				// </li>
				// <hr/>
				// ';
			// }
			// echo '
				// </ul>
			// ';
		// }else
		// {
			// echo 'No comments...';
		// }
	// }
	
	
	/****** for ADMIN ******/
		function moderate($item=null) {
			if($item == 'prod_section') {
				$prodID = $this->input->get_post('prodID');
				$prodSection = $this->input->get_post('prodSection');
				
				$update_prod['section'] = json_encode($prodSection);
				
				$this->db->where('id', $prodID);
				$this->db->update('products', $update_prod);
				
				echo $prodID.'-'.$update_prod['section'];
			}
			
			if($item == 'product') {
				$prodID = $this->input->post('prodID');
				$value = $this->input->post('value');
				
				$update_prod['marketplace'] = $value;
				if($value == 0) {
					$update_prod['product_posted'] = 0;
				} else {
					$update_prod['product_posted'] = time();
				}
			
				$this->db->where('id', $prodID);
				$this->db->update('products', $update_prod);
			}

			if($item == 'site') {
				$webID = $this->input->post('webID');
				$value = $this->input->post('value');
				
				$update_web['marketplace'] = $value;
			
				$this->db->where('id', $webID);
				$this->db->update('websites', $update_web);			
			}
		}

	function fbtest() {
		$this->load->file('api/facebook-php-sdk-master/examples/with_js_sdk.php');
	}
	
	function msntest() {
		$this->load->file('api/liveservices-LiveSDK-2b505a1/Samples/PHP/OauthSample/callback.php');
	}
	
	function yahootest() {
		print_r($this->uri->uri_string());
		// $this->load->file('api/yahoo-yos-social-php5-d34814f/examples/yap/profiles.php');
	}
	
	function session() {
		$newdata = array(
						   'uid' => 'noel',
						   'username' => 'haha',
						   'logged_in' => TRUE
					   );

		$this->session->set_userdata($newdata);
		
		$this->db->where('session_id', $this->session->userdata('session_id'));
		$query = $this->db->get('ci_sessions');
		if($query->num_rows == 1)
		{
			$result = $query->row_array();
			$getdata = unserialize($result['user_data']);
			echo $getdata['uid'];
		}
		
		// print_r($this->session->all_userdata());

	}
	
	
	function deleteAlbumPhoto(){
		$image_filename = $_POST['image_filename'];
		$image_ids = $_POST['image_ids'];
		if($image_ids != 'undefined') {
			$this->db->where('id',$image_ids);
			$getquery = $this->db->get('gallery');
			$result = $getquery->row_array();
			$albumid = $result['albums'];
			$files = 'files/'.$albumid.'/';
			$filesm = $files.'medium/';
			$filesb = $files.'thumbnail/';
			unlink($files.$image_filename);
			unlink($filesm.$image_filename);
			unlink($filesb.$image_filename);
			$this->db->query("DELETE FROM gallery WHERE `id`='$image_ids'");
		}
		
	}
	
	function imagecomment(){
		$data['imgid'] = $this->input->post('image');
			$albumid = $this->input->post('albumid');
			$arr_key = $this->input->post('arr_key');
			$imagesDir = "files/".$albumid.'/medium/';
			$images = glob($imagesDir.'*.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF}', GLOB_BRACE);
			$imgcount = count($images);
			$nxtimg = $arr_key + 1;
			$i = 1;
		if($this->input->post('nxtimg') == 'nxt'){
			if($imgcount == $nxtimg){
				$nxtimg = 0;
			}
		}elseif($this->input->post('nxtimg') == 'prv'){
			if($arr_key == 0){
				$nxtimg = $imgcount - 1;
			}
		}
		if(array_key_exists($nxtimg,$images)){
			foreach($images as $key => $image){
				if($key == $nxtimg){
					$strimage = str_replace($imagesDir,'',$image);

					$this->db->where('image_name',$strimage);
					$this->db->where('albums',$albumid);
					$getimgid = $this->db->get('gallery');
					$result = $getimgid->row_array();
					$data['imgid'] = $result['id'];
				}
			}				
		}
		$this->load->view('templates/types/comment', $data);
	}

	function imgcoment(){
		$comentmsg = $_POST['comentmsg'];
		$imgid = $_POST['imgid'];
		$userdata =  $this->session->userdata('uid');
		$time = time();
		$this->db->query("INSERT INTO `comments` (comment, msg_id_fk, uid_fk, created) VALUES('$comentmsg','$imgid','$userdata','$time')");
		$thisid = $this->db->insert_id();
		echo $thisid;
		
		/* get website id from gallery table */
		$this->db->where('id',$imgid);
		$query_gallery = $this->db->get('gallery');
		$row_gal = $query_gallery->row_array();
		$wid = $row_gal['web_id'];
		
		/* get page id from gallery table to albums table */
		$this->db->where('id',$row_gal['albums']);
		$pageQuery = $this->db->get('albums');
		$pageRow = $pageQuery->row_array();
		
		/* for notification */
		$websiteUser = "SELECT `user_id` FROM websites WHERE id='".$wid."' ";
		$webuser = $this->db->query("SELECT * FROM users where uid = ($websiteUser)");
		$rowUser = $webuser->row_array();
		$status = 1;
		$action = 'photo';
		$times = time();
		if($rowUser['uid'] != $userdata)
		{
			/* notify post owner */
			$returns = 'reply to owner';
			$flagQuery = $this->db->query("INSERT INTO flag (uid, website_id, status, notify, action, time, img_id, page_id, callback) VALUES('".$userdata."','".$wid."','".$status."','".$rowUser['uid']."','".$action."','".$times."','".$imgid."','".$pageRow['page_id']."','".$returns."')");
			
			/* check if other users also commented of post */
			$querycomment = $this->db->query("SELECT DISTINCT msg_id_fk,uid_fk FROM comments WHERE msg_id_fk = ".$imgid." AND uid_fk != ".$this->session->userdata('uid')." ");
			if($querycomment->num_rows() > 0)
			{
				foreach($querycomment->result_array() as $rowComment)
				{
					if($rowComment['uid_fk'] != $rowUser['uid'])
					{
						$return_other = 'reply to other';
						$this->db->query("INSERT INTO flag (uid, website_id, status, notify, action, time, img_id, page_id, callback) VALUES('".$userdata."','".$wid."','".$status."','".$rowComment['uid_fk']."','".$action."','".$times."','".$imgid."','".$pageRow['page_id']."','".$return_other."')");
					}
				}
			}
		}else
		{
			$rQuery = $this->db->query("SELECT * FROM flag WHERE img_id='".$imgid."' ");
			$rowR = $rQuery->row_array();
			if($rQuery->num_rows() > 0)
			{
				/* check if other users also commented of post */
				$querycomment = $this->db->query("SELECT DISTINCT msg_id_fk,uid_fk FROM comments WHERE msg_id_fk = ".$imgid." AND uid_fk != ".$this->session->userdata('uid')." ");
				if($querycomment->num_rows() > 0)
				{
					foreach($querycomment->result_array() as $rowComment)
					{
						if($rowComment['uid_fk'] != $rowUser['uid'])
						{
							$returns = 'reply';
							$flagQuery = $this->db->query("INSERT INTO flag (uid, website_id, status, notify, action, time, img_id, callback, page_id) VALUES('".$rowUser['uid']."','".$wid."','".$status."','".$rowComment['uid_fk']."','".$action."','".$times."','".$imgid."','".$returns."','".$pageRow['page_id']."')");
						}
					}
				}
			}
		}
		
		
	}
	
	function sendtoseller() {
		if($this->input->post()) {
			$fname = $this->input->post('fname');
			$emails = $this->input->post('emails');
			$subject = $this->input->post('subject');
			$message = $this->input->post('message');
			$sellermail = $this->input->post('sellermail');
			$product_id = $this->input->post('product_id');
			
			/* save email message to database */
			$insert_data = array(
				'product_id' => $product_id,
				'sender_email' => $emails,
				'receiver_email' => $sellermail,
				'sender_name' => $fname,
				'subject' => $subject,
				'message' => $message,
				'timestamp' => time()
			);
			$this->db->insert('product_inquiry', $insert_data);
			$insert_id = $this->db->insert_id();
		
			/*** create product link ***/
				$produrl = $this->getProductURL($product_id);
					
				$site_url = url_title($produrl['url'], '-', true);
				$page_url = url_title($produrl['page_name'], '-', true);
				$prod_name = url_title($produrl['prod_name'], '-', true);
				
				$prod_link = base_url($site_url . '/' . $page_url . '/' . $prod_name . '/' . $produrl['id']);
			/*** ***/
			
			/*** get website id ***/
				$this->db->where('id', $product_id);
				$qproducts = $this->db->get('products');
				$rproducts = $qproducts->row_array();
				$wid = $rproducts['website_id'];
				$pid = $rproducts['page_id'];
			/*** ***/
			
			/** get user id **/
				$this->db->where('id', $wid);
				$query = $this->db->get('websites');
				$rwebsite = $query->row_array();

				$user_id = $rwebsite['user_id'];
			/** **/
			
			/* get email cc */
				$this->db->where('uid', $user_id);
				$quser = $this->db->get('users');
				$ruser = $quser->row_array();
				$user_email = $ruser['email'];
			/* */

			/* check if affiliated to marketgroup */
				$this->db->where('web_id', $wid);
				$status_array = array('approved', 'accepted', '1');
				$this->db->where_in('status', $status_array);
				$qweb_marketgroup = $this->db->get('web_marketgroup');
				if($qweb_marketgroup->num_rows() > 0) {
					$rweb_marketgroup = $qweb_marketgroup->row_array();
					$this->db->where('id', $rweb_marketgroup['marketgroup_id']);
					$qmarketgroup = $this->db->get('marketgroup');
					$rmarketgroup = $qmarketgroup->row_array();
					
					$site = $rmarketgroup['name'];
					$url = base_url(url_title($rmarketgroup['url']));
				} else {
					$site = 'Bolooka';
					$url = '';
				}
			/* */
		
			/* send email */
					$config['mailtype'] = 'html';
					$config['charset'] = 'iso-8859-1';
					$config['wordwrap'] = TRUE;
					
					$this->email->initialize($config);
			
			$this->email->from($emails, $fname);
			$this->email->to($user_email);
			// $this->email->cc('another@another-example.com');
			$this->email->bcc('info@bolooka.com');
			$this->email->subject($subject);
			
			$message2send = 
				'<strong> '.$site.' Inquiry: </strong> <br>'.
				'&ldquo;'. $message .'&rdquo; <br>'.
				'<br>'.
				'<strong> Product Link: </strong><br>'.
				'<a href="'.$prod_link.'"> '.$produrl['prod_name'].' </a> - <a href="'.$prod_link.'"> '. $prod_link .' </a><br>'.
				'<br>'.
				'Message delivered by <a href="'.$url.'"> '.$site.' </a><br>'
			;
			$this->email->message($message2send);

			if($this->email->send()) {
				echo $insert_id;
			} else {
				/* echo $this->email->print_debugger(); */
			}
		} else {
			// redirect(base_url());
		}
	}
	
	function getProductURL($productid = null) {
		if($productid != null) {
			$this->db->select('websites.url, websites.site_name, pages.name as "page_name", products.name as "prod_name", products.id');
			$this->db->where('products.id', $productid);
			$this->db->join('websites', 'websites.id = products.website_id');
			$this->db->join('pages', 'pages.id = products.page_id');
			$qprod = $this->db->get('products');

			$rprod = $qprod->row_array();

			return $rprod;
		}
	}
	
	function del_feed_comment(){
		$type = $_POST['type'];
		$comment_id = $_POST['comment_id'];
		$product_id = $_POST['product_id'];
		$this->db->query("DELETE FROM `comments` WHERE `com_id`='$comment_id'");
	}
	
	function checkImage() {
		$productID = $this->input->post('prodID');
		$this->db->where('id', $productID);
		$qProd = $this->db->get('products');
		if($qProd->num_rows > 0) {
			$products = $qProd->row_array();
			$this->db->where('id', $products['website_id']);
			$qUser = $this->db->get('websites');
			if($qUser->num_rows() > 0) {
				$rowUser = $qUser->row_array();
				
				if($this->db->field_exists('product_cover', 'products')) {
					$file = $products['product_cover'];
				} else {
					$file = $products['primary'];
				}
				$oldfile = 'uploads/'.$file;
				
				if(is_file($oldfile)) {
					$new_dir = 'uploads/'.$rowUser['user_id'].'/'.$rowUser['id'].'/'.$products['page_id'].'/'.$products['id'];
					if(!is_dir($new_dir)){
						if (!mkdir($new_dir, 0755, true)) {
							die('Failed to create folders...');
						}
					}
					$newfile = $new_dir.'/'.$file;
					
					if (!rename($oldfile, $newfile)) {
						echo "failed to rename $file...\n";
					}
				} else {
					echo 'file not found';
				}
			}
		}
	}
	/* for admin access */
	function add_access2admin() {
		$userID = $this->input->post('userID');
		$value = $this->input->post('value');

		$user_market = array(
			'admin_access' => $value
		);
		$this->db->where('uid', $userID);
		$this->db->update('users', $user_market);
	}
	/* */
	
	/* pagination for catalogue */
	function prodpagination() {
		$pid = $this->input->post('pid');
		$page_num = $this->input->post('p_num');
		$wid = $this->input->post('wid');
		$category = $this->input->post('category');
		
		$perpage = 10;
		$startingpoint = ($page_num * $perpage) - $perpage;

		$this->db->where('page_id', $pid);
		if($category) {
			if($category != 'all')
			{
				$this->db->where('category', $category);
			}
		}
		$this->db->where('website_id', $wid);
		$this->db->where_not_in('name', '');
		$this->db->order_by('id','desc');
		$this->db->limit($perpage, $startingpoint);
		$queryProducts = $this->db->get('products');
		
		foreach($queryProducts->result_array() as $product)
		{
				if(isset($word_set))
				{
					$product['name'] = str_ireplace($word_set,'<mark>'.$word_set.'</mark>',$product['name']);
					$product['category'] = str_ireplace($word_set,'<mark>'.$word_set.'</mark>',$product['category']);
				}
				$p_image = '';

				if($this->db->field_exists('product_cover', 'products')) {
					if($product['product_cover'] != null)
					{
						$p_image = base_url().'uploads/' . $this->session->userdata('uid') . '/' . $wid . '/' . $pid . '/' . $product['id'] . '/'. $product['product_cover'];
					}
				} else {
					if($product['primary'] != null)
					{
						$p_image = base_url().'uploads/' . $this->session->userdata('uid') . '/' . $wid . '/' . $pid . '/' . $product['id'] . '/'. $product['primary'];
					}
				}

				if($product['name'] != null)
				{
					$this->db->where('product_id',$product['id']);
					$queryProdImage = $this->db->get('products_images');

					echo '<tr id="'.$product['id'].'" class="item_prod">
					  <td>
						<abbr title="Edit" style="border-bottom: none;"><i class="icon-cog edit_product" onmouseenter="this.style.color=\'red\';" onmouseleave="this.style.color=\'black\'" style="cursor: pointer;"></i></abbr>
						<abbr title="Delete" style="border-bottom: none;"><i class="icon-trash del_product" onmouseenter="this.style.color=\'red\';" onmouseleave="this.style.color=\'black\'" style="cursor: pointer;"></i></abbr>
					  </td>
					  <td style="cursor:pointer;">
						000'.$product['id'].'
					  </td>
					  <td class="edit_product" style="cursor:pointer;">
						<a class="prod_imageview" alt="'.$p_image.'" rel="tooltip" style="color:#000;text-decoration:none;cursor:pointer">
							'.$product['name'].'
						</a>	
						<div class="product_preview container" style="display:none;"></div>
					  </td>
					  <td class="hidden-phone">'.$product['category'].'</td>
					  <td class="hidden-phone">'.$product['stocks'].'</td>
					  <td class="hidden-phone">PHP '.number_format($product['price'], 2).'</td>
					  <td style="width: 120px;">
						<select class="span12 pubunpub" name="pubunpub'.$product['id'].'">
							<option value="1" '.($product['published'] == 1 ? 'selected' : ' ').'> Published </option>
							<option value="0" '.($product['published'] == 0 ? 'selected' : ' ').'> Unpublished </option>
						</select>
					  </td>
					</tr>
					';
				}

		}
	}
	
	function catalog_second() {
		extract($this->input->post());

		$price_tag = null;
		
		// $query_prod = $this->db->query("SELECT * FROM products WHERE page_id='".$pid."' AND website_id='".$wid."' AND id < '$lastId' AND published = 1 ".$ctoquery." ORDER BY id desc LIMIT 12");
		$this->db->where('products.page_id', $pid);
		$this->db->where('products.published', 1);
		if($filter) {
			if($filter != 'All')
			{
				$this->db->where('(products.category LIKE "%'.$filter.'%" OR products.sub_category LIKE "%'.$filter.'%")', null, true);
			} 
		}
		if($search) {
			$this->db->where('(products.name LIKE "%'.$search.'%")', null, true);
		}
		if($wid == 364)
		{
			$this->db->order_by('products.id asc');

		}else
		{
			$this->db->order_by('products.id desc');
		}
		if($this->input->get_post('limit'))
		{
			$limit = $this->input->get_post('limit');
			if($this->input->get_post('offset'))
			{
				$offset = max((($limit * $this->input->get_post('offset')) - $limit) , 0);
			}
		}
		$this->db->group_by('products.id');
		$this->db->limit($limit, $offset);
		$query_prod = $this->db->get('products');
		
		if($query_prod->num_rows() > 0) {
			foreach($query_prod->result_array() as $rowp){
				$this->db->where('id', $rowp['website_id']);
				$qweb = $this->db->get('websites');
				$rweb = $qweb->row_array();
				
				$prod_name = $rowp['name'];
				$prod_id = $rowp['id'];
				$price_tag = '';
				
				$this->db->where('product_id',$prod_id);
				$this->db->order_by('price asc');
				$variant = $this->db->get('product_variants');
				$variant_row = $variant->row();
				
				if($rowp['price'] > 0){
					$price_tag = '<div class="price_in_a_box">Php '.number_format($rowp['price'], 2).'</div>';
				}else if($variant->num_rows() > 0 && $variant_row->price) 
				{
					if($variant->num_rows() > 1)
					{
						$price_tag = '<div class="price_in_a_box">Start at Php '.number_format($variant_row->price, 2).'</div>';
					}else
					{
						$price_tag = '<div class="price_in_a_box">Php '.number_format($variant_row->price, 2).'</div>';
					}
					
				}

				if($this->db->field_exists('product_cover', 'products')) {
					$cover = $rowp['product_cover'];
				} else {
					$cover = $rowp['primary'];
				}

				$checkPic = 'uploads/' . $rweb['user_id'] . '/' . $rowp['website_id'] . '/' . $pid . '/' . $prod_id . '/s180x180/' .$cover;
				
				if($this->photo_model->image_exists($checkPic)) {
					$imgSrc = base_url().$checkPic;
				} else {
					$checkPic = 'uploads/' . $rweb['user_id'] . '/' . $rowp['website_id'] . '/' . $pid . '/' . $prod_id . '/' .$cover;
					if($this->photo_model->image_exists($checkPic)) {
						$checkPic = $this->photo_model->custom_thumbnail($checkPic, 180, 180);
						$imgSrc = base_url().$checkPic;
					} else {
						$imgSrc = 'http://www.placehold.it/180x180/333333/ffffff&text=image+not+found';
					}
				}
				
				echo '
					<li class="box" style="background-image: url(\''.$imgSrc.'\'); background-position: top center; background-repeat: no-repeat; background-size: cover;">
						<a class="cat-items" data-id="'.$prod_id.'" style="color:#fff;" href="'.base_url().url_title($web_url, '-', true).'/'.url_title($page_url, '-', true).'/'.url_title($prod_name, '-', TRUE).'/'.$prod_id.'">
							<div class="fade_gradient">
								<div class="product_label trim text-center">
											'.html_entity_decode($prod_name, ENT_QUOTES).'
								</div>
								'.$price_tag.'
							</div>
						</a>
					</li>
				';
			}
		} else {
			echo 'lana';
		}
	}
	
	function get_content_catalogue()
	{
		$p = $this->input->post('p');
		$w = $this->input->post('w');
		$type = $this->input->post('type');
		
		/* result for data fetch from products */
		$this->db->where('page_id',$p);
		$query = $this->db->get('products');
		echo $query->num_rows().'>>>';
		
		$data['pid'] = $p;
		$data['wid'] = $w;
		echo $this->load->view('edit/pages/'.$type, $data);
	}
	
	function deletefav(){
		$web_id = $_POST['web_id'];
		
		// $this->db->query("UPDATE `websites` SET `favicon`= NULL WHERE `id` = '$web_id'");
		$del_arr = array(
					'favicon' => NULL
				);
		$this->db->where('id',$web_id);
		$this->db->update('websites',$del_arr);
		redirect(base_url().'manage/webeditor?wid='.$web_id);
	}
	
	function deletelogo(){
		$web_id = $_POST['logo_id'];
		$del_arr = array(
					'image' => NULL
				);
		//$this->db->query("UPDATE `logo` SET `image`= NULL WHERE `website_id` = '$web_id'");
		$this->db->where('website_id',$web_id);
		$this->db->update('logo',$del_arr);
		redirect(base_url().'manage/webeditor?wid='.$web_id);
	}
	
	function check_site_exists() {
		$file = $this->input->post('siteName');
		$file = trim($file);
		if($file != null) {
			/* check if link exists */
			$url = base_url(url_title($file, '-', true));
			$headers = @get_headers($url);
			$pos = strpos($headers[0], 'Not Found');
			if ($pos === false) {
				echo true;
			} else {
				$this->db->where('url', $file);
				$qweb = $this->db->get('websites');
				if($qweb->num_rows() > 0) {
					echo true;
				}
			}
		}
	}
	
	function fb() {
		$this->load->model('facebook_model');
		$data = $this->facebook_model->fb_action_create('noel');
		print_r($data);
	}
	
	function getprods() {
		$products = $this->marketplace_model->getMarketProducts();
		if($products->num_rows() > 0)
		{
			$numprods = range($min = 0, $products->num_rows() - 1);
			shuffle($numprods);
			for($p = 0; $p < $products->num_rows() && $p < 10; $p++)
			{
					$prod = $products->row_array($numprods[$p]);
					/* get website */
					$this->db->where('id', $prod['website_id']);
					$this->db->where('deleted', 0);
					$qweb = $this->db->get('websites');
					$rweb = $qweb->row_array();
					
					/* get pages */
					$this->db->where('id',$prod['page_id']);
					$pquery = $this->db->get('pages');
					$prow = $pquery->row_array();
					
					if($this->db->field_exists('product_cover', 'products')) {
						$cover = $prod['product_cover'];
					} else {
						$cover = $prod['primary'];
					}
					
					$img = base_url().'uploads/'.$rweb['user_id'].'/'.$rweb['id'].'/'.$prod['page_id'].'/'.$prod['id'].'/thumbnail/'.$cover;
					$imgsrc = $img;
					
					echo '
					<a href="'.base_url($rweb['url']).'" id="'.$prod['id'].'"><img src="'.$img.'"></a>
					';
			}
		}
	}
	
	function pass_decode() {
		$pass = '0FpUDeQHF4Z+gcc2hok9gmIeO0ECU1uJ0ZpjWlFzDPU4Kt2uy6p6CgbEjw8JyjPUhL0W84OvAE3YFytXQxAaAw==';
		$this->load->library('encrypt');
		
		$data = $this->encrypt->decode($pass);
		echo $data;
	}
	
	function updatepaid(){
		$pay_status = $this->input->post('pay_status');
		$txnvalue = $this->input->post('txnvalue');
		
		$update_array = array(
			'payment_status' => $pay_status
		);
		
		$this->db->where('txn_id', $txnvalue);
		$this->db->update('confirm_orders', $update_array);
		
	}
	
	function uploadreceipt(){
		$uid = $this->session->userdata('uid');
		// print_r($_FILES);
		if(isset($_FILES['receiptfile'])){			
			$this->load->model('Photo_Model');
			$uploaded = $this->photo_model->upload('receiptfile', $uid);
			$thumbnail = $this->photo_model->make_thumbnail($uploaded['full_path']);
			$medium = $this->photo_model->make_medium($uploaded['full_path']);
		
			// // print_r($uploaded);
			// /* for upload image file */
			if(isset($uploaded['file_name']))
			{
				$update_array = array(
					'receiptfile' => $uploaded['file_name']
				);
				
				$this->db->where('txn_id', $this->input->post('txn_id'));
				$this->db->update('confirm_orders', $update_array);								
			}		
			
		}else{
			echo 'nodata';
		}
	}
	
	function typeahead(){
	
		$array = array();
		$asd = $this->input->post('query');
		$this->db->distinct();
		$this->db->select('tag_names');
		$this->db->like('tag_names',$asd);
		$query_tags_names = $this->db->get('tags');
		$len = $query_tags_names->num_rows();
		foreach($query_tags_names->result_array() as $rowrow)
		{ 
			array_push($array,$rowrow['tag_names']);
		} 
		echo json_encode($array);
	}
	
	function getCategory() {
		$section = $this->input->get('section');
		$product_category = array();
		if($section === 'furnitures') {
			
			// array_push($product_category,'Select...');
			$product_category[''] = 'Select...';
			$this->db->where('section_id',$section);
			$dbfurniture = $this->db->get('product_category');
			foreach ($dbfurniture->result_array() as $tablerow) {
				$product_category[$tablerow['id']] = $tablerow['value'];
			}
		}
		else if($section === 'crafts') {
			
			// array_push($product_category,'Select...');
			$product_category[''] = 'Select...';
			$this->db->where('section_id',$section);
			$dbcraft = $this->db->get('product_category');
			foreach ($dbcraft->result_array() as $tablerow) {
				$product_category[$tablerow['id']] = $tablerow['value'];
			}		
		}
		else if($section === 'food') {
			$product_category = array(
				'diary' => 'Dairy',
				'fruits' => 'Fruits',
				'grains' => 'Grains',
				'meat' => 'Meat',
				'sweets' => 'Sweets',
				'vegetables' => 'Vegetables',
				'water' => 'Water',
				'alcohol' => 'Alcohol',
				'juice' => 'Juice',
				'cookies' => 'Cookies',
				'others' => 'Other',
			);		
		}
		else {
			$product_category = array(
					'others' => 'Others'
				);
		}
		foreach($product_category as $key=>$value) {
			echo '<option value="'.$key.'">'.$value.'</option>';
		}
	}
	
	function backend() {
		$filename  = dirname(__FILE__).'/data.txt';

		// store new message in the file
		$msg = isset($_GET['msg']) ? $_GET['msg'] : '';
		if ($msg != '')
		{
			file_put_contents($filename,$msg);
			die();
		}

		// infinite loop until the data file is not modified
		$lastmodif    = isset($_GET['timestamp']) ? $_GET['timestamp'] : 0;
		$currentmodif = filemtime($filename);
		while ($currentmodif <= $lastmodif) // check if the data file has been modified
		{
			usleep(10000); // sleep 10ms to unload the CPU
			clearstatcache();
			$currentmodif = filemtime($filename);
		}

		// return a json array
		$response = array();
		$response['msg']       = file_get_contents($filename);
		$response['timestamp'] = $currentmodif;
		echo json_encode($response);
		flush();
	}
	
	function sample_comet() {
		
	}
	
	function chat() {
		extract($this->input->post());

		$data = array(
		   'from_user_id' => $from,
		   'to_user_id' => $to,
		   'message' => $message,
		   'timestamp' => time()
		);

		$this->db->insert('chat', $data);
	}
	
	function get_chat() {
		$qchat = $this->db->get('chat');
		$rchat = $qchat->result_array();
		$data = json_encode($rchat);
		echo $data;
	}
	
	function random_it() {
		$this->db->where('products.marketplace', 1);
		$qproducts = $this->db->get('products');
		$rproducts = $qproducts->result_array();

		$numprods = range($min = 0, $qproducts->num_rows() - 1);
		shuffle($numprods);
		foreach($rproducts as $key=>$prods)
		{
			if($this->db->field_exists('product_seq', 'products')) {
				$update_data = array(
					'product_seq' => $numprods[$key]
				);
			} else {
				$update_data = array(
					'order' => $numprods[$key]
				);
			}
			$this->db->where('id', $prods['id']);
			$this->db->update('products', $update_data);
		}
	}
	
	// function favme() {
		// $this->load->model('favicon_model');
		// $img = $this->favicon_model->set_favicon('3');
	// }
	
	function loadmore() {
		$data['range'] = $this->input->get_post('range');
		$offset = $this->input->get_post('offset');
		$searchvalue = $this->input->get_post('searchvalue');
		$activetab = $this->input->get_post('activetab');
		$datefrom = $this->input->get_post('datefrom');
		$dateto = $this->input->get_post('dateto');
		$orderby = $this->input->get_post('orderby');

		$start = ($data['range'] * $offset) - $data['range'];
		
		if($activetab === 'm-c') {
			$data['queryMarketProducts'] = $this->marketplace_model->getMarketProducts(0, $data['range'], $start, null, null, $searchvalue, $orderby);
			$data['products_content'] = $this->load->view('admin/marketplace_control_content', $data, true);
			echo $data['products_content'];
		}
		if($activetab === 'w-c') {
			$data['queryActiveWebsites'] = $this->marketplace_model->getActiveWebsites($datefrom, $dateto, $data['range'], $start, $searchvalue, $orderby);
			$data['websites_control_content'] = $this->load->view('admin/websites_control_content', $data, true);
			echo $data['websites_control_content'];
		}
		if($activetab === 'u') {
			$data['queryUsers'] = $this->marketplace_model->getUsers($datefrom, $dateto, $data['range'], $start, $searchvalue, $orderby);
			$data['users_content'] = $this->load->view('admin/users_content', $data, true);			
			echo $data['users_content'];
		}
		if($activetab === 'w') {
			$data['queryWebsites'] = $this->marketplace_model->getWebsites($datefrom, $dateto, $data['range'], $start, $searchvalue, $orderby);
			$data['websites_content'] = $this->load->view('admin/websites_content', $data, true);
			echo $data['websites_content'];
		}
		if($activetab === 'p') {
			$data['queryProducts'] = $this->marketplace_model->getProducts($datefrom, $dateto, $data['range'], $start, $searchvalue, $orderby);
			$data['products_content'] = $this->load->view('admin/products_content', $data, true);
			echo $data['products_content'];
		}
	}
	
	function upload_gallery() {
		$wid = $this->input->post('wid');
		$albumid = $this->input->post('albumid');
		$uploaded = $this->photo_model->multi_upload($albumid, 0, 0, 0, 'album');
		
		$images_arr = array();
		
		if(array_key_exists('success', $uploaded)) {
			foreach($uploaded['success'] as $photo) {
				$insert_gallery = array(
					'web_id' => $wid,
					'image_file' => $photo['file_name'],
					'albums' => $albumid
				);
				$this->db->insert('gallery', $insert_gallery);
				$gallery['id'] = $this->db->insert_id();
				array_push($images_arr, $insert_gallery);
			}
			
			$check_record_time = $this->wall_updates->select_blog(0, $albumid);
			
			if($check_record_time->num_rows() > 0)
			{
				foreach ($check_record_time->result() as $chk_time_row)
				{
				  $chk_time_value = $chk_time_row->created;
				}
				$time_ago = $this->times_model->makeAgoNum($chk_time_value);
				$period_ago = $this->times_model->makeAgoPeriod($chk_time_value);
				if(($period_ago =='hrs ago') || ($period_ago =='hr ago') || ($period_ago =='day ago') || ($period_ago =='days ago') || ($period_ago =='week ago') || ($period_ago =='weeks ago') || ($period_ago =='month ago') || ($period_ago =='months ago'))
				{
					if(($period_ago =='hrs ago') || ($period_ago =='hr ago'))
					{
						if($time_ago >= 1)
						{
							$this->wall_updates->insert_blog($wid, 0, $albumid);
						}
					}
				}
			}
			else
			{
				$this->wall_updates->insert_blog($wid, 0, $albumid);
			}

			// echo json_encode($images_arr);

			$this->db->where('id', $gallery['id']);
			$qgallery = $this->db->get('gallery');
			$rgallery = $qgallery->row_array();
			$image = base_url('files/'.$rgallery['albums'].'/'.$rgallery['image_file']);
			
			$output = '
				<div class="row-fluid sorthold" id="image_'.$rgallery['id'].'" data-galleryid="'.$rgallery['id'].'" albumid="'.$rgallery['albums'].'">

						<div class="span2 offset1 text-center">
							<img src="'.$image.'">
						</div>
						<div class="offset2 span2">
							<input type="radio" class="albumpriId" name="albumpriId_'.$rgallery['albums'].'" value="'.$rgallery['image_file'].'" />
							<span class="priinfo primary_info"> </span>
						</div>

					<div class="span2 offset2">
						<button type="button" class="btn show_album_modal" data-image="'.$rgallery['image_file'].'">
							<i class="icon-trash"></i>
							<span>Delete</span>
						</button>				
					</div>
				</div>
			';
			echo $output;
		}
	}
	
	function get_albums() {
		$wid = $this->input->post('web_id');
		$pid = $this->input->post('page_id');
		$this->db->where('web_id', $wid);
		$qalbums = $this->db->get('albums');
		if($qalbums->num_rows() > 0) {
			$ralbums = $qalbums->result_array();

			foreach($ralbums as $album) {
				extract($album);
				$album_path = 'files/'.$id.'/';
				if(isset($album_cover)) {
					$img = $album_path.$album_cover;
				} else {
					$img = $album_path.$primary;
				}
				// if($this->photo_model->image_exists($img)) {
					$imgsrc = base_url($img);
				// } else {
					// $imgsrc = 'http://placehold.it/80x80';
				// }
					echo'
					<li class="album-'.$id.'">
						<a class="thumbnail" style="width: 80px; height: 80px; cursor: pointer;" onclick="javascript:void(0)">
							<img src="'.$imgsrc.'" style="max-width: 80px; max-height: 80px;">
						</a>
					</li>
					';
			}

		}
	}
	
	function get_gallery() {
		$wid = $this->input->post('web_id');
		$position = $this->input->post('position');
		
		$this->db->where('web_id', $wid);
		$qgallery = $this->db->get('gallery');
		if($qgallery->num_rows() > 0) {
			$rgallery = $qgallery->result_array();

			foreach($rgallery as $gallery) {
				extract($gallery);
				$album_path = 'files/'.$albums.'/';
				$img = $album_path.$image_file;
				if($this->photo_model->image_exists($img)) {
					$imgsrc = base_url($img);
				} else {
					$img = $album_path.$image;
					if($this->photo_model->image_exists($img)) {
						$imgsrc = base_url($img);
					} else {
						$img = $album_path.$image_name;
						if($this->photo_model->image_exists($img)) {
							$imgsrc = base_url($img);
						} else {
							$imgsrc = 'http://placehold.it/80x80';
						}
					}
				}
				
				$this->db->where('gallery_id', $id);
				$this->db->where('image_position', $position);
				$qarticle_images = $this->db->get('article_images');

					echo'
					<li class="gallery-'.$id.'">
						<a data-image-position="'.$position.'" class="thumbnail'. ($qarticle_images->num_rows() > 0 ? ' btn-info' : '') .'" style="width: 80px; height: 80px; cursor: pointer;">
							<img src="'.$imgsrc.'" style="max-width: 80px; max-height: 80px;">
						</a>
					</li>
					';
			}

		}
	}
	
	function insert_image_article() {
		$page_id = $this->input->post('page_id');
		$gallery_id = $this->input->post('gallery_id');
		$position = $this->input->post('position');

		$this->db->where('gallery_id', $gallery_id);
		$this->db->where('image_position', $position);
		$qarticle_images = $this->db->get('article_images');
		if($qarticle_images->num_rows() == 0) {
			$article_images_data = array(
				'gallery_id' => $gallery_id,
				'page_id' => $page_id,
				'image_position' => $position
			);
			$this->db->insert('article_images', $article_images_data);
		}
	}
	
	function remove_image_article() {
		$page_id = $this->input->post('page_id');
		$gallery_id = $this->input->post('gallery_id');
		$position = $this->input->post('position');

		$this->db->where('gallery_id', $gallery_id);
		$this->db->where('image_position', $position);
		$this->db->delete('article_images');
	}
	function img_prod_del(){
		if (isset($_POST["delphoto"]))
		$checkarray=$_POST["delphoto"];
		echo json_encode($checkarray);
		$this->db->where_in('id',$checkarray)->delete('products_images');
	}
}


/* End of file test.php */
/* Location: ./application/controllers/dashboard.php */