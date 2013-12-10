<?php

	$queryView = $this->db->query("SELECT * FROM `user_marketgroup` WHERE `user_id` = '".$this->session->userdata('uid')."'");
	$rowView = $queryView->row_array();
	
	// $query = $this->db->query("SELECT * FROM user_marketgroup WHERE marketgroup_id = '".$group_id."' ");
	// $row = $query->row_array();

	// $query1 = $this->db->query("SELECT * FROM users WHERE uid = '".$row['user_id']."' ");
	// $row1 = $query1->row_array();

	// $queryGroup = "SELECT user_id FROM user_marketgroup WHERE marketgroup_id = '".$group_id."' AND role <> 1 ";

	// $queryList = $this->db->query("SELECT * FROM users WHERE uid IN (".$queryGroup.") ");
	// print_r($queryList->num_rows());
	
	$queryList = $this->db->get('user_marketgroup');
	
?>
<style>
/* RESPONSIVE */
@media (max-width: 767px)
{
	.mobile_view {
		padding: 0 8px;
	}
}
@media (max-width: 800px)
{
	#user_table {
		display: block;
		position: relative;
		width: 100%;
	}
	#user_table th {
		display: block;
		text-align: right;
		width: auto;
		font-size: 12px;
	}
	#user_table thead tr {
		display: block;
	}
	#user_table tbody tr {
		display: inline-block;
		vertical-align: top;
	}
	#user_table tbody {
		display: block;
		width: auto;
		position: relative;
		overflow-x: auto;
		white-space: nowrap;
	}
	#user_table td {
		display: block;
		min-height: 1.25em;
		text-align: left;
	}
	#user_table thead {
		display: block;
		float: left;
	}
}
@media (max-width: 320px)
{
	#user_input {
		margin: 0 -13px;
	}
}
</style>
<div class="container-fluid mobile_view">
	<legend style="font-family: Segoe UI Semibold; font-size: 18px; color: rgb(23, 23, 23);">User Manager</legend>
	<div id="contentArea">
		<table id="user_table" class="table table-striped table-condensed table-bordered">
			<thead>
				<tr>
					<th class="span2">Name</th>
					<th class="span2">Email</th>
					<th class="span2">Role</th>
					<th class="span2">Date Added</th>
					<th class="span2">Last Visit</th>
					<th class="span2"></th>
				</tr>
			</thead>
			<tbody>
<?php
		if($queryList->num_rows() > 0)
		{
			foreach($queryList->result_array() as $rowStatus)
			{
				$this->db->where('uid', $rowStatus['user_id']);
				$quser = $this->db->get('users');
				$row2 = $quser->row_array();
				
				/* DATE			 */
				$date_log = $rowStatus['last_visit'];
				if(isset($date_log))
				{
					$last_log = date('m-d-Y g:i a', $rowStatus['last_visit']);
				}else
				{
					$last_log = 'not visit yet';
				}
				
				if($rowStatus['role'] == 1) {
					$status = 'Administrator';
				}
				else if($rowStatus['role'] == 2)
				{
					$status = 'Moderator';
				}else if($rowStatus['role'] == 3)
				{
					$status = 'Member';
				}
				echo '
					<tr>
						<td>'.$row2['name'].'</td>
						<td>'.$row2['email'].'</td>
						<td class="role_status">'.$status.'</td>
						<td>'.date('m-d-Y g:i a', $rowStatus['date_added']).'
						<td>'.$last_log.'</td>
						<td>
					';
				if($rowView['role'] == 1 && $rowView['user_id'] != $rowStatus['user_id'])
				{
						echo '
								<button class="btn on_edit" alt="'.$row2['uid'].'">edit</button>
								<button class="btn on_delete" alt="'.$row2['uid'].'">delete</button>
							';
				}
					echo '
						</td>
					</tr>
				';
			
			}	
		}
?>
			</tbody>
		</table>
