<?php date_default_timezone_set('Asia/Manila'); ?>
<?php
	if(isset($search))
	{
		if($search == 'all') {
			$querySearch = '';
		} else {
			$querySearch = ' AND category LIKE "'.$search.'"';
		}
	}
	else
	{
		if(isset($word_set))
		{
			$querySearch = ' AND (id LIKE "%'.ltrim($word_set, 0).'%" OR category LIKE "%'.$word_set.'%" OR name LIKE "%'.$word_set.'%" OR price LIKE "%'.str_replace(',','',$word_set).'%")';
		} else {
			$querySearch = '';
		}
	}
	
	$queryProducts = $this->db->query('SELECT * FROM `products` WHERE `website_id` = '.$wid.' AND `page_id` LIKE "'.$pid.'" AND `name` NOT LIKE "" '.$querySearch.' ORDER BY `id` DESC LIMIT 10');
	$queryProductsPagination = $this->db->query('SELECT * FROM `products` WHERE `website_id` = '.$wid.' AND `page_id` LIKE "'.$pid.'" AND `name` NOT LIKE "" '.$querySearch.' ORDER BY `id`');
?>
<style>
	.edit_product:hover {
		text-decoration: underline;
	}
	.thumb {
		height: 75px;
		border: 1px solid #000;
		margin: 10px 5px;
	}
	#item_prod_list select {
		margin-bottom: 0;
	}
</style>
	<div id="catalogue">
		<div class="container-fluid" style="border-bottom: 1px solid #DDD;padding-left: 0;padding-right: 0;">

				<div class="row-fluid hide_this_title">
					<div class="row-fluid">
						<legend style="font-family: 'Segoe UI bold'; font-size: 14px;">
							<span style="text-transform: uppercase;"> Your Catalog: </span>
							<span class="pull-right"> Total Products: <?php echo $queryProductsPagination->num_rows(); ?> </span>
						</legend>
					</div>
					<div class="row-fluid">
						<div class="span4">
							<div class="input-append">
								<input id="search_type_prod" type="text" onkeypress="keysearch(this)" placeholder="Search...">
								<button class="btn search_type_btn" type="button" onclick="search_prod(this);">Search</button>
							</div>
						</div>
						<div class="span3 offset1">
					<?php
						if($queryProducts->num_rows() > 0)
						{
					?>
							<div class="span12 btn-group">
								<select class="span12" name="prod_categ" id="prod_categ" onchange="select_prod(this)">
									<option>Sort By...</option>
									<option value="all">All</option>
								<?php 
									$queryCateg = $this->db->query('SELECT DISTINCT `category` FROM `products` WHERE `page_id` = "'.$pid.'" AND name NOT LIKE ""');
									if($queryCateg->num_rows() > 0)
									{
										foreach($queryCateg->result_array() as $categ)
										{
											
											$category = $categ['category'];
											echo '<option value="'.$category.'">'.$category.'</option>';
										}
									}
								?>
								</select>
							</div>	
					<?php
						}
						else if(isset($word_set))
						{
					?>
							<div class="span12 btn-group">
								<select class="span12" name="prod_categ" id="prod_categ" onchange="select_prod(this)">
									<option>Sort By...</option>
									<option value="all">All</option>
								<?php 
									$queryCateg = $this->db->query('SELECT DISTINCT `category` FROM `products` WHERE `page_id` = "'.$pid.'" AND name NOT LIKE ""');
									if($queryCateg->num_rows() > 0)
									{
										foreach($queryCateg->result_array() as $categ)
										{
											
											$category = $categ['category'];
											echo '<option value="'.$category.'">'.$category.'</option>';
										}
									}
								?>
								</select>
							</div>
					<?php		
						}
					?>
						</div>
						<div class="span4 text-right">
							<button id="add_product" class="btn btn-primary add_prod_btn" data-loading-text="+ add product" style="border-radius: 0;">+ add product</button>							
						</div>
					</div>
				</div>
				<div class="row-fluid asas" style="display: none;">
				</div>	
						
		</div>
		<div id="item_prod_list" style="cursor:auto;">	
	<?php
		if($queryProducts->num_rows() > 0)
		{
	?>
			<table class="table table-striped table-condensed">
              <thead style="background-color: rgb(0, 0, 0); color: rgb(255, 255, 255);">
                <tr>
				  <th> </th>
				  <th> PRODUCT NUMBER</th>
                  <th> PRODUCT NAME </th>
                  <th class="hidden-phone"> CATEGORY </th>
				  <th> </th>
                </tr>
              </thead>
              <tbody class="pagination_item_content">
<?php
		foreach($queryProducts->result_array() as $product)
		{
				if(isset($word_set))
				{
					$product['name'] = str_ireplace($word_set,'<mark>'.$word_set.'</mark>',$product['name']);
					$product['category'] = str_ireplace($word_set,'<mark>'.$word_set.'</mark>',$product['category']);
				}
				$p_image = '';
				if($this->db->field_exists('product_cover', 'products')) {
					if($product['product_cover'] != null)
					{
						$p_image = base_url().'uploads/' . $this->session->userdata('uid') . '/' . $wid . '/' . $pid . '/' . $product['id'] . '/medium/'. $product['product_cover'];
					}				
				} else {
					if($product['primary'] != null)
					{
						$p_image = base_url().'uploads/' . $this->session->userdata('uid') . '/' . $wid . '/' . $pid . '/' . $product['id'] . '/medium/'. $product['primary'];
					}
				}
				if($product['name'] != null)
				{
					$this->db->where('product_id',$product['id']);
					$queryProdImage = $this->db->get('products_images');
?>
					<tr id="<?php echo $product['id']; ?>" class="item_prod">
					  <td>
						<abbr title="Edit" style="border-bottom: none;"><i class="icon-cog edit_product" style="cursor: pointer;"></i></abbr>
						<abbr title="Delete" style="border-bottom: none;"><i class="icon-trash del_product" style="cursor: pointer;"></i></abbr>
					  </td>
					  <td>
						000<?php echo $product['id']; ?>
					  </td>
					  <td class="edit_product" style="cursor:pointer;">
						<a class="prod_imageview" alt="<?php echo $p_image; ?>" style="color: #000; text-decoration: none; cursor: pointer">
							<?php echo $product['name']; ?>
						</a>
						<div class="product_preview container" style="display:none;"></div>
					  </td>
					  <td class="hidden-phone"><?php echo $product['category']; ?></td>
					  <td style="width: 120px;">
						<select class="span12 pubunpub" name="pubunpub<?php echo $product['id']; ?>">
							<option value="1" <?php echo $product['published'] == 1 ? 'selected' : ' '; ?>> Published </option>
							<option value="0" <?php echo $product['published'] == 0 ? 'selected' : ' '; ?>> Unpublished </option>
						</select>
					  </td>
					</tr>
<?php
				}
		}
?>				
              </tbody>
            </table>		
<?php
		}
		else
		{
			if(!isset($word_set))
			{
?>
			<div class="row-fluid" style="margin-top: 20px;">
				<div class="span12" style="text-align: center;">You don&rsquo;t have any products.</div>
			</div>
<?php
			}else
			{
				echo '
			<div class="row-fluid" style="margin-top: 20px;">
				<div class="span12" style="text-align: center;">No Result.</div>
			</div>	
				';
			}
		}
