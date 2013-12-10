<div class="row-fluid" style="font-size: 11px;">
	<table style="width:100%;text-align:center;">
		<tr style="background: #898989;color: white;">
			<td style="padding-bottom: 10px;padding-top: 10px;">Payment Method</td>
			<td style="padding-bottom: 10px;padding-top: 10px;">Payment Status</td>
			<td style="padding-bottom: 10px;padding-top: 10px;">Delivery Mode</td>
			<td style="padding-bottom: 10px;padding-top: 10px;">Delivery Status</td>
			<td style="padding-bottom: 10px;padding-top: 10px;">Received</td>
		</tr>
<?php
	$query = $this->db->query("SELECT * FROM confirm_orders WHERE txn_id='$txn_id'");
	$if_xend = false;
	if($query->num_rows() > 0)
	{
		$result = $query->row_array();
		$del_com = $result['del_com'];
		$pay_com = $result['pay_com'];
		$waybills = $result['waybill'];
		$books = $result['booking'];
		
		if($result['del_method'] == 'xend')
		{
			$if_xend = true;
		}
		
?>
		<tr>
			<td style="padding-top: 7px;">
				<?php 
					$payopt = $result['payopt']; 
					switch ($payopt)
					{
						case 'cod':
							echo 'Cash On Delivery';
						break;
						case 'dp':
							echo 'Dragon Pay';
						break;
						case 'pp':
							echo 'Paypal';
						break;
					}
				?>
			</td>
			<td style="padding-top: 7px;">
				<select class="pay_status<?php echo $txn_id; ?>" style="max-width: 119px;font-size: 11px;" <?php echo $result['payment_status'] == 'Paid' ? 'disabled="disabled"' : ''; ?>>					
					<option value="">--Select Status--</option>
					<option value="Paid" <?php echo $result['payment_status'] == 'Paid' ? 'Selected="selected"' : ''; ?>>Paid</option>
					<option value="Pending" <?php echo $result['payment_status'] == 'Pending' ? 'Selected="selected"' : ''; ?>>Pending</option>
					<option value="For Verification" <?php echo $result['payment_status'] == 'For Verification' ? 'Selected="selected"' : ''; ?>>For Verification</option>
				</select>
			</td>
			<td style="padding-top: 7px;"><?php echo $result['del_method']; ?></td>
			<td style="padding-top: 7px;">
				<select class="del_status<?php echo $txn_id; ?>" style="max-width: 107px;font-size: 11px;" <?php echo $result['delivery_status'] == 'Shipped' ? 'disabled="disabled"' : ''; ?>>					
					<option value="">--Select Status--</option>
					<option value="Shipped" <?php echo $result['delivery_status'] == 'Shipped' ? 'Selected="selected"' : ''; ?>>Shipped</option>
					<option value="Pending" <?php echo $result['delivery_status'] == 'Pending' ? 'Selected="selected"' : ''; ?>>Pending</option>
				</select>
			</td>
			<td style="padding-top: 7px;"><?php echo $result['received'] == 1 ? 'Received' : 'Not Received'; ?></td>
		</tr>
<?php		
	}
?>
	</table>
