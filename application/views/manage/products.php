<?php
	$queProds = $this->db->get('products');
?>
<table>
	<tr>
		<th>Image</th>
		<th>Name</th>
		<th>Category</th>
		<th>Price</th>
		<th>Stocks</th>
		<th>Published</th>
	</td>
<?php
	foreach($queProds->result_array() as $prods)
	{
		if($this->db->field_exists('product_cover', 'products')) {
			$cover = $prods['product_cover'];
		} else {
			$cover = $prods['primary'];
		}
		echo "
			<tr>
				<td><img style='max-height: 50px;' src='".base_url()."uploads/".$cover."'></td>
				<td>".$prods['name']."</td>
				<td>".$prods['category']."</td>
				<td>".$prods['price']."</td>
				<td>".$prods['stocks']."</td>
				<td>".$prods['published']."</td>
			<tr>
		";
	}
?>
</table>