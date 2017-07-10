@extends('master')

@section('content')

    {{ Form::label('orderID', 'Счет №'.$orderID) }}<br/>
    {{ Form::label('compName', 'Имя предприятия: '.$compName) }}
    <br/>
    {{ Form::open(['route' => 'send-order', 'method' => 'post', 'enctype' => 'multipart/form-data']) }}
    <input type="text" hidden="hidden" name="orderID" value="{{ $orderID }}">
    <input type="text" hidden="hidden" name="filename" value="{{ $filename }}">
    @if($emailComp)
        <h1>
        {{ Form::text('email', $emailComp, ['class' => 'form-control']) }}
        </h1>
        <br/>
    @else
        <h1>У данного предприятия нет email адреса</h1>
        <br/>
        {{ Form::text('email', '', ['class' => 'form-control', 'placeholder' => 'Введите email']) }}
    @endif
    <br/>
    {{ Form::submit('Отправить клиенту', ['class' => 'form-control btn-primary']) }}
    {{ Form::close() }}
    <br/>
    <h1>Или можно отправить себе на email</h1>
    <br/>
    {{ Form::open(['route' => 'send-order-to-emp', 'method' => 'post', 'enctype' => 'multipart/form-data']) }}
    <input type="text" hidden="hidden" name="filename" value="{{ $filename }}">
    <input type="text" hidden="hidden" name="orderID" value="{{ $orderID }}">
    <input type="text" hidden="hidden" name="email" value="{{ Auth::user()->email }}">
    {{ Form::submit('Отправить себе', ['class' => 'form-control btn-primary']) }}
    {{ Form::close() }}

@stop