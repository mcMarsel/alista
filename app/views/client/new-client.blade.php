@extends('master')

@section('content')
<script src="{{ url('public/packages/manager/client.js') }}" type="text/javascript"></script>
{{ Form::open(['route'=>'new-client', 'method' => 'post', 'enctype' => 'multipart/form-data']) }}
	{{ Form::text('clientName', '', ['id' => 'clientName', 'class' => 'form-control', 'placeholder' => 'Введите название предприятия', 'autocapitalize' => 'on']) }}
	<br/>
	{{ Form::label('', 'Город ', ['id' => 'cityText']) }}
	<select id="city" name="city" class="btn form-control" style="align-content: center;">
        <option value="0" selected="selected">Введите название......</option>
    </select>
    <br/>
	Контактное лицо
	{{ Form::text('fullName', '', ['id' => 'fullName', 'class' => 'form-control', 'placeholder' => 'Ф И О', 'autocapitalize' => 'on']) }}	
	<br/>
	Время работы
	<br/>
	Начало рабочего дня:  {{ Form::text('BTime', '', ['id' => 'BTime']) }} ,
	<br/>конец рабочего дня:  {{ Form::text('ETime', '', ['id' => 'ETime']) }}
	<br/>
	{{ Form::text('email', '', ['id' => 'email', 'class' => 'form-control', 'placeholder' => 'Контактный email', 'autocapitalize' => 'off']) }}
	<br/>
	{{ Form::text('address', '', ['id' => 'address', 'class' => 'form-control', 'placeholder' => 'Введите адрес предприятия', 'autocapitalize' => 'off']) }}
    <br/>
	{{ Form::text('phone', '', ['id' => 'phone', 'type' => 'tel', 'class' => 'form-control', 'placeholder' => 'Введите телефон в формате 0xx-xxx-xx-xx, где вместо x должна быть цифра (без дефисов):', 'pattern' => '0[0-9]{2}[0-9]{3}[0-9]{2}[0-9]{2}']) }}
	<br/>
	{{ Form::submit('Отправить',['id' => 'send','class' => 'form-control  btn btn-primary btn-lg', 'style' => 'width: 100%; display: inline-block', 'style' => 'height: 10%;', 'disabled' => 'true']) }}
{{ Form::close() }}	
<br/>
<br/>
<br/>
	
@stop