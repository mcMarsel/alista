$(document).ready(function () {
    //$('#table-pl').footable();
    $('.gr-pl').on('change', function () {
        $(this).attr('ch', 1);
        var tr = $(this).parent();
        var value = $(this).children().val();
        var table = $(tr).children('.ch-td').children('.ch-table');
        var chpl = $(table).children().children('.pl');
        for (var i = 0; i < chpl.length; i++) {
            var sel = $(chpl[i]).children().children();
            for (var j = 0; j < sel.length; j++) {
                if ($(sel[j]).attr('value') == value) {
                    $(sel[j]).attr('selected', 'selected');
                    $(sel[j]).attr('ch', 1);
                }
            }
        }
    });

    $('#save').on('click', function () {
        var res = new Array();
        var ck = $('.check-pl').children('.check-p');
        for (var i = 0; i < ck.length; i++) {
            var obj = {};

            if ($(ck[i]).prop('checked')) {
                var tr = $(ck[i]).parent().parent();
                /*var selGr = tr.children('.gr-pl').children().children();
                 for(var k = 0; k < selGr.length; k++)
                 {
                 if($(selGr[k]).prop('selected'))
                 {
                 obj.grPL = $(selGr[k]).val();
                 }
                 }*/
                var trProd = tr.children('.ch-td').children().children('.tr');
                //var trProd = tr.children('.ch-td').children().children('.tr').children('.prodID');
                for (var z = 0; z < trProd.length; z++) {
                    obj.ProdID = $(trProd[z]).children('.prodID').text();
                    var sel = trProd.children('.pl').children();
                    for (var l = 0; l < sel.length; l++) {
                        var op = $(sel[l]).children();
                        for (var k = 0; k < op.length; k++) {
                            if ($(op[k]).prop('selected')) {
                                obj.PLID = $(op[k]).val();
                            }
                        }
                    }
                    res[z] = obj;
                }
            }
        }
        $.ajax({
            url: 'sendPrice',
            method: 'POST',
            data: {
                res: res
            }, success: function (responce) {
                console.log(responce);
            }
        });
        console.log(res);
    });
});