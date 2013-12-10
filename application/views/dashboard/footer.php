<!-- Modal -->
<div id="myModal_feedback" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
	<div class="modal-header title_message" style="background-color: #f26221; border-bottom:0;">
		<h3 id="myModalLabel" class="text-info" style="color: rgb(255, 255, 255); font-family: 'Segoe UI Semibold'; font-size: 20px; opacity: 0.7;">Feedback</h3>
	</div>
	<div class="modal-body" style="background-color: #e34e0d;color: #fff;">
		<p>We love to hear them.</p>
<?php
		$form_attrib_feedback = array(
			'name' => 'form_feedback', 
			'id' => 'form_feedback',
			'class' => 'form-horizontal'
		);
		echo form_open_multipart('manage/sendFeedback', $form_attrib_feedback);
?>
			<div class="control-group">
				<label class="control-label" for="inputSubject">Subject:</label>
				<div class="controls">
					<input type="text" id="inputSubject" name="subject">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputMessage">Message:</label>
				<div class="controls">
					<textarea rows="3" id="inputMessage" name="message"></textarea>
				</div>
			</div>
			<div class="pull-right">
				<button class="btn btn_color" id="send_feedback" type="submit">Send</button>
				<button class="btn btn_color" data-dismiss="modal" aria-hidden="true" type="button">Close</button>
			</div>
		</form>		
	</div>
</div>

<!-- Footer -->
<div id="footer" class="container-fluid hidden-phone" style="margin-top: 20px;">
	<div class="row-fluid muted" style="font-size: 10px; border-top: 1px solid #EEEEEE;">
		<div class="span6">
			<div>
				Copyright 2012. All Rights Reserved. A Product of <a href="http://www.lightweightsolutions.co" class="footer_hover">Lightweight Solutions</a>.
			</div>
		</div>
		<div class="span6">
			<div class="pull-right">
				Give us your feedback. Email us at <a href="mailto:info@bolooka.com" class="footer_hover">info@bolooka.com</a>
			</div>
		</div>
	</div>
</div>
<!-- end Footer -->