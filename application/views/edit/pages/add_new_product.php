<?php
	if(isset($redo) == 'edit')
	{
		$prod_action = 'edit';
		$insertid = $prodid;
		$prod_act = "edit";
		$addprod_cancel = 'edit';
		//echo $insertid;
		$this->db->where('id', $insertid);
		$editQuery = $this->db->get('products');
		$prodRow = $editQuery->row_array();
	}
	else 
	{
		$prod_action = 'insert';
		$new_product_insert_data = array(
			'page_id' => $pid,
			'website_id' => $wid,
			'date_created' => time()
		);
		$this->db->insert('products', $new_product_insert_data);
		$insertid = $this->db->insert_id();
		$addprod_cancel = 'cancel';
	}
	
	// variant query
	$this->db->where('product_id',$insertid);
	$this->db->where('website_id',$wid);
	$variant_query = $this->db->get('product_variants');
	
	
	$this->db->select('user_id');
	$this->db->where('id', $wid);
	$query_website = $this->db->get('websites');
	$row_web = $query_website->row_array();
	
	/* Get Checkout Settings */				
	$this->db->where('user_id', $this->session->userdata('uid'));
	$ckquery = $this->db->get('checkout_settings');
	$cksettings = $ckquery->row_array();	
	
	$otherdelivalue = '';
	if($cksettings){
		
		$other_delivery = rtrim($cksettings['other_delivery'], ',');
		$other_delivery   = explode(',',$other_delivery);
		
		if(isset($redo) == 'edit'){
		/* Get Product Checkout Settings */
			$ck_out_settings = rtrim($prodRow['checkout_settings'], ',');
			$ck_out_settings   = explode(',',$ck_out_settings);	

			foreach($ck_out_settings as $setinfo){
				$setting_type = substr($setinfo, 0, strrpos( $setinfo, '-' ));
				$length = strlen($setinfo);		
				$pos_of_dash = strrpos( $setinfo, '-' ) + 1;
				$position = $length - $pos_of_dash;
				$value = substr($setinfo, -$position);
				$$setting_type = $value;					
			}
		}
		
		/* Get Other Delivery Method */
		foreach($other_delivery as $del_info){
			$name_other = str_replace(' ','_',$del_info);
			$name_other2 = $name_other.'-true';
			$checked = '';
			
			if(isset($redo) == 'edit'){	
				if(in_array($name_other2, $ck_out_settings)){
					$checked = 'checked="checked"';
				}
			}
			
			$otherdelivalue .= '<li>
					<div class="control-group" style="margin-bottom:0;">
						<label class="control-label" style="padding-top: 0;">'.$del_info.'</label>
						<div class="controls">							
							<span><input type="checkbox" name="chkssetting['.$name_other.']" id="'.$name_other.'" value="true" '.$checked.' style="vertical-align: top;" /></span>
						</div>
					</div>
				</li>';
		}		
	}
