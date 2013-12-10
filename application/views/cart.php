<?php
		$this->db->where('website_id', $wid);
		$queryDesc = $this->db->get('design');
		$bg = $queryDesc->row();		
?>
<?php
	$weight = '';
	$thecontent = $this->cart->contents();
	foreach($this->cart->contents() as $items2){
		$this->db->where('id',$items2['id']);
		$this->db->where('website_id',$wid);
		$query = $this->db->get('products');
		
		if($query->num_rows() > 0){			
			$result = $query->row_array();
			$weight .= $result['prod_weight'].',';
		}else{
			$this->cart->destroy();
			$thecontent = '';
		}			
	}
	$weight = rtrim($weight, ',');
	$weight = explode(',', $weight);

	//print_r($bg);
?>
	<div class="container-fluid" style="padding:0;">
		<div class="alert alert-error" style="display:none;">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong>Please use numeric character only!!</strong>
		</div>
		<h2>Shopping Cart (<?php echo array_sum($weight).' kg'; ?>)</h2>
		<table class="table table-bordered">
			<thead style="background: <?php echo $bg->menu_bgcolor; ?>;">
				<tr>
					<th>Product Id</th>
					<th>Product Name</th>
					<th>Quantity</th>
					<th>Unit Price</th>
					<th>Sub Total</th>
					<td>Command</td>
				</tr>	
			</thead>
			<?php echo empty($thecontent) ? '<tr style="background:'.$bg->boxcolor.';border: 1px solid #B4B3B3;border-top: none;"><td colspan="6" align="center">Your shopping cart is empty.</td></tr>' : ''; ?>
			<tbody>
				<?php
				foreach($this->cart->contents() as $items){					
					$this->db->where('id',$items['id']);
					$query2 = $this->db->get('products');
					$result2 = $query2->row_array();
				?>
				<tr style="background: <?php echo $bg->boxcolor; ?>;border: 1px solid #B4B3B3;border-top: none;" id="<?php echo $items['id']; ?>">
					<td style="padding-bottom: 5px;">000<?php echo $items['id']; ?></td>
					<td>
						<?php echo $items['name']; ?><br/>
						<?php
							if ($this->cart->has_options($items['rowid']) == TRUE)
							{
								$option = $this->cart->product_options($items['rowid']);
								{
									echo '-'.$option['v_name'];
								}
							}
						?>
					</td>
					<td>
						<input style="max-width: 22px;" type="text" class="" id="item_<?php echo $items['id']; ?>" value="<?php echo $items['qty']; ?>" />
						<!-- plus minus -->
					</td>
					<td>Php <?php echo $this->cart->format_number($items['price']); ?></td>
					<td>Php <?php echo $this->cart->format_number($items['subtotal']); ?></td>
					<td>
						<span><a href="#" id="<?php echo $items['rowid']; ?>" class="update_cart" alt="<?php echo $items['id']; ?>" rel="tooltip" title="Update"><i class="icon-refresh"></i></a></span>
						<span><a class="remove_item" href="#del_item_prompt" rel="tooltip" title="Remove this item" data-toggle="modal"><i class="icon-remove"></i></a></span>
					</td>
				</tr>
				<?php
				}
				?>
			</tbody>
		</table>

		<div class="span12" style="margin-top:20px;background: <?php echo $bg->boxcolor; ?>;border: 1px solid #B4B3B3;margin-left:0;padding-top: 5px;padding-bottom: 5px;text-align: right;">
			<table class="pull-right" style="position:relative;margin-right: 12px;">
			<tr>
				<td><strong>Total:</strong></td>
				<td> <?php echo $this->cart->total() ? 'Php'.$this->cart->format_number($this->cart->total()) : ''; ?></td>
			</tr>
			</table>
		</div>
		<div class="span12" style="border-top: none;background: <?php echo $bg->boxcolor; ?>;border: 1px solid #B4B3B3;margin-left:0;padding-top: 5px;padding-bottom: 5px;text-align: right;">
			<ul style="list-style: none;">
				<li style="display: inline;"><a class="btn btn-warning btn-style conshop" href="<?php echo base_url().$web_url; ?>">Continue Shopping</a></li>
				<li style="display: inline;"><a href="<?php echo base_url().'cart?t=checkout&s='.$url; ?>" class="btn btn-warning btn-medium" style="margin-right: 12px;">Checkout</a></li>
			</ul>			
		</div>
	</div>
	<!-- Modal Purchase -->
	<div id="puchase_comp" class="modal hide fade" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="background: none repeat scroll 0 0 rgba(255, 255, 255, 0.8);font-family: Segoe UI;border-radius: 0px;">
		<div class="modal-header" style="background: none repeat scroll 0 0 #F26A2C;border-bottom: medium none;color: white;">		
			<h3 id="myModalLabel" style="font-weight: normal;">Order Complete</h3>
		</div>
		<div class="modal-body" style="text-align: center;">
			<div class="row-fluid" id="inform_buyer">
				<h6>Your order has been successfully processed!</h6>
				<h6>You may also check your email to view your order!</h6>
				<h6>Please direct any questions you have to the <a target="_blank" href="javascript:(void)">store owner</a>.</h6>

				<h6>Thanks for shopping with us online!</h6>
			</div>
		</div>
		<div class="modal-footer" style="background: none repeat scroll 0 0 rgba(255, 255, 255, 0);border: medium none;box-shadow: none;">
			<a class="btn btn-style conshop" href="<?php echo base_url().$web_url; ?>">Continue Shopping</a>
		</div>
	</div>
	<!-- Modal Delete Item -->
