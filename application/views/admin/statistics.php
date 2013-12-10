<?php
	$this->db->where('marketplace', 1);
	$this->db->where('published', 1);
	$queryProducts = $this->db->get('products');
	$resultProducts = $queryProducts->result_array();
	
	$this->db->where('published', 1);
	$publishProd = $this->db->get('products');
	
	if(date('j') == 1)
	{
		echo 'save history';
	}
	
	$totalProd = $this->db->query('SELECT * FROM products');
	$totalUsers = $this->db->query('SELECT * FROM users');
	
	$this_month = mktime(0, 0, 0, date("n"), 1, date("Y")); // get the first day of this month
	$this_day = time(); // get date and hours today
	$this_first_hour_of_a_day = mktime(0, 0, 0, date("n"), date("j"), date("Y")); // get first hour of this day 12:00 am

	
	$active_monthUser = $this->db->query('SELECT * FROM users WHERE date_last_login >= '.$this_month.' AND date_last_login < '.$this_day.'');
	$inactive_monthUser = $this->db->query('SELECT * FROM users WHERE date_last_login < '.$this_month.'');
	$active_nowUser = $this->db->query('SELECT * FROM users WHERE date_last_login >= '.$this_first_hour_of_a_day.'');
	
	$total_users = $totalUsers->num_rows();
	$total_active_this_month = $active_monthUser->num_rows();
	$total_inactive_this_month = $inactive_monthUser->num_rows();
	$total_active_this_day = $active_nowUser->num_rows(); 
	
	$percent_month = round(($total_active_this_month / $total_users) * 100, 1);
	$percent_day = round(($total_active_this_day / $total_users) * 100, 1);
?>

<div class="row-fluid">
	<div class="span3">
		<h4>Products</h4>
		<hr>
		<p>Total of all created products: <span class="badge badge-info"><?php echo $totalProd->num_rows(); ?></span></p>
		<p>Total published products: <span class="badge badge-info"><?php echo $publishProd->num_rows(); ?></span></p>
		<p>Products posted to marketplace: <span class="badge badge-info"><?php echo $queryProducts->num_rows(); ?></span></p>
 	</div>
	<div class="span3">
		<h4>Users</h4>
		<hr>
		<p>Total Users: <span class="badge badge-info"><?php echo $total_users; ?></span></p>
		<p>Active users this day: <span class="badge badge-important"><?php echo $total_active_this_day; ?></span></p>
		<p>Active users for this month: <span class="badge badge-info"><?php echo $total_active_this_month; ?></span></p>
		<p>Not active users for this month: <span class="badge badge-warning"><?php echo $total_inactive_this_month; ?></span></p>
		<hr>
		<h4>Total Active</h4>
		<hr>
		<p>Percentage PER Month: <strong style="font-size: 20px;"><?php echo $percent_month; ?>%</strong></p>
		<p>Percentage PER day: <strong style="font-size: 20px;"><?php echo $percent_day; ?>%</strong></p>
		<?php echo date("M-d-Y h:i:s",mktime(date('g'), date('i'), date('s'))); ?>
	</div>
</div>