?>

	<style>
		form label {
			vertical-align: top;
			width: 150px;
		}
		.controls input, .controls select {
			font-size: 12px !important; 
			font-family: Segoe UI Semibold;
		}
		#submit-buttons {
			text-align: right;
		}
		span.info-text
		{
			position:absolute;
			display:none;
			width: 171px;
			top: 1px;
			left: 22px;
			color: white;
			background: #7F7E7E;
			padding: 1px 7px;
			border-radius: 8px;
		}
		textarea#prod_desc
		{
			width: 360px;
			min-height: 90px;
		}
		.img-up-thumb
		{
			float:left;
		}
		#prod_price, #prod_stock
		{
			text-align:right;
		}
		.image_button {
			background: none repeat scroll 0 0 rgb(0, 136, 204);
			bottom: 0;
			color: rgb(255, 255, 255);
			display: none;
			line-height: 18px;
			position: absolute;
			left: 18px;
			bottom: 0;
		}
		.image_button:hover {
			box-shadow: 1px 2px 3px 0 rgba(0, 0, 0, 0.3) inset;
		}
		.delete_img {
			position: absolute;
			right: -13px;
			cursor: pointer;
			top: -14px;
			display:none;
		}
		.box_hover:hover .image_button {
			display: inline-block;
		}
		.box_hover:hover .delete_img {
			display: inline-block;
		}
		.delete_img_new {
			position: absolute;
			right: -13px;
			cursor: pointer;
			top: -14px;
			display:none;
		}
		.box_hover:hover .image_button {
			display: inline-block;
		}
		.box_hover:hover .delete_img_new {
			display: inline-block;
		}
		#prod_sort li {
			float:left;
			list-style: none;
		}
		.tags {
			padding: 1px 5px;
			border-style: solid;
			border-width: 1px;
			border-color: #c5c5c5;
			overflow: auto;
			
			background: rgb(235,235,235); /* Old browsers */
			background: -moz-linear-gradient(top,  rgba(235,235,235,1) 0%, rgba(207,209,207,1) 100%); /* FF3.6+ */
			background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(235,235,235,1)), color-stop(100%,rgba(207,209,207,1))); /* Chrome,Safari4+ */
			background: -webkit-linear-gradient(top,  rgba(235,235,235,1) 0%,rgba(207,209,207,1) 100%); /* Chrome10+,Safari5.1+ */
			background: -o-linear-gradient(top,  rgba(235,235,235,1) 0%,rgba(207,209,207,1) 100%); /* Opera 11.10+ */
			background: -ms-linear-gradient(top,  rgba(235,235,235,1) 0%,rgba(207,209,207,1) 100%); /* IE10+ */
			background: linear-gradient(to bottom,  rgba(235,235,235,1) 0%,rgba(207,209,207,1) 100%); /* W3C */
			filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ebebeb', endColorstr='#cfd1cf',GradientType=0 ); /* IE6-9 */ 
		}
		.tags li {
			float: left;
			list-style: none;
		}
		.tags .tag_input {
			background: transparent;
			border: 0;
			box-shadow: none;
			
		}
		.tags .tag_choice {
			background-color: #08c;
			border: 1px solid #CAD8F3;
			padding: 2px 4px 3px;
			margin-top: 1px;
			margin-right: 7px;
			color: #fff;
			border-radius: 5px;
		}
		.tags .tag_close {
			color: #fff;
			cursor: pointer;
			font-size: 12px;
			font-weight: bold;
			outline: medium none;
			padding: 2px 0 2px 3px;
			text-decoration: none;
		}
		.tags .tag_input:focus {
			outline: 0;
			box-shadow: none;
		}
		.typeahead.dropdown-menu li {
			float: none;
		}
		div.editable
		{
			border: solid 2px Transparent;
			padding-left: 15px;
			padding-right: 15px;
		}

		div.editable:hover
		{
			border-color: black;
		}
		.sub_item_ul li:hover button {
			display: inline-block;
		}
		.sub_item_ul li button {
			display: none;
		}
		.sub_item_ul li {
			text-align:left;
		}
		.sub_item_ul li span.sub_item {
			line-height: 25px;
		}
		.confirm_sub_button-delete:hover, .confirm_sub_button-cancel:hover {
			cursor: pointer;
			color: #BFBFBF;
		}
		
		form fieldset
		{
		   width: 853px;
		   padding:20px;
		   border:1px solid #ccc;
		-moz-border-radius: 10px;
		-webkit-border-radius: 10px;
		-khtml-border-radius: 10px;
		border-radius: 10px;   
		}
	</style>
				<div class="row-fluid">
					<legend style="line-height: 27px;">
						<div style="font-size: 14px; text-transform: uppercase; font-weight: bold; color: rgb(62, 62, 62);">
							<?php echo isset($prod_act) == 'edit' ? 'Edit ' : 'Add New ' ?> Product:
						</div>
						<div class="fbinfo" style="visibility:hidden;">
						</div>
					</legend>
<?php
						$prod_form_attrib = array('name'=>'prod_form', 'class'=>'prod_form form-horizontal', 'onsubmit'=>'return false');
						echo form_open_multipart('dashboard/ajaxproduct', $prod_form_attrib);
?>
								<div class="control-group">
									<label class="control-label" for="prod_number"> Product Number: </label>
									<div class="controls">
										<?php if(isset($prod_act) && $prod_act == 'edit'){ ?>
											<p style="margin-bottom: 0;margin-top: 6px;"><?php echo isset($prodRow['id']) ? str_pad($prodRow['id'], 7, 0, STR_PAD_LEFT) : ''; ?></p>								
										<?php }else{ ?>
											<p style="margin-bottom: 0;margin-top: 6px;"><?php echo str_pad($insertid, 7, 0, STR_PAD_LEFT); ?></p>								
										<?php } ?>										
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="prod_name"> Product Name: </label>
									<div class="controls">
										<input type="text" id="prod_name" name="prod_name" value="<?php echo isset($prodRow['name']) ? $prodRow['name'] : ''; ?>" />
										<span id="prod-name-info" class="help-inline"></span>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="prod_section"> Section: </label>
									<div class="controls">
