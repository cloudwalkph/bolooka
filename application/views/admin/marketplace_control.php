<?php
	$queryApproved = 0;
	foreach($queryAllMarketProducts->result_array() as $myarraycontent){
		if(isset($myarraycontent['marketplace']) && $myarraycontent['marketplace'] == 1) {
			$queryApproved++;
		}
	}
?>

	<div class="row-fluid">
		<div class="pull-left"> <button type="button" class="btn" id="randomize_it"> Randomize </button> </div>
		<div class="span3 pull-right" style="text-align: right;">
			<form class="searchform">
				<input type="text" class="searchprod" placeholder="Search..." name="searchprod" />
			</form>
		</div>
	</div>

<?php
	$form_attrib = array(
			'id' => 'productsTable_form',
			'name' => 'productsTable_form',
		);
	echo form_open('', $form_attrib); 
?>
	<table id="productsTable" class="table table-condensed">
		<caption>
			<span> Total No. of Published Products: <strong> <?php echo $queryAllMarketProducts->num_rows(); ?> </strong> </span> <br>
			<span> Total No. of Approved Products: <strong class="approved_prods"> <?php echo $queryApproved; ?> </strong> </span>
		</caption>
		<thead>
			<tr>
				<th data-order="id"> # </th>
				<th data-order="primary"> image </th>
				<th data-order="name"> name </th>
				<th data-order="website_id"> website name </th>
				<th data-order="category"> category </th>
				<th data-order="price"> price </th>
				<th data-order="marketplace"> marketplace </th>
				<th data-order="section"> section </th>
				<th data-order="date_modified"> posted </th>
			</tr>
		</thead>
		<tbody class="load_content">
<?php
	echo $marketplace_control_content;
?>
		</tbody>
	</table>
<?php
	echo form_close();
?>
<div id="modal_random" class="modal hide fade">
  <div class="modal-body">
    <p>Randoming Products.. Please Wait...</p>
  </div>
</div>
<script>
$(function() {
	$('#randomize_it').click(function(e) {
		$.ajax({
			xhr: function()
			{
				var xhr = new window.XMLHttpRequest();
				xhr.upload.addEventListener("progress", function(evt){
					if (evt.lengthComputable) {
						var percentComplete = evt.loaded / evt.total;
						console.log(percentComplete);
					}
				}, false);
				xhr.addEventListener("progress", function(evt){
					if (evt.lengthComputable) {
						var percentComplete = evt.loaded / evt.total;
						console.log(percentComplete);
					}
				}, false);
				return xhr;
			},
			beforeSend: function() {
				$('#modal_random').modal({
					backdrop: 'static',
					keyboard: 'false',
					show: 'true'
				});
			},
			url: '<?php echo base_url(); ?>test/random_it',
			success: function(html) {
				$('#modal_random').modal('hide');
			}
		});
	});

	$('#productsTable').on('change', '.prod_section', function(e) {
		var prodID = $(this).parents('tr').find('td:first-child').html(),
			prodSection = this.value,
			dataString = { 'prodID': prodID, 'prodSection': prodSection };
		
		$.ajax({
			url:"<?php echo base_url(); ?>test/moderate/prod_section",
			type: 'post',
			data: dataString,
			beforeSend: function(formData, jqForm, options){
			},
			success: function(html){
			}
		});
	});
	
	$('tbody .del_prod').on('click', function(e) {
		var prodID = $(this).parents('tr').find('td:first-child').html();
	});
	
	$('#productsTable').on('click', 'button[name="mod"]', function(e) {
		var el = e.target;
		var prodID = $(this).parents('tr').find('td:first-child').html();
		var value = el.value;
		var dataString = { 'prodID': prodID, 'value': value };
		
		$.ajax({
			type:"POST",
			url:"<?php echo base_url(); ?>test/moderate/product",
			data: dataString,
			success: function(html){
				if(value == 0) {
					$(el).html('Disapproved').addClass('btn-danger').removeClass('btn-success').val(1);
					$('.approved_prods').text(Number($('.approved_prods').html()) - 1);
				} else {
					$(el).html('Approved').addClass('btn-success').removeClass('btn-danger').val(0);
					$('.approved_prods').text(Number($('.approved_prods').html()) + 1);
				}
			}
		});
	});

});
</script>