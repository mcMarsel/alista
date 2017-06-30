@extends('master')

@section('content')

    <h2>Письмо отправленно</h2>
    <table>
        <tr>
            <td>Название предприятия: {{ $clientName }}</td>
        </tr>
        <tr>
            <td>Область: {{ $region }}</td>
        </tr>
        <tr>
            <td>Город: {{ $city }}</td>
        </tr>
        <tr>
            <td>Контактное лицо: {{ $fullName }}</td>
        </tr>
        <tr>
            <td>Время работы: {{ $timeWork }}</td>
        </tr>
        <tr>
            <td>Контактный номер телефона: {{ $phone }}</td>
        </tr>
    </table>
    <br/>
    <br/>
    <a href='addnew'>{{ Form::button('Добавить нового клиента',['id' => 'sender','class' => 'form-control  btn btn-primary btn-lg', 'style' => 'width: 100%; display: inline-block', 'style' => 'height: 10%;']) }}</a>
    <a href='list-client'>{{ Form::button('Список клиентов',['id' => 'sender','class' => 'form-control  btn btn-primary btn-lg', 'style' => 'width: 100%; display: inline-block', 'style' => 'height: 10%;']) }}</a>



@stop