			<div class="container-fluid">
				<a class="btn btn-link hidden-desktop" data-toggle="collapse" data-target=".nav-collapse" style="color: inherit;">
					<span>Menu</span>
				</a>
				 
				<div class="nav-collapse collapse">
					<ul class="nav nav-pills">
<?php 
						$this->db->where('website_id', $wid);
						$status = array(1,'publish');
						$this->db->where_in('status', $status);
						if($this->db->field_exists('page_seq', 'pages')) {
							$this->db->order_by('page_seq');
						} else {
							$this->db->order_by('order');						
						}
						$query = $this->db->get('pages');
						$row = $query->result();

						foreach($row as $key)
						{
							if($key->url == null)
							{
								$urlpage = url_title($key->name,'-',true);
							}
							else
							{
								$urlpage = $key->url;
							}
?>
						<li id="<?php echo $key->id;?>" class="<?php echo $activepid == $key->id ? 'active' : '' ; ?>">
							<a class="text-center" href="<?php echo base_url(url_title($url,'-',true).'/'.$urlpage); ?>"><?php echo $key->name; ?></a>
						</li>
<?php
						}
?>
					</ul>
				</div>
			</div>

