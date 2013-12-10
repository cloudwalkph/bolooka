<style>
.edit {
	background-color: #FFFFFF;
	border: 1px solid #DDDDDD;
	border-radius: 4px 4px 4px 4px;
	position: relative;
}
#webname {
	font-size:18px; font-family: Segoe UI Semibold; color: #171717;
}
#prev-btn {
    background: none repeat scroll 0 0 #08c;
    border: 0 none;
    border-radius: 0 0 0 0;
    color: #fff;
    font-family: Segoe UI Semibold;
    font-size: 14px;
    margin-top: 2px;
    padding: 8px 16px;
	text-shadow: none;
}
#prev-btn:hover {
	background: #DDDDDD;
	color: #0088CC;
}
/* RESPONSIVE */
@media (max-width: 767px)
{
	.mobile_view {
		padding: 0 8px;
	}
}
</style>
<?php
	$wid = $this->input->get('wid');

	$this->db->where('id', $wid);
	$queryWeb = $this->db->get('websites');
	$rowWeb = $queryWeb->row_array();

?>
	<div class="container-fluid mobile_view">
			<div class="row-fluid">
				<legend>
					<a id="webname" href="<?php echo base_url(); ?><?php echo $rowWeb['url']; ?>"><?php echo $rowWeb['site_name']; ?></a>
					<a id="prev-btn" class="btn pull-right" href="<?php echo base_url().url_title($rowWeb['url'],'',true); ?>" target="<?php echo $rowWeb['url']; ?>">PREVIEW</a>
				</legend>
			</div>
			<div class="row-fluid" style="padding-top: 10px;">
				<ul class="nav nav-tabs edit-tabs" style="padding-left: 10px;">
					<li><a alt="details" href="#details" data-toggle="tab">Details</a></li>
					<li><a alt="pages" href="#pages" data-toggle="tab">Pages</a></li>
					<li><a alt="layout" href="#layout" data-toggle="tab">Layout</a></li>
					<li class="domaintab hide"><a alt="domain" href="#domain" data-toggle="tab">Domain</a></li>
<!-- hidden for the meantime --
					<li class="bannertab"><a alt="banner" href="#banner" data-toggle="tab">Banner</a></li>
-->
				</ul>
				 
				<div class="tab-content">
					<div class="tab-pane active" id="details">
<?php
						echo isset($details) ? $details : null;
?>
					</div>
					<div class="tab-pane" id="pages">
<?php
						echo isset($pages) ? $pages : null;
?>
					</div>
					<div class="tab-pane" id="layout">
<?php
						echo isset($layout) ? $layout : null;
?>
					</div>
					<div class="tab-pane" id="domain">
<?php
						// echo isset($domain) ? $domain : null;
?>
					</div>
					<div class="tab-pane" id="banner">
<?php
						echo isset($banner) ? $banner : null;
?>
					</div>
				</div>
			</div>
	</div>

<script>
	$(function() {
		$('a[data-toggle="tab"]').on('shown', function (e) {
			/* save the latest tab; use cookies if you like 'em better: */
			sessionStorage.setItem('lastTab', $(e.target).attr('alt'));
		});

		/* go to the latest tab, if it exists: */
		var lastTab = sessionStorage.getItem('lastTab');
		if (lastTab) {
			$('a[href="#'+lastTab+'"]').tab('show');
			// show_tab_content($('a[href="#'+lastTab+'"]'));
		} else {
			$('a[href="#details"]').tab('show');
			// show_tab_content($('a[href="#details"]'));
		}
		
		// $('a[data-toggle="tab"]').on('show', function (e) {
			// e.target; // activated tab
			// e.relatedTarget; // previous tab
			// show_tab_content(e.target);
		// });
		
		function show_tab_content(e) {
			$.ajax({
				beforeSend: function() {
					$('#'+$(e).attr('alt')).html('<center><img src="<?php echo base_url(); ?>img/bigLoader.gif"></center>');
				},
				url: '<?php echo base_url(); ?>manage/get_tab_content',
				data: { wid: '<?php echo $wid; ?>', edit: $(e).attr('alt')},
				success: function(html) {
					$('#'+$(e).attr('alt')).html(html);
				}
			});			
		}

<?php
	if(isset($_GET['paypal'])){
?>
		$('.tab-content .tab-pane').removeClass('active');
		$('ul.edit-tabs li').removeClass('active');
		$('ul.edit-tabs li.domaintab').addClass('active');
		$('.tab-content #domain').addClass('active');
<?php
	}
?>
	});
</script>