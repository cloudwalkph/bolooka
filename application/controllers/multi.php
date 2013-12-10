<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Multi extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->helper(array('form', 'url', 'cookie'));			
			$this->load->library('session');
			$this->load->library('form_validation');
			$this->load->database();
			$this->load->model('session_model');
			$this->load->model('membership_model');
			$this->load->model('times_model');
			$this->load->model('video_model');
			$this->load->library('email');
			$this->load->library('cart');
			$this->load->model('photo_model');
			$this->load->model("paging_feedback");
			$this->load->library("pagination");
			$this->load->model('colormodel');
			$this->load->model('wall_updates');
			$this->load->model('gallery_model');
		}
		
		function index()
		{
			if(isset($_GET['albumid']))
			{
				$data['albumid'] = $_GET['albumid'];
				$data['pid'] = $_GET['pid'];
			}
			$this->load->view('multi', $data);
		}
		
		function upload()
		{
			$this->load->view('upload');
		}
		
		function blogcomment()
		{
			$this->load->view('templates/types/blog_comment.php');
		}

		function load_blog()
		{
			$data['wid'] = $this->input->post('wids');
			$data['pid'] = $this->input->post('pid');
			$data['lastId'] = $this->input->post('lastId');
			
			$data['query'] = $this->wall_updates->post_share(0, $data['wid'], $data['pid'], 4, $data['lastId']);

			// print_r($data);
			$this->load->view('templates/types/load_first.php', $data);
		}
		
		function showAll()
		{
			//echo 'ahaha';
			$msg_id = $_POST['msgId'];
			$userPost = $this->session->userdata('uid');
			$webPost = $this->session->userdata('website');
			$queryCommArea = $this->db->query("SELECT * FROM comments WHERE msg_id_fk='$msg_id' ORDER BY com_id ASC");
			foreach($queryCommArea->result_array() as $rowComments)
				{
					$comments = $rowComments['comment'];
					$com_id = $rowComments['com_id'];
					$usercom = $rowComments['uid_fk'];
					$createdss = $rowComments['created'];
					
					$usercomname = $this->db->query("SELECT * FROM users WHERE uid='$usercom' ORDER BY uid DESC LIMIT 1");
					if($usercomname->num_rows() > 0)
					{
							foreach($usercomname->result_array() as $rowname)
							{
								$first_name = $rowname['first_name'];
								$profilePicTo = $rowname['profile_picture'];
							}
							$profilePicTo = str_replace(" ","_",$profilePicTo);
							if($profilePicTo == null)
							{
								$userPhoto = 'img/Default Profile Picture.jpg';
							}
							else
							{
								$userPhoto = 'uploads/'.$profilePicTo;
							}
							
							
								$websitepost = $this->db->query("SELECT * FROM websites WHERE user_id='$userPost' AND id='$webPost' ORDER BY id DESC LIMIT 1");
						$numWebsites = $websitepost->num_rows();
						if(($numWebsites > 0) OR ($usercom == $userPost))
								{
									echo '<li style="margin: 0;padding: 5px 5px 4px;margin-top: 1px;border-radius: 0 0 0 0;border-bottom: 1px solid;">
													<div style="line-height: 1.28;display: block;">
														<img src="'.base_url().$userPhoto.'" style="width: 36px;height:36px;margin-right: 8px;float: left;display: block;" />
														<a href="#" style="float: right;display: inline-block;" onclick="deleteComment(this, '.$com_id.', '.$msg_id.')">x</a>
														<div style="padding-left:44px;color:#555555;">
														<a href="#">'.$first_name.'</a>
														<span style="font-size: 11px;">'.$comments.'</span>
														<div style="font-size: 10px;font-style: italic;padding-top: 2px;">'.$this->times_model->makeAgo($createdss).'</div>
														</div>
													</div>
													</li>';
									
								}
								else
								{
									echo '<li style="margin: 0;padding: 5px 5px 4px;margin-top: 1px;border-radius: 0 0 0 0;border-bottom: 1px solid;">
													<div style="line-height: 1.28;display: block;">
														<img src="'.base_url().$userPhoto.'" style="width: 36px;height:36px;margin-right: 8px;float: left;display: block;" />
														
														<div style="padding-left:44px;color:#555555;">
														<a href="#">'.$first_name.'</a>
														<span style="font-size: 11px;">'.$comments.'</span>
														<div style="font-size: 10px;font-style: italic;padding-top: 2px;">'.$this->times_model->makeAgo($createdss).'</div>
														</div>
													</div>
													</li>';
								}
					}
					
				}
		}
		
		function deleteCommentview()
		{
			$comentId = $_POST['commentId'];
			$messageId = $_POST['msgId'];
			$viewin = $_POST['viewsin'];
			$userPost = $this->session->userdata('uid');
			$webPost = $this->session->userdata('website');
			$queryCommArea = $this->db->query("SELECT * FROM comments WHERE msg_id_fk='$messageId' ORDER BY com_id ASC");
			$numComments = $queryCommArea->num_rows();
			$deleteThis = $this->db->query("DELETE FROM comments WHERE com_id='$comentId' LIMIT 1");
			echo '<div id="view'.$messageId.'" onclick="viewall(this, '.$messageId.')" style="opacity: 0.6;margin-left: -10px;width: 316px;padding-top: 5px;cursor: pointer;background:#fff;color:#555553;padding-bottom: 6px;"><span style="margin-left: 111px;">View All '.$numComments.' Comments</span></div>';
			$queryCommArea = $this->db->query("SELECT * FROM comments WHERE msg_id_fk = '$messageId' AND com_id >= '$viewin' ORDER BY com_id ASC");
			$numComments = $queryCommArea->num_rows();
			//$firstRow = $showOne->first_row();
			//$nextRow = $showOne->next_row();
			/* $rowComments = $queryCommArea->row_array();
			for ($i = 1; $i <= $numComments; $i++) { 
     
				echo $rowComments['com_id'].'<br />';
				 
			}  */
			
			 foreach($queryCommArea->result_array() as $rowComments)
				{
					$comments = $rowComments['comment'];
					$com_id = $rowComments['com_id'];
					$usercom = $rowComments['uid_fk'];
					$createdss = $rowComments['created'];
					
					$usercomname = $this->db->query("SELECT * FROM users WHERE uid='$usercom' ORDER BY uid DESC LIMIT 1");
					if($usercomname->num_rows() > 0)
					{
							foreach($usercomname->result_array() as $rowname)
							{
								$first_name = $rowname['first_name'];
								$profilePicTo = $rowname['profile_picture'];
							}
							$profilePicTo = str_replace(" ","_",$profilePicTo);
							if($profilePicTo == null)
							{
								$userPhoto = 'img/Default Profile Picture.jpg';
							}
							else
							{
								$userPhoto = 'uploads/'.$profilePicTo;
							}
								//echo $com_id.'<br />';
								
							$websitepost = $this->db->query("SELECT * FROM websites WHERE user_id='$userPost' AND id='$webPost' ORDER BY id DESC LIMIT 1");
							$numWebsites = $websitepost->num_rows();
							//if($usercom == $userPost)
							if(($numWebsites > 0) OR ($usercom == $userPost))
								{
									echo '<li style="margin: 0;padding: 5px 5px 4px;margin-top: 1px;border-radius: 0 0 0 0;border-bottom: 1px solid;">
													<div style="line-height: 1.28;display: block;">
														<img src="'.base_url().$userPhoto.'" style="width: 36px;height:36px;margin-right: 8px;float: left;display: block;" />
														<a href="#" style="float: right;display: inline-block;" onclick="deleteComment(this, '.$com_id.', '.$messageId.')">x</a>
														<div style="padding-left:44px;color:#555555;">
														<a href="#">'.$first_name.'</a>
														<span style="font-size: 11px;">'.$comments.'</span>
														<div style="font-size: 10px;font-style: italic;padding-top: 2px;">'.$this->times_model->makeAgo($createdss).'</div>
														</div>
													</div>
													</li>';
								
								}
								else
								{
										echo '<li style="margin: 0;padding: 5px 5px 4px;margin-top: 1px;border-radius: 0 0 0 0;border-bottom: 1px solid;">
													<div style="line-height: 1.28;display: block;">
														<img src="'.base_url().$userPhoto.'" style="width: 36px;height:36px;margin-right: 8px;float: left;display: block;" />
														
														<div style="padding-left:44px;color:#555555;">
														<a href="#">'.$first_name.'</a>
														<span style="font-size: 11px;">'.$comments.'</span>
														<div style="font-size: 10px;font-style: italic;padding-top: 2px;">'.$this->times_model->makeAgo($createdss).'</div>
														</div>
													</div>
													</li>';
								}
					
					}
				}
			//echo $viewin;
			echo '<input type="hidden" class="viewinput" name="'.$messageId.'" id="viewthis'.$messageId.'" value="'.$viewin.'" >';
			
		}
		
		function deleteComment()
		{
			$comentId = $_POST['commentId'];
			$messageId = $_POST['msgId'];
			$userPost = $this->session->userdata('uid');
			$webPost = $this->session->userdata('website');
			$deleteThis = $this->db->query("DELETE FROM comments WHERE com_id='$comentId' LIMIT 1");
			//echo $comentId;
			$showComment = $this->db->query("SELECT * FROM comments WHERE msg_id_fk='$messageId' ORDER BY com_id ASC");
			echo '<ul>';
			foreach($showComment->result_array() as $rowCom)
			{
				$comments = $rowCom['comment'];
				$com_id = $rowCom['com_id'];
				$usercom = $rowCom['uid_fk'];
				$created = $rowCom['created'];
				$usercomname = $this->db->query("SELECT * FROM users WHERE uid='$usercom' ORDER BY uid DESC LIMIT 1");
				foreach($usercomname->result_array() as $rowname)
				{
					$first_name = $rowname['first_name'];
				}
				$websitepost = $this->db->query("SELECT * FROM websites WHERE user_id='$userPost' AND id='$webPost' ORDER BY id DESC LIMIT 1");
				$numWebsites = $websitepost->num_rows();
				if(($numWebsites > 0) OR ($usercom == $userPost))
				{
					echo '<li style="list-style: none;"><div style="border-bottom: 1px dashed #000000;width: 299px;">
												<div style="font-size: 17px;font-weight: bold;">'.$first_name.'<span style="cursor:pointer;float: right;font-weight: normal;" onclick="deleteComment(this, '.$com_id.', '.$messageId.')">X</span></div>
												<div style="width: 293px;height: auto;font-size: 14px;">'.$comments.'</div>
												<div style="font-size: 12px; font-style: italic;">'.$this->times_model->makeAgo($created).'</div>
												</div>
												</li>';
					//echo '<li>'.$first_name.'-'.$comments.'-'.$this->times_model->makeAgo($created).'<span style="cursor:pointer;" onclick="deleteComment(this, '.$com_id.', '.$messageId.')">X</span></li>';
				}
				else
				{
					echo '<li style="list-style: none;"><div style="border-bottom: 1px dashed #000000;width: 299px;">
												<div style="font-size: 17px;font-weight: bold;">'.$first_name.'</div>
												<div style="width: 293px;height: auto;font-size: 14px;">'.$comments.'</div>
												<div style="font-size: 12px; font-style: italic;">'.$this->times_model->makeAgo($created).'</div>
												</div>
												</li>';
					
				}
				
			}
			echo '</ul>';
		}
		
		function deleteComment_editblog()
		{
			$comentId = $_POST['commentId'];
			$messageId = $_POST['msgId'];
			$userPost = $this->session->userdata('uid');
			$webPost = $this->session->userdata('website');
			$deleteThis = $this->db->query("DELETE FROM comments WHERE com_id='$comentId' LIMIT 1");
		}
		
		function deleteComment2()
		{
			$comentId = $_POST['commentId'];
			$messageId = $_POST['msgId'];
			$userPost = $this->session->userdata('uid');
			$webPost = $this->session->userdata('website');
			$deleteThis = $this->db->query("DELETE FROM comments WHERE com_id='$comentId' LIMIT 1");
			//echo $comentId;
			$showComment = $this->db->query("SELECT * FROM comments WHERE msg_id_fk='$messageId' ORDER BY com_id ASC");
			echo '<ul>';
			foreach($showComment->result_array() as $rowCom)
			{
				$comments = $rowCom['comment'];
				$com_id = $rowCom['com_id'];
				$usercom = $rowCom['uid_fk'];
				$created = $rowCom['created'];
				$usercomname = $this->db->query("SELECT * FROM users WHERE uid='$usercom' ORDER BY uid DESC LIMIT 1");
				if($usercomname->num_rows() > 0)
				{
					foreach($usercomname->result_array() as $rowname)
					{
						$first_name = $rowname['first_name'];
						$profilePicTo = $rowname['profile_picture'];
					}
					$profilePicTo = str_replace(" ","_",$profilePicTo);
					if($profilePicTo == null)
					{
						$userPhoto = 'img/Default Profile Picture.jpg';
					}
					else
					{
						$userPhoto = 'uploads/'.$profilePicTo;
					}
					$websitepost = $this->db->query("SELECT * FROM websites WHERE user_id='$userPost' AND id='$webPost' ORDER BY id DESC LIMIT 1");
					$numWebsites = $websitepost->num_rows();
					if(($numWebsites > 0) OR ($usercom == $userPost))
					{
							echo '<li style="margin: 0;padding: 5px 5px 4px;margin-top: 1px;border-radius: 0 0 0 0;border-bottom: 1px solid;">
												<div style="line-height: 1.28;display: block;">
													<img src="'.base_url().$userPhoto.'" style="width: 36px;height:36px;margin-right: 8px;float: left;display: block;" />
													<a href="#" style="float: right;display: inline-block;" onclick="deleteComment(this, '.$com_id.', '.$messageId.')">x</a>
													<div style="padding-left:44px;color:#555555;">
													<a href="#">'.$first_name.'</a>
													<span style="font-size: 11px;">'.$comments.'</span>
													<div style="font-size: 10px;font-style: italic;padding-top: 2px;">'.$this->times_model->makeAgo($created).'</div>
													</div>
												</div>
												</li>';
						
						
						//echo '<li>'.$first_name.'-'.$comments.'-'.$this->times_model->makeAgo($created).'<span style="cursor:pointer;" onclick="deleteComment(this, '.$com_id.', '.$messageId.')">X</span></li>';
					}
					else
					{
						echo '<li style="margin: 0;padding: 5px 5px 4px;margin-top: 1px;border-radius: 0 0 0 0;border-bottom: 1px solid;">
												<div style="line-height: 1.28;display: block;">
													<img src="'.base_url().$userPhoto.'" style="width: 36px;height:36px;margin-right: 8px;float: left;display: block;" />
													
													<div style="padding-left:44px;color:#555555;">
													<a href="#">'.$first_name.'</a>
													<span style="font-size: 11px;">'.$comments.'</span>
													<div style="font-size: 10px;font-style: italic;padding-top: 2px;">'.$this->times_model->makeAgo($created).'</div>
													</div>
												</div>
												</li>';
						
					}
				}
			}
			echo '</ul>';
		}
		function deleteComment3()
		{
			$comentId = $_POST['commentId'];
			$messageId = $_POST['msgId'];
			$userPost = $this->session->userdata('uid');
			$webPost = $this->session->userdata('website');
			$deleteThis = $this->db->query("DELETE FROM comments WHERE com_id='$comentId' LIMIT 1");
			//echo $comentId;
			$showComment = $this->db->query("SELECT * FROM comments WHERE msg_id_fk='$messageId' ORDER BY com_id ASC");
			echo '<ul style="padding: 0;margin:0;">';
			foreach($showComment->result_array() as $rowCom)
			{
				$comments = $rowCom['comment'];
				$com_id = $rowCom['com_id'];
				$usercom = $rowCom['uid_fk'];
				$created = $rowCom['created'];
				$usercomname = $this->db->query("SELECT * FROM users WHERE uid='$usercom' ORDER BY uid DESC LIMIT 1");
				foreach($usercomname->result_array() as $rowname)
				{
					$first_name = $rowname['first_name'];
					$profilePicTo = $rowname['profile_picture'];
				}
				$profilePicTo = str_replace(" ","_",$profilePicTo);
				if($profilePicTo == null)
				{
					$userPhoto = 'img/Default Profile Picture.jpg';
				}
				else
				{
					$userPhoto = 'uploads/'.$profilePicTo;
				}
				$websitepost = $this->db->query("SELECT * FROM websites WHERE user_id='$userPost' AND id='$webPost' ORDER BY id DESC LIMIT 1");
				$numWebsites = $websitepost->num_rows();
				if(($numWebsites > 0) OR ($usercom == $userPost))
				{
				/* 	echo '<li style="border-radius: 0 0 0 0;background: none repeat scroll 0 0 transparent;text-align: left;padding:0;margin:0;list-style: none;"><div style="border-bottom: 1px dashed #000000;width: 281px;">
												<div style="width: 36px;height: 36px;float: left;"><img src="'.base_url().'img/crop.php?w=36&h=36&f='.base_url().$userPhoto.'" style="width: 36px;" /></div>
												<div style="font-size: 12px;font-weight: bold;">'.$first_name.'<span style="cursor:pointer;float: right;font-weight: normal;" onclick="deleteComment(this, '.$com_id.', '.$messageId.')">X</span></div>
												<div style="width: 293px;height: auto;margin-left: 50px;font-size: 11px;">'.$comments.'</div>
												<div style="font-size: 10px; font-style: italic;color: #555553;">'.$this->times_model->makeAgo($created).'</div>
												</div>
												</li>'; */
						echo '<li style="list-style: none outside none;margin: 0;padding: 5px 5px 4px;margin-top: 1px;border-radius: 0 0 0 0;border-bottom: 1px inset;min-height: 38px;">
											<div style="line-height: 1.28;display: block;">
												<img src="'.base_url().$userPhoto.'" style="width: 36px;height:36px;margin-right: 8px;float: left;display: block;" />
												<a href="#" style="float: right;display: inline-block;" onclick="deleteComment(this, '.$com_id.', '.$messageId.')">x</a>
												<div style="padding-left:44px;color:#555555;">
												<a href="#">'.$first_name.'</a>
												<span style="font-size: 11px;word-wrap: break-word;">'.$comments.'</span>
												<div style="font-size: 10px;font-style: italic;padding-top: 2px;">'.$this->times_model->makeAgo($created).'</div>
												</div>
											</div>
											</li>';						
					
				}
				else
				{
					/* echo '<li style="border-radius: 0 0 0 0;background: none repeat scroll 0 0 transparent;text-align: left;padding:0;margin:0;list-style: none;"><div style="border-bottom: 1px dashed #000000;width: 281px;">
												<div style="width: 36px;height: 36px;float: left;"><img src="'.base_url().'img/crop.php?w=36&h=36&f='.base_url().$userPhoto.'" style="width: 36px;" /></div>
												<div style="font-size: 12px;font-weight: bold;">'.$first_name.'</div>
												<div style="width: 293px;height: auto;margin-left: 50px;font-size: 11px;">'.$comments.'</div>
												<div style="font-size: 10px; font-style: italic;color: #555553;">'.$this->times_model->makeAgo($created).'</div>
												</div>
												</li>'; */
												
						echo '<li style="list-style: none outside none;margin: 0;padding: 5px 5px 4px;margin-top: 1px;border-radius: 0 0 0 0;border-bottom: 1px inset;min-height: 38px;">
					<div style="line-height: 1.28;display: block;">
						<img src="'.base_url().$userPhoto.'" style="width: 36px;height:36px;margin-right: 8px;float: left;display: block;" />
						
						<div style="padding-left:44px;color:#555555;">
						<a href="#">'.$first_name.'</a>
						<span style="font-size: 11px;word-wrap: break-word;">'.$comments.'</span>
						<div style="font-size: 10px;font-style: italic;padding-top: 2px;">'.$this->times_model->makeAgo($created).'</div>
						</div>
					</div>
					</li>';
					
				}
				
			}
			echo '</ul>';
		}
		
		function testme2()
		{
			 $this->db->query("INSERT INTO shop (gallery_id, album_id, website) VALUES('12','12','12')");
		}
		
		function insert_rating()
		{
			$star = $_POST['star'];
			$product_id = $_POST['product_id'];
			$uid = $_POST['uid'];
			//echo $star.'>'.$product_id;
			$chkquery = $this->db->query("SELECT * FROM product_rating WHERE voter_ip='$uid' AND product_id='$product_id'");
			if($chkquery->num_rows() > 0)
			{
				echo 'you';
			}
			else
			{
				$this->db->query("INSERT INTO product_rating (product_id,rate,voter_ip) VALUES('$product_id','$star','$uid')");
				$query = $this->db->query("SELECT * FROM product_rating WHERE product_id='$product_id'");
				$total_votes = $query->num_rows();
				$starss = $this->db->query("SELECT * FROM product_rating WHERE product_id='$product_id' AND rate='$star'");
				echo $starss->num_rows();;
			}
		}
		
		function view_rating()
		{
			$product_id = $_POST['product_id'];
			$query = $this->db->query("SELECT * FROM product_rating WHERE product_id='$product_id'");
			$total_votes = $query->num_rows();
			$star1 = $this->db->query("SELECT * FROM product_rating WHERE product_id='$product_id' AND rate='1'");
			$star2 = $this->db->query("SELECT * FROM product_rating WHERE product_id='$product_id' AND rate='2'");
			$star3 = $this->db->query("SELECT * FROM product_rating WHERE product_id='$product_id' AND rate='3'");
			$star4 = $this->db->query("SELECT * FROM product_rating WHERE product_id='$product_id' AND rate='4'");
			$star5 = $this->db->query("SELECT * FROM product_rating WHERE product_id='$product_id' AND rate='5'");
			$votes_in_star1 = $star1->num_rows() * 1;
			$votes_in_star2 = $star2->num_rows() * 2;
			$votes_in_star3 = $star3->num_rows() * 3;
			$votes_in_star4 = $star4->num_rows() * 4;
			$votes_in_star5 = $star5->num_rows() * 5;
			
			$total_votes_in = $votes_in_star1 + $votes_in_star2 + $votes_in_star3 + $votes_in_star4 + $votes_in_star5;
			$vote_percent = $total_votes_in / $total_votes;
			
			echo round($vote_percent);
			
		}
		
		function checkProd()
		{
			$wantname = $_POST['prodName'];

			$query = $this->db->query("SELECT * FROM `products` WHERE `name` LIKE '$wantname'");
			if($query->num_rows() > 0)
			{
				echo 'meron';
			}
			else
			{
				echo 'wala';
			}
		}
		
		function webfollowers()
		{
			$wid = $_POST['wid'];
			$data['wid'] = $wid;
			$data['catalog_page'] = 1;
			$this->load->view('webfollowers', $data);
		}
		
		function blogcomment2()
		{
			$commentmsg =  $_POST['comm'];
			$msgId =  $_POST['msgId'];
			$wid = $_POST['wid'];
			$userdata =  $this->session->userdata('uid');
			$time = time();
			
			$this->db->where('uid',$this->session->userdata('uid'));
			$this->db->order_by('uid','desc');
			$this->db->limit(1);
			$usercomname = $this->db->get('users');			
			$theresult = $usercomname->row_array();

			if(isset($theresult['profile_picture'])) {
				$userPhoto = 'uploads/'.$this->session->userdata('uid').'/medium/' . str_replace(" ", "_", $theresult['profile_picture']);
			} else {
				$userPhoto = 'http://www.placehold.it/164x164/333333/ffffff&text=no+photo';
			}

			echo  '
			<li style="color:#898989 width: 75px; height: 75px;">
				<img class="pull-left" style="width: 32px; height: 32px; background-image: url('.base_url().$userPhoto.'); background-size: cover;" /><span><h6 style="margin-left: 35px;">'.$theresult['name'].' <span class="muted" style="font-weight: normal;font-size: 11px;margin-left: 13px;">'.date('F j, Y g:i:s a', $time).'</span></h6></span>
				<p style="font-size: 11px;border: 1px solid lightGrey;padding: 6px;margin-top: 18px;color: #525252;">'.$commentmsg.'</p>
			</li>';

			// /* insert to DB */
			$insert_array = array(
				'comment' => $commentmsg,
				'msg_id_fk' => $msgId,
				'uid_fk' => $this->session->userdata('uid'),
				'created' => $time,
				'type' => 'blog'
			);
			$this->db->insert('comments', $insert_array);			
			$newinsertid = $this->db->insert_id();
			
			/* for notification */
			$websiteUser = "SELECT `user_id` FROM websites WHERE id='".$wid."' ";
			$webuser = $this->db->query("SELECT * FROM users where uid = ($websiteUser)");
			$rowUser = $webuser->row_array();
			$status = 1;
			$action = 'blog';
			$times = time();
			if($rowUser['uid'] != $userdata)
			{
				/* notify post owner */
				$returns = 'reply to owner';
				$flagQuery = $this->db->query("INSERT INTO flag (uid, website_id, status, notify, action, time, msg_id, page_id, callback) VALUES('".$userdata."','".$wid."','".$status."','".$rowUser['uid']."','".$action."','".$times."','".$msgId."','".$pageRow['page_id']."','".$returns."')");
				
				/* check if other users also commented of post */
				$querycomment = $this->db->query("SELECT DISTINCT msg_id_fk,uid_fk FROM comments WHERE msg_id_fk = ".$msgId." AND uid_fk != ".$this->session->userdata('uid')." ");
				if($querycomment->num_rows() > 0)
				{
					foreach($querycomment->result_array() as $rowComment)
					{
						if($rowComment['uid_fk'] != $rowUser['uid'])
						{
							$return_other = 'reply to other';
							$this->db->query("INSERT INTO flag (uid, website_id, status, notify, action, time, msg_id, page_id, callback) VALUES('".$userdata."','".$wid."','".$status."','".$rowComment['uid_fk']."','".$action."','".$times."','".$msgId."','".$pageRow['page_id']."','".$return_other."')");
						}
					}
				}
			}else
			{
				$rQuery = $this->db->query("SELECT * FROM flag WHERE msg_id='".$msgId."' ");
				$rowR = $rQuery->row_array();
				if($rQuery->num_rows() > 0)
				{
					/* check if other users also commented of post */
					$querycomment = $this->db->query("SELECT DISTINCT msg_id_fk,uid_fk FROM comments WHERE msg_id_fk = ".$msgId." AND uid_fk != ".$this->session->userdata('uid')." ");
					if($querycomment->num_rows() > 0)
					{
						foreach($querycomment->result_array() as $rowComment)
						{
							if($rowComment['uid_fk'] != $rowUser['uid'])
							{
								$returns = 'reply';
								$flagQuery = $this->db->query("INSERT INTO flag (uid, website_id, status, notify, action, time, msg_id, callback, page_id) VALUES('".$rowUser['uid']."','".$wid."','".$status."','".$rowComment['uid_fk']."','".$action."','".$times."','".$msgId."','".$returns."','".$pageRow['page_id']."')");
							}
						}
					}
				}
			}			
		}
		
		function catalogcomment()
		{
			$commentmsg =  $_POST['commentmsg'];
			$type =  $_POST['type'];
			$commentmsg = htmlentities($commentmsg, ENT_QUOTES);
			$prodid =  $_POST['prodid'];
			$time = time();
			$site_id = $_POST['site_id'];
			$userPost = $this->session->userdata('uid');
			
			$this->db->where('id', $site_id);
			$this->db->where('deleted', 0);
			$querywebsite = $this->db->get('websites');
			$thewebsite = $querywebsite->row_array();
			
			$insert_array = array(
				'comment' => $commentmsg,
				'msg_id_fk' => $prodid,
				'uid_fk' => $this->session->userdata('uid'),
				'created' => $time,
				'type' => $type
			);
			$this->db->insert('comments', $insert_array);
			$newinsertid = $this->db->insert_id();
			
			$this->db->where('uid', $this->session->userdata('uid'));
			$this->db->order_by('uid','desc');
			$this->db->limit(1);
			$usercomname = $this->db->get('users');
			$theresult = $usercomname->row_array();
			$profilePicTo = str_replace(" ","_",$theresult['profile_picture']);
			
			/* for notification */
			$this->db->where('id', $prodid);
			$prodquery = $this->db->get('products')->row();
			// $resultprod = $prodquery->row_array();
			$websiteUser = "SELECT `user_id` FROM websites WHERE id='".$site_id."' ";
			$webuser = $this->db->query("SELECT * FROM users where uid = ($websiteUser)");
			$rowUser = $webuser->row_array();
			$status = 1;
			$action = 'product';
			$times = time();
			if($rowUser['uid'] != $userPost)
			{
				/* notify post owner */
				$returns = 'reply to owner';
				$flagQuery = $this->db->query("INSERT INTO flag (uid, website_id, status, notify, action, time, callback, prod_id, page_id) VALUES('".$userPost."','".$site_id."','".$status."','".$rowUser['uid']."','".$action."','".$times."','".$returns."','".$prodid."','".$prodquery->page_id."')");
				
				/* check if other users also commented of post */
				$querycomment = $this->db->query("SELECT DISTINCT msg_id_fk,uid_fk FROM comments WHERE msg_id_fk = ".$prodid." AND uid_fk != ".$this->session->userdata('uid')." ");
				if($querycomment->num_rows() > 0)
				{
					foreach($querycomment->result_array() as $rowComment)
					{
						if($rowComment['uid_fk'] != $rowUser['uid'])
						{
							$return_other = 'reply to other';
							$this->db->query("INSERT INTO flag (uid, website_id, status, notify, action, time, callback, prod_id, page_id) VALUES('".$userPost."','".$site_id."','".$status."','".$rowComment['uid_fk']."','".$action."','".$times."','".$return_other."','".$prodid."','".$prodquery->page_id."')");
						}
					}
				}
			}else
			{
				$rQuery = $this->db->query("SELECT * FROM flag WHERE prod_id='".$prodid."' ");
				$rowR = $rQuery->row_array();
				if($rQuery->num_rows() > 0)
				{
					/* check if other users also commented of post */
					$querycomment = $this->db->query("SELECT DISTINCT msg_id_fk,uid_fk FROM comments WHERE msg_id_fk = ".$prodid." AND uid_fk != ".$this->session->userdata('uid')." ");
					if($querycomment->num_rows() > 0)
					{
						foreach($querycomment->result_array() as $rowComment)
						{
							if($rowComment['uid_fk'] != $rowUser['uid'])
							{
								$returns = 'reply';
								$flagQuery = $this->db->query("INSERT INTO flag (uid, website_id, status, notify, action, time, callback, prod_id, page_id) VALUES('".$rowUser['uid']."','".$site_id."','".$status."','".$rowComment['uid_fk']."','".$action."','".$times."','".$returns."','".$prodid."','".$prodquery->page_id."')");
							}
						}
					}
				}
			}
			/* Notification end */
			if($profilePicTo == null)
			{
				$userPhoto = 'http://www.placehold.it/164x164/333333/ffffff&text=no+photo';
			}
			else
			{
				$userPhoto = 'uploads/'.$this->session->userdata('uid').'/medium/'.$profilePicTo;
			}
			if($thewebsite['user_id'] == $this->session->userdata('uid'))
			{
				$delete_span = '<span class="delete_comment" onclick="delete_category_comment(this)" id="'.$newinsertid.'">X</span>';
			}
			else
			{
				$delete_span = '';
			}
			echo '<li id="'.$newinsertid.'" class="del_'.$newinsertid.'">
					<i class="icon-remove icon-white pull-right del-feed-com" style="cursor:pointer;"></i>
					<div class="row-fluid" style="border-bottom: 1px solid #ddd;">
						<img class="pull-left" src="'.base_url().$userPhoto.'" style="height: 30px; width: 30px;" />
		
							<h6 style="margin-left: 35px;margin-top: 10px;margin-bottom: 0;">
								'.$theresult['name'].'
								<span class="muted" style="color: #ddd;">Says:</span>								
								<span class="muted pull-right" style="color: #ddd;">
									'.date('F j, Y g:i:s a',$time).'
								</span>
							</h6>
					</div>
						<p class="comment_header_name" style="padding: 10px 20px;">'.$commentmsg.'</p>
				</li>';			
			
			//echo $commentmsg.' '.$prodid.' '.$userdata.' '.$time;
		}
		
		function del_cat_comment()
		{
			$com_id = $_POST['com_id'];
			$this->db->query("DELETE FROM comments WHERE com_id='$com_id'");
		}
		
		function cartsession()
		{
			$table = $this->input->post('table');
			$selected_id = $this->input->post('id');

			$product_id = $_POST['product_id'];
			
			$thequery = $this->db->query("SELECT * FROM products WHERE id='$product_id'");
			$result = $thequery->row_array();
			
			/* variants */
			$v_id = 0;
			$v_type = '';
			$v_name = '';
			$v_price = 0;
			$v_qty = 0;
			
			if($table == 'variant')
			{
				$this->db->where('id',$selected_id);
				$var_query = $this->db->get('product_variants');
				$var_result = $var_query->row_array();
				$result['price'] = $var_result['price'];
				$result['stocks'] = $var_result['quantity'];
				
				$v_id = $var_result['id'];
				$v_type = $var_result['type'];
				$v_name = $var_result['name'];
				$v_price = $var_result['price'];
				$v_qty = $var_result['quantity'];
				
				$option_array = array(
					'v_id' => $selected_id,
					'v_type' => $v_type,
					'v_name' => $v_name,
					'v_price' => $v_price,
					'v_qty' => $v_qty
				);
			}
			
			
			$wasfound = false;
			if(isset($product_id))
			{
				$wasfound = false;
				$i = 0;
				$thecart = $this->cart->contents();
				
				if(empty($thecart))
				{
					$data = array(
							   'id'      => $product_id,
							   'qty'     => 1,
							   'price'   => $result['price'],
							   'name'    => $result['name']
							);
					if($table == 'variant')
					{
						$data['options'] = $option_array;
					}
					
					$this->cart->insert($data);
				}
				else
				{
					$variant_add = false;
					foreach($this->cart->contents() as $items)
					{
						if($items['id'] == $product_id) 
						{
							if($table == 'variant')
							{
								/* check if meron variants */
								if ($this->cart->has_options($items['rowid']) == TRUE)
								{
									$option = $this->cart->product_options($items['rowid']);
									if($option['v_id'] == $v_id)
									{
										$v_qty = $items['qty'];
										$ttlqty =  $v_qty + 1;
										if($ttlqty >= $result['stocks'])
										{
											$ttlqty = $result['stocks']; 
										}
										
										$thedata = array(
														'rowid' => $items['rowid'],
														'qty'   => $ttlqty
														);
										$this->cart->update($thedata);
										$variant_add = true;
									}
								}
								
								/* check if product has other variants */
								if($variant_add == false)
								{
									$data = array(
											   'id'      => $product_id,
											   'qty'     => 1,
											   'price'   => $result['price'],
											   'name'    => $result['name']
											);
									if($table == 'variant')
									{
										$data['options'] = $option_array;
									}
									$this->cart->insert($data);
								}
							}else
							{
								$ttlqty = $items['qty'] + 1;
								if($ttlqty >= $result['stocks'])
								{
									$ttlqty = $result['stocks']; 
								}
								
								$thedata = array(
												'rowid' => $items['rowid'],
												'qty'   => $ttlqty
												);
								$this->cart->update($thedata);
							}
							$wasFound = true;
						}
					}
					if($wasFound == false)
					{
						$data = array(
								   'id'      => $product_id,
								   'qty'     => 1,
								   'price'   => $result['price'],
								   'name'    => $result['name']
								);
						if($table == 'variant')
						{
							$data['options'] = $option_array;
						}
						$this->cart->insert($data);
					}
				}
				
				//$this->cart->destroy();
				
			}
			
			echo $this->cart->total_items();
		}

		function getcartitems()
		{
			$thecart = $this->cart->contents();
			$check_items = array();
			if(empty($thecart)){
				echo 0;
			}else{
				foreach($this->cart->contents() as $items){
					$this->db->where('id',$items['id']);
					$this->db->where('website_id',$this->input->post('wid'));
					$checkproduct = $this->db->get('products');
					if($checkproduct->num_rows() > 0){
						$check_items[] = 'meron';
					}else{
						$check_items[] = 'wala';
					}
				}
				if(in_array('wala', $check_items)){
					$this->cart->destroy();
					echo 0;
				}else{
					echo $this->cart->total_items();
				}
			}
		}
		
		function emptycart()
		{
			$this->cart->destroy();
		}
		
		function cartsubtotal()
		{
			$prod_id = $_POST['prod_id'];
			foreach($this->cart->contents() as $items)
			{
				if($items['id'] == $prod_id)
				{
					echo $this->cart->format_number($items['subtotal']);
				}
				
			}
		}
		
		function topcart()
		{
			$data['url'] = $this->input->post('urls');
			$this->load->view('topcart', $data);
		}
		
		function carttotal()
		{
			$thecart = $this->cart->contents();
			$check_items = array();
			if(empty($thecart)){
				echo $this->cart->format_number($this->cart->total());
			}else{
				foreach($this->cart->contents() as $items){
					$this->db->where('id',$items['id']);
					$this->db->where('website_id',$this->input->post('wid'));
					$checkproduct = $this->db->get('products');
					if($checkproduct->num_rows() > 0){
						$check_items[] = 'meron';
					}else{
						$check_items[] = 'wala';
					}
				}
				if(in_array('wala', $check_items)){
					$this->cart->destroy();
					echo 0;
				}else{
					echo $this->cart->format_number($this->cart->total());
				}
			}
		}
		
		function removecart()
		{
			$prod_id = $_POST['prod_id'];
			foreach($this->cart->contents() as $items)
			{
				if($items['id'] == $prod_id)
				{
					$thedata = array(
									'rowid' => $items['rowid'],
									'qty'   => 0
									);
					$this->cart->update($thedata);
					echo $this->cart->total_items();
				}
			} 
		}
		
		function updatecart()
		{
			
			$value = $_POST['value'];
			$cartid = $_POST['cartid'];
			$prod_id = $_POST['prod_id'];

			/* if product has a variants */
			if ($this->cart->has_options($cartid) == TRUE)
			{
				$option = $this->cart->product_options($cartid);
				if($value <= $option['v_qty'])
				{
					$thedata = array(
									'rowid' => $cartid,
									'qty'   => $value
									);
					$this->cart->update($thedata);
				}else
				{
					echo 'exceeded';
				}
			}else
			{
				/* get stock from products */
				$this->db->where('id',$prod_id);
				$query = $this->db->get('products');
				$row = $query->row_array();
				
				if($value <= $row['stocks'])
				{
					$thedata = array(
									'rowid' => $cartid,
									'qty'   => $value
									);
					$this->cart->update($thedata);
				}else
				{
					echo 'exceeded';
				}
			}
			
			
		}
		
		function viewcart()
		{
			$data['site_id'] = $_POST['site_id'];
			$data['page_url'] = $_POST['page_url'];
			$data['web_url'] = $_POST['web_url'];
			$product_id = $_POST['product_id'];
			
			$thequery = $this->db->query("SELECT * FROM products WHERE id='$product_id'");
			$result = $thequery->row_array();
			
			
			if(isset($product_id))
			{
				$wasfound = false;
				$i = 0;
				$thecart = $this->cart->contents();
				
				if(empty($thecart))
				{
					$data = array(
							   'id'      => $product_id,
							   'qty'     => 1,
							   'price'   => $result['price'],
							   'name'    => $result['name']
							);

					$this->cart->insert($data);
				}
				else
				{
					foreach($this->cart->contents() as $items)
					{
						if($items['id'] == $product_id)
						{
							$ttlqty = $items['qty'] + 1;
							if($ttlqty > $result['stocks'])
							{
								$ttlqty = $result['stocks']; 
							}
							
							$thedata = array(
											'rowid' => $items['rowid'],
											'qty'   => $ttlqty
											);
							$this->cart->update($thedata);
							$wasFound = true;
						}
					}
					if($wasFound == false)
					{
						$data = array(
								   'id'      => $product_id,
								   'qty'     => 1,
								   'price'   => $result['price'],
								   'name'    => $result['name']
								);
						$this->cart->insert($data);
					}
				}
				
				//$this->cart->destroy();
				
			}
			
			$this->load->view('cart',$data);
		}
		function checkdomain()
		{
			$wid = $_POST['web_id'];
			$domain = url_title($_POST['domainname'],'-',true);
			$thedomain = $domain.'.'.$_POST['ext'];
			$theext = $_POST['ext'];
			$ext_array = array('com','net','org','me','mobi','us','asia','biz','co','info');
				echo '
		<table class="table table-striped table-condensed table-bordered">
			<caption>List of domain</caption>
			<thead>
				<tr>
					<th>Domain Name</th>
					<th>Availability</th>
					<th>Amount</th>
					<th style="text-align:center;" colspan="2">Get this domain</th>
				</tr>
			</thead>
			<tbody>';
							
				foreach($ext_array as $ext){
					$thisdomain = $domain.'.'.$ext;
					if(checkdnsrr($thisdomain, 'ANY')){
						echo '<tr>
								<td>'.$thisdomain.'</td>
								<td>NOT available</td>
								<td style="text-decoration:line-through;">P875.00</td>
								<td></td>
								<td></td>
							</tr>';
					}else{						
						echo '<tr>
							<td><strong>'.$thisdomain.'</strong></td>
							<td>Available</td>
							<td>P875.00</td>
							<td>
								<form action="https://www.paypal.com/cgi-bin/webscr" method="post" style="margin-bottom: 0;">
								<input type="hidden" name="cmd" value="_cart">
								<input type="hidden" name="upload" value="1">
								<input type="hidden" name="business" value="henryc_1353585423_per@gmail.com">
								<input type="hidden" name="item_name_1" value="'.$thisdomain.'">
								<input type="hidden" name="amount_1" value="875.76">
								<input type="hidden" name="quantity_1" value="1">
								<input type="hidden" name="custom" value="'.$thisdomain.'">
								<input type="hidden" name="return" value="'.base_url().'manage/webeditor?wid='.$wid.'&paypal=domainpaid">
								<input type="hidden" name="notify_url" value="'.base_url().'multi/paypal_ipn_domain">
								<input type="hidden" name="rm" value="2">
								<input type="hidden" name="cbt" value="Return to The Store">
								<input type="hidden" name="cancel_return" value="'.base_url().'manage/webeditor?wid='.$wid.'">
								<input type="hidden" name="lc" value="PH">
								<input type="hidden" name="currency_code" value="PHP">
								<input type="image" src="http://www.paypal.com/en_US/i/btn/x-click-but01.gif" name="submit" alt="Make payments with PayPal - its fast, free and secure!">
								</form>
							</td>
							<td>Dragonpay</td>
						</tr>';
					}
				}
				echo '</tbody>
				</table>
				';
		}
		
		function paypal_ipn_domain()
		{
			$raw_post_data = file_get_contents('php://input');
			$raw_post_array = explode('&', $raw_post_data);
			$myPost = array();
			foreach ($raw_post_array as $keyval) {
			  $keyval = explode ('=', $keyval);
			  if (count($keyval) == 2)
				 $myPost[$keyval[0]] = urldecode($keyval[1]);
			}
			// read the post from PayPal system and add 'cmd'
			$req = 'cmd=_notify-validate';
			if(function_exists('get_magic_quotes_gpc')) {
			   $get_magic_quotes_exists = true;
			} 
			foreach ($myPost as $key => $value) {        
			   if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) { 
					$value = urlencode(stripslashes($value)); 
			   } else {
					$value = urlencode($value);
			   }
			   $req .= "&$key=$value";
			}
			 
			 
			// STEP 2: Post IPN data back to paypal to validate
			 
			$ch = curl_init('https://www.paypal.com/cgi-bin/webscr');
			curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
			curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
			 
			// In wamp like environments that do not come bundled with root authority certificates,
			// please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set the directory path 
			// of the certificate as shown below.
			// curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . '/cacert.pem');
			if( !($res = curl_exec($ch)) ) {
				// error_log("Got " . curl_error($ch) . " when processing IPN data");
				curl_close($ch);
				exit;
			}
			curl_close($ch);
			 
			 
			// STEP 3: Inspect IPN validation result and act accordingly
			 
			if (strcmp ($res, "VERIFIED") == 0) {
				
				$mc_fee = $_POST['mc_fee'];
				$payer_id = $_POST['payer_id'];
				$mc_currency = $_POST['mc_currency'];
				$verify_sign = $_POST['verify_sign'];
				$notify_version = $_POST['notify_version'];
				$address_status = $_POST['address_status'];
				$address_country = $_POST['address_country'];
				$address_zip = $_POST['address_zip'];
				$address_state = $_POST['address_state'];
				$address_city = $_POST['address_city'];
				$address_street = $_POST['address_street'];
				$payer_status = $_POST['payer_status'];
				$txn_type = $_POST['txn_type'];
				$payment_status = $_POST['payment_status'];
				$payment_type = $_POST['payment_type'];
				$payment_currency = $_POST['payment_currency'];
				$mc_gross = $_POST['mc_gross'];
				$payment_date = $_POST['payment_date'];
				$last_name = $_POST['last_name'];
				$first_name = $_POST['first_name'];
				$txn_id = $_POST['txn_id'];
				$payer_email = $_POST['payer_email'];
				$custom = $_POST['custom'];
				$time = time();
				// Place the transaction into the database
				$insertdata = array(
					'payer_email' => $payer_email,
					'first_name' => $first_name,
					'last_name' => $last_name,
					'payment_date' => $payment_date,
					'mc_gross' => $mc_gross,
					'payment_currency' => $payment_currency,
					'txn_id' => $txn_id,
					'receiver_email' => $receiver_email,
					'payment_status' => $payment_status,
					'txn_type' => $txn_type,
					'payer_status' => $payer_status,
					'address_street' => $address_street,
					'address_city' => $address_city,
					'address_state' => $address_state,
					'address_country' => $address_country,
					'address_status' => $address_status,
					'notify_version' => $notify_version,
					'verify_sign' => $verify_sign,
					'payer_id' => $payer_id,
					'mc_currency' => $mc_currency,
					'product_id_array' => $custom,
					'payment_type' => 'domain',
					'mc_fee' => $mc_fee
				);
				// $this->db->where('id',$ids);
				//$this->db->insert('transactions',$insertdata);	
			$this->db->query("INSERT INTO transactions (payer_email,first_name,last_name,payment_date,mc_gross,payment_currency,txn_id,receiver_email,payment_status,txn_type,payer_status,address_street,address_city,address_state,address_country,address_status,notify_version,verify_sign,payer_id,mc_currency,product_id_array,payment_type,mc_fee) VALUES('$payer_email','$first_name','$last_name','$payment_date','$mc_gross','$payment_currency','$txn_id','$receiver_email','$payment_status','$txn_type','$payer_status','$address_street','$address_city','$address_state','$address_country','$address_status','$notify_version','$verify_sign','$payer_id','$mc_currency','$custom','domain','$mc_fee')");				
				
				
				
			} else if (strcmp ($res, "INVALID") == 0) {
				// log for manual investigation
			}
		}
		
		function createdomain()
		{
			$user = 'henryblinds';
			$key = 'faa03947cd5141af8c942975b55113c8';
			$islive = 0;
			$ip = '192.168.1.120';
			$url = 'https://api.sandbox.namecheap.com/xml.response?ApiUser='.$user.'&ApiKey='.$key.'&UserName='.$user.'&Command=namecheap.domains.check&ClientIp='.$ip.'&DomainList='.$domain;
			//$xml = file_get_contents($url);
			//$data = new SimpleXMLElement($xml);

			//$thexml = simplexml_load_string($xml);
			
			$resp = array();
			$xml = simplexml_load_string(file_get_contents($url));
			$status = $xml['Status'];		
			if($status == "OK")
			{
				//print_r($xml->CommandResponse->DomainCheckResult);
				
				$theresult = $xml->CommandResponse->DomainCheckResult;
				foreach($theresult as $row)
				{
					if($theresult['Available'] == 'false')
					{
						echo '<p style="font-size: 23px;font-family: century gothic;">This <strong>'.$theresult['Domain'].'</strong> is <span style="color:red;">not available</span>.</p>';
					}
					else
					{
						echo '<p style="font-size: 23px;font-family: century gothic;">This <strong>'.$theresult['Domain'].'</strong> is <span style="color:green;">available</span>.</p>';
					}
				}
			}
			else
			{
				$response = '';
				foreach ($xml->Errors->Error as $error)
				{
					echo $response.$error."<br/>";
				}
			}
		}
		
		function recordpaypal()
		{
			$user_id = $_POST['user_id'];
			$email = $_POST['email'];
			//echo $user_id.'>>'.$email;
			$thequer = $this->db->query("SELECT * FROM paypal_account WHERE user_id='$user_id'");
			if($thequer->num_rows() > 0)
			{
				$this->db->query("UPDATE paypal_account SET paypal_email='$email' WHERE user_id='$user_id'");
			}
			else
			{
				$this->db->query("INSERT INTO paypal_account (user_id, paypal_email) VALUES('$user_id','$email')");
			}
		}
		
		function paypal_ipn()
		{
			$raw_post_data = file_get_contents('php://input');
			$raw_post_array = explode('&', $raw_post_data);
			$myPost = array();
			foreach ($raw_post_array as $keyval) {
			  $keyval = explode ('=', $keyval);
			  if (count($keyval) == 2)
				 $myPost[$keyval[0]] = urldecode($keyval[1]);
			}
			// read the post from PayPal system and add 'cmd'
			$req = 'cmd=_notify-validate';
			if(function_exists('get_magic_quotes_gpc')) {
			   $get_magic_quotes_exists = true;
			} 
			foreach ($myPost as $key => $value) {        
			   if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) { 
					$value = urlencode(stripslashes($value)); 
			   } else {
					$value = urlencode($value);
			   }
			   $req .= "&$key=$value";
			}
			 
			 
			// STEP 2: Post IPN data back to paypal to validate
			 
			$ch = curl_init('https://www.paypal.com/cgi-bin/webscr');
			curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
			curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
			 
			// In wamp like environments that do not come bundled with root authority certificates,
			// please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set the directory path 
			// of the certificate as shown below.
			// curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . '/cacert.pem');
			if( !($res = curl_exec($ch)) ) {
				// error_log("Got " . curl_error($ch) . " when processing IPN data");
				curl_close($ch);
				exit;
			}
			curl_close($ch);
			 
			 
			// STEP 3: Inspect IPN validation result and act accordingly
			 
			if (strcmp ($res, "VERIFIED") == 0) {
				
				$mc_fee = $_POST['mc_fee'];
				$payer_id = $_POST['payer_id'];
				$mc_currency = $_POST['mc_currency'];
				$verify_sign = $_POST['verify_sign'];
				$notify_version = $_POST['notify_version'];
				$address_status = $_POST['address_status'];
				$address_country = $_POST['address_country'];
				$address_zip = $_POST['address_zip'];
				$address_state = $_POST['address_state'];
				$address_city = $_POST['address_city'];
				$address_street = $_POST['address_street'];
				$payer_status = $_POST['payer_status'];
				$txn_type = $_POST['txn_type'];
				$payment_status = $_POST['payment_status'];
				$payment_type = $_POST['payment_type'];
				$payment_currency = $_POST['payment_currency'];
				$mc_gross = $_POST['mc_gross'];
				$payment_date = $_POST['payment_date'];
				$last_name = $_POST['last_name'];
				$first_name = $_POST['first_name'];
				$txn_id = $_POST['txn_id'];
				$payer_email = $_POST['payer_email'];
				$custom = $_POST['custom'];
				$time = time();
				
				/* Place the transaction into the database */
				$ids = $result['id'];
				$updatedata = array(
					'paypal_txn_id' => $txn_id,
					'payment_status' => 'paid'
				);
				
				$this->db->where('txn_id',$custom);
				$this->db->update('transactions_detail',$updatedata);				
				
				
				
			} else if (strcmp ($res, "INVALID") == 0) {
				// log for manual investigation
			}
		}
		
		function recorddomain()
		{
			$user = 'henryblinds';
			$key = 'faa03947cd5141af8c942975b55113c8';
			$islive = 0;
			$ip = '192.168.1.120';
			
			
			$web_id = $_POST['web_id'];
			$domain = $_POST['domain'];
			$years = $_POST['years'];
			$fname = $_POST['fname'];
			$lname = $_POST['lname'];
			$email = $_POST['email'];
			$address = $_POST['address'];
			$province = $_POST['province'];
			$postal = $_POST['postal'];
			$country = $_POST['country'];
			$phone = $_POST['phone'];
			$name = $fname.' '.$lname;
			$time = time();
			//echo $domain.'>>'.$years.'>>'.$email.'>>'.$name.'>>'.$address.'>>'.$province.'>>'.$postal.'>>'.$country.'>>'.$phone.'>>'.$time;
			//$url = 'https://api.sandbox.namecheap.com/xml.response?ApiUser=henryblinds&ApiKey=faa03947cd5141af8c942975b55113c8&UserName=henryblinds&Command=namecheap.domains.create&ClientIp=112.205.62.176&DomainName='.$domain.'&Years=1&AuxBillingFirstName='.$fname.'&AuxBillingLastName='.$lname.'&AuxBillingAddress1='.$address.'&AuxBillingStateProvince=PH&AuxBillingPostalCode=12345&AuxBillingCountry=PH&AuxBillingPhone=+1.6613102107&AuxBillingEmailAddress='.$email.'&AuxBillingOrganizationName=NC&AuxBillingCity=California&TechFirstName='.$fname.'&TechLastName='.$lname.'&TechAddress1=notentered&TechStateProvince=PH&TechPostalCode=12345&TechCountry=PH&TechPhone=+1.6613102107&TechEmailAddress='.$email.'&TechOrganizationName=NC&TechCity=Philippines&AdminFirstName='.$fname.'&AdminLastName='.$lname.'&AdminAddress1=notentered&AdminStateProvince=PH&AdminPostalCode=12345&AdminCountry=PH&AdminPhone=+1.6613102107&AdminEmailAddress='.$email.'&AdminOrganizationName=NC&AdminCity=Philippines&RegistrantFirstName='.$fname.'&RegistrantLastName='.$lname.'&RegistrantAddress1='.$address.'&RegistrantStateProvince=PH&RegistrantPostalCode=12345&RegistrantCountry=PH&RegistrantPhone=+1.6613102107&RegistrantEmailAddress='.$email.'&RegistrantOrganizationName=NC&RegistrantCity=Philippines&RegistrantNexus=C11&RegistrantNexusCountry=In&RegistrantPurpose=P1';
			$url = 'https://api.sandbox.namecheap.com/xml.response?ApiUser=henryblinds&ApiKey=faa03947cd5141af8c942975b55113c8&UserName=henryblinds&Command=namecheap.domains.create&ClientIp=112.205.62.176&DomainName='.$domain.'&Years=1&AuxBillingFirstName='.$fname.'&AuxBillingLastName='.$lname.'&AuxBillingAddress1=malvarst&AuxBillingStateProvince=PH&AuxBillingPostalCode=12345&AuxBillingCountry=PH&AuxBillingPhone=+1.6613102107&AuxBillingEmailAddress=henryblinds009@gmail.com&AuxBillingOrganizationName=NC&AuxBillingCity=California&TechFirstName='.$fname.'&TechLastName='.$lname.'&TechAddress1=notentered&TechStateProvince=PH&TechPostalCode=12345&TechCountry=PH&TechPhone=+1.6613102107&TechEmailAddress=henryblinds009@gmail.com&TechOrganizationName=NC&TechCity=Philippines&AdminFirstName='.$fname.'&AdminLastName='.$lname.'&AdminAddress1=notentered&AdminStateProvince=PH&AdminPostalCode=12345&AdminCountry=PH&AdminPhone=+1.6613102107&AdminEmailAddress=henryblinds009@gmail.com&AdminOrganizationName=NC&AdminCity=Philippines&RegistrantFirstName='.$fname.'&RegistrantLastName='.$lname.'&RegistrantAddress1=malvarst&RegistrantStateProvince=PH&RegistrantPostalCode=12345&RegistrantCountry=PH&RegistrantPhone=+1.6613102107&RegistrantEmailAddress=henryblinds009@gmail.com&RegistrantOrganizationName=NC&RegistrantCity=Philippines&RegistrantNexus=C11&RegistrantNexusCountry=In&RegistrantPurpose=P1';
			$thequery = $this->db->query("SELECT * FROM domainlist WHERE web_id='$web_id' OR domain='$domain'");
			if($thequery->num_rows() > 0)
			{
				echo 'domain_exist';
			}
			else
			{
				
				$resp = array();
				$xml = simplexml_load_string(file_get_contents($url));
				$status = $xml['Status'];		
				if($status == "OK")
				{
					//print_r($xml->CommandResponse->DomainCheckResult);
					
					$theresult = $xml->CommandResponse->DomainCreateResult;
					foreach($theresult as $row)
					{
						if($theresult['Registered'] == 'false')
						{
							echo 'hindi';
						}
						else
						{
							echo 'nagawa';
							$this->db->query("INSERT INTO domainlist (domain,years,name,email,address,province,postal,country,phone,date_added,web_id) VALUES('$domain','$years','$name','$email','$address','$province','$postal','$country','$phone','$time','$web_id')");
						}
					}
				}
				else
				{
					$response = '';
					foreach ($xml->Errors->Error as $error)
					{
						echo $response.$error;
					}
				}
			
			}
			
		}
		
		function transactions()
		{
			if($this->session->userdata('logged_in')) {
				$data['activemenu'] = 'transactions';
				$data['sidebar'] = $this->load->view('dashboard/sidebar', $data, true);
				$data['content'] = $this->load->view('transactions_details', '', true);
				
				$data2home['bar_holder'] = $this->load->view('bar_holder', $data, true);
				$data2home['body'] = $this->load->view('manage_account', $data, true);
				$data2home['footer'] = '';
				
				$this->load->view('dashboard/template', $data2home);
			} else {
				redirect(base_url());
			}
		}
		
		function costumeremail()
		{
			$emasil = $_POST['emasil'];
			$csracc = $_POST['csracc'];
			$queryone = $this->db->query("SELECT * FROM costumer WHERE email='$emasil'");
			if($queryone->num_rows() > 0)
			{				
				if($csracc != 'update')
				{
					echo 'email_exist';
				}
			}
		}
		
		function recordcostumer()
		{
			$acctype1 = $_POST['acctype'];
			$acctype = '0';
			$country_id = $_POST['country_id'];
			$postal = $_POST['postal'];
			$city = $_POST['city'];
			$add2 = $_POST['add2'];
			$add1 = $_POST['add1'];
			$pass1 = $_POST['pass1'];
			$fax = $_POST['fax'];
			$telephone = $_POST['telephone'];
			$emasil = $_POST['emasil'];
			$lname = $_POST['lname'];
			$fname = $_POST['fname'];
			$csracc = $_POST['csracc'];
			$time = time();
			//echo 'mabuhay';
			if($acctype1 == 'myacc')
			{
				$acctype = '0';
			}
			if($acctype1 == 'reg')
			{
				$acctype = '1';
			}
			if($acctype1 == 'guest')
			{
				$acctype = '2';
			}
			$queryone = $this->db->query("SELECT * FROM costumer WHERE email='$emasil'");
			if($queryone->num_rows() > 0)
			{
				// echo 'email_exist';
				$res = $queryone->row_array();
				$cruid = $res['id'];
				if($csracc == 'update')
				{
					$this->db->query("UPDATE costumer SET fname='$fname',lname='$lname',email='$emasil',telephone='$telephone',fax='$fax',address1='$add1',address2='$add2',city='$city',postal='$postal',country='$country_id' WHERE id='$cruid'");
				}
			}
			else
			{
				$querytwo = $this->db->query("INSERT INTO costumer (date_added,fname,lname,email,telephone,fax,password,address1,address2,city,postal,country,account_type) VALUES('$time','$fname','$lname','$emasil','$telephone','$fax','$pass1','$add1','$add2','$city','$postal','$country_id','$acctype')");
			}
			
			echo $add1.' '.$city.','.$country_id;
		}
		
		function confirm_orders()
		{
			$uid = $this->session->userdata('uid');
			$logged_in = $this->session->userdata('logged_in');
			$acctype = $_POST['acctype'];
			$emasil = $_POST['emasil'];
			$weburl = $_POST['weburl'];
			$txn_ci = $_POST['txn_id'];
			$wheredeliver = $_POST['wheredeliver'];
			$fname = $_POST['fname'];
			$lname = $_POST['lname'];
			$ip = $this->input->ip_address();
			$totalamount = str_replace(',','',$_POST['totalamount']);
			$devdetails = $_POST['devdetails'];
			$delmethod = $_POST['delmethod'];
			$payopt = $_POST['payopt'];
			$pay_comment = $_POST['pay_comment'];
			$del_comment = $_POST['del_comment'];
			$payment_currency = 'PHP';
			$txn_id = '';
			$payment_type = '';
			$href = '';
			$time = time();
			$prod_array = '';
			// echo "'$wheredeliver','$emasil','$devdetails','$delmethod','$payopt','$del_comment','$pay_comment','$prod_array','$time','$txn_ci')";
			foreach($this->cart->contents() as $items)
			{
				$theprid = $items['id'];
				$theprqty = $items['qty'];
				$thisquery_pr = $this->db->query("SELECT * FROM `products` WHERE `id`='$theprid'");
				$result = $thisquery_pr->row_array();
				$stoksmen = $result['stocks'] - $theprqty;
				$this->db->query("UPDATE `products` SET `stocks`='$stoksmen' WHERE `id`='$theprid'");
				$prod_array .= $items['id'].'-'.$items['qty'].',';
			}
			$totalamount = number_format($totalamount,2);
			// echo $devdetails;
			
			$this->db->query("INSERT INTO confirm_orders (ship_delivery, costumers_email, del_details, del_method, payopt, del_com, pay_com, prod_array, date_confirmed, txn_ci) VALUES('$wheredeliver','$emasil','$devdetails','$delmethod','$payopt','$del_comment','$pay_comment','$prod_array','$time','$txn_ci')");
			$txnid2 = $this->db->insert_id();
			$txnid = $txnid2.$time;
			$txn_id = strtoupper(substr(md5($txnid), 0, 17));
			
			if($payopt == 'pp')
			{
				$ip = $this->input->ip_address();
				$this->db->query("INSERT INTO transactions (ip_address, txn_id, product_id_array) VALUES('$ip','$txn_ci','$prod_array')");				
			}
				
				
			if($payopt == 'cod')
			{
				$payment_type = 'cod';
				$insert_to_transaction = $this->db->query("INSERT INTO transactions (product_id_array,payer_email,first_name,last_name,payment_date,mc_gross,payment_currency,txn_id,payment_type,address_street,payment_status) VALUES('$prod_array','$emasil','$fname','$lname','$time','$totalamount','$payment_currency','$txn_id','$payment_type','$devdetails','$delmethod')");
				$this->db->query("UPDATE confirm_orders SET txn_id='$txn_id' WHERE id='$txnid2'");
			}
			
			if($payopt == 'dp')
			{
				$payment_type = 'dp';
				$this->db->query("UPDATE confirm_orders SET txn_id='$txn_id' WHERE id='$txnid2'");
				$insert_to_transaction = $this->db->query("INSERT INTO transactions (product_id_array,payer_email,first_name,last_name,payment_date,mc_gross,payment_currency,txn_id,payment_type,address_street,payment_status) VALUES('$prod_array','$emasil','$fname','$lname','$time','$totalamount','$payment_currency','$txn_id','$payment_type','$devdetails','$delmethod')");
				
				$dpamount = $totalamount;
				$dpamount2 = str_replace(',','',$dpamount);
				$dpdescription = 'payments';
				$dpcostumer_email = "$emasil";
				// $param1 = base_url().'cart?t=success&s='.$weburl;
				$param1 = $weburl;
				$param2 = '';
				$digestvar = "BOLOOKA:$txn_id:$dpamount2:PHP:$dpdescription:$dpcostumer_email:Sz$4Qm2Vt";
				// $digestvar = "BOLOOKA:$txn_id:654813.00:PHP:payments:hbg_009@ymail.com:Sz$4Qm2Vt";
				$dpdigest = sha1($digestvar);					
				$href = "http://test.dragonpay.ph/Pay.aspx?merchantid=BOLOOKA&txnid=$txn_id&amount=$dpamount&ccy=PHP&description=$dpdescription&email=$dpcostumer_email&digest=$dpdigest&param1=$param1";
				echo $href;
			} 
		
		}
		
		function costumerlogout()
		{
			$this->session->unset_userdata('costumer_usrid');
			$this->session->unset_userdata('costumer_name');
		}
		
		function costumerlogin()
		{
			$email = $_POST['cos_email'];
			$password = $_POST['cos_pass'];
			
			$chk_query = $this->db->query("SELECT * FROM costumer WHERE email='$email' AND password='$password' ORDER BY id LIMIT 1");
			if($chk_query->num_rows() > 0)
			{
				$result = $chk_query->row_array();
				$email = $result['email'];
				$fname = $result['fname'];
				$lname = $result['lname'];
				$id = $result['id'];
				$this->session->set_userdata('costumer_usrid',$id);
				$this->session->set_userdata('costumer_name',$fname);
				
			}
			else
			{
				echo 'wrong';
			}
		}
		
		function checkout_success()
		{
			$product=null;
			$product_id=null;	
			$theparam1 = null;	
			$dragonpay = false;
			if(isset($_GET['param1'])){
				$theparam1 = $_GET['param1'];
			}
			
			if(!empty($theparam1)){
				$carttype = 'success';
				$web = $_GET['param1'];
				$dragonpay = true;
				$data['dragonpay'] = $dragonpay;
				//echo 'a';
			}else{
				$data['dragonpay'] = $dragonpay;
				//echo 'b';
				if(!isset($_GET['s'])){
					show_404();
				}else{
					$carttype = $_GET['t'];
					$web = $_GET['s'];
				}
				if(isset($_GET['log'])){
					if($_GET['log'] == 'guest'){
						$data['log_in'] = true;
					}else{
						$data['log_in'] = false;
					}					
				}else{
					$data['log_in'] = $this->session->userdata('logged_in');
				}
			}
			$web = urldecode($web);
			$this->db->where('url', url_title($web));
			$this->db->where('deleted', 0);
			$query = $this->db->get('websites');
			
			$row = $query->row_array();
			
			 if($row){
				$data['site_id'] = $row['id'];
				$data['site_name'] = $row['site_name'];
				$data['url'] = $row['url'];
				$data['background'] = $row['background'];
				$data['layout'] = $row['layout'];
				$data['description'] = $row['description'];
				
				$this->db->where('website_id', $row['id']);
				if($this->db->field_exists('page_seq', 'pages')) {
					$this->db->order_by('page_seq');
				} else {
					$this->db->order_by('order');
				}
				$queryPage = $this->db->get('pages');
				
				if($queryPage->num_rows() == 0)
				{
					$this->db->where('website_id', $row['id']);
					$queryPage = $this->db->get('pages');
				}
				
				$data['pages'] = $queryPage->row_array();

				$data['wid'] = $data['pages']['website_id'];
				$data['pid'] = $data['pages']['id'];
				
				//get page name and sitename
				$this->db->where('id', $data['pages']['website_id']);
				$this->db->where('deleted', 0);
				$queryWebs = $this->db->get('websites');
				$resultWebs = $queryWebs->row_array();
				
				$data['page_url'] = $data['pages']['url'];
				$data['page_name'] = $data['pages']['name']; 
				$data['web_url'] = $resultWebs['url']; 
				$data['product'] = null; 
				$data['product_id'] = null; 
				$data['page_type'] = 'catalogue';
				$data['page_name'] = $data['pages']['name'];
				$data['activepage'] = $data['pages']['id'];
				$data['carttype'] = $carttype;
				switch ($carttype)
				{
					case 'success':
						//destroy cart items
						$this->cart->destroy();
						$data['content'] = $this->load->view('cart', $data, TRUE);
						// $data['content'] = $this->load->view('checkout_success', $data, TRUE);
					break;
					case 'yourcart':
						$data['content'] = $this->load->view('cart', $data, TRUE);
					break;
					case 'checkout':
						$data['content'] = $this->load->view('checkout', $data, TRUE);
					break;
					case 'step4':
						$data['content'] = $this->load->view('checkout', $data, TRUE);
					break;
				}
				
				/* get background design */
				$this->db->where('website_id', $data['wid']);
				$queryDesc = $this->db->get('design');
				$data['bg'] = $queryDesc->row();
				/* */
				
				/* get logo settings */
				$this->db->where('website_id', $data['wid']);
				$queryLogo = $this->db->get('logo');
				if ($queryLogo->num_rows() == '0') {
					$queryAdd = "INSERT INTO `logo` (`website_id`) VALUES ('".$data['wid']."')";
					$this->db->query($queryAdd);
				} else {
					$logo = $queryLogo->row();
				}
				$this->db->where('website_id', $data['wid']);
				$queryLogo = $this->db->get('logo');
				$data['logo'] = $queryLogo->row();
				/* */
				
				/* get footer settings */
				$this->db->where('website_id', $data['wid']);
				$qFooter = $this->db->get('footer');
				$data['footer'] = $qFooter->row();			
				/* */
				
				$data['activepid'] = $data['activepage'];
				$data['menu_over'] = $data['bg']->menu_over;
				$data['align'] = 'class="horizontal"';
				if($data['layout'] == 'layout1' || $data['layout'] == 'layout2') {
					$data['menu'] = $this->load->view('templates/menu.php', $data, true);
				}
				if($data['layout'] == 'layout3' || $data['layout'] == 'layout4') {
					$data['menu'] = $this->load->view('templates/menu3.php', $data, true);
				}
				if($data['layout'] == 'layout5' || $data['layout'] == 'layout6') {
					$data['menu'] = $this->load->view('templates/menu6_5.php',$data, true);
				}

				/* for cart holder */
				$this->load->model('cart_model');
				$data['items_cart'] = $this->cart_model->getcartitems($data['wid']);
				$data['c_total'] = $this->cart_model->carttotal($data['wid']);
				$data['holder'] = $this->load->view('holder', $data, true);
				/* */
			
				$data2template['site_id'] = $row['id'];
				$data2template['body'] = $this->load->view('templates/'.$row['layout'], $data, true);
				$this->load->view('templates/layout', $data2template);
			}
			else
			{
				show_404();
			}
		}
		
		function trans_info()
		{
			$txn_id = $_POST['txnid'];
			$data['txn_id'] = $txn_id;
			$this->load->view('trans_info', $data);
		}
		
		function trans_status()
		{
			$txn_id = $_POST['txnid'];
			$data['txn_id'] = $txn_id;
			$this->load->view('trans_status',$data);
		}
		
		function save_ship()
		{
			$ship = $_POST['ship'];
			$txnid = $_POST['txnid'];
			if($ship == 1)
			{
				$ship = 'Yes';
			}
			else
			{
				$ship = 'No';
			}
			$this->db->query("UPDATE confirm_orders SET delivery_status='$ship' WHERE txn_id='$txnid'");
		}
		
		function save_order_status()
		{
			$del_status = $_POST['del_status'];
			$pay_status = $_POST['pay_status'];
			$txn = $_POST['txn'];
			$this->db->query("UPDATE confirm_orders SET payment_status='$pay_status', delivery_status='$del_status' WHERE txn_id='$txn'");
		}
		
		function xendcreatewaybill()
		{
			$txnid = $_POST['txnid'];
			$waybill = $_POST['waybill'];
			$this->db->query("UPDATE `confirm_orders` SET `waybill`='$waybill' WHERE txn_id='$txnid'");
		}
		
		function xendcreate()
		{
			$description = $_POST['description'];
			$xendservice = $_POST['xendservice'];
			$txnid = $_POST['txnid'];
			$query = $this->db->query("SELECT * FROM confirm_orders WHERE txn_id='$txnid'");
			$result = $query->row_array();
			$costumeremail = $result['costumers_email'];
			$query2 = $this->db->query("SELECT * FROM costumer WHERE email='$costumeremail'");
			$theresult = $query2->row_array();
			$data['description'] = $description;
			$data['xendservice'] = $xendservice;
			$data['fname'] = $theresult['fname'];
			$data['lname'] = $theresult['lname'];
			$data['email'] = $theresult['email'];
			$data['telephone'] = $theresult['telephone'];
			$data['address1'] = $theresult['address1'];
			$data['address2'] = $theresult['address2'];
			$data['city'] = $theresult['city'];
			$data['postal'] = $theresult['postal'];
			$data['country'] = $theresult['country'];
			$this->load->view('xendcreate', $data);
		}
		
		function xendcreatebook()
		{
			$txnid = $_POST['txnid'];
			$booknum = $_POST['booknum'];
			$this->db->query("UPDATE `confirm_orders` SET `booking`='$booknum' WHERE txn_id='$txnid'");
		}
		
		function xendbook()
		{
			$data['bookdate'] = $_POST['bookdate'];
			$data['bookfname'] = $_POST['bookfname'];
			$data['booklname'] = $_POST['booklname'];
			$data['bookadd1'] = $_POST['bookadd1'];
			$data['bookadd2'] = $_POST['bookadd2'];
			$data['bookcity'] = $_POST['bookcity'];
			$data['bookprov'] = $_POST['bookprov'];
			$data['bookpostal'] = $_POST['bookpostal'];
			$data['bookland'] = $_POST['bookland'];
			$data['remarks'] = $_POST['remarks'];
			
			$this->load->view('xendbooking', $data);
		}
		
		function viewphotoFE()
		{
			$data['albumid'] = $this->input->post('albumid');
			$data['wid'] = $this->input->post('wid');

			$this->db->where('id', $data['wid']);
			$this->db->where('deleted', 0);
			$query = $this->db->get('websites');

			if($query->num_rows() > 0) {
				$result = $query->row_array();
				$data['url'] = $result['url'];
				$this->load->view('templates/types/photolist', $data);
			} else {
				echo 'no data';
			}
		}
		
		function navimgs() {
			$albumid = $this->input->post('albumid');
			$wid = $this->input->post('wid');
			$arr_key = $this->input->post('arr_key');
			$nav = $this->input->post('nav');
			
			$qgallery = $this->gallery_model->getGallery(0, $albumid);

			if($nav == 'prev') {
				$key = $arr_key - 1;
				if($key <= 0) {
					$key = $qgallery->num_rows();
				}
			} else if($nav == 'next') {
				$key = $arr_key + 1;
				if($key >= $qgallery->num_rows()) {
					$key = 0;
				}			
			}

			if($rgallery = $qgallery->row_array($key)) {
				$img = 'files/'.$albumid.'/'.$rgallery['image_file'];
				if($this->photo_model->image_exists($img)) {
					$image = base_url($img);
				} else {
					$img = 'files/'.$albumid.'/'.$rgallery['image_name'];
					if($this->photo_model->image_exists($img)){
						$image = base_url($img);
					} else {
						$img = 'files/'.$albumid.'/'.$rgallery['image'];
						if($this->photo_model->image_exists($img)) {
							$image = base_url($img);
						} else {
							$img = 'uploads/'.$rgallery['image'];
							if($this->photo_model->image_exists($img)) {
								$image = base_url($img);
							} else {
								$image = base_url('img/no-photo.jpg');
							}
						}
					}
				}
			
				echo '<script type="text/javascript">
					$(document).ready(function() {
						$(".img-ctrl").attr("id",'. $albumid. ');
						$("#img-holder").css("background-image","url('.$image.')");
						$("#img-holder").css("background-size","contain");
						$("#img-holder").css("background-position","center center");
						$("#img-holder").css("background-repeat","no-repeat");		
						$("#img-holder").attr("alt",'.$key.');	
					});
				</script>';
			}
			return false;		
		}
		
		function setalbumprimary()
		{
			$album_cover = $this->input->post('primary');
			$album_id = $this->input->post('albumid');
			
			$this->gallery_model->updateAlbums($album_id, $album_cover);
		}
		
		function updaterecord()
		{
			$value = $_POST['value'];
			$txnid = $_POST['txnid'];
			//echo $value.' ----- '.$txnid;
			$this->db->query("UPDATE `confirm_orders` SET `received`='$value' WHERE `txn_id`='$txnid'");
		}
		
		function countshare()
		{
			//$url = 'http://graph.facebook.com/?id=http://alpha.bolooka.com/henryblinds/catalogue/Lungs/1';
			$url = 'http://api.facebook.com/restserver.php?method=links.getStats&urls='.$_POST['urls'];
			//$content = file_get_contents($url);
			//$json = $_POST['jsondata'];
			$obj = simplexml_load_string(file_get_contents($url));		
			echo $obj->link_stat->share_count;
			
			/* $fql  = "SELECT url, normalized_url, share_count, like_count, comment_count, ";
			$fql .= "total_count, commentsbox_count, comments_fbid, click_count FROM ";
			$fql .= "link_stat WHERE url = 'http://alpha.bolooka.com'";

			$apifql="https://api.facebook.com/method/fql.query?format=json&query=".urlencode($fql);
			$json=file_get_contents($apifql);
			print_r( json_decode($json)); */
		}
		
		function checkexistingemail() 
		{
			$email = $this->input->post('email');
			
			$this->db->where('email',$email);
			$user = $this->db->get('users')->num_rows();
			if($user >= 1)
			{
				echo 'exist';
			}
		}
		
		function transaction_details()
		{
			$txn_id = $this->input->post('txn_id');
			$uid = $this->session->userdata('uid');
			
			/* get transaction table */
			$this->db->where('txn_id',$txn_id);
			$trans_query = $this->db->get('transactions_detail');
			$row_trans = $trans_query->row_array();
			
			/* get customer table */
			$this->db->where('txn_id',$txn_id);
			$customer_query = $this->db->get('costumer');
			$row_customer = $customer_query->row_array();
			
			/* get order items */
			$this->db->where('txn_id',$txn_id);
			$query_order = $this->db->get('orders_items')->result_array();
			
			$total_array = array();
			echo '
				<div class="row-fluid" style="font-size:12px;">
					<div class="span12">
						<div class="row-fluid">
							<div class="span6">
								<div>
									<strong>Transaction Made:</strong>
									<span>'.$this->times_model->makeAgo($row_trans['purchase_date']).'</span>
								</div>
								<div>
									<strong>Delivery Method:</strong>
									<span>'.$row_trans['delivery_method'].'</span>
								</div>
								<div>
									<strong>Payment Option:</strong>
									<span>'.$row_trans['payment_option'].'</span>
								</div>
								<div>
									<strong>Delivery Status:</strong>
									<span>'.$row_trans['delivery_status'].'</span>
								</div>
								<div>
									<strong>Payment Status:</strong>
									<span>'.$row_trans['payment_status'].'</span>
								</div>
							</div>
							<div class="span6">
								<div>
									<strong>Account type:</strong>
									<span>'.($row_customer['account_type'] > 0 ? 'Bolooka user' : 'Guest').'</span>
								</div>
								<div>
									<strong>Customer name:</strong>
									<span>'.$row_customer['fname'].'</span>
								</div>
								<div>
									<strong>Customer Email:</strong>
									<span>'.$row_customer['email'].'</span>
								</div>
								<div>
									<strong>Customer Contact:</strong>
									<span>'.$row_customer['telephone'].'</span>
								</div>
								<div>
									<strong>Location:</strong>
									<span>'.$row_customer['city'].'</span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<hr style="margin: 5px 0;">
				<div class="row-fluid" style="font-size:12px;">
					
					<table class="table table-bordered">
						<thead>
							<th>Product id</th>
							<th>Product name</th>
							<th>Quantity</th>
							<th>Price</th>
							<th>Subtotal</th>
						</thead>
						<tbody>
			';
			foreach($query_order as $row_order)
			{
				$total_array[] = $row_order['subtotal'];
				echo '
							<tr>
								<td>'.str_pad($row_order['product_id'], 7, 0, STR_PAD_LEFT).'</td>
								<td>
									<span>'.$row_order['product_name'].'</span>
									<span>-'.$row_order['variant_name'].'</span>
								</td>
								<td>'.$row_order['qty'].'</td>
								<td>&#8369;'.$row_order['price'].'</td>
								<td>&#8369;'.$row_order['subtotal'].'</td>
							</tr>
				';
			}
			/* add delivery cost to total */
			$total_array[] = $row_trans['delivery_cost'];
			
			echo '
							<tr class="costTotalRow">
								<td colspan="4"><strong>Delivery Cost</strong></td>
								<td colspan="4">&#8369;'.number_format($row_trans['delivery_cost'],2).'</td>
							</tr>
							<tr class="costTotalRow">
								<td colspan="4"><strong>Total</strong></td>
								<td colspan="4">&#8369;'.number_format(array_sum($total_array),2).'</td>
							</tr>
						</tbody>
					</table>
				</div>
			';
		}
		
		function email_to_pay()
		{
			$txnid = $this->input->post('submit_to_buyer');
			$subject = $this->input->post('subject_to_pay');
			$message = $this->input->post('message_to_pay');
			
			$message2 = '<strong>Transaction No:&nbsp;</strong>'.strtoupper($txnid).'<br/><br/></br>'.$message;
			
			/* Set email config */
					$config['mailtype'] = 'html';
					$config['charset'] = 'iso-8859-1';
					$config['wordwrap'] = TRUE;
					
					$this->email->initialize($config);
			
			$this->db->where('txn_id',$txnid);
			$trans_query = $this->db->get('transactions_detail');
			$trans_row = $trans_query->row_array();
			
			$this->db->where('uid',$trans_row['seller_id']);
			$user_query = $this->db->get('users')->row_array();
			if($trans_query->num_rows() > 0)
			{
				$this->email->from($user_query['email']);
				$this->email->to($trans_row['payer_email']);  
				$this->email->subject($subject);
				$this->email->message($message2);	
				$email_to_buyer = $this->email->send();
				if($email_to_buyer)
				{
					echo 'send';
				}
			}else
			{
				echo 'not send';
			}
			
		}
		
		function complete_purchases()
		{
			$reponse = array();
			$productlist_email = '';
			
			/* payment and delivery method */
			$payment_option = $this->input->post('payment_options');
			$delivery_method = $this->input->post('delivery_method');
			
			/* transaction id unique */
			$transaction_id = $this->input->post('txn_uid');
			
			/* owner detail */
			$website_id = $this->input->post('site_id');
			$owner_user_id = $this->input->post('receiver_uid');
			$owner_user_email = $this->input->post('receiver_email');
			
			/* buyers details */
			$buyer_user_email = $this->input->post('email-c');
			$buyer_fname = $this->input->post('fname');
			$buyer_lname = $this->input->post('lname');
			$buyer_bday = $this->input->post('bdayc');
			$buyer_address = $this->input->post('addr');
			$buyer_city = $this->input->post('city');
			$buyer_state = $this->input->post('state');
			$buyer_country = $this->input->post('country');
			$buyer_pzcode = $this->input->post('pzcode');
			$buyer_phone = $this->input->post('phone');
			
			/* determine which user is? bolooka user or guest */
			$buyer_type = $this->input->post('guest');
			
			/* delivery details */
			$del_details = $this->input->post('del_details');
			if(!$del_details)
			{
				$buyer_fname = $this->input->post('sfname');
				$buyer_lname = $this->input->post('slname');
				$buyer_address = $this->input->post('saddr');
				$buyer_city = $this->input->post('scity');
				$buyer_state = $this->input->post('sstate');
				$buyer_country = $this->input->post('scountry');
				$buyer_pzcode = $this->input->post('spzcode');
				$buyer_phone = $this->input->post('sphone');
				
			}
			
			/* start process */
			if($payment_option && $delivery_method)
			{
				/* get items from cart session */
				foreach($this->cart->contents() as $items)
				{
					$this->db->where('id',$items['id']);
					$thisquery_pr = $this->db->get('products');
					$result = $thisquery_pr->row_array();
					
					$order_array = array(
						'txn_id' => strtoupper($transaction_id),
						'product_id' => $items['id'],
						'qty' => $items['qty'],
						'price' => $items['price'],
						'subtotal' => $items['subtotal'],
						'product_name' => $items['name'],
						'created' => time()
					);
					
					/* if has variants option */
					if ($this->cart->has_options($items['rowid']) == TRUE)
					{
						$option = $this->cart->product_options($items['rowid']);
						$stoksmen = $option['v_qty'] - $items['qty'];
						$update_data = array(
							'quantity' => $stoksmen
						);
						// $this->db->where('id',$option['v_id']);
						// $this->db->update('product_variants',$update_data);
						
						$productlist_email .= '<tr>
							<td style="padding: 10px 25px 0 0;">'.str_pad($items['id'], 7, 0, STR_PAD_LEFT).'</td>
							<td style="padding: 10px 25px 0 0;">'.$items['name'].'<br/>-'.$option['v_name'].'</td>
							<td style="padding: 10px 25px 0 0;">'.$items['qty'].'</td>
							<td style="padding: 10px 25px 0 0;">'.number_format($items['price'],2).'</td>
							<td style="padding: 10px 25px 0 0;">'.number_format($items['subtotal'], 2).'</td>
						</tr>';
						
						$order_array['variant_id'] = $option['v_id'];
						$order_array['variant_name'] = $option['v_name'];
					}else
					{
						$stoksmen = $result['stocks'] - $items['qty'];
						$update_data = array(
							'stocks' => $stoksmen
						);
						// $this->db->where('id',$items['id']);
						// $this->db->update('products',$update_data);
						
						$productlist_email .= '<tr>
							<td style="padding: 10px 25px 0 0;">'.str_pad($items['id'], 7, 0, STR_PAD_LEFT).'</td>
							<td style="padding: 10px 25px 0 0;">'.$items['name'].'</td>
							<td style="padding: 10px 25px 0 0;">'.$items['qty'].'</td>
							<td style="padding: 10px 25px 0 0;">'.number_format($items['price'],2).'</td>
							<td style="padding: 10px 25px 0 0;">'.number_format($items['subtotal'], 2).'</td>
						</tr>';
						
						$order_array['variant_id'] = 0;
					}
					
					$this->db->insert('orders_items',$order_array);
				
				}
				
				/* get seller name */
				$this->db->where('uid',$owner_user_id);
				$querySellerUser = $this->db->get('users');
				$resultSellerUser = $querySellerUser->row_array();
				
				/* get mobile and landline to user_profile_info */
				$this->db->where('user_id',$owner_user_id);
				$querySellerInfo = $this->db->get('user_profile_info');
				$resultSellerInfo = $querySellerInfo->row_array();
				
				/* get delivery method price */
				$this->db->where('name',$delivery_method);
				$this->db->where('user_id',$owner_user_id);
				$query_del = $this->db->get('user_delivery_method')->row_array();
				$del_price = '
					<tr>
						<td colspan="4"><strong>Delivery Cost</strong></td>
						<td>'.number_format($query_del['price'],2).'</td>
					</tr>
				';
				
				$payment_list = '';
				switch($payment_option)
				{
					case 'gcash':
						$this->db->where('user_id',$owner_user_id);
						$query_payment = $this->db->get('user_payment_option')->row_array();
						
						$payment_list = '<strong>Gcash Number:&nbsp;</strong>'.$query_payment['gcash'];
						$add_message = 'You can process your payment thru Gcash using details below.';
						
						$reponse['type'] = 'gcash';
						$reponse['shipping'] = number_format($query_del['price'],2);
					break;
					case 'smart_money':
						$this->db->where('user_id',$owner_user_id);
						$query_payment = $this->db->get('user_payment_option')->row_array();
						
						$payment_list = '<strong>Smart Money Number:&nbsp;</strong>'.$query_payment['smart_money'];
						$add_message = 'You can process your payment thru Smart Money using details below.';
						
						$reponse['type'] = 'smart_money';
						$reponse['shipping'] = number_format($query_del['price'],2);
					break;
					case 'paypal':
						$add_message = 'Payment type is PAYPAL';
						$reponse['type'] = 'paypal';
						$reponse['shipping'] = number_format($query_del['price'],2);
					break;
					default: 
						$reponse['type'] = 'bank';
						$reponse['shipping'] = number_format($query_del['price'],2);
						
						$this->db->where('bank_name',$payment_option);
						$this->db->where('user_id',$owner_user_id);
						$query_bank = $this->db->get('user_bank_details')->row_array();
						
						$payment_list = '
							<ul style="list-style:none;padding:0;">
								<li style="margin-left:0;"><strong>Bank Name:&nbsp;</strong>'.$query_bank['bank_name'].'</li>
								<li style="margin-left:0;"><strong>Account Name:&nbsp;</strong>'.$query_bank['account_name'].'</li>
								<li style="margin-left:0;"><strong>Account Number:&nbsp;</strong>'.$query_bank['account_number'].'</li>
							</ul>
						';
						$add_message = 'You can process your payment thru Bank Deposit using details below.';
				}
				
				/* save customer record data */
				$pay_status = 'not paid';
				$customer_data = array(
					'account_type' => $this->input->post('guest'),
					'fname' => $buyer_fname,
					'lname' => $buyer_lname,
					'email' => $buyer_user_email,
					'bday' => $buyer_bday,
					'telephone' => $buyer_phone,
					'address1' => $buyer_address,
					'city' => $buyer_city,
					'postal' => $buyer_pzcode,
					'country' => $buyer_country,
					'state' => $buyer_state,
					'txn_id' => $transaction_id,
					'user_id' => $this->input->post('guest'),
					'date_added' => time()
				);
				
				/* save transaction record */
				$transaction_data = array(
					'payer_email' => $buyer_user_email,
					'purchase_date' => time(),
					'total_price' => $this->cart->total(),
					'status' => 'pending',
					'delivery_status' => 'not delivered',
					'payment_status' => $pay_status,
					'txn_id' => $transaction_id,
					'paypal_txn_id' => NULL,
					'seller_id' => $owner_user_id,
					'delivery_method' => $delivery_method,
					'payment_option' => $payment_option,
					'website_id' => $website_id,
					'delivery_cost' => $query_del['price']
				);
				
				$contact_moblie_seller = '';
				$contact_landline_seller = '';
				if($querySellerInfo->num_rows() > 0)
				{
					$contact_moblie_seller = $resultSellerInfo['mobile_num'];
					$contact_landline_seller = $resultSellerInfo['landline'];
				}
				
				/* get all total cost */
				$total_cost = $this->cart->total() + $query_del['price'];
				
				$message = '
					<h3>Transaction Made</h3>
					<p>The seller has been notified. Please go to <a href="'.base_url('multi/transactions').'" target="_BLANK">Bolooka</a> under of menu go to the ORDERS to monitor your transaction</p>
					<p>'.$add_message.'</p>
					'.$payment_list.'
					<hr/>
					<p><b>Seller&rsquo;s Info</b></p>
					<p style="margin:0;"><strong>Email:&nbsp;</strong>'.$owner_user_email.'</p>
					<p style="margin:0;"><strong>Name:&nbsp;</strong>'.$resultSellerUser['name'].'</p>
					<p style="margin:0;"><strong>Contact Number:&nbsp;</strong>'.($contact_moblie_seller ? $contact_moblie_seller : '').''.($contact_landline_seller ? '/'.$contact_landline_seller : '').'</p>
					<p style="margin:0;"><strong>Delivery Method:&nbsp;</strong>'.$delivery_method.'</p>
					<p style="margin:0;"><strong>Payment Type:&nbsp;</strong>'.$payment_option.'</p>
					<br/>
					<p style="margin:0;"><strong>Transaction No:&nbsp;</strong>'.strtoupper($transaction_id).'</p>
					<br/>
					<p><strong>Order Summary</strong></p>
					<table style="border-spacing: 0;">
						<thead>
							<th style="border-bottom:1px solid; padding: 10px 30px 0 0;">Product ID</th>
							<th style="border-bottom:1px solid; padding: 10px 250px 0 0;">Product Name</th>
							<th style="border-bottom:1px solid; padding: 10px 30px 0 0;">Quantity</th>
							<th style="border-bottom:1px solid; padding: 10px 30px 0 0;">Price</th>
							<th style="border-bottom:1px solid; padding: 10px 30px 0 0;">Amount</th>
						</thead>
						<tbody>
							'.$productlist_email.'
							'.$del_price.'
							<tr>
								<td colspan="4"></td>
								<td style="border-top: 1px solid">&#8369;'.number_format($total_cost,2).'</td>
							</tr>
						</tbody>
					</table>
				';
				
				$message2 = '
					<h3>Transaction Made</h3>
					<p>You have orders</p>
					<p>Please go to <a href="'.base_url('multi/transactions').'" target="_BLANK">Bolooka</a> under of menu go to the ORDERS to monitor your transaction</p>
					<p><b>Customer&rsquo;s Info</b></p>
					<p style="margin:0;"><strong>Email:&nbsp;</strong>'.$buyer_user_email.'</p>
					<p style="margin:0;"><strong>Name:&nbsp;</strong>'.$buyer_fname.' ' .$buyer_lname.'</p>
					<p style="margin:0;"><strong>Contact Number:&nbsp;</strong>'.$buyer_phone.'</p>
					<p style="margin:0;"><strong>Address:&nbsp;</strong>'.$buyer_address.'</p>
					<p style="margin:0;"><strong>Delivery Method:&nbsp;</strong>'.$delivery_method.'</p>
					<p style="margin:0;"><strong>Payment Type:&nbsp;</strong>'.$payment_option.'</p>
					<br/>
					<p style="margin:0;"><strong>Transaction No:&nbsp;</strong>'.strtoupper($transaction_id).'</p>
					<br/>
					<p><strong>Order Summary</strong></p>
					<table style="border-spacing: 0;">
						<thead>
							<th style="border-bottom:1px solid; padding: 10px 30px 0 0;">Product ID</th>
							<th style="border-bottom:1px solid; padding: 10px 250px 0 0;">Product Name</th>
							<th style="border-bottom:1px solid; padding: 10px 30px 0 0;">Quantity</th>
							<th style="border-bottom:1px solid; padding: 10px 30px 0 0;">Price</th>
							<th style="border-bottom:1px solid; padding: 10px 30px 0 0;">Amount</th>
						</thead>
						<tbody>
							'.$productlist_email.'
							'.$del_price.'
							<tr>
								<td colspan="4"></td>
								<td style="border-top: 1px solid">&#8369;'.number_format($total_cost,2).'</td>
							</tr>
						</tbody>
					</table>
				';
				
				/* Set email config */
					$config['mailtype'] = 'html';
					$config['charset'] = 'iso-8859-1';
					$config['wordwrap'] = TRUE;
					
					$this->email->initialize($config);
				
				$this->email->from('info@bolooka.com', 'Bolooka');
				$this->email->to($buyer_user_email);  
				$this->email->subject('Bolooka Order Slip - '.$transaction_id);
				$this->email->message($message);
				$email_to_buyer = $this->email->send();
				
				$this->email->from('info@bolooka.com', 'Bolooka');
				$this->email->to($owner_user_email);  
				$this->email->subject('Bolooka Order Slip - '.$transaction_id);
				$this->email->message($message2);	
				$email_to_seller = $this->email->send();
				
				if($email_to_seller && $email_to_buyer)
				{
					// /* insert to tables */
					$this->db->insert('costumer', $customer_data);
					$this->db->insert('transactions_detail', $transaction_data);
					$this->cart->destroy();
					
					echo json_encode($reponse);
				}
				
			}
		}
		
		function complete_purchase(){
			$response = array();
			$shipping_array = array();
			$prod_email = '';
			$prod_array = '';
			$add_shipping = '
			<b>Shipping Delivery</b><br/>
			Ship items to the above billing address.<br/>
			';
			$counterror = 0;
			$time = time();
			if(isset($_POST)){
				if(!$this->input->post('payment_options')){
					$response['error'][] = 'no_payment_options';					
				}
				if(!$this->input->post('delivery_method')){
					$response['error'][] = 'no_delivery_method';					
				}				
				if(isset($response['error'])){
					$counterror = count($response['error']);
				}
				
				if($counterror < 1){
					if(!$this->input->post('del_details')){						
						$shipping_array = array(
							'fname' => $this->input->post('sfname'),
							'lname' => $this->input->post('slname'),
							'address1' => $this->input->post('saddr'),
							'scity' => $this->input->post('scity'),
							'spzcode' => $this->input->post('spzcode'),
							'scountry' => $this->input->post('scountry'),
							'sstate' => $this->input->post('sstate'),
							'sphone' => $this->input->post('sphone')
						);
						
						$add_shipping = '
						<b>Shipping Delivery</b><br/>
						Name: '.$this->input->post('sfname').' '.$this->input->post('slname').'<br/>
						Address: '.$this->input->post('saddr').'<br/>
						City: '.$this->input->post('scity').'<br/>
						Postal/Zip Code: '.$this->input->post('spzcode').'<br/>
						Country: '.$this->input->post('scountry').'<br/>
						State: '.$this->input->post('sstate').'<br/>
						Phone: '.$this->input->post('sphone').'<br/>
						';
					}
					
					foreach($this->cart->contents() as $items)
					{
						$this->db->where('id',$items['id']);
						$thisquery_pr = $this->db->get('products');
						$result = $thisquery_pr->row_array();
						
						/* if has variants option */
						if ($this->cart->has_options($items['rowid']) == TRUE)
						{
							$option = $this->cart->product_options($items['rowid']);
							$stoksmen = $option['v_qty'] - $items['qty'];
							$update_data = array(
								'quantity' => $stoksmen
							);
							$this->db->where('id',$option['v_id']);
							$this->db->update('product_variants',$update_data);
							
							$prod_email .= '<tr>
								<td>000'.$items['id'].'</td>
								<td>'.$items['name'].'<br/>-'.$option['v_name'].'</td>
								<td>'.$items['qty'].'</td>
								<td>'.number_format($items['price'],2).'</td>
								<td>'.number_format($items['subtotal'], 2).'</td>
							</tr>';
						}else
						{
							$stoksmen = $result['stocks'] - $items['qty'];
							$update_data = array(
								'stocks' => $stoksmen
							);
							$this->db->where('id',$items['id']);
							$this->db->update('products',$update_data);
							
							$prod_email .= '<tr>
								<td>000'.$items['id'].'</td>
								<td>'.$items['name'].'</td>
								<td>'.$items['qty'].'</td>
								<td>'.number_format($items['price'],2).'</td>
								<td>'.number_format($items['subtotal'], 2).'</td>
							</tr>';
						}
						
						$prod_array .= $items['id'].'-'.$items['qty'].',';
						
					}
					
					$record_data = array(
						'account_type' => $this->input->post('guest'),
						'fname' => $this->input->post('fname'),
						'lname' => $this->input->post('lname'),
						'email' => $this->input->post('email-c'),
						'bday' => $this->input->post('bdayc'),
						'telephone' => $this->input->post('phone'),
						'address1' => $this->input->post('addr'),
						'city' => $this->input->post('city'),
						'postal' => $this->input->post('pzcode'),
						'country' => $this->input->post('country'),
						'state' => $this->input->post('state'),
						'shipping_data' => serialize($shipping_array),
						'date_added' => $time
					);
					
					$payment_delivery_data = array(
						'costumers_email' => $this->input->post('email-c'),
						'del_method' => $this->input->post('delivery_method'),
						'payopt' => $this->input->post('payment_options'),
						'prod_array' => $prod_array,
						'date_confirmed' => $time
					);									
					
					/* Record data to Costumer table and confirm orders */
					$this->db->insert('costumer', $record_data);
					$cosInsertId = $this->db->insert_id();
					$this->db->insert('confirm_orders', $payment_delivery_data);
					$insertId = $this->db->insert_id();
					$txnid = $insertId.$time;
					$txnid = strtoupper(substr(md5($txnid), 0, 17));
					
					/* Txn Record */
					$txn_array = array(
						'txn_id' => $txnid
					);
					$txn_ci = array(
						'txn_ci' => $this->input->post('txn_uid')
					);
					
					$transaction_data = array(
						'product_id_array' => $prod_array,
						'payer_email' => $this->input->post('email-c'),
						'first_name' => $this->input->post('fname'),
						'last_name' => $this->input->post('lname'),
						'payment_date' => $time,
						'mc_gross' => $this->cart->total(),
						'txn_id' => $txnid,
						'receiver_email' => $this->input->post('receiver_email')
					);
					
					$transaction_data_paypal = array(
						'product_id_array' => $prod_array,
						'txn_id' => $this->input->post('txn_uid')
					);
					
					/* Get Records from Profile */
					$this->db->where('user_id', $this->input->post('receiver_uid'));
					$ckquery = $this->db->get('checkout_settings');
					$cksettings = $ckquery->row_array();
					
					/* Set email config */
					$config['mailtype'] = 'html';
					$config['charset'] = 'iso-8859-1';
					$config['wordwrap'] = TRUE;
					
					$this->email->initialize($config);
					
					$payment_list = '';
					switch($this->input->post('payment_options')){
						case 'bank':
							$x = 0;
							$payment_list .= '<ul style="list-style:none;">';
							foreach(json_decode($cksettings['bank_details']) as $bank_row){
								$response['bank'][$x]['bankname'] = $bank_row->bank_name;
								$response['bank'][$x]['actname'] = $bank_row->acct_name;
								$response['bank'][$x]['actnum'] = $bank_row->acct_num;
								$payment_list .= '<li>
								Bank Name: '.$bank_row->bank_name.'<br>
								Acount Name: '.$bank_row->acct_name.'<br>
								Acount Number: '.$bank_row->acct_num.'<br>
								</li>';
								$x++;
							}
							$payment_list .= '</ul>';
							$this->db->insert('transactions', $transaction_data);
							$this->db->where('id', $insertId);
							$this->db->update('confirm_orders',$txn_array);
							
							$txn_array['user_id'] = 'guest';
							if($this->input->post('guest') == 0){
								$txn_array['user_id'] = $this->session->userdata('uid');
							}
							
							$this->db->where('id', $cosInsertId);
							$this->db->update('costumer',$txn_array);
							
							$payments = 'Bank';
							$add_message = 'You can process your payment thru Bank Deposit using details below.';
							
						break;
						case 'pay_email':						
							$response['paypal'] = 'true';
							$this->db->where('id', $insertId);
							$this->db->update('confirm_orders',$txn_ci);
							$this->db->insert('transactions', $transaction_data_paypal);
							
							$array_user_id = 'guest';
							if($this->input->post('guest') == 0){
								$array_user_id = $this->session->userdata('uid');
							}
							
							$user_paypal_array = array(
								'txn_id' => $this->input->post('txn_uid'),
								'user_id' => $array_user_id
							);
							$this->db->where('id', $cosInsertId);
							$this->db->update('costumer',$user_paypal_array);
							
							$payments = 'Paypal';
							$add_message = '';
						break;
						case 'gcash':
							$response['pnumber'] = $cksettings['gcash'];
							$response['ptype'] = 'Gcash Number:';
							
							$this->db->insert('transactions', $transaction_data);
							$this->db->where('id', $insertId);
							$this->db->update('confirm_orders',$txn_array);
							
							$txn_array['user_id'] = 'guest';
							if($this->input->post('guest') == 0){
								$txn_array['user_id'] = $this->session->userdata('uid');
							}
							
							$this->db->where('id', $cosInsertId);
							$this->db->update('costumer',$txn_array);
							
							$payments = 'Gcash';
							$payment_list .= 'Gcash Number: '.$cksettings['gcash'];
							$add_message = 'You can process your payment thru Gcash using details below.';
						break;
						case 'smoney':
							$response['pnumber'] = $cksettings['smart_money'];
							$response['ptype'] = 'Smart Money:';
							
							$this->db->insert('transactions', $transaction_data);
							$this->db->where('id', $insertId);
							$this->db->update('confirm_orders',$txn_array);
							
							$txn_array['user_id'] = 'guest';
							if($this->input->post('guest') == 0){
								$txn_array['user_id'] = $this->session->userdata('uid');
							}
							
							$this->db->where('id', $cosInsertId);
							$this->db->update('costumer',$txn_array);
							
							$payments = 'Smart Money';
							$payment_list .= 'Smart Money Number: '.$cksettings['smart_money'];
							$add_message = 'You can process your payment thru Smart Money using details below.';
						break;
						default:
							$add_message = 'The seller has been notified. Please contact the seller for payment details.';
					}
					
					# Get Sellers Info 
					$this->db->where('uid', $this->input->post('receiver_uid'));
					$querySeller = $this->db->get('users');
					$resultSeller = $querySeller->row_array();
					
					$this->db->where('user_id', $this->input->post('receiver_uid'));
					$querySellerInfo = $this->db->get('user_profile_info');
					$resultSellerInfo = $querySellerInfo->row_array();
					
					$message = '
					<p>This is the summary of your order.</p>
					<b>Seller&rsquo;s Info:</b><br>
					<br>
					Email: '.$resultSeller['email'].' <br>'
					.($resultSellerInfo['mobile_num'] ? 'Mobile Number: '.$resultSellerInfo['mobile_num'].'<br>' : '')
					.($resultSellerInfo['landline'] ? 'Landline Number: '.$resultSellerInfo['landline'].'<br>' : '')
					.$add_message.'<br>'
					.$payment_list.'<br>
					<table style="width:100%;">
					<tr>
						<td style="background:#ddd;">Product Id</td>
						<td style="background:#ddd;">Product Name</td>
						<td style="background:#ddd;">Quantity</td>
						<td style="background:#ddd;">Unit Price</td>
						<td style="background:#ddd;">Amount</td>
					</tr>
					'.$prod_email.'
					<tr>
						<td colspan="3"></td>
						<td>Total:</td>
						<td>'.number_format($this->cart->total(), 2).'</td>
					</tr>
					</table>
					<br>
					';
					
					$message2 = '
					<b>Costumer Info</b><br/>
					Name: '.$this->input->post('fname').' '.$this->input->post('lname').'<br/>
					Email: '.$this->input->post('email-c').'<br/>
					Address: '.$this->input->post('addr').'<br/>
					City: '.$this->input->post('city').'<br/>
					Postal/Zip Code: '.$this->input->post('pzcode').'<br/>
					Country: '.$this->input->post('country').'<br/>
					State/Province: '.$this->input->post('state').'<br/>
					Phone: '.$this->input->post('phone').'<br/>
					Payment Option: '.$payments.'<br/>
					Delivery Method: '.$this->input->post('delivery_method').'<br/>
					'.$add_shipping.'
					<table style="width:100%;">
					<tr>
						<td style="background:#ddd;">Product Id</td>
						<td style="background:#ddd;">Product Name</td>
						<td style="background:#ddd;">Quantity</td>
						<td style="background:#ddd;">Unit Price</td>
						<td style="background:#ddd;">Amount</td>
					</tr>
					'.$prod_email.'
					<tr>
						<td colspan="3"></td>
						<td>Total:</td>
						<td>'.number_format($this->cart->total(), 2).'</td>
					</tr>
					</table>
					';
					
					$this->email->from('info@bolooka.com', 'Bolooka');
					$this->email->to($this->input->post('receiver_email'));  
					$this->email->subject('Bolooka Order Slip - '.$txnid);
					$this->email->message($message2);	
					$this->email->send();
					
					$this->email->from('info@bolooka.com', 'Bolooka');
					$this->email->to($this->input->post('email-c'));  
					$this->email->subject('Bolooka Order Slip - '.$txnid);
					$this->email->message($message);	
					$this->email->send();
					
					$this->cart->destroy();
				}
			}else{
				$response['error'][] = 'no_data';
			}
			//echo json_encode($response, JSON_FORCE_OBJECT);// for local
			echo json_encode($response);//for alpha
		}

		function payment_paid()
		{
			$txnid = $this->input->post('txnid');
			
			$this->db->where('txn_id',$txnid);
			$this->db->where('delivery_status','delivered');
			$query = $this->db->get('transactions_detail');
			
			if($query->num_rows() > 0)
			{
				$data_array = array(
					'payment_status'=>'paid',
					'status'=>'closed'
				);
			}else
			{
				$data_array = array(
					'payment_status'=>'paid'
				);
			}
			
			$this->db->where('txn_id',$txnid);
			$this->db->update('transactions_detail',$data_array);
		}	
		
		function delivery_to_buyer($to_seller=null)
		{
			/* Set email config */
					$config['mailtype'] = 'html';
					$config['charset'] = 'iso-8859-1';
					$config['wordwrap'] = TRUE;
					
					$this->email->initialize($config);
			
			$txnid = $this->input->post('txnid');
			
			if($to_seller)
			{
				$this->db->select('
					costumer.fname,
					costumer.lname,
					transactions_detail.seller_id,
					users.email
				');
				$this->db->where('costumer.txn_id',$txnid);
				$this->db->from('costumer');
				$this->db->join('transactions_detail','transactions_detail.txn_id = costumer.txn_id');
				$this->db->join('users','users.uid = transactions_detail.seller_id','left');
				$query_customer = $this->db->get()->row_array();
				$message = '
					<div style="border:1px solid;font: 14px arial,normal;padding: 23px 20px;">
						<strong>Transaction No: </strong><span> '.strtoupper($txnid).'</span>
						<p>
							<strong>'.$query_customer['fname'].' '.$query_customer['lname'].'</strong>
							Had received your delivery
						</p>
						<p>
							Your delivery has been successful 
						</p>
						<p>
							Delivery method closed 
						</p>
						<p>
							Thank you! 
						</p>
					</div>
				';
				
				$this->email->from('info@bolooka.com', 'Bolooka');
				$this->email->to($query_customer['email']);  
				$this->email->subject('Delivery Confirmation');
				$this->email->message($message);	
				$email = $this->email->send();
				if($email)
				{
					$this->db->where('txn_id',$txnid);
					$this->db->where('payment_status','paid');
					$query = $this->db->get('transactions_detail');
					
					if($query->num_rows() > 0)
					{
						$data_array = array(
							'delivery_status' => 'delivered',
							'status'=>'closed'
						);
					}else
					{
						$data_array = array(
							'delivery_status' => 'delivered'
						);
					}

					$this->db->where('txn_id',$txnid);
					$this->db->update('transactions_detail',$data_array);
				}
			}else
			{
				
				/* get transaction_details join websites and users */
				$this->db->select('
					transactions_detail.seller_id, 
					transactions_detail.delivery_method, 
					transactions_detail.payment_option, 
					transactions_detail.payer_email, 
					websites.url, 
					websites.site_name,
					users.profile_picture,
					users.name
				');
				$this->db->where('txn_id',$txnid);
				$this->db->from('transactions_detail');
				$this->db->join('websites', 'websites.id = transactions_detail.website_id', 'left');
				$this->db->join('users', 'users.uid = transactions_detail.seller_id', 'left');
				$query = $this->db->get()->row_array();
				
				/* get user_delivery_method */
				$this->db->where('user_id',$query['seller_id']);
				$this->db->where('name',$query['delivery_method']);
				$query_delivery_method = $this->db->get('user_delivery_method')->row();
				
				/* get order_items */
				$this->db->select('
					products.name,
					orders_items.qty,
					orders_items.price,
					orders_items.subtotal,
					product_variants.name as variant_name
				');
				$this->db->where('orders_items.txn_id',$txnid);
				$this->db->from('orders_items');
				$this->db->join('product_variants', 'product_variants.id = orders_items.variant_id', 'left');
				$this->db->join('products', 'products.id = orders_items.product_id', 'left');
				$query_items = $this->db->get()->result_array();
				
				$time_send = date('M j, Y',time());
				$total = array();
				$productList = '<table style="border-spacing: 0;">
									<thead>
										<th style="border-bottom:1px solid; padding: 10px 250px 0 0;">Product name</th>
										<th style="border-bottom:1px solid; padding: 10px 30px 0 0;">Quantity</th>
										<th style="border-bottom:1px solid; padding: 10px 30px 0 0;">Price</th>
										<th style="border-bottom:1px solid; padding: 10px 30px 0 0;">Subtotal</th>
									</thead>
									<tbody>
				';
				
				foreach($query_items as $row_items)
				{
					$total[] = $row_items['subtotal'];
					$productList .= '
										<tr>
											<td style="padding: 10px 25px 0 0;">'.$row_items['name'].'<br/>-'.$row_items['variant_name'].'</td>
											<td style="padding: 10px 25px 0 0;">'.$row_items['qty'].'</td>
											<td style="padding: 10px 25px 0 0;">'.number_format($row_items['price'],2).'</td>
											<td style="padding: 10px 25px 0 0;">'.number_format($row_items['subtotal'],2).'</td>
										</tr>
					';
				}
				
				/* add delivery cost to total */
				$total[] = $query_delivery_method->price;
				
				$productList .= '
										<tr>
											<td colspan="3"><strong>Delivery Cost</strong></td>
											<td style="padding: 10px 25px 0 0;">'.number_format($query_delivery_method->price,2).'</td>
										</tr>
										<tr>
											<td colspan="3"></td>
											<td style="border-top:1px solid;padding: 10px 25px 0 0;">&#8369; '.number_format(array_sum($total),2).'</td>
										</tr>
				';
				$productList .= '
									</tbody>
								</table>
				';
				
				$message = '
				<div style="border:1px solid;font: 14px arial,normal;padding: 23px 20px;">
					<img src="'.base_url($query['seller_id'].'/medium/'.$query['profile_picture']).'">
					<strong>'.$query['name'].'</strong> said that the items you bought from 
					<a href="'.base_url($query['url']).'">'.$query['site_name'].' </a> Has been delivered <br/><br/>
					<span>Please sign in to bolooka to check your order status and go to ORDERS then BOUGHT ITEMS</span><br/>
					<a href="'.base_url().'" target="_BLANK">Go to Bolooka</a>
					<br/>
					<br/>
					<div>
						<strong>Delivery Method: </strong><span> '.$query['delivery_method'].'</span>
					</div>
					<div>
						<strong>Payment Option: </strong><span> '.$query['payment_option'].'</span>
					</div>
					<div>
						<strong>Date: </strong><span> '.$time_send.'</span>
					</div>
					<div>
						<strong>Transaction No: </strong><span> '.strtoupper($txnid).'</span>
					</div>
					<br/>
					<div>'.$productList.'</div>
				</div>';
				
				$this->email->from('info@bolooka.com', 'Bolooka');
				$this->email->to($query['payer_email']);  
				$this->email->subject('Delivery Confirmation');
				$this->email->message($message);	
				$email = $this->email->send();
				if($email)
				{
					$data_array = array(
						'delivery_status' => 'on delivery'
					);
					$this->db->where('txn_id',$txnid);
					$this->db->update('transactions_detail',$data_array);
				}
			}
			
		}
		
		function contact_seller()
		{
			$prod_array = '';
			$prod_email = '';
			$add_shipping = '
			<b>Shipping Delivery</b><br/>
			Ship items to the above billing address.<br/>
			';
			
			$this->db->where('id', $this->input->post('site_id'));
			$qsite = $this->db->get('websites');
			$rsite = $qsite->row_array();
			
			
			foreach($this->cart->contents() as $items){
				$this->db->where('id', $items['id']);
				$thisquery_pr = $this->db->get('products');
				$result = $thisquery_pr->row_array();
				
				$prod_array .= $items['id'].'-'.$items['qty'].',';
				if ($this->cart->has_options($items['rowid']) == TRUE)
				{
					$option = $this->cart->product_options($items['rowid']);
					$prod_email .= '<tr>
						<td>000'.$items['id'].'</td>
						<td>'.$items['name'].'<br/>-'.$option['v_name'].'</td>
						<td>'.$items['qty'].'</td>
						<td>'.number_format($items['price'],2).'</td>
						<td>'.number_format($items['subtotal'], 2).'</td>
					</tr>
					<br>';
				}else
				{
					$prod_email .= '<tr>
						<td>000'.$items['id'].'</td>
						<td>'.$items['name'].'</td>
						<td>'.$items['qty'].'</td>
						<td>'.number_format($items['price'],2).'</td>
						<td>'.number_format($items['subtotal'], 2).'</td>
					</tr>
					<br>';
				}
			}
			
			if(!$this->input->post('del_details')){
				$add_shipping = '
				<b>Shipping Delivery</b><br/>
				Name: '.$this->input->post('sfname').' '.$this->input->post('slname').'<br/>
				Address: '.$this->input->post('saddr').'<br/>
				City: '.$this->input->post('scity').'<br/>
				Postal/Zip Code: '.$this->input->post('spzcode').'<br/>
				Country: '.$this->input->post('scountry').'<br/>
				State: '.$this->input->post('sstate').'<br/>
				Phone: '.$this->input->post('sphone').'<br/>
				';
			}
			
			/* Set email config */
					$config['mailtype'] = 'html';
					$config['charset'] = 'iso-8859-1';
					$config['wordwrap'] = TRUE;
					
					$this->email->initialize($config);
			
			$message = '
			<p style="margin:0;">You received this payment process email because the payment options and delivery method in your profile page is empty, Please update your profile now to show payment options in your checkout. <a href="'.base_url().'">Click here</a></p>
			<b>Costumer Info</b><br/>
			Name: '.$this->input->post('fname').' '.$this->input->post('lname').'<br/>
			Email: '.$this->input->post('email-c').'<br/>
			Address: '.$this->input->post('addr').'<br/>
			City: '.$this->input->post('city').'<br/>
			Postal/Zip Code: '.$this->input->post('pzcode').'<br/>
			Country: '.$this->input->post('country').'<br/>
			State/Province: '.$this->input->post('state').'<br/>
			Phone: '.$this->input->post('phone').'<br/>
			'.$add_shipping.'
			<table style="width:100%;">
			<tr>
				<td style="background:#ddd;">Product Id</td>
				<td style="background:#ddd;">Product Name</td>
				<td style="background:#ddd;">Quantity</td>
				<td style="background:#ddd;">Unit Price</td>
				<td style="background:#ddd;">Amount</td>
			</tr>
			'.$prod_email.'
			<tr>
				<td colspan="3"></td>
				<td>Total:</td>
				<td>'.number_format($this->cart->total(), 2).'</td>
			</tr>
			</table>
			';
						
			$this->db->select('users.uid, users.first_name, users.last_name, user_profile_info.mobile_num, user_profile_info.landline');
			$this->db->from('users');
			$this->db->join('user_profile_info', 'user_profile_info.user_id = users.uid','left');
			$this->db->where('users.email', $this->input->post('receiver_email'));
			$querys = $this->db->get();
			$thisresult = $querys->row_array();
			
			$message2 = '
				<p style="margin:0;">Seller has been notified, please contact them for payment details.</p>
				<br />
				<b>Store Info</b><br/>
				Store: '.$rsite['site_name'].'<br />
				Owner: '.$thisresult['first_name'].' '.$thisresult['last_name'].'<br />
				Email: '.$this->input->post('receiver_email').'<br />
			';
			if(isset($thisresult['mobile_num']) && $thisresult['mobile_num'] != '')
			{
			$message2 .= '
				Mobile Number: '.$thisresult['mobile_num'].'<br />
			';
			}
			if(isset($thisresult['landline']) && $thisresult['landline'] != '')
			{
			$message2 .= '
				Landline Number: '.$thisresult['landline'].'<br />
			';
			}
			$message2 .= '
				<table style="width:100%;">
				<tr>
					<td style="background:#ddd;">Product Id</td>
					<td style="background:#ddd;">Product Name</td>
					<td style="background:#ddd;">Quantity</td>
					<td style="background:#ddd;">Unit Price</td>
					<td style="background:#ddd;">Amount</td>
				</tr>
				'.$prod_email.'
				<tr>
					<td colspan="3"></td>
					<td>Total:</td>
					<td>'.number_format($this->cart->total(), 2).'</td>
				</tr>
				</table>
			';
			
			$this->email->from('info@bolooka.com', 'Bolooka');
			$this->email->to($this->input->post('receiver_email'));  
			$this->email->subject('Bolooka Order - Payment Process');
			$this->email->message($message);	
			$email1 = $this->email->send();
			
			$this->email->from('info@bolooka.com', 'Bolooka');
			$this->email->to($this->input->post('email-c'));  
			$this->email->subject('Bolooka Order - Payment Process');
			$this->email->message($message2);	
			$email2 = $this->email->send();
			
			if($email1 && $email2) {
				$this->cart->destroy();
			}
		}
	}
	
?>