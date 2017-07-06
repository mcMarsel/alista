$(document).ready(function () {
    var descText = $('#descText');
    var descPL = $('#descPL');
    var mModalIdObj = $('#m-modal-id');
    var curKurs = $('#curKurs').text();
    var EmpPL = $('#EmpPL');

    $('.quantity').on('change', function () {
        var tr = $(this).parent().parent();
        var curPrice = $(tr).children().children('.m-price').text();
        var curKurs = $('#curKurs').text();
        var qty = $(this).val();
        $(tr).children('.totalPCC').text(Number(qty * curPrice).toFixed(2));
        $(tr).children('.totalPMC').text(Number((qty * curPrice) / curKurs).toFixed(2));
    });

    $('#m-price-text').on('change', function () {
        var valuePrice = $(this).val();
        var tr = $(this).parent().children('#table-modal').children().children('.tr-val');
        var chtr = $(tr).children();
        var priceBtn = $('#m-modal-id').text();
        var priceBtnObj = $('#' + priceBtn + '');
        var pl = '';
        var price = '';
        for (var i = 0; i < chtr.length; i++) {
            if (Number($(this).val()) == $(chtr[i]).text() && $(chtr[i]).attr('name') == 111) {
                price = $(this).val();
            } else if (Number($(EmpPL).text()) != 0 && $(chtr[i]).attr('minpl') == 1) {
                //pl = $(tr[i]).attr('name');
                if (Number($(EmpPL).text()) > Number($(chtr[i]).attr('name'))) {
                    for (var j = 0; j < chtr.length; j++) {
                        if (Number($(chtr[i]).attr('name')) == Number($(EmpPL).text())) {
                            price = $(chtr[i]).text();
                            descText = price;
                        }
                    }
                } else {
                    price = $(chtr[i]).text();
                }
            } else if (Number($(EmpPL).text()) != 0 && !($(chtr[i]).attr('minpl') == 1)) {
                for (var j = 0; j < chtr.length; j++) {
                    if (Number($(chtr[i]).attr('name')) == Number($(EmpPL).text())) {
                        price = $(chtr[i]).text();
                        descText = price;
                    }
                }
            }
        }
        for (var i = 0; i < chtr.length; i++) {
            if (!$.isNumeric(price)) {
                //console.log('if');
                if ((Number($(chtr[i]).text()) > Number(valuePrice)) && (Number(valuePrice) > Number(($(chtr[i - 1])).text()))) {
                    //$('#'+priceID+'').attr('name', $(priceArr[i]).attr('name')-1);
                    $(priceBtnObj).text($(this).val());
                    $(priceBtnObj).attr('name', $(chtr[i]).attr('name'));
                    $('#mModal').modal("hide");
                    $(descPL).text('');
                    $(descText).text('');
                    $(this).val('');
                    return true;
                }
            } else if ($.isNumeric(price) && Number(valuePrice) >= Number(price)) {
                if ((Number($(chtr[i]).text()) > Number(valuePrice)) && (Number(valuePrice) > Number(($(chtr[i - 1])).text()))) {
                    //console.log('else if 1');
                    //$('#'+priceID+'').attr('name', $(priceArr[i]).attr('name')-1);
                    $(priceBtnObj).text($(this).val());
                    $(priceBtnObj).attr('name', $(chtr[i]).attr('name'));
                    $('#mModal').modal("hide");
                    $(descPL).text('');
                    $(descText).text('');
                    $(this).val('');
                    return true;
                }
            } else if ($.isNumeric(price) && Number(valuePrice) < Number(price)) {
                //console.log('else if 2');
                $('#price-text').val('');
                $(this).val('');
                $(priceBtnObj).text('');
                alert('Вы не можете установить цену меньже чем ' + descText);
                return true;
            }
        }
    });

    $('.m-price-val').on('click', function () {
        var pl = '';
        var price = '';
        var priceID = $('#modal-id').text();
        var priceNewID = $('#' + priceID + '');
        var tr = $(this).parent();
        var chtr = $(tr).children();
        var valuePrice = $(this).text();
        var priceBtn = $('#m-modal-id').text();
        var priceBtnObj = $('#' + priceBtn + '');
        var plid = $(this).attr('name');
        for (var i = 0; i < chtr.length; i++) {
            //console.log('for');
            if (Number($(chtr[i]).attr('name')) == 111) {
                price = $(chtr[i]).text();
            } else if (Number($(EmpPL).text()) != 0 && $(chtr[i]).attr('minpl') == 1) {
                //console.log('if');
                //pl = $(tr[i]).attr('name');
                if (Number($(EmpPL).text()) > Number($(chtr[i]).attr('name'))) {
                    //console.log('if if');
                    for (var j = 0; j < chtr.length; j++) {
                        if (Number($(chtr[i]).attr('name')) == Number($(EmpPL).text())) {
                            //console.log('for if');
                            price = $(chtr[i]).text();
                            descText = price;
                        }
                    }
                } else {
                    price = $(chtr[i]).text();
                }
            } else if (Number($(EmpPL).text()) != 0 && !($(chtr[i]).attr('minpl') == 1)) {
                //console.log('else');
                for (var j = 0; j < chtr.length; j++) {
                    if (Number($(chtr[i]).attr('name')) == Number($(EmpPL).text())) {
                        //console.log('for else');
                        price = $(chtr[i]).text();
                        descText = price;
                    }
                }
            }
        }
        for (var i = 0; i < chtr.length; i++) {
            //console.log('for');
            //console.log(valuePrice);
            if (!$.isNumeric(price)) {
                //console.log('if');
                $(priceBtnObj).text(valuePrice);
                $(priceBtnObj).attr('name', plid);
                $('#mModal').modal("hide");
                $(descPL).text('');
                $(descText).text('');
            } else if ($.isNumeric(price) && Number(valuePrice) >= Number(price)) {
                //console.log('else if1');
                $(priceBtnObj).text(valuePrice);
                $(priceBtnObj).attr('name', plid);
                $('#mModal').modal("hide");
                $(descPL).text('');
                $(descText).text('');
            } else if ($.isNumeric(price) && Number(valuePrice) < Number(price)) {
                //console.log('else if2');
                $(priceBtnObj).text('');
                $('#price-text').val('');
                alert('Вы не можете установить цену меньже чем ' + descText);
                return true;
            }
        }
    });

    if ($('#emp option:selected').val()) {
        var empID = $('#empID').text();
        var emp = $('#emp');
        var empCh = $(emp).children();
        for (var i = 0; i < empCh.length; i++) {
            if ($(empCh[i]).attr('value') == empID) {
                $(empCh[i]).attr('selected', 'selected');
            }
        }
        $(emp).select2();
    }

    $('.price-val').on("click", function () {
        if ($.isNumeric($(this).text())) {
            var priceID = $('#modal-id').text();
            var nPriceID = $('#' + priceID + '');
            $(nPriceID).text($(this).text());
            var plid = $(this).attr('name');
            $(nPriceID).attr('name', plid);
            $('#myModal').modal("hide");
        }
    });

    $('#modal-done').on("click", function () {
        /*var priceID = $('#modal-id').text();
         var priceArr = $('.price-val');
         var price = $('#price-text').val();
         var priceIdObj = $('#'+priceID+'');
         $(priceIdObj).text(price);
         for(var i = 0; i < priceArr.length; i++) {
         if(( $(priceArr[i]).text() > price) && (price > $(priceArr[i-1]).text())) {
         $(priceIdObj).attr('name', $(priceArr[i]).attr('name')-1);
         return true;
         }
         }*/
    });

    var compID = $('#curComp').attr('for');
    var ecompObj = $('#e-comps');
    var comps = $(ecompObj).children();

    for (var i = 0; i < comps.length; i++) {
        if ($(comps[i]).attr('value') == compID) {
            $(comps[i]).attr('selected', 'selected');
        }
    }

    var invObj = $('#inv');
    var inv = $(invObj).children();
    var typeInv = $('#typeInv').text();

    for (var i = 0; i < inv.length; i++) {
        if ($(inv[i]).attr('value') == typeInv) {
            $(inv[i]).attr('selected', 'selected');
        }
    }

    $(invObj).select2();
    $(ecompObj).select2();
    var stockObj = $('#stock');
    var stockIdObj = $('#stockID');
    var stock = $(stockObj).children();
    var stockID = $(stockIdObj).text();

    for (var i = 0; i < stock.length; i++) {
        if ($(stock[i]).attr('value') == stockID) {
            $(stock[i]).attr('selected', 'selected');
        }
    }

    $(stockObj).select2();

    $('.posDel').on('click', function () {
        $(this).parent().parent().remove();
    });

    $('#add').on('click', function () {
        $(this).remove();
        $.ajax({
            url: 'addCateg',
            method: 'POST',
            data: {
                stasus: 'ok'
            },
            success: function (responce) {
                var selectHtml = '';
                var array = $.map(responce, function (value, index) {
                    selectHtml += '<option value=' + index + '>' + value + '</option>';
                });
                $('#addpos').html('</br><select id="sel-cat" class="select btn btn-primary" style="width: 100%; align-content: center;">' + selectHtml + '</select>');
                var selCatObj = $('#sel-cat');
                $(selCatObj).select2();
                $(selCatObj).on("change", function () {
                    var categ = $('#sel-cat option:selected').val();
                    var stock = $('#stockID').text();
                    $.ajax({
                        url: 'addGoods',
                        method: 'POST',
                        data: {
                            stock: stock,
                            categ: categ
                        },
                        success: function (responce) {
                            $('#tgoods').show();
                            $('#tbgoods').html(responce);
                            $('.price').on('click', function () {
                                $(mModalIdObj).text($(this).attr('id'));
                                var price = $(this);
                                var tr = $(this).parent().parent();
                                var res = new Array();
                                for (var i = 0; i < 11; i++) {
                                    var obj = {};
                                    obj.PriceMC = tr.children('.p' + i).text();
                                    obj.MinPLID = tr.children('.p' + i).attr('minpl');
                                    obj.PLID = tr.children('.p' + i).attr('plid');
                                    res[i] = obj;
                                }
                                for (var i = 0; i < res.length; i++) {
                                    if ($.isNumeric(res[i].PriceMC)) {
                                        $('#p0' + i + 'm').text(res[i].PriceMC);
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
                                        $('#p0' + i + 'm').text('-');
                                    }
                                }
                                $(mModalIdObj).text($(this).attr('id'));
                                $('#mModal').modal();
                            });
                            $('.btnAddGood').click(function () {
                                var tb = $('#tbody-g').children();
                                var lastIndex = $(tb).length;
                                var tr = $(this).parent().parent();
                                /*var p100 = tr.children('.pl0').text();
                                 var p101 = tr.children('.pl1').text();
                                 var p102 = tr.children('.pl2').text();
                                 var p103 = tr.children('.pl3').text();
                                 var p104 = tr.children('.pl4').text();
                                 var p105 = tr.children('.pl5').text();
                                 var p106 = tr.children('.pl6').text();
                                 var p107 = tr.children('.pl7').text();
                                 var p108 = tr.children('.pl8').text();
                                 var p109 = tr.children('.pl9').text();
                                 var p110 = tr.children('.pl10').text();*/
                                var t = $(this).parent('th').parent('tr').children('th');
                                var shortName = t.children('.shortName').text();
                                var name = t.children('.name').text();
                                var quantity = t.children('.quantity').val();
                                var UM = t.children('.UM').text();
                                var pl = t.children('.price').attr('name');
                                var price = t.children('.price').text();
                                var rem_cashless = t.children('.remains_cashless').text();
                                var rem_cash = t.children('.remains_cash').text();
                                var UM = t.children('.UM').text();
                                var stockID;
                                var curKurs = $('#curKurs').text();
                                var position = '<tr class="touch">' +
                                    '<th class="ShortProdName">' + shortName + '</th>' +
                                    '<th class="ProdName">' + name + '</th>' +
                                    '<th class="Qty"><input value="' + quantity + '" class="quantity" type="number" autocorrect="off" pattern="\d+" novalidate=""></th>' +
                                    '<th class="UM">' + UM + '</th>' +
                                    '<th><span style="width: 100%; height: 100%" class="btn m-price PriceMC" name="' + pl + '" id="m-price' + lastIndex + '">' + Number(price).toFixed(2) + '</span></th>' +
                                    '<th class="totalPCC">' + Number((quantity * price)).toFixed(2) + '</th>' +
                                    '<th class="totalPMC">' + Number(((quantity * price) / curKurs)).toFixed(2) + '</th>';
                                for (var i = 0; i < 11; i++) {
                                    position += '<th class="p' + i + '" hidden="hidden">' + tr.children('.p' + i).text();
                                    +'</th>';
                                }
                                /*'<th class="pl0" hidden="hidden">'+ p100 +'</th>'+
                                 '<th class="pl1" hidden="hidden">'+ p101 +'</th>'+
                                 '<th class="pl2" hidden="hidden">'+ p102 +'</th>'+
                                 '<th class="pl3" hidden="hidden">'+ p103 +'</th>'+
                                 '<th class="pl4" hidden="hidden">'+ p104 +'</th>'+
                                 '<th class="pl5" hidden="hidden">'+ p105 +'</th>'+
                                 '<th class="pl6" hidden="hidden">'+ p106 +'</th>'+
                                 '<th class="pl7" hidden="hidden">'+ p107 +'</th>'+
                                 '<th class="pl8" hidden="hidden">'+ p108 +'</th>'+
                                 '<th class="pl9" hidden="hidden">'+ p109 +'</th>'+
                                 '<th class="pl10" hidden="hidden">'+ p110 +'</th>'+*/
                                position += '<th><input type="button" class="delGood btn btn-primary" value="Удалить"></th></tr>';
                                $('#tposition').show();
                                $('#tbody-pos').before(position);
                                $('.m-price').on('click', function () {
                                    $(mModalIdObj).text($(this).attr('id'));
                                    var price = $(this);
                                    var tr = $(this).parent().parent();
                                    var res = new Array();
                                    for (var i = 0; i < 11; i++) {
                                        var obj = {};
                                        obj.PriceMC = tr.children('.pl' + i).text();
                                        obj.MinPLID = tr.children('.pl' + i).attr('minpl');
                                        obj.PLID = tr.children('.pl' + i).attr('plid');
                                        res[i] = obj;
                                    }
                                    for (var i = 0; i < res.length; i++) {
                                        if ($.isNumeric(tr.children('#pl' + i).text())) {
                                            $('#p0' + i + 'm').text(Number(tr.children('#pl' + res[i].PriceMC).text()).toFixed(2));
                                        } else {
                                            $('#p0' + i + 'm').text('-');
                                        }
                                        if (res[i].MinPLID == 1) {
                                            $('#descPL').text((Math.ceil((res[i].PriceMC / 6) * 100) / 100 * 6).toFixed(2));
                                            $('#descText').text('Минимальная цена продажи ');
                                            $('#descText').css('color', 'red');
                                            $('#descText').show();
                                            $('#descPL').css('color', 'red');
                                            $('#descPL').show();
                                        } else {
                                            $('#descText').text('');
                                            $('#descPL').text('');
                                        }
                                    }
                                    /*var p100 = tr.children('.pl0').text();
                                     var p101 = tr.children('.pl1').text();
                                     var p102 = tr.children('.pl2').text();
                                     var p103 = tr.children('.pl3').text();
                                     var p104 = tr.children('.pl4').text();
                                     var p105 = tr.children('.pl5').text();
                                     var p106 = tr.children('.pl6').text();
                                     var p107 = tr.children('.pl7').text();
                                     var p108 = tr.children('.pl8').text();
                                     var p109 = tr.children('.pl9').text();
                                     var p110 = tr.children('.pl10').text();
                                     if($.isNumeric(p100)) {
                                     $('#p100m').text(Number(p100).toFixed(2));
                                     } else {
                                     $('#p100m').text('-');
                                     }
                                     $('#p101m').text(Number(p101).toFixed(2));
                                     $('#p102m').text(Number(p102).toFixed(2));
                                     $('#p103m').text(Number(p103).toFixed(2));
                                     $('#p104m').text(Number(p104).toFixed(2));
                                     $('#p105m').text(Number(p105).toFixed(2));
                                     $('#p106m').text(Number(p106).toFixed(2));
                                     $('#p107m').text(Number(p107).toFixed(2));
                                     $('#p108m').text(Number(p108).toFixed(2));
                                     $('#p109m').text(Number(p109).toFixed(2));
                                     $('#p110m').text(Number(p110).toFixed(2));*/
                                    $(mModalIdObj).text($(this).attr('id'));
                                    $('#mModal').modal();
                                });
                                $('.quantity').on('change', function () {
                                    var tr = $(this).parent().parent();
                                    var curPrice = $(tr).children().children('.m-price').text();
                                    var curKurs = $('#curKurs').text();
                                    var qty = $(this).val();
                                    $(tr).children('.totalPCC').text(Number(qty * curPrice).toFixed(2));
                                    $(tr).children('.totalPMC').text(Number((qty * curPrice) / curKurs).toFixed(2));
                                });
                                $('.delGood').on("click", function () {
                                    var tr = $(this).parent().parent().remove();
                                });
                            });
                        }
                    });
                });
            }
        });
    });

    $('.m-price').on('click', function () {
        $(mModalIdObj).text($(this).attr('id'));
        var price = $(this);
        var tr = $(this).parent().parent();
        var res = new Array();
        for (var i = 0; i < 11; i++) {
            var obj = {};
            obj.PriceMC = tr.children('.pl' + i).text();
            obj.MinPLID = tr.children('.pl' + i).attr('minpl');
            obj.PLID = tr.children('.pl' + i).attr('plid');
            res[i] = obj;
        }
        for (var i = 0; i < res.length; i++) {
            if ($.isNumeric(tr.children('#pl' + i).text())) {
                $('#p0' + i + 'm').text(Number(tr.children('#pl' + i).text()).toFixed(2));
            } else {
                $('#p0' + i + 'm').text('-');
            }
            if (res[i].MinPLID == 1) {
                $(descPL).text((Math.ceil((res[i].PriceMC / 6) * 100) / 100 * 6).toFixed(2));
                $(descText).text('Минимальная цена продажи ');
                $(descText).css('color', 'red');
                $(descText).show();
                $(descPL).css('color', 'red');
                $(descPL).show();
            } else {
                $(descText).text('');
                $(descPL).text('');
            }
        }
        /*var p100 = tr.children('.pl0').text();
         var p101 = tr.children('.pl1').text();
         var p102 = tr.children('.pl2').text();
         var p103 = tr.children('.pl3').text();
         var p104 = tr.children('.pl4').text();
         var p105 = tr.children('.pl5').text();
         var p106 = tr.children('.pl6').text();
         var p107 = tr.children('.pl7').text();
         var p108 = tr.children('.pl8').text();
         var p109 = tr.children('.pl9').text();
         var p110 = tr.children('.pl10').text();
         if($.isNumeric(p100)) {
         $('#p100m').text(Number(p100).toFixed(2));
         } else {
         $('#p100m').text('-');
         }
         $('#p101m').text(Number(p101).toFixed(2));
         $('#p102m').text(Number(p102).toFixed(2));
         $('#p103m').text(Number(p103).toFixed(2));
         $('#p104m').text(Number(p104).toFixed(2));
         $('#p105m').text(Number(p105).toFixed(2));
         $('#p106m').text(Number(p106).toFixed(2));
         $('#p107m').text(Number(p107).toFixed(2));
         $('#p108m').text(Number(p108).toFixed(2));
         $('#p109m').text(Number(p109).toFixed(2));
         $('#p110m').text(Number(p110).toFixed(2));*/
        $(mModalIdObj).text($(this).attr('id'));
        $('#mModal').modal();
    });

    var sendBtn = $('#send');

    $(sendBtn).on("click", function () {
        $('#tbody-pos').remove();
        var table = $('#tbody-g').children();
        var res = new Array();
        var ordIdObj = $('#ordID');
        for (var i = 0; i < table.length; i++) {
            var obj = {};
            if ($('#emp option:selected').val()) {
                obj.EmpID = $('#emp option:selected').val();
            } else {
                obj.EmpID = $('#emp').text();
            }
            obj.typeInv = $('#inv option:selected').val();
            obj.CompID = $('#e-comps option:selected').val();
            obj.stock = $('#stock option:selected').val();
            obj.orderID = $(ordIdObj).text();
            obj.shortName = $(table[i]).children('.ShortProdName').text();
            obj.name = $(table[i]).children('.ProdName').text();
            obj.quantity = $(table[i]).children('.Qty').children().val();
            obj.um = $(table[i]).children('.UM').text();
            obj.price = $(table[i]).children().children('.PriceMC').text();
            obj.pl = $(table[i]).children().children('.PriceMC').attr('name');
            res[i] = obj;
        }
        console.log(res);
        var ordID = $(ordIdObj).text();
        $('#tposition').remove();
        $.ajax({
            url: 'saveEditOrder',
            method: 'POST',
            data: {
                res: res,
                orderID: ordID
            }, success: function (responce) {
                //if(responce.message.success)
                //{
                console.log(responce);
                $(sendBtn).removeClass('btn-primary');
                $(sendBtn).addClass('btn-success');
                $(sendBtn).attr('disabled', 'disabled');
                $('.posDel').attr('disabled', true);
                $('.delGood').attr('disabled', true);
                $('.table-container').remove();
                $('#sel-cat').remove();
                //$('#add').remove();
                //window.location.href = "http://metiz.alista.org.ua/accr";
                //$('#createOrder').show();
                //$('#table-filter').remove();
                /*} else {
                 $('#table-filter').remove();
                 $('#error').html('<h1>У нас проблемы</h1>');
                 }*/
            }
        });
    });

});