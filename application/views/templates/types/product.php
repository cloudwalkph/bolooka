<?php
	//$pname = str_replace('-', ' ',$product);
	$prod_query = $this->db->query("SELECT * FROM products WHERE id='".$product_id."'");
	// $prod_image_query = $this->db->get("products_images WHERE product_id='".$product_id."' ORDER BY seq");
	
	
	if(isset($_GET['color']))
	{
		if($_GET['color'] != '')
		{
			$this->db->like('color_name',$_GET['color']);
		}
	}
	$this->db->where('product_id',$product_id);
	$this->db->order_by('seq','asc');
	$prod_image_query = $this->db->get('products_images');
	
	
	/* product images color 
	$this->db->distinct();
	$this->db->select('color_name');
	$this->db->where('product_id',$product_id);
	$this->db->where_not_in('color_name','NULL');
	$prod_image_color = $this->db->get('products_images'); */
	$this->db->where('product_id',$product_id);
	$this->db->where('website_id',$wid);
	$variant_query = $this->db->get('product_variants');
	
	//$this->db->where('name',$pname);
	//$prod_query = $this->db->get('products');
	if($prod_query->num_rows() == 0)
	{
		show_404();
	}
	$row1 = $prod_query->row_array();
	$prodid = $row1['id'];
	$pnames = $row1['name'];	
	
	$pimages = $this->db->query("SELECT * FROM products_images WHERE product_id='$product_id' ORDER BY id DESC LIMIT 1");
	if($pimages->num_rows() > 0)
	{
		foreach($pimages->result_array() as $imagerow)
		{
			$imgfile = $imagerow['images'];
		}
	}

	$this->db->where('id', $wid);
	$this->db->where('deleted', 0);
	$website_query = $this->db->get('websites');
	$row = $website_query->row_array();
	
	$this->db->where('uid',$row['user_id']);
	$user_query = $this->db->get('users');
	$row2 = $user_query->row_array();
	$next_href = '#';
	$prev_href = '#';
	// get next product
	$next_query = $this->db->query("SELECT * FROM products WHERE page_id='".$row1['page_id']."' AND website_id='".$wid."' AND published = 1 AND id < '".$product_id."' ORDER BY id DESC LIMIT 1");
	$next_result = $next_query->row_array();
	if($next_query->num_rows() > 0){
		$next_href = base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.url_title($next_result['name'], '-', TRUE).'/'.$next_result['id'];
	}
	else
	{
		/* query go back to first id */
		$next_query_start = $this->db->query("SELECT * FROM products WHERE page_id='".$row1['page_id']."' AND website_id='".$wid."' AND published = 1 ORDER BY id DESC LIMIT 1");
		$next_result_start = $next_query_start->row_array();
		
		$next_href = base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.url_title($next_result_start['name'], '-', TRUE).'/'.$next_result_start['id'];
	}
	// get prev product
	$prev_query = $this->db->query("SELECT * FROM products WHERE page_id='".$row1['page_id']."' AND website_id='".$wid."' AND published = 1 AND id > '".$product_id."' ORDER BY id ASC LIMIT 1");
	$prev_result = $prev_query->row_array();
	if($prev_query->num_rows() > 0){
		$prev_href = base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.url_title($prev_result['name'], '-', TRUE).'/'.$prev_result['id'];
	}

	/* design change when no video uploaded */
	if($row1['video'] != '')
	{
		$id_slider_height = 'height: 300px !important;';
		$carousel_li_div_height = 'height: 100px;';
	}else
	{
		$id_slider_height = 'height: 420px !important;';
		$carousel_li_div_height = 'height: 180px;';
	}
	
	if($this->db->field_exists('product_cover', 'products')) {
		$cover = 'uploads/'. $row['user_id'] . '/' . $wid . '/' . $pid . '/' . $product_id . '/' .$row1['product_cover'];
	} else {
		$cover = 'uploads/'. $row['user_id'] . '/' . $wid . '/' . $pid . '/' . $product_id . '/' .$row1['primary'];
	}
	
	if($this->photo_model->image_exists($cover)) {
		$imgsrc = base_url($cover);
	} else {
		$imgsrc = base_url('img/bolooka-logo.png');
	}
