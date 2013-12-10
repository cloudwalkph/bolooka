<?php $this->load->model('times_model'); ?>
<div style="height:auto;min-height:50px;">
					<div class="commArea<?php echo $msg_id; ?>">
					<ul>
		<?php
						$queryCommArea = $this->db->query("SELECT * FROM comments WHERE msg_id_fk='$msg_id' ORDER BY com_id ASC");
						$numComments = $queryCommArea->num_rows();
						$userPost = $this->session->userdata('uid');
						$webPost = $this->session->userdata('website');
							if($numComments > 3)
							{
								echo '<div id="view'.$msg_id.'" onclick="viewall(this, '.$msg_id.')" style="opacity: 0.6;padding-top: 5px;cursor: pointer;background:#DDDDDD;color:#555553;padding-bottom: 6px;"><span style="margin-left: 111px;">View All '.$numComments.' Comments</span></div>';
								//echo $webPost.' '.$userPost;
								//echo '<div onclick="viewall(this, '.$msg_id.')" style="width: 100%;height: 30px;background: none repeat scroll 0 0 #000000;"></div>';
								$showOne = $this->db->query("SELECT * FROM comments WHERE msg_id_fk='$msg_id' ORDER BY com_id DESC");
								//$showtwo = $this->db->query("SELECT * FROM comments WHERE msg_id_fk='$msg_id' ORDER BY com_id DESC LIMIT 2");
								
								$firstRow = $showOne->first_row();
								$nextRow = $showOne->next_row();

								/* for previus comment */
								
								$commentsnext = $nextRow->comment;
								$com_idnext = $nextRow->com_id;
								$usercomnext = $nextRow->uid_fk;
								$createdssnext = $nextRow->created;
								
								/* for last comment */
								
								$commentsfirst = $firstRow->comment;
								$com_idfirst = $firstRow->com_id;
								$usercomfirst = $firstRow->uid_fk;
								$createdssfirst = $firstRow->created;
								
								/* for previus comment */
								
								$usercomname = $this->db->query("SELECT * FROM users WHERE uid='$usercomnext' ORDER BY uid DESC LIMIT 1");
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
										
									//	if($usercomnext == $userPost)
										if(($numWebsites > 0) OR ($usercomnext == $userPost))
										{
											echo '<li style="margin: 0;padding: 5px 5px 4px;margin-top: 1px;border-radius: 0 0 0 0;border-bottom: 1px solid;">
													<div style="line-height: 1.28;display: block;">
														<img src="'.base_url($userPhoto).'" style="width:36px;height:36px;float:left; margin-right:8px: display: block;" />
														<a href="#" style="float: right;display: inline-block;" onclick="deleteComment(this, '.$com_idnext.', '.$msg_id.')">x</a>
														<div style="padding-left:44px;color: #555555;">
														<a href="#">'.$first_name.'</a>
														<span style="font-size: 11px;">'.$commentsnext.'</span>
														<div style="font-size: 10px;font-style: italic;padding-top: 2px;">'.$this->times_model->makeAgo($createdssnext).'</div>
														</div>
													</div>
													</li>';
											
										
										}
										else
										{
											echo '<li style="margin: 0;padding: 5px 5px 4px;margin-top: 1px;border-radius: 0 0 0 0;border-bottom: 1px solid;">
													<div style="line-height: 1.28;display: block;">
														<img src="'.base_url($userPhoto).'" style="width:36px;height:36px;float:left;margin-right:8px: display: block;" />
														
														<div style="padding-left:44px;color: #555555;">
														<a href="#">'.$first_name.'</a>
														<span style="font-size: 11px;">'.$commentsnext.'</span>
														<div style="font-size: 10px;font-style: italic;padding-top: 2px;">'.$this->times_model->makeAgo($createdssnext).'</div>
														</div>
													</div>
													</li>';
											
										
										}
								}
								/* for last comment */
								
								$usercomnamefirst = $this->db->query("SELECT * FROM users WHERE uid='$usercomfirst' ORDER BY uid DESC LIMIT 1");
								if($usercomnamefirst->num_rows() > 0)
								{
										foreach($usercomnamefirst->result_array() as $rownamefirst)
										{
											$first_namefirst = $rownamefirst['first_name'];
											$profilePicTofirst = $rownamefirst['profile_picture'];
										}
										$profilePicTofirst = str_replace(" ","_",$profilePicTofirst);
										if($profilePicTofirst == null)
										{
											$userPhotofirst = 'img/Default Profile Picture.jpg';
										}
										else
										{
											$userPhotofirst = 'uploads/'.$profilePicTofirst;
										}
										
										$websitepost2 = $this->db->query("SELECT * FROM websites WHERE user_id='$userPost' AND id='$webPost'");
										$numWebsites2 = $websitepost2->num_rows();
										
										if(($numWebsites > 0) OR ($usercomfirst == $userPost))
										{
											
											echo '<li style="margin: 0;padding: 5px 5px 4px;margin-top: 1px;border-radius: 0 0 0 0;border-bottom: 1px solid;">
													<div style="line-height: 1.28;display: block;">
														<img src="'.base_url().$userPhotofirst.'" style="width:36px;height:36px;float:left;margin-right:8px; display: block;" />
														<a href="#" style="float: right;display: inline-block;" onclick="deleteComment(this, '.$com_idfirst.', '.$msg_id.')">x</a>
														<div style="padding-left:44px;color: #555555;">
														<a href="#">'.$first_namefirst.'</a>
														<span style="font-size: 11px;">'.$commentsfirst.'</span>
														<div style="font-size: 10px;font-style: italic;padding-top: 2px;">'.$this->times_model->makeAgo($createdssfirst).'</div>
														</div>
													</div>
													</li>';
										}
										else
										{
											echo '<li style="margin: 0;padding: 5px 5px 4px;margin-top: 1px;border-radius: 0 0 0 0;border-bottom: 1px solid;">
													<div style="line-height: 1.28;display: block;">
														<img src="'.base_url().$userPhotofirst.'" style="width:36px;height:36px;float:left;margin-right:8px: display: block;" />
														
														<div style="padding-left:44px;color: #555555;">
														<a href="#">'.$first_namefirst.'</a>
														<span style="font-size: 11px;">'.$commentsfirst.'</span>
														<div style="font-size: 10px;font-style: italic;padding-top: 2px;">'.$this->times_model->makeAgo($createdssfirst).'</div>
														</div>
													</div>
													</li>';
										
										}
								}
								//echo '<li>'.$nextRow->com_id.'</li>'; 
								//echo '<li>'.$firstRow->com_id.'</li>';
								
								
							
								
								
								echo '<input type="hidden" class="viewinput" name="'.$msg_id.'" id="viewthis'.$msg_id.'" value="'.$nextRow->com_id.'" >';
								
									
									
								}
								else
								{
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
																			<div style="font-size: 10px;font-style: italic;padding-top: 2px;">'.$this->times_model->makeAgo($createdss).'</div>
																			</div>
																		</div>
																		</li>';
												//echo '<li>'.$first_name.'-'.$comments.'-'.$this->times_model->makeAgo($created).'</li>';
											}
										}
										
										
										
										
									//echo '<font color="red">'.$usercom.'>>'.$this->session->userdata('uid').'</font>';
										
										
										
									}
								}
							?>
										</ul></div>
										<div id="showText<?php echo $msg_id; ?>" class="<?php echo $wid; ?>">
										<p id="showName<?php echo $msg_id; ?>"></p> 
							<?php
								if($logged)
								{
									
							?>
										<div id="profile<?php echo $msg_id; ?>" style="float: left; width: 40px; height: 40px;display:none"></div>
										<textarea placeholder="write a comment..." id="blogcom<?php echo $msg_id; ?>" alt="<?php echo $msg_id; ?>" title="notview" onfocus="showUser2h(this, <?php echo $msg_id; ?>)" style="font-family: helvetica;width: 98%; float: right;" onblur="hideBox(this, <?php echo $msg_id; ?>)"></textarea>
							<?php
								}
							?>
										
										</div>
										</div>