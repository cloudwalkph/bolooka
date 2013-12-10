<?php
	$uid = $this->session->userdata('uid');
	$query = $this->db->query("SELECT * FROM user_marketgroup WHERE user_id = '".$uid."' ");
	$rowGroup = $query->row_array();
	
if(isset($_GET['page']))
{
	if($_GET['page'] == 'invite')
	{
		$query1 = "SELECT `web_id` FROM `web_marketgroup` WHERE `marketgroup_id` IS NOT NULL AND status <> 'decline'";
		$query_web = $this->db->query("SELECT * FROM websites WHERE id NOT IN ($query1) ");
	}
}
else
{	
	if(isset($rowGroup['marketgroup_id']))
	{
		$query1 = "SELECT `web_id` FROM `web_marketgroup` WHERE status <> 'rejected' AND marketgroup_id = ".$rowGroup['marketgroup_id']." "; 
		$queryweb = "SELECT * FROM `websites` WHERE `id` IN ($query1) ORDER BY id DESC";
		$query_web = $this->db->query($queryweb);
	}
	
}
?>
<style>
.tooltip_sitename {
	width: 100px;
}
@media (max-width: 767px)
{
	.mobile_view {
		padding: 0 8px;
	}
}

</style>
<div class="container-fluid mobile_view">
	<div class="row-fluid">
		<h4 id="msy-web" style="font-family: Segoe UI Semibold; font-size: 18px; color: rgb(23, 23, 23);"><legend>Websites: </legend></h4>
	</div>
	<div class="row-fluid">
		<div class="span12">
			<div class="row-fluid">
				<div class="span5">
<?php
	if($rowGroup['role'] != 3)
	{
?>
					<a href="<?php echo base_url(); ?>manage/market/website"><div class="btn btn-primary">approval</div></a>
					<a href="<?php echo base_url(); ?>manage/market/website?page=invite"><div class="btn btn-primary">invite</div></a>
<?php
	}
?>
				</div>
				<div class="span7">
					<div class="form-inline pull-right">
						<input type="text" id="search_website" class="span5" name="search_website" placeholder="Search by name..." alt="<?php echo isset($_GET['page']) ? 'invite' : 'aprroval'; ?>"/>
						<span>Filter by: </span>
						<select id="search_filter" name="search_filter" class="span5">
							<option></option>
							<option value="site_name">Company name</option>
							<option value="business_type" class="hidden-phone hidden-tablet">Business type</option>
							<option value="user_id" class="hidden-phone hidden-tablet">Site Owner</option>
						</select>
					</div>
				</div>
			</div>
		</div>
		<br/>
		<br/>
		<table class="market_table table table-bordered">
			<tr>
				<th class="hidden-phone hidden-tablet">Logo</th>
				<th class="detectName" >Company Name</th>
				<th class="hidden-phone hidden-tablet">Type of Business</th>
				<th class="hidden-phone hidden-tablet">Country</th>
				<th class="hidden-phone hidden-tablet">Business Description</th>
				<th class="hidden-phone hidden-tablet">Site Owner</th>
				<th>&nbsp;&nbsp;</th>
			</tr>
