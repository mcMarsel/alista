@extends('master')

@section('content')
	<style>
		td#int-test{
			color: red;
		}
		td.td-t1{
			width: 200px;
		}
		h#hw{
			color: red;
		}
		td.t2{
			width: 50px;
		}
	
	</style>
    {{--{{ Form::open(['route' => 'send_price', 'method' => 'post', 'enctype' => 'multipart/form-data']) }}

    {{ Form::file('price', ['method' => 'post', 'enctype' => 'multipart/form-data']) }}
    {{ Form::submit('Отправить',['class' => 'btn btn-primary', 'style' => 'display: inline-block']) }}

    {{ Form::close() }}--}}


    {{ Form::open(['route' => 'email', 'method' => 'post', 'enctype' => 'multipart/form-data']) }}
    {{ Form::submit('Отправить',['class' => 'btn btn-primary', 'style' => 'display: inline-block']) }}

    <table class="">
        <tr>
            <td id="inv-text" rowspan="2"><h3 id="hw">Рахунок</h3></td>
            <td class="t2">Номер:</td>
            <td class="t2" colspan="2">19170</td>
        </tr>
        <tr>
            <td class="t2">Дата:</td>
            <td class="t2" colspan="2">15.12.2015</td>
        </tr>
        <tr>
            <td>ТОВАРИСТВО З ОБМЕЖЕНОЮ ВІДПОВІДАЛЬНІСТЮ "ТОРГОВА КОМПАНІЯ "АЛИСТА""</td>
            <td colspan="3">р/с 26002000032507</td>
        </tr>
        <tr>
            <td>49083, м. Дніпропетровськ</td>
            <td colspan="3">Акціонерний банк "Південний" м. Одеса</td>
        </tr>
        <tr>
            <td>вул. Собінова, буд. 1</td>
            <td colspan="3">МФО 328209</td>
        </tr>
        <tr>
            <td>Податковий код: 372595704614, Свідоцтво: 100324872</td>
            <td colspan="3">ОКПО 37259577</td>
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
	<style>
		td#int-test{
			color: red;
		}
		td.td-t1{
			width: 200px;
		}
		h#hw{
			color: red;
		}
	
	</style>
    {{ Form::close() }}

@stop()