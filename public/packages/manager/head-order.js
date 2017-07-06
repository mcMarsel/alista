$(document).ready(function () {
    var descText = $('#descText');
    var descPL = $('#descPL');

    if ($('input:radio[name=invoice]:checked').val() == 1) {
        var type = 4;
        $.ajax({
            url: 'getKurs',
            method: 'POST',
            data: {
                type: type
            }, success: function (response) {
                $('#Kurs').text(response);
                $('#Kurs').show();
            }
        });
    }
    else {
        var type = 1;
        $.ajax({
            url: 'getKurs',
            method: 'POST',
            data: {
                type: type
            }, success: function (response) {
                $('#Kurs').text(response);
                $('#Kurs').show();
            }
        });
    }

    $('input:radio[name=invoice]').on('change', function () {
        if ($('input:radio[name=invoice]:checked').val() == 1) {
            var type = 4;
            $.ajax({
                url: 'getKurs',
                method: 'POST',
                data: {
                    type: type
                }, success: function (response) {
                    $('#Kurs').text(response);
                    $('#Kurs').show();
                }
            });
        } else {
            var type = 1;
            $.ajax({
                url: 'getKurs',
                method: 'POST',
                data: {
                    type: type
                }, success: function (response) {
                    $('#Kurs').text(response);
                    $('#Kurs').show();
                }
            });
        }
    });

    $('.price-val').on("click", function () {
        var descText = $(descPL).text()
        var priceID = $('#modal-id').text();
        var priceNewID = $('#' + priceID + '');
        var plid = $(this).attr('name');
        var tr = $(this).parent().children();
        var pl = '';
        var price = '';
        for (var i = 0; i < tr.length; i++) {
            //console.log('for');
            if (Number($(tr[i]).attr('name')) == 111) {
                price = $(tr[i]).text();
            } else if (Number($('#EmpPL').text()) != 0 && $(tr[i]).attr('minpl') == 1) {
                //console.log('if');
                //pl = $(tr[i]).attr('name');
                if (Number($('#EmpPL').text()) > Number($(tr[i]).attr('name'))) {
                    //console.log('if if');
                    for (var j = 0; j < tr.length; j++) {
                        if (Number($(tr[i]).attr('name')) == Number($('#EmpPL').text())) {
                            console.log('for if');
                            price = $(tr[i]).text();
                            descText = price;
                        }
                    }
                } else {
                    price = $(tr[i]).text();
                }
            } else if (Number($('#EmpPL').text()) != 0 && !($(tr[i]).attr('minpl') == 1)) {
                //console.log('else');
                for (var j = 0; j < tr.length; j++) {
                    if (Number($(tr[i]).attr('name')) == Number($('#EmpPL').text())) {
                        //console.log('for else');
                        price = $(tr[i]).text();
                        descText = price;
                    }
                }
            }
        }
        //console.log(price);
        for (var i = 0; i < tr.length; i++) {
            if (!$.isNumeric(price)) {
                $(priceNewID).text($(this).text());
                $(priceNewID).attr('name', plid);
                $('#myModal').modal("hide");
                $(descPL).text('');
                $(descText).text('');
            } else if ($.isNumeric(price) && Number($(this).text()) >= Number(price)) {
                $(priceNewID).text($(this).text());
                $(priceNewID).attr('name', plid);
                $('#myModal').modal("hide");
                $(descPL).text('');
                $(descText).text('');
            } else if ($.isNumeric(price) && Number($(this).text()) < Number(price)) {
                $(priceNewID).text('');
                $('#price-text').val('');
                alert('Вы не можете установить цену меньже чем ' + descText);
                return true;
            }
            /*} else {
             $(priceNewID).text($(this).text());
             $(priceNewID).attr('name', plid);
             $('#myModal').modal("hide");
             $(descPL).text('');
             $(descText).text('');
             }*/
        }
    });

    $('#price-text').on('change', function () {
        var descText = $(descPL).text();
        var priceID = $('#modal-id').text();
        var priceArr = $('.price-val');
        var priceIDNew = $('#' + priceID + '');
        var pl = '';
        var price = '';
        //var tr = $('#'+priceID+'').parent().parent();
        for (var i = 0; i < priceArr.length; i++) {
            if (Number($(this).val()) == $(priceArr[i]).text() && $(priceArr[i]).attr('name') == 111) {
                price = $(this).val();
            } else if (Number($('#EmpPL').text()) != 0 && $(priceArr[i]).attr('minpl') == 1) {
                //pl = $(tr[i]).attr('name');
                if (Number($('#EmpPL').text()) > Number($(priceArr[i]).attr('name'))) {
                    for (var j = 0; j < priceArr.length; j++) {
                        if (Number($(priceArr[i]).attr('name')) == Number($('#EmpPL').text())) {
                            price = $(priceArr[i]).text();
                            descText = price;
                        }
                    }
                } else {
                    price = $(priceArr[i]).text();
                }
            } else if (Number($('#EmpPL').text()) != 0 && !($(priceArr[i]).attr('minpl') == 1)) {
                for (var j = 0; j < priceArr.length; j++) {
                    if (Number($(priceArr[i]).attr('name')) == Number($('#EmpPL').text())) {
                        price = $(priceArr[i]).text();
                        descText = price;
                    }
                }
            }
        }
        console.log(price);
        /*for(var i = 0; i < priceArr.length; i++) {
         if($(priceArr[i]).attr('minpl') == 1) {
         pl = $(priceArr[i]).attr('name');
         price = $(priceArr[i]).text();
         }
         }*/
        for (var i = 0; i < priceArr.length; i++) {
            if (!$.isNumeric(price)) {
                //console.log('if');
                if ((Number($(priceArr[i]).text()) > Number($(this).val())) && (Number($(this).val()) > Number(($(priceArr[i - 1])).text()))) {
                    //$('#'+priceID+'').attr('name', $(priceArr[i]).attr('name')-1);
                    $(priceIDNew).text($(this).val());
                    $(priceIDNew).attr('name', $(priceArr[i]).attr('name'));
                    $('#myModal').modal("hide");
                    $(descPL).text('');
                    $(descText).text('');
                    $(this).val('');
                    return true;
                }
            } else if ($.isNumeric(price) && Number($(this).val()) >= Number(price)) {
                if ((Number($(priceArr[i]).text()) > Number($(this).val())) && (Number($(this).val()) > Number(($(priceArr[i - 1])).text()))) {
                    //console.log('else if 1');
                    //$('#'+priceID+'').attr('name', $(priceArr[i]).attr('name')-1);
                    $(priceIDNew).text($(this).val());
                    $(priceIDNew).attr('name', $(priceArr[i]).attr('name'));
                    $('#myModal').modal("hide");
                    $(descPL).text('');
                    $(descText).text('');
                    $(this).val('');
                    return true;
                }
            } else if ($.isNumeric(price) && Number($(this).text()) < Number(price)) {
                //console.log('else if 2');
                $('#price-text').val('');
                $(this).val('');
                $(priceIDNew).text('');
                alert('Вы не можете установить цену меньже чем ' + descText);
                return true;
            }
        }
    });

    $('#modal-done').on("click", function () {
        /*var priceID = $('#modal-id').text();
         var priceArr = $('.price-val');
         var price = $('#price-text');
         var priceVal = $(price).val();
         var priceIDNew = $('#'+priceID+'');
         if(!$.isNumeric(Number($(descPL).text()))) {
         $(priceIDNew).text(priceVal);
         for(var i = 0; i < priceArr.length; i++) {
         if(( Number($(priceArr[i]).text()) > Number(priceVal)) && (Number(priceVal) > Number($(priceArr[i-1]).text()))) {
         $('#'+priceID+'').attr('name', $(priceArr[i]).attr('name')-1);
         return true;
         }
         }
         $(price).val('');
         } else if(Number($(descPL).text()) < Number(priceVal)) {
         $(price).val('');
         $(priceIDNew).text('');
         alert('Вы не можете установить цену меньже чем '+ $(descPL).text());
         } else if(Number($(descPL).text() >= Number(priceVal))) {
         $(priceIDNew).text(priceVal);
         for(var i = 0; i < priceArr.length; i++) {
         if(( Number($(priceArr[i]).text()) > Number(priceVal)) && (Number(priceVal) > Number($(priceArr[i-1]).text()))) {
         $('#'+priceID+'').attr('name', $(priceArr[i]).attr('name')-1);
         return true;
         }
         }
         $(price).val('');
         } else if(!$.isNumeric($(descPL).text())) {
         $(priceIDNew).text(priceVal);
         for(var i = 0; i < priceArr.length; i++) {
         if(( Number($(priceArr[i]).text()) > Number(priceVal)) && (Number(priceVal) > (Number($(priceArr[i-1]).text())))) {
         $('#'+priceID+'').attr('name', $(priceArr[i]).attr('name')-1);
         return true;
         }
         }
         $(price).val('');
         } else {
         $(price).val('');
         $(priceIDNew).text('');
         alert('Вы не можете установить цену меньже чем '+ $(descPL).text());
         }*/
    });

    //$("#emps").prepend($('<option value=""></option>'));

    var objEmp = $('#emps');
    $(objEmp).select2();
    $(objEmp).on("change", function () {
        var emp = $('#emps option:selected').val();
        $.ajax({
            url: 'comps',
            method: 'POST',
            data: {
                emp: emp
            },
            success: function (responce) {
                //var res = $.parseJSON(responce);
                //console.log(responce);
                var selectHtml = '';
                var array = $.map(responce, function (value, index) {
                    selectHtml += '<option value=' + index + '>' + value + '</option>';
                });
                $('#comps').html('<select id="comp" class="form-control select btn btn-primary btn-lg" style = "height: 50px;">' + selectHtml + '</select>');
                $('#comp').select2();
                /*var selectHtml = '';
                 for(var i = 0; i < responce.length; i++)
                 {
                 selectHtml += '<option>'+responce[i]+'</option>';
                 }*/
                //$('#comps').html('{{ Form::select("pg", '+ responce[0] +', null, ["class" => "select btn btn-primary", "id" => "select-categ", "style" => "width: 100%; align-content: center;"]) }}');
                //$('#comps').html('{{ Form::select("comp", $'+responce+', null, ["id" => "comps","class" => "form-control select btn btn-primary btn-lg", "style" => "height: 50px;"]) }}');
            }
        });
    });
    $('#send').on("click", function () {
        $('#tbody-pos').remove();
        var table = $('#tbody').children();
        var res = new Array();
        for (var i = 0; i < table.length; i++) {
            var obj = {};
            var typeInv = $('input:radio[name=invoice]:checked').val();
            obj.CompID = $('#comp option:selected').val();
            obj.gr = $('#category option:selected').val();
            var stock = $('input:radio[name=stock]:checked').val();
            obj.empID = $('#emps option:selected').val();
            if (typeInv == 1) {
                obj.CodeID3 = 4;
            } else {
                obj.CodeID3 = 1;
            }
            if (stock == 1) {
                obj.stockID = 110;
            } else {
                obj.stockID = 118;
            }
            obj.shortName = $(table[i]).children('td').children('.shortName').text();
            obj.name = $(table[i]).children('td').children('.name').text();
            obj.quantity = $(table[i]).children('td').children('.quantity').text();
            obj.um = $(table[i]).children('td').children('.UM').text();
            obj.price = $(table[i]).children('td').children('.price').text();
            obj.pl = $(table[i]).children('td').children('.price').attr('name');
            res[i] = obj;
        }
        $('#tposition').remove();
        $.ajax({
            url: 'orders',
            method: 'POST',
            data: {
                res: res
            }, success: function (responce) {
                var array = $.map(responce, function (value, index) {

                });
                $('#send').attr('disabled', 'disabled');
                $('#createOrder').show();
                $('#table-filter').remove();
            }
        });
    });
    var objCat = $('#category');
    $(objCat).select2();
    $(objCat).on("change", function () {
        var categ = $('#category option:selected').val();
        var stock = $('input:radio[name=stock]:checked').val();
        var stockID;
        var kurs = $('#Kurs').text();
        if (stock == 1) {
            stockID = 110;
        } else {
            stockID = 118;
        }
        $.ajax({
            url: 'category',
            method: 'POST',
            data: {
                stockID: stockID,
                categ: categ,
                kurs: kurs
            }, success: function (res) {
                $('#table-filter').html(res);
                $('.price').on('click', function () {
                    //$('#descPL').text('');
                    var price = $(this);
                    var goodid = $(this).attr('goodid');
                    var res = new Array();
                    for (var i = 0; i < 11; i++) {
                        var obj = {};
                        obj.PriceMC = $(this).parent().parent().children('.p' + i).text();
                        obj.MinPLID = $(this).parent().parent().children('.p' + i).attr('minpl');
                        obj.PLID = $(this).parent().parent().children('.p' + i).attr('plid');
                        res[i] = obj;
                    }
                    for (var i = 0; i < res.length; i++) {
                        //$('#p'+res[i].PLID).text('');
                        $('#p' + res[i].PLID).attr("minpl", res[i].MinPLID);
                        if ($.isNumeric(res[i].PriceMC)) {
                            $('#p' + res[i].PLID).text(res[i].PriceMC);
                            //$('#p'+res[i].PLID).text((Math.ceil((res[i].PriceMC  / 6) * 100) / 100 * 6).toString());
                            if (res[i].MinPLID == 1) {
                                $(descPL).text('');
                                $(descText).text('');
                                //$(descPL).text((Math.ceil((res[i].PriceMC  / 6) * 100) / 100 * 6).toString());
                                $(descPL).text(res[i].PriceMC);
                                $(descText).text('Минимальная цена продажи ');
                                $(descText).css('color', 'red');
                                $(descText).show();
                                $(descPL).css('color', 'red');
                                $(descPL).show();
                            } else {
                                /*$(descPL).text('');
                                 $(descText).text('');*/
                            }
                        } else {
                            $('#p' + res[i].PLID).text('-');
                        }
                    }
                    var tr = $(this).parent().parent();
                    $('#modal-id').text($(this).attr('id'));
                    $('#myModal').modal();
                });
                $('.addGood').click(function () {
                    $(this).attr('disabled', true);
                    var t = $(this).parent('th').parent('tr').children('th');
                    var shortName = t.children('.shortName').text();
                    var id = $(this).attr('id');
                    var name = t.children('.name').text();
                    var quantity = t.children('.quantity').val();
                    var pl = t.children('.price').attr('name');
                    var price = t.children('.price').text();
                    var rem_cashless = t.children('.remains_cashless').text();
                    var rem_cash = t.children('.remains_cash').text();
                    var form = $(this).parent();
                    var typeInv = $('input:radio[name=invoice]:checked').val();
                    var comp = $('#comp option:selected').val();
                    var gr = $('#category option:selected').val();
                    var good = new Array();
                    var goods = new Array();
                    var invID;
                    var stock = $('input:radio[name=stock]:checked').val();
                    var emp = $('#emps option:selected').val();
                    var UM = t.children('.UM').text();
                    var stockID;
                    if (typeInv == 1) {
                        invID = 102;
                    } else {
                        invID = 1;
                    }
                    if (stock == 1) {
                        stockID = 110;
                    } else {
                        stockID = 118;
                    }
                    var position = '<tr><td><div class="shortName">' + shortName + '</div></td>' +
                        '<td><div class="name">' + name + '</div></td>' +
                        '<td><div class="quantity">' + quantity + '</div></td>' +
                        '<td><div class="UM">' + UM + '</div></td>' +
                        '<td><div class="price" name="' + pl + '">' + price + '</div></td>' +
                        '<td><div class="" name="' + pl + '">' + (price * quantity).toFixed(2) + '</div></td>' +
                        '<td><input type="button" name="' + id + '" class="delGood btn btn-primary" value="Удалить"></td></tr>';
                    $('#tposition').show();
                    $('#tbody-pos').before(position);
                    $('.delGood').on("click", function () {
                        var id = $(this).attr('name');
                        $('#' + id).attr('disabled', false);
                        $(this).parent().parent().remove();
                    });
                });
                $('#btnCloseModal').click(function () {
                    $('#price-list').remove();
                });
                $('.price-btn').on("click", function () {
                    var price = $(this).prop('name');
                    var tr = $(this).parent().parent();
                    tr.children('th').children('h5').children('input').val(price);
                });
                $('.quantity').on("blur", function () {
                });
            }
        });
    });
});