<h6>Delivery Comment</h6>
<p class="offset1"><?php echo !empty($del_com) ? $del_com : 'No Comment'; ?></p>
<h6>Payment Comment</h6>
<p class="offset1"><?php echo !empty($pay_com) ? $pay_com : 'No Comment'; ?></p>
<?php
		if($if_xend)
		{
?>
<div class="accordion" id="accordion2">
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne" style="padding: 0px 15px;">
        Create Shipping Address
      </a>
    </div>
    <div id="collapseOne" class="accordion-body collapse">
      <div class="accordion-inner">
		<div class="shipping-info">
		<?php
			if($waybills)
			{
				echo '<p style="text-align:center;">Waybill Number: '.$waybills.'</p>';
			}
			else
			{
		?>
			<form class="form-horizontal">
			<div class="control-group">
				<label class="control-label">Service Type</label>
				<div class="controls">
					<select class="xendservice">
						<option value="MetroManilaExpress">MetroManilaExpress</option>
						<option value="ProvincialExpress">ProvincialExpress</option>
						<option value="InternationalPostal">InternationalPostal</option>
						<option value="InternationalEMS">InternationalEMS</option>
						<option value="InternationalExpress">InternationalExpress</option>
						<option value="RizalMetroManilaExpress">RizalMetroManilaExpress</option>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Description</label>
				<div class="controls">
					<textarea class="xendesc"></textarea>
				</div>
			</div>
			<div class="control-group">
				<div class="controls">
					<a class="btn btn-primary c-shipping">Create Shipping</a>
				</div>
			</div>
			</form>
			
		<?php
			}
		?>
      </div>
      </div>
    </div>
  </div>
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo" style="padding: 0px 15px;">
        Create Schedule Booking
      </a>
    </div>
    <div id="collapseTwo" class="accordion-body collapse">
      <div class="accordion-inner">
		<?php 
			$tommorrow = date("M-d-Y", strtotime("tomorrow"));
			$torecord1 = date("m/d/Y", strtotime("tomorrow"));
			$past2days = date("M-d-Y", strtotime("+2 days"));
			$torecord2 = date("m/d/Y", strtotime("tomorrow"));
			$past3days = date("M-d-Y", strtotime("+3 days"));
			$torecord3 = date("m/d/Y", strtotime("tomorrow"));
			$past4days = date("M-d-Y", strtotime("+4 days"));
			$torecord4 = date("m/d/Y", strtotime("tomorrow"));
			$past5days = date("M-d-Y", strtotime("+5 days"));
			$torecord5 = date("m/d/Y", strtotime("tomorrow"));
			$past6days = date("M-d-Y", strtotime("+6 days"));
			$torecord6 = date("m/d/Y", strtotime("tomorrow"));
			
			if($books)
			{
				echo '<p style="text-align:center;">Booking Number: '.$books.'</p>';
			}
			else
			{
		?>
		<div class="bookinginfos">
			<form class="form-horizontal">
				<div class="control-group">
					<label class="control-label">Booking Date</label>
					<div class="controls">
						<select class="datebooking">
							<?php echo '<option value="'.date('Y-m-d\TH\:i\:s\.u', strtotime($torecord1)).'">'.$tommorrow.'</option>'; ?>
							<?php echo '<option value="'.date('Y-m-d\TH\:i\:s\.u', strtotime($torecord2)).'">'.$past2days.'</option>'; ?>
							<?php echo '<option value="'.date('Y-m-d\TH\:i\:s\.u', strtotime($torecord3)).'">'.$past3days.'</option>'; ?>
							<?php echo '<option value="'.date('Y-m-d\TH\:i\:s\.u', strtotime($torecord4)).'">'.$past4days.'</option>'; ?>
							<?php echo '<option value="'.date('Y-m-d\TH\:i\:s\.u', strtotime($torecord5)).'">'.$past5days.'</option>'; ?>
							<?php echo '<option value="'.date('Y-m-d\TH\:i\:s\.u', strtotime($torecord6)).'">'.$past6days.'</option>'; ?>
						</select>
					</div>
				</div>
				<div class="control-group bfname bookingform">
					<label class="control-label">First Name*</label>
					<div class="controls">
						<input type="text" id="bookfname" />
						<span class="help-inline">Required</span>
					</div>
				</div>
				<div class="control-group blname bookingform">
					<label class="control-label">Last Name*</label>
					<div class="controls">
						<input type="text" id="booklname" />
						<span class="help-inline">Required</span>
					</div>
				</div>
				<div class="control-group badd1 bookingform">
					<label class="control-label">Address 1*</label>
					<div class="controls">
						<input type="text" id="bookadd1" />
						<span class="help-inline">Required</span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Address 2</label>
					<div class="controls">
						<input type="text" id="bookadd2" />
					</div>
				</div>
				<div class="control-group bcity bookingform">
					<label class="control-label">City*</label>
					<div class="controls">
						<input type="text" id="bookcity" />
						<span class="help-inline">Required</span>
					</div>
				</div>
				<div class="control-group bprovince bookingform">
					<label class="control-label">Province*</label>
					<div class="controls">
						<input type="text" id="bookprov" />
						<span class="help-inline">Required</span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Postal Code</label>
					<div class="controls">
						<input type="text" id="bookpostal" />
					</div>
				</div>
				<div class="control-group blandmark bookingform">
					<label class="control-label">Landmark*</label>
					<div class="controls">
						<input type="text" id="bookland" />
						<span class="help-inline">Required</span>
					</div>
				</div>
				<div class="control-group brem bookingform">
					<label class="control-label">Remarks*</label>
					<div class="controls">
						<input type="text" id="remarks" />
						<span class="help-inline">Required</span>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<a class="btn btn-primary c-booking">Create Booking</a>
					</div>
				</div>
			</form>
		</div>
		<?php
			}
		?>
      </div>
    </div>
  </div>
</div>
<?php
		}