<?php
										$prod_section = array(
												'' => 'Select...',
												'furnitures' => 'Furnitures',
												'crafts' => 'Crafts',
												'food' => 'Food',
												'others' => 'Others'
											);
										echo form_dropdown('prod_section', $prod_section, isset($prodRow['section']) ? $prodRow['section'] : 'Select...', 'id="prod_section"');
?>
										<span id="prod-cat-info" class="help-inline"></span>
									</div>
								</div>
								<div class="control-group" alt="<?php echo isset($prodRow['category']) ? $prodRow['category'] : ''; ?>">
									<label class="control-label" for="prod_cat"> Category: </label>
									<div class="controls">
<?php
										$product_category = array();										
										
										if(isset($prodRow['section'])){
											if($prodRow['section'] === 'furnitures') {
												
												$this->db->where('section_id',$prodRow['section']);
												$dbfurniture = $this->db->get('product_category');
												foreach ($dbfurniture->result_array() as $tablerow) {
													$product_category[$tablerow['id']] = $tablerow['value'];
												}
												
											} else if($prodRow['section'] === 'crafts') {
												
												$this->db->where('section_id',$prodRow['section']);
												$dbcraft = $this->db->get('product_category');
												foreach ($dbcraft->result_array() as $tablerow) {
													$product_category[$tablerow['id']] = $tablerow['value'];
												}
											} else if($prodRow['section'] === 'food') {
												
												$product_category = array(
													'Dairy' => 'Dairy',
													'fruits' => 'Fruits',
													'grains' => 'Grains',
													'meat' => 'Meat',
													'sweets' => 'Sweets',
													'vegetables' => 'Vegetables',
													'water' => 'Water',
													'alcohol' => 'Alcohol',
													'juice' => 'Juice',
													'cookies' => 'Cookies',
													'others' => 'Other',
												);		
											} else if($prodRow['section'] === 'others') {
												$product_category['others'] = 'Others';
											}
										}
										echo form_dropdown('prod_cat', $product_category, isset($prodRow['category']) ? $prodRow['category'] : 'Select...', 'id="prod_cat" class="prod_cat"');
?>	
										<span id="prod-cat-info" class="help-inline"></span>
									</div>
								</div>
<?php
					if(isset($prodRow['category'])) 
					{
						// $this->db->where('category',$prodRow['category']);
						// $this->db->where('website_id',$wid);
						// $this->db->order_by('sub_category asc');
						// $query_sub_categ = $this->db->get('product_subcategory');
						// $row_array_sub = $query_sub_categ->row_array();
						
						$this->db->distinct();
						$this->db->select('sub_category');
						$this->db->where('website_id', $wid);
						$this->db->where('category',$prodRow['category']);
						$null_entry = array('','0');
						$this->db->where_not_in('sub_category',$null_entry);
						$query_sub_categ = $this->db->get('products');
						if($query_sub_categ->num_rows() > 0)
						{
							echo '
								<div class="control-group sub_div">
									<label class="control-label" for="sub_category"> Sub-category: </label>
									<div class="controls">
										<select class="sub_category" id="sub_category" name="sub_category" alt="'.$prodRow['category'].'">
								';
									foreach($query_sub_categ->result_array() as $rowSubCateg)
									{
										$selected = ($prodRow['sub_category'] == $rowSubCateg['sub_category'] ? 'selected' : '');
										echo '
											<option value="'.$rowSubCateg['sub_category'].'" '.$selected.'>'.ucwords(strtolower($rowSubCateg['sub_category'])).'</option>	
										';
									}
							echo '
										</select>
										<button class="btn btn-mini add_sub_categ" style="margin-right:3px;margin-top:2px;" title="add more sub category">Add</button>
										<button class="btn btn-mini remove_sub_categ" style="margin-right:3px;margin-top:2px;">Remove</button> 
									</div>
								</div>
							';
						}
					}
