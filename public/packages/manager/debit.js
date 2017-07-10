$(document).ready(function()
{
	//$('#table-debit').footable();

    $('#table-debit').footable({
        "paging": {
            "enabled": true,
            "countFormat": "{CP} of {TP}",
            "size": 20
        },
        "columns": $.get('getColumns'),
        "rows": $.get('getRows')
    });
});