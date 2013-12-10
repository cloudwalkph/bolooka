<?php

$logged = $this->session->userdata('logged_in');

	
	
	if($logged)
	{
		$userPhoto2 = base_url('img/Default Profile Picture.jpg');
	
		$uid = $this->session->userdata('uid');
		$this->db->where('uid', $uid);
		$query3 = $this->db->get('users');
		$users = $query3->row_array();
		
		$profilePic = $users['profile_picture'];
		if($profilePic != '')
		{
			$profilePic = str_replace(" ","_",$profilePic);
			$userPhoto2 = base_url('uploads/'.$profilePic);
		}

	}
	else
	{
		$userPhoto2 = base_url('img/Default Profile Picture.jpg');
	}
	// echo "<img src='$userPhoto2' style='width: 36px;' />";
?>
<?php
	//////////////////////---Get Album Name---/////////////////////////////
	$getAlbumName = $this->db->query("SELECT * FROM albums WHERE id='$albumId'");
	if($getAlbumName->num_rows() > 0)
	{
		foreach($getAlbumName->result_array() as $galbumrow)
		{
			$galbumname = $galbumrow['album_name'];
		}
	}
	
?>
<?php
	//////////////////////---Get Site Name---/////////////////////////////
	$getAlbumName = $this->db->query("SELECT * FROM albums WHERE id='$albumId'");
	if($getAlbumName->num_rows() > 0)
	{
		foreach($getAlbumName->result_array() as $galbumrow)
		{
			$galbumname = $galbumrow['album_name'];
			$web_idalbum = $galbumrow['web_id'];
			$getWeb = $this->db->query("SELECT * FROM websites WHERE id='$web_idalbum' ORDER BY id LIMIT 1");
			if($getWeb->num_rows() > 0)
			{
				foreach($getWeb->result_array() as $webitems)
				{
					 $wid = $webitems['id'];
					 $siteUrl = $webitems['url'];
				}
			}
		}
	}
	
?>
<?php
	
	
	$getimage = $this->db->query("SELECT * FROM gallery WHERE albums='$albumId' AND id='$imgId' ORDER BY id DESC LIMIT 1");
	if($getimage->num_rows() > 0)
	{
		foreach($getimage->result_array() as $rowsget)
		{
			$imgIdget = $rowsget['id'];
			$imagefileget = $rowsget['image'];
			$imageNameget = $rowsget['image_name'];
			$imagedescrip = $rowsget['descrip'];
			$imageprice = $rowsget['price'];

		}
	}
	else
	{
		
	}
	
	$query = $this->db->query("SELECT * FROM gallery WHERE albums='$albumId' AND id < '$imgId' ORDER BY id DESC LIMIT 1");
	if($query->num_rows() > 0)
	{
		foreach($query->result_array() as $rows)
		{
			$imgsId = $rows['id'];
			$imagefile = $rows['image'];
			$nxtbutton = '<a class="nxtbtn1" style="" href="javascript:void(0)" alt="'.$albumId.'" id="'.$imgsId.'">></a>';
		}
	}
	else
	{
		$nxtbutton = '';
	}
	
	$query2 = $this->db->query("SELECT * FROM gallery WHERE albums='$albumId' AND id > '$imgId' ORDER BY id ASC LIMIT 1");
	if($query2->num_rows() > 0)
	{
		foreach($query2->result_array() as $rows2)
		{
			$prvId = $rows2['id'];
			$imagefile = $rows2['image'];
			$prvbutton = '<a class="prvbtn1" style="" href="javascript:void(0)" alt="'.$albumId.'" id="'.$prvId.'"><</a>';
		}
	}
	else
	{
		$prvbutton = '';
	}
	
?>
<?php

$logged = $this->session->userdata('logged_in');

	
	
	if($logged)
	{
		$userPhoto2 = base_url('img/Default Profile Picture.jpg');
	
		$uid = $this->session->userdata('uid');
		$this->db->where('uid', $uid);
		$query3 = $this->db->get('users');
		$users = $query3->row_array();
		
		$profilePic = $users['profile_picture'];
		if($profilePic != '')
		{
			$profilePic = str_replace(" ","_",$profilePic);
			$userPhoto2 = base_url('uploads/'.$profilePic);
		}

	}
	else
	{
		$userPhoto2 = base_url('img/Default Profile Picture.jpg');
	}
	// echo "<img src='$userPhoto2' style='width: 36px;' />";
?>

<script>
	function showUser2(x, y)
	{
		//$('#showName'+x).html('<?php echo $this->session->userdata('username'); ?>');
		$('#profile'+y).html("<img src='<?php echo $userPhoto2; ?>' style='width: 36px;' />");

		$('#imgc'+y).css('height', '100%');
		$('#imgc'+y).css('width', '80%');
		$('#imgc'+y).css('margin-left', '3px');
		$('#imgc'+y).addClass('commentBoxClass2');
	}
	
	function hideBox(x, y)
	{
		$('#showName'+y).html('');
		$('#imgc'+y).css('height', '100%');
		$('#imgc'+y).removeClass('commentBoxClass2');
		$('#profile'+y).html('');
		$('#imgc'+y).css('margin-left', '-2px');
		$('#imgc'+y).css('width', '96%');
	}
	function deleteComment(x, y, z)
	{
		
		
		 var dataString = 'commentId=' + y + '&msgId=' + z;
		
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>multi/deleteComment3",
			data: dataString,
			cache: false,
			success: function(html)
			{
				$('.commArea'+z).html(html);
				

			}
		}); 
		
	}
