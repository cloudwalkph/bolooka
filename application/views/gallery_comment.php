<link rel="stylesheet" href="<?php echo base_url(); ?>css/wall.css" type="text/css"/>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.oembed.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.form.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/blog.js"></script>
<script type="text/javascript">
$('.viewUpload').live('click',function(){
	$('#uploadFile').toggle('slow');   
	$('.wallUp').css('display','block');
	if($('#uploadFile').is(':visible')) {
		$('#uploadFile').val('');
	}
});
</script>

	<div id="wrapper">
		<?php 
			$form_attrib = array('name' => 'form_wall','id' => 'imageform');
			echo form_open_multipart('wall/upwallimage', $form_attrib); 
		?>
			<input name="current_img" id="current_img" type="hidden"/> 
			<input name="ajax_flag" id="ajax_flag" type="hidden"/>
			

		<div id="textareaWrap">
			<textarea id="wall"></textarea>
			<div id="fetched_data">
				<div id="loader"> </div>
				<div id="ajax_content"></div>
			</div>
			<div id="sharebtn">
				<a class="button Share link" id="<?php echo $this->session->userdata('website_id'); ?>">Share</a>
			</div>
		</form>
		</div> 
		<!-- wall starts here -->
		<div id="wallz" class="fb_wall">
			<ul id="posts" style="height: 500px; overflow-y: scroll;">
			
		<?php
				// $uid = $this->session->userdata('uid');
				$uid = $this->session->userdata('website_id');
				$query = $this->wall_updates->post_share(0, $uid);
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
		<li> <center>
		<?php
						$query52 = $this->db->query("SELECT * FROM upload_counter WHERE albumid='$album_id' AND addeds='$msg_id' ORDER BY id DESC");
						if($query52->num_rows() > 0)
						{
							$query5 = $this->db->query("SELECT * FROM upload_counter WHERE albumid='$album_id' AND addeds='$msg_id' ORDER BY id DESC");
							if($query5->num_rows() >= 3)
								{

									//$query4 = $this->db->query("SELECT * FROM gallery WHERE albums='$album_id' ORDER BY id DESC LIMIT 3");
									$row4 = $query5->row_array(0);
									$row5 = $query5->row_array(1);
									$row6 = $query5->row_array(2);
									
									echo '<table style="border: none;">
									  <tr>
										<td rowspan="2" valign="top">
										<img style="float: left;height: 133px;padding-right: 4px;width: 184px;" class="external_pic" src="'.base_url().'img/crop.php?w=184&h=133&f='.base_url().'uploads/'.$row4['extra1'].'"/>
										</td>
										<td valign="top">
										<img style="float: left;padding-bottom: 4px;width: 105px;height: 64px;" class="external_pic" src="'.base_url().'img/crop.php?w=105&h=64&f='.base_url().'uploads/'.$row5['extra1'].'"/>
										</td>
									  </tr>
									  <tr>
										<td valign="top">
										<img style="width: 105px;height: 63px;" class="external_pic" src="'.base_url().'img/crop.php?w=105&h=63&f='.base_url().'uploads/'.$row6['extra1'].'"/>
										</td>
									  </tr>
									</table>';
								}
								if($query5->num_rows() == 1)
									{
										//$query4 = $this->db->query("SELECT * FROM gallery WHERE albums='$album_id' ORDER BY id DESC LIMIT 1");
										$row4 = $query5->row_array(0);
										
										echo '<table style="border: none;">
										  <tr>
											<td rowspan="2" valign="top">
											<img style="float: left;padding-right: 4px;width: 300px;" class="external_pic" src="'.base_url().'uploads/'.$row4['extra1'].'"/>
											</td>
										  </tr>
										</table>';
									}
									if($query5->num_rows() == 2)
								{
									//$query4 = $this->db->query("SELECT * FROM gallery WHERE albums='$album_id' ORDER BY id DESC LIMIT 2");
									$row4 = $query5->row_array(0);
									$row5 = $query5->row_array(1);
									
									echo '<table style="border: none;">
									  <tr>
										<td valign="top">
										<img style="float: left;height: 133px;padding-right: 4px;width: 184px;" class="external_pic" src="'.base_url().'img/crop.php?w=184&h=133&f='.base_url().'uploads/'.$row4['extra1'].'"/>
										</td>
										<td valign="top">
										<img style="float: left;padding-bottom: 4px;width: 105px;height: 133px;" class="external_pic" src="'.base_url().'img/crop.php?w=105&h=133&f='.base_url().'uploads/'.$row5['extra1'].'"/>
										</td>
									  </tr>
									</table>';
								}
						}
		?>
					<div style="width:343px;height:auto;min-height:50px;">
					<div class="commArea<?php echo $msg_id; ?>"><ul>
		<?php
						$queryCommArea = $this->db->query("SELECT * FROM comments WHERE msg_id_fk='$msg_id' ORDER BY com_id ASC");
						foreach($queryCommArea->result_array() as $rowComments)
						{
							$comments = $rowComments['comment'];
							$com_id = $rowComments['com_id'];
							$usercom = $rowComments['uid_fk'];
							$createdss = $rowComments['created'];
							$userPost = $this->session->userdata('uid');
							$usercomname = $this->db->query("SELECT * FROM users WHERE uid='$usercom' ORDER BY uid DESC LIMIT 1");
							foreach($usercomname->result_array() as $rowname)
							{
								$first_name = $rowname['first_name'];
							}
							if($usercom == $userPost)
							{
								echo '<li style="list-style: none;background: none repeat scroll 0 0 transparent;text-align: left;padding:0;margin:0;"><div style="border-bottom: 1px dashed #000000;width: 299px;">
								<div style="font-size: 17px;font-weight: bold;">'.$first_name.'<span style="cursor:pointer;float: right;font-weight: normal;" onclick="deleteComment(this, '.$com_id.', '.$msg_id.')">X</span></div>
								<div style="width: 293px;height: auto;font-size: 14px;">'.$comments.'</div>
								<div style="font-size: 12px; font-style: italic;">'.$this->times_model->makeAgo($createdss).'</div>
								</div>
								</li>';
							}
							else
							{
								echo '<li style="list-style: none;background: none repeat scroll 0 0 transparent;text-align: left;padding:0;margin:0;"><div style="border-bottom: 1px dashed #000000;width: 299px;">
								<div style="font-size: 17px;font-weight: bold;">'.$first_name.'</div>
								<div style="width: 293px;height: auto;font-size: 14px;">'.$comments.'</div>
								 
								</div>
								</li>';
							}
					//<div style="font-size: 12px; font-style: italic;">'.$this->times_model->makeAgo($createdss).'</div>		
							
						}
		?>
					</ul></div>
					<div id="showText<?php echo $msg_id; ?>">
					<p id="showName<?php echo $msg_id; ?>"></p>
					<textarea placeholder="write a comment..." id="<?php echo $msg_id; ?>" onfocus="showUser2(this.id)" style="width:300px;height:15px;margin-left: 30px;" onblur="hideBox(this.id)"></textarea>
					</div>
					</div>
		</center>
		</li>	
		<?php
					}
					
					if($album_id == '0')
					{
		?>
				<li> 
					<img class="avatar"> 
					<div class="status"> 
						<h2><a target="_blank" href="#"></a></h2> 
						<p class="message"><?php echo $row->message; ?></p> 
						<div id="preview"></div>
							<?php echo html_entity_decode($row->image, ENT_QUOTES); ?>
							
							<div class="data">
								<p class="name"><?php echo $row->title; ?><a target="_blank"></a></p>
								<p class="caption"><a href="<?php echo $row->url; ?>" target="_blank"><?php echo $row->url; ?></a> </p>
								<p class="description"><?php echo $row->description; ?> </p>  
							</div>
					</div>
					<p class="likes"></p>
					<center>
					<div style="width:343px;height:auto;min-height:50px;">
					<div class="commArea<?php echo $msg_id; ?>"><ul>
		<?php
						$queryCommArea = $this->db->query("SELECT * FROM comments WHERE msg_id_fk='$msg_id' ORDER BY com_id ASC");
						foreach($queryCommArea->result_array() as $rowComments)
						{
							$comments = $rowComments['comment'];
							$com_id = $rowComments['com_id'];
							$usercom = $rowComments['uid_fk'];
							$createdss = $rowComments['created'];
							$userPost = $this->session->userdata('uid');
							$usercomname = $this->db->query("SELECT * FROM users WHERE uid='$usercom' ORDER BY uid DESC LIMIT 1");
							foreach($usercomname->result_array() as $rowname)
							{
								$first_name = $rowname['first_name'];
							}
							if($usercom == $userPost)
							{
								echo '<li style="list-style: none;background: none repeat scroll 0 0 transparent;text-align: left;padding:0;margin:0;"><div style="border-bottom: 1px dashed #000000;width: 299px;">
								<div style="font-size: 17px;font-weight: bold;">'.$first_name.'<span style="cursor:pointer;float: right;font-weight: normal;" onclick="deleteComment(this, '.$com_id.', '.$msg_id.')">X</span></div>
								<div style="width: 293px;height: auto;font-size: 14px;">'.$comments.'</div>
								<div style="font-size: 12px; font-style: italic;">'.$this->times_model->makeAgo($createdss).'</div>
								</div>
								</li>';
							}
							else
							{
								echo '<li style="list-style: none;background: none repeat scroll 0 0 transparent;text-align: left;padding:0;margin:0;"><div style="border-bottom: 1px dashed #000000;width: 299px;">
								<div style="font-size: 17px;font-weight: bold;">'.$first_name.'</div>
								<div style="width: 293px;height: auto;font-size: 14px;">'.$comments.'</div>
								<div style="font-size: 12px; font-style: italic;">'.$this->times_model->makeAgo($createdss).'</div>
								</div>
								</li>';
							}
							
							
						}
		?>
					</ul></div>
					<div id="showText<?php echo $msg_id; ?>">
					<p id="showName<?php echo $msg_id; ?>"></p>
					<textarea placeholder="write a comment..." id="<?php echo $msg_id; ?>" onfocus="showUser2(this.id)" style="width:300px;height:15px;margin-left: 30px;" onblur="hideBox(this.id)"></textarea>
					</div>
					</div>
					</center>
				</li>	
	
	
	
		<?php
					}
	
				}
		?>			
			</ul>
		</div>
		<!-- wall Ends here --> 
	</div>