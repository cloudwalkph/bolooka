<?php
	$uid = $wid;
	foreach ($query->result() as $row)
	{
		$created = $row->created;
		$album_id = $row->album_id;
		$msg_id = $row->msg_id;
		$uid_fk = $row->uid_fk;
		$message = $row->message;
		$description = $row->description;
		$image_name = $row->image_name;
		$images = $row->image;
		$imageUrl = $row->imageUrl;
		$titles = $row->title;
		$url_web = $row->url;

		if($album_id != '0')
		{
?>
<!--		<li class="blog-item-list" alt="<?php //echo $msg_id; ?>">
			<a onclick="deleteblog<?php //echo $pid; ?>(this, '<?php //echo $msg_id; ?>','<?php //echo $pid; ?>')"><img style="cursor: pointer;float:right;" src="<?php echo base_url(); ?>js/jquery.fancybox-1.3.4/fancybox/fancy_close.png" /></a>
			<div id=""></div>-->
<?php
			// $albumPics = $this->db->query("SELECT * FROM gallery WHERE albums='$album_id' ORDER BY id DESC");

			// if($albumPics->num_rows() == 1)
			// {
				// /* echo 'isa'; */
				// $row4 = $albumPics->row_array(0);
				// echo '
					// <table style="border: none;">
						// <tr>
							// <td rowspan="2" valign="top">
								// <img style="float: left;width: 372px;border: 1px solid #000000;" class="external_pic" src="'.base_url().$this->crop_img->image('uploads/'.$row4['image'].'', 372, 297).'"/>
							// </td>
						// </tr>
					// </table>
				// ';
			// }
						
			// if($albumPics->num_rows() == 2)
			// {
				// /* echo 'dalawa'; */
				// $row4 = $albumPics->row_array(0);
				// $row5 = $albumPics->row_array(1);
				// echo '
					// <table style="border: none;">
						// <tr>
							// <td valign="top" style="padding-right: 4px;">
								// <img style="float: left;height: 162px;border: 1px solid #000000;width: 236px;" class="external_pic" src="'.base_url().$this->crop_img->image('uploads/'.$row4['image'].'', 236, 162).'"/>
							// </td>
							// <td valign="top">
								// <img style="float: left;border: 1px solid #000000;width: 123px;height: 162px;" class="external_pic" src="'.base_url().$this->crop_img->image('uploads/'.$row5['image'].'', 123, 162).'"/>
							// </td>
						// </tr>
					// </table>
				// ';
			// }
						
			// if($albumPics->num_rows() >= 3)
			// {
				// /* echo 'tatlo'; */
				// $row4 = $albumPics->row_array(0);
				// $row5 = $albumPics->row_array(1);
				// $row6 = $albumPics->row_array(2);
				// echo '
					// <table style="border: none;">
						// <tr>
							// <td rowspan="2" valign="top" style="padding-right: 4px;">
								// <img style="float: left;height: 165px;width: 236px;border: 1px solid #000000;" class="external_pic" src="'.base_url().$this->crop_img->image('uploads/'.$row4['image'].'', 236, 165).'"/>
							// </td>
							// <td valign="top" style="padding-bottom: 4px;">
								// <img style="float: left;width: 127px;height: 79px;border: 1px solid #000000;" class="external_pic" src="'.base_url().$this->crop_img->image('uploads/'.$row5['image'].'', 127, 79).'"/>
							// </td>
						// </tr>
						// <tr>
							// <td valign="top">
								// <img style="width: 127px;height: 78px;border: 1px solid #000000;" class="external_pic" src="'.base_url().$this->crop_img->image('uploads/'.$row6['image'].'', 127, 79).'"/>
							// </td>
						// </tr>
					// </table>
				// ';
			// }
?>
<!--			<div style="width:343px;height:auto;min-height:50px;">
				<div class="commArea<?php //echo $msg_id; ?>">
					<ul>-->
					<!--COMMENT START GALLERy-->
<?php
						/* $queryCommArea = $this->db->query("SELECT * FROM comments WHERE msg_id_fk='$msg_id' ORDER BY com_id ASC");
						foreach($queryCommArea->result_array() as $rowComments)
						{
							$comments = $rowComments['comment'];
							$com_id = $rowComments['com_id'];
							$usercom = $rowComments['uid_fk'];
							$createdss = $rowComments['created'];
							$userPost = $this->session->userdata('uid');
							$webPost = $wid;
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
							if($numWebsites > 0)
							{
								
								echo '
								<li style="width: 313px;padding: 14px 0;border-bottom: 1px inset;border-radius: 0 0 0 0;list-style: none;background: none repeat scroll 0 0 transparent;text-align: left;">
									<img src="'.base_url().$userPhoto.'" style="width: 36px;" />
									<span style="cursor:pointer;float: right;font-weight: normal;" onclick="deleteComment(this, '.$com_id.', '.$msg_id.')">X</span>
									<div style="margin-left: 6px;display:inline-block; vertical-align: top;font-size: 12px;font-weight: bold;color: #4C4646;">'.$first_name.'</div>
									<div style="display: inline-block;word-wrap: break-word;font-size: 12px;vertical-align: top;width: 180px;padding-bottom: 20px;">'.$comments.'</div>
									<div style="margin-top: -18px;margin-left: 43px;font-size: 10px; font-style: italic;color: #555553;">'.$this->times_model->makeAgo($createdss).'</div>
								</li>';
							}
							else
							{
								echo '
								<li style="width: 313px;padding: 14px 0;border-bottom: 1px inset;border-radius: 0 0 0 0;list-style: none;background: none repeat scroll 0 0 transparent;text-align: left;">
									<img src="'.base_url().$userPhoto.'" style="width: 36px;" />
									<div style="margin-left: 6px;display:inline-block; vertical-align: top;font-size: 12px;font-weight: bold;color: #4C4646;">'.$first_name.'</div>
									<div style="display: inline-block;word-wrap: break-word;font-size: 12px;vertical-align: top;width: 180px;padding-bottom: 20px;">'.$comments.'</div>
									<div style="margin-top: -18px;margin-left: 43px;font-size: 10px; font-style: italic;color: #555553;">'.$this->times_model->makeAgo($createdss).'</div>
								</li>';
							}
						} */
?>
<!--					</ul>
				</div>
				<br />
				<div id="showText<?php //echo $msg_id; ?>">
					<div id="profile<?php //echo $msg_id; ?>" style="float: left;margin-left: 15px;"></div>
					<textarea placeholder="write a comment..." id="<?php //echo $msg_id; ?>" onfocus="showUser2(this.id)" style="width:300px;height:15px;margin-left: -9px;background-color: #E9E9E9;border: 1px solid #C4C4C4;border-radius: 10px 10px 10px 10px;padding: 3px;resize: none;" onblur="hideBox(this.id)"></textarea>
				</div>
			</div>
		</li>	-->
<?php
		}
		
		if($album_id == '0')
		{
?>
				<li class="blog-item-list" alt="<?php echo $msg_id; ?>"> <a onclick="deleteblog<?php echo $pid; ?>(this, '<?php echo $msg_id; ?>','<?php echo $pid; ?>')"><img style="cursor: pointer;float:right;" src="<?php echo base_url(); ?>js/jquery.fancybox-1.3.4/fancybox/fancy_close.png" title="Delete this post"/></a><div id=""></div>
					<img class="avatar"> 
					
					<div id="editStatus" class="status"> 
						<h2><a target="_blank" href="#"></a></h2>
						<?php if($row->message) { ?>
							<p class="message" style="text-align: left;margin: 0 15px;width: 415px;"><?php echo $row->message; ?></p> 
						<?php } ?>
						<div id="preview"></div><br/>
							<?php //echo html_entity_decode($row->image, ENT_QUOTES); ?>
							<div class="img_attachment" style="">
							
							<?php
								if(($url_web != ' ') OR ($url_web != null)){
									
									$detect = $this->video_model->detect_url($url_web);
									if($detect == 'no video'){
										if(strripos($url_web, 'http') === false)
										{
											/* DO NOTHING */
										}else{
											if($imageUrl == 'undefined'){
												/*DO NOTHING*/
											}else{
										
												echo '
												<div id="image_div" style="border: 1px solid rgb(221, 221, 221); position: relative; vertical-align: top; float: left;">
													<img class="external_pic" src="'.$imageUrl.'" style="width: 160px;"/>
												</div>
												<div class="data" style="border: 1px solid rgb(221, 221, 221); text-align: left; height: 108px;padding-left: 185px;">
													<p class="name" style="font-size: 1em;">'.$row->title.'<a target="_blank"></a></p>
													<p class="caption" style="margin: 0;font-size: 1em;font-size: 1em;width: 100%;text-overflow: ellipsis;white-space: nowrap;overflow: hidden;"><a style="color: #000000;"href="'.$row->url.'" target="_blank">'.$row->url.'</a> </p>
													<p class="description trim" style="display: block;margin: 0 0 1px 0;height: 50px;overflow: hidden;">'.html_entity_decode($row->description, ENT_QUOTES).'</p>  
												</div>
												';
												
											}
										
										}
										
									}elseif($detect == 'dailymotion'){
										echo '
										<div id="image_div" style="border: 1px solid rgb(221, 221, 221); position: relative; vertical-align: top; float: left;">
											<img style="position: absolute; cursor: pointer; width: 30px; top: -1px; bottom: -1px; left: -1px; right: -1px; margin: auto;" class="playButtonBlog" src="../../img/playbtn.png" />
											<img class="external_pic" src="'.$imageUrl.'" style=""/>
										</div>
										<div class="data" style="border: 1px solid rgb(221, 221, 221); text-align: left; height: 108px;padding-left: 185px;">
											<p class="name" style="font-size: 1em;">'.$row->title.'<a target="_blank"></a></p>
											<p class="caption" style="margin: 0;font-size: 1em;font-size: 1em;width: 100%;text-overflow: ellipsis;white-space: nowrap;overflow: hidden;"><a style="color: #000000;"href="'.$row->url.'" target="_blank">'.$row->url.'</a> </p>
											<p class="description trim" style="display: block;margin: 0 0 1px 0;height: 50px;overflow: hidden;">'.html_entity_decode($row->description, ENT_QUOTES).'</p>  
										</div>
										';
									
									}else{
										echo '
										<div id="image_div" style="border: 1px solid rgb(221, 221, 221); position: relative; vertical-align: top; float: left;">
											<img style="position: absolute; cursor: pointer; width: 30px; top: -1px; bottom: -1px; left: -1px; right: -1px; margin: auto;" class="playButtonBlog" src="../../img/playbtn.png" />
											<img class="external_pic" src="'.$imageUrl.'" style=""/>
										</div>
										<div class="data" style="border: 1px solid rgb(221, 221, 221); text-align: left; height: 108px;padding-left: 185px;">
											<p class="name" style="font-size: 1em;">'.$row->title.'<a target="_blank"></a></p>
											<p class="caption" style="margin: 0;font-size: 1em;font-size: 1em;width: 100%;text-overflow: ellipsis;white-space: nowrap;overflow: hidden;"><a style="color: #000000;"href="'.$row->url.'" target="_blank">'.$row->url.'</a> </p>
											<p class="description trim" style="display: block;margin: 0 0 1px 0;height: 50px;overflow: hidden;">'.html_entity_decode($row->description, ENT_QUOTES).'</p>  
										</div>
										';
									}
								}
								if($image_name){
									$margin_left = '-5px';
									$text = $image_name;
									$text = str_replace(" ","_",$text);
									echo '<div id="image_div" style="position: relative; float: left;">
										<img class="external_pic" src="'. base_url('uploads/'.$text) .'"style="max-width: none;height: 160px;" /></div>';
								}else
								{
									$margin_left = '-142px';
								}
							?>
							
							<!--<img class="external_pic" src="<?php //echo $imageUrl; ?>" style="width: 300px;"/>-->
								
							</div>
					</div>
					<p class="likes"></p>

					<div style="margin-top: 10px;">
					<div class="commArea<?php echo $msg_id; ?>" style="text-align: left;">
					<ul>
		<?php
						$queryCommArea = $this->db->query("SELECT * FROM comments WHERE msg_id_fk='$msg_id' ORDER BY com_id ASC");
						foreach($queryCommArea->result_array() as $rowComments)
						{
							$comments = $rowComments['comment'];
							$com_id = $rowComments['com_id'];
							$usercom = $rowComments['uid_fk'];
							$createdss = $rowComments['created'];
							$userPost = $this->session->userdata('uid');
							$webPost = $wid;
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
							if($numWebsites > 0)
							{
							
								echo '<li style="width: 645px;padding: 10px 5px;border-bottom: 1px inset;border-radius: 0 0 0 0;list-style: none;background: #ddd;text-align: left;margin-bottom: 0px;">
								<img src="'.base_url().$userPhoto.'" style="width: 36px;" />
								<span style="cursor:pointer;float: right;font-weight: normal;" onclick="deleteComment(this, '.$com_id.', '.$msg_id.')"><img src="'.base_url('img/deleteIcon.png').'" title="Remove this comment"/></span>
								<div style="margin-left: 6px;display:inline-block; vertical-align: top;font-size: 12px;font-weight: bold;color: #4C4646;width: 65px;text-overflow: ellipsis;white-space: nowrap;overflow: hidden;" title="'.$first_name.'">'.$first_name.'</div>
								<div style="display: inline-block;word-wrap: break-word;font-size: 12px;vertical-align: top;width: 515px;padding-bottom: 20px;">'.$comments.'</div>
								<div style="margin-top: -18px;margin-left: 43px;font-size: 10px; font-style: italic;color: #555553;">'.$this->times_model->makeAgo($createdss).'</div>
								
								</li>';
							}
							else
							{
								echo '<li style="width: 645px;padding: 10px 5px;border-bottom: 1px inset;border-radius: 0 0 0 0;list-style: none;background: #ddd;text-align: left;margin-bottom: 0px;">
										<img src="'.base_url().$userPhoto.'" style="width: 36px;" />
										
										<div style="margin-left: 6px;display:inline-block; vertical-align: top;font-size: 12px;font-weight: bold;color: #4C4646;width: 65px;text-overflow: ellipsis;white-space: nowrap;overflow: hidden;" title="'.$first_name.'">'.$first_name.'</div>
										<div style="display: inline-block;word-wrap: break-word;font-size: 12px;vertical-align: top;width: 515px;padding-bottom: 20px;">'.$comments.'</div>
										<div style="margin-top: -18px;margin-left: 43px;font-size: 10px; font-style: italic;color: #555553;">'.$this->times_model->makeAgo($createdss).'</div>
								
									</li>';
							}
							
							
						}
?>
					</ul></div>
					<br/>
						<div id="showText<?php echo $msg_id; ?>" style="text-align: left;padding: 5px;display: inline-block;">
							<!--<div id="profile<?php echo $msg_id; ?>" style="float: left;margin-left: -1px;"></div>-->
							<?php
								$userPic = base_url('img/Default Profile Picture.jpg');
							
								$this->db->where('uid',$this->session->userdata('uid'));
								$getUserQuery = $this->db->get('users');
								$userRow = $getUserQuery->row_array();
								
								if($getUserQuery->num_rows() > 0)
								{
									$profPic = $userRow['profile_picture'];
									$profPic = str_replace(" ","_",$profPic);
									$userPic = base_url('uploads/'.$profPic);
								}
							?>
							<img src="<?php echo $userPic; ?>" style="width: 36px;height: 36px;margin-top: -2px;" />
							<textarea placeholder="write a comment..." id="<?php echo $msg_id; ?>" onfocus="showUser2(this.id)" style="width: 595px;height: 15px;border: 1px solid #C4C4C4;padding: 3px;resize: none;background: #DDD;border-radius: 10px;"></textarea>
						</div>
					</div>

				</li>	
	
	
	
<?php
					}
	
	}
?>	