<?php
	date_default_timezone_set('Asia/Manila');

	$query = $this->db->query("SELECT * FROM transactions WHERE txn_id='$txn_id'");
	$result = $query->row_array();
	$prd_ary = $result['product_id_array'];
	$prd_ary = rtrim($prd_ary, ',');
	$prd_ary   = explode(',',$prd_ary);
	
	$payer_email = $result['payer_email'];
	$cos_query2 = $this->db->query("SELECT * FROM confirm_orders WHERE txn_id='$txn_id'");
	$thisresult = $cos_query2->row_array();
	$cos_email = $thisresult['costumers_email'];
	$cos_query = $this->db->query("SELECT * FROM costumer WHERE email='$cos_email' ORDER BY id DESC");
	$costumer_result = $cos_query->row_array();
	
	/* Get websites id */
	$website_arr = array();
	foreach($prd_ary as $prd_info)
	{
		$prd_id = substr($prd_info, 0, strrpos( $prd_info, '-' ));
		$length = strlen($prd_info);
		$pos_of_dash = strrpos( $prd_info, '-' ) + 1;
		$position = $length - $pos_of_dash;
		$qty = substr($prd_info, -$position);
		$get_product = $this->db->query("SELECT * FROM products WHERE id='$prd_id'");
		if($get_product->num_rows() > 0)
		{
			foreach($get_product->result_array() as $product)
			{
				$web_id2 = $product['website_id'];
				if(!in_array($web_id2,$website_arr))
				{
					$website_arr[] = $web_id2;
				}
			}
		}
	}
