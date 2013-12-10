<?php
	class Group_Model extends CI_Model 
	{
	
		private $_tgroups = "gallery_comment";
		//private $_tusers = "users";
		private $_tmembers = "websites";
		private $_usergroups = "web_group";
		
		function __construct()
		{
			$this->load->database();
			$this->load->library('session');
		}

		function following()
		{
			$msgToUser = "
				<div id='show_cont'>
					<div style='width: 328px;margin-left: 122px;margin-top: 71px;' class='null'>
					<p style='font-size: 18px;font-weight: bold;line-height: 21px;font-family: Arial;'>Here's the list of websites you're following.</p>
					</div>
				</div>
			";
			
			if(isset($_POST['uid']))
			{
				/* echo 'meron'; */
				$the_user = $_POST['uid'];
				
				$query2 = $this->db->query("SELECT website_id FROM follow WHERE users LIKE '$the_user'");
				
				if($query2->num_rows() > 0)
				{
					foreach($query2->result_array() as $rows)
					{
						$website_id = $rows['website_id'];
						$query = $this->db->query("SELECT * FROM websites WHERE id='$website_id'");
						
						if($query->num_rows() > 0)
						{
							foreach($query->result_array() as $rows2)
							{
								$name = $rows2['site_name'];
								$ids = $rows2['id'];
								$description = $rows2['description'];
								$url = $rows2['url'];
							}
							$queryLogo = $this->db->query("SELECT * FROM logo WHERE website_id ='$website_id'");
							if($queryLogo->num_rows() > 0)
							{
								foreach($queryLogo->result_array() as $rows3)
								{
									$imageSrc = '../'.$rows3['image'];
									
									
								}
									if($imageSrc == '../')
									{
										$imageSrc = '../img/Default Profile Picture.jpg';
										
									}
							}
							else
							{
								$imageSrc = 'img/Default Profile Picture.jpg';
							}
							
							echo '
								<div class="following" style="border-radius: 10px 10px 10px 10px;box-shadow: 2px 2px 2px 0 #000000;border:1px solid;margin: 20px 0 10px;padding: 8px;">
									<a id="siteNameLink" style="float: right; font-weight: bold; font-style: italic; color: #000000;" href="/'.$url.'" target="_blank">'.$name.'</a>
									<br />
									<div style="width: 85px;">
										<table style="border:none;">
										<tr>
										<td>
											<a href="/'.$url.'" target="_blank"><div style="background-image: url(&quot;'.$imageSrc.'&quot;); margin-left: 10px;background-repeat: no-repeat; box-shadow: 4px 4px 6px rgb(0, 0, 0) inset; border-radius: 5px 5px 5px 5px; height: 98px; width: 143px; background-size: 113px auto; background-color: #f5f5f5; background-position: center center;"></div></a>
										</td>
										<td>
											<div style="margin-left: 10px; box-shadow: 4px 4px 6px rgb(0, 0, 0) inset; border-radius: 5px 5px 5px 5px; height: 88px;text-align: justify;padding-top: 10px;padding-right: 10px;padding-left: 11px;overflow-y: auto; width: 226px;  background-color: #f5f5f5;">'.$description.'</div>
										</td>
										<td valign="middle" align="center" style="padding-left:10px;">
														<div class="js-follow-combo follow-combo btn-group js-actionable-user following2 protected" id="followingId'.$ids.'">
													  <a class="follow-btn btn2 js-combo-btn js-recommended-item">
														<div class="js-action-follow follow2-text action-text followLinkButton" id="follow'.$ids.'" alt="'.$ids.'">
														  <i class="follow"></i> 
														  Follow
														</div>
														<div class="js-action-unfollow following-text action-text" id="following'.$ids.'" style="color:#000;">
														  <span style="color:red;">+</span>Following
														</div>
														<div class="js-action-unfollow unfollow-text action-text unf_but" id="unfollow'.$ids.'" alt="'.$ids.'" style="color:#fff;">
														  <span style="color:#000;">x</span>Unfollow
														</div>
													  </a>
														<span href="#" class="btn2 btn-user-actions js-action-profilemenu">
														  <i class="account-arrow"></i>
														</span>
													</div>
													 <div class="js-follow-combo follow-combo btn-group js-actionable-user not-following" id="not-following'.$ids.'" style="display:none;">
											  <a class="follow-btn btn2 js-combo-btn js-recommended-item">
												<div class="js-action-follow follow-text action-text followLinkButton" id="follow'.$ids.'" alt="'.$ids.'" style="border-radius: 4px 4px 4px 4px;color:#000;">
												  <i class="follow"></i>
												  <span style="color:red;">+</span>Follow
												</div>
											  </a>
												<span href="#" class="btn2 btn-user-actions js-action-profilemenu">
												  <i class="account-arrow"></i>
												</span>
											</div>
										</td>
										</tr>
										</table>
									</div>
									<br />
									
								</div>
								<input type="hidden" name="webs_ids" id="webs_ids" value="'.$ids.'" />';
						
							$wala[] = 'meron';
						}
						else
						{
							$wala[] = 'wala';
						}
					}
					
					if(in_array('meron', $wala))
					{
						unset($wala);
					}
					else
					{
						
						echo $msgToUser;
					}
				}
				else
				{
					echo $msgToUser;
				}
			}
			else
			{
				echo "no data";
			}
		}
	}
?>