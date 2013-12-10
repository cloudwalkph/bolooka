<style>
.page {
	background-color: #FFFFFF;
}	
.page .group {
	cursor: move;
}
.accordion-heading.show_editor.span1 {
	margin: 0 0 0 10px;
}

/* RESPONSIVE */
@media (max-width: 767px)
{
	.accordion-heading.show_editor.span1 {
		margin: 0;
	}
	.page {
		margin-bottom: 23px;
		padding-bottom: 15px;
		text-align: center;
	}
}

div.editorcontents
{
    border: 2px solid transparent;
    overflow: hidden;
    padding-left: 15px;
    padding-right: 15px;
}

div.editorcontents:hover
{
	border-color: black;
	cursor: text;
}
</style>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/ckeditor/ckeditor.js"></script>

<?php
	$website_id = $rowWeb->id;
	$website_name = $rowWeb->site_name;
	if($website_name == '')
	{
		$website_name = $rowWeb->url;
	}
	
	$web_logo = $this->db->query('SELECT * FROM `logo` WHERE `website_id`="'.$website_id.'" LIMIT 1');
	if($web_logo->num_rows() > 0)
	{
		$img = $web_logo->row_array();
		$url_logo = $img['image'];
		if(file_exists($url_logo)){
			list($width, $height, $type, $attr) = getimagesize($url_logo);
			$mylogo = '<span style="padding-right: 7px;"><img style="height: 36px;" src="'.base_url().$url_logo.'" /></span>';
		}
	}

	$this->db->where('website_id', $wid);
	if($this->db->field_exists('page_seq', 'pages')) {
		$this->db->order_by('page_seq');
	} else {
		$this->db->order_by('order');
	}
	$queryPage = $this->db->get('pages');
?>
<?php
		if(isset($_GET['save']))
		{
			if($_GET['save'] == 'pages')
			{
?>
				<center><div class="confirmSave">Successfully Saved.</div></center>
<?php
			}
		}
?>
<?php
		if(isset($_GET['error']))
		{
			if($_GET['error'] == 'pages')
			{
?>
				<center id="edit-page-error"><div class="errorSave">Please leave at least one published page!</div></center>
<?php
			}
		}
?>
	<center id="del-album-success" style="display:none;"><div class="confirmSave">Successfully Deleted.</div></center>
	<center id="del-photo-success" style="display:none;"><div class="confirmSave">Successfully Deleted.</div></center>
	<center id="edit-photo-success" style="display:none;"><div class="confirmSave">Saved Successfully!</div></center>
	<center id="pri-photo-success" style="display:none;"><div class="confirmSave">Primary was set successfully.</div></center>
	<center id="del-album-error" style="display:none;"><div class="errorSave">Something went wrong deleting album. Try again later.</div></center>
	
	<div id="contentArea">
		<div id="page-content">
<?php 
		// $form_array = array('id'=>'page_form');
		// echo form_open_multipart('dashboard/update_page/pages', $form_array);
?>
			<input type="hidden" class="website_id" name="website_id" value="<?php echo $wid; ?>" />
<?php
			if($queryPage->num_rows() < 6) {
				echo'
					<div style="text-align: right; margin-bottom: 5px;">
						<span id="add_page" class="button1" style="display: inline-block;">Add Page</span>
					</div>
				';
			}
?>
			<div class="row-fluid">
				<div class="head" style="font-family: Segoe UI Semibold;">Manage your Pages: </div>
			</div>

			<div class="row-fluid hidden-phone" style="background-color: rgb(158,158,158); color: white;">
				<div class="span1" style="font-weight: bold; text-align: center;padding-top: 5px;">#</div>
				<div class="span3" style="font-weight: bold; text-align: center;padding-top: 5px;">Menu Label</div>
				<div class="span3" style="font-weight: bold; text-align: center;padding-top: 5px;">Menu Type</div>
				<div class="span1" style="font-weight: bold; text-align: center;padding-top: 5px;">Social Share</div>
				<div class="span2" style="font-weight: bold; text-align: center;padding-top: 5px;">Publish</div>
				<div class="span1" style="font-weight: bold; text-align: center;padding-top: 5px;">&nbsp;</div>
			</div>
		
			<div id="accordion">
<?php
				foreach($queryPage->result_array() as $row) {
					if($this->db->field_exists('page_seq', 'pages')) {
						$sequence = $row['page_seq'];
					} else {
						$sequence = $row['order'];
					}
?>					
					<div id="<?php echo $row['id']; ?>" class="accordion-group page">
						<div class="group row-fluid" style="padding-top: 10px;">
							<div class="seq span1 hidden-phone" style="text-align: center;">
								<span id="seq<?php echo $row['id']; ?>"><?php echo $sequence; ?></span>
							</div>
							<div class="menu span3">
								<span class="changename" id="menu<?php echo $row['id']; ?>" style="cursor:text;"><?php echo $row['name']; ?></span>
								<input style="display:none;" class="span12 input_change row-fluid" alt="<?php echo $row['id']; ?>" type="text" maxlength="22"/>
							</div>
							<div class="type span3" style="text-align: center;">
								<span class="visible-phone">(Menu Type)</span>
								<select class="row-fluid" id="type<?php echo $row['id']; ?>" name="type<?php echo $row['id']; ?>" alt="<?php echo $row['type']; ?>" onchange="menuoption(this, <?php echo $row['id']; ?>);">
									<option value="article" <?php echo $row['type']=='article' ? 'selected="selected"' : ''; ?>> Article </option>
									<option value="blog" <?php echo $row['type']=='blog' ? 'selected="selected"' : ''; ?>> Blog</option>
									<option value="contact_us" <?php echo $row['type']=='contact_us' ? 'selected="selected"' : ''; ?>> Contact </option>
									<option value="photo" <?php echo $row['type']=='photo' ? 'selected="selected"' : ''; ?>> Photos</option>
<?php
	
?>
									<option value="catalogue" <?php echo $row['type']=='catalogue' ? 'selected="selected"' : ''; ?>> Catalogue </option>
<?php

?>
									
								</select>
							</div>
							<div class="social span1" style="text-align: center;">
								<input class="row-fluid social_active" alt="<?php echo $row['id']; ?>" id="social<?php echo $row['id']; ?>" type="checkbox" name="social<?php echo $row['id']; ?>" <?php echo $row['social']=='on' || $row['social']=='1' ? 'checked="checked"' : ''; ?> style="<?php echo $row['type']=='article' ? 'visibility: visible' : 'visibility: hidden'; ?>"/>
								<span class="activated" style="font-style: italic;vertical-align: top; display:none;">Activated</span>
							</div>
							<div class="status span2" style="text-align: center;">
								<span class="visible-phone">(Publish)</span>
								<select name="status<?php echo $row['id']; ?>" class="row-fluid changestatus span10" style="<?php echo $row['status']=='0' ? 'color:red;' : ''; ?>">
									<option <?php echo $row['status']=='1' ? 'selected="selected"' : ''; ?> value="1"> Publish </option>
									<option <?php echo $row['status']=='0' ? 'selected="selected"' : ''; ?> value="0"> Unpublish </option>
								</select>
							</div>
							<div class="accordion-heading show_editor span2" alt="<?php echo $row['type']; ?>">
								<a class="row-fluid btn btn-small accordion-toggle span10 active_action_button" data-toggle="collapse" data-parent="#accordion" data-target="#slide<?php echo $row['id']; ?>" style="padding: 4px 10px;">
								Edit
								</a>
							</div>
						</div>
						<div id="slide<?php echo $row['id']; ?>" class="accordion-body collapse">
							<div class="accordion-inner" alt="<?php echo $row['type']; ?>">
							<?php
								// if($row->type != 'catalogue')
								// {
									$data['pid'] = $row['id'];
									$data['wid'] = $wid;
									$data['bgcolor'] = $design_data['bgcolor'];
									$data['boxcolor'] = $design_data['boxcolor'];
									echo $this->load->view('edit/pages/'.$row['type'], $data);
								// }
							?>
							</div>
						</div>
					</div>
<?php
				}
