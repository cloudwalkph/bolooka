					
						<?php

							$this->db->where('website_id', $site_id);
						// add mo ito mic
							$this->db->order_by('sequence asc');
						//
							$query = $this->db->get('banner');
							$result = $query->result();
							
							if($query->num_rows() > 0){
								foreach($query->result() as $rowBan)
								{
									$noBanner = $rowBan->disable;
								}
								if($noBanner == 'no')
								{
									if(!isset($galleryPage))
									{
									
						?>
						
						<div id="banner" style="background-color: <?php echo $bg->boxcolor; ?>;">
							<div id="slider">
								<div id="mask-gallery" style="border-radius: 2px;">
									<ul id="gallery">
									<?php foreach($query->result() as $row) { ?>
										<li><img src="<?php echo base_url().'uploads/'.$row->images; ?>" width="300" height="200" alt=""/></li>
									<?php } ?>	
									</ul>
								</div>
								
							</div>
									
						</div>
						<?php 
									}
								} 
							}
						?>