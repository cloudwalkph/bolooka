<style>
.footer_hover:hover {
	color: #08c;
}
.content-part .r-side
{
    background-color: #FFFFFF;
    box-shadow: 0 0 1px 1px #BEB8AF;
    margin-bottom: 10px;
}
.phone_li li{
	float: left;
	margin-bottom: 3px;
	margin-left: 3px;
}
.phone_li li a{
	padding: 20px 10px;
}
/* This for create site */
.input_margin input, .input_margin select {
	margin-left: 10px;
}

.left_menu {
	border-radius: 0;
	background-color: rgb(231,74,5);
}
.left_menu li > a {
    color: #FFFFFF;
    font-family: Segoe UI;
    font-size: 12px;
    text-align: right;
}
.left_menu .divider {
	background-color: #f0692f;
	border-bottom: none;
}
.navbar .nav li.dropdown.open > .dropdown-toggle
{
	background:#E74A05;
	color:#fff;
}
.navbar-on-top
{
	min-width:407px;
	margin-bottom:0;
}
.content-part
{
	margin-top: 40px;
}
body
{
	background-image: url('<?php echo base_url(); ?>img/noise.png');
}

/* responsive CSS */
    /* Large desktop */
    @media (min-width: 1200px) { ... }
     
    /* Portrait tablet to landscape and desktop */
    @media (min-width: 768px) and (max-width: 979px) {
		.content-part {
			margin-top: 0;
		}
	}
     
    /* Landscape phone to portrait tablet */
    @media (max-width: 767px) { ... }
     
    /* Landscape phones and down */
    @media (max-width: 480px) { ... }
/* */
</style>
<div id="fb-root"></div>

	<div class="container content-part">
		<div class="row">
			<div class="span2 affix">
				<?php echo $sidebar; ?>
			</div>
			<div class="span10 offset2 r-side">
				<?php echo $content; ?>
				<?php echo $this->load->view('dashboard/footer'); ?>
			</div>
		</div>
	</div>

	<div class="popupNotification">
		
	</div>