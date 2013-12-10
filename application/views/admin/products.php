		<div class="row-fluid form-inline">
			<div class="span6">
<?php
			$array = array(
				'class' => 'form_searchdate',
				'name' => 'form_searchdate'
			);
			echo form_open_multipart(base_url().'test/loadmore', $array);
?>
				<label for="prodfrom">From</label>
				<input type="text" id="prodfrom" name="prodfrom" class="from" value="<?php echo $this->input->post('prodfrom') ?>" />
				<label for="prodto">to</label>
				<input type="text" id="prodto" name="prodto" class="to" value="<?php echo $this->input->post('prodto') ?>" />
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

	<table class="table table-striped table-condensed table-bordered">
	<caption>Total No. of Products: <strong><?php echo $queryAllProducts->num_rows(); ?></strong></caption>
	<thead>
		<tr>
			<th data-order="id"> # </th>
			<th data-order="name"> name </th>
			<th data-order="category"> category </th>
			<th data-order="price"> price </th>
			<th data-order="stocks"> stocks </th>
			<th data-order="video"> video link </th>
			<th data-order="desc"> description </th>
			<th data-order="marketplace"> marketplace </th>
			<th data-order="date_created"> date created </th>
			<th data-order="date_modified"> date updated </th>
			<th data-order="published"> published </th>
			<th data-order="website_id"> website </th>
			<th data-order="id"> </th>
		</tr>
	</thead>
	<tbody>
<?php
	echo $products_content;
?>
	</tbody>
</table>