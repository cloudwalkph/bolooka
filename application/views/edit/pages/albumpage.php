<style>
.drop-area {
    border: 2px dashed #DDDDDD;
    height: 50px;
    margin-bottom: 2em;
    overflow: hidden;
    text-align: center;
	transition: border 1s ease 0.5s, background-color 1s ease 0.5s;
	-webkit-transition: border 1s ease 0.5s, background-color 1s ease 0.5s;
}
.drop-area:hover {
	border: 2px solid #DDD;
	background-color: #DDD;
}
.drop-area .drop-instructions {
    display: block;
    height: 30px;
}
.drop-area .drop-over {
    display: none;
    font-size: 25px;
    height: 30px;
}
.drop-area.over {
    background: none repeat scroll 0 0 #FFFFA2;
    border: 2px dashed #000000;
}
.drop-area.over .drop-instructions {
    display: none;
}
.drop-area.over .drop-over {
    display: block;
}
.drop-area.over .drop-over {
    display: block;
    font-size: 25px;
}
.file-list {
    list-style: none outside none;
    margin-bottom: 3em;
}
.file-list li {
    border-bottom: 1px solid #000000;
    margin-bottom: 0.5em;
    padding-bottom: 0.5em;
}
.file-list li.no-items {
    border-bottom: medium none;
}
.file-list div {
    margin-bottom: 0.5em;
}
.file-list .progress-bar-container {
    border: 1px solid #555555;
    height: 10px;
    margin-bottom: 20px;
    width: 400px;
}
.file-list .progress-bar-container.uploaded {
    border: medium none;
    height: auto;
}
.file-list .progress-bar {
    background: none repeat scroll 0 0 #6787E3;
    font-weight: bold;
    height: 10px;
    width: 0;
}
.file-list .progress-bar-container.uploaded .progress-bar {
    background: none repeat scroll 0 0 transparent;
    color: #6DB508;
    display: inline-block;
    width: auto;
}
</style>
<?php
	$form_array = array(
		'id' => 'fileupload-'.$albumid,
		'class' => 'albumpage_form'
	);
	echo form_open_multipart('', $form_array);
?>
<div class="container-fluid">
		<fieldset>
			<div class="lead">Album Details:</div>
			<div>
				Album Name:
				<span class="album-titles" id="e_album_name"><?php echo $albumname; ?></span>
				<input class="hidden" type="text" id="old_alname_text" />
			</div>
			<div>
				Album Description: 
				<span class="album-description" id="e_album_des"><?php echo $albumdesc; ?></span>
				<input class="hidden" type="text" id="old_aldes_text" />
			</div>
		</fieldset>
</div>

<div class="container-fluid">
	<h3>Choose file(s)</h3>
	<div class="row-fluid drop-area">
		<div class="fileinput-button" style="float: none; overflow: visible;">
			<i class="icon-plus"></i> <span>Add photos...</span>
			<input class="files-upload" type="file" multiple name="photos[]" style="width: 100%; height: 50px;">
		</div>
		<span class="drop-instructions">or drag and drop files here</span>
		<span class="drop-over">Drop files here!</span>
	</div>

	<ul id="file-list_<?php echo $albumid; ?>" class="file-list sortablephotos form-inline">

