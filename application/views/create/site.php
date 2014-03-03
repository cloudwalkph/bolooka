<?php
	$uid = $this->session->userdata('uid');
	
	$this->db->where('user_id', $uid);
	// $this->db->where('deleted', 0);
	$query = $this->db->get('websites');
	$website = $query->result();
?>
<style>
.save_form {
	background: #0083ef;
	color: white;
	border-radius: 0px;
	padding: 10px;
	border: 0;
	text-shadow: 0px 0px;
}
.create_site_nav {
	border-radius: 0px;
	padding: 10px;
	border: 0;
	text-shadow: 0px 0px;
	background: #0083ef;
	color: white;

}
.create_site_nav:hover {
	background: #DDD; 
	color: #08c;
}
#portfolio-filter li {
	float: left;
}
ul {
	list-style: none;
}
select {
	margin: 0;
}
.header_table tr th {
	color: #fff;
}
.header_table td, .header_table th{
	text-align: center;
}
.table_list tr td {
	text-align: center;
}
.form-horizontal input, .form-horizontal select {
	border-radius: 0;
}
.header_table {
	font-family: Segoe UI;
}
.classImage:hover {
	box-shadow: 0px 13px 15px -14px !important;
}
#num_width {
	width: 9%;
}

a.thumbnail:hover {
	border-color: #08C !important;
}
.table-condensed th, .table-condensed td {
	padding: 7px 5px;
	vertical-align: middle;
}
.current {
	background: #ddd;
}
	/* RESPONSIVE CSS */
	@media (max-width: 767px)
	{
		.mobile_view {
			padding: 0 8px;
		}
	}