?>
</div>
<script type="text/javascript">
	$('.c-shipping').click(function(){
		var xendservice = $('.xendservice').val();
		var description = $('.xendesc').val();
		var datashipping = 'description='+description+'&xendservice='+xendservice+'&txnid=<?php echo $txn_id; ?>';
		$('.shipping-info').empty();
		$('.shipping-info').html('<p style="text-align:center;">Please wait...<br/><img src="<?php echo base_url(); ?>img/add.gif" /></p>');
		$.ajax({
			type: 'POST',
			url: '<?php echo base_url(); ?>multi/xendcreate',
			data: datashipping,
			success: function(html)
			{
				$('.shipping-info').empty();
				$('.shipping-info').html('<p style="text-align:center;">Waybill Number: '+html+'</p>');
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
	});
	$('.c-booking').click(function(){
		var bookdate = $('.datebooking').val();
		var bookfname = $('#bookfname').val();
		var booklname = $('#booklname').val();
		var bookadd1 = $('#bookadd1').val();
		var bookadd2 = $('#bookadd2').val();
		var bookcity = $('#bookcity').val();
		var bookprov = $('#bookprov').val();
		var bookpostal = $('#bookpostal').val();
		var bookland = $('#bookland').val();
		var remarks = $('#remarks').val();
		var databook = 'remarks='+remarks+'&bookdate='+bookdate+'&bookfname='+bookfname+'&booklname='+booklname+'&bookadd1='+bookadd1+'&bookadd2='+bookadd2+'&bookcity='+bookcity+'&bookprov='+bookprov+'&bookpostal='+bookpostal+'&bookland='+bookland;
		if(remarks == '' || bookfname == '' || booklname == '' || bookadd1 == '' || bookcity == '' || bookprov == '' || bookland == '')
		{
			$('.bookingform').removeClass('error');
			$('.control-group .help-inline').hide();
			if(remarks == '')
			{
				$('.brem').addClass('error');
				$('.brem .help-inline').show();
			}
			
			if(bookfname == '')
			{
				$('.bfname').addClass('error');
				$('.bfname .help-inline').show();
			}
			
			if(booklname == '')
			{
				$('.blname').addClass('error');
				$('.blname .help-inline').show();
			}
			
			if(bookadd1 == '')
			{
				$('.badd1').addClass('error');
				$('.badd1 .help-inline').show();
			}
			
			if(bookcity == '')
			{
				$('.bcity').addClass('error');
				$('.bcity .help-inline').show();
			}
			
			if(bookprov == '')
			{
				$('.bprovince').addClass('error');
				$('.bprovince .help-inline').show();
			}
			
			if(bookland == '')
			{
				$('.blandmark').addClass('error');
				$('.blandmark .help-inline').show();
			}
			
		}
		else
		{
			$('.bookinginfos').empty();
			$('.bookinginfos').html('<p style="text-align:center;">Please wait...<br/><img src="<?php echo base_url(); ?>img/add.gif" /></p>');
			$('.bookingform').removeClass('error');
			$('.control-group .help-inline').hide();
			$.ajax({
				type: 'post',
				url: '<?php echo base_url(); ?>multi/xendbook',
				data: databook,
				success: function(html)
				{
					$('.bookinginfos').empty();
					$('.bookinginfos').html('<p style="text-align:center;">Booking Number: '+html+'</p>');
					$.ajax({
						type: 'POST',
						url: '<?php echo base_url(); ?>multi/xendcreatebook',
						data: 'booknum='+html+'&txnid=<?php echo $txn_id; ?>',
						success: function(html2)
						{
							
						}
					});
				}
			});
		}
	});
</script>
<style type="text/css">
.control-group .help-inline
{
	display:none;
}
</style>