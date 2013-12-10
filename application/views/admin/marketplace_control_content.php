<?php
	$resultProducts = $queryMarketProducts->result_array();
	foreach($resultProducts as $products) {
?>
		<tr>
			<td><?php echo $products['id']; ?></td>
			<td>
<?php
			/**** image in uploads folder ****/

			// $img = 'uploads/'.$products['primary'];
			if($this->db->field_exists('product_cover', 'products')) {
				$cover = $products['product_cover'];
			} else {
				$cover = $products['primary'];
			}
			$img = 'uploads/'.$products['user_id'].'/'.$products['website_id'].'/'.$products['page_id'].'/'.$products['id'].'/thumbnail/'.$cover;
			if($this->photo_model->image_exists($img)) {
				$imgsrc = base_url().$img;
			} else {
				$img = 'uploads/'.$products['user_id'].'/'.$products['website_id'].'/'.$products['page_id'].'/'.$products['id'].'/'.$cover;
				if($this->photo_model->image_exists($img)) {
					$this->photo_model->make_thumbnail($img);
					$imgsrc = base_url().$img;
				} else {
					$imgsrc = 'http://www.placehold.it/80x80/333333/ffffff';
				}
			}

			echo '<div style="height: 80px;"><img src="'.$imgsrc.'" style="max-height: 80px;" /></div>';
?>
			</td>
			<td><?php echo $products['name']; ?></td>
			<td><?php echo $products['site_name']; ?></td>
			<td><?php echo $products['category']; ?></td>
			<td> <span class="pull-left">&#8369;</span> <span class="pull-right"><?php echo number_format($products['price'], 2); ?></span></td>
			<td>
<?php 
			if($products['marketplace'] == 1) {
				echo '<button type="button" class="btn btn-success" name="mod" value="0">Approved</button>';
			} else {
				echo '<button type="button" class="btn btn-danger" name="mod" value="1">Disapproved</button>';
			}
?>
			</td>
			<td>
<?php
			/* section */
			$section = $products['section'];
			echo ucwords(str_replace('"', '', $section));
?>
<?php /*
			<select class="prod_section" name="prod_section<?php echo $products['id']; ?>">
				<option value="0">Select section...</option>
				<option value="crafts" <?php echo strpos ($section, 'crafts') !== false ? 'selected' : '';?>> Crafts </option>
				<option value="furnitures" <?php echo strpos ($section, 'furnitures') !== false ? 'selected' : '';?>> Furnitures </option>
			</select>
*/ ?>
<?php
			/* */
?>
			</td>
			<td>
<?php
			if($products['product_posted'] == 0) {
				if($products['date_modified'] == 0) {
					echo 'not yet published';
				} else {
					echo date("M j, Y g:i A", $products['date_modified']);
				}
			} else {
				echo date("M j, Y g:i A", $products['product_posted']);
			}
?>
			</td>
			<td> <i class="icon-trash del_prod"></i> </td>
		</tr>
<?php
	}
?>