<?php
				$signin_form_attrib = array(
					'id' => 'signin_form',
					'name' => 'gsigh_in'
				);

				$password_attrib = array(
					'name' => 'password',
					'id' => 'lg_password',
					'class' => 'mp_sg_it lg_i'
				);
				
				echo form_open(base_url('signin'),$signin_form_attrib);
?>
				<div id="login">
					<div class="mp_sg_f">
						<div id="usernamecheck"></div>
						<label class="mp_sg_fl" for="email">Email: </label>
<?php
						$email_attrib = array(
							'name' => 'email',
							'id' => 'lg_email',
							'class' => 'mp_sg_it lg_i'
						);
						echo form_input($email_attrib);
?>
					</div> 
					<div class="mp_sg_f">
						<div id="passcheck"></div>
						<label class="mp_sg_fl" for="password">Password: </label>
						<?php echo form_password($password_attrib); ?>
					</div>
					<div class="mp_sg_fa mp_sg_sbmt">
						
					</div>
				</div>
<?php
			echo form_close();
?>
			<div id="forgotPass" style="">Forgot password?</div>
<?php
			$forgotPassForm_attrib = array(
				'id' => 'forgotPassForm',
				'name' => 'emailSendPass'
			);
			echo form_open(base_url('signin/emailSendPass'),$forgotPassForm_attrib);
?>
				<div id="forgotHide" style="display: none;">
					<hr />
					<div class="mp_sg_f">
						<label id="forgotLabel" class="mp_sg_fl">Email: </label>
<?php
						$email_attrib = array(
							'id' => 'em_pass',
							'name' => 'emailPass',
							'class' => 'mp_sg_it lg_i'
						);
						echo form_input($email_attrib);
?>
					</div>
					<div class="mp_sg_fa mp_sg_sbmt">
						<button id="forgot_button" name="forgot_button" class="btn_st btn_smt mp_sg_post">Reset Password</button>
					</div>
				</div>
<?php
			echo form_close();
?>
			
			<hr />
			<div id="errormessage" style="display: none; background: none repeat scroll 0% 0% gray; padding: 5px; color: #fff;"></div>
			<div id="sendingverify" style="display: none; padding: 5px;"></div>