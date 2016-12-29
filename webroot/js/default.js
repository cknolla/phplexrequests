$(function() {
//	showAlert();
});

function showAlert(style, message)
{
	$("#alerts").removeClass("showAlert");
	$("#alerts").empty();
	$("#alerts").append(message);
	// style can 'success', 'error', 'warn
	if(style == "success") {
		$("#alerts").removeClass("alert-danger");
		$("#alerts").removeClass("alert-warning");
		$("#alerts").addClass("alert-success");
	} else if(style == "error") {
		$("#alerts").removeClass("alert-success");
		$("#alerts").removeClass("alert-warning");
		$("#alerts").addClass("alert-danger");
	} else if(style == "warn") {
		$("#alerts").removeClass("alert-danger");
		$("#alerts").removeClass("alert-success");
		$("#alerts").addClass("alert-warning");
	}
	setTimeout(function() {
		$("#alerts").addClass("showAlert");
	}, 10);
}