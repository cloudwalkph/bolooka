<?php

?>
	<style>
	#alogin {
		width: 260px;
	}
	</style>
	<div id="alogin" class="login_container">

<?php
	$admin_form_attrib = array(
		'id' => 'aform',
		'name' => 'aform',
		'class' => 'well form-horizontal'
	);
	echo form_open_multipart('?bolookas', $admin_form_attrib)
?>
		<center>
			<img src="img/homepage/logo.png">
			<legend>Administrator Panel</legend>
		</center>
		<div class="control-group">
			<input type="text" id="inputUsername" name="inputUsername" placeholder="Username">
		</div>
		<div class="control-group">
			<input type="password" id="inputPassword" name="inputPassword" placeholder="Password">
		</div>
		<div class="control-group">
			<label class="checkbox">
				<input type="checkbox"> Remember me
			</label>
			<button id="login" type="submit" class="btn pull-right" data-loading-text="Loading..." autocomplete="off">Log In</button>
<!--			<button type="submit" class="btn pull-right">Log In</button> -->
		</div>
<?php
		if(isset($msg)) {
			echo '<div class="alert alert-error">'.$msg.'</div>';
		}
?>	
<?php
	echo form_close();
?>
</div>

<!-- modals -->
    <div class="modal hide fade">
		<div class="modal-body">
			<div class="progress">
				<div class="bar" style="width: 60%;"></div>
			</div>
		</div>
    </div>

<script>
$(function(){
	$(window).resize(function(){
		$('.login_container').css({
			position:'absolute',
			left: ($(window).width() - $('.login_container').outerWidth())/2,
			top: ($(window).height() - $('.login_container').outerHeight())/2
		});
	});
	// To initially run the function:
	$(window).resize();
	$('#aform').ajaxForm({
		beforeSubmit: function(a,b,c) {
			$('#login').button('loading');
		},
		success: function(html) {
			document.location.reload();
			$('#login').button('reset');
		}
	});
	
	
});
</script>