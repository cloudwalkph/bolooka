<?php
	$this->db->where('website_id', $wid);
	$queryDesc = $this->db->get('design');
	$bg = $queryDesc->row_array();
	
	$this->db->where('id', $wid);
	$this->db->where('deleted', 0);
	$website_query = $this->db->get('websites');
	$row = $website_query->row_array();
	
	$this->db->where('uid', $row['user_id']);
	$user_query = $this->db->get('users');
	
	$profilePic = 'http://www.placehold.it/160x160/333333/ffffff&text=no+photo';
	
	if($user_query->num_rows() > 0) {
		$row1 = $user_query->row_array();
		if($row1['profile_picture'] != null) {
			$profilePic = $row1['profile_picture'];
			$profilePic = str_replace(" ","_",$profilePic);
			$checkPic = 'uploads/'.$row['user_id'].'/medium/'.$profilePic;
			
			if($this->photo_model->image_exists($checkPic)) {
				$profilePic = base_url().$checkPic;
			} else {
				$checkPic = 'uploads/'.$profilePic;
				if($this->photo_model->image_exists($checkPic)) {
					$profilePic = base_url().$checkPic;
				} else {
					$profilePic = 'http://www.placehold.it/160x160/333333/ffffff&text=image+not+found';
				}
			}
		} else {
			$profilePic = 'http://www.placehold.it/160x160/333333/ffffff&text=no+image';
		}
	} else {
		$profilePic = 'http://www.placehold.it/160x160/333333/ffffff&text=no+image';
	}
	
	$connect_to_query = null;
	
	if($this->input->get('f')) {
		$item_name = $_GET['f'];
		if($item_name != 'All')
		{
			$connect_to_query = '(category LIKE "%'.$item_name.'%" OR sub_category LIKE "%'.$item_name.'%")';
		}
	} else if($this->input->get('s')) {
		$item_word = $_GET['s'];
		if($item_word) {
			$connect_to_query = '(name LIKE "%'.$item_word.'%")';
		}
	}

	$this->db->where('page_id', $pid);
	$this->db->where('website_id', $wid);
	$this->db->where('published', 1);
	$total_prod = $this->db->get('products');
	
	// $query_prod = $this->db->query("SELECT * FROM products WHERE page_id='".$pid."' AND `name` NOT LIKE '' AND website_id='".$wid."' AND published = 1 ".$connect_to_query." ORDER BY id desc LIMIT 12");
	$this->db->select('*');
	$this->db->from('products');
	$this->db->where('page_id', $pid);
	$this->db->where('website_id', $wid);
	$this->db->where('published', 1);
	if($connect_to_query) {
		$this->db->where($connect_to_query, null, false);
	}
	if($wid == 364)
	{
		$this->db->order_by('id asc');
	}else
	{
		$this->db->order_by('id desc');
	}
	$limit = 12;
	$this->db->limit($limit);
	$this->db->where('(name NOT LIKE "")', null, false);
	$query_prod = $this->db->get();
	
	
	/* this for filter prod */
	$this->db->distinct();
	$this->db->select('category');
	$this->db->where('page_id',$pid);
	$this->db->where('website_id',$wid);
	$this->db->where('published',1);
	$this->db->order_by('category','asc');
	$query_selection = $this->db->get('products');
	
	/* for sub category */
	$this->db->distinct();
	$this->db->select('sub_category');
	$null_entity = array('','0');
	$this->db->where_not_in('sub_category',$null_entity);
	$this->db->where('page_id',$pid);
	$this->db->where('website_id',$wid);
	$this->db->where('published',1);
	$this->db->order_by('category','asc');
	$query_selection_sub_categ = $this->db->get('products');
	
	$quePage = $this->db->query("SELECT * FROM pages WHERE website_id='$wid'");
	$pgName = '';
	if($quePage->num_rows() > 0)
	{
		foreach($quePage->result_array() as $rwpg)
		{
			if($rwpg['type'] == 'contact_us')
			{
				$pgName = $rwpg['name'];
			}
		}
	}
	
	$query2 = $this->db->query("SELECT website_id FROM follow WHERE website_id='$wid'");
	if($layout == 'layout2' || $layout == 'layout4' || $layout == 'layout5')
	{
		$float_left_sides = 'float:right; margin-left: margin-left: 2.564102564102564%;';
		$float_catalog_bg = 'float:left;margin-left:0;';
	}else
	{
		$float_left_sides = '';
		$float_catalog_bg = '';
	}
	
