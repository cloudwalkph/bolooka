<div id="fb-root"></div>
		<!-- sign in accordion -->
		<div id="signtop" class="row-fluid accordion" style="position: relative;">
			<div class="accordion-group">
				<div id="collapseTwo" class="accordion-body collapse">
				  <div class="accordion-inner">

<?php
						$signin_form_attrib = array(
							'id' => 'signin_form',
							'name' => 'gsigh_in',
							'class' => 'form-inline'
						);
						echo form_open(base_url('signin'), $signin_form_attrib);
?>
							<input type="hidden" name="redirect_url" value="<?php echo $this->uri->uri_string(); ?>">
							<label class="control-label" style="font-family: 'Segoe UI';">Sign in</label>
							<div class="pull-right">
								<a data-toggle="collapse" href="#collapseTwo" data-parent="#signtop" style="text-decoration: none;">
									<img src="<?php echo base_url('img/close_button.png'); ?>">
								</a>
							</div>
							<input type="text" name="email" id="email" placeholder="Email address" class="email_sign_in span2" style="font-family: 'Segoe UI';"/>
							<input type="password" name="password" id="password" placeholder="Password" class="password_sign_in span2" style="font-family: 'Segoe UI';" />
							<button class="btn btn-primary" id="log_in" type="submit">Sign In</button>
							<a data-toggle="collapse" data-parent="#signtop" href="#collapseFour" style="color: #08c">Forgot password?</a>
							<?php if(isset($isHome) != 'yes') { ?>
							<a data-toggle="collapse" data-parent="#signtop" href="#collapseThree" style="color: #08c">New User?</a>
							<?php } ?>
<?php
						echo form_close();
?>
				  </div>
				</div>  
			</div>  
			<div class="accordion-group">
				<div id="collapseThree" class="accordion-body collapse">
				
					<!--register-->
					<div class="accordion-inner">
					<?php
						$signtop_form_attrib = array(
								'name' => 'signtopstep',
								'id' => 'signtopstep',
								'class' => 'form-inline container'
							);
						echo form_open(base_url('signup/first_sign_up'),$signtop_form_attrib);
					?>
							<div class="row-fluid">
								<div class="offset4 span4">
									<label class="control-label" style="font-size: 16px; margin-bottom: 0;">Sign up and create a website</label>
									<a data-toggle="collapse" href="#collapseThree" data-parent="#signtop" style="margin-top: 8px;"><img src="<?php echo base_url('img/close_button.png'); ?>"></a>
								</div>
							</div>
							<div class="row-fluid controls">
								<div class="offset4 span4">
									<input class="span12" id="email_signtop" type="text" name="email1" placeholder="Email Address" style="margin-top: 8px;" />
								</div>
							</div>
							<div class="row-fluid controls">
								<div class="offset4 span4">
									<div class="row-fluid">
										<div class="span12">
											<div class="row-fluid">
												<input class="span6" id="password_signtop" type="password" name="pass1" placeholder="Password" style="margin-top: 8px;margin-right: 6px;" />
												<input class="span6" id="retype_signtop" type="password" name="pass2" placeholder="Re-type Password" style="margin-top: 8px;" />
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row-fluid">
								<div class="offset4 span4">
									<button class="btn btn-small btn-primary span12 signtop_free_button" type="submit" style="margin-top: 8px;">GET FREE E-STORE NOW</button>
								</div>
							</div>
						<?php
							echo form_close();
						?>
					</div>
				</div>
			</div>
			<div class="accordion-group">
				<div id="collapseFour" class="accordion-body collapse">
					<div class="accordion-inner">
					<?php
						$forgot_form_attrib = array(
								'id' => 'forgot_form',
								'name' => 'forgot_in',
								'class' => 'form-inline',
								'style' => 'color: white; text-align: center;',
								'onsubmit' => 'return false'
							);
						echo form_open(base_url('signin/email_check'), $forgot_form_attrib);
					?>
						<label class="control-label" style="font-family: 'Segoe UI';">Email address</label>
						<input type="text" name="email" id="emailf" placeholder="Email address" class="span2" style="font-family: 'Segoe UI';" />
						<button class="btn btn-primary" id="forgot_send" type="button">Ok</button>&nbsp;&nbsp;
						<a data-toggle="collapse" href="#collapseFour" data-parent="#signtop"><img src="<?php echo base_url('img/close_button.png'); ?>"></a>
						<span class="help-inline validation_message forgot_error" style="color:red;"></span>
					</form>
						
					</div>
					<div class="container-fluid forgot_email_container" style="width: 34%;margin: 0 auto;text-align:left;box-shadow: 0 0 4px 1px #ddd inset;margin-bottom: 10px;padding: 10px;display:none;">
						<div class="pull-left">Email me a link to reset my password</div>
						<div class="pull-right">
							<button class="btn btn-primary go_to_pass" data-loading-text="Sending">Continue</button>
						</div>
						<div style="clear:both;"></div>
						<input type="text" id="email_catch" disabled>
					</div>
				</div>
			</div>
		</div> <!-- accordion -->
	
	<!--social create account-->
	<?php
		if(isset($_GET['init'])) {
			if($_GET['init'] != '')	{
				$data['init'] = $_GET['init'];
				$data['name'] = $_GET['name'];
				$data['last'] = $_GET['last'];
				$data['email'] = $_GET['email'];
				$data['connect'] = $_GET['connect'];
			}
		} else {
			$data['init'] = '';
			$data['name'] = '';
			$data['last'] = '';
			$data['email'] = '';
			$data['connect'] = '';
		}
	?>
	<div id="myModal_fb" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" style="width: 268px;left:60%;border-radius:0;background: #383838;">
		<div class="modal-header title_message" style="border-bottom:0;">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="padding: 2px 6px;background: #ddd;border-radius: 100px;">&times;</button>
			<p id="myModalLabel" style="color: #ddd;font-family: 'ScalaSans Light';margin-bottom: 0;font-size: 23px;">Create new account</p>
		</div>
		<div class="modal-body" style="text-align: center;">
		<?php echo $this->load->view('homepage/social_create_form_sign_top', $data); ?>
		</div>
	</div>
	
	<!--modal registration validation-->
	<div id="myModal_validation_error" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-body" style="background-color: #e34e0d;color: #fff;">
			<p id="error_sign_up" style="font-family: 'Segoe UI Semibold';"></p>
			<div class="pull-right">
				<button class="btn btn_color" data-dismiss="modal" aria-hidden="true">Close</button>
			</div>
		</div>
	</div>