</style>
<div class="container-fluid mobile_view">
	<ul class="nav nav-tabs" id="myTab" style="margin-top: 10px;">
		<li class="active"><a href="#site" data-toggle="tab">Site</a></li>
		<li><a href="#menu" data-toggle="tab">Menu</a></li>
		<li><a href="#layout" data-toggle="tab">Layout</a></li>
	</ul>
	<div class="row-fluid">
			<?php
				$form_array = array(
					'id'=>'create_web_form',
					'class'=>'form-horizontal fileupload_form'
				);
				echo form_open_multipart(base_url().'store', $form_array);
			?>
		<div class="tab-content">
			<div class="tab-pane active" id="site" style="overflow: hidden;">
					<h4>Site details:</h4>
				<div class="control-group">
					<label class="control-label" style="width: 200px;">Site URL: &nbsp;&nbsp;<span style="color: #999;"><?php echo base_url(); ?></span></label>
					<div class="controls input_margin">
			<?php 
				if($query->num_rows() == 0)
				{
			?>
						<input type="text" name="site_name" id="site_name" rel="tooltip" data-placement="top" data-original-title="URL of your website">
			<?php
				}else
				{
			?>
						<input type="text" name="site_name" id="site_name">
			<?php
				}
			?>
						<i style="font-size: 23px;color: red;">*</i>
						<span class="help-inline error_site"></span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label label_width" style="width: 200px;">Company name:</label>
					<div class="controls input_margin">
			<?php 
				if($query->num_rows() == 0)
				{
			?>
						<input type="text" name="com_name" id="com_name" rel="tooltip" data-placement="top" data-original-title="Name of your website">
			<?php
				}else
				{
			?>
						<input type="text" name="com_name" id="com_name">
			<?php
				}
			?>
						<i style="font-size: 23px;color: red;">*</i>
						<span class="help-inline error_com"></span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label label_width" for="business_type" style="width: 200px;">Type of Busines:</label>
					<div class="controls input_margin">
						<select name="business_type" id="business_type">
							<option value="0"> Select... </option>
							<?php 
								$query = $this->db->query('SELECT * FROM `business_categories`');
								foreach($query->result_array() as $row)
								{
							?>
							<option value="<?php echo $row['Category']; ?>"><?php echo $row['Description']; ?></option>
							<?php
								}
							?>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label label_width" for="marketgroup" style="width: 200px;">Affiliates:</label>
					<div class="controls input_margin">
					<?php
						$marketgroup_query = $this->db->get('marketgroup');
					?>
						<select name="marketgroup" id="marketgroup">
							<option value="0">Select...</option>
		<?php 
								foreach($marketgroup_query->result_array() as $marketgroup_result)
								{
									echo $marketgroup_result['id'];
		?>
								<option value="<?php echo $marketgroup_result['id']; ?>"><?php echo $marketgroup_result['name']; ?></option>
		<?php
								}
		?>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label label_width" for="upload_logo" style="width: 200px;">Logo:</label>
					<div class="controls input_margin">
						<div class="fileupload fileupload-new" data-provides="fileupload" style="margin-left: 31px;">
							<div class="fileupload-new thumbnail" style="max-width: 200px; max-height: 150px;"><img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image" /></div>
							<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
							<div>
								<span class="btn btn-file fileinput-button">
									<span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span>
									<input type="file" name="upload_logo" id="upload_logo" accept="image/*">
								</span>
								<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
								<span class="help-inline">Upload up to 2MB of image size.</span>
							</div>
						</div>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label label_width" style="width: 200px;">Background:</label>
					<div class="controls input_margin">
						<div class="fileupload fileupload-new" data-provides="fileupload" style="margin-left: 31px;">
							<div class="fileupload-new thumbnail" style="max-width: 200px; max-height: 150px;"><img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image" /></div>
							<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
							<div>
								<span class="btn btn-file fileinput-button">
									<span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span>
									<input type="file" name="upload_bg" id="upload_bg" accept="image/*" />
								</span>
								<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
								<span class="help-inline">Upload up to 2MB of image size.</span>
							</div>
						</div>
					</div>
				</div>
				<hr>
				<h4>Default background image:</h4>
				<div class="container-fluid">
					<div class="boundingBox" id="contentSlide">
						<?php 
							$queryImage = $this->db->query("SELECT * FROM backgrounds");
							$queryCategory = $this->db->query("SELECT DISTINCT `category` FROM backgrounds");
						?>
						<div style="margin: 0 50px;">
							<ul id="portfolio-filter" style="font-size: 13px;">
								<li><a href="#all" title="" style="color:#656565;font-size: 12px;font-family: Segoe UI;">All</a></li>
						<?php 
							foreach ($queryCategory->result_array() as $rowCategory)
							{
								$imgCategory = $rowCategory['category'];
								$strReplace = str_replace(' ','',$imgCategory);
								echo '<li>&nbsp;<i>|</i>&nbsp;<a href="#'.$strReplace.'" title="'.$imgCategory.'" rel="sample" style="color:#656565;font-size: 12px;font-family: Segoe UI;">'.$imgCategory.'</a></li>';
							}
						?>
							</ul>
						</div>
						<div style="clear: both;"></div>
						<input type="hidden" name="def_bg" id="img" value="">
							<div style="background-color: rgb(255, 255, 255); overflow-x: hidden; overflow-y: auto; width: 100%; border: 1px solid #ddd; height: 198px;margin: 0 auto;">	
								<ul id="portfolio-list" style="margin: 10px 10px;width: 100%;">
								<?php
									foreach ($queryImage->result_array() as $rowImage)
									{
										$imageSrc = $rowImage['image'];
										$imgId = $rowImage['id'];
										$imgName = $rowImage['name'];
										$imgCategory = $rowImage['category'];
										$strReplace = str_replace(' ','',$imgCategory);
								?>
									<li style="float:left;margin-right: 9px;" class="<?php echo $strReplace; ?>">
										<a class="click" style="display: block;">
											<div id="bgi">
												<img id="<?php echo $imgId; ?>" class="classImage" style="width: 163px;border: 1px solid #656565;" src="<?php echo base_url().'img/backgroundsThumbs/'.$imageSrc; ?>" alt="<?php echo $imageSrc; ?>">
											</div>
										</a>
										<p><?php echo $imgName; ?></p>
									</li>
								<?php } ?>
								</ul>
							</div>
						
					</div>
					<br/>
				</div>
			</div>

			<div class="tab-pane" id="menu">
				<h4>Manage your pages:</h4>
				<table class="table table-condensed header_table">
					<tr style="background: #9e9e9e;">
						<th>Sequence</th>
						<th>Menu Label</th>
						<th>Menu Type</th>
						<th class="hidden-phone">Social Share</th>
						<th>Publish</th>
						<!--<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>-->
					</tr>
		<?php
			for($i=1; $i<=7; $i++)
			{
				switch($i)
				{
					case 1:	$menuname = "Home"; $menutype = "article"; break;
					case 2:	$menuname = "About Us"; $menutype = "article"; break;
					case 3:	$menuname = "Photos"; $menutype = "photo"; break;
					case 4:	$menuname = "Services"; $menutype = "article"; break;
					case 5:	$menuname = "Blog"; $menutype = "blog"; break;
					case 6:	$menuname = "Catalogue"; $menutype = "catalogue"; break;
					case 7:	$menuname = "Contact Us"; $menutype = "contact_us"; break;
				}
		?>
					<tr>
						<td><input type="hidden" name="seq[]" value="<?php echo $i; ?>"><?php echo $i; ?></td>
						<td><input type="hidden" name="menu[]" value="<?php echo $menuname; ?>"/><?php echo $menuname; ?></td>
						<td>
							<select name="type[]" class="span7 menu_type">
								<option <?php echo $menutype == "article" ? "selected=selected" : ""; ?> value="article" >Article</option>
								<option <?php echo $menutype == "photo" ? "selected=selected" : ""; ?> value="photo">Photos</option>
								<option <?php echo $menutype == "blog" ? "selected=selected" : ""; ?> value="blog">Blog</option>
								<option <?php echo $menutype == "catalogue" ? "selected=selected" : ""; ?> value="catalogue">Catalogue</option>
								<option <?php echo $menutype == "contact_us" ? "selected=selected" : ""; ?> value="contact_us">Contact Us</option>
							</select>
						</td>
						<td class="box_share hidden-phone">
							<input style="<?php echo $menutype != 'article' ? 'visibility:hidden;' : ''; ?>" type="checkbox" name="social[]" value="<?php echo $i; ?>"/>
						</td>
						<td>
							<select name="status[]" class="span7">
								<option value="1" selected="selected">Published</option>
								<option value="0">Unpublished</option>
							</select>
						</td>
						<!--<td>
							<input type="hidden" class="count" value="<?php //echo $i; ?>">
							<a data-toggle="collapse" data-target="#<?php //echo 'menu'.$i; ?>" class="content1">
							  Edit
							</a>
						</td>-->
					</tr>
					<!--<tr>
						<td colspan="6" style="border: 0;">
							<div id="<?php //echo 'menu'.$i; ?>" class="collapse">
								<div class="accordion-inner accordion-inner<?php //echo $i; ?>">
									Loading...
								</div>
							</div>
						</td>
					</tr>-->
		<?php
			}
		?>
				</table>
			</div>

			<div class="tab-pane" id="layout">
				<input id="layout_val" type="hidden" name="layout" value="layout1" />
				<ul class="thumbnails" style="text-align: center;">
					<li class="span4">
						<p>Layout 1</p>
						<a class="thumbnail" alt="layout1" style="background-image: url('<?php echo base_url('img/defaultBack.png'); ?>');">
							<img src="<?php echo base_url('img/layout1_skin.png'); ?>" width="100%" alt="">
						</a>
					</li>
					<li class="span4">
						<p>Layout 2</p>
						<a class="thumbnail" alt="layout2" style="background-image: url('<?php echo base_url('img/defaultBack.png'); ?>');">
							<img src="<?php echo base_url('img/layout2_skin.png'); ?>" width="100%" alt="">
						</a>
					</li>
					<li class="span4">
						<p>Layout 3</p>
						<a class="thumbnail" alt="layout3" style="background-image: url('<?php echo base_url('img/defaultBack.png'); ?>');">
							<img src="<?php echo base_url('img/layout3_skin.png'); ?>" width="100%" alt="">
						</a>
					</li>
					<li class="span4" style="margin-left:0;">
						<p>Layout 4</p>
						<a class="thumbnail" alt="layout4" style="background-image: url('<?php echo base_url('img/defaultBack.png'); ?>');">
							<img src="<?php echo base_url('img/layout4_skin.png'); ?>" width="100%" alt="">
							
						</a>
					</li>
					<li class="span4">
						<p>Layout 5</p>
						<a class="thumbnail" alt="layout5" style="background-image: url('<?php echo base_url('img/defaultBack.png'); ?>');">
							<img src="<?php echo base_url('img/layout5_skin.png'); ?>" width="100%" alt="">
						</a>
						
					</li>
					<li class="span4">
						<p>Layout 6</p>
						<a class="thumbnail" alt="layout6" style="background-image: url('<?php echo base_url('img/defaultBack.png'); ?>');">
							<img src="<?php echo base_url('img/layout6_skin.png'); ?>" width="100%" alt="">
						</a>
					</li>
				</ul>	
			</div>

			<button class="save_form btn span2 pull-right" type="submit" name="create" value="save">Save</button>
			<a class="btn span2 pull-right create_site_nav next_nav" id="next_menu" href="#menu" data-toggle="tab">Next</a>
			<a class="btn span2 pull-right create_site_nav back_nav" style="display: none;" id="next_menu" href="#" data-toggle="tab">Back</a>

		</div>
