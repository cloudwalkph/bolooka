<script type = "text/javascript" src = "js/GBKS/jquery.wookmark.js"/> </script>
<?php /*?>
<!-- wookmark-->
<script type="text/javascript">
    $(document).ready(function() {
      // Prepare layout options.
      var options = {
        autoResize: true, // This will auto-update the layout when the browser window is resized.
        container: $('.whole-body'), // Optional, used for some extra CSS styling
        offset: 20, // Optional, the distance between grid items
        itemWidth: 190 // Optional, the width of a grid item
		
      };
      
      // Get a reference to your grid items.
      var handler = $('.g-image');
      var wookid = $('.g-image').attr('id');
      // Call the layout function.
      handler.wookmark(options);
      
      // Capture clicks on grid items.
      handler.click(function(){
        // Randomize the height of the clicked item.
        var newHeight = $('.li-gimage', this).height() + Math.round(Math.random()*300+30);
        $(this).css('height', newHeight+'px');
        
        // Update the layout.
        handler.wookmark();
      });
    });
  </script>

<!-- End wookmark--><?php */?>

