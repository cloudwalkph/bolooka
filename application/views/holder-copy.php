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
<ul id="follow" style="margin: 1em 0">
<?php
	if($this->session->userdata('logged_in')) {
	
		echo '<form>';
		
		$the_user = $this->session->userdata('uid');
		$the_website = $site_id;
		
		$query = $this->db->query("SELECT * FROM follow WHERE users='$the_user' AND website_id='$the_website'");
		$querySite = $this->db->query("SELECT * FROM websites WHERE user_id='$the_user' AND id='$the_website'");
		
		if($querySite->num_rows() > 0)
		{
			echo '<li class="editSite"><a href="'.base_url().'dashboard/edit?wid='.$the_website.'"><span class="editSite" style="color: #FFFFFF">Edit Website</span></a></li>&nbsp;';
			// echo '<li><button formmethod="post" formaction="'.base_url().'dashboard/edit/site_details" style="" class="editSite" name="edit_site" value="'.$site_id.'" type="submit">Edit Website</button></li>&nbsp;';
		}
		echo '	<li>
					<a href="'.base_url().'manage/dashboard"><span style="color: #FFFFFF">Dashboard</span></a>
				</li>&nbsp;';

		if ($query->num_rows() > 0)
		{
		   echo '<li><a href="'.base_url().'test/unfollow/?siteurl='.current_url().'&uid='.$the_user.'&website_id='.$the_website.'"><span style="color: #FFFFFF">Unfollow</span></a></li>';
		}
		else
		{
		   echo '<li><a href="'.base_url().'test/follow/?siteurl='.current_url().'&uid='.$the_user.'&website_id='.$the_website.'"><span id="followButton" style="color: #FFFFFF">Follow</span></a></li>';
		}
		
		echo '</form>';
	}
	else
	{
		echo '
			<li><a href="'.base_url().'"><span style="color: #FFFFFF">Register</span></a></li>
			<li><a class="sm_sign_in">Login</a></li>
		';
		$this->load->view('homepage/sign_in_form');
	}
?>
</ul>