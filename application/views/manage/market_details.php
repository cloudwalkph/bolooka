<?php
	if(!isset($group))
	{
		$group = null;
	}
	
	$query = $this->db->query("SELECT * FROM `user_marketgroup` WHERE `marketgroup_id` ='".$group['marketgroup_id']."' AND `user_id` = '".$this->session->userdata('uid')."' ");
	$row_user = $query->row_array();
	
	if(isset($row_user['marketgroup_id']))
	{
		$this->db->where('id', $row_user['marketgroup_id']);
		$query1 = $this->db->get('marketgroup');
		$row_market = $query1->row_array();
	}
?>
<style>
/* RESPONSIVE */
@media (max-width: 767px)
{
	.mobile_view {
		padding: 0 8px;
	}
}	
</style>
<div class="container-fluid mobile_view">
<?php
	$form_marketgroups = array('class' => 'form-horizontal fileupload_form', 'id' => 'market_form');
	echo form_open_multipart('manage/add_marketgroup', $form_marketgroups);
?>
	<div class="row-fluid">
		<legend id="msy-web" style="font-family: Segoe UI Semibold; font-size: 18px; color: rgb(23, 23, 23);">Market Details:</legend>
	</div>
	<div>
		<div class="control-group">
			<label class="control-label" for="market_name">Marketplace Name:</label>
			<div class="controls">
				<input type="text" id="market_name" name="market_name" value="<?php echo isset($row_market['name']) ? $row_market['name'] : ''; ?>" <?php echo (isset($row_user['role']) && $row_user['role'] == 3) ? 'readonly' : ''; ?>>
				<div id="mn_err" class="help-inline"></div>
			</div>
		</div>
<?php
	if(isset($group)):
		if($query1->num_rows() > 0):
?>
			<div class="control-group">
				<label class="control-label">url: </label>
				<div class="controls">
					<div class="help-inline" style="font-style:italic;"><?php echo base_url($row_market['url']); ?></div>
				</div>
			</div>
<?php
		endif;
	endif;
?>
			<div class="control-group">
				<label class="control-label">Description: </label>
				<div class="controls">
					<textarea id="market_desc" rows="3" name="market_desc" <?php echo (isset($row_user['role']) && $row_user['role'] == 3) ? 'readonly' : ''; ?>><?php echo isset($row_market['description']) ? $row_market['description'] : ''; ?></textarea>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Logo:</label>
				<div class="controls">
					<div class="fileupload fileupload-new" data-provides="fileupload">
						<div class="fileupload-new thumbnail" style="max-width: 50px; max-height: 50px;">
							<img src="<?php echo isset($row_market['logo']) ? base_url().'uploads/'. str_replace('uploads/', '', $row_market['logo']) : 'http://www.placehold.it/50x50/EFEFEF/AAAAAA'; ?>" />
						</div>
<?php
			$role = array(1,2);
			if(isset($market_access) == 1 || (isset($row_user['role']) && in_array($row_user['role'], $role))):
?>						
						<div class="fileupload-preview fileupload-exists thumbnail" style="width: 50px; height: 50px;"></div>
						<div>
							<span class="btn btn-file fileinput-button"><span class="fileupload-new">Select image</span>
								<span class="fileupload-exists">Change</span>
								<input type="file" name="market_logo" accept="image/*">
							</span>
							<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
						</div>
<?php
			endif;
?>
					</div>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Background:</label>
				<div class="controls">
					<div class="fileupload fileupload-new" data-provides="fileupload">
						<div class="fileupload-new thumbnail" style="width: 50px; height: 50px;">
							<img src="<?php echo isset($row_market['background']) ? base_url().'uploads/'. str_replace('uploads/', '', $row_market['background']) : 'http://www.placehold.it/50x50/EFEFEF/AAAAAA'; ?>" />
						</div>
<?php
			$role = array(1,2);
			if(isset($market_access) == 1 || (isset($row_user['role']) && in_array($row_user['role'], $role))):
?>
						<div class="fileupload-preview fileupload-exists thumbnail" style="width: 50px; height: 50px;"></div>
						<div>
							<span class="btn btn-file fileinput-button">
								<span class="fileupload-new">Select image</span>
								<span class="fileupload-exists">Change</span>
								<input type="file" name="market_bg" accept="image/*">
							</span>
							<a href="#" class="btn fileupload-exists" data-dismiss="fileupload" style="float:left; margin-right: 4px">Remove</a>
						</div>
<?php
			endif;
?>
					</div>
				</div>
			</div>
			<div class="form-actions" style="background-color: transparent; border-top: 0px none;">
<?php
			$role = array(1, 2);
			if(isset($market_access) == 1 || (isset($row_user['role']) && in_array($row_user['role'], $role))):
?>
				<button type="submit" class="btn btn-primary button_add" name="save_edit" value="<?php echo isset($row_market['name']) ? 'edit' : 'save'; ?>">Save</button>
				<button type="button" class="btn btn-primary" onclick='history.back()'>Cancel</button>
<?php
			endif;
?>
			</div>
<?php 
	echo form_close();
?>
	</div>
</div>

<script>
$(function(){
		var options = {
			// target:        '.mn_err',   // target element(s) to be updated with server response 
			// beforeSubmit:  showRequest,  // pre-submit callback 
			success:       showResponse,  // post-submit callback 
	 
			// other available options: 
			// url: '<?php echo base_url('shop/search') ?>',         // override for form's 'action' attribute 
			// type:      type        // 'get' or 'post', override for form's 'method' attribute 
			// dataType:  null        // 'xml', 'script', or 'json' (expected server response type) 
			clearForm: true,        // clear all form fields after successful submit 
			resetForm: true,        // reset the form after successful submit 
	 
			// $.ajax options can be used here too, for example: 
			// timeout:   3000 
			data: { 'market_id': '<?php echo isset($row_market['id']) ? $row_market['id'] : '0'; ?>' }
		};
	
		$('#market_form').ajaxForm(options);

		// pre-submit callback 
		function showRequest(formData, jqForm, options) { 
			// var queryString = $.param(formData);
			// return true;
		}
		// post-submit callback 
		function showResponse(responseText, statusText, xhr, $form)  {
			if(responseText == 'err') {
				$('#mn_err').html('<span style="color: red">Marketname already exists</span>').fadeIn().delay(2000).fadeOut();
			} else {
				window.location = "<?php echo base_url(); ?>manage/market";
			}
		}
});
</script>

