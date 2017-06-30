@extends('master')

@section('content')


    <script src="{{ url('public/packages/manager/approved-order.js') }}" type="text/javascript"></script>
    <br/>
    <h1>Перед утверждением нужно заполнить данные о перевозчике</h1>
    {{ Form::label('orderID', 'Счет №'.$orderID) }}
    <br/>
    {{ Form::label('CompName', $CompName) }}
    {{ Form::open(['route'=>'approvedDone', 'method' => 'post', 'enctype' => 'multipart/form-data']) }}
    {{ Form::text('orderID', $orderID, ['hidden' => 'hidden', 'id' => 'approved-orderID']) }}
    {{ Form::text('StockID', $StockID, ['hidden' => 'hidden', 'id' => 'stockID']) }}
    {{ Form::text('CodeID3', $CodeID3, ['hidden' => 'hidden', 'id' => 'CodeID3']) }}
    {{ Form::text('CompID', $CompID, ['hidden' => 'hidden', 'id' => 'CompID']) }}
    <br/>
    {{------------------------------------------------------------------------------------}}
    {{ Form::label('', 'Дата отгрузки ', ['id' => 'dateShippingText']) }}
    {{ Form::input('date', 'dateShipping', null,
    ['placeholder' => 'Date', 'id' => 'dateShipping', 'class' => 'btn-default form-control']) }}
    {{-------------------------------------------------------------------------------------}}
    <br/>
    {{ Form::label('', 'Перевозчик ', ['id' => 'transporterText', 'style' => 'display:none;']) }}
    {{ Form::select('transporterID', $transporter,  null,
    ['id' => 'transporterName','class' => 'btn form-control', "style" => "align-content: center; display:none;"]) }}
    <br/>
    {{-------------------------------------------------------------------------------------------}}
    {{ Form::label('', 'Город ', ['id' => 'cityText', 'style' => 'display:none;']) }}
    <select id="city" name="city" class="btn form-control" style="align-content: center; display:none;">
        <option value="0" selected="selected">Select a value......</option>
    </select>
    {{------------------------------------------------------------------------------------}}
    <br/>
    {{------------------------------------------------------------------------------------}}
    {{ Form::label('', 'Отправитель ', ['id' => 'originatorText', 'style' => 'display:none;']) }}
    {{ Form::text('originator', 'Днепрополимермаш', ['id' => 'originator','class' => 'form-control', "style" => "display:none;"]) }}
    {{------------------------------------------------------------------------------------}}
    <br/>
    {{------------------------------------------------------------------------------------}}
    {{ Form::label('', 'Получатель ', ['id' => 'addresseeText', 'style' => 'display:none;']) }}
    {{ Form::select('addresseeSel', $compContact,  null,
    ['id' => 'addresseeSel','class' => 'btn form-control', "style" => "align-content: center; display:none;"]) }}
    {{ Form::text('addressee', '', ['id' => 'addressee','class' => 'btn-default form-control',
            'style' => 'display:none;']) }}
    {{------------------------------------------------------------------------------------}}
    <br/>
    {{------------------------------------------------------------------------------------}}
    {{ Form::label('', 'Плательщик ', ['id' => 'payerText', 'style' => 'display:none;']) }}
    <br/>
    {{ Form::checkbox('checkPayer', '', 1,
    ['id' => 'checkPayer',
    'data-on-text' => 'ДПМ',
    'data-off-text' => 'Yes',
    'data-label-width' => '100',
    'style' => 'display:none;']) }}
    <br/>
    {{ Form::text('payer', '',
    ['id' => 'payer',
    'data-switch-set-value' => 'offText',
    'style' => 'display:none;',
    'class' => 'btn-default form-control']) }}
    {{------------------------------------------------------------------------------------}}
    <br/>
    {{------------------------------------------------------------------------------------}}
    {{ Form::label('', 'Адрес ', ['id' => 'addressText', 'style' => 'display:none;']) }}
    {{ Form::select('addressSel', $compAdd,  null,
    ['id' => 'addressSel','class' => 'btn form-control', "style" => "align-content: center; display:none;"]) }}
    {{ Form::text('address', '', ['id' => 'address','class' => 'btn-default form-control', 'style' => 'display:none;']) }}
    {{------------------------------------------------------------------------------------}}
    <br/>
    {{------------------------------------------------------------------------------------}}
    {{ Form::label('', 'Склад перевозчика ', ['id' => 'stockTransporterText', 'style' => 'display:none;']) }}
    {{ Form::text('stockTransporter', '',
    ['id' => 'stockTransporter', 'novalidate' => 'novalidate', 'class' => 'btn-default form-control', 'style' => 'display:none;']) }}
    {{------------------------------------------------------------------------------------}}
    <br/>
    {{------------------------------------------------------------------------------------}}
    {{ Form::label('', 'Вид оплаты ', ['id' => 'payFormText', 'style' => 'display:none;']) }}
    {{ Form::select('payForm', ['0' => '', '1' => 'Наличка', '2' => 'Безналичка'], null,
    ['class' => 'btn-default form-control', 'id' => 'payForm', 'style' => 'align-content: center; display:none;']) }}
    <br/>
    {{------------------------------------------------------------------------------------}}
    {{ Form::label('', 'Забрать деньги ', ['id' => 'getCashText', 'style' => 'display:none;']) }}
    {{ Form::select('getCash',
    ['0' => 'На карту', '1' => 'По факту', '2' => 'Наложенный платеж'], null,
    ['class' => 'btn form-control', 'id' => 'getCash', 'style' => 'display:none;']) }}
    {{------------------------------------------------------------------------------------}}
    <br/>
    {{------------------------------------------------------------------------------------}}
    {{ Form::label('', 'Особые отметки ', ['id' => 'specialNotesText', 'style' => 'display:none;']) }}
    {{ Form::text('specialNotes', '',
    ['id' => 'specialNotes', 'class' => 'btn-default form-control', 'style' => 'display:none;']) }}
    {{------------------------------------------------------------------------------------}}
    <br/>
    {{------------------------------------------------------------------------------------}}
    {{ Form::submit('Утвердить',['id' => 'sendApproved','class' => 'form-control  btn btn-primary btn-lg', 'style' => 'display:none;']) }}
    {{------------------------------------------------------------------------------------}}
    {{ Form::close() }}
@stop