?>
	<div class="row-fluid">
		<div class="span3 left-sides" style="<?php echo $float_left_sides; ?> margin-bottom: 8px;">
			<div class="row-fluid catalog-area catalog_bg" style="text-align: center; margin-bottom: 8px">
				<input class="key_search" onfocus="this.placeholder=''" onkeypress="onKeySearch(this)" type="text" placeholder="Search…" style="margin: 10px; width: 72%;" value="">
			</div>
			<div class="row-fluid catalog_bg" style="border-radius: 12px; text-align: center;">
				<div style="margin-bottom: 10px;">
					Site Owner
				</div>
				<div class="row-fluid">
					<div class="container-fluid">
						<img class="img-polaroid" src="<?php echo $profilePic; ?>" style="max-width: 90%; max-height: 145px; margin-bottom: 10px;" />
					</div>
				</div>
				<div class="row-fluid">
<?php
				$the_user = $this->session->userdata('uid');
				$the_website = $wid;
				$fdback = '';		
				$this->db->where('page_id', $pid);
				$this->db->where('website_id', $wid);
				$prod_feed = $this->db->get('products');
				foreach($prod_feed->result_array() as $rowp)
				{
					$prod_id = $rowp['id'];
					$thefeedback = $this->db->query("SELECT * FROM comments WHERE msg_id_fk='$prod_id' AND type='product'");
					$fdback += $thefeedback->num_rows();
				}
				$query = $this->db->query("SELECT * FROM follow WHERE users='$the_user' AND website_id='$the_website'");
				if($query->num_rows() > 0)
				{
					$followlink = 'unfollow';
				}
				else
				{
					$followlink = 'follow';
				}
			
?>
<?php 
				if($this->session->userdata('logged_in'))
				{
					if($this->session->userdata('uid') != $row['user_id'])
					{
?>
				<div class="row-fluid" style="margin-bottom: 8px;">
					<a href="#chat" role="button" class="btn span10 offset1" data-toggle="modal">Message</a>
				</div>
<?php
					}
?>
				<div class="row-fluid" style="margin-bottom: 8px;">
					<a href="#" class="btn span10 offset1 follow_event <?php echo ($query->num_rows() > 0) ? 'unfollow_class' : 'follow_class' ;?>" alt="<?php echo $followlink; ?>">
						<i class="icon-plus-sign" style="margin-top: 3px;"></i>
					</a>
				</div>
<?php 
				}
?>	
				<table style="margin: 0 auto 10px;">
					<tbody>
<?php 
							if($query2->num_rows() > 0){
?>
						<tr>
							<td style="text-align:right;">Followers:</td>
							<td><?php echo $query2->num_rows(); ?></td>
						</tr>
<?php
							}
							if($fdback > 0){
?>
						<tr>
							<td style="text-align:right;">Feedback:</td>
							<td><?php echo $fdback; ?></td>
						</tr>
<?php
							}
?>
						<tr style="display:none;">
							<td style="text-align:right;">Sold Item(s):</td>
							<td>0</td>
						</tr>
<?php
							if($total_prod->num_rows() > 0){
?>					
						<tr>
							<td style="text-align:right;">Total Products:</td>
							<td><?php echo $total_prod->num_rows(); ?></td>
						</tr>
<?php
							}
