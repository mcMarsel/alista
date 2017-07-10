@extends('master')

@section('content')

    <table id="list" class="responsive table-hover table-striped" data-sorting="true" data-paging="true" data-filtering="true">
        <thead>
            <tr>
                <th data-breakpoints="xs">Статус</th>
                <th data-breakpoints="xs">№ счета</th>
                <th data-breakpoints="xs">№ заявки</th>
                <th data-breakpoints="xs">Дата отправки</th>
                <th data-breakpoints="xs">Дата заявки</th>
                <th data-breakpoints="xs">Имя предприятия</th>
                <th data-breakpoints="xs">Склад</th>
                <th data-breakpoints="xs">Сумма грн</th>
                <th data-breakpoints="xs">Сумма $</th>
                <th data-type="html">Действие</th>
            </tr>
        </thead>
        <tbody>
            @foreach($approvedOnce as $key => $value)
            <tr>
                <td>{{ $value['statusName'] }}</td>
                <td>{{ $value['DocID'] }}</td>
                <td>{{ $value['AppID'] }}</td>
                <td>{{ $value['dateShipping'] }}</td>
                <td>{{ $value['created_at'] }}</td>
                <td>{{ $value['CompName'] }}</td>
                <td>{{ $value['StockID'] }}</td>
                <td>{{ $value['totalPriceMC'] }}</td>
                <td>{{ round(($value['totalPriceMC']/$value['Kurs']), 2) }}</td>
                @if($value['status'] == 3)
                <td>
                    <form method="POST" action="/approved-pdf">
                        <input type="text" name="appID" value="{{ $value['AppID'] }}" style ="display: none;">
                        <input type="submit" class="btn btn-primary" name="Отправить на email" value="Отправить на email">
                    </form>
                </td>
                @else
                <td>
                    <form method="POST" action="/approved-pdf">
                        <input type="text" name="appID" value="{{ $value['AppID'] }}" style ="display: none;">
                        <input type="submit" disabled class="btn btn-primary" name="Отправить на email" value="Отправить на email">
                    </form>
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
    <script src="{{ url('public/packages/approved-list.js') }}" type="text/javascript"></script>
@stop