?>
			</div>
		<!--
			<div id="save-holder">
				<button class="button" id="saveButton" type="submit"><img src="../../img/floopy.png" style="vertical-align: middle; margin: 0px 4px;" /><span style="vertical-align: middle;">Save</button>
			</div>
		-->
<?php
			// echo form_close();
?>
		</div>
	</div>
	
	<?php
		# dialog boxes
	?>
	<!--
		<div id="menuoption" class="modal hide fade">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3>Change Menu Type:</h3>
			</div>
			<div class="modal-body">
				<p>Are you sure you want to change the menu type?</p>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal" >No</a>
				<a href="#" class="btn btn-primary" onclick="">Yes</a>
			</div>
		</div>
	-->
		
<div id="menu-option" title="Change Menu Type:" style="display: none;">
	Are you sure you want to change the menu type?
</div>

<!-- Modal -->
<div id="myModal_album" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header" style="background-color: #f26221;border-bottom:0;">
    <h4 id="myModalLabel_pages" style="color:#fff;margin: 5px 0;font-family: 'ScalaSans Light';opacity: 0.7;">Are you sure you want to delete this photo?</h4>
  </div>
	<input type="hidden" name="inputModal_album" id="inputModal_album" />
	<input type="hidden" name="image_ids" id="image_ids" />
	<input type="hidden" name="image_filename" id="image_filename" />
  <div class="modal-footer" style="background-color: #e34e0d;color: #fff;border-top:0;box-shadow: none;border-radius:0;">
    <span class="yes_album"><button class="btn btn_color modal_photo_del" onclick="deletephoto()" data-dismiss="modal" aria-hidden="true">YES</button></span>
    <button class="btn btn_color pages_no" data-dismiss="modal" aria-hidden="true" onclick="reset_select(this.id)">NO</button>
  </div>
</div>
<div id="myModal_page" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header" style="background-color: #f26221;border-bottom:0;">
    <h4 id="myModalLabel_pages" style="color:#fff;margin: 5px 0;font-family: 'ScalaSans Light';opacity: 0.7;">Are you sure you want to change the menu type?</h4>
  </div>
  <div class="modal-footer" style="background-color: #e34e0d;color: #fff;border-top:0;box-shadow: none;border-radius:0;">
    <button class="btn btn_color pages_change" onclick="save_menuoption(this.id, this)">YES</button>
    <button class="btn btn_color pages_no" data-dismiss="modal" aria-hidden="true" onclick="reset_select(this.id)">NO</button>
  </div>
</div>	
<style>
	.cke_contents iframe body.cke_show_borders {
		background: #000 !important;
	}
