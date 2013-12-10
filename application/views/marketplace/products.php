<?php
	if($products->num_rows() > 0):

		foreach($products->result_array() as $resultShop)
		{
			$qweb = $this->marketplace_model->getWebsite($resultShop['website_id']);
			$rweb = $qweb->row_array();
			
			if(isset($rweb['url']) || isset($rweb['name'])) // temporary code if website is missing in web_marketgroup
			{
				$qpage = $this->marketplace_model->getPage($resultShop['page_id']);
				$rpage = $qpage->row_array();
				
					if($this->db->field_exists('product_cover', 'products')) {
						$img = 'uploads/'.$resultShop['user_id'].'/'.$resultShop['website_id'].'/'.$resultShop['product_cover'];
					} else {
						$img = 'uploads/'.$resultShop['user_id'].'/'.$resultShop['website_id'].'/'.$resultShop['primary'];
					}
					$imgsrc = base_url($img);

				if(isset($resultShop['disabled']))
				{
					if($resultShop['disabled'] != 1)
					{
						echo '
							<div class="item w1" style = "list-style: none" id = "'.$resultShop['id'].'">
								<div class="box">
									<div class="img_cont">
										<a class = "text-center direct-gallery'.$resultShop['id'].'" target = "_blank" href = "'.strtolower(prep_url(base_url($rweb['url'].'/'.url_title($rpage['name'],'-',true).'/'.url_title($resultShop['name'],'-',true).'/'.$resultShop['id']))).'">
											<img class="product" src="'.$imgsrc.'"/>
										</a>
									</div>
									<div class="g-description-shop">'.$resultShop['name'].'</div>
									<div class="p-category">'.$resultShop['category'].'</div><span>'.$resultShop['price'].'</span>
									<div class="g-url-shop"><a href="'.strtolower(prep_url(base_url($rweb['url']))).'">http://www.bolooka.com/'.strtolower($rweb['url']).'</a></div>
								</div>
							</div>
						';
					}
				} else {
					echo '
						<div class="item w1" style = "list-style: none" id = "'.$resultShop['id'].'">
							<div class="box">
								<div style="text-align: center;">
									<a class = "direct-gallery'.$resultShop['id'].'" target = "_blank" href = "'.strtolower(prep_url(base_url($rweb['url'].'/'.url_title($rpage['name'],'-',true).'/'.url_title($resultShop['name'],'-',true).'/'.$resultShop['id']))).'">
										<img src="'.$imgsrc.'"/>
									</a>
								</div>
								<div class="g-description-shop">'.$resultShop['name'].'</div>
								<div style="position: relative;">
									<span class="p-category" style="font-size: 9px; font-family: Segoe UI; color: rgb(129, 128, 128);">'.($resultShop['category'] ? $resultShop['category'] : '<span style="font-style: italic;">category</span>').'&nbsp;</span><span style="font-size: 10px; font-family: Segoe UI; color: rgb(53, 144, 234); right: 0px; position: absolute;">&#8369; '.number_format($resultShop['price'],2).'</span>
								</div>
							</div>
						</div>
					';
				}
			}
		}

	endif;
?>