<div id="del_item_prompt" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="background: none repeat scroll 0 0 rgba(255, 255, 255, 0.8);font-family: Segoe UI;border-radius: 0px;">
  <div class="modal-header" style="background: none repeat scroll 0 0 #F26A2C;border-bottom: medium none;color: white;">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-white"></i></button>
    <h3 style="font-weight: normal;">Delete Product</h3>
  </div>
  <div class="modal-body">
		<p>Do you want to delete the product?</p>
  </div>
  <div class="modal-footer" style="background: none repeat scroll 0 0 rgba(255, 255, 255, 0);border: medium none;box-shadow: none;">    
		<a href="#" class="btn" data-dismiss="modal" aria-hidden="true">No</a>
		<a href="#" id="accept_remove" class="btn btn-warning">Yes</a>
  </div>
</div>	

<script type="text/javascript">
$(function(){
	$('a[rel="tooltip"]').tooltip();
<?php
	if($carttype == 'success'){
?>
	$('#puchase_comp').modal('show');
<?php
	}
?>

	$('.remove_item').click(function(e) {
		// console.log($(e.target).parents('tr').attr('id'));
		sessionStorage.item = $(e.target).parents('tr').attr('id');
	});
	$('#accept_remove').click(function(e) {
		prid = sessionStorage.item;
		$.ajax({
			type: 'post',
			url: '<?php echo base_url(); ?>multi/removecart',
			data: {'prod_id':prid},
			success: function(html)
			{
				$('#del_item_prompt').modal('hide');
				$('#'+prid).fadeOut();
			}
		});	
	});
});

	$('.update_cart').on('click',function(){
		var dis = $(this);
		var prodid = $(this).attr('alt');
		var cartid = $(this).attr('id');
		var value = $('#item_'+prodid).val();
		
		updateqty(dis,prodid,cartid,value);
	});
	
	function updateqty(x, prodid, cartid, value)
	{
		var el = '';
		var datastr = 'value='+value+'&prod_id='+prodid+'&cartid='+cartid;
		//alert(datastr);
		if(isNaN(value))
		{
			//alert('n');
			el = '<button type="button" class="close" data-dismiss="alert">&times;</button>';
			el += '<strong>Please use numeric character only!!</strong>';
			
			$('.alert-error').html(el);
			$('.alert-error').show();
			$('#item_'+prodid).addClass('error');
			setTimeout(function(){
				$('.alert-error').hide();
			}, 3000);
		}
		else
		{
			if(value == 0)
			{
				el = '<button type="button" class="close" data-dismiss="alert">&times;</button>';
				el += '<strong>Please use a valid number!!</strong>';
				
				$('.alert-error').html(el);
				$('.alert-error').show();
				$('#item_'+prodid).addClass('error');
				setTimeout(function(){
					$('.alert-error').hide();
				}, 3000);
				
			}else
			{
				$('.alert-error').hide();
				$('#item_'+prodid).removeClass('error');
				//alert('y');
				$.ajax({
					type: 'post',
					url: '<?php echo base_url(); ?>multi/updatecart',
					data: datastr,
					success: function(html)
					{
						if(html == 'exceeded')
						{
							el = '<button type="button" class="close" data-dismiss="alert">&times;</button>';
							el += '<strong>Stocks exceeded!!</strong>';
							
							$('.alert-error').html(el);
							$('.alert-error').show();
							$('#item_'+prodid).addClass('error');
							setTimeout(function(){
								$('.alert-error').hide();
							}, 3000);
						}else
						{
							window.location.reload(true);
						}
					}
				});
			}
		}
	}


</script>