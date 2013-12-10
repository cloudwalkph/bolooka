<?php
	$query = $this->db->query("SELECT * FROM confirm_orders ORDER BY id DESC");
	$if_yours = false;
	$if_me = array();
	$pr_weight = Array();
	$overall = Array();
?>
<div class="container-fluid">
		<table class="table table-striped table-condensed table-bordered">
		<caption>Total No. of Sold Product(s): <strong class="total_pr"></strong></caption>
		<thead>
			<tr>
				<th>#</th>
				<th>date added</th>
				<th>txn #</th>				
				<th colspan="3">Product</th>
				<th colspan="2">seller</th>
				<th colspan="2">costumer</th>
				<th colspan="2">status</th>				
				<th colspan="4">amount</th>
			</tr>
			<tr>
				<th></th>
				<th></th>
				<th></th>
				<th>Name</th>
				<th>Quantity</th>
				<th>Unit Price</th>
				<th>Name</th>
				<th>Website</th>
				<th>Name</th>
				<th>Contact</th>
				<th>shipped</th>
				<th>received</th>
				<th>Floating</th>
				<th>shipping fee</th>
				<th>Transaction Fee</th>
				<th>Real</th>
			</tr>
		</thead>
		<tbody>
<?php
	$countpr = array();
	foreach($query->result_array() as $rows){
		$prd_ary = $rows['prod_array'];
		$prd_ary = rtrim($prd_ary, ',');
		$prd_ary   = explode(',',$prd_ary);
		$total_pr = count($prd_ary);
		$txn = $rows['txn_id'];
		$email_cs = $rows['costumers_email'];
		$this->db->where('email', $email_cs);
		$getcostumer = $this->db->get('costumer');
		$cos_res = $getcostumer->row_array();
		$this->db->where('txn_id', $txn);
		$getgross = $this->db->get('transactions');
		$gross_res = $getgross->row_array();
		$$txn = 0;
		 
		foreach($prd_ary as $prd_info2)
		{
			$prd_id = substr($prd_info2, 0, strrpos( $prd_info2, '-' ));
			$length = strlen($prd_info2);
			$pos_of_dash = strrpos( $prd_info2, '-' ) + 1;
			$position = $length - $pos_of_dash;
			$qty = substr($prd_info2, -$position);
			$countpr[] = $prd_id;
			$get_the_product = $this->db->query("SELECT * FROM products WHERE id='$prd_id'");
			if($get_the_product->num_rows() > 0)
			{
				foreach($get_the_product->result_array() as $prduct)
				{
					$web_id = $prduct['website_id'];
					$namep = $prduct['name'];
					$pricep = $prduct['price'];
					$pr_weight = $prduct['prod_weight'];
					$this->db->where('id', $web_id);
					$this->db->where('deleted', 0);
					$getweb = $this->db->get('websites');
					// if($getweb->num_rows() > 0) {
						$webres = $getweb->row_array();
						
						$this->db->where('uid', $webres['user_id']);
						$getuser = $this->db->get('users');
						$userres = $getuser->row_array();
					// }
	
				}//end foreach
				
				$pr_amount = $qty * $pricep;
?>
			<tr style="background:#F9F9F9;">	
				<td><?php echo $$txn == 0 ? $rows['id'] : ''; ?></td>
				<td><?php echo $$txn == 0 ? date('m-d-Y',$rows['date_confirmed']) : ''; ?></td>
				<td><?php echo $$txn == 0 ? $rows['txn_id'] : ''; ?></td>
				<td><?php echo $namep; ?></td>
				<td><?php echo $qty . ' ' . $web_id; ?></td>
				<td> P<?php echo number_format($pricep, 2); ?></td>
				<td><?php echo $userres['first_name'].' '.$userres['last_name']; ?></td>
				<td><?php echo $webres['site_name']; ?></td>
				<td><?php echo $$txn == 0 ? $cos_res['fname'].' '.$cos_res['lname'] : ''; ?></td>
				<td></td>
				<td><?php echo $$txn == 0 ? $rows['delivery_status'] : ''; ?></td>
				<td><?php echo $$txn == 0 ? $rows['received'] == 1 ? 'Yes' : 'No' : ''; ?></td>
				<td> <?php echo $$txn == 0 ? 'P'.$gross_res['mc_gross'] : ''; ?></td>
				<td><?php echo $$txn == 0 ? $rows['del_method'] : ''; ?></td>
				<td><?php echo $$txn; ?></td>
				<td></td>
			</tr>
<?php				
				
			}
			if($total_pr == $$txn + 1)
			{
?>
			<tr>	
				<td style="height: 14px;background:#fff;"></td>
				<td style="background:#fff;"></td>
				<td style="background:#fff;"></td>
				<td style="background:#fff;"></td>
				<td style="background:#fff;"></td>
				<td style="background:#fff;"></td>
				<td style="background:#fff;"></td>
				<td style="background:#fff;"></td>
				<td style="background:#fff;"></td>
				<td style="background:#fff;"></td>
				<td style="background:#fff;"></td>
				<td style="background:#fff;"></td>
				<td style="background:#fff;"></td>
				<td style="background:#fff;"></td>
				<td style="background:#fff;"></td>
				<td style="background:#fff;"></td>
			</tr>
<?php
			}
			$$txn++;
		}//end foreach
		
	}
	$total_pr = count($countpr);
?>
		</tbody>
	</table>
	</div>
<script type="text/javascript">
$(function(){
	$('.total_pr').html('<?php echo $total_pr; ?>');
});
</script>