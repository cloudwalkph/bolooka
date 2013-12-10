				<a class="btn btn-link first_menu">
					<span>Menu</span>
				</a>
				 
				<div class="menu_list">
					<ul class="nav">
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
							if(stripos($cur_url, $textMenu) ===false)
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
							
							$cur_url = current_url();
							$class_active = '';
							if(strpos($cur_url, $urlpage)!==false)
							{
								$class_active = 'active';
							}
?>
						<li id="<?php echo $key->id;?>" class="<?php echo $class_active; ?>">
							<a href="<?php echo base_url(url_title($url,'-',true).'/'.$urlpage); ?>">
								<?php echo $key->name; ?>
							</a>
						</li>
<?php
						}
?>
					</ul>
				</div>

<script>
	$('.first_menu').on('click',function(e) {
		$(this).hide();
		$('.menu_list').show();
		// $('.row-fluid').children('.span9').css('margin','0');
		e.stopPropagation();
	});
	$(document).on('click',function(e){
		if($('.menu_list').is(':visible'))
		{
			$('.first_menu').show();
			$('.menu_list').hide();
		}
		e.stopPropagation();
	});
</script>