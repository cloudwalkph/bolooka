	<form id="social_form" onsubmit="return false" style="margin-bottom: 0;">
		<input type="hidden" name="social_id" id="social_id" value="<?php echo $init; ?>"/>
		<input type="hidden" name="loginType" id="loginType" value="<?php echo $connect; ?>"/>
		<div class="control-group error_validate1">
			<div class="controls">
				<input type="text" id="social_first" name="social_first" placeholder="First name" value="<?php echo $name; ?>">
				<span class="help-inline validation_message1"></span>
			</div>
		</div>
		<div class="control-group error_validate2">
			
			<div class="controls">
				<input type="text" id="social_last" name="social_last" placeholder="Last name" value="<?php echo $last; ?>">
				<span class="help-inline validation_message2"></span>
			</div>
		</div>
		<div class="control-group error_validate3">
			
			<div class="controls">
				<input type="text" id="social_email" name="social_email" placeholder="Email" value="<?php echo $email; ?>">
				<span class="help-inline validation_message3"></span>
			</div>
		</div>
		<div class="control-group error_validate4">
			
			<div class="controls">
				<input type="password" id="social_pass" name="social_pass" placeholder="Password" onfocus="this.placeholder = ''">
				<span class="help-inline validation_message4"></span>
			</div>
		</div>
		<div class="control-group error_validate5">
		
			<div class="controls">
				<input type="password" id="social_confirm" name="social_confirm" placeholder="Re-type password" onfocus="this.placeholder = ''">
				<span class="help-inline validation_message5"></span>
			</div>
		</div>
		<div class="control-group" style="text-align: right;padding-top: 13px;padding-right: 15px;"> 
			<button id="social_form_button" type="submit" class="btn btn-primary" data-loading-text="loading...please wait">PROCEED</button>
		</div>
	</form>		
<script>

</script>