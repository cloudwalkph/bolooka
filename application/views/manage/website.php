<?php
	$uid = $this->session->userdata('uid');
	
	$this->db->where('user_id', $uid);
	$this->db->where('deleted', 0);
	$query = $this->db->get('websites');
	
	$total_website = 1;
	
	if ($this->db->table_exists('tbl_credits')) {
		$this->db->where('user_id', $uid);
		$this->db->where('action', 'buy');
		$this->db->where('object', 'website_1');
		$qcredits = $this->db->get('tbl_credits');

		$total_website = $qcredits->num_rows() + 1;
	}
	
?>
<style>
	table.table-striped tr td
	{
		padding: 13px 5px;
		border-top:none;
	}
	.btn_create {
		background-color: rgb(0, 130, 238);
		background-image: none;
		border: 0 none;
		border-radius: 0 0 0 0;
		text-shadow: none;
	}
	.btn_color {
		background: #f16120; /* Old browsers */
		background: -moz-linear-gradient(top,  #f16120 0%, #e75210 100%); /* FF3.6+ */
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#f16120), color-stop(100%,#e75210)); /* Chrome,Safari4+ */
		background: -webkit-linear-gradient(top,  #f16120 0%,#e75210 100%); /* Chrome10+,Safari5.1+ */
		background: -o-linear-gradient(top,  #f16120 0%,#e75210 100%); /* Opera 11.10+ */
		background: -ms-linear-gradient(top,  #f16120 0%,#e75210 100%); /* IE10+ */
		background: linear-gradient(to bottom,  #f16120 0%,#e75210 100%); /* W3C */
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f16120', endColorstr='#e75210',GradientType=0 ); /* IE6-9 */
		
		text-shadow: none;
		box-shadow: -2px 2px 5px -2px #ddd inset;
		color: #fff;
	}
	.btn_color:hover {
		background: #e75311; /* Old browsers */
		background: -moz-linear-gradient(top, #e75311 0%, #f16120 100%); /* FF3.6+ */
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#e75311), color-stop(100%,#f16120)); /* Chrome,Safari4+ */
		background: -webkit-linear-gradient(top, #e75311 0%,#f16120 100%); /* Chrome10+,Safari5.1+ */
		background: -o-linear-gradient(top, #e75311 0%,#f16120 100%); /* Opera 11.10+ */
		background: -ms-linear-gradient(top, #e75311 0%,#f16120 100%); /* IE10+ */
		background: linear-gradient(to bottom, #e75311 0%,#f16120 100%); /* W3C */
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#e75311', endColorstr='#f16120',GradientType=0 ); /* IE6-9 */

		box-shadow: 1px -2px 5px -2px #ddd inset;
		color: #fff;
	}
	/* RESPONSIVE CSS */
	@media (max-width: 767px)
	{
		.mobile_view {
			padding: 0 8px;
		}
	}
</style>

<div id="website" class="container-fluid mobile_view">
		<legend style="font-family: Segoe UI Semibold; font-size: 18px; color: rgb(23, 23, 23);">Manage e-store</legend>
<?php
		if($query->num_rows() == 0):
?>
		<p style="line-height: 1;color: rgb(144, 144, 144); font-size: 30px; font-family: ScalaSans Light;">Welcome to Bolooka manage e-store, your social e-commerce! </p>
		<p style="font-size: 16px; color: rgb(51, 51, 51); font-family: Segoe UI;">You will see here all the links of the websites you&rsquo;ve created.</p>
<?php
		endif;
?>
		<p class="pull-right">
<?php
		if($query->num_rows() < $total_website || $this->session->userdata('uid') == 264):
?>
			<a href="<?php echo base_url('create/site'); ?>" class="btn btn-large btn-primary btn_create" rel="popover" data-placement="right" data-content="asdsad"><i class="icon-plus icon-white"></i> Create website</a>
<?php
		else:
?>
			<button id="tooltip_create_button" class="btn btn-large btn-primary btn_create"><i class="icon-plus icon-white"></i> Create website</button>
<?php
		endif;
?>
		</p>
	<?php	
		if($query->num_rows() > 0)
		{
			$website = $query->result();
	?>
		<div style="clear:both;"></div>
		<!--<div class="container-fluid"> this is to center the table width-->
		<table class="table table-condensed table-striped hidden-phone">
			<thead style="background: #dee8f2;">
			<th>Name</th>
			<th>Url</th>
			<th>Followers</th>
			<th>&nbsp;&nbsp;&nbsp;</th>
			<thead>
	<?php
			echo '<tbody>';
			foreach($website as $row)
			{
				$the_id = $row->id;
				$this->db->where('website_id',$the_id);
				$query2 = $this->db->get('follow');
				if($query2->num_rows() > 0)
				{
					$followers = $query2->num_rows();
					$totalfollow[] = $query2->num_rows();
				}
				else
				{
					$followers = 0;
				}
	?>
				<tr id="<?php echo $row->id; ?>">
					<td><?php echo $row->site_name; ?></td>
					<td><?php echo '<a target="_blank" href="'.base_url().'preview?wid='.$row->id.'">'.base_url().url_title($row->url,'-',true).'</a>'; ?></td>
					<td><a href="<?php echo base_url().'manage/followers/'.$row->id; ?>"><?php echo $followers; ?></a></td>
					<td>
						<a href="<?php echo base_url().'manage/webeditor?wid='.$row->id; ?>">Edit</a>
						 <span> | </span> <a target="_blank" href="<?php echo base_url().'preview?wid='.$row->id; ?>">Preview</a>
<?php
						if ($row->deleted == 0) {
							echo '<span> | <a style="cursor: pointer;" class="deleteWebsite" alt="'.$row->id.'">Delete</a></span>';
						} else {
							echo '<span> | <a style="cursor: pointer;" class="restore_website" alt="'.$row->id.'">Restore</a></span>';
						}
?>
					</td>
				</tr>
	<?php
			}
	?>
			</tbody>
		</table>
		
		<div class="container-fluid visible-phone">
			<div class="accordion" id="web_accordion_phone">
	<?php
			foreach($website as $row)
			{
				$the_id = $row->id;
				$this->db->where('website_id',$the_id);
				$query2 = $this->db->get('follow');
				if($query2->num_rows() > 0)
				{
					$followers = $query2->num_rows();
					$totalfollow[] = $query2->num_rows();
				}
				else
				{
					$followers = 0;
				}
	?>	
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle" style="display:inline;" data-toggle="collapse" data-parent="#web_accordion_phone" href="#collapse<?php echo $the_id; ?>">
							<?php echo $row->site_name; ?> 
						</a>
						<a class="accordion-toggle" style="display:inline;" href="<?php echo base_url().'manage/followers/'.$row->id; ?>"><i class="icon-eye-open"></i></a>
					</div>
					<div id="collapse<?php echo $the_id; ?>" class="accordion-body collapse">
						<div class="accordion-inner">
							<a href="<?php echo base_url().'manage/webeditor?wid='.$row->id; ?>">Edit</a> <span>|</span> 
							<a target="_blank" href="<?php echo base_url().'preview?wid='.$row->id; ?>">Preview</a> <span>|</span> 
							<a style="cursor: pointer;" class="deleteWebsite" alt="<?php echo $row->id; ?>">Delete</a>
						</div>
					</div>
				</div>
	<?php
			}
	?>
			</div>
		</div>
<?php
		}
?>
</div><!--end of container fluid-->

	<!-- Modal Delete Website-->
	<div id="myModal_delete_website" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
		<div class="modal-header title_message" style="background-color: #f26221;border-bottom:0;">
			<h4 id="myModalLabel" style="color:#fff;font-size: 20px;margin: 5px 0;font-family: 'Segoe UI Semibold';opacity: 0.7;">All contents will be removed.</h4>
		</div>
		<div class="modal-body" style="background-color: #e34e0d;color: #fff;">
			<?php
				$delete_website_attrib = array(
					'id' => 'delete_website'
				);
				
				echo form_open('manage/delete_website', $delete_website_attrib);
			?>
				<p>Are you sure you want to delete your website?</p>
				<input class="website_id" name="website_id" type="hidden">
				<p class="pull-right">
					<button id="dwyes" class="btn btn_color" type="submit" style="font-weight: bold;">YES</button>
					<button id="dwno" class="btn btn_color" data-dismiss="modal" aria-hidden="true" type="button" style="font-weight: bold;">NO</button>
				</p>
<?php
				echo form_close();
?>
		</div>
	</div>
	<input type="hidden" id="website_base_url" value="<?= base_url();?>" />
<!--<script type="text/javascript">
// $(function(){
	// $('#tooltip_create_button').tooltip({
		// html: true,
		// trigger: 'click',
		// title: 'You have exceeded your website creation limit. Please contact us for more info.',
		// delay: { show: 500, hide: 100 }
	// });
	// $('#website').delegate('.deleteWebsite', 'click', function(e) {
		// if(e.shiftKey == true) {
			// $.ajax({
				// 'url': 'manage/del_web',
				// 'data': {'website_id': $(e.target).attr('alt')},
				// 'beforeSend': function(a,b,c) {
				// },
				// 'success': function(html) {
					// $(e.target).parents('tr').slideUp();
				// }
			// });
		// } else {
			// var webId = $(this).attr('alt');
			// $('.website_id').val(webId);
			// $('#myModal_delete_website').modal('show');
			// $('#dwyes').removeAttr('disabled');
			// $('#dwyes').text('Yes');
		// }
	// });
	
	// $('#delete_website').ajaxForm({
		// url: 'manage/delete_website',
		// beforeSubmit: function(formData, jqForm, options) {
			// $('#dwyes').attr('disabled','disabled');
			// $('#dwyes').html('Loading...');
		// },
		// success: function(html) {
			// location.reload();
		// }
	// });
	
	// $('.restore_website').on('click', function(ev) {
		// var website_base_url = $('#website_base_url').val();
		// var site_id = $(this).attr('alt'),
			// el = $(this);
		// $.ajax({
			// url: website_base_url+'manage/restore_website',
			// type: 'post',
			// data: { 'website_id': site_id },
			// beforeSend: function() {
				// el.parent().hide();
			// },
			// success: function(html) {
				// location.reload();
			// }
		// });
		// ev.stopPropagation();
	// });
		
	// /* // clear latest tab stored */
	// sessionStorage.setItem('lastTab', 'details');
});-->
</script>
		