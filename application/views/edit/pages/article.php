<?php
	/* insert article image module *
	$data['position'] = 'top';
	$this->load->view('edit/pages/insert_article_image', $data);
	/* */
?>
<?php
	$attributes = array('class' => 'article_form well', 'id' => 'article_form', 'name' => 'article_form');
	echo form_open('', $attributes);
?>
<?php
	$this->db->where('page_id', $pid);
	$queryArticle = $this->db->get('articles');
	# if no content in article table will get old content in pages table
	$countArticle = $queryArticle->num_rows();
	if($countArticle == '0') {
		$this->db->where('website_id', $wid);
		$queryArticle = $this->db->get('pages');
	}
	# end
	$rowArticle = $queryArticle->row();

	$content = '
		<h2>Welcome to your Site</h2>

		<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Cras et ipsum quis mi semper accumsan. Integer pretium dui id massa. Suspendisse in nisl sit amet urna rutrum imperdiet. Nulla eu tellus. Donec ante nisi, ullamcorper quis, fringilla nec, sagittis eleifend, pede. Nulla commodo interdum massa. Donec id metus. Fusce eu ipsum. Suspendisse auctor. Phasellus fermentum porttitor risus.</p>

		<h3>Services</h3>

		<ul>
			<li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Cras et ipsum quis mi semper accumsan.</li>
			<li>Integer pretium dui id massa. Suspendisse in nisl sit amet urna rutrum imperdiet.</li>
			<li>Nulla eu tellus. Donec ante nisi, ullamcorper quis, fringilla nec, sagittis eleifend, pede.</li>
			<li>Nulla commodo interdum massa. Donec id metus. Fusce eu ipsum. Suspendisse auctor. Phasellus fermentum porttitor risus.</li>
		</ul>
	';
?>
		<div class="contents">
			<!-- This div will be used to display the editor contents. -->
			<div class="editorcontents editable">
				<?php echo (isset($rowArticle->content)) ? $rowArticle->content : $content; ?>
			</div>
			<div class="hide article_content">
			</div>
			<div id="article_buttons" class="article_btn btn-toolbar" style="display: none;text-align: right;">
				<div class="btn-group">
				<?php
					$data = array(
						'name' => 'article_reset',
						'class' => 'article_reset btn',
						'value' => 'true',
						'type' => 'reset',
						'content' => 'Cancel',
						'data-loading-text' => "Loading..."
					);
					echo form_button($data);
				?>
				</div>
				<div class="btn-group">
				<?php
					$data = array(
						'name' => 'article_submit',
						'class' => 'article_submit btn',
						'value' => 'true',
						'type' => 'button',
						'content' => 'Save'
					);
					echo form_button($data);
				?>
				</div>
			</div>
		</div>
<?php
	echo form_close();
?>
<?php
	/* insert article image module *
	$data['position'] = 'bottom';
	$this->load->view('edit/pages/insert_article_image', $data);
	/* */
?>
<script>
$(function() {
	$('.show_gallery_modal').click( function(e) {
		e.stopPropagation();
		$.ajax({
			type: 'post',
			url: '<?php echo base_url('test/get_gallery'); ?>',
			data: { 'web_id': <?php echo $wid; ?>, 'position': $(e.target).attr('data-image-position') },
			xhr: function() {
				var xhr = new window.XMLHttpRequest();
				xhr.addEventListener("progress", function(evt){
					if (evt.lengthComputable) {
						var percentComplete = (evt.loaded / evt.total) * 100;
					}
				}, false);
				return xhr;
			},
			success: function(html) {
				$(e.target).parents('#article_image_container').find('.albums_container').html(html);
				$(e.target).fadeOut().remove();
			}
		});
	});

	$('.albums_container').on('click', 'a', function(e) {
		e.preventDefault();
		thumbnail = $(this);
		page_id = $(this).parents('.page').attr('id');
		str = $(this).parents('li').attr('class');
		var n = str.split("-");
		var gallery_id = n[1];
		$.ajax({
			async: false,
			type: 'post',
			url: '<?php echo base_url('test/insert_image_article'); ?>',
			data: { 'gallery_id': gallery_id, 'page_id': page_id, 'position': thumbnail.attr('data-image-position') },
			success: function(html) {
				thumbnail.addClass('btn-info');
			}
		});
	});

	$('.albums_container').on('click', 'a.btn-info', function(e) {
		e.preventDefault();
		thumbnail = $(this);
		page_id = $(this).parents('.page').attr('id');
		str = $(this).parents('li').attr('class');
		var n = str.split("-");
		var gallery_id = n[1];
		$.ajax({
			async: false,
			type: 'post',
			url: '<?php echo base_url('test/remove_image_article'); ?>',
			data: { 'gallery_id': gallery_id, 'page_id': page_id, 'position': thumbnail.attr('data-image-position') },
			success: function(html) {
				thumbnail.removeClass('btn-info');
			}
		});		
	});

	// $('.insert_image').on('click', function(e) {
		// e.preventDefault;
		// var dataString = { 'wid': <?php echo $wid; ?> }
		// $.ajax({
			// type: 'post',
			// url: '<?php echo base_url('manage/get_albums'); ?>',
			// data: dataString,
			// beforeSend: function() {},
			// success: function(html) {
				// console.log(html);
			// }
		// });
	// });

});
</script>