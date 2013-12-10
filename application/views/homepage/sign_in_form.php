<style>
input.mp_sg_it {
background: rgb(198,198,198);
background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CiAgPGxpbmVhckdyYWRpZW50IGlkPSJncmFkLXVjZ2ctZ2VuZXJhdGVkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjAlIiB5MT0iMCUiIHgyPSIwJSIgeTI9IjEwMCUiPgogICAgPHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iI2M2YzZjNiIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0b3AtY29sb3I9IiNlOGU4ZTgiIHN0b3Atb3BhY2l0eT0iMSIvPgogIDwvbGluZWFyR3JhZGllbnQ+CiAgPHJlY3QgeD0iMCIgeT0iMCIgd2lkdGg9IjEiIGhlaWdodD0iMSIgZmlsbD0idXJsKCNncmFkLXVjZ2ctZ2VuZXJhdGVkKSIgLz4KPC9zdmc+);
background: -moz-linear-gradient(top,  rgba(198,198,198,1) 0%, rgba(232,232,232,1) 100%);
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(198,198,198,1)), color-stop(100%,rgba(232,232,232,1)));
background: -webkit-linear-gradient(top,  rgba(198,198,198,1) 0%,rgba(232,232,232,1) 100%);
background: -o-linear-gradient(top,  rgba(198,198,198,1) 0%,rgba(232,232,232,1) 100%);
background: -ms-linear-gradient(top,  rgba(198,198,198,1) 0%,rgba(232,232,232,1) 100%);
background: linear-gradient(to bottom,  rgba(198,198,198,1) 0%,rgba(232,232,232,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#c6c6c6', endColorstr='#e8e8e8',GradientType=0 );

    border: 1px inset #B2B2B2;
    border-radius: 10px 10px 10px 10px;
    font-size: 16px;
    height: 26px;
    margin-bottom: 9px;
    padding: 4px 6px;
    width: 239px;
}
.mp_sg_it:valid {
    /* box-shadow: 0 0 1.5px 1px green; */
}
.mp_sg_f {
    text-align: right;
}
.mp_sg_fl {
    color: #737373;
    display: inline-block;
}
</style>
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