$(document).ready(function() {
  	//list states
  	$('#country').change(function(e) {
		
		var id = $(this).val();
		$.ajax({
			type: "POST",   
			url: user_content+'getStatesByCountry/'+id,
			dataType: 'json',
			success: function(response)
			{
				$('#state').html(response.html);
			}
		});
		return false;
	
	});
	
  	//list cities
  	$('#state').change(function(e) {
		
		var id = $(this).val();
		$.ajax({
			type: "POST",   
			url: user_content+'getCitiesByState/'+id,
			dataType: 'json',
			success: function(response)
			{
				$('#city').html(response.html);
			}
		});
		return false;
	
	});
	
	//datepicker
	$('.datepicker,#started_date').datepicker({
		format: "yyyy-mm-dd",
		calendarWeeks: true,
		autoclose: true,
		todayHighlight: true
	});
});