<?php
		if($rowView['role'] != 3)
		{
?>
		<div class="row-fluid">
			<div class="span2">
				<button class="btn add_user" style="margin-bottom: 10px;"><i class="iconic-plus"></i> Add user</button>
			</div>
			<div id="user_input" class="span10">
				<div class="pull-right input-append">
					<div class="btn-group">
						<input type="text" id="email_role" />
						<button class="btn search_user">Search</button>
					</div>
				</div>
			</div>
		</div>
<?php
		}
?>
		<table id="search" class="table table-condensed table-striped">
		</table>
	</div>
</div>

<!--modal-->
<div id="myModal_user_role" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
	<div class="modal-header title_message">
		<h3 id="myModalLabel" class="text-warning">Remove!</h3>
	</div>
	<div class="modal-body">
		<p>Are you sure you want to remove this user?</p>
		<p class="pull-right">
			<button class="btn" data-dismiss="modal" aria-hidden="true" type="button">No</button>
			<button class="btn btn-danger delete_alert" type="button">Yes</button>
		</p>
	</div>
</div>

<script>
$(function() {
	$('#contentArea').delegate('.add_user', 'click', function() {
		$('#user_input').show();
	});
	
	$('.search_user').click(function(){
		var key = $('#email_role').val();
		var dataString = { 'item': key, 'group_id': '<?php echo $group_id; ?>' };
		$.ajax({
			type: "POST",
			url: '<?php echo base_url(); ?>test/add_role',
			data: dataString,
			success: function(html) {
				$('#search').html(html);
				var windowH = $('table').height();	
				setTimeout(function(){
					$('html, body').animate({ scrollTop: windowH });
				},500);
			}
		});		
	});

	$('.on_add').click(function(){
		var uid = $(this).attr('alt');
		var type = $(this).parent().parent('tr').children('td').children('.role_type').val();
		
		var dataString = 'uid='+uid+'&type='+type+'&group_id=<?php echo $group_id; ?>';
		$.ajax({
			type: "POST",
			url: '<?php echo base_url(); ?>test/add_user_role',
			data: dataString,
			success: function(html) {
				$('.add'+uid).parent().parent().fadeOut(1000);
			}
		});
	});

	$('.on_edit').click(function(){
		$(this).html('save');
		$(this).removeClass('on_edit');
		$(this).addClass('on_save');
		$(this).parent().parent('tr').children('.role_status').html(
							'<select class="role_type">'+
								'<option value="1">Administrator</option>'+
								'<option value="2">Moderator</option>'+
								'<option value="3" selected>Member</option>'+
							'</select>'
		);
	});

	$('.on_delete').click(function(){
	
		var user_id = $(this).attr('alt');
		var pass_id = $('.delete_alert').attr('alt',user_id);
		$('#myModal_user_role').modal('show');

	});
	
	$('.delete_alert').click(function(){
		var user_id = $(this).attr('alt');
		var dataString = 'uid='+user_id;
		
		$.ajax({
			type: "POST",
			url: '<?php echo base_url(); ?>test/delete_role',
			data: dataString,
			success: function(html) {
				window.location.href = '<?php echo base_url('manage/market/user')?>';
			}
		});	
	});
	
	$('#on_save').click(function(){
		$(this).html('edit');
		$(this).removeClass('on_save');
		$(this).addClass('on_edit');
	
		var user_id = $(this).attr('alt');
		var role_type = $(this).parent().parent('tr').children('.role_status').children('.role_type').val();
		var event = $(this).parent().parent('tr');
		
		var dataString = 'uid='+user_id+'&role_type='+role_type+'&group_id=<?php echo $group_id; ?>';	
		
		$.ajax({
			type: "POST",
			url: '<?php echo base_url(); ?>test/edit_role',
			data: dataString,
			success: function(html) {
				$(event).children('.role_status').html(html);
			}
		});		
	});
});
</script>