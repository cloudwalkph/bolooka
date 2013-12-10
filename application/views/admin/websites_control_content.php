<?php
		$result = $queryActiveWebsites->result_array();
		foreach($result as $website) {
			/* get user query */
			$this->db->where('uid', $website['user_id']);
			$queryuser = $this->db->get('users');
			
			if($queryuser->num_rows() > 0) {
				$rowuser = $queryuser->row_array();
?>
			<tr <?php echo $website['deleted'] != 0 ? 'class="error"' : ''; ?> >
				<td><?php echo $website['id']; ?></td>

				<td><a href="<?php echo $website['url']; ?>"> <?php echo $website['site_name']; ?> </a></td>
				<td>
<?php
				if(isset($rowuser)) {
					echo '<a href="mailto:'.$rowuser['email'].'">'.$rowuser['email'].'</a>';
				} else {
					echo 'no user connected';
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

				<td>
					<div style="text-overflow: ellipsis; overflow: hidden; max-height: 80px;">
						<?php echo $website['description'] != '' ? $website['description'] : '<em>no description</em>'; ?>
					</div>
				</td>
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
				<td>
<?php
				if($website['deleted'] == 0) {
					if($website['marketplace'] == 1) {
						echo '<button class="btn btn-success" name="mod" value="0">Approved</button>';
					} else {
						echo '<button class="btn btn-danger" name="mod" value="1">Disapproved</button>';
					}
				} else {
					echo 'DELETED';
				}
?>
				</td>
				<td><?php echo $website['date_created'] == 0 ? "no data" : date("M j, Y g:i A", $website['date_created']); ?></td>


			</tr>
<?php
			}
		}
?>