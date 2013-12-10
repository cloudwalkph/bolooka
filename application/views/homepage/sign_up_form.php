<style>
	#signup_form .control-group .controls input {
		box-shadow: none;
		border: 0;
		border-bottom: 1px solid #4F4F4F;
		border-radius: 0;
		background: #383838;
		width: 85%;
		color: #fff;
	}
	#social_form .control-group {
		margin: 0 auto;
	}
	
</style>
<?php
	$form_attrib = array(
			'id' => 'signup_form',
			'name' => 'signup_form',
			'style' => 'text-align:center;'
		);
	echo form_open('signup', $form_attrib); 
?>
	<div class="control-group">
		<div class="controls">
			<input type="text" id="emailmodal" name="email" placeholder="Email">
		</div>
	</div>
	<div class="control-group">
		<div class="controls">
			<input type="password" id="p1" name="p1" placeholder="Password">
		</div>
	</div>
	<div class="control-group error_validate">
		<div class="controls">
			<input type="text" id="first_name" name="first_name" placeholder="First name" onfocus="this.placeholder = ''">
			<span class="help-inline validation_message"></span>
		</div>
	</div>
	<div class="control-group error_validate">
		<div class="controls">
			<input type="text" id="last_name" name="last_name" placeholder="Last name" onfocus="this.placeholder = ''">
			<span class="help-inline validation_message"></span>
		</div>
	</div>
	<div class="control-group">
		<button id="form_submit_button" type="submit" class="btn btn-primary" style="float: right;">Proceed</button>
		<button style="margin-right:5px; float:right;" data-dismiss="modal" aria-hidden="true" type="submit" class="btn btn-primary" style="float: right;">Cancel</button>
	</div>
<?php
	echo form_close();
?>