</style>	
	<script>
		
		// $('.page').delegate('.accordion-toggle','click',function(){
			// if($(this).hasClass('btn-primary') == true) {
				// $(this).removeClass('btn-primary');
			// } else {
				// $('.accordion-toggle').removeClass('btn-primary');
				// $(this).addClass('btn-primary');
			// }
		// });
		function deletealbum() {
			var albumid = $("input[name='del_album_page']").val();
			var parentpic = $("input[name='parentpic_album']").val();
			var dataalbum34 = 'pid='+parentpic+'&wid=<?php echo $wid; ?>&albumid='+albumid;
			$.ajax({
				type:'post',
				url:'<?php echo base_url(); ?>test/deletealbum',
				data:dataalbum34,
				success: function(html)
				{
					if(html == 0){
						$('#'+parentpic).find('.gallery-content').html('<p style="text-align: center;">YOU DON\'T HAVE ALBUMS YET.</p>');
					}else{
						$('#'+parentpic).find('#album-hold'+albumid).hide();
					}					
				}
			});
		}

		function deletephoto() {
			var image_filename = $("input[name='image_filename']").val();
			var image_ids = $("input[name='image_ids']").val();
			$.ajax({
				type: 'post',
				url: '<?php echo base_url(); ?>test/deleteAlbumPhoto',
				data: { 'image_ids': image_ids, 'image_filename': image_filename },
				success: function(html){
					$('#image_'+image_ids).parents('.template-download').remove();
				}
			});
			
		}
		function menuoption(elem, theid) {
			var oldvalue = $('#type'+theid).attr('alt'),
				type = $('#type'+theid).val();
				
			$('.pages_change').attr('id',theid);
			$('.pages_change').attr('alt',type);
			$('.pages_no').attr('id',theid);
			
			/* bootstrap modal */
			$('#myModal_page').modal('show');
		}
		
		function reset_select(pageid)
		{
			var oldvalue = $('#type'+pageid).attr('alt');
			$('#type'+pageid).val(oldvalue);
		}
		
		function save_menuoption(pageid,elem)
		{
			var type = $(elem).attr('alt');
			var dataString = {'menu':'type','pageid':pageid,'type':type}
			$.ajax({
				type:"POST",
				url:"<?php echo base_url(); ?>dashboard/update_page/menu",
				data:dataString,
				success: function(html){
					window.location = '<?php echo current_url().'?wid='.$wid; ?>';
				}
			});
		}
			
		function show_editor(pageid,type) {
			$('#slide'+pageid).load('<?php echo base_url(); ?>dashboard/get_page_content',{'pagetype':type,'pid':pageid,'wid':<?php echo $wid; ?>});
		}
		
		function init_pages() {
			var accordion_options = {
					// fillSpace: true,
					header: ".page .show_editor",
					collapsible: true,
					active: false,
					icons: false,
					autoHeight: false,
					changestart: function(event, ui) {
						var pageid = ui.newHeader.parent().attr('id'),
							type = $('#type'+pageid).val();
						ui.newHeader.parent().css('background-color','#EEEEEE');
						ui.newContent.load('<?php echo base_url(); ?>dashboard/get_page_content',{'pagetype':type,'pid':pageid,'wid':<?php echo $wid; ?>}).hide();
					},
					change: function(event,ui)
					{
						ui.oldHeader.parent().css('background-color','transparent');
						ui.oldContent.html('');
					}
				},
				sortable_options = {
					axis: "y",
					handle: '.group',
					stop: function( event, ui ) {
						// IE doesn't register the blur when sorting
						// so trigger focusout handlers to remove .ui-state-focus
						ui.item.children( ".group" ).triggerHandler( "focusout" );
					},
					cancel: "select",
					// revert: true,
					update: function() {
						// $('#accordion .page').each(function(i,el) {
							// el.id = 'page'+i;
						// });
						var order = new Array(),
							dataString = null;
						$('#accordion div.seq span').each(function(i,el) {
							i=i+1;
							el.innerHTML = i;
							order.push($(this).parents('.page').attr('id'));
						});
						dataString = {'order':order};
						$.ajax({
							type:"POST",
							url:"<?php echo base_url(); ?>dashboard/update_page/order",
							data:dataString,
							success: function(html){
							}
						});
					},
					// placeholder: "ui-state-highlight"
				};
			$( "#accordion" )
				// .accordion(accordion_options)
				.sortable(sortable_options);
		}
		
		$(function() {
			init_pages();

			$('.collapse')
				.on('show', function (e) {
					var pageid = $(this).parent().attr('id'),
						type = $('#type'+pageid).val();
					// /* $(this).load('<?php echo base_url(); ?>dashboard/get_page_content',{'pagetype':type,'pid':pageid,'wid':<?php echo $wid; ?>}); */
					// $('#'+pageid).css('background-color','rgb(238,238,238)');
					var page_type = $(this).children('.accordion-inner').attr('alt');
					if(page_type == 'article')
					{
						$(this).children('.accordion-inner').css('background-color','rgb(238,238,238)');
					}
					$(this).parents('.page').find('.asdad').addClass('btn-primary');
				})
				.on('hide', function() {
					var pageid = $(this).parent().attr('id');
					$('#'+pageid).css('background-color','rgb(255,255,255)')
				})
				.on('shown', function (e) {

				})
				.on('hidden', function () {
					// $(this).parents('.page').find('.asdad').removeClass('btn-primary');
				})
		});
		
		
		/* Dynamic Menu Name Update */
		// $('.changename').bind('click',function(){
			// var name = $(this).html();
			// $(this).html('<input class="nameinput" type="input" maxlength="20" name="" value="'+name+'" />');
			// $('.nameinput').focus();
			// /* $(this).unbind('click'); */
		// });
		// $('.nameinput').live('blur',function(){
			// var name = $(this).val(),
				// pageid = $(this).parents('.page').attr('id'),
				// dataString = {'menu':'name','pageid':pageid,'name':name};
			// $.ajax({
				// type:"POST",
				// url:"<?php echo base_url(); ?>dashboard/update_page/menu",
				// data:dataString,
				// success: function(html){
				// }
			// });
			// $(this).parent().attr('class','changename').html(name);
		// });
		
		/* Dynamic Status Update */
		$('.page').delegate('.changestatus','change',function(){
			var status = $(this).val(),
				pageid = $(this).parents('.page').attr('id'),
				dataString = {'pageid':pageid,'status':status};
			$.ajax({
				type:"POST",
				url:"<?php echo base_url(); ?>dashboard/update_page/status",
				data:dataString,
				success: function(html){
				}
			});
		});
		
		$('#add_page').click(function() {
			var dataString = null;
			$.ajax({
				type:"POST",
				url:"<?php echo base_url(); ?>dashboard/add_page",
				data:dataString,
				success: function(html){
					var num_pages = 0;
					$('#accordion').append(html)
						.accordion('destroy')
						.children('.group').each(function(e,el){
							if(e >= 8){
								$('#add_page').parent().html('');
							}
						});
					init_pages();
				}
			});
		});

		$('.page').delegate('.social_active', 'click', function(){
			var pageId = $(this).attr('alt'),
				dataString = { pid: pageId },
				eto = this;
			if(eto.checked == true)
			{
				$.ajax({
					type:"POST",
					url:"<?php echo base_url(); ?>dashboard/onSocialActive/active",
					data:dataString,
					success: function(html){
						$(eto).parent().children('.activated').text('Activated').show().fadeOut(1000);
					}
				});	
			}
			else
			{
				$.ajax({
					type:"POST",
					url:"<?php echo base_url(); ?>dashboard/onSocialActive/deactivated",
					data:dataString,
					success: function(html){
						$(eto).parent().children('.activated').text('Deactivated').show().fadeOut(1000);
					}
				});	
			}
		});
		
		$('.page').delegate('#contact_us_submit','click',function(){
			var page_id = $(this).parents('.page').attr('id');
			$('#contact_us_form').ajaxForm({
				data: {'page_id':page_id,'type':'contact_us'},
				success: function(html){
				}
			}).submit();
		});
		/* Menu Name dynamic edit */
		$('.changename').on('click',function(){
			$(this).parent().children().show().val($(this).html());
			$(this).hide();
			$(this).parent().children('.input_change').focus();
		});
		$('.input_change').on('click',function(){
			$(this).focus();
		});
		$('.input_change').on('blur',function(e){
			var event = $(this),
				oldname = $(event).parent().children('.changename').html(),
				name = $(this).val(),
				pageid = $(this).attr('alt'),
				dataString = 'menu=name&pageid='+pageid+'&name='+name;
			if(name.trim() == ''){
				$(this).parent().children('.input_change').focus();
			}else{
				$(event).parent().children('.changename').html($(this).val());
				$.ajax({
					type:"POST",
					url:"<?php echo base_url(); ?>dashboard/update_page/menu",
					data:dataString,
					success: function(html){
						$(event).hide();
						$(event).parent().children('.changename').html(name);
						$(event).parent().children('.changename').show();
					}
				});
			}
		});
		
		$('.input_change').on('keypress',function(e){
			var event = $(this),
				name = $(this).val(),
				pageid = $(this).attr('alt'),
				dataString = 'menu=name&pageid='+pageid+'&name='+name;
			if(e.keyCode == 13 && !e.shiftKey)
			{	
				if(name.trim() == ''){
					$(this).parent().children('.input_change').focus();
				}else{
					$(event).parent().children('.changename').html($(this).val());
					$.ajax({
						type:"POST",
						url:"<?php echo base_url(); ?>dashboard/update_page/menu",
						data:dataString,
						success: function(html){
							$(event).hide();
							$(event).parent().children('.changename').html(name);
							$(event).parent().children('.changename').show();
						}
					});
				}
			}
		});

	$('.page').delegate('.b-to-album','click',function(){
		var parent = $(this).parents('.page');
		var pid = $(this).parents('.page').attr('id');
		
		parent.find('.gallery-content').empty();
		parent.find('.files').empty();
		parent.find('.gallery-content').html('<p style="text-align: center;"><img src="<?php echo base_url(); ?>img/ajax-loader.gif" /></p>');
		parent.find("#multi-album").collapse('hide');
		parent.find('.edit-album-name').hide();
		parent.find("#uploadalbum").collapse('show');
		/* not needed 
			var dataalbum5 = 'wid=<?php echo $wid; ?>&pid='+pid;
			$.ajax({
				type:'post',
				url:'../test/unsetalbumsession',
				data:dataalbum5,
				success: function(html)
				{
					
				}
			});
		*/
		var dataalbum3 = 'wid=<?php echo $wid; ?>&pid='+pid;
		$.ajax({
			type:'post',
			url:'../test/viewalbum',
			data:dataalbum3,
			success: function(html)
			{
				parent.find('.b-to-album').hide();
				parent.find('.c-album').show();
				parent.find('.gallery-content').empty();
				parent.find('.gallery-content').html(html);
			}
		});
	});
	$('.page').delegate('.cr-album','click',function(){
		var parent = $(this).parents('.page'),
			pid = $(this).parents('.page').attr('id'),
			albumname = parent.find('#inputAlbum').val(),
			albumdesc = parent.find('#inputdes').val(),
			dataalbum = {
				'wid': '<?php echo $wid; ?>',
				'pid': pid,
				'albumname': albumname,
				'albumdesc': albumdesc
			}
		if(albumname.trim() != '')
		{
			$.ajax({
				type:'post',
				url:'<?php echo base_url(); ?>test/create_new_album2',
				data: dataalbum,
				beforeSend: function() {
					parent.find("#createalbum"+pid).collapse('hide');
					// parent.find('#inputAlbum').val('');
					// parent.find('#inputdes').val('');
					// parent.find('.files').empty();
					parent.find('.edit-album-name').show();
					// parent.find('#nameAlbum').val(albumname);
					// parent.find('#descAlbum').val(albumdes);
					// parent.find(".crlink").css('visibility','visible');
					// parent.find('.yalbum').html('Your Album:');
				},
				success: function(html)
				{
					parent.find("#multi-album").collapse('show');
					parent.find('.b-to-album').show();
					// parent.find('.album-titles').html(albumname);
					// parent.find('.album-description').html(albumdes);
					// parent.find('#old_alname_text').val(albumname);
					// parent.find('#old_aldes_text').val(albumdes);
					// parent.find('.album-ids').html(html);
					// parent.find('.c-album').hide();
					// parent.find('#idAlbum').val(html);
					$(parent).find('.gallery-upload').html(html);
					// $(parent).find('.file-list').attr('id', 'file-list_'+albumid);
				}
			});
		}
	});
	$('.page').delegate('.ca-album','click',function(){
		var parent = $(this).parents('.page');
		var pid = $(this).parents('.page').attr('id');
		parent.find('#inputAlbum').val('');
		parent.find('#inputdes').val('');
		parent.find("#createalbum"+pid).collapse('hide');
		parent.find("#uploadalbum").collapse('show');
		parent.find(".crlink").css('visibility','visible');
		parent.find('.yalbum').html('Your Album:');
	});
	
	$('.page').delegate('.save-album','click',function(e) {
		var parent = $(this).parents('.page');
		var pid = $(this).parents('.page').attr('id');
		var albumid = parent.find('#idAlbum').val();
		var album_name = parent.find('#old_alname_text').val();
		var albmdesc = parent.find('#old_aldes_text').val();
		var datass = 'album_name='+album_name+'&albumid='+albumid+'&albmdesc='+albmdesc;
		parent.find('.save-album').button('loading');
		$.ajax({
			type: 'post',
			url: '<?php echo base_url(); ?>test/upalbumname',
			data: datass,
			success: function(html){
				parent.find('.save-album').button('reset');
			}
		});
		
		e.stopPropagation;
		e.preventDefault;
	});
	
	function isNumber(el) {
		var price_value = el.val();
		var remove_commas = price_value.replace(/,/g, '');
		var remove_period = remove_commas.replace(/\./g, "");
		if(isNaN(remove_period))
		{
			return false;
		}
		return true;
	}
	$('.page').delegate('.del_product','click',function(e) {
		var parent = $(this).parents('.page');
		var pid = $(this).parents('.page').attr('id');
		var id = $(this).parents('.item_prod').attr('id');
		parent.find('#deleteId').val(id);
		parent.find('#delete_product').modal('show');
	});
	function delete_prod(x){
		var parent = $(x).parents('.page');
		var pid = $(x).parents('.page').attr('id');
		var id = parent.find('#deleteId').val();
		var dataString = 'prod_id='+id;
		$.ajax({
			type: "POST",
			url: '<?php echo base_url(); ?>dashboard/delprod',
			data: dataString,
			success: function(data) {
				parent.find('#delete_product').modal('hide');
				var type = 'catalogue';
				var order = parent.find('#seq'+pid).val();
				var dataString = 'pagetype='+type+'&pid='+pid+'&wid='+<?php echo $wid; ?>+'&order='+order;
				$.ajax({
					type: "POST",
					url: '<?php echo base_url(); ?>dashboard/get_page_content',
					data: dataString,
					success: function(data) {
						parent.find('#catalogue').html(data);
					}
				});
			}
		});
	}
	$('.page').delegate('.image_button','click',function(e) {
		var parent = $(this).parents('.page');
		var pid = $(this).parents('.page').attr('id');
		var insertid = parent.find('#insertid').val();
		var eto = $(this);
		$(eto).button('loading');
		var image_name = $(this).attr('alt');
		var dataString = 'prod_id='+insertid+'&primary='+image_name;
		
		$.ajax({
			type: "POST",
			url: '<?php echo base_url(); ?>dashboard/setPrimaryProd',
			data: dataString,
			success: function(html) {
				$(eto).button('reset');
			}
		});
		e.stopImmediatePropagation();
	});
	
	$('.page').delegate('.delete_img','click',function(e) {
		var parent = $(this).parents('.page');
		var pid = $(this).parents('.page').attr('id');
		var eto = $(this);
		var image_id = $(this).parent().children('.prod_thumb').attr('id');
		var dataString = 'image_id='+image_id;
		
		$.ajax({
			type: "POST",
			url: '<?php echo base_url(); ?>dashboard/del_image_prod',
			data: dataString,
			success: function(html) {
				$(eto).parent().fadeOut(1000).remove();
			}
		});
		e.stopImmediatePropagation();
	});
	
	$('.page').delegate('.delete_img_new','click',function(e) {
		var file_name = $(this).parent().children('.image_button').attr('alt');
		var dataString = 'image_name='+file_name;
		var eto = $(this);
		$.ajax({
			type: "POST",
			url: '<?php echo base_url(); ?>dashboard/del_new_upload_prod',
			data: dataString,
			success: function(html) {
				// alert(html)
				$(eto).parent().fadeOut(1000).remove();
			}
		});
	});
	function select_prod(x) 
	{
		var val = $(x).val();
		var parent = $(x).parents('.page');
		var pid = $(x).parents('.page').attr('id');
		var type = 'catalogue';
		var order = $('#seq'+pid).val();
		parent.find('#catalogue').html('<div class="progress progress-striped active"><div class="bar" style="width: 100%;"></div></div>');
		var dataString = 'pagetype='+type+'&pid='+pid+'&wid='+<?php echo $wid; ?>+'&order='+order+'&search='+encodeURIComponent(val);
		$.ajax({
			type: "POST",
			url: '<?php echo base_url(); ?>dashboard/load_categ',
			data: dataString,
			success: function(data) {
				parent.find('#catalogue').html(data);
				var catalogH = $('#item_prod_list').outerHeight();
				$('html, body').animate({ scrollTop: catalogH });
			}
		});
	}
	
	/* search button */
	function search_prod(x)
	{
		
		var item = $(x).parent('.input-append').find('#search_type_prod').val();
		var parent = $(x).parents('.page');
		var pid = $(x).parents('.page').attr('id');
		var type = 'catalogue';
		var dataString = 'pagetype='+type+'&pid='+pid+'&wid=<?php echo $wid; ?>&item='+item;
		
		if(item == '' || item == ' ')
		{
			$(x).parent('.input-append').find('#search_type_prod').val('');
			$(x).parent('.input-append').find('#search_type_prod').focus();
			return false;
		}else
		{
			parent.find('#catalogue').html('<div class="progress progress-striped active"><div class="bar" style="width: 100%;"></div></div>');
			$.ajax({
				type: "POST",
				url: '<?php echo base_url(); ?>dashboard/load_categ/input_search',
				data: dataString,
				success: function(data) {
					parent.find('#catalogue').html(data);
					var catalogH = $('#item_prod_list').outerHeight();
					$('html, body').animate({ scrollTop: catalogH });
				}
			});
		}
		
	}
	
	/* search on keypress */
	function keysearch(e)
	{
		if (window.event.keyCode == 13)
        {
			var item = $(e).val();
			var parent = $(e).parents('.page');
			var pid = $(e).parents('.page').attr('id');
			var type = 'catalogue';
			var dataString = 'pagetype='+type+'&pid='+pid+'&wid=<?php echo $wid; ?>&item='+item;
			
			if(item == '' || item == ' ')
			{
				$(e).val('');
				$(e).focus();
				return false;
			}else
			{
				parent.find('#catalogue').html('<div class="progress progress-striped active"><div class="bar" style="width: 100%;"></div></div>');
				$.ajax({
					type: "POST",
					url: '<?php echo base_url(); ?>dashboard/load_categ/input_search',
					data: dataString,
					success: function(data) {
						parent.find('#catalogue').html(data);
						var catalogH = $('#item_prod_list');
						var scrollTo = $('.item_prod:last-child');
						
						if($(window).width() > 767)  /* 767px visible for window desktop */
						{
							/* scroll down the window */
							$('body').animate({
								scrollTop: scrollTo.offset().top - catalogH.offset().top + catalogH.scrollTop()
							});
						}
					}
				});
			}
		}
	}

	
	$('.page').delegate('.pubunpub','change',function(e) {
		var parent = $(this).parents('.page');
		var pid = $(this).parents('.page').attr('id');
		var prod_id = $(this).parents('.item_prod').attr('id'),
			pub_val = $(this).val(),
			dataString = 'id='+prod_id+'&status='+pub_val;
			
		$.ajax({
			type: "POST",
			url: '<?php echo base_url(); ?>dashboard/publish_unpublish',
			data: dataString,
			success: function(data) {
				if(data==1) {
				} else {
				}
			}
		});	
	});
	
		/* pagination */
	$('.page').delegate('.prev_page', 'click', function(e) {
		var pid = $(this).parents('.page').attr('id');
		var eto = $(this);
		var filter_select = $(eto).parents('.pagination-centered').find('.pagination_filter_select').val();
		
		var p_num = $(this).parent('ul').find('.current_page').children().html();
		var previous = p_num - 1;
		var dataString = 'pid='+pid+'&wid=<?php echo $wid; ?>&p_num='+previous+'&category='+filter_select;
		
		/* enable next button */
		$(eto).parent('ul').find('.next_page').removeClass('disabled');
		
		/* if previous button reach the limit */
		if(previous == 0)
		{
			$(eto).addClass('disabled');
			return false;
		}
		
		$.ajax({ 
			type: "POST",
			url: "<?php echo base_url(); ?>test/prodpagination",
			data: dataString,
			success: function (html) {
				$('#item_prod_list tbody').html(html).fadeOut(200).fadeIn(500);
				$(eto).parent('ul').find('.current_page').children().html(previous);
				/* show popover */
				$('.prod_imageview').popover({
					placement: 'top',
					container: '.page',
					trigger:'hover',
					html: true,
					content: function(e){
						var imageSrc = $(this).attr('alt');
						$(this).parent().find('.product_preview').html('<img src="'+imageSrc+'">');
						return $(this).parent().find('.product_preview').html();
					}
				});
			}
			
		});
	});
	$('.page').delegate('.next_page','click',function(e) {
		var pid = $(this).parents('.page').attr('id');
		var eto = $(this);
		var filter_select = $(eto).parents('.pagination-centered').find('.pagination_filter_select').val();
		var p_num = $(this).parent('ul').find('.current_page').children().html();
		var next = Number(p_num) + 1;
		var total_pages = $('#total_pages'+pid).val();
		
		var dataString = 'pid='+pid+'&wid=<?php echo $wid; ?>&p_num='+next+'&category='+filter_select;
		
		/* enable previous button */
		$(eto).parent('ul').find('.prev_page').removeClass('disabled');
		
		/* if next button reach the limit */
		if(next > total_pages)
		{
			$(eto).addClass('disabled');
			return false;
		}
		
		$.ajax({ 
			type: "POST",
			url: "<?php echo base_url(); ?>test/prodpagination",
			data: dataString,
			success: function (html) {

				$('#item_prod_list tbody').html(html).fadeOut(200).fadeIn(500);
				$(eto).parent('ul').find('.current_page').children().html(next);
				/* show popover */
				$('.prod_imageview').popover({
					placement: 'top',
					container: '.page',
					trigger:'hover',
					html: true,
					content: function(e){
						var imageSrc = $(this).attr('alt');
						$(this).parent().find('.product_preview').html('<img src="'+imageSrc+'">');
						return $(this).parent().find('.product_preview').html();
					}
				});
			}
		});
		e.stopImmediatePropagation();
	});
	$('.page').delegate('.page_number', 'change', function(e){
		var pid = $(this).parents('.page').attr('id');
		/* enable next/previous button */
		$('.next_page').removeClass('disabled');
		$('.prev_page').removeClass('disabled');
		
		var eto = $(this);
		var p_num = $(eto).val();
		var dataString = 'pid='+pid+'&wid=<?php echo $wid; ?>&p_num='+p_num;
		
		if(p_num == 0)
		{
			return false;
		}
		
		$.ajax({ 
			type: "POST",
			url: "<?php echo base_url(); ?>test/prodpagination",
			data: dataString,
			success: function (html) {
				$('#item_prod_list tbody').hide().html(html).fadeIn(300);
				$(eto).parents('ul').find('.current_page').children().html(p_num);
				/* show popover */
				$('a.prod_imageview').popover({
					placement: 'top',
					container: '.page',
					trigger:'hover',
					html: true,
					content: function(e){
						var imageSrc = $(this).attr('alt');
						$(this).parent().find('.product_preview').html('<img src="'+imageSrc+'">');
						return $(this).parent().find('.product_preview').html();
					}
				});
			}
		});
	});
	
	/* detect if tags names if available */
	function is_new(el,value){
		var is_new = true;
		var i=0;
		el.parents('.tags').children(".tag_choice").each(function(){
			i=i+1;
			n = $(this).children("input").val();
			if (value == n || i == 5) {
				is_new = false;
			}
		});
		return is_new;
	}
	/* creating a tags name  */
	function create_choice(dis,value){
		var pid = $(this).parents('.page').attr('id');
		var el = '';
		el = '<li class="tag_choice">';
		el += value.replace(' ','');
		el += '<a class="tag_close">x</a>';
		el += '<input type="hidden" style="display:none;" value="'+value.replace(' ','')+'" name="tagItem[]">';
		el += '</li>';
		var li_search_tags = dis.parent();
		$(el).insertBefore (li_search_tags);
	}
	/* deleting tags names */
	function remove_tags(el){
		el.remove();
	}
	

	
