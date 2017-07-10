@extends('master')

@section('content')

    <table class="table responsive table-hover">
        <thead>
            <tr>
                <th>№ счета</th>
                <th>№ заявки</th>
                <th>Дата заявки</th>
                <th>Имя предприятия</th>
                <th>Склад</th>
                <th>Сумма грн</th>
                <th>Сумма $</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($approvedOnce as $key => $value)
            <tr>
                <td>{{ $value['DocID'] }}</td>
                <td>{{ $value['AppID'] }}</td>
                <td>{{ $value['created_at'] }}</td>
                <td>{{ $value['CompName'] }}</td>
                <td>{{ $value['StockID'] }}</td>
                {{--<td>{{ round($value['Kurs'], 2) }}</td>--}}
                {{--<td>{{ round(($value['totalPriceMC']/$value['Kurs']), 2) }}</td>--}}
                <td></td>
            </tr>
            @endforeach
        </tbody>
    </table>

@stop