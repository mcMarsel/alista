$(document).ready(function()
{	
	console.log('asdadasdass');
	console.log('asdadasdass');
	/*$('.order').on('click', function(){
		var id = $(this).children('.orderID').text();
		$('#edit-orderID').attr('value', id);
		$('#view-orderID').attr('value', id);
		$('#myModal').modal();
	});*/
	var compID = $('#curComp').attr('for');
	var comps = $('#e-comps').children();
	for(var i = 0; i < comps.length; i++)
	{
		if($(comps[i]).attr('value') == compID)
		{
			$(comps[i]).attr('selected', 'selected');
			
		}
	}
	console.log('asdaddddddddddddddddddddd');
	$('#e-comps').select2();
	//var stock = $('#StockID').text();
	//$('input:radio[value=110]').attr('checked', 'checked');
	//$('input:radio[value=118]').attr('checked', '');
	console.log($('#div-stock').children('input:radio'));
	
	
	/*if($('#stock').val() == 110)
	{
		
		$('#stock').prop('checked', true); 
		//$('#stock').attr('checked', false);		
	}*/

	//$( ".stock" ).prop( "checked", true );
 
	//$( "#x" ).prop( "checked", false );
    	

		
});