$(function() {
	var editor;

/***** for article *****/
	$('.editable').click(function(e) {
		e.preventDefault();
		if ( editor ) {
			editor.destroy();
			$('.article_btn').hide();
		}
		editor = CKEDITOR.replace( this, { removeButtons: 'Source', enterMode: CKEDITOR.ENTER_DIV, forcePasteAsPlainText: true } );
		$(this.parentNode).find('.article_content').html(this.innerHTML);	
		$(this.parentNode).children('.article_btn').show();
	});

	$('.article_submit').click(function() {
		var parent = $(this).parents('.contents');
		var div = parent.children('.editable');
		var page_id = $(this).parents('.page').attr('id');
		div.innerHTML = content = editor.getData();
		
		if(content.trim() == ''){
			div.innerHTML = editor.setData(parent.find('.article_content').html());
		}else{
			$.ajax({
				url: '<?php echo base_url(); ?>dashboard/update_page/pages',
				data: {'page_id':page_id, 'type':'article', 'content':content},
				type: 'post',
				success: function(html) {
					editor.destroy();
					$('.article_btn').hide();
					parent.find('.article_content').html(content);
				},
			});
		}

	});

	$('.article_reset').click(function() {
		var parent = $(this).parents('.contents');
		var div = $(this).parents('.contents').children('.editable');
		var page_id = $(this).parents('.page').attr('id');
						
		div.innerHTML = editor.setData(parent.find('.article_content').html());
		
		if ( editor ) {
			editor.destroy();
			$('.article_btn').hide();
		}
	});
/***** for product *****/
	
	function createEditor() {
		if ( editor ) {
			editor.destroy(); 
			$('.article_btn').hide();
		}
		html = $('#editorcontents22').html();
		// Create a new editor inside the <div id="editor">, setting its value to html
		var config = {
			removeButtons: 'Source',
		};
		editor = CKEDITOR.appendTo( 'editorproduct9', config, html );
	}

	$('.page').delegate('#add_product','click',function(e) {
		var parent = $(this).parents('.page');
		var pid = $(this).parents('.page').attr('id');
		var type = 'add_new_product';
		parent.find('.hide_this_title').hide();
		parent.find('.asas').load('<?php echo base_url(); ?>dashboard/get_page_content',
			{'pagetype':type,'pid':pid,'wid':<?php echo $wid; ?>},
			function(response, status, xhr){
				if(status == 'success')
				{
					createEditor();
				}
		}).slideDown();
		parent.find('#item_prod_list').slideUp();
		$(document).scrollTop(document.getElementById(pid).offsetTop - 50);
		e.stopImmediatePropagation();
	});
	$('.page').delegate('#back2cat', 'click', function(e) {
		if ( editor ) {
			editor.destroy(); 
		}
		var parent = $(this).parents('.page');
		var pid = parent.attr('id');
		var cancel = parent.find('#addprod_cancel').val();
		var insertid = parent.find('#insertid').val();
		$(this).button('loading');
		$('#save_prod').attr('disabled','disabled');
		
		$(this).parents('.container-fluid').find('.hide_this_title').show();
		if(cancel == 'cancel'){
			var contentH = parent.find('#catalogue').height();
			var dataString1 = 'prod_id='+insertid;
			$.ajax({
				type: "POST",
				data: dataString1,
				url: '<?php echo base_url(); ?>dashboard/delprod',
				success: function(html){			
				}
			});
			parent.find('.asas').slideUp();
		}else{
			var type = 'catalogue';
			var order = parent.find('#seq'+pid).val();
			var dataString = 'pagetype='+type+'&pid='+pid+'&wid='+<?php echo $wid; ?>+'&order='+order;
			parent.find('#catalogue').html('<div class="progress progress-striped active"><div class="bar" style="width: 100%;"></div></div>');
			$.ajax({
				type: "POST",
				url: '<?php echo base_url(); ?>dashboard/get_page_content',
				data: dataString,
				success: function(data) {
					parent.find('#catalogue').html(data);
				}
			});
		}
		// parent.find('#add_product').button('reset');
		// parent.find('.hide_this_title').show();
		parent.find('#item_prod_list').slideDown();
	});
	
	/************* add color option ***************/
	$('.page').delegate('.add_option','click',function(){
		var el = '';
		var elem = $(this);
		
		/* remove showed option menu */
		$('.option_menu_container').remove();
		
		if($(this).is(':checked') == true)
		{
			create_optionContainer(elem);
		}
	});
	$('.page').delegate('.save_color_option','click',function(){
		var elem = $(this);
		var set_image = $(this).parent('.option_menu_container').children('select.image_option').val();
		var color_name = $(this).parent('.option_menu_container').children('input.color_name').val();
		var dataString = 'image_id='+set_image+'&color_name='+color_name;
		
		$.ajax({
			type: "POST",
			url: '<?php echo base_url(); ?>dashboard/addColorOption',
			data: dataString,
			beforeSend: function() {
				
				/* validation */
				var validInput = validate_color_option(elem,set_image,color_name);
				if(validInput == false)
				{
					return false;
				}else
				{
					elem.button('loading');
				}
			},
			success: function(html) {
				/* disbled */
				elem.html('Saved');
				elem.attr('disabled','disabled');
				elem.parent().find('input').attr('disabled','disbaled');
				elem.parent().find('select').attr('disabled','disbaled');
				
				var detect = elem.parents('.prod_form').find('li.box_hover').children('div#'+set_image).find('div.color_badge_custom').attr('class');
				if(detect == undefined)
				{
					elem.parents('.prod_form').find('li.box_hover').children('div#'+set_image).append('<div class="color_badge_custom" alt="'+color_name+'" "="" style="background-color:'+color_name+'; height:10px;width:10px;margin:5px;"> </div>');
				}else
				{
					/* set color to choosen image */
					elem.parents('.prod_form').find('li.box_hover').children('div#'+set_image).find('div.color_badge_custom').attr('alt',color_name).css('background-color',color_name);
				}
			}
		
		});
	});
	
	$('.page').delegate('.add_more_option','click',function(){
		var elem = $(this);
		var set_image = $(this).parent('.option_menu_container').children('select.image_option').val();
		var color_name = $(this).parent('.option_menu_container').children('input.color_name').val();
		
		/* validation */
		var validInput = validate_color_option(elem,set_image,color_name);
		if(validInput == false)
		{
			return false;
		}
		
		/* create container */
		create_optionContainer(elem);
		
		/* remove add button */
		elem.remove();
		
	});
	function validate_color_option(dis,image,color)
	{
		if(color.trim() == '')
		{
			dis.parent('.option_menu_container').children('input.color_name').focus();
			dis.parent('.option_menu_container').children('input.color_name').val('');
			return false;
		}else if(image == 0)
		{
			dis.parent('.option_menu_container').children('select.image_option').focus();
			return false;
		}
	}
	function create_optionContainer(dis)
	{	
		el ='<div style="margin-bottom: 10px;" class="option_menu_container">';
		el +=	'Group by: ';
		el +=	'<input type="text" value="" class="color_name" placeholder="Color name">';
		el +=	'&nbsp;Set image:';
		el +=	'<select class="image_option">';
		el +=		'<option value="0">Select...</option>';
		$('#prod_sort li').each(function(e,elem){
			e = e + 1;
			var image_id = $(elem).children('.prod_thumb').attr('id');
			el +=	'<option value="'+image_id+'">'+e+'</option>'; 
		});
		el +=	'</select>';
		el +=	'&nbsp;';
		el +=	'<button class="btn btn-mini save_color_option" data-loading-text="Saving..." style="margin-top: 7px;">Save</button>';
		el +=	'&nbsp;';
		el +=	'<button class="btn btn-mini add_more_option" style="margin-top: 7px;">Add</button>';
		el +='</div>'
		
		$(el).insertAfter(dis.parent());
		
		/******** typeahead colors ************/
		$('.color_name').typeahead({
			source: function(query,process){
				$.getJSON(
					'<?php echo base_url(); ?>dashboard/typeaheadColors',
					{ query: query },
					function (data) {
						return process(data);
				});
			},
			items: 5
		});
		/******** typeahead colors end ************/
	}
	/************* add color option end ***************/
	
	
	$('.page').delegate('#save_prod','click',function(e) {
		var eto = $(this);
		var parent = $(this).parents('.page');
		var pid = $(this).parents('.page').attr('id');
		var insertid = parent.find('#insertid').val();
		var prod_action = parent.find('#prod_action').val();
		var prod_weight = parent.find('#ideal_weight').val();
		var avail_ship = parent.find('#avail_ship').val();
		
		/* detect url */
		var url_video = parent.find('#prod_video').val();
		var ytLink = url_video.match('youtube.com');
		
		/* this is for tags */
		var tags_array = new Array();
		$(this).parents('.prod_form').find('.tag_choice').each(function(i,el){
			tags_array.push($(el).find('input').val());
		});
		var div = parent.find('#editorproduct9');
		div.innerHTML = content = editor.getData();
		var dataSerial = $('.prod_form').serialize(),
			dataString = dataSerial+'&action='+prod_action+'&avail_ship='+avail_ship+'&prod_weight='+prod_weight+'&prod_description='+encodeURIComponent(content)+'&prod_id='+insertid+'&wid=<?php echo $wid; ?>&pid='+pid+'&tags_name='+tags_array;	
 		$.ajax({
			type: "POST",
			url: '<?php echo base_url(); ?>dashboard/ajaxproduct',
			data: dataString,
			beforeSend: function() {
			
					/* loading state */
					$(eto).button('loading');
					parent.find('#back2cat').button('loading');
					
					/* url validation */
					if(url_video != '')
					{
						if(ytLink == null)
						{
							alert('Invalid video link');
							$(eto).button('reset');
							parent.find('#back2cat').button('reset');
							return false;
						}
					}
					
					/* validation */
					var prodName = parent.find('#prod_name').val();
					var prodCateg = parent.find('#prod_cat').val();
					var prodSec = parent.find('#prod_section').val();
					var imgsrc = '';
					if((prodName == '') || (prodName == ' ')){
						parent.find('#prod_name').focus();
						parent.find('#save_prod').button('reset');
						parent.find('#back2cat').button('reset');
						
						/* scroll to top */
						var top = parent.find('#prod_name').offset().top;
						$('body').animate({ scrollTop: top - 150 });	
						return false;
					}else if((prodCateg == '') || (prodCateg == 'Select')){
						parent.find('#prod_cat').focus();
						parent.find('#save_prod').button('reset');
						parent.find('#back2cat').button('reset');
						$('html, body').animate({ scrollTop: 300 });	
						return false;
					}else if((prodSec == '') || (prodSec == 'Select')){
						parent.find('#prod_section').focus();
						parent.find('#save_prod').button('reset');
						parent.find('#back2cat').button('reset');
						$('html, body').animate({ scrollTop: 300 });	
						return false;
					}		
					
			},
			success: function(html) {
				var type = 'catalogue';
				var order = parent.find('#seq'+pid).val();
				var dataStringda = 'pagetype='+type+'&pid='+pid+'&wid='+<?php echo $wid; ?>+'&order='+order;
				$.ajax({
					type: "POST",
					url: '<?php echo base_url(); ?>dashboard/get_page_content',
					data: dataStringda,
					success: function(data) {
						if ( editor ) {
							editor.destroy();
						}
						parent.find('#catalogue').html(data);
						parent.find('#save_prod').button('reset');
					}
				});
				parent.find('#catalogue').css('position','static');
				parent.find('#catalogue').css('z-index','0');
			}
		});
		parent.find('#add_product').button('reset');
		e.stopImmediatePropagation();
	});

	$('.page').delegate('.edit_product','click',function(e) {
		
		/* destroy popover */
		$('a.prod_imageview').popover('destroy');
		
		var parent = $(this).parents('.page');
		var pid = $(this).parents('.page').attr('id');
		var prodId = $(this).parents('.item_prod').attr('id');
		var datastr = { 'prodid': prodId, 'pid': pid, 'wid': '<?php echo $wid; ?>' };
		parent.find('#catalogue').html('<div class="progress progress-striped active"><div class="bar" style="width: 100%;"></div></div>');
		$.ajax({
			type:'post',
			url:'<?php echo base_url(); ?>dashboard/edit_product',
			cache: false,
			data: datastr,
			success: function(data)
			{
				parent.find('#catalogue').html(data);
				// $('html, body').animate({scrollTop: 550});
				createEditor();
			}
		});
		e.stopImmediatePropagation();
	});
	
	/* sub category */
	$('.page').delegate('.prod_cat','change',function(e) {
		var dis = $(this);
		var pid = dis.parents('.page').attr('id');
		var cat_name = dis.val();
		var dataString = 'cat_name='+cat_name+'&wid=<?php echo $wid; ?>'+'&pid='+pid;
		
		/* remove existing div */
		$('.sub_div').remove();
		
		$.ajax({
			type:'post',
			url:'<?php echo base_url(); ?>dashboard/subcategoryset',
			data: dataString,
			success: function(data)
			{
				var divSection = dis.parents('.control-group');
				$(data).insertAfter(divSection);
				$('.sub_category').focus();
			}
		});
		
	});
	$('.page').delegate('.add_sub_categ','click',function(e) {
		var dis = $(this);
		var pid = dis.parents('.page').attr('id');
		var el = '';
		
		/* disable add button */
		dis.attr('disabled','disabled');
		
		el = '<input type="text" class="added_input_sub_categ" value="" style="margin-right:3px;">';
		el += '<button class="btn btn-mini save_added_categ" style="margin-top:2px;">Push</button>';
		$(el).insertAfter(dis);
		
		$('.added_input_sub_categ').focus();
		
	});
	$('.page').delegate('.save_added_categ','click',function(e) {
		var dis = $(this);
		var added_categ = dis.parent().find('.added_input_sub_categ').val();
		var option = dis.parent().find('.sub_category');
		if(added_categ.trim() == '')
		{
			dis.parent().find('.added_input_sub_categ').val('');
			dis.parent().find('.added_input_sub_categ').focus();
			return false;
		}
		
		/* disable save button */
		dis.attr('disabled','disabled');
		dis.parent().find('.added_input_sub_categ').attr('disabled','disabled');
		dis.parent().find('.edit_sub_categ').hide();
		
		option.prepend('<option value="'+added_categ+'" selected>'+added_categ+'</option>');
	});
	
	/* sub category end */
	
	$('.page').delegate('.variant_select','change',function(){
		var dis = $(this);
		var placeholder = dis.parents('.row-fluid').find('.variant_input');
		if(dis.val() == 'size')
		{
			placeholder.val('');
			placeholder.attr('placeholder','small,medium,large');
			
		}else if(dis.val() == 'color')
		{
			placeholder.val('');
			placeholder.attr('placeholder','red,blue,yellow');
			
		}else if(dis.val() == 'package')
		{
			placeholder.val('');
			placeholder.attr('placeholder','1 pcs,50 pcs,100 pcs');
			
		}else
		{
			placeholder.val('');
			placeholder.attr('placeholder','...');
		}
	});
	
	$('.page').delegate('.add_variant','click',function(){
		var dis = $(this);
		var variant_type = dis.parents('.row-fluid').find('.variant_select');
		var variant_name = dis.parents('.row-fluid').find('.variant_input');
		var variant_price = dis.parents('.row-fluid').find('.variant_price');
		var variant_quantity = dis.parents('.row-fluid').find('.variant_quantity');
		
		if(variant_name.val().trim() == '')
		{
			variant_name.focus();
			return false;
		}
		else if(variant_price.val() == '' || isNaN(variant_price.val()))
		{
			variant_price.val('');
			variant_price.focus();
			return false;
		}else if(variant_quantity.val() == '' || isNaN(variant_quantity.val()))
		{
			variant_quantity.val('');
			variant_quantity.focus();
			return false;
		}else
		{
			/* add variant group */
			if(validateVariant_name(dis,variant_name) == 1)
			{
				variant_group_div(dis,variant_type.val(),variant_name.val(),variant_price.val(),variant_quantity.val());
			}else
			{
				alert('Name already exist');
				variant_name.val('').focus();
			}
		}
	});
	$('.page').delegate('.remove_variant','click',function(){
		$(this).parents('.variant_row').remove();
	});
	$('.page').delegate('.variant_row input','keyup',function(){
		var value = $(this).val();
		if(isNaN(value))
		{
			$(this).val(1);
		}
	});
	
	function variant_group_div(dis,type,name,price,quantity) {
		var loc = dis.parents('#advanceoption');
		var get_parent = dis.parents('.prod_form ');
		var el = '';
		
		el ='<div class="row-fluid variant_row">';
		el +='<div class="span2" style="border-bottom: 1px dashed #ddd;">';
		el +='	<span>'+type+'</span>';
		el +='	<input type="hidden" class="v_type" name="v_type[]" value="'+type+'">';
		el +='</div>';
		el +='<div class="span2" style="border-bottom: 1px dashed #ddd;">';
		el +='	<span>'+name+'</span>';
		el +='	<input type="hidden" class="v_name" name="v_name[]" value="'+name+'">';
		el +='</div>';
		el +='<div class="span2" style="border-bottom: 1px dashed #ddd;">';
		el +='	<input type="text" class="v_price span12" name="v_price[]" value="'+price+'">';
		el +='</div>';
		el +='<div class="span2" style="border-bottom: 1px dashed #ddd;">';
		el +='	<input type="text" class="v_quantity span12" name="v_quantity[]" value="'+quantity+'">';
		el +='</div>';
		el +='<div class="span1">';
		el +='	<i class="icon-remove-sign remove_variant" style="cursor:pointer;"></i>';
		el +='</div>';
		el +='</div>';
		get_parent.find('.variant_group_container').append(el);
	}
	function validateVariant_name(dis,name)
	{
		var get_parent = dis.parents('.prod_form');
		var validname = 1;
		get_parent.find('.v_name').each(function(){
			if($(this).val().trim() == name.val().trim())
			{
				validname = 0;
			}
		});
		return validname;
	}
	
	$('.page').delegate('.remove_sub_categ','click',function(){
		var dis = $(this);
		dis.parents('.sub_div').remove();
		
	});
	
	$('.upload_article_image').on('change', function(e) {
		var pid = $(this).parents('.page').attr('id');
		$(this).parents('.article_image_form').ajaxForm({
			type: 'post',
			data: { pid: pid },
			beforeSubmit: function() {
			
			},
			success: function(html) {
				console.log(html);
			}
		}).submit();
		e.preventDefault();
		e.stopPropagation();
	});
});

</script>