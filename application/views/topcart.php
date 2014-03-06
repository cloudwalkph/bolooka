<style>
.item-holder {
    background-color: #373737;
    border-radius: 7px 7px 7px 7px;
    color: #FFFFFF;
    display: table;
    font-family: Segoe UI;
    font-size: 15px;
    padding: 4px 10px;
    width: 90%;
}
.cart-item {
	display: table-cell;
}
</style>
<?php
	$thecart = $this->cart->contents();
?>
		<legend style="font-family: Segoe UI Light; font-size: 14px; color: rgb(255, 255, 255);">Shopping Cart <span class="pull-right"><?php echo $this->cart->total() == 0 ? 'empty' : '( ' . count($thecart) . ' item(s) )'; ?></span></legend>
<?php 
	if(!empty($thecart))
	{
?>
		<div style="margin-bottom: 10px;">
		<?php
		foreach($this->cart->contents() as $items)
		{
			$product_id = $items['id'];
			$getdesc = $this->db->query("SELECT * FROM products WHERE `id`='$product_id'");
			$result = $getdesc->row_array();
			
?>
			<div class="item-holder">
				<div class="cart-item"><?php echo isset($items['name']) ? $items['name'] : 'no items'; ?></div>
				<div class="cart-item">x<?php echo $items['qty']; ?></div>
				<div class="cart-item">Php <?php echo $this->cart->format_number($items['price']); ?></div>
				<div class="cart-item">
					<a href="#"><i alt="<?php echo $items['id']; ?>" class="icon-remove remove-item icon-white"></i></a>
				</div>
			</div>
<?php
		}
?>
		</div>
<?php
		$total = $this->cart->total();
	}
?>
		<table>
			<tr>
				<td style="width: 60%; text-align: right; font-family: Segoe UI; font-size: 13px;">Total: </td>
				<td style="width: 40%; text-align: right;">Php <?php echo isset($total) ? $this->cart->format_number($total) : '0.00'; ?></td>
			</tr>
			<tr>
				<td>
					<a class="btn btn-inverse" href="<?php echo base_url().'cart?t=yourcart&s='.$url; ?>" style="font-family: Segoe UI Bold; color: rgb(255, 255, 255); font-size: 13.5px; text-transform: uppercase;">View Cart</a>
				</td>
				<td>
					<a class="btn btn-inverse" href="<?php echo base_url().'cart?t=checkout&s='.$url; ?>" style="font-family: Segoe UI Bold; color: rgb(255, 255, 255); font-size: 13.5px; text-transform: uppercase;">Checkout</a>
				</td>
			</tr>
		</table>