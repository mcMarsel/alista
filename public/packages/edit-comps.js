$(document).ready(function()
{
    $('editAddress').on('click', function(){
        var tr = $(this).parent().parent();
        var valueAdd = tr.children().children('.addressEdit').val();
        var idAdd = tr.children().children('.addressEdit').prop('id');
        var compID = $('#CompID').text();
        $.ajax({
            url: 'editAddress',
            method: 'POST',
            data: {
                value: valueAdd,
                id: idAdd,
                compID: compID
            }, success: function(resp) {
                console.log(resp);
            }
        });
    });
    $('editContact').on('click', function(){
        var tr = $(this).parent().parent();
        var valContact = tr.children().children('.contactEdit').val();
        var id = tr.children().children('.contactEdit').prop('id');
        var valPhone = tr.children().children('.phoneEdit').val();
        var compID = $('#CompID').text();
        $.ajax({
            url: 'editContact',
            method: 'POST',
            data: {
                valueC: valContact,
                valueP: valPhone,
                id: id,
                compID: compID
            }, success: function(resp) {
                console.log(resp);
            }
        });
    });

    $('.delAddress').on('click', function(){
        var idAdd = $(this).prop('id');
        var compID = $('#CompID').text();
        $.ajax({
            url: 'delAddress',
            method: 'POST',
            data: {
                id: idAdd,
                compID: compID
            }, success: function(resp) {
                console.log(resp);
            }
        });
    });
    $('.delContact').on('click', function(){
        var idContact = $(this).prop('id');
        var compID = $('#CompID').text();
        $.ajax({
            url: 'delContact',
            method: 'POST',
            data: {
                id: idContact,
                compID: compID
            }, success: function(resp) {
                console.log(resp);
            }
        });
    });

    $('#addContact').on('click', function(){
        $($($(this).parent().parent())).before('<tr class="cont">' +
        '<td><input type="text" name="contact" class="contactEdit"></td>' +
        '<td><input type="text" name="phone" class="phoneEdit"></td>' +
        '<td><input type="button" value="Сохранить" class="saveContact btn-primary"></td></tr>');
        $('.saveContact').on('click', function() {
            var tr = $(this).parent().parent();
            var valContact = tr.children().children('.contactEdit').val();
            var id = tr.children().children('.contactEdit').prop('id');
            var valPhone = tr.children().children('.phoneEdit').val();
            var compID = $('#CompID').text();
            $.ajax({
                url: 'saveContact',
                method: 'POST',
                data: {
                    valueC: valContact,
                    valueP: valPhone,
                    id: id,
                    compID: compID
                }, success: function(resp) {
                    console.log(resp);
                }
            });
        });
    });

    $('#addAddress').on('click', function(){
        $($($(this).parent().parent())).before('<tr class="add">' +
        '<td><input type="text" name="address" class="addressEdit"></td>' +
        '<td><input type="button" value="Сохранить" class="saveAddress btn-primary"></td></tr>');
        $('.saveAddress').on('click', function() {
            var tr = $(this).parent().parent();
            var valueAdd = tr.children().children('.addressEdit').val();
            var idAdd = tr.children().children('.addressEdit').prop('id');
            var compID = $('#CompID').text();
            $.ajax({
                url: 'saveAddress',
                method: 'POST',
                data: {
                    value: valueAdd,
                    id: idAdd,
                    compID: compID
                }, success: function(resp) {
                    console.log(resp);
                }
            });
        });
    });

});
