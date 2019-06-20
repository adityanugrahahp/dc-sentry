document.addEventListener("DOMContentLoaded", function() {
	var elements = document.getElementsByTagName("INPUT");
	for (var i = 0; i < elements.length; i++) {
		elements[i].oninvalid = function(e) {
			e.target.setCustomValidity("");
			if (!e.target.validity.valid) {
				e.target.setCustomValidity("Field ini harus diisi!");
			}
		};
		elements[i].oninput = function(e) {
			e.target.setCustomValidity("");
		};
	}
});
$(document).ready(function () {
	//$("#id_visitor_card").val("ABC");
	var isValid = true;
	$("#tgl_lahir").datepicker();
	
	
});