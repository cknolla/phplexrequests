$(function() {
//	showAlert();
});

function showAlert()
{
	$("#alerts").removeClass("hideAlert");
	$("#alerts").addClass("showAlert");
	setTimeout(hideAlert(), 4000);
}

function hideAlert()
{
	return function() {
		$("#alerts").removeClass("showAlert");
		$("#alerts").addClass("hideAlert");
	}

}