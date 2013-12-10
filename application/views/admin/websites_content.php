<?php
		$result = $queryWebsites->result_array();
		foreach($result as $website) {
			/* get user query */
			$this->db->where('uid', $website['user_id']);
			$queryuser = $this->db->get('users');
			$rowuser = $queryuser->row_array();
?>
			<tr <?php echo $website['deleted'] != 0 ? 'class="error"' : ''; ?> >
				<td><?php echo $website['id']; ?></td>
				<td>
<?php
				echo isset($rowuser['uid']) ? $rowuser['uid'] : '<strong>no user id<strong>';
?>
				</td>
				<td><a href="<?php echo $website['url']; ?>"> <?php echo $website['site_name']; ?> </a></td>
				<td>
<?php
				$this->db->where('Category', $website['business_type']);
				$queryBusType = $this->db->get('business_categories');
				if($queryBusType->num_rows() > 0) {
					$resultBusType = $queryBusType->row_array();
					echo $resultBusType['Description'];
				} else {
					echo 'No Category';
				}
?>
				</td>
				<td>
<?php
				$this->db->where('website_id', $website['id']);
				$querylogo = $this->db->get('logo');
				$resultlogo = $querylogo->row_array();
				
				if($resultlogo['image'] != null) {
					$imgsrc = str_replace('uploads/','',$resultlogo['image']);
					
					$img = 'uploads/thumbnail/' . $imgsrc;
					if($this->photo_model->image_exists($img)) {
						$logo_img = base_url().$img;
					} else {
						$img = 'uploads/' . $imgsrc;
						if($this->photo_model->image_exists($img)) {
							$thumbnail = $this->photo_model->make_thumbnail($img);
							$logo_img = base_url().$thumbnail;
						} else {
							$logo_img = "http://www.placehold.it/80x80/333333/ffffff&text=not+found";
						}
					}
				} else {
					$logo_img = "http://www.placehold.it/80x80/333333/ffffff&text=no+logo";
				}
				echo '<img src="'.$logo_img.'" style="max-width: 80px;">';
?>
				</td>
				<td><?php echo $website['country']; ?></td>
				<td><div style="text-overflow: ellipsis; overflow: hidden; white-space: pre-wrap; max-height: 80px;"><?php echo $website['description']; ?></div></td>
				<td><?php echo isset($website['background']) ? 'Yes' : 'No'; ?></td>
				<td><?php echo $website['layout']; ?></td>
				<td><?php echo $website['status'] == 1 ? "Active" : "Deactivated"; ?></td>
				<td><?php echo $website['favicon'] ? 'Yes' : 'No'; ?></td>
				<td>
<?php
				$this->db->where('id', $website['marketgroup']);
				$queryMarket = $this->db->get('marketgroup');
				if($queryMarket->num_rows() > 0) {
					$resultMarket = $queryMarket->row_array();
					echo '<span>'.$resultMarket['name'].'</span>';
				} else {
					echo 'No Marketgroup';
				}
?>
				</td>

				<td><?php echo $website['date_created'] == 0 ? "no data" : date("M j, Y g:i A", $website['date_created']); ?></td>
				<td><?php echo $website['deleted'] == 0 ? "Active" : date("M j, Y g:i A", $website['deleted']); ?></td>
				
				<td>
<?php
			if($website['deleted'] != 0) {
?>
					<i id="delete_web" class="icon-trash"></i>
<?php
			}
?>
				</td>
			</tr>
<?php
		}
?>