<?php
	$queryApproved = 0;
	foreach($queryAllActiveWebsites->result_array() as $myarraycontent){
		if(isset($myarraycontent['marketplace']) && $myarraycontent['marketplace'] == 1) {
			$queryApproved++;
		}
	}
?>
		<div class="row-fluid form-inline">
			<div class="span6">
<?php
			$array = array(
				'class' => 'form_searchdate',
				'name' => 'form_searchdate'
			);
			echo form_open_multipart(base_url().'test/loadmore', $array);
?>
				<label for="webfrom">From</label>
				<input type="text" id="webfrom" name="webfrom" class="from" value="<?php echo $this->input->post('webfrom') ?>" />
				<label for="webto">to</label>
				<input type="text" id="webto" name="webto" class="to" value="<?php echo $this->input->post('webto') ?>" />
				<button type="submit" class="btn">Go</button>
<?php
			echo form_close();
?>
			</div>
			<div class="span3 text-right">
			</div>
			<div class="span3 text-right">
				<form class="searchform">
					<input type="text" class="searchprod" placeholder="Search..." name="searchprod" />
				</form>
			</div>
		</div>
	<div class="container-fluid">
		<table id="websitesTable" class="table table-striped table-condensed table-bordered">
		<caption>
			<span> Total No. of Websites: <strong><?php echo $queryAllActiveWebsites->num_rows(); ?></strong> </span><br>
			<span> Total No. of Approved Websites: <strong class="approved_prods"> <?php echo $queryApproved; ?> </strong> </span>
		</caption>
		
		<thead>
			<tr>
				<th data-order="id"> # </th>

				<th data-order="site_name"> name </th>
				<th > email </th>

				<th data-order="logo"> logo </th>

				<th data-order="description"> description </th>
				<th data-order="background"> background </th>
				<th data-order="layout"> layout </th>
				<th data-order="status"> status </th>
				<th data-order="favicon"> favicon </th>
				<th data-order="marketgroup"> marketgroup </th>
				<th data-order="marketplace"> marketplace </th>
				<th data-order="date_created"> created </th>
				

			</tr>
		</thead>
		<tbody>
<?php
			echo $websites_control_content;
?>
		</tbody>
	</table>
	</div>
<script>
$(function(){
	$('#websitesTable').delegate('#delete_web', 'click', function(e) {
		
	});	
});
</script>