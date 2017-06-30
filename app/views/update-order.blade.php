@extends('master')

@section('content')

    {{ Form::open(['route'=>'update', 'method' => 'post']) }}
    Номер счета
    <br/>
    {{ Form::text('DocID', null, ['class' => 'form-control btn']) }}
    <br/>
    статус
    <br/>
    {{ Form::text('status', null, ['class' => 'form-control btn']) }}
    {{ Form::close() }}

@stop