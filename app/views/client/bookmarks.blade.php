@extends('master')

@section('content')
    Код предприятия: {{ Form::label('CompID', $compID, ['class' => 'bth', 'id' => 'CompID']) }}
    <br/>
    Имя предприятия: {{ Form::label('CompName', $compName, ['class' => 'bth']) }}
    <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="#delivery_settings" role="tab" data-toggle="tab">Доставка</a></li>
        <li class=""><a href="#other_settings" role="tab" data-toggle="tab">Другие настройки</a></li>
    </ul>
    <div class="tab-content">
        <div class="active tab-pane fade in" id="delivery_settings">
            <h1>
                <small>Редактирование и добавление адресов доставки и контактов</small>
            </h1>
            <table class="table-striped table-responsive" id="tbAddress">
                @foreach($address as $key => $value)
                    @if(!empty($value['CompAdd']))
                        <tr class="add">
                            <td>{{ Form::text('address', $value['CompAdd'],['class' => 'addressEdit', 'id' => $value['id']]) }}</td>
                            <td>
                                {{ Form::button('Удалить', ['id' => $value['id'], 'class' => 'btn btn-primary delAddress']) }}
                                {{ Form::button('Сохранить', ['id' => $value['id'], 'class' => 'btn btn-primary editAddress']) }}
                            </td>
                        </tr>
                    @endif
                @endforeach
                <tr>
                    <td>{{ Form::button('Добавить адрес', ['class' => 'btn-primary', 'id' => 'addAddress']) }}</td>
                </tr>
            </table>
            <table class="table-striped table-responsive" id="tbContact">
                @foreach($contact as $key => $value)
                    <tr class="cont">
                        @if(!empty($value['Contact']))
                            <td>{{ Form::text('contact', $value['Contact'],['class' => 'contactEdit', 'id' => $value['id']]) }}</td>
                            <td>
                                {{ Form::button('Удалить', ['id' => $value['id'], 'class' => 'btn btn-primary delAddress']) }}
                                {{ Form::button('Сохранить', ['id' => $value['id'], 'class' => 'btn btn-primary editContact']) }}
                            </td>
                        @endif
                        @if(!empty($value['PhoneWork']))
                            <td>{{ Form::text('phone', $value['PhoneWork'],['class' => 'phoneEdit', 'id' => $value['id']]) }}</td>
                            <td>
                                {{ Form::button('Удалить', ['id' => $value['id'], 'class' => 'btn btn-primary delAddress']) }}
                                {{ Form::button('Сохранить', ['id' => $value['id'], 'class' => 'btn btn-primary editContact']) }}
                            </td>
                        @elseif(!empty($value['PhoneMob']))
                            <td>{{ Form::text('phone', $value['PhoneMob'],['class' => 'phoneEdit', 'id' => $value['id']]) }}</td>
                            <td>
                                {{ Form::button('Удалить', ['id' => $value['id'], 'class' => 'btn btn-primary delAddress']) }}
                                {{ Form::button('Сохранить', ['id' => $value['id'], 'class' => 'btn btn-primary editContact']) }}
                            </td>
                        @elseif(!empty($value['PhoneHome']))
                            <td>{{ Form::text('phone', $value['PhoneHome'],['class' => 'phoneEdit', 'id' => $value['id']]) }}</td>
                            <td>
                                {{ Form::button('Удалить', ['id' => $value['id'], 'class' => 'btn btn-primary delAddress']) }}
                                {{ Form::button('Сохранить', ['id' => $value['id'], 'class' => 'btn btn-primary editContact']) }}
                            </td>
                        @endif
                    </tr>
                @endforeach
                <tr>
                    <td>{{ Form::button('Добавить контактное лицо', ['class' => 'btn-primary', 'id' => 'addContact']) }}</td>
                </tr>
            </table>
        </div>
        <div class="tab-pane fade in" id="other_settings">
        </div>
    </div>
    <script src="{{ url('public/packages/edit-comps.js') }}" type="text/javascript"></script>
@stop