<?php
	if($products->num_rows() > 0):
?>	

<?php
	foreach($products->result_array() as $resultShop)
	{

		// if($resultShop['marketplace'] == 1) {
			$price_tag = ''; $imgsrc = '';
			$qweb = $this->marketplace_model->getWebsite($resultShop['website_id']);
			$rweb = $qweb->row_array();
			
			if($this->db->field_exists('product_cover', 'products')) {
				$cover = $resultShop['product_cover'];
			} else {
				$cover = $resultShop['primary'];
			}

			if(isset($cover)) {
				$imgsrc = 'http://www.placehold.it/240x240/333333/ffffff&text=image+missing';
				$img = 'uploads/'.$rweb['user_id'].'/'.$rweb['id'].'/'.$resultShop['page_id'].'/'.$resultShop['id'].'/s240/'.$cover;
				if($this->photo_model->image_exists($img)) {
					$imgsrc = base_url($img);
				} else {
					// $img = 'uploads/'.$rweb['user_id'].'/'.$rweb['id'].'/'.$resultShop['page_id'].'/'.$resultShop['id'].'/s240x240/'.$cover;
					// if($this->photo_model->image_exists($img)) {
						// $imgsrc = base_url($img);
					// } else {
						$img = 'uploads/'.$rweb['user_id'].'/'.$rweb['id'].'/'.$resultShop['page_id'].'/'.$resultShop['id'].'/'.$cover;
						if($this->photo_model->image_exists($img)) {
							$img = $this->photo_model->custom_thumbnail($img, 240);
							$imgsrc = base_url($img);
						}
					// }
				}
			} else {
				$imgsrc = 'http://www.placehold.it/240x240/333333/ffffff&text=no+image';
			}


			if(isset($rweb['url']) || isset($rweb['name'])) // temporary code if website is missing in web_marketgroup
			{
				$qpage = $this->marketplace_model->getPage($resultShop['page_id']);
				$rpage = $qpage->row_array();

				if(!isset($resultShop['disabled']) || $resultShop['disabled'] != 1)
				{
					if($resultShop['price'] > 0){
						$price_tag = '&#8369; '.number_format($resultShop['price'], 2);
					}
					echo '
						<div class="item w1" id = "'.$resultShop['id'].'">
							<div class="box">
								<div class="text-center img_cont">
									<a class = "direct-gallery'.$resultShop['id'].'" target = "_blank" href = "'.strtolower(prep_url(base_url($rweb['url'].'/'.url_title($rpage['name'],'-',true).'/'.url_title($resultShop['name'],'-',true).'/'.$resultShop['id']))).'">
										<img class="zoomhover" src="'. $imgsrc .'" alt="'.$resultShop['name'].'" />
									</a>
								</div>
								<div class="g-description-shop">'.$resultShop['name'].'</div>
								<div style="position: relative; text-align: left;">
									<span class="p-category" style="font-size: 9px; font-family: Segoe UI; color: rgb(129, 128, 128);">' . ($resultShop['category'] ? ucfirst($resultShop['category']) : '<span style="font-style: italic;">no category</span>') . ' </span><span style="font-size: 10px; font-family: Segoe UI; color: rgb(53, 144, 234); right: 0px; position: absolute;">'.$price_tag.'</span>
								</div>
								<div style="font-size: 9px; font-family: Segoe UI; color: rgb(129, 128, 128); text-align: left;"><a target="_BLANK" href="'.strtolower(prep_url(base_url(url_title($rweb['url'], '-', true)))).'">'.$rweb['site_name'].'</a></div>
							</div>
						</div>
					';
				}
			}
		// }

	}
?>

<?php
	endif;
?>