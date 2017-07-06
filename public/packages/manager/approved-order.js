$(document).ready(function () {
    var getCashObj = $('#getCash');
    var getCashTextObj = $('#getCashText');
    var payFormObj = $('#payForm');
    var payFormTextObj = $('#payFormText');
    var payerObj = $('#payer');
    var payerTextObj = $('#payerText');
    var payerTObj = $('#payerT');
    var transporterIDObj = $('#transporterID');
    var transporterNameObj = $('#transporterName');
    var addresseeObj = $('#addressee');
    var addresseeSelObj = $('#addresseeSel');
    var addresseeTextObj = $('#addresseeText');
    var addressSelObj = $('#addressSel');
    var addressTextObj = $('#addressText');
    var addressObj = $('#address');
    var cityObj = $('#city');
    var cityTextObj = $('#cityText');
    var originatorObj = $('#originator');
    var stockTransporterObj = $('#stockTransporter');
    var stockTransporterTextObj = $('#stockTransporterText');
    var specialNotesObj = $('#specialNotes');
    var specialNotesTextObj = $('#specialNotesText');
    var CodeID3 = $('#CodeID3');
    var CompID = $('#CompID');
    var orderID = $('#approved-orderID');
    var sendApproved = $('#sendApproved');
    var checkPayer = $('#checkPayer');

    function formatRepo(repo) {
        if (repo.loading) return repo.text;
        var markup = '<div class="clearfix">' +
            '<div clas="col-sm-10">' +
            '<div class="clearfix">' +
            '<div class="col-sm-6">' + repo.full_name + '</div>' +
            '<div class="col-sm-4">' + repo.id + '</div>' +
            '</div>';
        if (repo.description) {
            markup += '<div>' + repo.description + '</div>';
        }
        markup += '</div></div>';
        return markup;
    }

    function formatRepoSelection(repo) {
        return repo.full_name;
    }

    $('#dateShipping').on('change', function () {
        $('#transporterText').show();
        $(transporterNameObj).show();
        $(transporterNameObj).select2({
            theme: "classic"
        });
    });

    $(checkPayer).on('switchChange.bootstrapSwitch', function (event, state) {
        if (state == true) {
            $(this).val('ДПМ');
            $(payerObj).prop('disabled', true);
            $(payerObj).val('ДПМ');
        } else {
            $(this).val($(payerObj).val());
            $(payerObj).prop('disabled', false);
            if ($(payerObj) == '') {
                $(payerObj).val($(this).val());
            }
        }
    });

    $(transporterNameObj).on('change', function () {
        var tnos = $('#transporterName option:selected').val();
        var nextElem = $(this).nextAll();
        if (tnos == 1) { //самовывоз

            for (var i = 0; i < nextElem.length; i++) {
                $(nextElem[i]).prop('disabled', true);
                $(nextElem[i]).hide();
            }
            $(this).show();
            $(this).select2();
            if ($('#stockID').val() == 110) {
                $('#city option:selected').val('49000'); //49000
            } else {
                $('#city option:selected').val('1000'); //1000
            }
            $('#specialNotesText').show();
            $(specialNotesObj).prop('disabled', false);
            $(specialNotesObj).show();
            $(sendApproved).show();
            $(sendApproved).prop('disabled', false);
        } else if ((tnos == 15) || (tnos == 10) || (tnos == 2) || (tnos == 3)) {
            //Эвроекспресс почта, ИТЛ-Групп, услуги ЧП (указать конкретно вместо ттн), Миколенко
            $(cityTextObj).show();
            $(cityObj).show();
            $(cityObj).select2({
                theme: "classic",
                ajax: {
                    url: "getCity",
                    dataType: 'json',
                    delay: 50,
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            page: params.page
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data.items
                        };
                    },
                    cache: true
                },
                escapeMarkup: function (markup) {
                    return markup;
                },
                minimumInputLength: 1,
                templateResult: formatRepo,
                templateSelection: formatRepoSelection
            });
            $(cityObj).on('change', function () {
                $('#originatorText').show();
                $(originatorObj).show();
                $(addresseeTextObj).show();
                if (($('#addresseeSel option').toArray().length != 0) && ($('#addresseeSel option').val() != '')) {
                    $(addresseeSelObj).show();
                    $(addresseeSelObj).select2({
                        theme: "classic"
                    });
                    $(addresseeSelObj).prop('disabled', false);
                    $(addresseeObj).prop('disabled', true);
                    $(addresseeObj).hide();
                } else {
                    $(addresseeObj).prop('disabled', false);
                    $(addresseeSelObj).prop('disabled', true);
                    $(addresseeObj).show();
                }
                $(payerTextObj).show();
                $(checkPayer).show();
                $(payerObj).show();
                $(checkPayer).bootstrapSwitch('state', false);
                $(payerObj).on('change', function () {
                    if ($(this).val() != '') {
                        $(checkPayer).attr('data-off-text', $(this).val());
                        $(checkPayer).attr('data-label-width', $(this).val().length + 20);
                        $(checkPayer).bootstrapSwitch('offText', $(this).val());
                        $(checkPayer).bootstrapSwitch('labelWidth', $(this).val().length + 20);
                        $(checkPayer).val($(this).val());
                    } else {
                        $(checkPayer).attr('data-off-text', 'OFF');
                        $(checkPayer).bootstrapSwitch('offText', 'OFF');
                    }
                });
                /*$(payerObj).show();
                 $(payerObj).select2({
                 theme: "classic"
                 });*/
                $(addressTextObj).show();
                //$(addressObj).show();
                if (($('#addressSel option').toArray().length != 0) && ($('#addressSel option').val() != '')) {
                    $(addressSelObj).show();
                    $(addressSelObj).select2({
                        theme: "classic"
                    });
                    $(addressObj).prop('disabled', true);
                } else {
                    $(addressSelObj).prop('disabled', true);
                    $(addressObj).show();
                    $(addressObj).on('click', function () {
                        $(stockTransporterObj).show();
                        $(stockTransporterTextObj).show();
                    });
                }
                $(stockTransporterObj).show();
                $(stockTransporterTextObj).show();
                $(specialNotesTextObj).show();
                $(specialNotesObj).prop('disabled', false);
                $(specialNotesObj).show();
                $(sendApproved).show();
                $(sendApproved).prop('disabled', false);
                $(getCashTextObj).show();
                $(getCashObj).show();
                $(getCashObj).select2();
            });
            /*$(payerObj).on('change', function() { //плательщик
             var optPay = $(payFormObj).children();
             if($('#payerObj option:selected').val() == 0) {
             $(payerObj).hide();
             $(payerObj).next('.select2').hide();
             $(payerTObj).show();
             }
             if($(this).val() == 2) {
             for(var i = 0; i < optPay.length; i++) {
             if($(optPay[i]).val() == 2) {
             $(optPay[i]).attr('selected', 'selected');
             $(payFormTextObj).show();
             $(payFormObj).select2({
             theme: "classic"
             });
             }
             }
             } else {
             $(getCashTextObj).show();
             $(getCashObj).show();
             $(getCashObj).select2();
             }
             });*/
        } else if (($(CodeID3).val() == 4) && (tnos == 5) || (tnos == 6) || (tnos == 7) || (tnos == 8)) {
            //Признак3 = 4, Ин-тайм, САТ, Деливери, Рабен Украина
            $(cityTextObj).show();
            $(cityObj).show();
            $(cityObj).select2({
                theme: "classic",
                ajax: {
                    url: "getCity",
                    dataType: 'json',
                    delay: 50,
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            page: params.page
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data.items
                        };
                    },
                    cache: true
                },
                escapeMarkup: function (markup) {
                    return markup;
                },
                minimumInputLength: 1,
                templateResult: formatRepo,
                templateSelection: formatRepoSelection
            });
            $(cityObj).on('change', function () {
                $('#originatorText').show();
                $(originatorObj).show();
                $(addresseeTextObj).show();
                if (($('#addresseeSel option').toArray().length != 0) && ($('#addresseeSel option').val() != '')) {
                    $(addresseeSelObj).show();
                    $(addresseeSelObj).select2({
                        theme: "classic"
                    });
                    $(addresseeSelObj).prop('disabled', false);
                    $(addresseeObj).prop('disabled', true);
                    $(addresseeObj).hide();
                } else {
                    $(addresseeObj).prop('disabled', false);
                    $(addresseeSelObj).prop('disabled', true);
                    $(addresseeObj).show();
                }
                $(payerTextObj).show();
                $(checkPayer).show();
                $(payerObj).show();
                $(checkPayer).bootstrapSwitch('state', false);
                $(payerObj).on('change', function () {
                    if ($(this).val() != '') {
                        $(checkPayer).attr('data-off-text', $(this).val());
                        $(checkPayer).attr('data-label-width', $(this).val().length + 20);
                        $(checkPayer).bootstrapSwitch('offText', $(this).val());
                        $(checkPayer).bootstrapSwitch('labelWidth', $(this).val().length + 20);
                        $(checkPayer).val($(this).val());
                    } else {
                        $(checkPayer).attr('data-off-text', 'OFF');
                        $(checkPayer).bootstrapSwitch('offText', 'OFF');
                    }
                });
                $(addressTextObj).show();
                //$(addressObj).show();
                if (($('#addressSel option').toArray().length != 0) && ($('#addressSel option').val() != '')) {
                    $(addressSelObj).show();
                    $(addressSelObj).select2({
                        theme: "classic"
                    });
                    $(addressObj).prop('disabled', true);
                } else {
                    $(addressSelObj).prop('disabled', true);
                    $(addressObj).show();
                    $(addressObj).on('click', function () {
                        $(stockTransporterObj).show();
                        $(stockTransporterTextObj).show();
                    });
                }
                $(stockTransporterObj).show();
                $(stockTransporterTextObj).show();
                $(specialNotesTextObj).show();
                $(specialNotesObj).prop('disabled', false);
                $(specialNotesObj).show();
                $(sendApproved).show();
                $(sendApproved).prop('disabled', false);
                $(getCashTextObj).show();
                $(getCashObj).show();
                $(getCashObj).select2();
            });
            /*$(payerObj).on('change', function() { //плательщик
             var optPay = $(payFormObj).children();
             if($('#payerObj option:selected').val() == 0) {
             $(payerObj).hide();
             $(payerObj).next('.select2').hide();
             $(payerTObj).show();
             }
             if($(this).val() == 2) {
             for(var i = 0; i < optPay.length; i++) {
             if($(optPay[i]).val() == 2) {
             $(optPay[i]).attr('selected', 'selected');
             $(payFormTextObj).show();
             $(payFormObj).select2({
             theme: "classic"
             });
             }
             }
             } else {
             $(getCashTextObj).show();
             $(getCashObj).show();
             $(getCashObj).select2();
             }
             });*/
        } else if ((tnos == 7) || (tnos == 5) || (tnos == 14) || (tnos == 4) || (tnos == 12) || (tnos == 6)) {
            //Деливери
            $(cityTextObj).show();
            $(cityObj).show();
            $(cityObj).select2({
                theme: "classic",
                ajax: {
                    url: "getCity",
                    dataType: 'json',
                    delay: 50,
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            page: params.page
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data.items
                        };
                    },
                    cache: true
                },
                escapeMarkup: function (markup) {
                    return markup;
                },
                minimumInputLength: 1,
                templateResult: formatRepo,
                templateSelection: formatRepoSelection
            });
            $(cityObj).on('change', function () {
                $('#originatorText').show();
                $(originatorObj).show();
                $(addresseeTextObj).show();
                if (($('#addresseeSel option').toArray().length != 0) && ($('#addresseeSel option').val() != '')) {
                    $(addresseeSelObj).show();
                    $(addresseeSelObj).select2({
                        theme: "classic"
                    });
                    $(addresseeSelObj).prop('disabled', false);
                    $(addresseeObj).prop('disabled', true);
                    $(addresseeObj).hide();
                } else {
                    $(addresseeObj).prop('disabled', false);
                    $(addresseeSelObj).prop('disabled', true);
                    $(addresseeObj).show();
                }
                $(payerTextObj).show();
                $(checkPayer).show();
                $(payerObj).show();
                $(checkPayer).bootstrapSwitch('state', false);
                $(payerObj).on('change', function () {
                    if ($(this).val() != '') {
                        $(checkPayer).attr('data-off-text', $(this).val());
                        $(checkPayer).attr('data-label-width', $(this).val().length + 20);
                        $(checkPayer).bootstrapSwitch('offText', $(this).val());
                        $(checkPayer).bootstrapSwitch('labelWidth', $(this).val().length + 20);
                        $(checkPayer).val($(this).val());
                    } else {
                        $(checkPayer).attr('data-off-text', 'OFF');
                        $(checkPayer).bootstrapSwitch('offText', 'OFF');
                    }
                });

                $(addressTextObj).show();
                //$(addressObj).show();
                if (($('#addressSel option').toArray().length != 0) && ($('#addressSel option').val() != '')) {
                    $(addressSelObj).show();
                    $(addressSelObj).select2({
                        theme: "classic"
                    });
                    $(addressObj).prop('disabled', true);
                } else {
                    $(addressSelObj).prop('disabled', true);
                    $(addressObj).show();
                }
                $(stockTransporterObj).show();
                $(stockTransporterTextObj).show();
                $(specialNotesTextObj).show();
                $(specialNotesObj).prop('disabled', false);
                $(specialNotesObj).show();
                $(sendApproved).show();
                $(sendApproved).prop('disabled', false);
                $(getCashTextObj).show();
                $(getCashObj).show();
                $(getCashObj).select2();
            });
            /*$(payerObj).on('change', function() { //плательщик
             var optPay = $(payFormObj).children();
             if($('#payerObj option:selected').val() == 0) {
             $(payerObj).hide();
             $(payerObj).next('.select2').hide();
             $(payerTObj).show();
             }
             if($(this).val() == 2) {
             for(var i = 0; i < optPay.length; i++) {
             if($(optPay[i]).val() == 2) {
             $(optPay[i]).attr('selected', 'selected');
             $(payFormTextObj).show();
             $(payFormObj).select2({
             theme: "classic"
             });
             }
             }
             } else {
             $(getCashTextObj).show();
             $(getCashObj).show();
             $(getCashObj).select2();
             }
             });*/
        } else if ((tnos == 11) || (tnos == 8) || (tnos == 13)) {
            //Водитель ТК Алиста
            $(cityTextObj).show();
            $(cityObj).show();
            $(cityObj).select2({
                theme: "classic",
                ajax: {
                    url: "getCity",
                    dataType: 'json',
                    delay: 50,
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            page: params.page
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data.items
                        };
                    },
                    cache: true
                },
                escapeMarkup: function (markup) {
                    return markup;
                },
                minimumInputLength: 1,
                templateResult: formatRepo,
                templateSelection: formatRepoSelection
            });
            $(cityObj).on('change', function () {
                $('#originatorText').show();
                $(originatorObj).show();
                $(addresseeTextObj).show();
                if (($('#addresseeSel option').toArray().length != 0) && ($('#addresseeSel option').val() != '')) {
                    $(addresseeSelObj).show();
                    $(addresseeSelObj).select2({
                        theme: "classic"
                    });
                    $(addresseeSelObj).prop('disabled', false);
                    $(addresseeObj).prop('disabled', true);
                    $(addresseeObj).hide();
                } else {
                    $(addresseeObj).prop('disabled', false);
                    $(addresseeSelObj).prop('disabled', true);
                    $(addresseeObj).show();
                }
                $(payerTextObj).show();
                $(checkPayer).show();
                $(payerObj).show();
                $(checkPayer).bootstrapSwitch('state', false);
                $(payerObj).on('change', function () {
                    if ($(this).val() != '') {
                        $(checkPayer).attr('data-off-text', $(this).val());
                        $(checkPayer).attr('data-label-width', $(this).val().length + 20);
                        $(checkPayer).bootstrapSwitch('offText', $(this).val());
                        $(checkPayer).bootstrapSwitch('labelWidth', $(this).val().length + 20);
                        $(checkPayer).val($(this).val());
                    } else {
                        $(checkPayer).attr('data-off-text', 'OFF');
                        $(checkPayer).bootstrapSwitch('offText', 'OFF');
                    }
                });
                $(addressTextObj).show();
                if (($('#addressSel option').toArray().length != 0) && ($('#addressSel option').val() != '')) {
                    $(addressSelObj).show();
                    $(addressSelObj).select2({
                        theme: "classic"
                    });
                    $(addressObj).prop('disabled', true);
                } else {
                    $(addressSelObj).prop('disabled', true);
                    $(addressObj).show();
                    $(addressObj).on('click', function () {
                        $(stockTransporterObj).show();
                        $(stockTransporterTextObj).show();
                    });
                }
                $(specialNotesTextObj).show();
                $(specialNotesObj).prop('disabled', false);
                $(specialNotesObj).show();
                $(sendApproved).show();
                $(sendApproved).prop('disabled', false);
                $(getCashTextObj).show();
                $(getCashObj).show();
                $(getCashObj).select2();
            });
            /*$(payerObj).on('change', function() { //плательщик
             var optPay = $(payFormObj).children();
             if($('#payerObj option:selected').val() == 0) {
             $(payerObj).hide();
             $(payerObj).next('.select2').hide();
             $(payerTObj).show();
             }
             if($(this).val() == 2) {
             for(var i = 0; i < optPay.length; i++) {
             if($(optPay[i]).val() == 2) {
             $(optPay[i]).attr('selected', 'selected');
             $(payFormTextObj).show();
             $(payFormObj).select2({
             theme: "classic"
             });
             }
             }
             } else {
             $(getCashTextObj).show();
             $(getCashObj).show();
             $(getCashObj).select2();
             }
             });*/
        } else {
            for (var i = 0; i < nextElem.length; i++) {
                $(nextElem[i]).prop('disabled', true);
                $(nextElem[i]).hide();
            }
            $(this).show();
            $(this).select2();
        }
    });
});