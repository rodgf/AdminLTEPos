$(document).ready( function () 
{	
	$.ajax(
	{
		url : "../../library/checksession.php",
		type: "POST",
		async:false,
		success: function(data, textStatus, jqXHR)
		{
			var data = jQuery.parseJSON(data);
			if(data.result == -1)
			{
				window.location.replace(data.url);
			}
		},
		error: function(jqXHR, textStatus, errorThrown)
		{
			
		}
	});
});