<script>

$('.delete-albumss').click(function(){

     $('#fancybox-wrap').removeClass('extras');
    $('#fancybox-wrap').addClass('extras');
		$('.fancybox-bg').css('display','none');

});





$('.primary').click(function(){

     $('#fancybox-wrap').removeClass('extras');
    $('#fancybox-wrap').addClass('extras');
		$('.fancybox-bg').css('display','none');
		$('#fancybox-content').css('border','none');
		$('#fancybox-content').css('background','white');
		

});


$('#fancybox-close').css('top','-22px  ');
$('#fancybox-close').css('right','684px ');
$('#fancybox-close').css('display','inline ');


</script>



	<div class = "delete-wholefancy">

		<div class = "areusure">Are you sure you want to delete?</div>
		
		
		<div class = "yes-no">
		
			<div label ="<?php echo $albumid?>" ids = "<?php echo $pageid?>" class = "fancy-yes-album"><a onclick = "$.fancybox.close()"  id = "delete_album" href = "#">Yes</a></div>
			
			<div class = "fancy-no"><a onclick = "$.fancybox.close()" href = "#">No</a></div>

		</div>
	</div>

