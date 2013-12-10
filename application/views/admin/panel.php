	<div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
		  <a class="invrot" href="<?php echo base_url(); ?>" style="line-height: 40px; "><img src="img/dashboard-logo.png"></a>
		  <div class="nav-collapse collapse pull-right">
<?php
	if($this->session->userdata('uid')) {
?>
            <ul class="nav pull-right">
              <li class="divider-vertical"></li>
              <li><a href="<?php echo base_url().'logout'; ?>">Log-out</a></li>
            </ul>			
			<p class="hidden-phone hidden-tablet navbar-text pull-right">
              <a class="navbar-link">Mabuhay, <?php echo $this->session->userdata('username'); ?>!</a>
            </p>
<?php
	} else {
?>
            <form class="navbar-form pull-right">
              <input class="span2" type="text" placeholder="Email">
              <input class="span2" type="password" placeholder="Password">
              <button type="submit" class="btn">Sign in</button>
            </form>
<?php
	}
?>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
	
<div class="container-fluid" style="padding-top: 60px;">
	<div class="row-fluid">
		<div class="span12">

			<ul class="nav nav-tabs" id="myTab">
				<li class="active"><a href="#m-c" alt="m-c"> Marketplace Control </a></li>
				<li><a href="#w-c" alt="w-c"> Websites Control </a></li>
				<li><a href="#u" alt="u"> Users </a></li>
				<li><a href="#w" alt="w"> Websites </a></li>
				<li><a href="#p" alt="p"> Products </a></li>
				<li><a href="#s" alt="s"> Sold Items </a></li>
				<li><a href="#prod_inquire" alt="prod_inquire"> Product Inquiries </a></li>
				<li><a href="#statistic" alt="statistic"> Statistics </a></li>
			</ul>
			
			<div class="tab-tools">
				
			</div>

			<div class="tab-content">
				<div class="tab-pane active" id="m-c">
				<?php
					echo $marketplace_control;
				?>
				</div>
				<div class="tab-pane" id="w-c"> <?php echo $websites_control; ?> </div>
				<div class="tab-pane" id="u"> <?php echo $users; ?> </div>
				<div class="tab-pane" id="w"> <?php echo $websites; ?> </div>
				<div class="tab-pane" id="p"> <?php echo $products; ?> </div>
				<div class="tab-pane" id="s"> <?php echo $this->load->view('admin/sold_items'); ?> </div>
				<div class="tab-pane" id="prod_inquire"> <?php echo $this->load->view('admin/prod_inquire'); ?> </div>
				<div class="tab-pane" id="statistic"> <?php echo $this->load->view('admin/statistics'); ?> </div>
			</div>
	
		</div>
	</div>
