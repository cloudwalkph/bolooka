<?php
		$wala = Array();
		if($wallUid)
		{
			
			$the_user = $wallUid;
			if ($query->num_rows() > 0)
			{
				foreach($query->result_array() as $row)
				{
					$headpart = ''; $postpart = ''; $thecommentpart = '';
					extract($row);
					//echo makeAgo($created)."<br />";
					
					/* number of comments */
					$this->db->where('msg_id_fk', $msg_id);
					$comments_query = $this->db->get('comments');
					
					$this->db->where('id', $uid_fk);
					$this->db->where('deleted', 0);
					$queryUser_prod = $this->db->get('websites');

					if($queryUser_prod->num_rows() > 0)
					{
						$userRowProd = $queryUser_prod->row_array();
						$site_name = $userRowProd['site_name'];
						$site_url = $userRowProd['url'];
						
						/* get image logo */

						$queryImage = $this->db->query("SELECT * FROM `logo` WHERE `website_id` = '$uid_fk'");
						
						$rowImage = $queryImage->row_array();
						
						if($rowImage['image']) {
							$img = 'uploads/thumbnail/'.str_replace('uploads/', '', $rowImage['image']);
							if($this->photo_model->image_exists($img)){
								$imageSrc = base_url().$img;
							} else {
								$img = 'uploads/'.str_replace('uploads/', '', $rowImage['image']);
								if($this->photo_model->image_exists($img)){
									$imageSrc = base_url().$img;
								} else {
									$imageSrc = 'http://www.placehold.it/80x80/333333/ffffff&text=logo+missing';
								}
							}
						} else {
							$imageSrc = 'http://www.placehold.it/80x80/333333/ffffff&text=no+logo';
						}
						
						/* post from products */
						if($album_id == '-1')
						{
							$this->db->where('msg_id_fk', $message);
							$comments_query = $this->db->get('comments');
							
							
							$query_product_image = $this->db->query("SELECT * FROM products_images WHERE product_id='$message' ORDER BY id");
							$query_product = $this->db->query("SELECT * FROM products WHERE id='$message' ORDER BY id LIMIT 1");
							$prod_details = $query_product->row_array();
							
							$query_pages = $this->db->query("SELECT * FROM pages WHERE id='".$prod_details['page_id']."'");
							$row_pages = $query_pages->row_array();
							if($query_product->num_rows() > 0)
							{
								$products = '';
								if($prod_details['price'] > 0){
									$products = 'Price: &#8369; '.number_format($prod_details['price'], 2);
								}
								$headpart = '<span style="font-family: Segoe UI;"><span class="muted"> - posted a new product "'.$prod_details['name'].'"</span><span class="pull-right">'.$products.'</span></span>';
								
								if($this->db->field_exists('product_desc', 'products')) {
									$postpart = '<p>'.html_entity_decode($prod_details['product_desc']).'</p>';
								} else {
									$postpart = '<p>'.html_entity_decode($prod_details['desc']).'</p>';
								}
								
								if($query_product_image->num_rows() == 1)
								{
									$row4 = $query_product_image->row_array(0);
									$postpart .= '
											<div class="row-fluid">
												<div class="span6">
													<a target="_BLANK" href="'.base_url($userRowProd['url'].'/'.url_title($row_pages['name'],'-',true).'/'.str_replace(' ', '-',$prod_details['name']).'/'.$prod_details['id']).'">
														<img class="img-rounded thumbnail" src="'.base_url().'uploads/'.$userRowProd['user_id'].'/'.$prod_details['website_id'].'/'.$prod_details['page_id'].'/'.$prod_details['id'].'/'.$row4['images'].'" />
													</a>
												</div>
											</div>
									';
								}
								if($query_product_image->num_rows() == 2)
								{
									$row4 = $query_product_image->row_array(0);
									$row5 = $query_product_image->row_array(1);
									$row4img = base_url().'uploads/'.$userRowProd['user_id'].'/'.$uid_fk.'/'.$prod_details['page_id'].'/'.$prod_details['id'].'/'.$row4['images'];
									$row5img = base_url().'uploads/'.$userRowProd['user_id'].'/'.$uid_fk.'/'.$prod_details['page_id'].'/'.$prod_details['id'].'/'.$row5['images'];
									
									$postpart .= '
											<ul class="thumbnails">
												<li class="span5">
													<a target="_BLANK" href="'.base_url($userRowProd['url'].'/'.url_title($row_pages['name'],'-',true).'/'.str_replace(' ', '-',$prod_details['name']).'/'.$prod_details['id']).'">
														<img class="thumbnail" src="'.$row4img.'" />
													</a>
												</li>
												<li class="span5">
													<a target="_BLANK" href="'.base_url($userRowProd['url'].'/'.url_title($row_pages['name'],'-',true).'/'.str_replace(' ', '-',$prod_details['name']).'/'.$prod_details['id']).'">
														<img class="thumbnail" src="'.$row5img.'" />
													</a>
												</li>
											</ul>
									';
								}
								
								if($query_product_image->num_rows() >= 3)
								{
									$this->db->where('id',$uid_fk);
									$this->db->where('deleted', 0);
									$queryUser_prod = $this->db->get('websites');
									$userRowProd = $queryUser_prod->row_array();
									/* this is for carousel */
								
									$postpart .= '
										<div class="flexslider" style="margin-bottom: 0;">
											<ul class="slides">
									';
									foreach($query_product_image->result_array() as $rowRow)
									{
										$img = base_url().'uploads/'.$userRowProd['user_id'].'/'.$uid_fk.'/'.$prod_details['page_id'].'/'.$prod_details['id'].'/'.$rowRow['images'];
										$postpart .= '
												<li data-thumb="'.$img.'">
													<a target="_BLANK" href="'.base_url($userRowProd['url'].'/'.url_title($row_pages['name'],'-',true).'/'.str_replace(' ', '-',$prod_details['name']).'/'.$prod_details['id']).'">
										';	
										// $postpart .= '<img src="'.$img.'" />';
										$postpart .= '<div class="img-rounded" style="background:url('.$img.'); border: 4px solid #ddd; background-repeat: no-repeat; background-size: 100%; background-position: center; height:360px;"></div>';
										$postpart .= '
													</a>
												</li>
										';
									}
									$postpart .= '
											</ul>
										</div>
									';
								}
							}
						}
						
						// Post of gallery photos
						if(($album_id != '0') && ($album_id != '-1'))
						{
							$this->db->where('id', $album_id);
							$getAlbum = $this->db->get('albums');
							$album = $getAlbum->row_array();
							
							if($getAlbum->num_rows() > 0) {

								/* get page name */
								$getpageType = $this->db->query("SELECT * FROM `pages` WHERE `id`='".$album['page_id']."'");
								if($getpageType->num_rows() > 0)
								{
									foreach($getpageType->result_array() as $pageType)
									{
										$typeName = $pageType['type'];
										
										$thepageName = url_title($pageType['name'],'-',true);
										
									}
								}
								else
								{
									$thepageName = '';
								}
								
								//$query5 = $this->db->query("SELECT * FROM upload_counter WHERE albumid='$album_id' AND addeds='$msg_id' ORDER BY id DESC");
								$this->db->where('albums', $album_id);
								$this->db->order_by('id', 'desc');
								$albumPic = $this->db->get('gallery');
								
								$imagesDir = "files/".$album_id.'/';
								$imagesDirMedium = "files/".$album_id.'/medium';
								$images23Medium = glob($imagesDir . '*.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF}', GLOB_BRACE);
								$images23 = glob($imagesDir . '*.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF}', GLOB_BRACE);
								$num_of_ph0tos = count($images23);
								
								if($num_of_ph0tos > 0) {
									$array_extension = array(
										'.jpg',
										'.jpeg',
										'.png',
										'.gif',
										' (1)'
									);
									$array_replace = array(
										'',
										'',
										'',
										''
									);
								
									$headpart = '<span class="muted" style="font-family: Segoe UI;"> -- added '.$num_of_ph0tos.' photos to the <a style="font-weight:normal;font-family: Segoe UI;" target="_blank" href="'.base_url().$site_url.'/'.$thepageName.'">'.$album['album_name'].'</a> album on '.date('F Y', $album['created']).'</span>';
									
									
									if($num_of_ph0tos == 1)
									{
										// echo 'one photos';
										$postpart .= '
											<div class="row-fluid">
												<div class="span6">
													<a target="_blank" href="'.base_url().$site_url.'/'.$thepageName.'">
														<img class="img-rounded thumbnail" style="border: 4px solid #ddd;max-height: 350px;" src="'.base_url().$images23[0].'" />
													</a>
												</div>
											</div>
										';
									}
									
									if($num_of_ph0tos == 2)
									{
										$gal_id = str_replace($array_extension,$array_replace,$images23Medium[0]);
										$gal_id = str_replace($array_extension,$array_replace,$images23Medium[1]);
										$gal_id = str_replace($imagesDir,'',$gal_id);
										$postpart .= '
											<div class="row-fluid">
												<div class="span6 thumbnails">
													<a target="_blank" href="'.base_url().$site_url.'/'.$thepageName.'?img_id='.$gal_id.'">
														<div class="thumbnail img-rounded" style="border: 4px solid #ddd;background:url(\''.base_url().$images23Medium[0].'\');background-repeat: no-repeat;background-size: 98%; background-position: center center; height:360px;" ></div>														
													</a>
												</div>
												<div class="span6 thumbnails">
													<a target="_blank" href="'.base_url().$site_url.'/'.$thepageName.'?img_id='.$gal_id.'">														
														<div class="thumbnail img-rounded" style="border: 4px solid #ddd;background:url(\''.base_url().$images23Medium[1].'\');background-repeat: no-repeat;background-size: 98%; background-position: center center; height:360px;" ></div>
													</a>
												</div>
											</div>
										';
									}
									
									if($num_of_ph0tos >= 3)
									{
										$minusOne = $num_of_ph0tos - 1;
										$this->db
											->select('*')
											->from('gallery')
											->where('albums', $album_id)
											->order_by('id desc');
										$albumPics2 = $this->db->get();
										$ck = 0;
										$active = '';
										
										$postpart .= '
											<div class="photoslider flexslider">
												<ul class="slides">										
										';
										
										for($x = 0; $x <= $minusOne; $x++)
										{
											/* detect if file is duplicate show only original file */
											$mystring = $images23Medium[$x];
											$findme   = '(1)';
											$pos = strpos($mystring, $findme);
											if ($pos === false) {
											
												$gal_id = str_replace($array_extension,$array_replace,$images23Medium[$x]);
												$gal_id = str_replace($imagesDir,'',$gal_id);
												$postpart .= '
														<li>
															<div class="thumbnail">
																<a target="_blank" href="'.base_url().$site_url.'/'.$thepageName.'?img_id='.$gal_id.'">
																	<img src="'.base_url().$images23Medium[$x].'" >
																<!-- div class="img-rounded" style="background:url(\''.base_url().$images23Medium[$x].'\'); background-repeat: no-repeat; background-size: 98%; background-position: center center; height:360px;" -->
																</a>
															</div>
														</li>
												';
											
											}
										}

										$postpart .= '
												</ul>
											</div>
										';
									}
								}
							}
						}

						/* post from blog */
						if($album_id == '0')
						{
							$message = str_replace("\n",'</p></p>',html_entity_decode($message));
							$postpart = '';
							if($image_name == null) 
							{
								$varimage = html_entity_decode($image, ENT_QUOTES);
								if(strripos($varimage, 'undefined') === false)
								{
									//echo 'varimage>>'.$varimage.'';
									if($varimage != null)
									{
										/* echo '<div class="row-fluid">
												<img class="span12" src="'.$imageUrl.'" />
											</div>
											'; */
									}
								}
								else
								{

								}
								
								if(($url == ' ') OR ($url == null))
								{
									$postpart .= '<div class="row-fluid desc">'.$message.'</div>';
								}
								else
								{
									$detect = $this->video_model->detect_url($url);
									
									echo '
										<div class="row-fluid">
											<h4>'.$blog_title.'</h4>
											<p>'.$message.'</p>
											<div class="v-holder" style="margin-left: 0;margin-left: 0;border: 1px solid #ddd;padding: 0 2px;">
									';
									
									if($detect == 'youtube')
									{
										$yid = $this->video_model->getyoutubeid($url);
										$yid = str_replace(' ','',$yid);
										$postpart .= '
											
												<h5 class="v-title" style="margin:0;"><a href="'.$url.'">'.html_entity_decode($title).'</a></h5>
												<p class="v-desc muted">'.html_entity_decode($description).'</p>
												<iframe class="row-fluid" src="http://www.youtube.com/embed/'.$yid.'?rel=0&wmode=opaque" frameborder="0" allowfullscreen style="height: 400px;"></iframe>
										';
									}
									elseif($detect == 'vimeo')
									{
										$postpart .= '												
													<h5 class="v-title" style="margin:0;"><a href="'.$url.'">'.html_entity_decode($title).'</a></h5>
													<p class="v-desc muted">'.html_entity_decode($description).'</p>
													<iframe class="row-fluid" src="'.str_replace('vimeo.com','player.vimeo.com/video',$url).'?rel=0&wmode=opaque" frameborder="0" allowfullscreen style="height: 400px;"></iframe>
										';
									}
									elseif($detect == 'dailymotion')
									{
										$postpart .= '
													<h5 class="v-title" style="margin:0;"><a href="'.$url.'">'.html_entity_decode($title).'</a></h5>
													<p class="v-desc muted">'.html_entity_decode($description).'</p>
													<iframe class="row-fluid" src="'.str_replace('dailymotion.com/video','dailymotion.com/embed/video/',$url).'?rel=0&wmode=opaque" frameborder="0" allowfullscreen style="height: 400px;"></iframe>
										';
									}
									elseif($detect == 'no video')
									{
										$images = strip_tags(html_entity_decode($image, ENT_QUOTES), '<img>');
										if($images)
										{
											$postpart .= '
														<div class="pull-left" style="margin: 5px 10px 5px 5px;">
														'.$images.'
														</div>
														<div>
															<h5 class="v-title" style="margin:0;"><a href="'.$url.'">'.html_entity_decode($title).'</a></h5>
															<p class="v-desc muted">'.html_entity_decode($description).'</p>
														</div>
														<div style="clear:both;"></div>
											';
										}
										else
										{
											$postpart .= '
														<div>
															<h5 class="v-title" style="margin:0;"><a href="'.$url.'">'.html_entity_decode($title).'</a></h5>
															<p class="v-desc muted">'.html_entity_decode($description).'</p>
														</div>
														<div style="clear:both;"></div>
											';
										}
									}
									echo '
											</div>
										</div>
									';
								}
							}
							else
							{
								$textStr = $image_name;
								$textStr = str_replace(" ","_",$textStr);
								$textStr = 'uploads/'.$textStr;
								if($this->photo_model->image_exists($textStr)) {
									$imgtextStr = base_url().$textStr;
								} else {
									$imgtextStr = 'http://www.placehold.it/200x120/333333/ffffff&text=image+missing';
								}
								$postpart .= '
									<h4>'.$blog_title.'</h4>
									<p>'.$message.'</p>
									<div class="span6 thumbnails">
										<img class="img-rounded thumbnail" src="'.$imgtextStr.'" />
									</div>
								';	
							}
						}
						
						/* comment area */
							$thecommentpart = '
								<p class="" style="font-size: 10px; text-align: right; color: rgb(159, 159, 159); margin-top: 10px;">
									<a href="#myModalDashboard" class="comment_show" id="'.$msg_id.'" data-toggle="collapse" data-target="#demo'.$msg_id.'">'. ($comments_query->num_rows() > 0 ? $comments_query->num_rows() : 'No ').' Comment(s)</a>
									| '.$this->times_model->makeAgo($created).'
								</p>

									<div id="demo'.$msg_id.'" class="collapse" style="background-color: #f6f5f0;">
							';
							if($comments_query->num_rows() > 0)
							{
								foreach($comments_query->result_array() as $rowComments)
								{
									$com_id_c = $rowComments['com_id'];
									$comment_c = $rowComments['comment'];
									$msg_id_fk_c = $rowComments['msg_id_fk'];
									$uid_fk_c = $rowComments['uid_fk'];
									$created_c = $rowComments['created'];
									
									$this->db->where('uid', $uid_fk_c);
									$getUser = $this->db->get('users');
									$user = $getUser->row_array();
									
									if(isset($user['profile_picture'])) {
										$userPhoto = 'uploads/' . $user['uid'] .'/'. str_replace(" ", "_", $user['profile_picture']);
									} else {
										$userPhoto = 'img/no-photo.jpg';
									}
									
									$thecommentpart .= '
											<div class="media" style="padding: 3px; margin: 5px;border: 1px solid #ddd;">
												<a class="pull-left" href="#">
													<img class="media-object" src="'.base_url($userPhoto).'" style="width: 32px; height: 32px;">
												</a>
												<div class="media-body">
													<div style="font-size: 12px; font-family: Segoe UI Bold; color: rgb(53, 144, 234);">'.(isset($user['name']) ? $user['name'] : '').'</div>
													<div style="font-size: 12px; font-family: Segoe UI;">'.$comment_c.'</div>
												</div>
												<div style="text-align: right; font-size: 10px; color: rgb(159, 159, 159);">'.$this->times_model->makeAgo($created_c).'</div>
											</div>
									';
								}
							}else
							{
									$thecommentpart .= '<div style="font-size: 12px; font-family: Segoe UI;">No comment...</div>';
							}
							$thecommentpart .= '
									</div>
							';
						/* comment area */
?>

						<div class="media post_item" alt="<?php echo $msg_id;?>" style="border-bottom: 1px dotted rgb(207, 207, 207);">
							<a class="thumbnail pull-left" target="_BLANK" href="<?php echo base_url().url_title($site_url, '-', true); ?>" style="width: 80px;">
							<?php /*	<img class="media-object w-logo" style="background-image: url(<?php echo $imageSrc; ?>); width: 100%; height: 100%; background-size: 90% auto; background-repeat: no-repeat; background-position: center center;"> */ ?>
								<img class="media-object w-logo" src="<?php echo $imageSrc; ?>">
							</a>
							<div class="media-body">
								<h5 class="media-heading f-head"> <a target="_BLANK" href="<?php echo base_url().$site_url; ?>"><?php echo $site_name; ?></a> <?php echo isset($headpart) ? $headpart : ''; ?> </h5>
								
								<div class="row-fluid desc"><?php echo isset($postpart) ? $postpart : ''; ?></div>
								<div class="row-fluid comment"><?php echo isset($thecommentpart) ? $thecommentpart : '';?></div>

							</div>
						</div>
					
<?php						
						$wala[] = 'meron';
					}
					else
					{
						$wala[] = 'wala';
					}
				}
				
				if(in_array('meron', $wala)) {
					unset($wala);
				} else {
					echo $noresult;
				}
			}
			else
			{
				echo $noresult;
			}
		}
		else
		{
			echo "<div style='font-size: 12px; font-family: Century Gothic; font-style: italic;'>No More Posts</div>";
		}
		
		
?>