?>					
					</tbody>
				</table>
				</div>		
			</div>
		</div>
		<div class="span9 catalog_bg" style="<?php echo $float_catalog_bg; ?>">
			<div class="row-fluid product_title">
				<div class="pull-left" style="margin: 10px;">
					<span>Product Catalogue</span>
						<input type="hidden" class="offset">
				</div>
				<div class="pull-right">
					<select class="filter_prod" type="text" onchange="onFilter(this)">
						<option value="All">All</option>
			<?php
				$get_cat = '';
				if(isset($_GET['f']))
				{
					if($_GET['f'] != 'All')
					{
						$get_cat = $_GET['f'];
				
					}
				}

				foreach($query_selection->result_array() as $rowSelect)
				{
					$selected_cat = $rowSelect['category'] == $get_cat ? 'selected' : '';
					if($rowSelect['category'] != 'others')
					{
						echo '<option value="'.$rowSelect['category'].'" '.$selected_cat.'>'.ucwords(strtolower($rowSelect['category'])).'</option>';
					}
				}
				
				foreach($query_selection_sub_categ->result_array() as $rowSelect_sub)
				{
					$selected_cat = $rowSelect_sub['sub_category'] == $get_cat ? 'selected' : '';
					echo '<option value="'.$rowSelect_sub['sub_category'].'" '.$selected_cat.'>'.ucwords(strtolower($rowSelect_sub['sub_category'])).'</option>';
				}
				
				$this->db->distinct();
				$this->db->select('category');
				$this->db->where('page_id',$pid);
				$this->db->where('website_id',$wid);
				$this->db->where('published',1);
				$this->db->where('category','others');
				$this->db->order_by('category','asc');
				$query_selection_others = $this->db->get('products');
				$query_selection_others_row = $query_selection_others->row();
				if($query_selection_others->num_rows() > 0)
				{
					$selected_cat = $rowSelect['category'] == $get_cat ? 'selected' : '';
					echo '<option value="'.$query_selection_others_row->category.'" '.$selected_cat.'>'.ucwords(strtolower($query_selection_others_row->category)).'</option>';
				}
			?>
					</select>
				</div>
			</div>
			
		<?php 
			if($query_prod->num_rows() > 0)
			{
				$imgSrc = 'http://www.placehold.it/180x180/333333/ffffff&text=no+image';
		?>
			<ul class="unstyled text-center move_center_mobile">
		<?php
				foreach($query_prod->result_array() as $rowp)
				{
					$prod_name = $rowp['name'];
					$prod_id = $rowp['id'];
					$thefeedback = $this->db->query("SELECT * FROM comments WHERE msg_id_fk='$product_id'");
					
					$this->db->where('product_id',$prod_id);
					$this->db->order_by('price asc');
					$variant = $this->db->get('product_variants');
					$variant_row = $variant->row();
					
					if($this->db->field_exists('product_cover', 'products')) {
						$cover = $rowp['product_cover'];
					} else {
						$cover = $rowp['primary'];
					}
					
					$checkPic = 'uploads/' . $row['user_id'] . '/' . $wid . '/' . $pid . '/' . $prod_id . '/s180x180/' .$cover;
					if($this->photo_model->image_exists($checkPic)) {
						$imgSrc = base_url().$checkPic;
					} else {
						$checkPic = 'uploads/' . $row['user_id'] . '/' . $wid . '/' . $pid . '/' . $prod_id . '/' .$cover;
						if($this->photo_model->image_exists($checkPic)) {
							$s180 = $this->photo_model->custom_thumbnail($checkPic, 180, 180);
							$imgSrc = base_url().$s180;
						} else {
							$imgSrc = 'http://www.placehold.it/180x180/333333/ffffff&text=image+not+found';
						}
					}
					
		?>
			<li class="box" style="background-image: url('<?php echo $imgSrc; ?>'); background-position: top center; background-repeat: no-repeat; background-size: cover;">
				<a class="cat-items" data-id="<?php echo $prod_id; ?>" style="color:#fff;" href="<?php echo base_url().url_title($url, '-', true).'/'.url_title($page_url, '-', true).'/'.url_title($prod_name, '-', true).'/'.$prod_id; ?>">
					<div class="fade_gradient">
						<div class="product_label trim text-center">
							<strong>
							<?php // echo $this->trim_text->trim_string($prod_name, 10); ?>
							<?php echo html_entity_decode($prod_name, ENT_QUOTES); ?>
							</strong>
						</div>
						<?php if($rowp['price'] > 0){ ?>
						<div class="price_in_a_box">Php <?php echo number_format($rowp['price'], 2,'.',','); ?></div>
						<?php }else if($variant->num_rows() > 0 && $variant_row->price) {?>
						<div class="price_in_a_box"><?php echo $variant->num_rows() > 1 ? 'Start at' : ''; ?> Php <?php echo number_format($variant_row->price, 2,'.',','); ?></div>
						<?php }?>
					</div>
				</a>
			</li>
		<?php
				}
		?>
			</ul>
		<?php
			} else {
				if(isset($_GET['s']))
				{
					$data['saying'] = 'No Result';
					$this->load->view('templates/types/no_contents',$data);
				}else
				{
					if($this->session->userdata('logged_in'))
					{
						$data['saying'] = 'You don&rsquo;t have any products.';
						$this->load->view('templates/types/no_contents',$data);
					}else
					{
						$data['saying'] = 'No products available.';
						$this->load->view('templates/types/no_contents',$data);
					}
				}
			}		
		?>

			<div class="clearfix"></div>
			<div class="loading-area"></div>
		</div>
	</div>
	
    <div id="chat" class="modal hide fade" style="color: #000;">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4>To: <?php echo $row1['name']; ?></h4>
		</div>
		<div class="modal-body">
			<textarea id="chat_msg" placeholder="Message here..." style="resize: none; width: 90%;" autocomplete="off"></textarea>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn" data-dismiss="modal">Close</a>
			<a id="send_msg" href="#" class="btn btn-primary">Send</a>
		</div>
    </div>
	