<?php
		echo form_close();
?>

	</div>
</div>
<!-- Modal -->
<div id="savingModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
  <div class="modal-header">
    <h3 id="myModalLabel">Saving</h3>
  </div>
  <div class="modal-body">
    <p>Please Wait…</p>
  </div>
  <div class="modal-footer">
  </div>
</div>
<?php

?>
<script>
$(function(){
	// $(document.form).reset();
	$('#create_web_form').ajaxForm({
		url: '<?php echo base_url(); ?>store',
		type: 'post',
		beforeSubmit: function (a,b,c) {
			if($('#site_name').val() == 0 )
			{
				$('#site_name').parent().parent('.control-group').removeClass('success').addClass('error');
				$('#site_name').focus();
				$('#site_name').parent().children('.help-inline').html('Required');
				$(document).scrollTop(document.getElementById('site_name').offsetTop - 50);
				return false;
			} else {
				if($('#com_name').val() == 0 ) {
					$('#com_name').parent().parent('.control-group').removeClass('success').addClass('error');
					$('#com_name').focus();
					$('#com_name').parent().children('.help-inline').html('Required');
					$(document).scrollTop(document.getElementById('com_name').offsetTop - 50);
					return false;
				}
			}
			if($('.error_site').html() == 'Available!')
			{
				$('#savingModal').modal({
					keyboard: false
				}).modal('show');
			} else {
				$(document).scrollTop(document.getElementById('site_name').offsetTop - 50);
				return false;
			}
		},
		success: function(html) {
			var data = JSON.parse(html);
			window.location.href = "<?php echo base_url(); ?>preview?wid="+data.web_id;
		},
		clearForm: true,
		resetForm: true
	});

	/* tooltip text new user */
	// $('#site_name').on('focus',function(){
		// $(this).tooltip('show');
	// });
	// $('#com_name').on('focus',function(){
		// $(this).tooltip('show');
	// });
	
	$('.menu_type').on('change',function(){
		var value = $(this).val();
		if(value == 'article')
		{
			$(this).parent().parent().children('.box_share').children('input').css('visibility','visible');
		}else
		{
			$(this).parent().parent().children('.box_share').children('input').css('visibility','hidden');
		}
	});

	$('.content1').click(function(){
		var type = $(this).parent().parent().children().children('.menu_type').val();
		var num = $(this).parent().children('.count').val();
		$('.collapse').on('show', function () {
			$('.accordion-inner'+num).load('<?php echo base_url(); ?>dashboard/get_page_content',{'pagetype': type});
		});
	});
	
	$('.thumbnail').click(function(){
		$('.thumbnail').css('border-color','#fff');
		$('.thumbnail').css('box-shadow','none');
		$(this).css('border-color','#08C');
		$(this).css('box-shadow','1px 30px 10px -28px');
		$('#layout_val').val($(this).attr('alt'));
		
	});
	
	$('.classImage').click(function(){
		$('.classImage').css('box-shadow','none');
		$(this).css('box-shadow','0px 15px 15px -14px');
		var ID = $(this).attr('id');
		$('#img').val($(this).attr('alt'));
	});

	$('a[data-toggle="tab"]').on('show', function (e) {
		e.target // activated tab
		e.relatedTarget // previous tab
		if($(e.target).attr('href') == '#menu' || $(e.target).attr('href') == '#layout') {
			if($('#site_name').val() == '')
			{
				$('#site_name').parent().parent('.control-group').removeClass('success').addClass('error');
				$('#site_name').focus();
				$('#site_name').parent().children('.help-inline').html('Required');
				return false;
			} else if($('#com_name').val() == '') {
				$('#com_name').parent().parent('.control-group').removeClass('success').addClass('error');
				$('#com_name').focus();
				$('#com_name').parent().children('.help-inline').html('Required');
				return false;
			}
			if($('.error_site').html() != 'Available!' && $('.error_com').html() != 'Available!')
			{
				return false;
			}
		}
			if($(e.target).attr('href') == '#site') {
				$('.back_nav').attr('href', '#').hide();
				$('.next_nav').attr('href', '#menu');
			} else if($(e.target).attr('href') == '#menu') {
				$('.back_nav').attr('href', '#site').show();
				$('.next_nav').attr('href', '#layout').show();
			} else if($(e.target).attr('href') == '#layout') {
				$('.back_nav').attr('href', '#menu');
				$('.next_nav').attr('href', '#').hide();
			}
	});
	
//	function comCheck(checkCom)
// 	{
// 		if(checkCom.charAt('0') == ' ')
// 		{
// 			$('#com_name').val('');
// 			return false;
// 		}
// 		if(checkCom != 0)
// 		{
// 			var dataString = 'comName=' + checkCom;
// 			$.ajax({ 
// 				type: "POST",
//				url: 'test/comValidation",
// 				data: dataString,
// 				success: function (html) {
// 					if(html == 1)
// 					{
// 						$('#com_name').parent().parent('.control-group').removeClass('success').addClass('error');
// 						$('#com_name').parent().children('.help-inline').html('Name already exists!');
// 					}else if(html == 0)
// 					{
// 						$('#com_name').parent().parent('.control-group').removeClass('error').addClass('success');
// 						$('#com_name').parent().children('.help-inline').html('Available!');
// 					}
// 				} 
// 			});
// 		} else {
// 			$('#com_name').parent().parent('.control-group').removeClass('success').removeClass('error');
// 			$('#com_name').parent().children('.help-inline').html('This cannot be blank');		
// 		}
// 	}
// 	document.getElementById("com_name").addEventListener('input', function() { comCheck(this.value) }, false);
	
	function nameCheck(checkName)
	{
		var dataString = { 'siteName': checkName };
		if(checkName != 0) {
			$.ajax({ 
				type: "POST",
				url: "<?php echo base_url(); ?>test/check_site_exists",
				data: dataString,
				beforeSend: function() {
					$('#site_name').parent().children('.help-inline').html('Checking...');
				},
				success: function (html) {
					console.log(html);
					if(html == 1) {
						$('#site_name').parent().parent('.control-group').removeClass('success').addClass('error');
						$('#site_name').parent().children('.help-inline').html('Name already exists!');
					} else if(html == 0) {
						$('#site_name').parent().parent('.control-group').removeClass('error').addClass('success');
						$('#site_name').parent().children('.help-inline').html('Available!');
					}
				}
			});
		} else {
			$('#site_name').parent().parent('.control-group').removeClass('success').removeClass('error');
			$('#site_name').parent().children('.help-inline').html('This cannot be blank');
		}
	}
	document.getElementById("site_name").addEventListener('input', function() { nameCheck(this.value) }, false);
});
</script>