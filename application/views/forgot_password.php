<?php
	$this->db->where('uid',$uid);
	$this->db->where('hash',$hash);
	$query = $this->db->get('users');
	$row = $query->row_array();
	
	if($query->num_rows() > 0)
	{
		$pass = $this->encrypt->decode($row['password']);
?>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.form.js"></script>
<div class="div_center">
<?php
		$admin_form_attrib = array(
			'id' => 'passform',
			'name' => 'passform',
			'class' => 'well form-horizontal'
		);
		echo form_open_multipart('profile/reset_password', $admin_form_attrib)
?>
		<center>
			<img src="<?php echo base_url(); ?>img/homepage/logo.png">
			<legend>Update password</legend>
		</center>
		<input type="hidden" value="<?php echo $uid; ?>" id="user_id" name="user_id">
		<input type="hidden" value="<?php echo $hash; ?>"id="hash_id" name="hash_id">
		<div class="control-group">
			<label class="control-label" for="current_pass" style="text-align:left;">Current password</label>
			<input type="password" id="current_pass" name="current_pass" value="<?php echo $pass; ?>" readonly="readonly">
		</div>
		<div class="control-group">
			<label class="control-label" for="input_pass" style="text-align:left;">New password</label>
			<input type="password" id="input_pass" name="input_pass">
		</div>
		<div class="control-group">
			<label class="control-label" for="retype_pass" style="text-align:left;">Retype password</label>
			<input type="password" id="retype_pass" name="retype_pass">
		</div>
		<div class="control-group">
			<button type="submit" class="btn pull-right udpate_prof">Update</button>
		</div>
<?php
		echo '<div class="alert alert-error"></div>';
?>	
<?php
		echo form_close();
?>
</div>
<?php
	} else	{
		echo '<span class="label label-warning">(Invalid Url) Your request has been expired</span>';
	}
?>
<script>
	$(window).resize(function(){
		$('.div_center').css({
			position:'absolute',
			left: ($(window).width() - $('.div_center').outerWidth())/2,
			top: ($(window).height() - $('.div_center').outerHeight())/2
		});
	});
	$(document).ready(function(){
		$('.div_center').css({
			position:'absolute',
			left: ($(window).width() - $('.div_center').outerWidth())/2,
			top: ($(window).height() - $('.div_center').outerHeight())/2
		});
	});
	// To initially run the function:
	$(window).resize();
		
	$('.udpate_prof').on('click',function(){
		$('#passform').ajaxForm({
				beforeSubmit: function(formData, jqForm, options){
					$('.udpate_prof').button('loading');
					var form = jqForm[0];
					if (!form.input_pass.value) {
						$('.alert-error').html('Invalid password');
						$('#input_pass').focus();
						$('.udpate_prof').button('reset');return false;
					}else if(!form.retype_pass.value)
					{
						$('.alert-error').html('Password did not match');
						$('#retype_pass').focus();
						$('.udpate_prof').button('reset');return false;
					}else if(form.input_pass.value != form.retype_pass.value)
					{
						$('.alert-error').html('Password did not match');
						$('#retype_pass').focus();
						$('.udpate_prof').button('reset');return false;
					}
				},
				success: function(html){
					
					if(html == 1)
					{
						window.location = '<?php echo base_url(); ?>';
					}else
					{
						$('.udpate_prof').button('reset');
						$('.alert-error').html('Invalid request');
					}
				}
		});
	});
	</script>