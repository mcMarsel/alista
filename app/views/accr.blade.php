@extends('master')
@section('content')
    <link href="{{ url('public/packages/mytable.css') }}" rel="stylesheet">
    <script src="{{ url('public/packages/manager/accr.js') }}" type="text/javascript"></script>
    <div>
        <table id="accr-list" class="table table-hover table-responsive" data-sorting="true" data-filtering="true"
               data-paging="true">
            <thead>
            <tr>
                <th data-breakpoints="">№ счета</th>
                <th data-breakpoints="">Форма оплаты</th>
                <th data-breakpoints="">Склад</th>
                <th data-breakpoints="">Предприятие</th>
                <th data-breakpoints="">Сумма грн</th>
                <th data-breakpoints="">Сумма $</th>
                <th>Курс</th>
                <th>Дата</th>
                <th>Служащий</th>
                <th>Статус</th>
            </tr>
            </thead>
            <tbody>
            @foreach($ordersObj as $key => $value)
                <tr bgcolor="{{ $value['color'] }}" class="order" link="view-order" onclick="load(this)">
                    <td class="orderID" name="{{ $value['orderID'] }}">{{ $value['DocID'] }}</td>
                    <td class="CodeID3">{{ $value['CodeID3'] }}</td>
                    <td class="StockID">{{ $value['StockID'] }}</td>
                    <td class="CompName">{{ $value['CompName'] }}</td>
                    <td class="totalPriceCC">{{ ceil(($value['totalPriceCC'] / 6) * 100) / 100 * 6 }} </td>
                    <td class="totalPriceMC">{{ ceil(($value['totalPriceMC'] / 6) * 100) / 100 * 6 }}</td>
                    <td class="Kurs">{{ round($value['Kurs'], 2) }}</td>
                    <td class="created_at">{{ $value['created_at'] }}</td>
                    <td class="EmpName">{{ $value['EmpName'] }}</td>
                    <td class="statusName" name="{{ $value['statusType'] }}">{{ $value['statusName'] }}</td>
                </tr>
            @endforeach
            </tbody>

        </table>
    </div>
    <div id="myModal" class="modal fade" role="dialog" hidden="hidden">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    {{ Form::label('name', '', ['id' => 'status', 'hidden' => 'hidden']) }}
                    <button type="button" onclick="close()" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Выберите действие</h4>
                    <div hidden="hidden" id='modal-id'></div>
                </div>
                <div class="modal-body">
                    </br>
                    </br>
                    {{ Form::open(['route'=>'view-order', 'method' => 'post']) }}
                    {{ Form::text('orderID', '', ['hidden' => 'hidden', 'id' => 'view-orderID']) }}
                    {{ Form::submit('Отправить счет на email',['id' => 'sendClient','class' => 'form-control  btn btn-primary btn-lg', 'style' => 'width: 100%; display: inline-block', 'style' => 'height: 10%;']) }}
                    {{ Form::close() }}
                    </br>
                    </br>
                    {{ Form::open(['route'=>'edit-order', 'method' => 'post']) }}
                    {{ Form::text('orderID', '', ['hidden' => 'hidden', 'id' => 'edit-orderID']) }}
                    {{ Form::submit('Редактировать',['id' => 'send','class' => 'form-control  btn btn-primary btn-lg', 'style' => 'width: 100%; display: inline-block; height: 10%;']) }}
                    {{ Form::close() }}
                    </br>
                    </br>
                    {{ Form::open(['route'=>'approved-order', 'method' => 'post']) }}
                    {{ Form::text('orderID', '', ['hidden' => 'hidden', 'id' => 'approved-orderID']) }}
                    {{ Form::text('compID', '', ['hidden' => 'hidden', 'id' => 'compID']) }}
                    {{ Form::submit('Заявка на отбор',['id' => 'sendApproved',
                    'class' => 'form-control  btn btn-primary btn-lg', 'disabled' => 'true', 'style' => 'width: 100%; display: inline-block; height: 10%;']) }}
                    {{ Form::close() }}
                    </br>
                    </br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal" id="modal-done">Готово</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function load(e) {
            var id = $(e).children('.orderID').text();
            if (!id) {
                id = $(e).children().attr('name');
            }
            var status = $(e).children('.statusName').attr('name');
            if ((status == 2) || (status == 4) || (status == 5)) {
                $('#send').prop('disabled', true);
            } else if (status == 0) {
                //$('#sendApproved').prop('disabled', true);
                $('#send').prop('disabled', false);
            } else {
                //$('#sendApproved').prop('disabled', false);
                $('#send').prop('disabled', false);
            }
            $.ajax({
                url: 'getCompID',
                method: 'POST',
                data: {
                    id: id
                }, success: function (responce) {
                    $('#compID').attr('value', responce);
                }
            });
            $('#status').attr('for', status);
            $('#edit-orderID').attr('value', id);
            $('#view-orderID').attr('value', id);
            $('#approved-orderID').attr('value', id);
            $('#myModal').modal();
        }
    </script>
@stop