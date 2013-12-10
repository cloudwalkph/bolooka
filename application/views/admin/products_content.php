<?php
	$resultProducts = $queryProducts->result_array();
	foreach($resultProducts as $products) {
		// $this->db->select('user_id');
		// $this->db->where('id', $products['website_id']);
		// $this->db->where('deleted', 0);
		// $queryUser = $this->db->get('websites');
		// $rowUser = $queryUser->row_array();
		// if(isset($rowUser['user_id'])) {
?>
		<tr>
			<td><?php echo $products['id']; ?></td>
			<td><?php echo $products['name']; ?></td>
			<td><?php echo $products['category']; ?></td>
			<td><?php echo $products['price']; ?></td>
			<td><?php echo $products['stocks']; ?></td>
			<td><?php echo $products['video']; ?></td>
			<td>
			<?php 
				if($this->db->field_exists('product_desc', 'products')) {
					echo $products['product_desc'];
				} else {
					echo $products['desc'];
				}
			?>
			</td>
			<td>
<?php
			$this->db->where('id', $products['marketplace']);
			$queryMarket = $this->db->get('marketgroup');
			$resultMarket = $queryMarket->row_array();
			if($queryMarket->num_rows() > 0) {
				echo $resultMarket['name'];
			} else {
				echo 'no market group';
			}
?>
			</td>
			<td><?php echo $products['date_created'] == 0 ? "no data" : date("F j, Y", $products['date_created']); ?></td>
			<td><?php echo $products['date_modified'] == 0 ? "no data" : date("F j, Y", $products['date_modified']); ?></td>
			<td><?php echo $products['published'] == 0 ? 'unpublished' : 'published'; ?></td>

			<td>
<?php
			$this->db->where('id', $products['website_id']);
			$this->db->where('deleted', 0);
			$queryWebsite = $this->db->get('websites');
			$resultWebsite = $queryWebsite->row_array();
			
			if($queryWebsite->num_rows() > 0) {
				echo $resultWebsite['site_name'];
			} else {
				echo '<strong style="color: red;">no website</strong>';
			}
?>
			</td>
			
			<td> <i class="icon-trash"></i> </td>
		</tr>
<?php
		// }
	}
?>