?>								
								<!--<div class="control-group">
									<label class="control-label" for="prod_price"> Actual Price: </label>
									<div class="controls">
										<div class="input-prepend">
											<span class="add-on">Php</span>
											<input class="span11" onfocus="if (this.value==this.defaultValue) this.value = ''" onblur="if (this.value=='') this.value = this.defaultValue" type="text" id="prod_price" name="prod_price" value="<?php echo isset($prodRow['price']) ? number_format($prodRow['price'], 2, '.', ',') : ''; ?>">
										</div>
										
										<span id="prod_price-info" class=""> </span>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="prod_stock"> Available Stock: </label>
									<div class="controls">
										<div class="input-append">
											<input style="max-width: 173px;" type="text" id="prod_stock" name="prod_stock" value="<?php echo isset($prodRow['stocks']) ? $prodRow['stocks'] : ''; ?>">
											<span class="add-on">Pcs.</span>
										</div>
										<span id="prod_stock-info" class="help-block" style="display:inline;"> </span>
									</div>
								</div>-->
								<div class="control-group">
									<label class="control-label" for="prod_video"> Video Link: </label>
									<div class="controls">
										<input type="text" id="prod_video" name="prod_video" value="<?php echo isset($prodRow['video']) ? $prodRow['video'] : ''; ?>" placeholder="youtube link"/>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="prod_weight"> Product Weight: </label> 
									<div class="controls">
										<div class="input-append">
											<input style="max-width: 163px;" type="text" id="ideal_weight" name="ideal_weight" value="<?php echo isset($prodRow['prod_weight']) ? $prodRow['prod_weight'] : ''; ?>">
											<span class="add-on">kg(s).</span>
										</div>									
										<a href="#" rel="tooltip" title="Basis for shipment charge."> <i class="icon-info-sign"></i></a>
										<span id="ideal_weight-info" class="help-block" style="display:inline;"></span>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="avail_ship"> Available to ship: </label>
									<div class="controls">
										<select id="avail_ship">
											<option value="2" <?php echo isset($prodRow['avail_ship']) && $prodRow['avail_ship'] == 2 ? 'selected="selected"' : ''; ?>>2 days</option>
											<option value="3" <?php echo isset($prodRow['avail_ship']) && $prodRow['avail_ship'] == 3 ? 'selected="selected"' : ''; ?>>3 days</option>
											<option value="4" <?php echo isset($prodRow['avail_ship']) && $prodRow['avail_ship'] == 4 ? 'selected="selected"' : ''; ?>>4 days</option>
											<option value="5" <?php echo isset($prodRow['avail_ship']) && $prodRow['avail_ship'] == 5 ? 'selected="selected"' : ''; ?>>5 days</option>
											<option value="6" <?php echo isset($prodRow['avail_ship']) && $prodRow['avail_ship'] == 6 ? 'selected="selected"' : ''; ?>>6 days</option>
											<option value="7" <?php echo isset($prodRow['avail_ship']) && $prodRow['avail_ship'] == 7 ? 'selected="selected"' : ''; ?>>7 days</option>
											<option value="mto" <?php echo isset($prodRow['avail_ship']) && $prodRow['avail_ship'] == 'mto' ? 'selected="selected"' : ''; ?>>Made to Order</option>
										</select>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="prod_desc"> Product Description: </label> 
									<div class="controls">
										<!--<div class="contents">
											<div class="editorcontents product_desc" id="prod_desc">
												<span><?php //echo isset($prodRow['desc']) ? $prodRow['desc'] : 'Add Description'; ?></span>
											</div>
										</div>-->
											<div id="editorproduct9">
												
											</div>
											<div id="editorcontents22" style="display:none;">
												<?php 
													if($this->db->field_exists('product_desc', 'products')) {
														echo isset($prodRow['product_desc']) ? html_entity_decode($prodRow['product_desc']) : '';
													} else {
														echo isset($prodRow['desc']) ? html_entity_decode($prodRow['desc']) : '';
													}
												?>
											</div>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Tags: </label>
									<div class="controls">
										<ul class="tags span12">
								<?php
									$this->db->where('prod_id',$insertid);
									$query_tags = $this->db->get('tags');
									if($query_tags->num_rows() > 0)
									{
										foreach($query_tags->result_array() as $row_tags)
										{
											echo '
												<li class="tag_choice">
													'.$row_tags['tag_names'].'
													<a class="tag_close">x</a>
													<input type="hidden" style="display:none;" value="'.$row_tags['tag_names'].'" name="tagItem[]">
												</li>
											'; 
										}
									}
								?>
											<li class="tagit_new">
												<input type="text" class="tag_input span8" style="cursor:text;" data-provide="typeahead" >
											</li>
											
										</ul>
									</div>
								</div>
							<!-- Advance Option Start -->
								<legend style="margin: 0;font-size: 14px; text-transform: uppercase; font-weight: bold;line-height: 28px;border: none;">
									<a class="accordion-toggle advoption" data-toggle="collapse" data-parent="#advanceoption" href="#advanceone" style="color: rgb(62, 62, 62);">
										<i class="icon-chevron-right"></i> Add Variant and Pricing Option:
									</a>
								</legend>
								<div class="accordion" id="advanceoption">
									<div class="accordion-group" style="border:none;">
										<div id="advanceone" class="accordion-body collapse <?php echo $variant_query->num_rows() > 0 ? 'in' : ''; ?>">
											<div class="row-fluid">
												<div class="span3">
													<select class="span12 variant_select">
														<option value="size">Size</option>
														<option value="color">Color</option>
														<option value="package">Package</option>
														<option value="custom">Custom...</option>
													</select>
												</div>
												<div class="span3">
													<input type="text" class="span12 variant_input" placeholder="small,medium,large"/>
												</div>
												<div class="span2">
													<input class="span12 variant_price" type="number" placeholder="Price">
												</div>
												<div class="span2">
													<input class="span12 variant_quantity" type="number" placeholder="Quantity">
												</div>
												<div class="span2">
													<button class="btn btn-primary add_variant" type="button">Add</button>
													<button class="btn" type="button" data-toggle="collapse" data-parent="#advanceoption" data-target="#advanceone">Cancel</button>
												</div>
											</div>
								<div class="control-group variant_group_container" style="border: 1px solid #ddd;margin: 5px 0;padding: 0 5px;">
									<div class="row-fluid hidden-phone">
										<div class="span2">
											<h5>Type</h5>
										</div>
										<div class="span2"><h5>Name</h5></div>
										<div class="span2"><h5>Price</h5></div>
										<div class="span2"><h5>Quantity</h5></div>
									</div>