</script>
<table style="width: 100%;height: 100%;">
	<tr>
		<td style="background:black;padding:6px;height:100%;width:auto;"><img style="max-height:<?php echo $winhei;?>px;max-width:<?php echo $stagewid;?>px;" src="<?php echo base_url();?>uploads/<?php echo $imagefileget;?>" id="getimg<?php echo $imgIdget;?>" class="theimg" alt="<?php echo $imgIdget;?>" />
		<?php echo $prvbutton; ?>
		<?php echo $nxtbutton; ?>
		</td>
		<td style="width:273px;background:white;" align="right" valign="top">
			
			<div id="right_item" style="width: 100%;height:100%;">
				<table style="width: 100%;height:100%;border: none;">
					<tr>
						<td style="height: 5%;width: 100%;">
						<h1 style="float: left;padding-left: 8px;padding-top: 10px;"><?php echo $imageNameget; ?></h1><span><a class="closelb" href = "javascript:void(0)" style="font-weight: normal;float:right;font-size: 15px;" ><img style="position: relative;" src="<?php echo base_url(); ?>js/jquery.fancybox-1.3.4/fancybox/fancy_close.png" /></a></span>
						</td>
					</tr>
					<tr>
						<td style="height: 40%;overflow: auto;border-bottom: 1px solid #BABABA;" valign="top" align="left">
						<h3 style="float: left;margin-left: 9px;width: 93%;margin-right: 14px;text-align: left;font-weight: normal;font-family: arial;"><?php echo $imagedescrip; ?></h3>
						</td>
					</tr>
					<tr>
						<td style="height: 50%;overflow: auto;" valign="top" align="left">
							<!-- START COMMENT AREA -->
								<table style="width: 100%;height:100%;border: none;">
									<tr>
										<td style="width: 100%;height: 85%;text-align: left;font-family: arial;">
											<div class="commArea<?php echo $imgId; ?>" style="height: 100%;overflow-x: hidden;overflow-y: auto;width: 100%;">
												<ul style="padding: 0;margin:0;">
													<?php
														$queryCommArea = $this->db->query("SELECT * FROM comments WHERE msg_id_fk='$imgId' ORDER BY com_id ASC");
														if($queryCommArea->num_rows() > 0)
														{
															foreach($queryCommArea->result_array() as $rowComments)
															{
																$comments = $rowComments['comment'];
																$com_id = $rowComments['com_id'];
																$usercom = $rowComments['uid_fk'];
																$createdss = $rowComments['created'];
																$userPost = $this->session->userdata('uid');
																$webPost = $this->session->userdata('website');
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
																	echo '<li style="list-style: none outside none;margin: 0;padding: 5px 5px 4px;margin-top: 1px;border-radius: 0 0 0 0;border-bottom: 1px inset;min-height: 38px;">
																				<div style="line-height: 1.28;display: block;">
																					<img src="'.base_url().$userPhoto.'" style="width: 36px;height:36px;margin-right: 8px;float: left;display: block;" />
																					<a href="#" style="float: right;display: inline-block;" onclick="deleteComment(this, '.$com_id.', '.$imgId.')">x</a>
																					<div style="padding-left:44px;">
																					<a href="#"><strong>'.$first_name.'</strong></a>
																					<span style="font-size: 11px;word-wrap: break-word;">'.$comments.'</span>
																					<div style="font-size: 10px;font-style: italic;padding-top: 2px;">'.$this->times_model->makeAgo($createdss).'</div>
																					</div>
																				</div>
																				</li>';
																}
																else
																{
																	echo '<li style="list-style: none outside none;margin: 0;padding: 5px 5px 4px;margin-top: 1px;border-radius: 0 0 0 0;border-bottom: 1px inset;min-height: 38px;">
																				<div style="line-height: 1.28;display: block;">
																					<img src="'.base_url().$userPhoto.'" style="width: 36px;height:36px;margin-right: 8px;float: left;display: block;" />
																					
																					<div style="padding-left:44px;">
																					<a href="#"><strong>'.$first_name.'</strong></a>
																					<span style="font-size: 11px;word-wrap: break-word;">'.$comments.'</span>
																					<div style="font-size: 10px;font-style: italic;padding-top: 2px;">'.$this->times_model->makeAgo($createdss).'</div>
																					</div>
																				</div>
																				</li>';
																}
																
																
															}
														}
														
													?>
												</ul>
											</div>
										</td>
									</tr>
									<tr>
										<td style="height: 15%;">
											<?php
												if($logged)
												{
											?>
										<div id="profile<?php echo $imgId; ?>" style="float:left;margin-left: 0px;"></div>
										<?php 
											$query9 = $this->db->query("SELECT * FROM pages WHERE website_id='".$wid."' AND type='photo' ");
											$row9 = $query9->row_array();
										?>
										<span id="<?php echo $uid; ?>" class="hiddenData" alt="<?php echo $wid; ?>" style="display: none;"><?php echo $pid ? $pid : $row9['id']; ?></span>
										<textarea placeholder="write a comment..." alt="<?php echo $imgId; ?>" id="imgc<?php echo $imgId; ?>" onfocus="showUser2(this, <?php echo $imgId; ?>)" style="width:96%;border-radius: 0px;height:100%;margin-left: -2px;" onblur="hideBox(this, <?php echo $imgId; ?>)"></textarea>
											<?php
												}
											?>
										
										</td>
									</tr>
								</table>
							<!-- END COMMENT AREA -->
						</td>
					</tr>
				</table>
			</div>
		</td>
	</tr>
</table>