?>	
<?php
	$num_of_rows = $queryProductsPagination->num_rows();
	$div_rows = $num_of_rows / 10;
	$converted_row = ceil($div_rows); 
	
	if($converted_row > 1)
	{
?>
	<input type="hidden" value="<?php echo $converted_row; ?>" id="total_pages<?php echo $pid; ?>">
	<div class="pagination pagination-centered">
		<input type="hidden" value="<?php echo isset($word_set) ? $word_set : ''; ?>" class="pagination_filter_search">
		<input type="hidden" value="<?php echo isset($search) ? $search : ''; ?>" class="pagination_filter_select">
		<ul>
			<li class="prev_page"><a style="cursor:pointer;">PREV</a></li>
			<li class="current_page active"><a style="cursor:pointer;font-weight:bold;font-size: 30px;">1</a></li>
			<li class="next_page"><a style="cursor:pointer;">NEXT</a></li>
			<li>
				<a style="padding: 0;border:0;">
					<select class="page_number span12" style="margin: 0;">
						<option value="0"></option>
					<?php
						for ($y=1; $y<=$converted_row; $y++)
						{
							echo '<option value="'.$y.'">'.$y.'</option>';
						}
					?>
					</select>
				</a>
			</li>
		</ul>
	</div>
<?php
	}
?>
	</div><!--item_prod_list closing tag-->
		<div style="clear: both;">
			<div style="margin: auto; width: 520px; display:none;">
				<div class="button" style="font-weight: bold; font-size: 16px; width: 500px; text-align: center; padding: 10px;"><span>Load More Products</span></div>
			</div>
		</div>
	</div>
	
<!-- Modals -->
	<input type="hidden" id="deleteId" />

	<div id="delete_product" class="modal hide fade">
		<div class="modal-header" style="background-color: #f26221; border-bottom:0;">
			<h4 style="color:#fff;margin: 5px 0;font-family: 'Segoe UI Semibold'; opacity: 0.7;">Delete Product?</h4>
		</div>
		<div class="modal-footer" style="background-color: #e34e0d;color: #fff;border-top:0;box-shadow: none;border-radius:0;">
			<a href="#" class="btn btn_color" data-dismiss="modal" onclick="delete_prod(this)"> Ok </a>
			<a href="#" class="btn btn_color" data-dismiss="modal"> Cancel </a>
		</div>
	</div>

<!-- -->
<style>
	.table.table-striped.table-condensed tr td {
		padding: 12px 5px 10px;
	}
</style>
<script>
$(document).ready(function(){
	$('a.prod_imageview').popover({
		placement: 'right',
		container: '.page',
		trigger: 'hover',
		html: true,
		content: function(e) {
			var imageSrc = $(this).attr('alt');
			if(imageSrc == '')
			{
				imageSrc = 'http://www.placehold.it/150x150/EFEFEF/AAAAAA&text=no+image';
			}
			$(this).parent().find('.product_preview').html('<img src="'+imageSrc+'">');
			return $(this).parent().find('.product_preview').html();
		}
	});
});
</script>
