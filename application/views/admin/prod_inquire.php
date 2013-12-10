
	<div class="container-fluid">
<?php
	$this->db->order_by('timestamp DESC');
	$qprodinq = $this->db->get('product_inquiry');
	if($qprodinq->num_rows() > 0) {
?>
		<table id="websitesTable" class="table table-striped table-condensed table-bordered">
			<caption>Product Inquiries: </caption>
			<thead>
				<tr>
					<th>ID</th>
					<th>Receiver's Email</th>
					<th>Sender's Message</th>
					<th>Sender's Name</th>
					<th>Subject</th>
					<th>Message</th>
					<th>Sent</th>
				</tr>
			</thead>
			<tbody>
<?php
				$rprodinq = $qprodinq->result_array();
				foreach($rprodinq as $inquiry) {
?>
					<tr>
						<td><?php echo $inquiry['id']; ?></td>
						<td><?php echo $inquiry['receiver_email']; ?></td>
						<td><?php echo $inquiry['sender_email']; ?></td>
						<td><?php echo $inquiry['sender_name']; ?></td>
						<td><?php echo $inquiry['subject']; ?></td>
						<td><?php echo $inquiry['message']; ?></td>
						<td><?php echo date('m-d-y g:i a', $inquiry['timestamp']); ?></td>
					</tr>
<?php
				}
?>
			</tbody>
		</table>
<?php
	} else {
?>
		<div>No Data to display</div>
<?php
	}
?>
	</div>