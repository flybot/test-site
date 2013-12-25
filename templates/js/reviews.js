function createLocationString(){
	var filter_str = "";
	$( ".filter_cb" ).each(function( index ) {
		if( this.checked ) {
			if(filter_str !== "")
				filter_str += "-";
			filter_str += $(this).val();
		}
	});
	var result_str = "/reviews";
	if(filter_str !== ""){
		result_str += "/filter/" + filter_str;
	}
	
	return result_str;
}

$(document).ready(function() {
	
	$(".filter_cb").on("click", function() {
		//window.history.pushState("", "", window.location.pathname);
		window.location = createLocationString();
	});
	
});
	