<script>
var catalogScroll = false;
$(function(){
	$('.offset').val(1);
	$('#send_msg').click(function() {
		var dataString = { 'from': '<?php echo $this->session->userdata('uid'); ?>', 'to': '<?php echo $row1['uid']; ?>', 'message': $('#chat_msg').val() };
		$.ajax({
			beforeSend: function() {
			},
			type: "POST",
			url: "<?php echo base_url(); ?>test/chat",
			data: dataString,
			success: function(html)
			{
				$('#chat').modal('hide');
				$('#chat_msg').val('');
			}
		});
	});

		<?php
			if($query_prod->num_rows() > 0)
			{
		?>
		$(window).scroll(function(){
			var winScroll = $(window).scrollTop();
			var docuHeight = $(document).height();
			var winHeight = $(window).height();			
			var docuHeight_winHeight = docuHeight - winHeight;

			if(winScroll + 20 >= docuHeight_winHeight)
			{
				if(window.catalogScroll == false)
				{
					show_catalog_item();
					window.catalogScroll = true;
				}
			}
		});
		<?php
			}
		?>
});	

	function show_catalog_item() {
		var ID = $(".cat-items:last").attr("data-id"),
			dataString = { 
				// lastId: ID, 
				filter: '<?php echo isset($item_name) ? $item_name : ''; ?>', 
				search: '<?php echo isset($item_word) ? $item_word : ''; ?>', 
				// ctoquery: '<?php echo $connect_to_query; ?>', 
				pid: '<?php echo $pid; ?>',
				limit: <?php echo $limit; ?>,
				offset: Number($('.offset').val()) + 1,
				wid: '<?php echo $wid; ?>', 
				web_url: '<?php echo $url; ?>', 
				page_url: '<?php echo $page_url; ?>' 
			};
		$.ajax({
			beforeSend: function() {
				$('.loading-area').empty();
				$('.loading-area').html('<p style="text-align: center;"><img src="<?php echo base_url(); ?>img/add.gif" /></p>');			
			},
			type: 'post',
			url: "<?php echo base_url(); ?>test/catalog_second",
			data: dataString,
			cache: false,
			success: function(html)
			{
				if(html != 'lana')
				{
					window.catalogScroll = false;
					$(".box:last").after(html);
					$('.loading-area').empty();
					$('.offset').val(dataString.offset);
				}
				else
				{
					$('.loading-area').empty();
					$('.loading-area').html('<h5 style="text-align: center;font-weight: normal;margin-top: 0;margin-bottom: 16px;">No more products</h5>');
				}
			}
		});
	}

	$('.follow_event').on('click',function() {
		var type = $(this).attr('alt');
		var dataString = 'siteurl=1&uid=<?php echo $the_user; ?>&website_id=<?php echo $the_website; ?>';
		
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>test/"+type,
			data: dataString,
			cache: false,
			success: function(html)
			{
				window.location = '<?php echo current_url(); ?>';
			}
		});
	});
	
	function onFilter(x)
	{
		var selected = $(x).val();
		window.location = '<?php echo current_url(); ?>?f='+selected+'';
	}
	
	function onKeySearch(e)
	{

		if (window.event.keyCode == 13)
        {
            var word = $(e).val();
			if(word == '' || word == ' ')
			{
				return false;
			}else
			{
				window.location = '<?php echo current_url(); ?>?s='+word+'';
			}
        }
	}
