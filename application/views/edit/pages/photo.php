<?php
	$siteTitle = '';
	$getsitename = $this->db->query("SELECT * FROM websites WHERE id='$wid'");
	if($getsitename->num_rows() > 0)
	{
		$res_web = $getsitename->row_array();
		$siteTitle = $res_web['site_name'];
	}
?>
<style type="text/css">

	#sortablephotos li {
		margin-bottom:10px;
	}
	#sortablephotos li .sorthold .span4 p {
		text-overflow: ellipsis;
		overflow: hidden;
		white-space: nowrap;
	}
	#sortablephotos li .sorthold .span4 {
		line-height: 54px;
	}
	#sortablephotos li .sorthold .span2 {
		line-height: 52px;
	}

	.c_gallery .accordion-group {
		border: 1px solid transparent;
	}
/*	.c-gallery button.ca-album
	{
		background: #D3D8DE;
		border-radius: 0px;
		padding: 5px;
		border: 0;
		text-shadow: none;
		color:#fff;
	}
	.c-gallery a.c-album, .c-gallery button.c-album, .b-to-album
	{
		background: #0082EE;
		border-radius: 0px;
		padding: 10px;
		border: 0;
		text-shadow: none;
		color:#fff;
	}
	.b-to-album:hover {
		background: #DDDDDD;
		color: #0088CC;
	}
	.c-gallery a.c-album:hover, .c-gallery button.c-album:hover
	{
		background: #D3D8DE !important;
		/* box-shadow: 1px 1px 9px 0px #999 inset; */
	}
*/
</style>

<div class="c-gallery c_gallery" style="background-color: #FFFFFF;">
<div class="fbinfo"></div>
	<div class="accordion" id="accordion2albumtitle" style="margin-bottom:0;">
		<div class="accordion-group" style="margin-bottom:0;">
			<div id="albumtitle" class="accordion-body collapse in">
			  <div class="accordion-inner" style="border-top:0;">			
				<div class="row-fluid">
					<legend style="font-family: 'Segoe UI bold'; font-size: 14px;">
						<span class="yalbum" style="text-transform: uppercase;"> Your Album: </span>
					</legend>
				</div>
				<div class="row-fluid">
					<button style="margin-right: 20px; display:none;" class="btn btn-primary active_action_button pull-right b-to-album">Back to album</button>
					<a class="pull-right btn btn-primary active_action_button c_album c-album crlink" onclick="$(this).css('visibility','hidden');changename(this);" data-toggle="collapse" data-parent="#accordion2album<?php echo $pid; ?>" href="#createalbum<?php echo $pid; ?>" >&#10010; Create Album </a>
				</div>
			  </div>
			</div>
		</div>
	</div>
	<!--<a href="#myModalalbum" role="button" class="btn btn-link pull-left edit-album-name" style="display:none;" data-toggle="modal">Edit</a>-->
	<div class="accordion" id="accordion2album<?php echo $pid; ?>">
	  <div class="accordion-group">
		<div id="createalbum<?php echo $pid; ?>" class="accordion-body collapse">
		  <div class="accordion-inner" style="background-color: #FFFFFF;padding: 35px 15px 0px;border:0;">			
			<div class="row-fluid">			
				<form class="offset3 span6 form-inline" onsubmit="return false">
				  <div class="control-group">					
					<div class="controls">
					  <input type="text" class="span12" id="inputAlbum" name="inputAlbum" placeholder="Album Name">
					</div>
				  </div>
				  <div class="control-group">					
					<div class="controls">
					  <textarea id="inputdes" class="span12" name="inputdes" placeholder="Album Description" style="resize: vertical;"></textarea>
					</div>
				  </div>
				  <div class="control-group">
					<div class="controls">
						<button class="btn btn-block active_action_button cr-album c_album c-album">Create</button>
					</div>
				  </div>
				  <div class="control-group">
					<div class="controls">
						<button class="btn btn-block active_action_button ca-album c_album c-album">Cancel</button>
					</div>
				  </div>
				</form>
			</div>
		  </div>
		</div>
	  </div>
	  <div class="accordion-group">
		<div id="multi-album" class="accordion-body collapse">
		  <div class="accordion-inner" style="border:0;">
			<div class="row-fluid gallery-upload">
				<?php 
					// $data['albumid'] = $pid;
					// $data['pid'] = $pid;
					// $this->load->view('edit/pages/albumpage', $data);
				?>
			</div>
		  </div>
		</div>
	  </div>
	  <div class="accordion-group">
		<div id="uploadalbum" class="accordion-body collapse in">
		  <div class="accordion-inner" style="padding: 9px 0px;border:0;">
			<div class="row-fluid gallery-content">
				<!-- Show album list -->
<?php
		$data['wid'] = $wid;
		$this->db->where('web_id', $wid);
		// $this->db->where('page_id', $pid);
		$this->db->order_by('id desc');
		$data['query'] = $this->db->get('albums');

		
		// $data['thequery'] = "SELECT * FROM albums WHERE web_id='".$wid."' AND page_id='".$pid."' ORDER BY id DESC";
		// $getquery = $this->db->query("SELECT * FROM albums WHERE web_id='".$wid."' ORDER BY id DESC");
		// $chkquery = $this->db->query($data['thequery']);
		// if($chkquery->num_rows() != $getquery->num_rows()) {

			// foreach($getquery->result_array() as $thedata){
				// $chek_value = false == $thedata['page_id'];
				// if($chek_value){
					// $updata = array(
						// "page_id" => $pid
					// );
					// $this->db->where('id',$thedata['id']);
					// $this->db->update('albums',$updata);
				// }
			// }
		// }
		$this->load->view('viewalbum', $data);
?>
				<!-- end album list -->
			</div>
			<div class="row-fluid loading-info">
			</div>
		  </div>
		</div>
	  </div>
	</div>
</div>
<!-- Modal Edit Album -->
<div id="myModalalbum" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Edit Album</h3>
  </div>
  <div class="modal-body">
    <form class="form-horizontal">
		<div class="control-group">
			<label class="control-label">Album Name:</label>
			<div class="controls">
				<input type="text" id="nameAlbum" />
				<input type="hidden" id="idAlbum" value="" />
			</div>
		</div>
		<div class="control-group">
			<label class="control-label">Album Description:</label>
			<div class="controls">
				<textarea name="descAlbum" id="descAlbum"></textarea>
			</div>
		</div>
    </form>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <button class="btn btn-primary save-album-details">Save changes</button>
  </div>
</div>

<div id="Modal_album_delete" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header" style="background-color: #f26221;border-bottom:0;">
    <h4 id="myModalLabel_pages" style="color:#fff;margin: 5px 0;font-family: 'ScalaSans Light';opacity: 0.7;">Are you sure you want to delete this album?</h4>
  </div>
  <input type="hidden" name="parentpic_album" id="parentpic_album" />
  <input type="hidden" name="del_album_page" id="del_album_page" />
  <div class="modal-footer" style="background-color: #e34e0d;color: #fff;border-top:0;box-shadow: none;border-radius:0;">
    <button class="btn btn_color" onclick="deletealbum()" data-dismiss="modal" aria-hidden="true">YES</button>
    <button class="btn btn_color pages_no" data-dismiss="modal" aria-hidden="true" onclick="reset_select(this.id)">NO</button>
  </div>
</div>

<script>
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
	function changename(x){
		var parentpic = $(x).parents('.page').attr('id');
		$('#'+parentpic).find('.yalbum').html('Create Album:');
	}
</script>