<?php
	if($variant_query->num_rows() > 0)
	{
		foreach($variant_query->result_array() as $variant_item)
		{
?>
									<div class="row-fluid variant_row">
										<div class="span2" style="border-bottom: 1px dashed #ddd;">
											<span><?php echo $variant_item['type']; ?></span>
											<input type="hidden" class="v_type" name="v_type[]" value="<?php echo $variant_item['type']; ?>">
										</div>
										<div class="span2" style="border-bottom: 1px dashed #ddd;">
											<span><?php echo $variant_item['name']; ?></span>
											<input type="hidden" class="v_name" name="v_name[]" value="<?php echo $variant_item['name']; ?>">
										</div>
										<div class="span2" style="border-bottom: 1px dashed #ddd;">
											<input type="text" class="v_price span12" name="v_price[]" value="<?php echo $variant_item['price']; ?>">
										</div>
										<div class="span2" style="border-bottom: 1px dashed #ddd;">
											<input type="text" class="v_quantity span12" name="v_quantity[]" value="<?php echo $variant_item['quantity']; ?>">
										</div>
										<div class="span1">
											<i class="icon-remove-sign remove_variant" style="cursor:pointer;"></i>
										</div>
									</div>
<?php
		}
	}
?>
								</div>
										</div>
									</div>
								</div>
							<!-- Advance Option End -->
							<?php
								if(($cksettings) AND (($cksettings['paypal_email']) OR ($cksettings['gcash']) OR ($cksettings['smart_money']))){
							?>								<legend style="font-family: Segoe UI Semibold; font-size: 16px; color: rgb(23, 23, 23);">Payment Options</legend>
								<?php if(!empty($cksettings['bank_details'])){ ?>
								<div class="control-group" style="margin-bottom:0;">
									<label class="control-label" for="bnk1" style="padding-top: 0;">Bank</label>							
									<div class="controls" style="font-size:13px;">										
										<!--<span><input type="checkbox" name="chkssetting[bank]" id="bnk1" value="true" checked="checked" style="vertical-align: top;" /></span>-->
									</div>				
								</div>
								<?php } 
									if($cksettings['paypal_email']){
								?>
								<div class="control-group" style="margin-bottom:0;">
									<label class="control-label" for="pay_email" style="padding-top: 0;">Paypal</label>							
									<div class="controls" style="font-size:13px;">										
										<!--<span><input type="checkbox" name="chkssetting[pay_email]" id="pay_email" value="true" checked="checked" style="vertical-align: top;" /></span>-->
									</div>				
								</div>
								<?php 
									} 
									if($cksettings['gcash']){
								?>
								<div class="control-group" style="margin-bottom:0;">
									<label class="control-label" for="gcash" style="padding-top: 0;">Gcash</label>							
									<div class="controls" style="font-size:13px;">										
										<!--<span><input type="checkbox" name="chkssetting[gcash]" id="gcash" value="true" checked="checked" style="vertical-align: top;" /></span>-->
									</div>			
								</div>	
								<?php 
									} 
									if($cksettings['smart_money']){
								?>
								<div class="control-group" style="margin-bottom:0;">
									<label class="control-label" for="smoney" style="padding-top: 0;">Smart Money</label>							
									<div class="controls" style="font-size:13px;">										
										<!--<span><input type="checkbox" name="chkssetting[smoney]" id="smoney" value="true" checked="checked" style="vertical-align: top;" /></span>-->
									</div>
								</div>	
								<?php } ?>
								<hr/>
							<?php
								}
							?>
								<div class="control-group" style="margin-top:20px;">
									<label class="control-label"> Upload Photo: </label>
									<div class="controls">
										<div class="fileupload fileupload-new" data-provides="fileupload">
											<div class="input-append">
												<span class="btn btn-file fileinput-button">
													<span class="fileupload-new">Select files</span>
													<span class="fileupload-exists">Change</span>
													<input type="file" id="prod_photo" class="uploadFile" name="prod_photo[]" multiple accept="image/*"/>
												</span>
												<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
											</div>
										</div>
									</div>
								</div>
							<!-- new uploader -->
								<script>
								  function handleFileSelect(evt) {
									/* var thisimage = $(this).val().replace(/.+[\\\/]/, "");
									evt.preventDefault;
									evt.stopPropagation;
									
									var files = evt.target.files; // FileList object
									
									// Loop through the FileList and render image files as thumbnails.
									for (var i = 0, f; f = files[i]; i++) {

									  // Only process image files.
									  if (!f.type.match('image.*')) {
										continue;
									  }

									  var reader = new FileReader();

									  // Closure to capture the file information.
									  reader.onload = (function(theFile) {
										return function(e) {
											
										  // Render thumbnail.
										  // var span = document.createElement('li');
										  // span.innerHTML = ['<img class="thumb" style="height: 100px;width: 120px;margin: 0;margin-left: 10px;" src="', e.target.result,
															// '" title="', escape(theFile.name), '"/>'].join('');
										  // document.getElementById('prod_sort').insertBefore(span, null);
											
										  
										};
									  })(f);

									  // Read in the image file as a data URL.
									  reader.readAsDataURL(f);
									} */
									$('.prod_sort').append('<li class="on_preview_image"><img src="<?php echo base_url(); ?>img/loader.gif" style="width:120px;height: 20px;"/></li>');
									$(".prod_form").ajaxForm({
										beforeSubmit: function() {
											$('#upload_modal').modal({
												backdrop: 'static',
												keyboard: 'false',
												show: 'true'
											});
										},
										type: "POST",
										url: "<?php echo base_url(); ?>dashboard/uploadproduct",
										data: { webId: '<?php echo $wid; ?>', product_id: '<?php echo $insertid; ?>', page_id: '<?php echo $pid; ?>'},
										success: function(html) {
											$('#upload_modal').modal('hide');
											$('.on_preview_image').remove();
											
											/* split array */
											var li_count = $('#prod_sort li').length;
											li_count = li_count + 1;
											var myarr = JSON.parse(html);
											$(myarr).each(function(e, el) {
												e = e + li_count;
												$('.prod_sort').append('<li class="ui-state-default box_hover" style="margin-right:10px;margin-bottom:10px;position:relative;cursor:move;border:2px solid #000;">'+
													'<div id="'+el.prod_id+'" class="prod_thumb" style="background-image: url(\'' + el.thumbs + '\'); background-repeat: no-repeat; background-size: cover; background-position: center center; height: 90px; width: 121px;">'+
													'<span class="badge badge-success">'+e+'</span>'+
													'</div>'+
													'<button class="image_button" alt="' + el.image + '" style="margin-bottom: 45px;">Set primary</button>'+
													'<span class="badge badge-info"></span>'+
													'<input type="checkbox" name="delphoto[]" value="'+el.prod_id+'" style="vertical-align: top;">Mark to Delete</input>'+
												  '</li>');
											});
										}
									}).submit();
									
								  }
								  document.getElementById('prod_photo').addEventListener('change', handleFileSelect, false);
								</script>
							
								<div class="row-fluid">
								<fieldset>
