<?php
	$logged = $this->session->userdata('logged_in');
	if(isset($logged))
	{
		$uid = $this->session->userdata('uid');
		$this->db->where('uid', $uid);
		$query = $this->db->get('users');
		$row = $query->row_array();
	}
?>

<?php 
	/* load signtop.php */
	echo $this->load->view('signtop'); 
?>

					<div class="navbar navbar-fixed-top">

					  <div class="navbar-inner">
						<!-- Wrap the .navbar in .container to center it within the absolutely positioned parent. -->
						<div class="container">
						<!-- Responsive Navbar Part 1: Button for triggering responsive navbar (not covered in tutorial). Include responsive CSS to utilize. -->
							<a href="<?php echo base_url('home'); ?>" class="brand"><img src="img/homepage/logo.png"></a>
							<!-- Responsive Navbar Part 2: Place all navbar contents you want collapsed withing .navbar-collapse.collapse. -->
							<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
							  <span class="icon-bar"></span>
							  <span class="icon-bar"></span>
							  <span class="icon-bar"></span>
							</a>
							<div class="nav-collapse collapse pull-right" style="height: 0px;">
<?php
			if($logged)	{
?>
								<ul class="nav">
									<li class="navbar-text hidden-phone" style="font-family: 'ScalaSans Light'; font-size: 22px;"><span>Hi, <a class="navbar-link" href="<?php echo base_url('dashboard'); ?>"><?php echo $row['name']; ?></a></span></li>
									<li><a href="<?php echo base_url(); ?>logout" class="dropdown_button_out" style="font-family: 'ScalaSans Light'; font-size: 22px;"> Log out </a></li>
								</ul>
<?php
			}

			if(!$logged) {
?>
								<ul class="nav">
				<?php if(isset($isHome) != 'yes') { ?>
								<li><a data-toggle="collapse" data-parent="#signtop" href="#collapseThree" style="font-family: 'ScalaSans Light'; font-size: 22px; line-height: 30px;">Register</a></li>
				<?php } ?>
								  <li><a data-toggle="collapse" data-parent="#signtop" href="#collapseTwo" style="font-family: 'ScalaSans Light'; font-size: 22px; line-height: 30px;">Sign in</a></li>
								</ul>
<?php
			} else {
?>

<?php
			}
?>
							</div><!--/.nav-collapse -->
							</div>
					  </div><!-- /.navbar-inner -->
					</div><!-- /.navbar -->

