<?php
	echo $holder;
?>
<div class="container logo_design">
	<div class="container-fluid comp_logo">
		<a class="brand logo-style" href="<?php echo base_url().url_title($url); ?>">
			<h1>
<?php
			$maxheight = '100px';
			if($logo->logosize == 1){
				$maxheight = '120px';
			}elseif($logo->logosize == 2){
				$maxheight = '140px';
			}
			if($logo->nologo == '1')
			{
				if($site_name) {
					echo '<span>'.$site_name.'</span>';
				} else {
					echo '<span>'.url_title($url).'</span>';
				}
			}
			else
			{
				if($logo->image != null) {
					echo '<img src="'. base_url().'uploads/'.str_replace('uploads/', '', $logo->image) .'" style="max-height: '.$maxheight.';" alt="'. $site_name .'">';
				} else {
					echo '<span>'.$site_name.'</span>';
				}
			}
?>
			</h1>
		</a>
	</div>
</div>
<div class="">
	<div class="row-fluid">
		<div class="nav_design">
			<div class="container" style="margin: auto; max-width: 1170px; font-family: <?php echo $bg->menu_style;?>;">

<?php
		echo isset($menu) ? $menu : '';
?>
			</div>
		</div>
		
		<div class="container">
			<div class="container-fluid">
				<div class="<?php echo ($page_type == 'catalogue') || ($page_type == 'photo') ? 'span12': 'span9 pull-right content_style'; ?>">
					<div <?php echo ($page_type == 'article') ? 'class="article container-fluid" style="padding: 10px;"': ''; ?>>
						<div class="row-fluid">
<?php
						echo $content;
?>
						</div>
<?php

		if($pages['social'] == 'on' && $page_type != 'catalogue') {
?>
						<div class="row-fluid" style="margin-top: 10px;">
							<ul class="inline">
<?php
							$this->load->view('templates/addthis');
?>
							</ul>
						</div>
<?php
		}
?>
					</div>
				</div>

<?php
		if($page_type == 'catalogue') {
			if($product || $this->uri->segment(1) == 'cart') {
				$footer_class = 'span12';
			} else {
				$footer_class = 'span9';
			}
		} elseif ($page_type == 'photo') {
			$footer_class = 'span12';
		} else {
			$footer_class = 'span9 pull-right';
		}
?>

<?php
	if($footer->noads == 0) {
?>
				<div class="row-fluid">
					<div class="footer_style <?php echo isset($footer_class) ? $footer_class: ''; ?>">
						<div><?php echo $footer->label; ?></div>
					</div>
				</div>
<?php
	}
?>
			</div>
		</div>
	</div>
</div>