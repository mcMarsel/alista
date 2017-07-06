$(document).ready(function () {
    $('#pgr3').footable();

    $('#user').footable();

    $('#saveKurs').on('click', function () {
        var cash = $('#cash').val();
        var uncash = $('#uncash').val();
        $.ajax({
            url: 'saveKurs',
            method: 'POST',
            data: {
                cash: cash,
                uncash: uncash
            }, success: function (responce) {
                //console.log(responce);
                if (Number(responce.status) == 1) {
                    $('#saveKurs').addClass('btn-success');
                    $('#saveKurs').removeClass('btn-primary');
                } else {
                    $('#saveKurs').addClass('btn-success');
                    $('#saveKurs').removeClass('btn-primary');
                }
            }
        });
    });

    $('.edit').on('click', function () {
        var id = $(this).attr('id');
        //console.log($(this).attr('id'));
        $.ajax({
            url: "modalEdit",
            method: "POST",
            data: {
                id: id
            }, success: function (responce) {
                var emp = $.parseJSON(responce.emp);
                var user = $.parseJSON(responce.user);
                $('#EmpName').val(emp.EmpName);
                $('#username').val(user.username);
                $('#EmpID').val(emp.EmpID);
                $('#UAEmpName').val(emp.UAEmpName);
                $('#DepID').val(emp.DepID);
                var selHead = $('#heads').children();
                for (var i = 0; i < selHead.length; i++) {
                    if ($(selHead[i]).val() == emp.HeadID) {
                        $(selHead[i]).attr('selected', 'selected');
                    }
                }
                //$('#HeadID').val(emp.HeadID);
                $('#PLID').val(emp.PLID);
                $('#EMail').val(emp.EMail);
                $('#EmpGrID').val(emp.EmpGrID);
                $('#id').text(id);
                $('#editModal').modal();
            }
        });
    });

    $('#modal-done').on('click', function () {
        var obj = {};
        obj.EmpID = $('#EmpID').val();
        obj.id = $('#id').text();
        obj.username = $('#username').val();
        obj.EmpName = $('#EmpName').val();
        obj.UAEmpName = $('#UAEmpName').val();
        obj.HeadID = $('#heads option:selected').val();
        obj.PLID = $('#PLID').val();
        obj.EMail = $('#EMail').val();
        obj.password = $('#password').val();
        $.ajax({
            url: 'saveProfile',
            method: 'POST',
            data: {
                obj: obj
            }, success: function (responce) {
                if (responce.status == 1) {
                    $('#editModal').modal("hide");
                    $('#EmpName').val('');
                    $('#username').val('');
                    $('#EmpID').val('');
                    $('#UAEmpName').val('');
                    //$('#HeadID').val('');
                    $('#PLID').val('');
                    $('#EMail').val('');
                    $('#id').text('');
                    $('#password').val('');
                }
            }
        });
    });

    $('#spw').on('click', function () {
        var password = $('#password').val();
        var id = $(this).attr('id');
        $.ajax({
            url: 'spw',
            method: 'POST',
            data: {
                password: password,
                id: id
            }, success: function (responce) {
                if (responce.status == 1) {
                    $('#spw').addClass('btn-success');
                    $('#spw').removeClass('btn-primary');
                }
            }
        });
    });

    $('#addUser').on('click', function () {
        $('#EmpName').val('');
        $('#username').hide();
        $('#usernameLabel').hide();
        $('#idLabel').hide();
        $('#id').hide();
        $('#EmpID').val('');
        $('#UAEmpName').val('');
        //$('#HeadID').val('');
        $('#PLID').val('');
        $('#EMail').val('');
        $('#id').text('');
        $('#password').val('');
        $('#modal-title').text('Создание нового пользователя и служащего');
        $('#modal-done').attr('id', 'new_user');
        $('#editModal').modal();
        $('#new_user').on('click', function () {
            var obj = {};
            obj.EmpID = $('#EmpID').val();
            obj.EmpName = $('#EmpName').val();
            obj.UAEmpName = $('#UAEmpName').val();
            obj.HeadID = $('#heads option:selected').val();
            obj.PLID = $('#PLID').val();
            obj.EMail = $('#EMail').val();
            obj.password = $('#password').val();
            $.ajax({
                url: 'new_user',
                method: 'POST',
                data: {
                    obj: obj
                }, success: function (responce) {
                    if (responce.status == 1) {
                        $('#editModal').modal("hide");
                        $('#EmpName').val('');
                        $('#username').val('');
                        $('#EmpID').val('');
                        $('#UAEmpName').val('');
                        //$('#HeadID').val('');
                        $('#PLID').val('');
                        $('#EMail').val('');
                        $('#id').text('');
                        $('#password').val('');
                    }
                }
            });
        });
    });

    $('#close').on('click', function () {
        $('#EmpName').val('');
        $('#username').val('');
        $('#EmpID').val('');
        $('#UAEmpName').val('');
        $('#DepID').val('');
        //$('#HeadID').val('');
        $('#PLID').val('');
        $('#EMail').val('');
        $('#EmpGrID').val('');
        $('#id').text('');
        $('#password').val('');
        $('#editModal').modal('hide');
    });

    $('.del_user').on('click', function () {
        var id = $(this).attr('id');
        $.ajax({
            url: 'rmUser',
            method: 'POST',
            data: {
                id: id
            }, success: function (responce) {
                if (responce.status == 1) {
                    $(this).parent().parent().hide();
                }
            }
        });
    });

    $('.hideGr3').on('click', function () {
        var id = $(this).prop('id');
        $.ajax({
            url: 'hidegr3',
            method: 'POST',
            data: {
                id: id
            }, success: function (responce) {
                if (responce == 1) {
                    $(this).prop('disabled', 'true');
                    $(this).removeClass(['btn-primary']);
                    $(this).addClass(['btn-success']);
                }
            }
        });
    });

    $('.showGr3').on('click', function () {
        var id = $(this).prop('id');
        $.ajax({
            url: 'showgr3',
            method: 'POST',
            data: {
                id: id
            }, success: function (responce) {
                if (responce == 1) {
                    $(this).prop('disabled', 'true');
                    $(this).removeClass(['btn-primary']);
                    $(this).addClass(['btn-success']);
                }
            }
        });
    });

    $('.degrade').on('click', function () {
        var id = $(this).prop('id');
        var status = $(this).prop('status');
        $.ajax({
            url: 'upstatus',
            method: 'POST',
            data: {
                id: id,
                status: status
            }, success: function (responce) {
                if (responce == 1) {
                    $(this).prop('disabled', 'true');
                    $(this).removeClass(['btn-primary']);
                    $(this).addClass(['btn-success']);
                }
            }
        });
    });

    $('.increase').on('click', function () {
        var id = $(this).prop('id');
        var status = $(this).prop('status');
        $.ajax({
            url: 'upstatus',
            method: 'POST',
            data: {
                id: id,
                status: status
            }, success: function (responce) {
                if (responce == 1) {
                    $(this).prop('disabled', 'true');
                    $(this).removeClass(['btn-primary']);
                    $(this).addClass(['btn-success']);
                }
            }
        });
    });

    $('.degrade_head').on('click', function () {
        var id = $(this).attr('id');
        $.ajax({
            url: 'degrade_head',
            method: 'POST',
            data: {
                id: id
            }, success: function (responce) {
                if (responce.status == 1) {
                    $(this).parent().parent().hide();
                }
            }
        });
    });

    $('#addHead').on('click', function () {
        var selEmp = $('#selHead option:selected').val();
        $.ajax({
            url: 'addHead',
            method: 'POST',
            data: {
                selEmp: selEmp
            }, success: function (responce) {
                if (responce.status == 1) {
                    var sel = $('#selHead').children();
                    for (var i = 0; i < sel.length; i++) {
                        if ($(sel[i]).val() == selEmp) {
                            $(sel[i]).hide();
                        }
                    }
                }
            }
        });
    });


});