</script>
<style type="text/css">
.product_title {
    border-radius: 8px 8px 0 0;
}
.catalog_bg {
    border-radius: 8px;
}
.box {
    display: inline-block;
    height: 180px;
    margin-bottom: 8px;
    margin-left: 4px;
    margin-right: 4px;
    position: relative;
    width: 180px;
}
.product_label {
    border-bottom: 1px solid white;
    font-weight: bold;
    margin: auto;
    width: 170px;
}
.move_center_mobile {
	padding-top: 10px;
}
.filter_prod {
	margin: 5px;
	width: auto;
}
.fade_gradient{
background: -moz-linear-gradient(top, rgba(48,47,47,0.68) 0%, rgba(68,68,68,0) 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(48,47,47,0.68)), color-stop(100%,rgba(68,68,68,0))); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top, rgba(48,47,47,0.68) 0%,rgba(68,68,68,0) 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top, rgba(48,47,47,0.68) 0%,rgba(68,68,68,0) 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top, rgba(48,47,47,0.68) 0%,rgba(68,68,68,0) 100%); /* IE10+ */
background: linear-gradient(to bottom, rgba(48,47,47,0.68) 0%,rgba(68,68,68,0) 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ad302f2f', endColorstr='#00444444',GradientType=0 ); /* IE6-9 */

    height: 100%;
    width: 100%;
	opacity: 1;

    transition: opacity 0.5s ease 0s;
	-moz-transition: opacity 0.5s ease 0s; /* Firefox 4 */
	-webkit-transition: opacity 0.5s ease 0s; /* Safari and Chrome */
	-o-transition: opacity 0.5s ease 0s; /* Opera */
}
.price_in_a_box {
    background: none repeat scroll 0 0 rgb(33, 33, 33);
    border: 1px solid rgb(255, 255, 255);
    bottom: 10px;
    color: rgb(242, 242, 242);
    padding: 2px;
    position: absolute;
    right: 10px;
	opacity: 1;
}
.fade_gradient:hover, .fade_gradient:hover div, .fade_gradient:hover .price_in_a_box {
	opacity: 0;
}
.follow_event:hover{

}
.unfollow_class:hover {
border: 1px solid rgb(234,93,88);
color:#fff;
text-shadow:none;
background: rgb(234,93,88); /* Old browsers */
background: -moz-linear-gradient(top, rgba(234,93,88,1) 0%, rgba(199,64,55,1) 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(234,93,88,1)), color-stop(100%,rgba(199,64,55,1))); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top, rgba(234,93,88,1) 0%,rgba(199,64,55,1) 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top, rgba(234,93,88,1) 0%,rgba(199,64,55,1) 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top, rgba(234,93,88,1) 0%,rgba(199,64,55,1) 100%); /* IE10+ */
background: linear-gradient(to bottom, rgba(234,93,88,1) 0%,rgba(199,64,55,1) 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ea5d58', endColorstr='#c74037',GradientType=0 ); /* IE6-9 */
}
.follow_class:after {
	content: 'Follow';
}
.unfollow_class:hover span {
	display: none;
}
.unfollow_class:after {
	content: 'Following';
}
.unfollow_class:hover:after {
	content: 'Unfollow';
}
</style>