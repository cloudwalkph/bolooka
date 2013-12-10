<?php

	$site_status = $this->db->query("SELECT `status` FROM `websites` WHERE `id` = '".$site_id."'");
	$status = $site_status->row_array();
	
	if($status['status']==0)
	{
		echo '
			<script>
				$(document).ready(function(){
						$(".editSite").fadeOut(300);
						$(".editSite").fadeIn(300);
						$(".editSite").fadeOut(300);
						$(".editSite").fadeIn(300);
						$(".editSite").fadeOut(300);
						$(".editSite").fadeIn(300);
						$(".editSite").fadeOut(300);
						$(".editSite").fadeIn(300);	
				});
			</script>
		';
		$this->db->query("UPDATE `websites` SET `status` = '1' WHERE `id` = '".$site_id."'");
	}
	
?>
<ul class="nav nav-pills pull-right">
  <li class="dropdown" style="text-align: center;">
	<a class="dropdown-toggle" data-toggle="dropdown" href="#">
		<p style="margin-bottom: 3px;">Shopping Cart</p>
		<p style="font-size: 11px;margin-bottom: 1px;">0 item(s) - P 0.00 &#9660;</p>
	</a>
		<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
		<li>asdasd</li>
	  </ul>
  </li>
<?php
	if($this->session->userdata('logged_in')) {
	
		
		
		$the_user = $this->session->userdata('uid');
		$the_website = $site_id;
		
		$query = $this->db->query("SELECT * FROM follow WHERE users='$the_user' AND website_id='$the_website'");
		$querySite = $this->db->query("SELECT * FROM websites WHERE user_id='$the_user' AND id='$the_website'");
		
		if($querySite->num_rows() > 0)
		{
			echo '<li class="editSite"><a href="'.base_url().'manage/webeditor?wid='.$the_website.'">Edit Website</a></li>';
		}
		echo '	<li>
					<a href="'.base_url().'dashboard">Dashboard</a>
				</li>';

		if ($query->num_rows() > 0)
		{
		   echo '<li><a href="'.base_url().'test/unfollow/?siteurl='.current_url().'&uid='.$the_user.'&website_id='.$the_website.'">Unfollow</a></li>';
		}
		else
		{
		   echo '<li><a href="'.base_url().'test/follow/?siteurl='.current_url().'&uid='.$the_user.'&website_id='.$the_website.'">Follow</a></li>';
		}
		
		
	}
	else
	{
		echo '
			<li><a data-toggle="collapse" data-parent="#accordion2" href="#collapseThree" >Register</a></li>
			<li><a data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo" >Sign in</a></li>
		';
		
	}
?>
</ul>