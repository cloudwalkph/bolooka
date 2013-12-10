
				<a class="btn btn-link hidden-desktop" data-toggle="collapse" data-target=".nav-collapse" style="color: inherit;">
					<span>Menu</span>
				</a>
				<div class="nav-collapse collapse">
					<ul class="nav nav-tabs nav-stacked <?php echo $layout == 'layout6' ? 'text-right' : ''; ?>">
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
		$activepage = "";
		$row = $query->result();

		foreach($row as $key)
		{

			$cur_url = current_url();
			$active_style = '';
			$theMenuName = $key->name;
			$textMenu = str_replace(" ","-",$theMenuName);
			if(stripos($cur_url, $textMenu) === false)
			{
				/* DO NOTHING */
				$activepage = '';
			}
			else
			{
				$active_style = 'style="background-color:'.$menu_over.';"';
				$activepage = $theMenuName;
			}
			
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
							<a href="<?php echo base_url(url_title($url,'-',true).'/'.$urlpage); ?>">
								<i class="<?php echo $layout == 'layout5' ? 'icon-chevron-right pull-right' : 'icon-chevron-left pull-left'?>"></i>
								<?php echo $key->name; ?>
							</a>
						</li>
<?php
		}
?>
					</ul>
				</div>