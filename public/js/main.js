$(function() {

	var debug = true;
	if (debug) {
		$("input").attr("required", false);
	}

	$('.modal').on('shown.bs.modal', function() {
		$(this).find('.modal-dialog').css({
			height: 'auto',
			'max-height': '100%'
		});
	});

	$('#passwordChangeModal').on('shown.bs.modal', function() {
		$("#password-change-message").html("").attr("class", null);
	});

	$("#signup-email").on("click", function(event) {

		$("#signup-email-section").fadeToggle(function() {
			if ($(this).is(':visible')) {
				$("#signup-email-section input").first().focus();
			} else {
				$("#username").focus();
			}
		});

		event.preventDefault();
	});

	/* Facilitates email address changing for a logged in user */
	$("#email-change-form").submit(function(event){

		var $form = $(this);

		$.post($form.attr("action"), $form.serialize(), function(data) {
			
			console.log(data);

			if(data.error){
				$("#email-change-message").addClass("alert-danger").text(data.error);
			} else{
				$("#changeEmailModal").modal("hide");
				$("#user-email").text(data);
			}
		}, "json");

		event.preventDefault();
	});

	/* Facilitates password changing for a logged in user */
	$("#password-change-form").submit(function(event) {

		var $form = $(this);

		$.post($form.attr("action"), $form.serialize(), function(data) {

			if (data == true) {

				$("#password-change-message").removeClass("alert-danger").addClass("alert alert-success").html("Password Changed!");
				$form[0].reset();

				setTimeout(function() {
						$("#changePasswordModal").modal("hide")
					},
					1000);

			} else {
				$("#password-change-message").show().removeClass("alert-success").addClass("alert alert-danger").html(JSON.stringify(data));
			}

		}, "json");

		event.preventDefault();
	});

	/* Facilitates resetting password for a user who forgot their password */
	$("#reset-password-form").submit(function(event) {

		var $form = $(this);

		$.post($form.attr("action"), $form.serialize(), function(data) {

			if (data == "1") {

				$("#password-reset-message").removeClass("alert-danger").addClass("alert alert-success").html("An email has been sent to you with further instructions");

				$form[0].reset();

				setTimeout(function() {
						$("#passwordChangeModal").modal("hide")
					},
					1000);

			} else {
				$("#password-reset-message").show().removeClass("alert-success").addClass("alert alert-danger").html(data.error);
			}

		}, "json");

		event.preventDefault();
	});

});