<?php
	$this->db->where('id', $albumid);
	$qalbum = $this->db->get('albums');
	$ralbum = $qalbum->row_array();
	
	if($this->db->field_exists('album_cover', 'albums')) {
		$cover = $ralbum['album_cover'];
	} else {
		$cover = $ralbum['primary'];
	}
	
	$this->db->where('albums', $albumid);
	$this->db->order_by('sortdata desc');
	$qgallery = $this->db->get('gallery');
	
	if($qgallery->num_rows() > 0)
	{
		$rgallery = $qgallery->result_array();
		foreach($rgallery as $key => $gallery)
		{
			$imgDir = 'files/'.$gallery['albums'].'/';
			$img = $gallery['image_file'];
			if($this->photo_model->image_exists($imgDir.$img)) {
				$image = base_url($imgDir.$img);
			} else {
				$img = $gallery['image_name'];
				if($this->photo_model->image_exists($imgDir.$img)) {
					$image = base_url($imgDir.$img);
				} else {
					$img = $gallery['image'];
					if($this->photo_model->image_exists($imgDir.$img)) {
						$image = base_url($imgDir.$img);
					} else {
						$imgDir = 'uploads/';
						$img = $gallery['image'];
						if($this->photo_model->image_exists($imgDir.$img)) {

							/* copy photo from uploads to files */
							// $basename = pathinfo($imgDir.$img);
							// $newDir = 'files/'.$albumid.'/';
							// if(!is_dir($newDir))
							// {
							   // mkdir($newDir, 0755, true);
							// }
								// /* convert to md5 then to decimal */
								// $newfilename = $basename['filename'];
								// $newfilename = hash('md5', $newfilename);
								// $newfilename = base_convert($newfilename, 16, 10);
								
								// /* */
							// $newPath = $newDir.$newfilename.'.'.$basename['extension'];
							// if(copy($img, $newPath)) {
								// $img = $newPath;
							// }
							
							// $update_gallery = array(
								// 'image_file' => $newfilename.'.'.$basename['extension'],
							// );
							// $this->db->where('id', $gallery['id']);
							// $this->db->update('gallery', $update_gallery);
							/* */

							$image = base_url($imgDir.$img);
						} else {
							$image = "http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image";
						}
					}
				}
			}
?>
		<li class="template-download">
			<div class="row-fluid sorthold" id="image_<?php echo $gallery['id']; ?>" data-galleryid="<?php echo $gallery['id']; ?>" order="<?php echo $key; ?>" albumid="<?php echo $gallery['albums']; ?>">

					<div class="span2 offset1 text-center">
						<img src="<?php echo $image; ?>">
					</div>
					<div class="offset2 span2">
						<input type="radio" class="albumpriId" name="albumpriId_<?php echo $gallery['albums']; ?>" <?php echo $cover == $img ? 'checked="checked"' : ''; ?> value="<?php echo $img; ?>" />
						<span class="priinfo primary_info"> <?php echo $cover === $img ? 'Primary' : ''; ?> </span>
					</div>

				<div class="span2 offset2">
					<button type="button" class="btn show_album_modal" data-image="<?php echo $img; ?>">
						<i class="icon-trash"></i>
						<span>Delete</span>
					</button>				
				</div>
			</div>
		</li>
<?php
		}
	}
?>

	</ul>
</div>
<?php
	echo form_close();
?>	