foreach($website_arr as $key => $value)
{
	$get_the_website2 = $this->db->query("SELECT * FROM websites WHERE id='$value'");
	if($get_the_website2->num_rows() > 0)
	{
		$resultsweb = $get_the_website2->row_array();
		$store_name = $resultsweb['site_name'];
	}
	else
	{
		$store_name = $value;
	}
?>
<div class="load-part">
</div>
<div class="or-slip" style="display:none;">
<h4 style="margin-bottom: 22px;"><?php echo $store_name; ?></h4>
<table cellspacing="0" cellpadding="0" style="width:90%;margin:0 auto;color:#585858;background:#fff;margin-bottom:10px;border-top:2px solid #fcac87;border-bottom:2px solid #fcac87;">
<tr>
	<td style="padding: 20px 0 20px 25px;">
		<p class="remove-margin">Name: <strong><?php echo isset($costumer_result['fname']) ? $costumer_result['fname'].' '.$costumer_result['lname'] : ''; ?></strong></p>
		<p class="remove-margin">Address 1: <strong><?php echo isset($costumer_result['address1']) ? $costumer_result['address1'].' '.$costumer_result['city'] : ''; ?></strong></p>
		<p class="remove-margin">Address 2: <strong><?php echo isset($costumer_result['address2']) ? $costumer_result['address2'].' '.$costumer_result['city'] : ''; ?></strong></p>
		<p class="remove-margin">Postal: <strong><?php echo isset($costumer_result['postal']) ? $costumer_result['postal'] : ''; ?><strong></p>
	</td>
	<td style="padding: 20px 0 20px 25px;">
		<p class="remove-margin">Shipping: <strong><?php echo isset($thisresult['del_method']) ? $thisresult['del_method'] : ''; ?></strong></p>
		<p class="waybillarea remove-margin">Waybill Number: <strong><?php echo isset($thisresult['waybill']) ? $thisresult['waybill'] : ''; ?></strong></p>
		<p class="remove-margin">TXN No.: <strong><span style="text-decoration:underline;color: #959595;"><?php echo $txn_id; ?></span></strong></p>
		<p class="remove-margin">Date: <strong>
		<?php 
			if(($result['payment_type'] == 'cod') or ($result['payment_type'] == 'dp'))
			{
				echo date('M j, Y', $result['payment_date']); 
			}
			else
			{
				echo $result['payment_date']; 
			}	
		?></strong>
		</p>
	</td>
</tr>
</table>
<table style="text-align: center;width: 100%;">
	<tr style="color:#585858;">
		<td style="padding: 10px 0px;">Item #</td>
		<td style="padding: 10px 0px;">Item Name</td>
		<td style="padding: 10px 0px;">Quantity</td>
		<td style="padding: 10px 0px;">Unit Price</td>
		<td style="padding: 10px 0px;">Amount</td>
	</tr>
<?php 		
	$ttlamount = Array();
	$pr_weight = Array();
	foreach($prd_ary as $prd_info)
	{
		$prd_id = substr($prd_info, 0, strrpos( $prd_info, '-' ));
		$length = strlen($prd_info);
		$pos_of_dash = strrpos( $prd_info, '-' ) + 1;
		$position = $length - $pos_of_dash;
		$qty = substr($prd_info, -$position);
		$get_product = $this->db->query("SELECT * FROM products WHERE id='$prd_id'");
		
		if($get_product->num_rows() > 0)
		{
			foreach($get_product->result_array() as $product)
			{
				$web_id2 = $product['website_id'];
				$pr_weight[] = $product['prod_weight'];
?>
		<tr style="color:#585858;background:#fff;margin-bottom:10px;border-top:1px solid #fcac87;border-bottom:1px solid #fcac87;">
			<td style="padding: 12px 0px;"><?php echo str_pad($product['id'], 8, '0', STR_PAD_LEFT); ?></td>
			<td style="padding: 12px 0px;"><?php echo $product['name']; ?></td>
			<td style="padding: 12px 0px;"><?php echo $qty; ?></td>
			<td style="padding: 12px 0px;">P<?php echo number_format($product['price'],2); ?> Php</td>
			<td style="padding: 12px 0px;">P<?php echo number_format($qty * $product['price'],2); ?> Php</td>
		</tr>
	
<?php
				$ttlamount[] = $qty * $product['price'];
			}
		}
	}
		$theship = 0;
		$pr_weight_ttl = array_sum($pr_weight);
		$trans_fee = array_sum($ttlamount) * 0.1;
		$subtotal = array_sum($ttlamount) - $trans_fee;		
		$cost_array = array();
		if($thisresult['ship_delivery']){
			$delship = $thisresult['ship_delivery']; 
			switch($delship){
				case 'metro':
					$cost_array[0] = 44;
					$cost_array[1] = 58;
					$cost_array[2] = 75;
					$cost_array[3] = 81;
					$cost_array[4] = 99;
					$cost_array[5] = 103;
					$cost_array[6] = 22;
				break;
				case 'luz':
					$cost_array[0] = 0;
					$cost_array[1] = 71;
					$cost_array[2] = 0;
					$cost_array[3] = 115;
					$cost_array[4] = 0;
					$cost_array[5] = 179;
					$cost_array[6] = 53;
				break;
				case 'vismin':
					$cost_array[0] = 0;
					$cost_array[1] = 79;
					$cost_array[2] = 0;
					$cost_array[3] = 115;
					$cost_array[4] = 0;
					$cost_array[5] = 179;
					$cost_array[6] = 62;
				break;
			}
			if($pr_weight_ttl > 3)
			{
				$get_excess_weight = $pr_weight_ttl - 3;
				$subttl_excess_cost = $get_excess_weight * $cost_array[6];
				$total_cost = $subttl_excess_cost + $cost_array[5];
				$ship_cost = $total_cost;
			}
			else
			{
				switch ($pr_weight_ttl)
				{
					case 0.5:
						$ship_cost = $cost_array[0]; 
					break;
					case 1:
						$ship_cost = $cost_array[1]; 
					break;
					case 1.5:
						$ship_cost = $cost_array[2]; 
					break;
					case 2:
						$ship_cost = $cost_array[3]; 
					break;
					case 2.5:
						$ship_cost = $cost_array[4]; 
					break;
					case 3:
						$ship_cost = $cost_array[5]; 
					break;
				}
			}
			if($thisresult['del_method'] == 'xend')
			{
				$theship = $ship_cost;
			}
			else
			{
				$theship = 0;
			}
		}
		
?>
<!--
	<tr>
		<td colspan="3"></td>
		<td style="text-align: right;padding-right: 10px;">Subtotal:</td>
		<td style="background: white;">P<?php echo number_format($subtotal,2); ?> Php</td>
	</tr>
-->
	<tr>
		<td colspan="3"></td>
		<td style="text-align: right;padding-right: 10px;">Shipping Fee:</td>
		<td style="background: white;">P<?php echo number_format($theship,2); ?> Php</td>
	</tr>
<!--
	<tr>
		<td colspan="3"></td>
		<td style="text-align: right;padding-right: 10px;">Transaction Fee:</td>
		<td style="background: white;">P<?php echo number_format($trans_fee,2); ?> Php</td>
	</tr>
-->
	<tr>
		<td colspan=5></td>
	</tr>
	<tr>
		<td></td>
		<td></td>
		<td></td>
		<td style="text-align: right;padding-right: 10px;"><strong>Total:</strong></td>
		<td style="background: white;"><strong><?php echo number_format($trans_fee + $theship + $subtotal,2); ?> Php</strong></td>
	</tr>
</table>
</div>
<?php
}
?>
<script type="text/javascript">
	$(document).ready(function(){
	<?php
		if(isset($thisresult['waybill']) && $thisresult['waybill'] != '')
		{
	?>
		$('.or-slip').show();
	<?php
		}
		else
		{
	?>
		$('.load-part').html('<p style="text-align:center;">Please wait...<br/><img src="<?php echo base_url(); ?>img/add.gif" /></p>');
		$.ajax({
			type: 'POST',
			url: '<?php echo base_url(); ?>multi/xendcreate',
			data: 'description=billingdetails&xendservice=MetroManilaExpress&txnid=<?php echo $txn_id; ?>',
			success: function(html)
			{
				$('.load-part').empty();
				$('.or-slip').show();
				$('.waybillarea').html('<strong>Waybill Number:</strong> '+html);
				$.ajax({
					type: 'POST',
					url: '<?php echo base_url(); ?>multi/xendcreatewaybill',
					data: 'waybill='+html+'&txnid=<?php echo $txn_id; ?>',
					success: function(html2)
					{
						
					}
				});
			}
		});
	<?php
		}
	?>
	});
</script>