</div>
<script>
$(function() {

	$( ".from" ).datepicker({
		// defaultDate: "+1w",
		changeMonth: true,
		changeYear: true,
		dateFormat: "M d, yy",
		onClose: function( selectedDate ) {
			$(this).parent().find( ".to" ).datepicker( "option", { minDate: selectedDate });
		}
	});

	var today = new Date();
	$( ".to" ).datepicker({
		defaultDate: "+1w",
		changeMonth: true,
		changeYear: true,
		dateFormat: "M d, yy",
		onClose: function( selectedDate ) {
			$(this).parent().find(".from").datepicker( "option", { maxDate: selectedDate });
		}
	});

	sessionStorage.setItem('offset-m-c', 1);
	sessionStorage.setItem('offset-u', 1);
	sessionStorage.setItem('offset-w', 1);
	sessionStorage.setItem('offset-p', 1);
	
	sessionStorage.setItem('orderby-m-c', 'id desc');

	$('#myTab a').click(function (e) {
		e.preventDefault();
		$(this).tab('show');
	});

	$('#myTab a').on('shown', function (e) {
		//save the latest tab; use cookies if you like 'em better:
		sessionStorage.setItem('lastTab', $(e.target).attr('alt'));
		sessionStorage.setItem('orderby-'+sessionStorage.getItem('lastTab'), $('#'+sessionStorage.getItem('lastTab')).find('th:first-child[data-order]').attr('data-order') + ' desc');
		// sessionStorage.setItem('offset-'+sessionStorage.getItem('lastTab'), 1);
		sessionStorage.removeItem('datefrom-'+sessionStorage.getItem('lastTab'));
		sessionStorage.removeItem('dateto-'+sessionStorage.getItem('lastTab'));
		$(window).unbind('scroll').bind('scroll', getNewElements);
	});

	/* go to the latest tab, if it exists: */
	var lastTab = sessionStorage.getItem('lastTab');
	if (lastTab) {
		$('a[href="#'+lastTab+'"]').tab('show');
	} else {
		sessionStorage.setItem('lastTab', $('.tab-content .active').attr('id'));
	}
	/* */
	
	/* for lazy loading */
	sessionStorage.setItem('offset-'+sessionStorage.getItem('lastTab'), 1);
	sessionStorage.setItem('range', '<?php echo $range; ?>');
	sessionStorage.setItem('searchvalue', '');
	
	function appendElements($container, dataString) {
		$.ajax({
			url: '<?php echo base_url(); ?>test/loadmore',
			type: 'get',
			data: dataString,
			async: false,
			beforeSend: function(a,b) {
				$(window).unbind('scroll');
			},
			success: function(newElements) {
				if(newElements != '') {
						var $newElems = $( newElements );	// hide new items while they are loading
							$container
								.append( $newElems );

				} else {
					$(window).unbind('scroll');
				}
			},
			complete: function() {
				$(window).bind('scroll', getNewElements);			
			}
		}).done( function() {
			
		});
	}

	function getNewElements(e) {
		if(($(window).scrollTop() + 1000) >= ($(document).height() - $(window).height()))
		{
			sessionStorage.setItem('offset-'+sessionStorage.getItem('lastTab'), Number(sessionStorage.getItem('offset-'+sessionStorage.getItem('lastTab'))) + 1);
			var $container = $('.tab-content .active tbody'),
				dataString = {
					'range': sessionStorage.getItem('range'), 
					'offset': sessionStorage.getItem('offset-'+sessionStorage.getItem('lastTab')),
					'activetab': sessionStorage.getItem('lastTab'), 
					'searchvalue': sessionStorage.getItem('searchvalue'),
					'datefrom': sessionStorage.getItem('datefrom-'+sessionStorage.getItem('lastTab')),
					'dateto': sessionStorage.getItem('dateto-'+sessionStorage.getItem('lastTab')),
					'orderby': sessionStorage.getItem('orderby-'+sessionStorage.getItem('lastTab'))
				};
			appendElements($container, dataString);
		}
	}
	$(window).bind('scroll', getNewElements);
	
	function loadElements($container, dataString, e) {
		
		var loading = $.ajax({
			type: 'post',
			url: '<?php echo base_url(); ?>test/loadmore',
			data: dataString,
			beforeSend: function() {
				$(e).append('<img class="loader" src="data:image/gif;base64,R0lGODlhEAAQAPMAAP///wAAAAAAAIKCgnNzc6ioqLy8vM7Ozt7e3pSUlOjo6GlpaQAAAAAAAAAAAAAAACH5BAkKAAAAIf4aQ3JlYXRlZCB3aXRoIGFqYXhsb2FkLmluZm8AIf8LTkVUU0NBUEUyLjADAQAAACwAAAAAEAAQAAAEKxDISau9OE/Bu//cQBTGgWDhWJ5XSpqoIL6s5a7xjLeyCvOgIEdDLBqPlAgAIfkECQoAAAAsAAAAABAAEAAABCsQyEmrvThPwbv/XJEMxIFg4VieV0qaqCC+rOWu8Yy3sgrzoCBHQywaj5QIACH5BAkKAAAALAAAAAAQABAAAAQrEMhJq704T8G7/9xhFMlAYOFYnldKmqggvqzlrvGMt7IK86AgR0MsGo+UCAAh+QQJCgAAACwAAAAAEAAQAAAEMRDISau9OE/Bu/+cghxGkQyEFY7lmVYraaKqIMpufbc0bLOzFyXGE25AyI5myWw6KREAIfkECQoAAAAsAAAAABAAEAAABDYQyEmrvThPwbv/nKQgh1EkA0GFwFie6SqIpImq29zWMC6xLlssR3vdZEWhDwBqejTQqHRKiQAAIfkECQoAAAAsAAAAABAAEAAABDYQyEmrvThPwbv/HKUgh1EkAyGF01ie6SqIpImqACu5dpzPrRoMpwPwhjLa6yYDOYuaqHRKjQAAIfkECQoAAAAsAAAAABAAEAAABDEQyEmrvThPwbv/nKUgh1EkAxFWY3mmK9WaqCqIJA3fbP7aOFctNpn9QEiPZslsOikRACH5BAkKAAAALAAAAAAQABAAAAQrEMhJq704T8G7/xymIIexEOE1lmdqrSYqiGTsVnA7q7VOszKQ8KYpGo/ICAAh+QQJCgAAACwAAAAAEAAQAAAEJhDISau9OE/Bu/+cthBDEmZjeWKpKYikC6svGq9XC+6e5v/AICUCACH5BAkKAAAALAAAAAAQABAAAAQrEMhJq704T8G7/xy2EENSGOE1lmdqrSYqiGTsVnA7q7VOszKQ8KYpGo/ICAAh+QQJCgAAACwAAAAAEAAQAAAEMRDISau9OE/Bu/+ctRBDUhgHElZjeaYr1ZqoKogkDd9s/to4Vy02mf1ASI9myWw6KREAIfkECQoAAAAsAAAAABAAEAAABDYQyEmrvThPwbv/HLUQQ1IYByKF01ie6SqIpImqACu5dpzPrRoMpwPwhjLa6yYDOYuaqHRKjQAAIfkECQoAAAAsAAAAABAAEAAABDYQyEmrvThPwbv/nLQQQ1IYB0KFwFie6SqIpImq29zWMC6xLlssR3vdZEWhDwBqejTQqHRKiQAAIfkECQoAAAAsAAAAABAAEAAABDEQyEmrvThPwbv/3EIMSWEciBWO5ZlWK2miqiDKbn23NGyzsxclxhNuQMiOZslsOikRADs=">')
				$(window).unbind('scroll');
			},
			success: function(newElements) {
				if(newElements) {
					var $newElems = $( newElements );
						$container
							.html( $newElems );
				} else {
					alert('No Items Found.')
				}
				$(e).find('.loader').remove();
			},
			complete: function() {
				$(window).bind('scroll', getNewElements);
			}
		});

	}
	
	$('.tab-pane').delegate('th[data-order]', 'click', function(e) {
		if($(this).hasClass('asc')) {
			$(this).removeClass('asc');
			sessionStorage.setItem('orderby-'+sessionStorage.getItem('lastTab'), $(this).attr('data-order') + ' desc');
		} else {
			$(this).addClass('asc');
			sessionStorage.setItem('orderby-'+sessionStorage.getItem('lastTab'), $(this).attr('data-order') + ' asc');
		}
		sessionStorage.setItem('lastTab', $('.tab-content .active').attr('id'));
		sessionStorage.setItem('offset-'+sessionStorage.getItem('lastTab'), 1);
		var $container = $('.tab-content .active tbody'),
			dataString = {
				'range': sessionStorage.getItem('range'),
				'offset': sessionStorage.getItem('offset-'+sessionStorage.getItem('lastTab')),
				'activetab': sessionStorage.getItem('lastTab'), 
				'searchvalue': sessionStorage.getItem('searchvalue'),
				'datefrom': sessionStorage.getItem('datefrom-'+sessionStorage.getItem('lastTab')),
				'dateto': sessionStorage.getItem('dateto-'+sessionStorage.getItem('lastTab')),
				'orderby': sessionStorage.getItem('orderby-'+sessionStorage.getItem('lastTab'))
			};
		loaded = loadElements($container, dataString, this);
	});
	
	$('.form_searchdate').submit(function(e) {
		e.preventDefault();
		sessionStorage.setItem('datefrom-'+sessionStorage.getItem('lastTab'), $(this).find('.from').val());
		sessionStorage.setItem('dateto-'+sessionStorage.getItem('lastTab'), $(this).find('.to').val());
		sessionStorage.setItem('offset-'+sessionStorage.getItem('lastTab'), 1);

		var $container = $('.tab-content .active tbody'),
			dataString = {
				'range': sessionStorage.getItem('range'),
				'offset': sessionStorage.getItem('offset-'+sessionStorage.getItem('lastTab')),
				'activetab': sessionStorage.getItem('lastTab'),
				'datefrom': sessionStorage.getItem('datefrom-'+sessionStorage.getItem('lastTab')),
				'dateto': sessionStorage.getItem('dateto-'+sessionStorage.getItem('lastTab'))
			};
		loadElements($container, dataString);
	});

	$('.searchform').on('submit', function(e) {
		e.preventDefault();
		sessionStorage.setItem('lastTab', $('.tab-content .active').attr('id'));
		sessionStorage.setItem('offset-'+sessionStorage.getItem('lastTab'), 1);
		sessionStorage.setItem('searchvalue', $(e.target).find('.searchprod').val());
		var $container = $('.tab-content .active tbody'),
			dataString = {
				'range': sessionStorage.getItem('range'),
				'offset': sessionStorage.getItem('offset-'+sessionStorage.getItem('lastTab')),
				'activetab': sessionStorage.getItem('lastTab'),
				'searchvalue': sessionStorage.getItem('searchvalue')
				// 'orderby': sessionStorage.getItem('orderby-'+sessionStorage.getItem('lastTab'))
			};
		loadElements($container, dataString);
	});
	

	$('#websitesTable').on('click', 'button[name="mod"]', function(e) {
		var el = e.target;
		var webID = $(this).parents('tr').find('td:first-child').html();
		var value = el.value;
		var dataString = { 'webID': webID, 'value': value };
		
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>test/moderate/site",
			data: dataString,
			beforeSend: function() {
			
			},
			success: function(html) {
				if(value == 0) {
					$(el).html('Disapproved').addClass('btn-danger').removeClass('btn-success').val(1);
				} else {
					$(el).html('Approved').addClass('btn-success').removeClass('btn-danger').val(0);
				}
				sessionStorage.setItem('offset-m-c', 1);
				var $container = $('.tab-content #m-c tbody'),
					dataString = {
						'range': sessionStorage.getItem('range'),
						'offset': sessionStorage.getItem('offset-m-c'),
						'activetab': 'm-c',
						'orderby': 'id desc'
					};
				loadElements($container, dataString);
			}
		});
	});
});
</script>
<style>
	table {
		font-size: 12px;
	}
	th[data-order]:hover {
		cursor: pointer;
		background-color: #f5f5f5;
	}
</style>