<?php 
		if($query_web->num_rows() > 0)
		{
			foreach($query_web->result_array() as $row)
			{
				$this->db->where('website_id', $row['id']);
				$query_logo = $this->db->get('logo');
				$row_logo = $query_logo->row_array();
				if($query_logo->num_rows() > 0)
				{
					$logoimage = 'uploads/'.str_replace('uploads/', '', $row_logo['image']);
					if($this->photo_model->image_exists($logoimage)) {
						$logo = base_url($logoimage);
					} else {
						$logo = 'http://www.placehold.it/160x160/333333/ffffff&text=image+not+found';
					}
				} else {
					$logo = 'http://www.placehold.it/160x160/333333/ffffff&text=no+image';
				}
				
				$query_business = $this->db->query("SELECT * FROM business_categories WHERE Category = '".$row['business_type']."' ");
				$row_buss = $query_business->row_array();
				
				$query_user = $this->db->query("SELECT * FROM users WHERE uid = '".$row['user_id']."' ");
				$row_user = $query_user->row_array();
				
				$profile_picture_image = 'uploads/thumbnail/'.$row_user['profile_picture'];
				if($this->photo_model->image_exists($profile_picture_image)) {
					$profile_picture = base_url($profile_picture_image);
				} else {
					$profile_picture_image = 'uploads/'.$row_user['profile_picture'];
					if($this->photo_model->image_exists($profile_picture_image)) {
						$profile_picture = base_url($profile_picture_image);
					} else {
						$profile_picture = 'http://www.placehold.it/160x160/333333/ffffff&text=image+not+found';
					}
				}
?>		
				<tr class="asd" id="<?php echo $row['id']; ?>">
					<td class="hidden-phone hidden-tablet">
						<div style="height: auto; text-align: center; width: 80px;">
							<img src="<?php echo $logo; ?>" style="max-height: 80px; max-width: 80px;" />
						</div>
					</td>
					<td>
						<div style="text-overflow: ellipsis; overflow: hidden;">
							<a class="tooltip_sitename" href="<?php echo base_url().$row['url']; ?>" target="_blank" data-toggle="tooltip" title="<?php echo $row['site_name']; ?>">
								<?php echo $row['site_name'] ? $row['site_name'] : ''; ?>
							</a>
						</div>
					</td>
					<td class="hidden-phone hidden-tablet">
						<div style="text-overflow: ellipsis; overflow: hidden;"><?php echo isset($row_buss['Description']) ? $row_buss['Description'] : ''; ?></div>
					</td>
					<td class="hidden-phone hidden-tablet">
						<div style="text-align: center;"><?php echo $row['country']; ?></div>
					</td>
					<td class="hidden-phone hidden-tablet">
						<div style="text-overflow: ellipsis; overflow: hidden; max-height: 80px;"><?php echo $row['description']; ?></div>
					</td>
					<td class="hidden-phone hidden-tablet">
						<div style="border: 1px solid;">
							<img src="<?php echo isset($profile_picture) ? $profile_picture : ''; ?>" style="max-height: 78px; max-width: 78px;" alt="<?php echo $row_user['name']; ?>" />
						</div>
					</td>
					<td style="width: 100px;">
<?php
				$this->db->where('web_id', $row['id']);
				$query_aprub = $this->db->get('web_marketgroup');
				$row_aprub = $query_aprub->row_array();
					if(isset($row_aprub['status']))
					{
						if($row_aprub['status'] === 'approved')
						{
?>
							<button class="btn btn-block btn-success" disabled="disabled"> approved </button>
							<button class="btn btn-block on_reject"> delete </button>
<?php
						}
						elseif($row_aprub['status'] === 'invite')
						{
?>
							<button class="btn btn-block" disabled="disabled"> pending </button>
							<button class="btn btn-block on_reject"> cancel </button>
<?php
						}
						elseif($row_aprub['status'] === 'accepted' || $row_aprub['status'] === '1')
						{
?>
							<button class="btn btn-block btn-success" disabled="disabled"> accepted </button>
							<button class="btn btn-block on_reject"> delete </button>
<?php
						}
						elseif($row_aprub['status'] === 'decline')
						{
?>
							<button id="but<?php echo $row['id']; ?>" class="btn btn-block btn-danger" alt="<?php echo $row['id']; ?>"> denied </button>
							<button class="btn btn-block on_reject"> delete </button>
<?php
						}
						elseif($row_aprub['status'] === 'request' || $row_aprub['status'] === '0')
						{
?>
							<button class="btn btn-block on_approve"> approve </button>
							<button class="btn btn-block on_reject"> cancel </button>
<?php
						}
					}
					else
					{
						if($rowGroup['role'] != 3)
						{
							if(isset($_GET['page']))
							{
								if($_GET['page'] == 'invite')
								{
?>
									<button class="btn on_notify">notify</button>
<?php
								}
								else
								{
?>
									<button class="btn on_approve"> approve </button>
									<button id="click<?php echo $row['id']; ?>" class="btn on_reject" alt="<?php echo $row['id']; ?>"> reject </button>
<?php
								}
							}
						}
					}
?>
					</td>
				</tr>
<?php
			}
		}
?>
		</table>
	</div>
</div>

<script>
$(function(){
	$('.tooltip_sitename').tooltip();

	$('.on_approve').click(function() {	
		var element = $(this);
			web_id = $(this).parents('.asd').attr('id'),
			dataString = { wid: web_id };
			console.log(dataString);
		$.ajax({
			type: "POST",
			url: '<?php echo base_url(); ?>test/approve_web',
			data: dataString,
			success: function(data) {
				element.addClass('btn-success').text('approved');
			}
		});
	});

	$('.on_reject').click(function() {
		var tr = $(this).parents('.asd'),
			trwid = tr.attr('id'),
			dataString = { 'wid': trwid };
		$.ajax({
			type: "POST",
			url: '<?php echo base_url(); ?>test/remove_web',
			data: dataString,
			success: function(data) {
				tr.slideUp().remove();
			}
		});
	});

	$('#search_website')
		.bind('keyup',function(e) {
			var x = $(this).val();
			var content = $(this).attr('alt');
			var dataString = { 'content': content, 'search_by': x, 'group_id': '<?php echo $rowGroup['marketgroup_id']; ?>' };
			if(e.keyCode == 13)
			{
				$.ajax({
					type: "POST",
					url: '<?php echo base_url(); ?>test/search_web',
					data: dataString,
					success: function(html) {
						$('.market_table').html(html);
					}
				});
			}
		})
		.click(function() {
			$('.detectName').css('color','#EAB82E');
			setTimeout(function(){
				$('.detectName').css('color','#777');
			},1000);
		});
	
	$('.market_table').delegate('.on_notify','click', function(e) {
		var tr = $(this).parents('.asd');
		var trwid = tr.attr('id');
		var dataString = { 'wid': trwid, 'group_id': '<?php echo $rowGroup['marketgroup_id']; ?>' };
		$.ajax({
			type: "POST",
			url: '<?php echo base_url(); ?>test/on_invite',
			data: dataString,
			success: function(data) {
				if(data == 'success') {
					$(e.target).text('pending').addClass('disabled').removeClass('on_notify');
				}
			}
		});	
	});
	
	$('#search_filter').change(function() {
		var val = $(this).val();
		var content = '<?php echo isset($_GET['page']) ? 'invite' : 'aprroval'; ?>';
		var dataString = 'content='+content+'&filter_by='+val+'&group_id=<?php echo $rowGroup['marketgroup_id']; ?>';
		$.ajax({
			type: "POST",
			url: '<?php echo base_url(); ?>test/filter_web',
			data: dataString,
			success: function(html) {
				$('.market_table').html(html);
			}
		});	
	});
});
</script>