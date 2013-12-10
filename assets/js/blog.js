function get_content() {
	var content = $('#wall').val(); // Get all the data in the textarea 
	content = content.replace('www.','http://www.');
	// var url = content.match('^(((ht|f)tp(s?))\://)?(www.|[a-zA-Z].)[a-zA-Z0-9\-\.]+\.(com|edu|gov|mil|net|org|biz|info|name|museum|us|ca|uk)(\:[0-9]+)*(/($|[a-zA-Z0-9\.\,\;\?\'\\\+&amp;%\$#\=~_\-]+))?$');
	var url = content.match('(^|[ \t\r\n])((ftp|http|https|gopher|mailto|news|nntp|telnet|wais|file|prospero|aim|webcal):(([A-Za-z0-9$_.+!*(),;/?:@&~=-])|%[A-Fa-f0-9]{2}){2,}(#([a-zA-Z0-9][a-zA-Z0-9$_.+!*(),;/?:@&~=%-]*))?([A-Za-z0-9$_+!*();/?:~-]))');
	
	// regular expression that will allow us to extract url from the textarea
		if ((url.length > 0) && $('#ajax_flag').val() == 0) { // If there's atleast one url entered in the textarea
			//ajax_flag ensure that if a url is found and user press spacebar,ajax will trigger only once .
			$("#fetched_data").slideDown('show'); // show this div with a 'slidedown' effect - previously hiddden by default
			$("#loader").html("<img style='float:right;' src='../../img/ajax-loader.gif'>"); // Add an Ajax loading image similar to facebook
			$('.Share').hide(); //remove button to prevent posting without content
			$('#text_value').val(content); // url stored to input text value
			$.post("../../wall/get_content", { url: url[0] }, function (response) { // Ajax call using get passing the url extracted from the textarea
					$("#ajax_content").html(response) //Place the response processed by get_content.php and place it in a div with id = ajax_content
					$('#loader').empty(); // remove the ajax loading image now
					$('.Share').show(); // show button
					$('img#1').fadeIn(); // Add a fading effect with the first image thumbnail extracted from the external website
					$('#current_img').val(1); // Initiate value =1 - this will be used for the next / previous button
			});
			$('#ajax_flag').val(1); // Ensure that only once ajax will trigger if a url match is found in the textarea  
		}
}
function get_contentPaste() {
	var content = $('#wall').val(); // Get all the data in the textarea 
	content = content.replace('https','http');
	/* var url = content.match('^(((ht|f)tp(s?))\://)?(www.|[a-zA-Z].)[a-zA-Z0-9\-\.]+\.(com|edu|gov|mil|net|org|biz|info|name|museum|us|ca|uk)(\:[0-9]+)*(/($|[a-zA-Z0-9\.\,\;\?\'\\\+&amp;%\$#\=~_\-]+))?$'); */
	var url = content.match('(^|[ \t\r\n])((ftp|http|https|gopher|mailto|news|nntp|telnet|wais|file|prospero|aim|webcal):(([A-Za-z0-9$_.+!*(),;/?:@&~=-])|%[A-Fa-f0-9]{2}){2,}(#([a-zA-Z0-9][a-zA-Z0-9$_.+!*(),;/?:@&~=%-]*))?([A-Za-z0-9$_+!*();/?:~-]))');

	// regular expression that will allow us to extract url from the textarea
		if ((url.length > 0) && $('#ajax_flag').val() == 0) { // If there's atleast one url entered in the textarea
			//ajax_flag ensure that if a url is found and user press spacebar,ajax will trigger only once .
			$("#fetched_data").slideDown('show'); // show this div with a 'slidedown' effect - previously hiddden by default
			$("#loader").html("<img style='float:right;' src='../../img/ajax-loader.gif'>"); // Add an Ajax loading image similar to facebook
			$('.Share').hide(); //remove button to prevent posting without content
			$('#text_value').val(content); // url stored to input text value
			$.post("../../wall/get_content", { url: url[0] }, function (response) { // Ajax call using get passing the url extracted from the textarea
					$("#ajax_content").html(response) //Place the response processed by get_content.php and place it in a div with id = ajax_content
					$('#loader').empty(); // remove the ajax loading image now
					$('.Share').show(); // show button
					$('img#1').fadeIn(); // Add a fading effect with the first image thumbnail extracted from the external website
					$('#current_img').val(1); // Initiate value =1 - this will be used for the next / previous button
			});
			$('#ajax_flag').val(1); // Ensure that only once ajax will trigger if a url match is found in the textarea
		}
}

 
$(document).ready(function () { // When the dom is ready
	
    $('#fetched_data').hide(); // Hide div id by default
    $('#ajax_flag').val(0); // Initialize value to zero i.e  input tag with id='ajax_flag' will have a new attribute 'value=0'
    $(document).keypress(function (e) { // Listen to keyboard press event by user 
        if (e.keyCode == 32 || e.charCode == 32) { // if user press spacebar 
			get_content();
            return false;
        }
    });
	$("#wall").bind('paste', function(e) {
		setTimeout(function() {
			get_contentPaste();
			return false;
		}, 100);
	});
	// $('#uploadFile').click(function() {
		// $('#wall').hide();
		// $("#fetched_data").slideDown('show');
		// $("#ajax_content").html('<textarea id="uploadWall" type="text"></textarea>')
		// alert($('#uploadFile').val());
	// }); 


    ///////////////////////////////////////////////////////////////////////	 Next image
    $('#next').live("click", function () { // when user click on next button
        var firstimage = $('#current_img').val(); // get the numeric value of the current image
        if (firstimage <= $('#total_images').val() - 1) // as long as last image has not been reached
        {
            $('img#' + firstimage).hide(); // hide the current image to be able to display the next image
            firstimage = parseInt(firstimage) + parseInt(1); // Increment image no so that next image no. can be displayed
            $('#current_img').val(firstimage); // Incremented in input tag
            $('img#' + firstimage).show(); // show second image
        }
        $('#totalimg').html(firstimage + ' of ' + $('#total_images').val()); // Update the current image no display value
    });
    ///////////////////////////////////////////////////////////////////////	 Next image
    ///////////////////////////////////////////////////////////////////////	 prev image
    $('#prev').live("click", function () { // When user clicks on Previous Button
        //Same logic as for Next Button
        var firstimage = $('#current_img').val();


        if (firstimage >= 2) {
            $('img#' + firstimage).hide();
            firstimage = parseInt(firstimage) - parseInt(1);
            $('#current_img').val(firstimage);
            $('img#' + firstimage).show();
        }
        $('#totalimg').html(firstimage + ' of ' + $('#total_images').val());
    });
    ///////////////////////////////////////////////////////////////////////	 prev image
    ///////////////////////////////Share Button
/* twitter	 */
// twttr.anywhere(function (T) {
/* twitter */
	
    $('.Share').live("click", function () { //if user clicks on share button
		var hiddentText = $('#text_value').val();
        var textarea_content = $('textarea#wall').val(); // get the content of what user typed ( in textarea ) 
		var uploadFile = $('#uploadFile').val().replace(/.+[\\\/]/, "");
		var Ids = $(this).parent('class');
        // if (textarea_content != '' || uploadFile != '') { // if textarea is not empty or empty
            var sitetitle = $('div.title').html(); // then get external site title (if there's any )
            if (sitetitle == null) {
                sitetitle = ' ';
            }
			
			/* detect if url is youtube MICHAEL*/
				var youtube = hiddentText.match(/^https?:\/\/(?:www\.)?youtube\.com\/watch\?(?=.*v=((\w|-){11}))(?:\S+)?$/);
				var vimeo = hiddentText.match(/http:\/\/(www\.)?vimeo.com\/(\d+)($|\/)/);
				var dailymotion = hiddentText.match(/http:\/\/www\.dailymotion\.com\/video\/+/);
				var playBtn = '';
				
				if(youtube != null)
				{
					playBtn = '<img style="position: absolute;right: 168px;top: 35px;cursor: pointer;width: 95px;" class="playButtonBlog" src="../../img/playbtn.png" />';
				}else if(vimeo != null)
				{
					playBtn = '<img style="position: absolute;right: 168px;top: 35px;cursor: pointer;width: 95px;" class="playButtonBlog" src="../../img/playbtn.png" />';
				}else if(dailymotion != null)
				{
					playBtn = '<img style="position: absolute;right: 177px;top: 22px;cursor: pointer;width: 95px;" class="playButtonBlog" src="../../img/playbtn.png" />';
				}
			/* end of url youtube MICHAEL */
			
            var siteurl = $('div.url').html(); // get site url ( if there's any )
			
			// if textarea is not empty or empty
			if(textarea_content == '' && uploadFile == '' && siteurl == undefined)
			{
				// alert('Input text first!');
				return false;
			}
			
            if (siteurl == null) { // if no value retrieved
                siteurl = ' '; //set to blank to prevent 'null' or 'undefined' displayed on page
            }
            var sitedesc = $('div.desc').html(); // get external site description ( if there's any)
            if (sitedesc == null) { // if no value retrieved
                sitedesc = ' '; //set to blank to prevent 'null' or 'undefined' displayed on page
            }
            var current_image_id = $('input#current_img').val(); // get the current image thumbnail id (if there's any) 
            // we need that id to post the correct image chosen by user in  wall post
            if (current_image_id != '') { //make sure id is retrieved successfully 
                var current_image_url = $("img." + current_image_id).attr("src"); // get the current image displayed in thumbnail url in "src" tag
				
                if (current_image_url) { //if there's an image url
                    var image_html = '<div class="img_attachment"><img style="width: 300px; cursor: pointer;" class="external_pic" src="' + current_image_url + '" />'; // prepare image url 'embeded with appropriate html
                } else { 
                    var image_html = ''; //No image to display ( it means that no image url was retrieved from external website , ( ignoring <div class = 'img_attachement> .. </div>
                } 
            } else { 
				if(uploadFile) {
				// <img style="cursor: pointer;position: absolute;right: 200px;top: 42px;width: 144px;" class="playButtonBlog" src="../../img/playbtn.png" />
					// $.post( "../../wall/upwallimage", {
						// upload: uploadFile },
						// function (html) {
							// uploadFiles = uploadFile.split(" ").join("_");
							// image_htmls = '<div class="img_attachment"><img style="cursor: pointer;" class="external_pic" src="../../uploads/' + uploadFiles + '" /></div>'; // upload FIle
						// }
					// );
					uploadFiles = uploadFile.split(" ").join("_");
					var image_html = '<div class="img_attachment"><div class="img_temp"></div><img style="border:1px solid;" class="external_pic" src="../../uploads/' + uploadFiles + '" /></div>';
					$("form#imageform").ajaxForm({
						success: function(html) {
							// alert(html);
							if(html) {
								$('.img_attachment').first().html('<img class="external_pic" src="../../uploads/'+ html +'" />')
							}
						}
					}).submit();					
				} else {
					var image_html = '';
				}
            }
				if(textarea_content) {
					textarea_content = '<p class="message" style="margin: 0 65px;text-align: left;width: 291px;">' + textarea_content + '</p> ';
				} else {
					textarea_content = '';
				}

            var wall_post = '<li> <div class="status"> <h2 style="display:none;"></h2> ' + textarea_content + image_html + '<div class="data"><p class="name" style="text-align: left;width: 300px;"><a style="color: #000000;" href="' + siteurl + '" target="_blank">' + sitetitle + '</a></p><p class="caption" style="color: #000000;text-align: left;width: 300px;"><a style="color: #000000;" href="'+ siteurl +'" target="_blank">' + siteurl + '</a></p><p class="description" style="text-align: left;width: 300px;">' + sitedesc + '</p></div></div> </div><p class="likes"></p></li>';
            
			var message_wall = $('#wall').attr('value');
			var ID = $(this).attr('id');
			siteurl = siteurl.replace(/\&amp;/g, '&' );
			message_wall = message_wall.replace(/\&amp;/g, '&' );
			var dataString = 'wall='+ message_wall + '&wid=' + ID + '&image=' + image_html + '&title=' + sitetitle + '&url=' + siteurl + '&desc=' + sitedesc + '&imageUrl=' + current_image_url + '&imageName='+ uploadFile; 
			// alert(dataString);
			// return false;
            $.ajax({ 
                type: "POST",
                url: "../../wall/insert",
                data: dataString,
                success: function (html) {
					
					var delbutton = '<a onclick="deleteblog(this, '+html+')" href="#"><img style="float:right;" src="../../js/jquery.fancybox-1.3.4/fancybox/fancy_close.png" /></a><div id=""></div>';
                    $('ul#posts').prepend('<li>'+delbutton+' <div class="status"> <h2 style="display:none;"></h2> ' + textarea_content + image_html + playBtn +'<div class="data"><p class="name" style="text-align: left;width: 300px;"><a style="color: #000000;" href="' + siteurl + '" target="_blank">' + sitetitle + '</a></p><p class="caption" style="color: #000000;text-align: left;width: 300px;"><a style="color: #000000;" href="'+ siteurl +'" target="_blank">' + siteurl + '</a></p><p class="description" style="text-align: left;width: 300px;">' + sitedesc + '</p></div></div> </div><p class="likes getIdAjax" alt="'+html+'"></p><center class="cen-coment"><div id="showText'+html+'"><div id="profile'+html+'" style="float: left;margin-left: -1px;"></div><br /><textarea placeholder="write a comment..." id="'+html+'" onfocus="showUser2(this.id)" style="width:300px;height:15px;margin-left: -9px;background-color: #E9E9E9;border: 1px solid #C4C4C4;border-radius: 10px 10px 10px 10px;padding: 3px;resize: none;" onblur="hideBox(this.id)"></textarea></div></div></center></li>');
					
				} 
            });
			
		/* twitter tweet */
		if (T.isConnected()) { 
			var tweetMsg = $('textarea#wall').val();
			T.Status.update(tweetMsg, {
				success: function (tweet) {
				  // alert('message tweet');
				},
				error: function (error) {
				  // alert('message not sent');
				}
			});
		}			

            //Add the prepared html to add in div with id = wallz
            //After adding the post wall ,
			$('input#current_img').val('');
            $('textarea#wall').val(''); // remove text in the textarea 
            $('#ajax_content').empty(); // empty the div with id = ajax_content ( contains previous content fetched via ajax )
            $('#fetched_data').hide(); // hide the div 
			$('#loader').empty(); // remove the ajax loading image now
            $('#ajax_flag').val(0); //reset  this to zero  
        // } else {
            // alert('Put text first ! '); // just in case some morons try to click on share witout writing anything :)
			// return false;
        // }
		
		// $('.img_temp').html('');
		// $('.img_temp').html('<img src="../../img/loader.gif" alt="Uploading...." />');
		// submit input via ajax form

		
		$('#uploadFile').val('');

    });
/* twitter */
// }); 
/* twitter */
	$('#remove').live('click',function(){
		//Add the prepared html to add in div with id = wallz
		//After adding the post wall ,
		$('#ajax_content').empty(); // empty the div with id = ajax_content ( contains previous content fetched via ajax )
		$('#fetched_data').hide(); // hide the div 
		$('#ajax_flag').val(0); //reset  this to zero  
	});
	
	// $('.external_pic').live('click',function(){

		// /*var url = $(this).parent().children('div.data').children('p.caption').children('a').attr('href'); */

		// var url = $(this).parent().children('div.data').children('p.caption').children('a').attr('href'); 
		// alert(url);
		// /*$(this).parent().children('div.data').children('p.name').hide();
		// $(this).parent().children('div.data').children('p.caption').hide();*/
		// $(this).parent().children('p.name').hide();
		// $(this).parent().children('p.caption').hide();
		// $(this).oembed(url,{maxWidth:400,maxHeight:300,embedMethod:'auto'}); 

	// });
	$('.playButtonBlog').live('click',function(){
		
		var url = $(this).parent().children('div.data').children('p.caption').children('a').attr('href'); 
		var image_attach = $(this).parent().children('.external_pic');
		$(image_attach).oembed(url,{maxWidth:419,embedMethod:'auto'});
		$(image_attach).css('opacity','0.6');
		$(this).fadeOut(900);
	});
});

