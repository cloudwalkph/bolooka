<?php
	$resultUsers = $queryUsers->result_array();
	foreach($resultUsers as $users) {
?>
		<tr>
			<td><?php echo $users['uid']; ?></td>
			<td><?php echo $users['name']; ?></td>
			<td><?php echo $users['first_name']; ?></td>
			<td><?php echo $users['last_name']; ?></td>
			<td><?php echo $users['email']; ?></td>
			<td>
			<?php
				if($users['fb_id_fk'] != null) {
					echo '
						<div class="fb_bg fb_button_log" style="font-family: \'lucida grande\',tahoma,verdana,arial,sans-serif; color: rgb(255, 255, 255); cursor: pointer; line-height: 14px;">
							<span style="color: white; font-weight: 600; vertical-align: middle; padding: 0px 6px; font-size: 12px;"> f </span>
						</div>';
				}
				if($users['y_id_fk'] != null) {
					echo '<img src="http://www.bolooka.com/img/yahoo_icon_drop.png" style="height: 17px; width: 17px;">';
				}
				if($users['g_id_fk'] != null) {
					echo '<img src="http://www.bolooka.com/img/google_icon_drop.png" style="height: 17px; width: 17px;">';
				}
				if($users['msn_id_fk'] != null) {
					echo '<img src="http://www.bolooka.com/img/msn_icon_drop.png" style="height: 17px; width: 17px;">';
				}
			?>	
			</td>
			<td><?php echo $users['gender']; ?></td>
			<td><?php echo $users['dob']; ?></td>
			<td><?php echo $users['email_status']; ?></td>
			<td><?php echo $users['date_registered'] == 0 ? "no data" : date("M j, Y g:i A", $users['date_registered']); ?></td>
			<td><?php echo $users['date_last_login'] == 0 ? "no data" : date("M j, Y g:i A", $users['date_last_login']); ?></td>
			<td><?php echo $users['status'] == 1 ? 'Yes' : 'No' ?></td>
			<td>
<?php 
			if($users['market_access'] == 1) {
				echo '<button class="btn btn-small btn-success" name="mrkt" value="0">Granted</button>';
			} else {
				echo '<button class="btn btn-small btn-danger" name="mrkt" value="1">Not Granted</button>';
			}
?>
			</td>
			<td>
<?php 
			if($users['admin_access'] == 1) {
				echo '<button class="btn btn-small btn-success" name="admin" value="0">Granted</button>';
			} else {
				echo '<button class="btn btn-small btn-danger" name="admin" value="1">Not Granted</button>';
			}
?>
			</td>
		</tr>
<?php
	}
?>