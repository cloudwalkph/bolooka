<?php
//
set_time_limit(0); // Do not let the script time out
// $server = 'http://'.$_SERVER['SERVER_NAME'].'/localhost/';
// include ('simplehtmldom/simple_html_dom.php'); // include  the parser library
$this->load->file('assets/simplehtmldom/simple_html_dom.php'); // include  the parser library

$pid = $_POST['pid']; 
$url = $_POST['url']; 
//URL received via ajax
$html = file_get_html($url);

// get DOM from URL fetched by ajax
$title = trim($html->find('title', 0)->plaintext); 
// Get the title of the page

foreach ($html->find('meta[name=description]') as $e);// Fetch Description from meta description of page
if($html->find('meta[name=description]')){
	$description = $e->content;
}

//Fetch images url and add it to an array
$images_url = array();
foreach ($html->find('img') as $e) {
	// $pattern = '#^(.*)\.(gif|png|jpg)$#ig';

	// if(preg_match($pattern, $e->src, $matches)) {
		// Loop through all images and make sure only appropriate image size is fetched
		// This will neglect icons , images from webpage layout etc
		if (substr($e->src, 0, 7) == 'http://' || substr($e->src, 0, 8) == 'https://') { // Make sure image url starts by either http or https
			$ImgSize = getimagesize($e->src); 
			// Get the size of current image
			if ($ImgSize[0] >= 140 && $ImgSize[1] >= 100) {
					 // Image width should be at least 140 pixel and height 120 pixel
					$images_url[] = $e->src; 
					// Add image to array stack
			}
		}
	// }
}

foreach ($html->find('meta[property=og:image]') as $e)
$og_image = $e->content;

//Some tidy up :)
$html->clear();
unset($html);
?>

<div style="float:right; cursor:pointer;" class="remove">
	<i class="icon-remove"></i>
</div>
			
<?php

echo '<div class="pull-left images images'.$pid.'" style="width: 150px;margin-right: 10px;">';
if (!empty($images_url)) {
    // If image array contains images
    for ($i = 0; $i < count($images_url); $i++) {
        // Loop through each image and add appropriate image tag
        $y = $i + 1;
        echo '<img style="display: none;" src="'. $images_url[$i] .'" class="'. $y .'" id="'. $y .'" />';
    }
	echo '<input name="total_images" class="total_images" value="'. count($images_url) .'" type="hidden"/>';
} else if (!empty($og_image)) { 
	echo '<img src="'. $og_image .'" class="1" />';
}
//Add the total no. of images to this hidden input.It will be used later when user press next/previous button
echo '</div>';

echo '<div class="info info'.$pid.'" style="overflow:hidden">';
if (!empty($title)) {
    echo ' <div class="title title'.$pid.'" style="font-weight: bold;color:#08C;"> '.$title.' </div>';
    //Display the title of page
}

echo '<div class="url url'.$pid.'" style="margin-bottom: 10px;color:#08C;">' . html_entity_decode($url) . '</div>';
//url of page

if (!empty($description)) {
    echo ' <div style="overflow: hidden;" class="desc desc'.$pid.'"> ' . substr($description, 0, 200) . ' </div>';
    //Description from meta description
}
if (count($images_url) > 1) {
	echo '<br clear="all"/>';
    // If there's more than 1 image fetched , display the next and previous button
    echo '<div style="float:left"><img src="../img/btn_prev.gif" class="prev" alt="" style="background-color: #ccc" /><img src="../img/btn_next.gif" class="next" alt="" style="background-color: #ccc" /></div>';
    echo '<div class="totalimg">1 of ' . count($images_url) . '</div>';
    // display total no. of images retrieved
}
echo '<br clear="all"/>';
echo '</div>';
?>
