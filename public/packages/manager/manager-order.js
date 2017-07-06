$(document).ready(function () {
    var descText = $('#descText');
    var descPL = $('#descPL');

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
            if (Number($('#EmpPL').text()) != 0 && $(tr[i]).attr('minpl') == 1) {
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
            if (Number($('#EmpPL').text()) != 0 && $(priceArr[i]).attr('minpl') == 1) {
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
    $('#sender').on("click", function () {
        $('#tbody-pos').remove();
        var table = $('#tbody').children();
        var res = new Array();
        for (var i = 0; i < table.length; i++) {
            var obj = {};
            var typeInv = $('input:radio[name=invoice]:checked').val();
            obj.CompID = $('#comp option:selected').val();
            obj.gr = $('#category option:selected').val();
            var stock = $('input:radio[name=stock]:checked').val();
            //obj.orderID = $('#newOrder').val();
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
            url: 'manager-order',
            method: 'POST',
            data: {
                res: res
            }, success: function (responce) {
                var array = $.map(responce, function (value, index) {
                });
                $('#sender').attr('disabled', 'disabled');
                $('#createOrder').show();
                $('#table-filter').remove();
                /*if(responce.state == 'success')
                 {
                 $('#sender').attr('disabled', 'disabled');
                 $('#createOrder').show();
                 $('#table-filter').remove();
                 } else {
                 if(responce.state.error)
                 {
                 $('#table-filter').remove();
                 $('#error').html('<h1>У нас проблемы</h1>');
                 } else if (responce.state.warning)
                 {
                 $('#table-filter').remove();
                 $('#error').html('<h1>У нас проблемы</h1>');
                 }
                 }*/
            }
        });
    });
    var category = $('#category');
    $(category).select2();
    var comp = $('#comp');
    $(comp).select2();
    $(comp).on('change', function () {
        $('#category').attr('disabled', false);
    });
    $(category).on("change", function () {
        $('#sender').attr('disabled', false);
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
                categ: categ,
                stockID: stockID,
                kurs: kurs
            }, success: function (res) {
                $('#table-filter').html(res);
                $(descPL).text('');
                $(descText).text('');
                $('.price').on('click', function () {
                    var price = $(this);
                    var goodid = $(this).attr('goodid');
                    var res = new Array();

                    /*if($.isNumeric($(this).parent().parent().children('.p0').text())) {
                     $('#p100').text((Math.ceil(($(this).parent().parent().children('.p0').text()  / 6) * 100) / 100 * 6).toFixed(2));
                     } else {
                     $('#p100').text('');
                     }*/
                    /*$('#p101').text((Math.ceil(($(this).parent().parent().children('.p1').text()  / 6) * 100) / 100 * 6).toFixed(2));
                     $('#p102').text((Math.ceil(($(this).parent().parent().children('.p2').text()  / 6) * 100) / 100 * 6).toFixed(2));
                     $('#p103').text((Math.ceil(($(this).parent().parent().children('.p3').text()  / 6) * 100) / 100 * 6).toFixed(2));
                     $('#p104').text((Math.ceil(($(this).parent().parent().children('.p4').text()  / 6) * 100) / 100 * 6).toFixed(2));
                     $('#p105').text((Math.ceil(($(this).parent().parent().children('.p5').text()  / 6) * 100) / 100 * 6).toFixed(2));
                     $('#p106').text((Math.ceil(($(this).parent().parent().children('.p6').text()  / 6) * 100) / 100 * 6).toFixed(2));
                     $('#p107').text((Math.ceil(($(this).parent().parent().children('.p7').text()  / 6) * 100) / 100 * 6).toFixed(2));
                     $('#p108').text((Math.ceil(($(this).parent().parent().children('.p8').text()  / 6) * 100) / 100 * 6).toFixed(2));
                     $('#p109').text((Math.ceil(($(this).parent().parent().children('.p9').text()  / 6) * 100) / 100 * 6).toFixed(2));
                     $('#p110').text((Math.ceil(($(this).parent().parent().children('.p10').text()  / 6) * 100) / 100 * 6).toFixed(2));*/
                    //$('#descPL').text('');

                    for (var i = 0; i < 11; i++) {
                        var obj = {};
                        obj.PriceMC = $(this).parent().parent().children('.p' + i).text();
                        obj.MinPLID = $(this).parent().parent().children('.p' + i).attr('minpl');
                        obj.PLID = $(this).parent().parent().children('.p' + i).attr('plid');
                        res[i] = obj;
                    }
                    for (var i = 0; i < res.length; i++) {
                        //$('#p'+res[i].PLID).text('');
                        if ($.isNumeric(res[i].PriceMC)) {
                            $('#p' + res[i].PLID).text((Math.ceil((res[i].PriceMC / 6) * 100) / 100 * 6).toFixed(2));
                            if (res[i].MinPLID == 1) {
                                $(descPL).text('');
                                $(descText).text('');
                                $(descPL).text((Math.ceil((res[i].PriceMC / 6) * 100) / 100 * 6).toFixed(2));
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
                    var form = $(this).parent();
                    var typeInv = $('input:radio[name=invoice]:checked').val();
                    var comp = $('#comp option:selected').val();
                    var gr = $('#category option:selected').val();
                    var invID;
                    var stock = $('input:radio[name=stock]:checked').val();
                    var pl = t.children('.price').attr('name');
                    var price = t.children('.price').text();
                    var rem_cashless = t.children('.remains_cashless').text();
                    var rem_cash = t.children('.remains_cash').text();
                    var UM = t.children('.UM').text();
                    var stockID;
                    if (typeInv == 1) {
                        invID = 4;
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
                        '<td><input type="button" name="' + id + '" class="delGood btn btn-primary" value="Удалить"></td></tr>';
                    $('#tposition').show();
                    $('#tbody-pos').before(position);
                    $('.delGood').on("click", function () {
                        var id = $(this).attr('name');
                        $('#' + id + '').attr('disabled', false);
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
    $('#select-categ').on("change", function () {
        var categ = $('#select-categ option:selected').text();
        $.ajax({
            url: 'categ',
            method: 'POST',
            data: {
                categ: categ
            },
            success: function (responce) {
                //localStorage.setItem('categ', responce);
                var selectHtml = '';
                for (var i = 0; i < responce.length; i++) {
                    selectHtml += '<option>' + responce[i] + '</option>';
                }
                $('#sel').html('<select id="sel-cat" class="select btn btn-primary" style="width: 100%; align-content: center;">' + selectHtml + '</select>');
                //$('#sel-cat')
                /*$('#sel-cat').change(function()
                 {
                 var cat = $(this).val();
                 console.log(cat);
                 });*/
                //$('#sel1').html('{{ Form::select("pg", $'+ responce[0] +', null, ["class" => "select btn btn-primary", "id" => "select-categ", "style" => "width: 100%; align-content: center;"]) }}');
                $('#sel-cat').on("click", function () {
                    var cat = $(this).val();
                    $.ajax({
                        url: 'cat',
                        method: 'POST',
                        data: {
                            cat: cat
                        },
                        success: function (res) {
                            $('#table-filter').html(res);
                            $('.price').on("click", function () {
                                var name = $(this).prop('id');
                                var tr = $(this).parent().parent().parent();
                                var p100 = tr.children().children('.p100').val();
                                var p101 = tr.children().children('.p101').val();
                                var p102 = tr.children().children('.p102').val();
                                var p103 = tr.children().children('.p103').val();
                                var p104 = tr.children().children('.p104').val();
                                var p105 = tr.children().children('.p105').val();
                                var p106 = tr.children().children('.p106').val();
                                var p107 = tr.children().children('.p107').val();
                                var p108 = tr.children().children('.p108').val();
                                var p109 = tr.children().children('.p109').val();
                                var p110 = tr.children().children('.p110').val();
                                var temp = _.template($('<script type="text/html" id="price-list">' +
                                    '<div id="div-price" style="width: 100%; height: 100%; background-color: rgba(12, 12, 12, 0.33); position: absolute;">' +
                                    '<div class="table-container"  style="background-color: rgb(255, 255, 255); width: 50%; height: 50%;  z-index: 2; position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%);">' +
                                    '<span class="btn" onclick="CloseModal()" style="position: absolute;  right: 1px; font-size: 20px;">×</span>' +
                                    '<br/><br/><br/><br/>' +
                                    '<table class="table table-bordered">' +
                                    '<tr>' +
                                    '<th>100</th>' +
                                    '<th>101</th>' +
                                    '<th>102</th>' +
                                    '<th>103</th>' +
                                    '<th>104</th>' +
                                    '<th>105</th>' +
                                    '<th>106</th>' +
                                    '<th>107</th>' +
                                    '<th>108</th>' +
                                    '<th>109</th>' +
                                    '<th>110</th>' +
                                    '</tr>' +
                                    '<tr>' +
                                    '<th><input class="price-val" type="button" value="' + p100 + '"></th>' +
                                    '<th><input class="price-val" type="button" value="' + p101 + '"></th>' +
                                    '<th><input class="price-val" type="button" value="' + p102 + '"></th>' +
                                    '<th><input class="price-val" type="button" value="' + p103 + '"></th>' +
                                    '<th><input class="price-val" type="button" value="' + p104 + '"></th>' +
                                    '<th><input class="price-val" type="button" value="' + p105 + '"></th>' +
                                    '<th><input class="price-val" type="button" value="' + p106 + '"></th>' +
                                    '<th><input class="price-val" type="button" value="' + p107 + '"></th>' +
                                    '<th><input class="price-val" type="button" value="' + p108 + '"></th>' +
                                    '<th><input class="price-val" type="button" value="' + p109 + '"></th>' +
                                    '<th><input class="price-val" type="button" value="' + p110 + '"></th>' +
                                    '</tr>' +
                                    '</table>' +
                                    '</div>' +
                                    '</div></script>').html());
                                $('body').before(temp({}));
                                $('.price-val').on("click", function () {
                                    $('#' + name + '').val($(this).prop('value'));
                                });
                                $('#btnCloseModal').click(function () {
                                    $('#price-list').remove();
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
                                var tr = $(this).parent().parent();
                                var residue = tr.children('th').children('h4').children('input').val();
                                var quantity = $(this).val();
                                tr.children('th').children('h4').children('input').val(residue - quantity);
                            });
                        }
                    });
                });
            }
        });
    });
    $('input[type="button"]').on("click", function () {
        var id = $(this).prop('name');
        $.ajax({
            url: 'filter',
            method: 'POST',
            data: {
                id: id
            },
            success: function (responce) {
                $('#table-filter').html(responce);
            },
            error: function (responce) {
            }
        });
    });
});