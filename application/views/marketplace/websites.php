<?php

		foreach($websites->result_array() as $resultSites)
		{
			$websitelogo = 'http://www.placehold.it/192x164/333333/ffffff&text=no+logo';

			$querylogo = $this->marketplace_model->getWebsiteLogo($resultSites['id']);
			$resultlogo = $querylogo->row_array();
			$imglogo = str_replace('uploads/', '', $resultlogo['image']);
			
			if($resultlogo['image'] != null) {
				$img = 'uploads/'.$resultSites['user_id'].'/s240/'.$imglogo;
				if($this->photo_model->image_exists($img)) {
					$websitelogo = base_url().$img;
				} else {
					$img = 'uploads/'.$resultSites['user_id'].'/'.$imglogo;
					if($this->photo_model->image_exists($img)) {
						$img = $this->photo_model->custom_thumbnail($img, 240);
						$websitelogo = base_url($img);
					} else {
						$img = 'uploads/s240'.$imglogo;
						if($this->photo_model->image_exists($img)) {
							$websitelogo = base_url($img);
						} else {
							$img = 'uploads/'.$imglogo;
							if($this->photo_model->image_exists($img)) {
								$img = $this->photo_model->custom_thumbnail($img, 240);
								$websitelogo = base_url($img);
							} else {
								$imgsrc = 'http://www.placehold.it/240x240/333333/ffffff&text=no+logo';
							}
						}
					}
				}
			}

			echo '
				<li class="item w1" id = "'.$resultSites['id'].'">
					<div class="box">
						<div style="text-align: center;">
							<a class = "direct-gallery'.$resultSites['id'].'" target = "_blank" href = "'.base_url().url_title($resultSites['url'], '-', true).'">
								<img src="'.$websitelogo.'" style="max-width: 192px; max-height: 164px;" />
							</a>
						</div>
						<div class="g-description-shop"><a href="'.url_title($resultSites['url'], '-', true).'">'.$resultSites['site_name'].'</a></div>
						<div class="p-category">'.$resultSites['category'].'</div>
					</div>
				</li>
			';
		}
?>