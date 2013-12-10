<?php
		$uid = $this->session->userdata('uid');

		/* User Info Query */
		$this->db->where('uid', $uid);
		$query = $this->db->get('users');
		$user = $query->row_array();
		
		/* Get User Profile Pics */
		$profilePic = 'http://www.placehold.it/164x164/333333/ffffff&text=no+photo';
		if($user['profile_picture'] != null) {
			$profilePic = $user['profile_picture'];
			$profilePic = str_replace(" ", "_", $profilePic);
			$checkPic = 'uploads/'.$uid.'/medium/'.$profilePic;
			
			if($this->photo_model->image_exists($checkPic)) {
				$profilePic = base_url().$checkPic;
			} else {
				$checkPic = 'uploads/'.$uid.'/'.$profilePic;
				if($this->photo_model->image_exists($checkPic)) {
					$profilePic = base_url().$checkPic;
				} else {
					$checkPic = 'uploads/'.$profilePic;
					if($this->photo_model->image_exists($checkPic)) {
						$profilePic = base_url().$checkPic;
					} else {
						$profilePic = 'http://www.placehold.it/164x164/333333/ffffff&text=image+not+found';
					}
				}
			}
		}
		
		$this->db->where('user_id', $user['uid']);
		$this->db->where('deleted', 0);
		$result_websites = $this->db->get('websites');
		
		/* get users in user_marketgroups */
		$this->db->select('user_id');
		$this->db->where('user_id', $user['uid']);
		$qum = $this->db->get('user_marketgroup');
?>
	<div class="row-fluid left-side hidden-phone">
		<div class="text-center">
				<img id="imgprofile" class="img-polaroid" src="<?php echo $profilePic; ?>">
			<div class="row-fluid">
					<a href="<?php echo base_url(); ?>marketplace" target="_blank" class="btn b-shop">
						<i class="icon-shopping-cart"></i> 
						<span>SHOP NOW </span>
					</a>
			</div>
			<div class="row-fluid">
					<a href="<?php echo base_url(); ?>test/following" class="btn b-shop <?php echo $activemenu == 'following' ? 'active' : ''; ?>">
						<img src="<?php echo base_url(); ?>img/bolooka_favicon.png" /> 
						<span>FOLLOWING </span>
					</a>
			</div>
		</div>
		<ul class="nav nav-list" style="text-align: right; margin-bottom: 10px">
			<li class="nav-header">MENU</li>
			<li class="<?php echo $activemenu == 'dashboard' ? 'active' : ''; ?>"><a style="border-bottom: 1px solid #CFCFCF;" class="border-style" href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>
			<li class="<?php echo $activemenu == 'manage' ? 'active' : ''; ?>"><a style="border-bottom: 1px solid #CFCFCF;" class="border-style" href="<?php echo base_url('manage'); ?>">Manage e-store</a></li>
			<li class="<?php echo $activemenu == 'profile' ? 'active' : ''; ?>"><a style="border-bottom: 1px solid #CFCFCF;" class="border-style" href="<?php echo base_url('profile'); ?>">Profile</a></li>
			
		<?php
			if($user['market_access'] == 1 || $qum->num_rows() > 0) {
		?>	
			<li class="<?php echo $activemenu == 'market' ? 'active' : ''; ?>"><a style="border-bottom: 1px solid #CFCFCF;" class="border-style" href="<?php echo base_url().'manage/market'; ?>">Marketplace</a></li>
		<?php
			}
		?>	
			<li class="<?php echo $activemenu == 'transactions' ? 'active' : ''; ?>"><a style="border-bottom: 1px solid #CFCFCF;" class="border-style" href="<?php echo base_url().'multi/transactions'; ?>">Orders</a></li>
			<li class="hide <?php echo $activemenu == 'messaging' ? 'active' : ''; ?>"><a style="border-bottom: 1px solid #CFCFCF;" class="border-style" href="<?php echo base_url('dashboard/messaging'); ?>">Messaging</a></li>	
			<li class="hide <?php echo $activemenu == 'credits' ? 'active' : ''; ?>"><a style="border-bottom: 1px solid #CFCFCF;" class="border-style" href="<?php echo base_url('credits'); ?>">Credits</a></li>	

		</ul>
		<div class="row-fluid" style="margin-top: 20px;">
			<div class="span12" style="text-align: center;">
				<a href="#myModal_feedback" data-toggle="modal" id="feedback_button">Feedback</a>
				<hr style="position: relative; top: -31px;"/>
			</div>
		</div>
	</div>		
	<div style="clear:both;"></div>
	

<script type="text/javascript">
$(function(){
	// $('#send_feedback').click(function(){
		$('#form_feedback').ajaxForm({
			beforeSubmit: function(formData, jqForm, options){
				$('#send_feedback').attr('disabled', 'disabled');
				$('#send_feedback').html('Sending...');
				alert($('#inputSubject').val());return false;
			},
			success: function(html){
				if(html == 2) {
					$('#send_feedback').html('Failed');
				} else {
					$('#send_feedback').removeAttr('disabled');
					$('#send_feedback').html('Send');
					$('#myModal_feedback').modal('hide');
				}
				form_feedback.reset();
			}
		});
	// });
});	
</script>