<?php
	$query = $this->db->query("SELECT * FROM user_marketgroup WHERE marketgroup_id = '".$group_id."' ORDER BY last_visit DESC");
	
	$getGrouId = $this->db->query("SELECT * FROM user_marketgroup WHERE user_id = ".$this->session->userdata('uid')." ");
	$groupID = $getGrouId->row_array();
	
	$get_web_prod = "SELECT web_id FROM web_marketgroup WHERE (status='accepted' OR status='approved') AND marketgroup_id=".$groupID['marketgroup_id']."";
	$get_prod_nums = $this->db->query("SELECT * FROM products WHERE website_id IN(".$get_web_prod.") AND published = 1");
	$num_of_prod = $get_prod_nums->num_rows();
	
	/* number of websites */
	$quePen = $this->db->query("SELECT `web_id` FROM `web_marketgroup` WHERE `status` = '0' AND marketgroup_id=".$groupID['marketgroup_id']."");
	$queYes = $this->db->query("SELECT `web_id` FROM `web_marketgroup` WHERE `status` IN ('accepted', 'approved') AND marketgroup_id=".$groupID['marketgroup_id']."");
	$queAll = $this->db->query("SELECT `web_id` FROM `web_marketgroup` WHERE  marketgroup_id=".$groupID['marketgroup_id']."");
	

?>
<style>
	.thumbnail:hover {
		border: 1px solid #08C;
	}
	/* RESPONSIVE */
	@media (max-width: 767px)
	{
		.mobile_view {
			padding: 0 8px;
		}
	}	
</style>
<div class="container-fluid mobile_view">
<legend style="font-family: Segoe UI Semibold; font-size: 18px; color: rgb(23, 23, 23);">My Marketplace</legend>
<div class="row-fluid">
	<div class="span12">
		<div class="row-fluid">
			<div class="span8">
				<ul class="thumbnails">
					<li class="span6">
						<a href="<?php echo base_url('manage/market/details'); ?>">
							<div class="thumbnail">
								<div style="background:#ddd;text-align:center;padding:10px;">
									<img src="<?php echo base_url('img/details_front_image.png'); ?>">
								</div>
								<h5 style="text-align: center;">Edit Marketplace</h5>							
							</div>
						</a>
					</li>
					<li class="span6">
						<a href="<?php echo base_url('manage/market/website'); ?>">
							<div class="thumbnail">
								<div style="background:#ddd;text-align:center;padding:10px 0;">
									<img src="<?php echo base_url('img/website_front_image.png'); ?>">
								</div>
								<h5 style="text-align: center;">Websites</h5>							
							</div>
						</a>
					</li>
					<li class="span6" style="margin:0;">
						<a href="<?php echo base_url('manage/market/product'); ?>">
							<div class="thumbnail">
								<div style="background:#ddd;text-align:center;padding:10px 0;">
									<img src="<?php echo base_url('img/product_front_image.png'); ?>">
								</div>
								<h5 style="text-align: center;">Products</h5>							
							</div>
						</a>
					</li>
					<li class="span6">
						<a href="<?php echo base_url('manage/market/user'); ?>">
							<div class="thumbnail">
								<div style="background:#ddd;text-align:center;padding:10px 0;">
									<img src="<?php echo base_url('img/user_front_image.png'); ?>">
								</div>
								<h5 style="text-align: center;">Users</h5>							
							</div>
						</a>
					</li>
				</ul>
			</div>
			<div class="span4">
				<p><strong>Last active users</strong></p>
				<hr>
				<table class="table table-condensed table-striped" style="border:1px solid #ddd;">
					<thead>
					<th>#</th>
					<th>Name</th>
					<th>Date</th>
					<th>Time</th>
					</thead>
					<?php
						if($query->num_rows() > 0)
						{
							$x = 1;
							foreach($query->result_array() as $row)
							{
								$queryUser = $this->db->query("SELECT * FROM users WHERE uid='".$row['user_id']."' ");
								$rowUser = $queryUser->row_array();
								if($row['last_visit'])
								{
									$last_log = date('n-j-Y',$row['last_visit']);
									$last_time = date('g:i a',$row['last_visit']);
								}else
								{
									$last_log = '--';
									$last_time = '--';
								}
								
								echo '<tr>';
								echo '<td>'.$x++.'</td>';
								echo '<td title="'.$rowUser['name'].'">'.$rowUser['name'].'</td>';
								echo '<td class="div_list">'.$last_log.'</td>';
								echo '<td class="div_list" title="Last visited">'.$last_time.'</td>';
								echo '</tr>';
							}
						}
					?>					
				</table>

				<p><strong>Status:</strong></p>
				<hr>
				<?php
					if($quePen->num_rows() > 0)
					{
						echo '<p>You have <a style="color: red; text-decoration: underline;" href="'.base_url().'manage/market/website">'. $quePen->num_rows() .'</a> website pending request! </p> ';
					}
					else
					{
						echo '<p>Marketplace websites statuses: </p>';
					}
				?>
				<p><?php echo $queYes->num_rows() . ' approved out of ' . $queAll->num_rows() . ' websites' ?></p>
				<p>Total number of products: <?php echo $num_of_prod; ?></p>
			</div>
		</div>
	</div>
</div>
</div>
<script>
$('#msy-web').click(function(ev,ui) {
	if(ev.ctrlKey == true ) {
		if(confirm("Are you sure you want to delete")) {
			var xmlhttp;
			if (window.XMLHttpRequest)
			  {// code for IE7+, Firefox, Chrome, Opera, Safari
			  xmlhttp=new XMLHttpRequest();
			  }
			else
			  {// code for IE6, IE5
			  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			  }
			xmlhttp.onreadystatechange=function()
			  {
			  if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{
					var data = xmlhttp.responseText;
					location.href = 'manage/market';
				}
			  }
			xmlhttp.open("POST","<?php echo base_url('manage/market/delete'); ?>",true);
			xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xmlhttp.send("market_id=<?php echo $group_id; ?>");
		}
	}
});
</script>