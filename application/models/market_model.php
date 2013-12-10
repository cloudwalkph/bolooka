<?php
	class Market_Model extends CI_Model
	{
		function __construct()
		{
			$this->load->model('marketplace_model');
		}
		
		function getProductList($marketgroup_id = 0) {
			echo '
				<ul id="prod_list" class="thumbnails">
			';

			$queryGetProd = $this->marketplace_model->getMarketProducts($marketgroup_id);

			if($queryGetProd->num_rows() > 0)
			{
				foreach($queryGetProd->result_array() as $wbgrprow) {

					$this->db->where('id', $row['website_id']);
					$this->db->where('deleted', 0);
					$queryWebsite = $this->db->get('websites');
					$row1 = $queryWebsite->row_array();
					
					/**** check if product is disabled ****/
					$this->db->where('product_id', $row['id']);
					$queryProdMod = $this->db->get('product_moderation');
					$resultProdMod = $queryProdMod->row_array();
					/**** end ****/
					
						/**** image uploaded script error catcher -- Noel ****/
							/* check image in uploads folder */
							if($this->db->field_exists('product_cover', 'products')) {
								$img = 'uploads/'.$wbgrprow['user_id'].'/'.$wbgrprow['website_id'].'/'.$wbgrprow['page_id'].'/'.$wbgrprow['id'].'/'.$wbgrprow['product_cover'];
							} else {
								$img = 'uploads/'.$wbgrprow['user_id'].'/'.$wbgrprow['website_id'].'/'.$wbgrprow['page_id'].'/'.$wbgrprow['id'].'/'.$wbgrprow['primary'];
							}
							if($this->photo_model->image_exists($img)) {
								$imgsrc = base_url($img);
							} else {
								$imgsrc = 'http://www.placehold.it/160x160/333333/ffffff&text=image+not+found';
							}
						/**** ****/
					
						if($wbgrprow['disabled'] == 0 || $wbgrprow['disabled'] == null)
						{
							$prod = 0;
						}
						else
						{
							$prod = 1;
						}

					echo '
						<li class="span3 '.($prod == 0 ? 'prod' : '').'"  id="'.$wbgrprow['id'].'" style="position:relative;">
							<div class="thumbnail prod_info">
								<img src="'.$imgsrc.'" style="height: 200px;">
								<h4 class="trim">'.$wbgrprow['name'].'</h4>
								<p>'.$wbgrprow['category'].'</p>
								<p class="trim"><a href="'.base_url().$wbgrprow['url'].'" title="'.$wbgrprow['site_name'].'"> '.$wbgrprow['site_name'].' </a></p>
								<p>PhP '.number_format($wbgrprow['price'],2).'</p>
							</div>
							<div class="offprod" style="position: absolute; text-align: center; font-size: 29px; height: 100%; width: 100%; font-weight: bold; color: rgb(255, 255, 255); background-color: rgba(0, 0, 0, 0.5); margin: auto; top: 0px; line-height: 270px; '.($prod == 0 ? 'display: none; ' : 'display: block; ').'">Disabled</div>
						</li>
					';

				}
			}
			echo '
				</ul>
			';
		}
	}
?>