<?php
								$this->db->where('product_id', $insertid);
								$this->db->order_by("seq", "asc");
								$queryImg = $this->db->get('products_images');
								$lastimg = '';
								echo '
										
										<ul id="prod_sort" class="prod_sort" style="margin: 0 0 10px 19px;">
									';
								if($queryImg->num_rows() > 0)
								{
									foreach($queryImg->result_array() as $key=>$row)
									{
										$color_name = isset($row['color_name']) ? $row['color_name'] : '';
										$img = 'uploads/' . $row_web['user_id'] . '/' . $wid . '/' . $pid . '/' . $insertid . '/s120/'. $row['images'];
										if($this->photo_model->image_exists($img)) {
											$lastimg = base_url($img);
										} else {
											$img = 'uploads/' . $row_web['user_id'] . '/' . $wid . '/' . $pid . '/' . $insertid . '/'. $row['images'];
											if($this->photo_model->image_exists($img)) {
												$thumbs = $this->photo_model->custom_thumbnail($img, 120);
												$lastimg = base_url($thumbs);	
											} else {
												$lastimg = 'http://www.placehold.it/120x120/333333/ffffff&text=missing+image';
											}
										}
										echo '
											<li class="ui-state-default box_hover" style="margin-right:10px;margin-bottom:10px;position:relative;cursor:move;border:2px solid #000 ;">
												<div id="'.$row['id'].'" class="prod_thumb" style="background:url(\''.$lastimg.'\');background-repeat: no-repeat;background-size: cover;background-position: center center; height: 90px; width: 121px;">
													<span class="badge badge-success">'.($key + 1).'</span>
											';
										echo '
												</div>
												<button class="image_button" alt="'.$row['images'].'" style="margin-bottom: 45px;">Set primary</button>
												<span class="badge badge-info"></span>
												<input type="checkbox" name="delphoto[]" value="'.$row['id'].'" style="vertical-align: top;">Mark to Delete</input>
											</li>
										';
									}
									
								}
								echo '
										</ul>
										<input name="multi_del" type="submit" id="multi_del" value="Delete"/>
										
									';