?>
<style>

#carousel {
    border-color: rgb(221, 221, 221);
    margin: 0 0 10px !important;
    max-height: 80px;
}
#carousel li {
    height: 80px;
    margin-right: 5px;
}
#carousel .flex-active-slide img {
    cursor: default;
    opacity: 1;
}
#carousel img {
    cursor: pointer;
    display: block;
    height: 100%;
    margin: auto;
    opacity: 0.5;
    width: auto;
}
#slider {
    border-color: rgb(221, 221, 221);
    height: auto !important;
    margin: 0 0 10px !important;
    /* max-height: 900px; */
}

.prod-nav li a, .prod-nav li a:hover {
	color:inherit;
}

.comment_header_name {
	padding: 10px 20px;
}
	.sidebar-box {
		max-height: 121px;
		position: relative;
		overflow: hidden;
	}
	.sidebar-box .read-more { 
		position: absolute; 
		bottom: 0; left: 0;
		width: 100%; 
		text-align: center; 
		margin: 0; 
		padding: 20px 0; 
		
		/* "transparent" only works here because == rgba(0,0,0,0) */ 
		background-image: -moz-linear-gradient(top, transparent, black);
			background-image: -webkit-gradient(linear,left top,left bottom,color-stop(0, transparent),color-stop(1, black));
	}
	.button_read {
	   border-top: 1px solid #000;
	   background: #000;
	   padding: 5px 10px;
	   color: #fff;
	   
	   
	   /* overboard shadows for Opera (and why spec version listed first) */
	   box-shadow: rgba(0,0,0,1) 0 1px 0, rgba(0,0,0,90) 0 0 10px, rgba(0,0,0,90) 0 0 20px, rgba(0,0,0,90) 0 0 30px;
	   
	   -webkit-box-shadow: rgba(0,0,0,1) 0 1px 0;
	   -moz-box-shadow: rgba(0,0,0,1) 0 1px 0;
	   
	   
	   font-size: 14px;
	   text-decoration: none;
	   vertical-align: middle;
	}
	.button_read:hover {
	   border-top-color: #A5A5A5;
	   background: #A5A5A5;
	   color: #000;
	   text-decoration: none;
	}
	.button_read:active {
	   border-top-color: #1b435e;
	   background: #1b435e;
	}
	.btn-style:hover{
		color:#fff;
		background: rgb(206,73,16); /* Old browsers */
		background: -moz-linear-gradient(top, rgba(206,73,16,1) 37%, rgba(239,96,30,1) 100%); /* FF3.6+ */
		background: -webkit-gradient(linear, left top, left bottom, color-stop(37%,rgba(206,73,16,1)), color-stop(100%,rgba(239,96,30,1))); /* Chrome,Safari4+ */
		background: -webkit-linear-gradient(top, rgba(206,73,16,1) 37%,rgba(239,96,30,1) 100%); /* Chrome10+,Safari5.1+ */
		background: -o-linear-gradient(top, rgba(206,73,16,1) 37%,rgba(239,96,30,1) 100%); /* Opera 11.10+ */
		background: -ms-linear-gradient(top, rgba(206,73,16,1) 37%,rgba(239,96,30,1) 100%); /* IE10+ */
		background: linear-gradient(to bottom, rgba(206,73,16,1) 37%,rgba(239,96,30,1) 100%); /* W3C */
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ce4910', endColorstr='#ef601e',GradientType=0 ); /* IE6-9 */
	}
	.btn-style{
		text-shadow: none;
		background: rgb(239,96,30); /* Old browsers */
		background: -moz-linear-gradient(top, rgba(239,96,30,1) 0%, rgba(206,73,16,1) 100%); /* FF3.6+ */
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(239,96,30,1)), color-stop(100%,rgba(206,73,16,1))); /* Chrome,Safari4+ */
		background: -webkit-linear-gradient(top, rgba(239,96,30,1) 0%,rgba(206,73,16,1) 100%); /* Chrome10+,Safari5.1+ */
		background: -o-linear-gradient(top, rgba(239,96,30,1) 0%,rgba(206,73,16,1) 100%); /* Opera 11.10+ */
		background: -ms-linear-gradient(top, rgba(239,96,30,1) 0%,rgba(206,73,16,1) 100%); /* IE10+ */
		background: linear-gradient(to bottom, rgba(239,96,30,1) 0%,rgba(206,73,16,1) 100%); /* W3C */
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ef601e', endColorstr='#ce4910',GradientType=0 ); /* IE6-9 */
		color:#fff;
	}
	.btn_color {
		background: #f16120; /* Old browsers */
		background: -moz-linear-gradient(top,  #f16120 0%, #e75210 100%); /* FF3.6+ */
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#f16120), color-stop(100%,#e75210)); /* Chrome,Safari4+ */
		background: -webkit-linear-gradient(top,  #f16120 0%,#e75210 100%); /* Chrome10+,Safari5.1+ */
		background: -o-linear-gradient(top,  #f16120 0%,#e75210 100%); /* Opera 11.10+ */
		background: -ms-linear-gradient(top,  #f16120 0%,#e75210 100%); /* IE10+ */
		background: linear-gradient(to bottom,  #f16120 0%,#e75210 100%); /* W3C */
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f16120', endColorstr='#e75210',GradientType=0 ); /* IE6-9 */
		
		text-shadow: none;
		box-shadow: -2px 2px 5px -2px #ddd inset;
		color: #fff;
	}
	.btn_color:hover {
		background: #e75311; /* Old browsers */
		background: -moz-linear-gradient(top, #e75311 0%, #f16120 100%); /* FF3.6+ */
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#e75311), color-stop(100%,#f16120)); /* Chrome,Safari4+ */
		background: -webkit-linear-gradient(top, #e75311 0%,#f16120 100%); /* Chrome10+,Safari5.1+ */
		background: -o-linear-gradient(top, #e75311 0%,#f16120 100%); /* Opera 11.10+ */
		background: -ms-linear-gradient(top, #e75311 0%,#f16120 100%); /* IE10+ */
		background: linear-gradient(to bottom, #e75311 0%,#f16120 100%); /* W3C */
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#e75311', endColorstr='#f16120',GradientType=0 ); /* IE6-9 */

		box-shadow: 1px -2px 5px -2px #ddd inset;
		color: #fff;
	}
	.variant_ul li:hover {
		background: #F26221;
	}
</style>
<div class="catalog_bg" style="border-radius: 8px; padding: 10px">
	<div class="row-fluid" style="margin-bottom: 20px">
		<div class="<?php echo $row1['video'] != '' ? 'span12' : 'span12'; ?>">

			<ul class="nav inline pull-right prod-nav">
				<li><a class="btn-link" href="<?php echo $prev_href; ?>"> Prev </a></li>
				<li class="divider-vertical"></li>
				<li><a class="btn-link" href="<?php echo $next_href; ?>"> Next </a></li>
			</ul>

			<h4 style="font-size: 23px;">
				<?php echo $pnames; ?>
			</h4>
			<hr style="margin: 5px 0;"/>
			<dl class="dl-horizontal">
				<dt>Product No:</dt>
				<dd><?php echo str_pad($row1['id'], 7, 0, STR_PAD_LEFT); ?></dd>
				<dt>Available to ship:</dt>
				<dd><?php echo $row1['avail_ship'] == 'mto' ? 'Made to Order': $row1['avail_ship'].' days';?></dd>
<?php
		if($this->db->field_exists('product_desc', 'products')) {
			if($row1['product_desc'] != '') { 
?>
				<dt>Description:</dt>
				<dd>
					<div class="sidebar-box">
						<?php echo html_entity_decode($row1['product_desc']); ?>
						<p class="read-more">
							<a href="#" class="button_read">Read More</a>
						</p>
					</div>
				</dd>
<?php
			}
		} else {
			if($row1['desc'] != '') {
?>
				<dt>Description:</dt>
				<dd>
					<div class="sidebar-box">
						<?php echo html_entity_decode($row1['desc']); ?>
						<p class="read-more">
							<a href="#" class="button_read">Read More</a>
						</p>
					</div>
				</dd>
<?php
			}
		}
?>
			
			</dl>
			<hr style="margin: 5px 0;"/>
		</div>
	</div> <!--end div class row-fluid-->

	<div class="row-fluid">
		<div class="<?php echo $row1['video'] != '' ? 'offset1 span6' : 'offset1 span6'; ?> center_margin" style="margin-bottom: 10px">
			<div class="slider">
<?php
		if($prod_image_query->num_rows() > 0)
		{
			if($prod_image_query->num_rows() > 4)
			{
				echo '
				<div id="carousel" class="hidden-phone flexslider">
					<ul class="slides">
				';
				foreach($prod_image_query->result_array() as $rowImage)
				{
?>
						<li>
							<img src="<?php echo base_url().'uploads/'. $row['user_id'] . '/' . $wid . '/' . $pid . '/' . $product_id . '/thumbnail/' .$rowImage['images']; ?>" alt="<?php echo $product_id; ?>">
						</li>
<?php 
				}
				echo '
					</ul>
				</div>
				';
			}

			echo '
				<div id="'.($prod_image_query->num_rows() > 2 ? 'slider' : 'slider').'" class="flexslider">
					<ul class="slides">
			';
			foreach($prod_image_query->result_array() as $rowImage)
			{
?>
						<li>
							<img src="<?php echo base_url().'uploads/'. $row['user_id'] . '/' . $wid . '/' . $pid . '/' . $product_id . '/medium/' .$rowImage['images']; ?>" alt="<?php echo $product_id; ?>">
						</li>
<?php 
			}
			echo '
					</ul>
				</div>
			';
		}
?>
			</div>
		</div>						
		<div class="offset1 span4">
			<div class="<?php if($row1['price'] != 0 || $row1['stocks'] != 0 || $variant_query->num_rows() > 0){ echo 'well well-small'; } ?> content_style">
				<div class="container-fluid" style="overflow-y:auto;max-height:250px;padding: 0;">
					<ul class="variant_ul" style="margin:0;">
<?php
		if($row1['price'] != 0 && $row1['stocks'] != 0)
		{
?>
						<li style="padding-left:5px;border-bottom:1px dashed #ddd;margin-bottom: 5px;">
							<label class="radio">
								<input type="radio" name="variant_option" checked="checked" value="<?php echo $row1['id']; ?>" alt="product">
								<span><strong style="font-size: 15px;">Price</strong></span><br/> 
								<span style="font-size:17px;">&#8369; <?php echo number_format($row1['price'], 2); ?></span><br/>
								<span>Available Stock: <?php echo $row1['stocks'];?></span>
							</label>
						</li>
<?php
		}
?>
<?php
		if($variant_query->num_rows() > 0)
		{
			$x = 1;
			foreach($variant_query->result_array() as $variant_item)
			{
?>
						<li style="padding-left:5px;">
							<label class="radio">
								<input type="radio" name="variant_option" <?php echo $variant_item['quantity'] == 0 ? 'disabled' : ''; ?> value="<?php echo $variant_item['id']?>">
								<span><?php echo ucfirst($variant_item['name']); ?></span></br>
								<span style="font-size:17px;">&#8369; <?php echo number_format($variant_item['price'], 2); ?></span></br>
								<span style="font-style:italic;<?php echo $variant_item['quantity'] == 0 ? 'color:red;' : ''; ?>"><?php echo $variant_item['quantity']; ?> in stock</span>
							</label>
						</li>
<?php
				$x++;
			}
		}
?>
					</ul>
				</div>
			</div>
			<div class="well content_style">
				<div class="text-center">
<?php
			if(($row1['price'] == 0 || $row1['stocks'] == 0) && $variant_query->num_rows() == 0):
?>
					<button class="btn btn-warning btn-large cc-seller" class="btn" style="font-size: 16px; background: #F26221;"> Contact Seller </button>
<?php
			else:
?>
					<a class="btn btn-warning add-cart" href="#" style="font-size: 20px;padding-top: 10px;padding-bottom: 10px;">Add to Cart</a>
<?php
			endif;
?>
				</div>
			</div>
<?php
	if($_SERVER['HTTP_HOST']=='www.bolooka.com') {
?>
			<div class="well content_style">

				<ul class="unstyled" style="width: 109px; margin: auto">
				Share: 
<?php
					/* AddThis Button BEGIN */
					$this->load->view('templates/addthis');
					/* AddThis Button END */
?>
					<!--Pinteret pin-->
					<li>
						<a href="//pinterest.com/pin/create/button/?url=<?php echo current_url(); ?>&media=<?php echo $imgsrc; ?>" data-pin-do="buttonPin" data-pin-config="beside">
							<img src="//assets.pinterest.com/images/pidgets/pin_it_button.png" />
						</a>
						<script type="text/javascript" src="http://assets.pinterest.com/js/pinit.js"></script>
					</li>
				</ul>
			</div>
<?php
	}
		if($row1['video'] != '')
		{
?>
			<div class="well content_style">
				<iframe src="<?php echo $row1['video']; ?>" style="border: medium none; width: 100%; height: 250px;"></iframe>
			</div>
<?php
		}

?>
		</div>
	</div>
	<div class="spaceleftright" style="margin-top: 20px;">
<?php
	$login = $this->session->userdata('logged_in');
	$uid = $this->session->userdata('uid');
	$thecomments = $this->db->query("SELECT * FROM comments WHERE msg_id_fk='$product_id' AND type='product' ORDER BY com_id ASC");
	if($thecomments->num_rows() > 0 OR $login)
	{
?>
		<legend style="font-family: Segoe UI Semibold; font-size: 18px;color:inherit;margin-top: 15px;margin-bottom: 9px;">Feedback:</legend>
<?php
	}
?>
		<div class="row-fluid comentarea" style="margin: 0 auto;">
			<ul style="list-style:none;margin:0;" class="comment-items-hold">
			<?php	
				if($thecomments->num_rows() > 0)
				{
					foreach($thecomments->result_array() as $therow)
					{
						$commentId = $therow['com_id'];
						$commentmsg = $therow['comment'];
						$commentuser = $therow['uid_fk'];
						$created = $therow['created'];
						$this->db->where('uid', $commentuser);
						$queryusers = $this->db->get('users');
						$theusers = $queryusers->row_array();
						$profPicss = $theusers['profile_picture'];
						$profPicss = str_replace(' ','_',$profPicss);
						$this->db->where('id', $wid);
						$this->db->where('deleted', 0);
						$querywebsite = $this->db->get('websites');
						$thewebsite = $querywebsite->row_array();
						
			?>
				<li id="<?php echo $commentId; ?>" class="del_<?php echo $commentId; ?>">
				<?php if($uid == $commentuser || $uid == $thewebsite['user_id']){ ?>
					<i class="icon-remove icon-white pull-right del-feed-com" style="cursor:pointer;"></i>
				<?php } ?>
					<div class="row-fluid" style="border-bottom: 1px solid #ddd;">
						<div class="pull-left" style="width: 40px; overflow: hidden; margin: 4px; max-height: 40px;">
							<img src="<?php echo $profPicss ? base_url().'uploads/'.$commentuser.'/thumbnail/'.$profPicss : 'broken.jpg'; ?>" />
						</div>
						<h6 style="margin-left: 35px;margin-top: 10px;margin-bottom: 0;">
							<?php echo $theusers['name']; ?>
							<span class="muted" style="color: #ddd;">Says:</span>
							<span class="muted pull-right hidden-phone" style="color: #ddd;">
								<?php echo date('F j, Y g:i:s a', $created); ?>
							</span>
						</h6>
					</div>
					<p class="well content_style"><?php echo $commentmsg; ?></p>
				</li>
			<?php
					}
				}
			?>
			</ul>
			<div class="load-com" style="display:none;">
				<img style="margin-bottom: 9px;" src="<?php echo base_url(); ?>img/add.gif" />
			</div>
			<div class="row-fluid">
			<?php
				if($login)
				{
			?>
				<textarea class="span12" style="resize:none;margin-left:0;max-height: 20px;border-radius: 0;" name="type-here" alt="<?php echo $product_id; ?>" onfocus="addtheclass(this, <?php echo $product_id; ?>)" onblur="removetheclass(this, <?php echo $product_id; ?>)" placeholder="Write a Feedback..."></textarea>
			<?php
				}
			?>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div id="csender" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="background: none repeat scroll 0 0 rgba(255, 255, 255, 0.8);font-family: Segoe UI;border-radius: 0px;">
	<div class="modal-header" style="background: none repeat scroll 0 0 #F26A2C;border-bottom: medium none;color: white;">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-white"></i></button>
		<h3 id="myModalLabel" style="font-weight: normal;">Contact Seller</h3>
	</div>
	<form id="csenderform" class="form-horizontal">
		<div class="modal-body">
			<div class="control-group">
				<div class="controls">
					<i class="icon-asterisk icon-white"></i> Please fill out the form.
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputFullname"> Full Name: </label>
				<div class="controls">
					<input type="text" id="inputFullname" name="fname" placeholder="Full Name" required>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputEmail"> Email: </label>
				<div class="controls">
					<input type="text" id="inputEmail" name="emails" placeholder="Email" required>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputSubject"> Subject: </label>
				<div class="controls">
					<input type="text" id="inputSubject" name="subject" placeholder="Subject" required>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="textareaMessage"> Message: </label>
				<div class="controls">
					<textarea id="textareaMessage" name="message" placeholder="Message" style="resize: none;" required></textarea>
				</div>
			</div>
		</div>
		<div class="modal-footer" style="background: none repeat scroll 0 0 rgba(255, 255, 255, 0);border: medium none;box-shadow: none;">
			<button class="btn btn-style" data-dismiss="modal" aria-hidden="true"> Close </button>
			<button class="btn btn-primary btn-style" id="csellerSend" data-loading-text="Sending..."> Send </button>
		</div>
	</form>
</div>

<div id="csConfirm" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="background: none repeat scroll 0 0 rgba(255, 255, 255, 0.8);font-family: Segoe UI;border-radius: 0px;">
  <div class="modal-header" style="background: none repeat scroll 0 0 #F26A2C;border-bottom: medium none;color: white;">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-white"></i></button>
    <h3 id="myModalLabel" style="font-weight: normal;">Contact Seller</h3>
  </div>
  <div class="modal-body">
		<h4 style="color: #333;">Your Message has been sent!</h4>
  </div>
  <div class="modal-footer" style="background: none repeat scroll 0 0 rgba(255, 255, 255, 0);border: medium none;box-shadow: none;">
    <button class="btn btn-style" data-dismiss="modal" aria-hidden="true">Close</button>
  </div>
</div>
<!-- Modal Delete-->
	<div id="feed_delete" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
		<div class="modal-body" style="background-color: #e34e0d;color: #fff;">
				<p>Are you sure you want to delete this comment?</p>
				<input id="comment_id" name="comment_id" type="hidden">
				<p class="pull-right">
					<button id="del-yes" class="btn btn_color" type="submit" style="font-weight: bold;">YES</button>
					<button id="dwno" class="btn btn_color" data-dismiss="modal" aria-hidden="true" type="button" style="font-weight: bold;">NO</button>
				</p>
			</form>
		</div>
	</div>
<script type="text/javascript">
$(document).ready(function(){

	/* detect if sidebar-box max height is less than description height */
	var sidebar_box_height = $('.sidebar-box').height();
	
	if(sidebar_box_height < 121)
	{
		$('.read-more').hide();
	}
	var $el, $ps, $up, totalHeight;
			
	$(".sidebar-box .button_read").click(function() {
		totalHeight = 0;
	
		$el = $(this);
		$p  = $el.parent();
		$up = $p.parent();
		$ps = $up.find("p,ul,div,table,h4,h1,h2,h3,table:not(.read-more)");
		
		// measure how tall inside should be by adding together heights of all inside paragraphs (except read-more paragraph)
		$ps.each(function() {
			totalHeight += $(this).innerHeight();
			// FAIL totalHeight += $(this).css("margin-bottom");
		});
		$up
			.css({
				// Set height to prevent instant jumpdown when max height is removed 
				"height": $up.height(),
				"max-height": 9999
			})
			.animate({
				"height": totalHeight + $('.read-more').height()
			});
		
		// fade out read-more
		$p.fadeOut();
		
		// prevent jump-down
		return false;
			
	});
	$.ajax({
		type: 'post',
		url: '<?php echo base_url(); ?>multi/countshare',
		data: 'urls=<?php echo current_url(); ?>',
		success: function(html)
		{
			$('.countshare').html(html);
		}
	});

$(window).load(function() {
  // The slider being synced must be initialized first
  $('#carousel').flexslider({
    animation: "slide",
    controlNav: false,
    animationLoop: false,
    slideshow: false,
    itemWidth: 90,
    itemMargin: 5,
    asNavFor: '#slider',
    minItems: 2,
    maxItems: 4,
	move: 1
  });
   
  $('#slider').flexslider({
    animation: "slide",
    controlNav: false,
    animationLoop: false,
    slideshow: false,
    sync: "#carousel",
	smoothHeight: true
  });
});

	$('#feed_delete').delegate('#del-yes','click',function(e){
		var comment_id = $('#comment_id').val();
		$.ajax({
			type:'post',
			url:'<?php echo base_url(); ?>test/del_feed_comment',
			data:'type=product&comment_id='+comment_id+'&product_id=<?php echo $product_id; ?>',
			success:function(html){
				$('#feed_delete').modal('hide');
				$('.del_'+comment_id).hide();
			}
		});
	});
	$('.comment-items-hold').delegate('.del-feed-com','click',function(e){
		var com_id = $(this).parents('li').attr('id');
		// alert(com_id);
		$('#comment_id').val(com_id);
		$('#feed_delete').modal('show');
	});

	/* product comment script */
	$('.catalog_bg').delegate('.commentProductClass', 'keypress', function(e){
		if(e.keyCode == 13 && !e.shiftKey) {
			var commentMsg = $(this).val();
			var prodId = $(this).attr('alt');
			var thisdata = 'type=product&commentmsg='+commentMsg+'&prodid='+prodId+'&site_id=<?php echo $wid; ?>';
			$('li.load-com').show();
			if(!commentMsg.match(/\S/))
			{
				$(this).val(' ');
				return false;
			}
			else
			{
				$(this).val(' ');
				$.ajax({
					type:'post',
					url: '<?php echo base_url(); ?>multi/catalogcomment',
					data: thisdata,
					success: function(html) {
						$('.commentProductClass').val(' ');
						$('li.load-com').hide();
						$('ul.comment-items-hold').append(html);
						return true;
					}
				});
			}
			
		}
	});

	$('.buy-now').click(function(){
		var thedatastring = 'product_id=<?php echo $product_id; ?>';
		$.ajax({
			type:'post',
			url:'<?php echo base_url(); ?>multi/cartsession',
			data: thedatastring,
			success: function(html)
			{
				window.location.href="<?php echo base_url().'cart?t=checkout&s='.$web_url; ?>";	
			}
		});
	});
	
	$('.cc-seller').click(function() {
		$('#csender').find('#inputSubject').val('Inquiry for item - <?php echo $pnames; ?>');
		$('#csender').modal('show');
	});

	$('#csenderform').ajaxForm({
			type: 'post',
			url: '<?php echo base_url(); ?>test/sendtoseller',
			data: {
				'product_id': '<?php echo $product_id; ?>',
				'sellermail': '<?php echo $row2['email']; ?>'
			},
			beforeSubmit: function() {
				$('#csellerSend').button('loading');
			},
			success: function(html) {
				$('#csender').modal('hide');
				$('#csenderform')[0].reset();
				$('#csellerSend').button('reset');
				$('#csConfirm').modal('show');
			}
	});

	$('.add-cart').click(function(){
		var detect = $('input[name="variant_option"]:checked').attr('alt');
		var table = '';
		var selected_id = $('input[name="variant_option"]:checked').val();
		
		if(detect == 'product')
		{
			table = 'product';
		}else
		{
			table = 'variant';
		}
		
		// detect if user choose a price
		if(selected_id == undefined)
		{
			return false;
		}
		
		var thedatastring = 'product_id=<?php echo $product_id; ?>&table='+table+'&id='+selected_id;
		
		$.ajax({
			type:'post',
			url:'<?php echo base_url(); ?>multi/cartsession',
			data: thedatastring,
			success: function(html)
			{
				window.location.href = '<?php echo base_url(); ?>cart?t=yourcart&s=<?php echo $url; ?>';
				// $("#popcart").fadeIn(400);
				// $("#popcart").fadeOut(400);
				// $("#popcart").fadeIn(400);
				// $("#popcart").fadeOut(400);
				// $("#popcart").fadeIn(400);
				// $(window).scrollTop(0);
				// Get Total Cart Items
				/* $.ajax({
					type:'post',
					url:'<?php echo base_url(); ?>multi/getcartitems',
					data: thedatastring,
					success: function(html3)
					{
						$('.items-cart').html(html3);
					}
				}); */
				
				// Get Total Cart Price
				/* $.ajax({
					type:'post',
					url:'<?php echo base_url(); ?>multi/carttotal',
					data: thedatastring,
					success: function(html2)
					{
						if(html == '')
						{
							$('.c-total').html('0.00');
						}
						else
						{
							$('.c-total').html(html2);
						}
					}
				}); */
			}
		});
	});

	$('.fbshare').on('click',function() {
		FB.ui(
		  {
			method: 'feed',
			name: '<?php echo str_replace('-', ' ',$product); ?>',
			link: '<?php echo base_url().$web_url.'/'.$page_url.'/'.str_replace(' ', '-',$product).'/'.$product_id; ?>',
			picture: '<?php echo $imgsrc; ?>',
			caption: '<?php echo base_url().$web_url; ?>',
			/* description: '<?php echo html_entity_decode(strip_tags($row1['product_desc']), ENT_QUOTES); ?>' */
		  },
		  function(response) {
			if (response && response.post_id) {
			 console.log('Post was published.');
			} else {
			 console.log('Post was not published.');
			}
		  }
		);
	});
});	

	function addtheclass(x, prod_id)
	{
		//alert(prod_id);
		
		$(x).addClass('commentProductClass');
	}
	
	function removetheclass(x, prod_id)
	{
		$(x).removeClass('commentProductClass');
	}
</script>