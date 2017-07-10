@extends('master')

@section('content')
    <script src="{{ url('public/packages/manager/debit.js') }}" type="text/javascript"></script>
    <h1>Дебиторка</h1>
    <br/>
    <br/>
    <div id="debit"></div>
    <table class="table" id="table-debit">
        {{--<thead>
            <tr>
                <th>Имя предприятия</th>
                <th>Имя служащего</th>
                <th data-breakpoints="xs" data-type="number">ИД РД</th>
                <th data-breakpoints="xs sm md" data-type="date">Дата РД</th>
                <th data-breakpoints="xs">Сумма РД, грн</th>
                <th data-breakpoints="xs">Сумма РД, $</th>
                <th data-breakpoints="xs">Сумма задолженности, грн</th>
                <th data-breakpoints="xs">Сумма задолженности, $</th>

            </tr>
        </thead>
        <tbody>
            @foreach($Receivables as $key => $value)
            <tr>
                <td name="{{ $value->CompID }}">{{ $value->CompName }}</td>
                <td name="{{ $value->EmpID }}">{{ $value->EmpName }}</td>
                <td>{{ str_replace(' 00:00:00', '', $value->DocDate) }}</td>
                <td>{{ $value->DocDate }}</td>
                <td>{{ round($value->TSumCC, 2)}}</td>
                <td>{{ round($value->TSumMC, 2) }}</td>
                <td>{{ round($value->ArrearsCC, 2) }}</td>
                <td>{{ round($value->ArrearsMC, 2) }}</td>
            </tr>
            @endforeach
        </tbody>--}}
    </table>
    

@stop