?>
								</fieldset>
								</div>
								
								<div id="loader" style="height: 23.5px;"></div>
								
								<!--save button submit-->
								<div id="submit-buttons">
									<input type="hidden" id="addprod_cancel" value="<?php echo $addprod_cancel; ?>" />
									<input type="hidden" id="insertid" value="<?php echo $insertid; ?>" />
									<input type="hidden" id="prod_action" value="<?php echo $prod_action; ?>" />
									<button type="reset" id="back2cat" data-loading-text="Please wait..." class="btn" value="<?php echo isset($prodRow['name']) ? $prodRow['name'] : ''; ?>"> Cancel </button>
									<button id="save_prod" class="btn" data-loading-text="Saving..." name="prod_submit" value="<?php echo $pid; ?>"><i class="icon-folder-close"></i> Save </button>
								</div>
<?php
	echo form_close();
?>
</div>
	<!--modal-->
    <div id="upload_modal" class="modal hide fade">
		<div class="modal-body">
		<p>Uploading... Please Wait...</p>
		</div>
    </div>



<script>
// window.onbeforeunload = function() {
    // return 'Are you sure you want to navigate away from this page?';
// };
// window.onload = function() {
	// if (window.confirm('yes/no?'))
	// {
		// alert('yes');
	// }
	// else
	// {
		// alert('no');
	// }
