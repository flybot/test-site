function createLocationString(){
	var filter_str = "";
	$( ".filter_cb" ).each(function( index ) {
		if( this.checked ) {
			if(filter_str !== "")
				filter_str += "-";
			filter_str += $(this).val();
		}
	});
	var result_str = "/routes";
	if(filter_str !== ""){
		result_str += "/filter/" + filter_str;
	}
	
	var btn = $('div').find('.glyphicon').parent();
	if(btn.length) {
		var sortOrder = "";
		if(btn.find(".glyphicon-chevron-up").length)
			sortOrder = '-asc';
		else
			sortOrder = '-desc';
		result_str += '/sort/' + btn.attr('id').replace('sort_', '') + sortOrder;
	}
	return result_str;
}

$(document).ready(function() {
	
	$(".filter_cb").on("click", function() {
		//window.history.pushState("", "", window.location.pathname);
		window.location = createLocationString();
	});
	
	$(".btn-sort").click(function() { 
		if( $(this).has('span').length ) {
			$(this).find('.glyphicon').toggleClass("glyphicon-chevron-up");
			$(this).find('.glyphicon').toggleClass("glyphicon-chevron-down");
		}
		else {
			$('span').remove('.glyphicon');
			$(this).append('<span class="glyphicon glyphicon-chevron-up"></span>');
		}
		window.location = createLocationString();
	});
	
});
	
