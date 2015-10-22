<div class="row">
	<div class="col-md-8 col-sm-8 col-md-offset-2 col-sm-offset-2">
		<div class="panel panel-default">
			<div class="panel-heading">
				User Form
			</div>
			<div class="panel-body">
				<div id="the-message"></div>

				<?php echo form_open("users/save", array("id" => "form-user", "class" => "form-horizontal")) ?>
					<div class="form-group">
						<label for="username" class="col-md-3 col-sm-4 control-label">Username</label>
						<div class="col-md-9 col-sm-8">
							<input type="text" name="username" id="username" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label for="email" class="col-md-3 col-sm-4 control-label">Email</label>
						<div class="col-md-9 col-sm-8">
							<input type="text" name="email" id="email" class="form-control">							
						</div>
					</div>
					<div class="form-group">
						<label for="password" class="col-md-3 col-sm-4 control-label">Password</label>
						<div class="col-md-9 col-sm-8">
							<input type="password" name="password" id="password" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label for="password_confirm" class="col-md-3 col-sm-4 control-label">Password Confirm</label>
						<div class="col-md-9 col-sm-8">
							<input type="password" name="password_confirm" id="password_confirm" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-3 col-md-3 col-sm-offset-4 col-sm-4">
							<button type="submit" class="btn btn-primary">Save</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script>
	$('#form-user').submit(function(e) {
		e.preventDefault();

		var me = $(this);

		// perform ajax
		$.ajax({
			url: me.attr('action'),
			type: 'post',
			data: me.serialize(),
			dataType: 'json',
			success: function(response) {
				if (response.success == true) {
					// if success we would show message
					// and also remove the error class
					$('#the-message').append('<div class="alert alert-success">' +
						'<span class="glyphicon glyphicon-ok"></span>' +
						' Data has been saved' +
						'</div>');
					$('.form-group').removeClass('has-error')
									.removeClass('has-success');
					$('.text-danger').remove();

					// reset the form
					me[0].reset();

					// close the message after seconds
					$('.alert-success').delay(500).show(10, function() {
						$(this).delay(3000).hide(10, function() {
							$(this).remove();
						});
					})
				}
				else {
					$.each(response.messages, function(key, value) {
						var element = $('#' + key);
						
						element.closest('div.form-group')
						.removeClass('has-error')
						.addClass(value.length > 0 ? 'has-error' : 'has-success')
						.find('.text-danger')
						.remove();
						
						element.after(value);
					});
				}
			}
		});
	});
</script>