// }
$(function(){

	$('.page').delegate('#multi_del','click',function(e){
		var eto = $(this);
		$(".prod_form").ajaxForm({
			beforeSubmit: function() {
				$('#upload_modal').modal({
				backdrop: 'static',
				keyboard: 'false',
				show: 'true'
				});
			},
			url: '<?php echo base_url(); ?>test/img_prod_del',
			type: 'post',
			data: { action:'multi_del'},
			success: function(html){
			
				var mrr = JSON.parse(html);
				$(mrr).each(function(e, el) { // [0:id,1:id,2:id]
					$('div[id='+el+']').parent().fadeOut(800);
				});
				$('#upload_modal').modal('hide');
			}
		}).submit();
	});

	/******************* Tags ********************/
	$('.page').delegate('.tag_input','keypress',function(e){
		var el = $(this);
		var ENTER			= 13;
		var SPACE			= 32;
		var COMMA			= 44;
		var code = (e.keyCode ? e.keyCode : e.which);
		
		/* if user press spacebar and enter */
		if(code == ENTER || code == SPACE || code == COMMA) { 
			e.preventDefault();
			var type = el.val();
			if(type != '')
			{
				if(is_new(el,type))
				{
					create_choice(el,type);
				}
				
				/* Cleaning the input. */
				el.val('');
			}
		}
	});
	
	$('.page').delegate('.tag_close','click',function(){
		var li = $(this).parent();
		remove_tags(li);
	});
	
	/* detect if tags names if available */
	function is_new(el,value){
		var is_new = true;
		var i=0;
		el.parents('.tags').children(".tag_choice").each(function(){
			i=i+1;
			n = $(this).children("input").val();
			if (value == n || i == 5) {
				is_new = false;
			}
		});
		return is_new;
	}
	/* creating a tags name  */
	function create_choice(dis,value){
		var pid = $(this).parents('.page').attr('id');
		var el = '';
		el = '<li class="tag_choice">';
		el += value.replace(' ','');
		el += '<a class="tag_close">x</a>';
		el += '<input type="hidden" style="display:none;" value="'+value.replace(' ','')+'" name="tagItem[]">';
		el += '</li>';
		var li_search_tags = dis.parent();
		$(el).insertBefore (li_search_tags);
	}
	/* deleting tags names */
	function remove_tags(el){
		el.remove();
	}
	/******************* Tags ********************/
	
	
	/******** typeahead tags ************/
	$('.tag_input').typeahead({
		source: function(query,process){
			$.getJSON(
				'<?php echo base_url(); ?>test/typeahead',
				{ query: query },
				function (data) {
					return process(data);
			});
		},
		items: 8
	});
	/******** typeahead tags ************/
	
	$('a[rel="tooltip"]').tooltip();
	
	$( ".prod_sort" ).sortable({
		revert: true,
		update: function(e, el) {
		//alert($(this).html());
			var eto = $(this);
			var seq = new Array();
			var img_id = new Array();
			$(this).find('li div.prod_thumb').each(function(i,el) {
				i=i+1;
				seq.push(i);
				img_id.push($(el).parent().children('.image_button').attr('alt'));
			});
				
			$(this).find('li span.badge-info').each(function(i,el) {
				i=i+1;
				$(this).html(i);
			});
			
			var dataString = 'seq_id='+seq+'&img_name='+img_id;
			$.ajax({
				type: "POST",
				url: '<?php echo base_url(); ?>test/prodImage_seq',
				data: dataString,
				success: function(html){
					setTimeout(function(){
						$(eto).find('span.badge-info').html('');
					},3000);
				}
			});
		}
	});

	
	
	$('#prod_section').on('change', function() {
		
		/* remove showed group category */
		$('.group_category').remove();
		
		if($(this).val() == 'furnitures') {
			$('#prod_cat').load('<?php echo base_url(); ?>test/getCategory?section=furnitures');
		} else
		if($(this).val() == 'crafts') {
			$('#prod_cat').load('<?php echo base_url(); ?>test/getCategory?section=crafts');
		} else
		if($(this).val() == 'food') {
			$('#prod_cat').load('<?php echo base_url(); ?>test/getCategory?section=food');
		} else 
		{
			$('#prod_cat').load('<?php echo base_url(); ?>test/getCategory');
		}
	});
	
	$('.advoption').tooltip({
		title: 'Now you can add more specific price for your product',
		html: true,
		trigger: 'hover'
	});


});
</script>