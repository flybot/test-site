$(document).ready(function() {
	
	$("select#route").change(function(){
	    $.getJSON("/ajax/order_dates",{id: $(this).val()}, function(j){
		      var options = '';
		      for (var i = 0; i < j.length; i++) {
		        options += '<option value="' + j[i].hike_id + '">' + j[i].hike_date + '</option>';
		      }
		      $("select#date_start").html(options);
		})
	});
	
	//$("select#route").change();
});
	
