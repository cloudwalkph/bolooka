<!DOCTYPE html>
<html>
<head>
	<title>Demo - jQuery Smooth Div Scroll - Thomas Kahn</title>
	
	<!-- the CSS for Smooth Div Scroll -->
	<link rel="Stylesheet" type="text/css" href="css/smoothDivScroll.css" />
	
	<!-- Styles for my specific scrolling content -->
	<style type="text/css">

		#makeMeScrollable
		{
			width:100%;
			height: 330px;
			position: relative;
		}
		
		/* Replace the last selector for the type of element you have in
		   your scroller. If you have div's use #makeMeScrollable div.scrollableArea div,
		   if you have links use #makeMeScrollable div.scrollableArea a and so on. */
		#makeMeScrollable div.scrollableArea img
		{
			position: relative;
			float: left;
			margin: 0;
			padding: 0;
			/* If you don't want the images in the scroller to be selectable, try the following
			   block of code. It's just a nice feature that prevent the images from
			   accidentally becoming selected/inverted when the user interacts with the scroller. */
			-webkit-user-select: none;
			-khtml-user-select: none;
			-moz-user-select: none;
			-o-user-select: none;
			user-select: none;
		}
	</style>

</head>

<body>

	<div id="makeMeScrollable">
		<img src="images/demo/field.jpg" alt="Demo image" id="field" />
		<img src="images/demo/gnome.jpg" alt="Demo image" id="gnome" />
		<img src="images/demo/pencils.jpg" alt="Demo image" id="pencils" />
		<img src="images/demo/golf.jpg" alt="Demo image" id="golf" />
		<img src="images/demo/river.jpg" alt="Demo image" id="river" />
		<img src="images/demo/train.jpg" alt="Demo image" id="train" />
		<img src="images/demo/leaf.jpg" alt="Demo image" id="leaf" />
		<img src="images/demo/dog.jpg" alt="Demo image" id="dog" />
	</div>

	<!-- LOAD JAVASCRIPT LATE - JUST BEFORE THE BODY TAG 
	     That way the browser will have loaded the images
		 and will know the width of the images. No need to
		 specify the width in the CSS or inline. -->

	<!-- jQuery library - Please load it from Google API's -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js" type="text/javascript"></script>

	<!-- jQuery UI Widget and Effects Core (custom download)
	     You can make your own at: http://jqueryui.com/download -->
	<script src="js/jquery-ui-1.8.23.custom.min.js" type="text/javascript"></script>
	
	<!-- Latest version (3.0.6) of jQuery Mouse Wheel by Brandon Aaron
	     You will find it here: http://brandonaaron.net/code/mousewheel/demos -->
	<script src="js/jquery.mousewheel.min.js" type="text/javascript"></script>

	<!-- jQuery Kinectic (1.5) used for touch scrolling -->
	<script src="js/jquery.kinetic.js" type="text/javascript"></script>

	<!-- Smooth Div Scroll 1.3 minified-->
	<script src="js/jquery.smoothdivscroll-1.3-min.js" type="text/javascript"></script>

	<!-- If you want to look at the uncompressed version you find it at
	     js/jquery.smoothDivScroll-1.3.js -->

	<!-- Plugin initialization -->
	<script type="text/javascript">
		// Initialize the plugin with no custom options
		$(document).ready(function () {
			// None of the options are set
			$("div#makeMeScrollable")
				.smoothDivScroll({
					autoScrollingMode: "onStart",
					autoScrollingDirection: "right",
					getContentOnLoad: { 
						method: "getHtmlContent",
						content: "http://localhost/project-bolooka/shop/getmore?type=products&items=5&lastitem=1",
						manipulationMethod: "addLast",
						filterTag: "img"
					}
				})
				.bind("mouseover", function(){
					$("div#makeMeScrollable").smoothDivScroll("stopAutoScrolling");
				})
				.bind("mouseout", function(){
						$("div#makeMeScrollable").smoothDivScroll("startAutoScrolling");
					})
			
		});
	</script>

</body>
</html>
