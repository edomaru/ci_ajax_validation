$(function  () {
	//$('.progress').hide();

	var fileInput   = $('input[name=file]');
	var uploadURI   = $('#form-upload').attr('action');
	var progressBar = $('#progress-bar');

	$('#upload-btn').on('click', function (event) {
		var fileToUpload = fileInput[0].files[0];
		// console.log(fileToUpload);
		if (fileToUpload != 'undefined') {
			// provide the form data
			// that would be sent to server through ajax
			var formData = new FormData();
			formData.append("file", fileToUpload);

			// now upload the file using ajax
			$.ajax({
				url: uploadURI,
				type: 'post',
				data: formData,
				processData: false,
				contentType: false,
				success: function () {					
					listFilesOnServer();															
				},
				xhr: function () {
					var xhr = new XMLHttpRequest();
					xhr.upload.addEventListener("progress", function(event) {
						if (event.lengthComputable) {
							var percentComplete = event.loaded / event.total;
							percentComplete = Math.round(percentComplete * 100);

							console.log(percentComplete);
							progressBar.text(percentComplete + "%");
							progressBar.css({width: percentComplete + "%"});
							progressBar.attr('aria-valuenow', percentComplete);
						}
					}, false);

					return xhr;
				}
			});
		}
	});	

	function listFilesOnServer() {
		var items = [];

		$.getJSON(uploadURI, function (data) {
			$.each(data, function(index, element) {
				items.push('<li class="list-group-item">' + element + '<div class="pull-right"><a href="#"><i class="glyphicon glyphicon-remove"></i></a></div></li>');
			});
			$('.list-group').html('').html(items.join(''));
		});
		$('.fileinput').fileinput('reset');
	}

	$('body').on('change.bs.fileinput', function(e) {	
		var progressBar = $('#progress-bar')
		progressBar.css({width: "0%"});
		progressBar.text('0%');
		progressBar.attr('aria-valuenow', 0);
	});

	$('body').on('click', '.glyphicon-remove', function (e) {
		$(this).closest('li').remove();
	})
});