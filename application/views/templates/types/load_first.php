<?php 
	if($query->num_rows() > 0) {
		foreach ($query->result() as $row)
		{
			$album_id = $row->album_id;
			$image_name = $row->image_name;
			$created = $row->created;
			$msg_id = $row->msg_id;
			$uid_fk = $row->uid_fk;
			$message = $row->message;
			$description = $row->description;
			$images = $row->image;
			$imageUrl = $row->imageUrl;
			$titles = $row->title;
			$url_web = $row->url;
			$title_post = $row->blog_title;
			$comments_ago_area2 = '';
			$comments_ago_area = '<div class="row-fluid comentarea">
				<ul class="blog-comment-area'.$msg_id.'" style="list-style: none; margin: 0;">';
			
			$this->db->where('msg_id_fk',$msg_id);
			$this->db->where('type','blog');
			$this->db->order_by('com_id','asc');
			$queryCommArea = $this->db->get('comments');
			
			if($queryCommArea->num_rows() > 0)
			{
				foreach($queryCommArea->result_array() as $rowComments)
				{
					$userdata = $rowComments['uid_fk'];
					$commsg = $rowComments['comment'];
					$com_id = $rowComments['com_id'];
					$msg_id_fk = $rowComments['msg_id_fk'];
					$created223 = $rowComments['created'];
					$usercomname = $this->db->query("SELECT * FROM `users` WHERE `uid`='".$userdata."' ORDER BY `uid` DESC");
					$totalnum = $usercomname->num_rows();
					$theresult = $usercomname->row_array();

					if(isset($theresult['profile_picture'])) {
						$userPhoto = 'uploads/'.$userdata.'/medium/' . str_replace(" ", "_", $theresult['profile_picture']);
					} else {
						$userPhoto = 'http://www.placehold.it/164x164/333333/ffffff&text=no+photo';
					}
					
					if($msg_id_fk == $msg_id)
					{
						$comments_ago_area .= '
						<li style="color: #898989;">
							<img class="pull-left" style="width: 32px; height: 32px; background-image: url('.base_url().$userPhoto.'); background-size: cover;" /><span><h6 style="margin-left: 35px;">'. (isset($theresult['name']) ? $theresult['name'] : '') .' <span class="muted" style="font-weight: normal;font-size: 11px;margin-left: 13px;">'.date('F j, Y g:i:s a', $created223).'</span></h6></span>
							<p style="font-size: 11px;border: 1px solid lightGrey;padding: 6px;margin-top: 18px;color: #525252;">'.$commsg.'</p>
						</li>';
					}
				}
			}
			
			
			$comments_ago_area .= '</ul>';
			if($this->session->userdata('logged_in') == 1) {
				$comments_ago_area .= '<textarea placeholder="Write a comment..." style="resize:none; border-radius: 0;" rows="1" class="span12" onblur="hideBox(this,'.$msg_id.')" onfocus="showUser2h(this,'.$msg_id.')" id="blogcom'.$msg_id.'" alt="'.$msg_id.'"></textarea>';
			}
			$comments_ago_area .= '</div>';
			
			
			
			echo '
			<div class="b-feeds message_box" alt="'.$msg_id.'">
				<div style="padding: 12px;">';
			//catalog
			if($album_id == '-1')
			{
				echo 'catalog';
			}
			//gallery
			if(($album_id != '0') && ($album_id != '-1'))
			{
				$imagesDir = "files/".$album_id.'/';
				$imagesDirMedium = "files/".$album_id.'/medium';
				$images23Medium = glob($imagesDir . '*.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF}', GLOB_BRACE);
				$images23 = glob($imagesDir . '*.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF}', GLOB_BRACE);
				$num_of_ph0tos = count($images23);
				
				if($num_of_ph0tos == 1)
				{
					
					echo '
						<p>Added '.$num_of_ph0tos.' photo(s)</p>
						<div class="g-img1" style="background:url(\''.base_url().$images23[0].'\');background-repeat: no-repeat;background-size: cover;background-position: center center;">
							
						</div>
					';
				}
				
				if($num_of_ph0tos == 2)
				{
					echo '<p>Added '.$num_of_ph0tos.' photo(s)</p>
					<div class="span6 g-img2" style="background:url(\''.base_url().$images23Medium[0].'\');background-repeat: no-repeat;background-size: cover;background-position: center center;">
					</div>
					<div class="span6 g-img2" style="background:url(\''.base_url().$images23Medium[1].'\');background-repeat: no-repeat;background-size: cover;background-position: center center;">
					</div>';
				}
				
				if($num_of_ph0tos >= 3)
				{
					$minusOne = $num_of_ph0tos - 1;
					$albumPics2 = $this->db->query("SELECT * FROM gallery WHERE albums='$album_id' ORDER BY id DESC");
					$ck = 0;
					$active = '';
					echo '<p>Added '.$num_of_ph0tos.' photo(s)</p>
					<div class="span12 g-img21 gimgl0" style="background:url(\''.base_url().$images23Medium[0].'\');background-repeat: no-repeat;background-size: cover;background-position: center center;">
					</div>
					<div class="span6 g-img21 gimgl0" style="background:url(\''.base_url().$images23Medium[1].'\');background-repeat: no-repeat;background-size: cover;background-position: center center;">
					</div>
					<div class="span6 g-img21 gimgl11" style="background:url(\''.base_url().$images23Medium[2].'\');background-repeat: no-repeat;background-size: cover;background-position: center center;">
					</div>';
				}
				echo '<hr style="margin-bottom: 0;"/>
				<p class="muted pull-left" style="font-size: 11px;">Posted '.$this->times_model->makeAgo($created).'</p>
				<a id="'.$msg_id.'" class="btn btn-link pull-right share_post_link" alt="">
					<span><i class="icon-share"></i></span>
				</a>
				';
			
				echo $comments_ago_area;
			}
			//blog
			if($album_id == '0')
			{
				/* get url link */
				$this->db->where('id',$uid_fk);
				$query_website = $this->db->get('websites');
				$row_web = $query_website->row_array();
				
				/* get page name */
				$this->db->where('id',$pid);
				$query_pages = $this->db->get('pages');
				$row_page = $query_pages->row_array();
				
				if($row->message) {
					$message = str_replace("\n",'</p></p>',html_entity_decode($message));
					if($title_post)
					{
						echo '<h4>'.$title_post.'</h4>';
					}
					echo '<p style="white-space: pre-wrap; overflow: hidden; text-overflow: ellipsis;" class="video_url_link" alt="'.$url_web.'" id="'.$msg_id.'">'.$message.'</p>';
				}
				if($image_name)
				{
					$img = str_replace(" ","_",$image_name);
					$imgtag = $img;
					$height = '';
					$width = '';
					$styles = '';
					
					/* detect if image has medium folder */
					$imageMedium = '';
					$imageDetect = 'uploads/medium/'.$imgtag;
					if($this->photo_model->image_exists($imageDetect))
					{
						$imageMedium = $imageDetect;
					}
					else
					{
						if($this->photo_model->image_exists('uploads/'.$imgtag))
						{
							/* create medium folder*/
							$medium = $this->photo_model->make_medium('uploads/'.$imgtag);
							$imageMedium = $medium;
						}
					}
					echo '
						<div class="g-img1" style="margin-bottom:10px;'.$styles.'">
							<img src="'.base_url($imageMedium).'">
						</div>';
				}
				if($image_name == null) 
				{
					if(($url_web == ' ') OR ($url_web == null))
					{
						//echo $url_web;
					}
					else
					{
						$detect = $this->video_model->detect_url($url_web);
						if($detect == 'youtube')
						{
							$yid = $this->video_model->getyoutubeid($url_web);
							$yid = str_replace(' ', '', $yid);
							echo '
							<div class="row-fluid info-youtube" style="background: #F3F3F3;border: 1px solid #D2D2D2;">
								<img class="pull-left" src="'.$imageUrl.'" width="170" style="margin: 15px;" />
								<span class="play_button pull-left" style="margin-left: -125px;margin-top: 51px;background: rgba(255, 255, 255, 0.5);padding: 2px 14px;cursor: pointer;"><i class="icon-play"></i></span>
								<h5 style="color:#187cec;padding: 0 5px;"><a href="'.$url_web.'">'.html_entity_decode($titles).'</a></h5>
								<p style="font-size: 11px;padding: 0 5px;">'.html_entity_decode($description).'</p>
							</div>
							<div class="row-fluid desc'.$msg_id.'" style="background: #F3F3F3;border: 1px solid #D2D2D2;display:none;">
								<h5 style="color:#187cec;margin-left: 15px;">'.html_entity_decode($titles).'</h5>
								<p style="font-size: 11px;margin-left: 15px;">'.html_entity_decode($description).'</p>
							</div>';
						
						}
						elseif($detect == 'dailymotion' || $detect == 'vimeo')
						{
							echo '
							<div class="row-fluid info-youtube" style="background: #F3F3F3;border: 1px solid #D2D2D2;">
								<img class="pull-left" src="'.$imageUrl.'" width="170" style="margin: 15px;" />
								<span class="play_button pull-left" style="margin-left: -125px;margin-top: 51px;background: rgba(255, 255, 255, 0.5);padding: 2px 14px;cursor: pointer;"><i class="icon-play"></i></span>
								<h5 style="color:#187cec;padding: 0 5px;"><a href="'.$url_web.'">'.html_entity_decode($titles).'</a></h5>
								<p style="font-size: 11px;padding: 0 5px;">'.html_entity_decode($description).'</p>
							</div>
							<div class="row-fluid desc'.$msg_id.'" style="background: #F3F3F3;border: 1px solid #D2D2D2;display:none;">
								<h5 style="color:#187cec;margin-left: 15px;">'.html_entity_decode($titles).'</h5>
								<p style="font-size: 11px;margin-left: 15px;">'.html_entity_decode($description).'</p>
							</div>';
						}
						elseif($detect == 'no video')
						{
							echo '
								<div class="row-fluid info-youtube" style="background: #F3F3F3;border: 1px solid #D2D2D2;">
							';
							if($imageUrl)
							{
								echo '
									<img class="pull-left" src="'.$imageUrl.'" style="margin: 15px;max-width: 150px;" />
								';
							}
							echo '
									<h5 style="color:#187cec; padding: 0 5px;"><a href="'.$url_web.'" style="color: #08c">'.html_entity_decode($titles).'</a></h5>
									<p style="font-size: 11px; padding: 0 5px;">'.html_entity_decode($description).'</p>
								</div>
							';	
						}
					}
				}
				echo '<hr style="margin-bottom: 0;"/>
				<p class="muted pull-left" style="font-size: 11px;">Posted '.$this->times_model->makeAgo($created).'</p>
				<a id="'.$msg_id.'" class="btn btn-link pull-right share_post_link" alt="'.base_url($row_web['url'].'/'.url_title($row_page['name'],'-',true).'/'.$msg_id).'">
					<span style="vertical-align: middle;"><i class="icon-share"></i> Share</span>
				</a>
				<div style="clear:both;"></div>
				';
				echo $comments_ago_area;
			}
			
			echo '
				</div>
			</div>
			';
		}
	}
	else
	{
		echo 'lana';
	}
?>