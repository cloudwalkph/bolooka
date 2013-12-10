		<div class="row-fluid form-inline">
			<div class="span6">
<?php
			$array = array(
				'class' => 'form_searchdate',
				'name' => 'form_searchdate'
			);
			echo form_open_multipart(base_url().'test/loadmore', $array);
?>
				<label for="userfrom">From</label>
				<input type="text" id="userfrom" name="userfrom" class="from" value="<?php echo $this->input->post('userfrom') ?>" />
				<label for="userto">to</label>
				<input type="text" id="userto" name="userto" class="to" value="<?php echo $this->input->post('userto') ?>" />
				<button type="submit" class="btn">Go</button>
<?php
			echo form_close();
?>
			</div>
			<div class="span3 text-right">
				<button id="add_user" class="btn btn-primary hide" data-loading-text="loading..."> + Add User </button>
			</div>
			<div class="span3 text-right">
				<form class="searchform">
					<input type="text" class="searchprod" placeholder="Search..." name="searchprod" />
				</form>
			</div>
		</div>

	<table id="users" class="table table-striped table-condensed table-bordered">
	<caption>
		<div class="row-fluid">
			<div class="span4">
<?php
	$social_count['fb_id_fk'] = 0; $social_count['y_id_fk'] = 0; $social_count['g_id_fk'] = 0; $social_count['msn_id_fk'] = 0;
	foreach($queryAllUsers->result_array() as $user) {
		if($user['fb_id_fk'] != null) {
			$social_count['fb_id_fk']++;
		}
		if($user['y_id_fk'] != null) {
			$social_count['y_id_fk']++;
		
		}
		if($user['g_id_fk'] != null) {
			$social_count['g_id_fk']++;
		
		}
		if($user['msn_id_fk'] != null) {
			$social_count['msn_id_fk']++;
		}
	}
	
?>
				<span>
					<div class="fb_bg fb_button_log" style="font-family: lucida grande,tahoma,verdana,arial,sans-serif; color: rgb(255, 255, 255); cursor: pointer; line-height: 14px;">
							<span style="color: white; font-weight: 600; vertical-align: middle; padding: 0px 6px; font-size: 12px;"> f </span>
					</div>
					<span class="label label-inverse"> <?php echo $social_count['fb_id_fk']; ?> </span>
				</span>
				&nbsp;
				<span>
					<img src="http://www.bolooka.com/img/yahoo_icon_drop.png" style="height: 17px; width: 17px;">
					<span class="label label-inverse"> <?php echo $social_count['y_id_fk']; ?> </span>
				</span>
				&nbsp;
				<span>
					<img src="http://www.bolooka.com/img/google_icon_drop.png" style="height: 17px; width: 17px;">
					<span class="label label-inverse"> <?php echo $social_count['g_id_fk']; ?> </span>
				</span>
				&nbsp;
				<span>
					<img src="http://www.bolooka.com/img/msn_icon_drop.png" style="height: 17px; width: 17px;">
					<span class="label label-inverse"> <?php echo $social_count['msn_id_fk']; ?> </span>
				</span>
			</div>
			<div class="span4">Total No. of Users: <strong><?php echo $queryAllUsers->num_rows(); ?></strong></div>
		</div>
	</caption>
	<thead>
		<tr>
			<th data-order="uid"> # </th>
			<th data-order="name"> name </th>
			<th data-order="first_name"> first name </th>
			<th data-order="last_name"> last name </th>
			<th data-order="email"> email </th>
			<th> registered via: </th>
			<th data-order="gender"> gender </th>
			<th data-order="dob"> date of birth </th>
			<th data-order="email_status"> email verified </th>
			<th data-order="date_registered"> date registered </th>
			<th data-order="date_last_login"> date last login </th>
			<th data-order="status"> status </th>
			<th data-order="market_access"> marketplace access </th>
			<th data-order="admin_access"> administrator access </th>
		</tr> 
	</thead>
	<tbody>
<?php
		echo $users_content;
?>
	</tbody>
</table>
<script>
$(function() {
	$('#users').on('click', 'button[name="mrkt"]',function(e) {
		var el = e.target;
		var userID = $(this).parents('tr').find('td:first-child').html();
		var value = el.value;
		var dataString = { 'userID': userID, 'value': value };
		
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>manage/add_access2market",
			data: dataString,
			success: function(html){
				if(value == 1) {
					$(el).html('Granted').addClass('btn-success').removeClass('btn-danger').val(0);
				} else {
					$(el).html('Not Granted').addClass('btn-danger').removeClass('btn-success').val(1);
				}
			}
		});
	});

	$('#users').on('click', 'button[name="admin"]', function(e) {
		var el = e.target;
		var userID = $(this).parents('tr').find('td:first-child').html();
		var value = el.value;
		var dataString = { 'userID': userID, 'value': value };
		
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>test/add_access2admin",
			data: dataString,
			success: function(html){
				if(value == 1) {
					$(el).html('Granted').addClass('btn-success').removeClass('btn-danger').val(0);
				} else {
					$(el).html('Not Granted').addClass('btn-danger').removeClass('btn-success').val(1);
				}
			}
		});
	});

	$('#add_user').click(function() {
		$('#add_user_modal').modal('show');
	});
});
</script>
<!-- User Modals -->
	<!--Sign up form modal-->
	<div id="add_user_modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" style="background: #383838;width: 290px;left:60%;">
		<div class="modal-header title_message">
			<h3 id="myModalLabel" style="color: #ddd;font-family: 'ScalaSans Light';">Welcome to Bolooka!</h3>
		</div>
		<div class="modal-body">
			<p style="color: #ddd;font-family: 'ScalaSans Light';">Please complete remaining fields</p>
			<?php echo $this->load->view('homepage/sign_up_form'); ?>
		</div>
	</div>
<!-- -->