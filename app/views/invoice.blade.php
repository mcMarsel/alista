@extends('master')

@section('content')

    {{--{{ Form::open(['route' => 'send_price', 'method' => 'post', 'enctype' => 'multipart/form-data']) }}

    {{ Form::file('price', ['method' => 'post', 'enctype' => 'multipart/form-data']) }}
    {{ Form::submit('Отправить',['class' => 'btn btn-primary', 'style' => 'display: inline-block']) }}

    {{ Form::close() }}--}}


    {{ Form::open(['route' => 'email', 'method' => 'post', 'enctype' => 'multipart/form-data']) }}
    {{ Form::submit('Отправить',['class' => 'btn btn-primary', 'style' => 'display: inline-block']) }}

    <table class="">
        <tr>
            <td rowspan="2"><h3>Рахунок</h3></td>
            <td class="td-test">Номер:</td>
            <td colspan="2">19170</td>
        </tr>
        <tr>
            <td>Дата:</td>
            <td colspan="2">15.12.2015</td>
        </tr>
        <tr>
            <td>ТОВАРИСТВО З ОБМЕЖЕНОЮ ВІДПОВІДАЛЬНІСТЮ "ТОРГОВА КОМПАНІЯ "АЛИСТА"</td>
        </tr>
        <tr>
            <td>Підприємство:</td>
            <td> ТОВАРИСТВО З ОБМЕЖЕНОЮ ВІДПОВІДАЛЬНІСТЮ "КАПЕКС"</td>
            <td colspan="2"> 16282<br>72<br>1<br>102</td>
        </tr>
        <tr>
            <td>Адреса:</td>
            <td colspan="3"> вул. Космонавта Комарова, буд. 10</td>
        </tr>
        <tr>
            <td>Місто:</td>
            <td colspan="3"> м. Одеса  65043</td>
        </tr>
    </table>
    <table class="">
        <tr>
            <td class="td-t1">Телефон:</td>
            <td class="td-t1"></td>
            <td class="td-t1">Факс:</td>
            <td class="td-t1"></td>
        </tr>
    </table>
    <br/>
    <table class="table table-hover table-bordered table-striped">
        <thead>
            <tr>
                <th>Код</th>
                <th>Назва товарів, (робіт, послуг)</th>
                <th>Од.Вим.</th>
                <th>Кількість</th>
                <th>Ціна без ПДВ</th>
                <th>Сума без ПДВ</th>
                <th>Ціна з ПДВ</th>
                <th>Сума з ПДВ</th>
            </tr>
        </thead>
        <tbody>
            @foreach($res as $key => $value)
                <tr>
                    <td>{{ $value[0] }}</td>
                    <td>{{ $value[1] }}</td>
                    <td></td>
                    <td>{{ $value[2] }}</td>
                    <td>{{ $value[3] * $currency }}</td>
                    <td>{{ $value[3] * $currency * $value[2] }}</td>
                    <td>{{ $value[3] * $currency * 1.12 }}</td>
                    <td>{{ $value[3] * $currency * 1.12 * $value[2] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <table class="table table-hover table-bordered table-striped">
        <tr>
            <td>Кількість: </td>
            <td>Сума без НДС: </td>
        </tr>
        <tr>
            <td>Загальна вага: </td>
            <td>Сума НДС: </td>
        </tr>
        <tr>
            <td>Сума з ПДВ:</td>
            <td>десять тисяч шiстсот тридцять одна гривня 4 коп.</td>
            <td>10 631,04</td>
        </tr>
    </table>

    {{ Form::close() }}
	<style>
		td.td-test{
			width:20px;
		}
		td.td-t1{
			width:100px;
		}
	</style>
@stop()