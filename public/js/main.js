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

	$("#change-password-form").submit(function(event) {

		var $form = $(this);

		$.post($form.attr("action"), $form.serialize(), function(data) {

			if (data == "1") {

				$("#password-change-message").removeClass("alert-danger").addClass("alert alert-success").html("Password Changed!");
				$form[0].reset();

				setTimeout(function() {
						$("#passwordChangeModal").modal("hide")
					},
					1000);

			} else {
				$("#password-change-message").show().removeClass("alert-success").addClass("alert alert-danger").html(data.error);
			}

		}, "json");

		event.preventDefault();
	});

	$("#reset-password-forma").submit(function(event) {

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