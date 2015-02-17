/* Bolooka JavaScripts */
$(function () {

	/* reload page in tab focus */
		// window.addEventListener('focus', function() {
			// window.location.reload();
		// });
	/* */
	
	/* File Upload Script with Bootstrap Design */
		$('.fileupload_form').fileupload({
			replaceFileInput: false,
			dataType: 'json',
			uploadTemplateId: '',
			downloadTemplateId: '',
			add: function (e, data) {
				this.$element = $(e.target).find('.fileupload');
				this.$input = data.fileInput;
				this.$hidden = this.$element.find('a.fileupload-exists');
				// this.name = this.$hidden.attr('name')
				
				// if(this.$hidden.attr('name') != null) 
					// this.$input.attr('name', this.name)
					// this.$hidden.attr('name', '')
				console.log(this.$input);

				if(data.files[0].size < 2097152) {
					previewPhoto(data);
					$(data.fileInput).parents('.fileupload').addClass('fileupload-exists').removeClass('fileupload-new');
					$(data.fileInput).parents('.fileupload').find('.help-inline').text('');
				} else {
					this.$input.val('');
					$(data.fileInput).parents('.fileupload').addClass('fileupload-new').removeClass('fileupload-exists');
					$(data.fileInput).parents('.fileupload').find('.help-inline').text('File size exceeded.').show().fadeOut(5000);
				}
			},
			done: function (e, data) {
				// data.context.text('Upload finished.');
			}
		});
		
		$('a.fileupload-exists').click(function(e) {
			this.$element = $(e.target).parents('.fileupload');
			this.$preview = this.$element.find('.fileupload-preview');
			this.$filename = this.$element.find('.fileupload-filename');
			this.$hidden = this.$element.find('a.fileupload-exists');
			this.$input = this.$element.find(':file');
			// this.name = this.$input.val('name');
			// this.$hidden.attr('name', this.name);
			
			// this.$input.attr('name', '');
			
		  this.$input.val('');
		  this.$preview.html('');
		  this.$filename.html('');
		  this.$element.addClass('fileupload-new').removeClass('fileupload-exists');
		  this.$element.find('.help-inline').text('File size exceeded.').text('');
		  return false;
		});

		function previewPhoto(data) {
			for (var i = 0, f; f = data.files[i]; i++) {
			  if (!f.type.match('image.*')) {
				continue;
			  }
			  var reader = new FileReader();
			  reader.onload = (function(theFile) {
				return function(e) {
				  /* for image view */
				  var span = document.createElement('span');
				  span.innerHTML = ['<img src="', e.target.result,
									'" title="', escape(theFile.name), '"/>'].join('');
				  $(data.fileInput).parents('.fileupload').find('.fileupload-preview').html(span);
				  
				  /* for filename view */
				  var imageName = document.createElement('span');
				  imageName.innerHTML = [escape(theFile.name)].join('');
				  $(data.fileInput).parents('.fileupload').find('.fileupload-filename').html(imageName);
				};
			  })(f);
			  reader.readAsDataURL(f);
			}
		}
	/* */
	
	/* bootstrap colorpicker */
		$('.color-picker')
			.colorpicker({
				format: 'rgba'
			})
			.on('changeColor', function(ev) {
			/* ev.parentNode.backgroundColor = ev.color.toHex(); */
			});
	/* */
	


/********** **********/
});
	