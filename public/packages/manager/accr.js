$(document).ready(function () {
    $('#accr-list').footable();
    /*$('.order').on('click', function(){
     var id = $(this).children('.orderID').text();
     if(!id)
     {
     id = $(this).children().attr('name');
     }
     var status = $(this).children('.statusName').attr('name');
     if(status >= 3){
     $('#sendApproved').prop('disabled', true);
     $('#send').prop('disabled', true);
     } else {
     $('#sendApproved').prop('disabled', false);
     $('#send').prop('disabled', false);
     }
     $.ajax({
     url: 'getCompID',
     method: 'POST',
     data: {
     id:id
     }, success: function(responce)
     {
     $('#compID').attr('value', responce);
     }
     });
     $('#status').attr('for', status);
     $('#edit-orderID').attr('value', id);
     $('#view-orderID').attr('value', id);
     $('#approved-orderID').attr('value', id);
     $('#myModal').modal();
     });*/
});