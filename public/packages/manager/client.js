$(document).ready(function () {
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

    var fullNameObj = $('#fullName');
    var ETimeObj = $('#ETime');
    var BTimeObj = $('#BTime');
    var cityObj = $('#city');
    var clientNameObj = $('#clientName');
    var emailObj = $('#email');
    var phoneObj = $('#phone');
    var addressObj = $('#address');

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


    $(ETimeObj).timepicker({
        minuteStep: 1,
        showMeridian: false
    });

    $(BTimeObj).timepicker({
        minuteStep: 1,
        showMeridian: false
    });

    $(addressObj).on('change', function () {
        if (
            $(this).val() != '' &&
            $(clientNameObj).val() != '' &&
            $(cityObj).val() != '' &&
            $(fullNameObj).val() != '' &&
            $(BTimeObj).val() != '' &&
            $(ETimeObj).val() != '' &&
            $(phoneObj).val() != ''
        ) {
            $('#send').prop('disabled', false);
        } else {
            $('#send').prop('disabled', true);
        }
    });

    $(clientNameObj).on('change', function () {
        if (
            $(this).val() != '' &&
            $(addressObj).val() != '' &&
            $(cityObj).val() != '' &&
            $(fullNameObj).val() != '' &&
            $(BTimeObj).val() != '' &&
            $(ETimeObj).val() != '' &&
            $(phoneObj).val() != ''
        ) {
            $('#send').prop('disabled', false);
        } else {
            $('#send').prop('disabled', true);
        }
    });

    $(cityObj).on('change', function () {
        if (
            $(clientNameObj).val() != '' &&
            $(addressObj).val() != '' &&
            $(this).val() != '' &&
            $(fullNameObj).val() != '' &&
            $(BTimeObj).val() != '' &&
            $(ETimeObj).val() != '' &&
            $(phoneObj).val() != ''
        ) {
            $('#send').prop('disabled', false);
        } else {
            $('#send').prop('disabled', true);
        }
    });

    $(fullNameObj).on('change', function () {
        if (
            $(clientNameObj).val() != '' &&
            $(addressObj).val() != '' &&
            $(cityObj).val() != '' &&
            $(this).val() != '' &&
            $(BTimeObj).val() != '' &&
            $(ETimeObj).val() != '' &&
            $(phoneObj).val() != ''
        ) {
            $('#send').prop('disabled', false);
        } else {
            $('#send').prop('disabled', true);
        }
    });

    $(BTimeObj).on('change', function () {
        if (
            $(clientNameObj).val() != '' &&
            $(addressObj).val() != '' &&
            $(cityObj).val() != '' &&
            $(fullNameObj).val() != '' &&
            $(this).val() != '' &&
            $(ETimeObj).val() != '' &&
            $(phoneObj).val() != ''
        ) {
            $('#send').prop('disabled', false);
        } else {
            $('#send').prop('disabled', true);
        }
    });
    $(ETimeObj).on('change', function () {
        if (
            $(clientNameObj).val() != '' &&
            $(addressObj).val() != '' &&
            $(cityObj).val() != '' &&
            $(fullNameObj).val() != '' &&
            $(BTimeObj).val() != '' &&
            $(this).val() != '' &&
            $(phoneObj).val() != ''
        ) {
            $('#send').prop('disabled', false);
        } else {
            $('#send').prop('disabled', true);
        }
    });

    /*$(emailObj).on('change', function(){
     if(
     $(clientNameObj).val() != '' &&
     $(addressObj).val() != '' &&
     $(cityObj).val() != '' &&
     $(fullNameObj).val() != '' &&
     $(this).val() != '' &&
     $(BTimeObj).val() != '' &&
     $(ETimeObj).val() != '' &&
     $(phoneObj).val() != ''
     ){
     $('#send').prop('disabled', false);
     } else {
     $('#send').prop('disabled', true);
     }
     });*/

    $(phoneObj).on('change', function () {
        if (
            $(clientNameObj).val() != '' &&
            $(addressObj).val() != '' &&
            $(cityObj).val() != '' &&
            $(fullNameObj).val() != '' &&
            $(this).val() != '' &&
            $(BTimeObj).val() != '' &&
            $(ETimeObj).val() != ''
        ) {
            $('#send').prop('disabled', false);
        } else {
            $('#send').prop('disabled', true);
        }
    });

});