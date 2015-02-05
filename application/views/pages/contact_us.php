<style>
#contact form {
	margin-top: 20px;
}
#contact textarea, #contact input {
    border-radius: 0 0 0 0;
    font-family: Segoe UI;
	width: 50%;
}
#contact textarea {
	resize: none;
}
#contact .btn {
    font-family: ScalaSans Light;
    font-size: 24px;
    min-width: 136px;
    text-transform: uppercase;
    width: 20%;
}
</style>
	<div id="contact" class="page-body">
		<div class="container">
			<div style="padding: 39px 21px;">
				
				<div id="alertbox">
				</div>

				<div class="lead" style="font-size: 32px; font-family: ScalaSans Light;">CONTACT</div>
				
				<p style="font-family: Segoe UI Semibold; font-size: 18px;">
				Need technical assistance?
				</p>
				
				<p style="font-size: 14px; font-family: Segoe UI;">
					Please feel free to drop us a message and we'll get back to you widthin 24 hours. <br />
					Email: <a rel="nofollow" style="text-decoration: none; color: #006cc0" href="mailto:info@bolooka.com"> info@bolooka.com </a>
				</p>

				<!-- divider striped -->
				<div style="background-image: url(img/innerPages/hr.jpg); height: 5px;"></div>
				<!-- -->
				
				<form id="contactForm" name="contactForm" class="form-entry form-horizontal" action="<?php echo base_url() ?>contact-us/submit" method="post" onsubmit="return false"> 

					<div class="control-group">
							<input type="text" name="subject" required="required" placeholder="Subject">
					</div>
					<div class="control-group">
							<input type="text" name="name" required="required" placeholder="Full Name">
					</div>
					<div class="control-group">
							<input type="email" name="email" required="required" placeholder="Email address">
					</div>
					<div class="control-group">
							<textarea name="message" required="required" placeholder="Message" rows="7"></textarea>
					</div>
					<div class="control-group">
						<button type="submit" class="btn btn-primary btn-large">Submit</button>
						<button type="reset" class="btn btn-primary btn-large">Discard</button>
					</div>
				</form>
				
					<!-- Modal Confirmation -->
					<div id="contact-modal" class="modal hide fade">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h3>Confirmation</h3>
						</div>
						<div class="modal-body">
							<p>Do you want to send your message?</p>
						</div>
						<div class="modal-footer">
							<button id="contactSubmit" type="button" class="btn btn-primary" data-loading-text="Loading...">Yes</a>
							<button type="button" class="btn" data-dismiss="modal">No</a>
						</div>
					</div>
					<!-- -->
				
			</div>
		</div>
	</div>

	<!--<script>
		// $('document').ready(function(e) {
			// var options = {
				// 'backdrop':'true',
				// 'show': false
			// };
			// $('#contact-modal').modal(options);

			// $('#contactForm').submit(function(e) {
				// $('#contact-modal').modal('show');
			// });
			
			// $('#contactSubmit').click(function(e) {
				// $('#contact-modal').modal('hide');
				// $('#contactForm').ajaxForm({
					/* data: {}, */
					// beforeSubmit: function(formData, jqForm, options){

					// },
					// success: function(html) {
						// if(html == 1) {
							// $('#alertbox').html('<div class="alert alert-success fade in"><button data-dismiss="alert" class="close" type="button">&times;</button><strong>Email Sent!</strong> We will review your message and get back to you as soon as possible.</div>');
							// setTimeout(function () { $('.alert-success').alert('close') }, 5000);
							// contactForm.reset();
						// }
					// }
				// }).submit();
			
				// if (!e) var e = window.event;
				// e.cancelBubble = true;
				// if (e.stopPropagation) e.stopPropagation();
			// });
		// });
	</script>-->