<script>
(function () {
	// var filesUpload = document.getElementById("files-upload"),
		// dropArea = document.getElementById("drop-area"),
		// fileList = document.getElementById("file-list");
	var filesUpload = document.getElementsByClassName('files-upload'),
		dropArea = document.getElementsByClassName('drop-area'),
		fileList = document.getElementById('file-list_<?php echo $albumid; ?>');
		
	function uploadFile (file) {
		var li = document.createElement("li"),
			div = document.createElement("div"),
			img,
			progressBarContainer = document.createElement("div"),
			progressBar = document.createElement("div"),
			reader,
			xhr,
			fileInfo;
			
		// li.appendChild(div);
		
		progressBarContainer.className = "progress-bar-container";
		progressBar.className = "progress-bar";
		progressBarContainer.appendChild(progressBar);
		li.appendChild(progressBarContainer);
		
		/*
			If the file is an image and the web browser supports FileReader,
			present a preview in the file list
		*/
		if (typeof FileReader !== "undefined" && (/image/i).test(file.type)) {
			img = document.createElement("img");
			img.style.width = 50+'px';
			// li.appendChild(img);
			reader = new FileReader();
			reader.onload = (function (theImg) {
				return function (evt) {
					theImg.src = evt.target.result;
				};
			}(img));
			reader.readAsDataURL(file);
		}
		
		// Uploading - for Firefox, Google Chrome and Safari
		xhr = new XMLHttpRequest();
		
		// Update progress bar
		xhr.upload.addEventListener("progress", function (evt) {
			if (evt.lengthComputable) {
				progressBar.style.width = (evt.loaded / evt.total) * 100 + "%";
			}
			else {
				// No data to calculate on
			}
		}, false);
		
		// File uploaded
		xhr.addEventListener("load", function () {
			progressBarContainer.className += " uploaded";
			// progressBar.innerHTML = "Uploaded!";
			
			li.appendChild(div);
			var html = xhr.responseText;
			div.innerHTML = html;
			li.className = 'template-download';
			
		}, false);

		xhr.open("post", "<?php echo base_url(); ?>test/upload_gallery", true);
		
		// Set appropriate headers
		// xhr.setRequestHeader("Content-Type", "multipart/form-data");
		// xhr.setRequestHeader("X-File-Name", file.name);
		// xhr.setRequestHeader("X-File-Size", file.size);
		// xhr.setRequestHeader("X-File-Type", file.type);
		
		var formData = new FormData();
		formData.append("photo", file);
		formData.append("wid", <?php echo $wid; ?>);
		formData.append("albumid", <?php echo $albumid; ?>);

		// Send the file (doh)
		xhr.send(formData);

		// Present file info and append it to the list of files
		
			// fileInfo = "<div><strong>Name:</strong> " + file.name + "</div>";
			// fileInfo += "<div><strong>Size:</strong> " + parseInt(file.size / 1024, 10) + " kb</div>";
			// fileInfo += "<div><strong>Type:</strong> " + file.type + "</div>";

			// div.innerHTML = fileInfo;
			fileList.appendChild(li);

	}
	
	function transferComplete(e) {
		return e;
	}
	
	function traverseFiles (files) {
		if (typeof files !== "undefined") {
			for (var i=0, l=files.length; i<l; i++) {
				uploadFile(files[i]);
			}
		}
		else {
			fileList.innerHTML = "No support for the File API in this web browser";
		}	
	}
	
	for (var i = 0; i < filesUpload.length; i++) {
		filesUpload[i].addEventListener("change", function (evt) {
			traverseFiles(this.files);
		}, false);
	}
	
	for (var i = 0; i < dropArea.length; i++) {
		dropArea[i].addEventListener("dragleave", function (evt) {
			// var target = evt.target;
			
			// if (target && target === dropArea) {
				// this.className = "";
			// }
			evt.preventDefault();
			evt.stopPropagation();
		}, false);
		
		dropArea[i].addEventListener("dragenter", function (evt) {
			// this.className = "over";
			evt.preventDefault();
			evt.stopPropagation();
		}, false);
		
		dropArea[i].addEventListener("dragover", function (evt) {
			evt.preventDefault();
			evt.stopPropagation();
		}, false);
		
		dropArea[i].addEventListener("drop", function (evt) {
			traverseFiles(evt.dataTransfer.files);
			// this.className = "";
			evt.preventDefault();
			evt.stopPropagation();
		}, false);
	}
	
})();

	$('.file-list').delegate('.show_album_modal', 'click', function() {
		var imageid = $(this).parents('.sorthold').attr('data-galleryid'),
			name = $(this).attr('data-image');
		$('#image_ids').val(imageid);
		$('#image_filename').val(name);
		$('#myModal_album').modal('show');
	});

	$('.file-list').delegate('.albumpriId','click',function(e) {
			var parentPic = $(this).parents('.sorthold'),
				imageid = parentPic.attr('data-galleryid'),
				y = parentPic.attr('order'),
				albumid = parentPic.attr('albumid');
			var datalist = { 'primary': $(this).val(), 'albumid': albumid }
			$.ajax({
				type: 'post',
				url: '<?php echo base_url() ?>multi/setalbumprimary',
				data: datalist,
				success: function(html)
				{
					$('.sorthold').find('.primary_info').text('').empty();
					$('#image_'+imageid).find('.priinfo').text('Primary');
				}
			});
	});


</script>