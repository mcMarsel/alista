@extends('master')

@section('content')
<script src="{{ url('public/packages/manager/accr-edit.js') }}" type="text/javascript"></script>
<style>
   .s10:hover {
    background-color: #EE8F48
   }
</style>
<div>
    {{ Form::label($EmpPL, $EmpPL, ['id' => 'EmpPL', 'style' => 'display:none;']) }}
	Курс на начало набития счета: {{ Form::label('currency', round($orders[0]['Kurs'], 2), ['id' => 'currency','class' => 'mylabel']) }}
	Номер счета: {{ Form::label('orderID', $orderID, ['id' => 'ordID', 'class' => 'mylabel']) }}
	Курс сейчас: {{ Form::label('curKurs', round($currency, 2), ['id' => 'curKurs', 'class' => 'mylabel']) }}
	</br>Форма оплаты: {{ Form::label('typeInv', $orders[0]['CodeID3'], ['id' => 'typeInv','class' => 'mylabel', 'hidden' => 'hidden']) }}
	{{ Form::select('inv', ['1' => 'Наличный','4' => 'Без наличный'], null, ['id' => 'inv', 'class' => 'form-control btn btn-primary', "style" => "align-content: center;", "disabled" => "true" ]) }}
	</br>Склад: {{ Form::label('stockID', $orders[0]['StockID'], ['id' => 'stockID']) }}
	{{ Form::select('stock', ['110' => 'Днепропетровск','118' => 'Киев'], null, ['id' => 'stock', 'class' => 'form-control btn btn-primary', "disabled" => "true", "style" => "align-content: center;"]) }}
    </br>
    </br>
    <div>
        {{ Form::label('empID', $aboutOrder['EmpID'], ['id' => 'empID', 'class' => 'mylabel', 'hidden' => 'hidden']) }}
        @if(is_array($Emps))
            {{ Form::select('emp', $Emps,  null, ['id' => 'emp', 'class' => 'form-control btn btn-primary', "style" => "align-content: center;"]) }}
        @else
            {{ Form::label('emp', array_keys($Emps), ['id' => 'emp', 'class' => 'mylabel', 'hidden' => 'hidden']) }}
        @endif
    </div>
	</br>
	{{ Form::label($curCompID, $curCompName, ['class' => 'mylabel', 'hidden' => 'hidden' , 'id' => 'curComp']) }}
	</br>Предприятие: {{ Form::select('e-comps', $comps,  null, ['id' => 'e-comps', "disabled" => "true", 'class' => 'form-control btn btn-primary', "style" => "align-content: center;"]) }}
    </br>
    <!--{{ Form::button('Сформировать',['id' => 'send','class' => 'form-control  btn btn-primary']) }} -->
    </br>
    <table class="table table-hover table-responsive" style="width:100%;">
        <thead>
            <tr>
                <th hidden="hidden">№</th>
                <th>Код товара</th>
                <th>Имя товара</th>
                <th>Кол-во</th>
                <th>Ед.изм.</th>
                <th>Цена</th>
                <th>Сумма грн</th>
                <th>Сумма $</th>
                <!--<th>Удалить</th>-->
            </tr>
        </thead>
        <tbody id="tbody-g">
            @foreach($orders as $key => $value)
                <tr class="touch s{{ $value['status'] }}" style="background-color: {{ $value['color'] }}">
                    <th hidden="hidden" class="ScrPosID">{{ $value['SrcPosID'] }}</th>
                    <th class="ShortProdName">{{ $value['ShortProdName'] }}</th>
                    <th class="ProdName">{{ $value['ProdName'] }}</th>
                    <th class="Qty"><input value="{{ round($value['Qty'], 1) }}" class="quantity" type="number" autocorrect="off" pattern="\d+" novalidate/></th>
                    <th class="UM">{{ $value['UM'] }}</th>
                    <th><span style="width: 100%; height: 100%" class="btn m-price PriceMC" name="{{ $value['PLID'] }}" id="m-price{{$key}}">{{ ceil(($value['PriceMC'] / 6) * 100) / 100 * 6 }}</span></th>
                    <th class="totalPCC">{{ ceil(($value['totalPricePosCC'] / 6) * 100) / 100 * 6 }}</th>
                    <th class="totalPMC">{{ ceil(($value['totalPricePosMC'] / 6) * 100) / 100 * 6 }}</th>
                    <!--<th class="">{{ Form::button('Удалить', ['class' => 'posDel btn btn-primary']) }}</th> -->
                    <? var_dump($value); ?>
                    @if(count($value['pl']) == 10)
                        <th class="pl1" id="pl0" name="{{ $value['pl'][0]['PLID'] }}" hidden="hidden">{{ ceil(($value['pl'][0]['PriceMC'] * $currency / 6) * 100) / 100 * 6 }}</th>
                        <th class="pl2" id="pl1" name="{{ $value['pl'][1]['PLID'] }}" hidden="hidden">{{ ceil(($value['pl'][1]['PriceMC'] * $currency / 6) * 100) / 100 * 6 }}</th>
                        <th class="pl3" id="pl2" name="{{ $value['pl'][2]['PLID'] }}" hidden="hidden">{{ ceil(($value['pl'][2]['PriceMC'] * $currency / 6) * 100) / 100 * 6 }}</th>
                        <th class="pl4" id="pl3" name="{{ $value['pl'][3]['PLID'] }}" hidden="hidden">{{ ceil(($value['pl'][3]['PriceMC'] * $currency / 6) * 100) / 100 * 6 }}</th>
                        <th class="pl5" id="pl4" name="{{ $value['pl'][4]['PLID'] }}" hidden="hidden">{{ ceil(($value['pl'][4]['PriceMC'] * $currency / 6) * 100) / 100 * 6 }}</th>
                        <th class="pl6" id="pl5" name="{{ $value['pl'][5]['PLID'] }}" hidden="hidden">{{ ceil(($value['pl'][5]['PriceMC'] * $currency / 6) * 100) / 100 * 6 }}</th>
                        <th class="pl7" id="pl6" name="{{ $value['pl'][6]['PLID'] }}" hidden="hidden">{{ ceil(($value['pl'][6]['PriceMC'] * $currency / 6) * 100) / 100 * 6 }}</th>
                        <th class="pl8" id="pl7" name="{{ $value['pl'][7]['PLID'] }}" hidden="hidden">{{ ceil(($value['pl'][7]['PriceMC'] * $currency / 6) * 100) / 100 * 6 }}</th>
                        <th class="pl9" id="pl8" name="{{ $value['pl'][8]['PLID'] }}" hidden="hidden">{{ ceil(($value['pl'][8]['PriceMC'] * $currency / 6) * 100) / 100 * 6 }}</th>
                        <th class="pl10" id="p19" name="{{ $value['pl'][9]['PLID'] }}" hidden="hidden">{{ ceil(($value['pl'][9]['PriceMC'] * $currency / 6) * 100) / 100 * 6 }}</th>
                        <th class="pl0" id="pl110" name="" hidden="hidden" > - </th>
                    @elseif(count($value['pl']) == 11)
                        <th class="pl0" id="pl0" name="{{ $value['pl'][0]['PLID'] }}" hidden="hidden">{{ ceil(($value['pl'][0]['PriceMC'] * $currency / 6) * 100) / 100 * 6 }}</th>
                        <th class="pl1" id="pl1" name="{{ $value['pl'][1]['PLID'] }}" hidden="hidden">{{ ceil(($value['pl'][1]['PriceMC'] * $currency / 6) * 100) / 100 * 6 }}</th>
                        <th class="pl2" id="pl2" name="{{ $value['pl'][2]['PLID'] }}" hidden="hidden">{{ ceil(($value['pl'][2]['PriceMC'] * $currency / 6) * 100) / 100 * 6 }}</th>
                        <th class="pl3" id="pl3" name="{{ $value['pl'][3]['PLID'] }}" hidden="hidden">{{ ceil(($value['pl'][3]['PriceMC'] * $currency / 6) * 100) / 100 * 6 }}</th>
                        <th class="pl4" id="pl4" name="{{ $value['pl'][4]['PLID'] }}" hidden="hidden">{{ ceil(($value['pl'][4]['PriceMC'] * $currency / 6) * 100) / 100 * 6 }}</th>
                        <th class="pl5" id="pl5" name="{{ $value['pl'][5]['PLID'] }}" hidden="hidden">{{ ceil(($value['pl'][5]['PriceMC'] * $currency / 6) * 100) / 100 * 6 }}</th>
                        <th class="pl6" id="pl6" name="{{ $value['pl'][6]['PLID'] }}" hidden="hidden">{{ ceil(($value['pl'][6]['PriceMC'] * $currency / 6) * 100) / 100 * 6 }}</th>
                        <th class="pl7" id="pl7" name="{{ $value['pl'][7]['PLID'] }}" hidden="hidden">{{ ceil(($value['pl'][7]['PriceMC'] * $currency / 6) * 100) / 100 * 6 }}</th>
                        <th class="pl8" id="pl8" name="{{ $value['pl'][8]['PLID'] }}" hidden="hidden">{{ ceil(($value['pl'][8]['PriceMC'] * $currency / 6) * 100) / 100 * 6 }}</th>
                        <th class="pl9" id="pl9" name="{{ $value['pl'][9]['PLID'] }}" hidden="hidden">{{ ceil(($value['pl'][9]['PriceMC'] * $currency / 6) * 100) / 100 * 6 }}</th>
                        if($app->username == "admin"){}
                        <th class="pl10" id="pl10" name="{{ $value['pl'][10]['PLID'] }}" hidden="hidden">{{ ceil(($value['pl'][10]['PriceMC'] * $currency / 6) * 100) / 100 * 6 }}</th>
                    @endif
                </tr>
            @endforeach
            <tr id="tbody-pos"></tr>
        </tbody>
    </table>
    <!--{{ Form::button('Добавить позицию', ['class' => 'btn btn-default', 'id' => 'add']) }} -->
    </br>
    <div id="addpos">
    </div>
    </br>
    <div class="table-container">
        <table id="tgoods" hidden="hidden" class="table table-bordered table-responsive" style="width: 100%">
            <thead style="width: 100%">
                <tr>
                    <th style="width: 10%">Код товара</th>
                    <th style="width: 40%">Название товара</th>
                    <th style="width: 10%">Кол-во</th>
                    <th style="width: 5%">Ед. изм.</th>
                    <th style="width: 10%">Цена</th>
                    <th style="width: 10%">Остатки безнал</th>
                    <th style="width: 10%">Остатки нал</th>
                    <th style="width: 5%">В корзину</th>
                </tr>
            </thead>
            <tbody id="tbgoods" class="table-filter">
            </tbody>
        </table>
    </div>
</div>

<div id="myModal" class="modal fade" role="dialog" hidden="hidden">
	<div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" onclick="close()" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Прайс по товару</h4>
            <br/>
            {{ Form::label('descText', null, ['id' => 'descText', 'style' => 'display: none;']) }}
            {{ Form::label('descPL', null, ['id' => 'descPL', 'style' => 'display: none;']) }}
            <div hidden="hidden" id='modal-id'></div>
        </div>
            <div class="modal-body">
                <div class="table table-responsive" style="display: table; margin: 0 auto; text-align: center; border: 1px solid black; border-collapse: collapse;">
                    <div style="display: table-header-group;">
                        <div class="tr" style="display: table-row;">
                            <div style="border: 1px solid black; display: table-cell;" class="td">101</div>
                            <div style="border: 1px solid black; display: table-cell;" class="td">102</div>
                            <div style="border: 1px solid black; display: table-cell;" class="td">103</div>
                            <div style="border: 1px solid black; display: table-cell;" class="td">104</div>
                            <div style="border: 1px solid black; display: table-cell;" class="td">105</div>
                            <div style="border: 1px solid black; display: table-cell;" class="td">106</div>
                            <div style="border: 1px solid black; display: table-cell;" class="td">107</div>
                            <div style="border: 1px solid black; display: table-cell;" class="td">108</div>
                            <div style="border: 1px solid black; display: table-cell;" class="td">109</div>
                            <div style="border: 1px solid black; display: table-cell;" class="td">110</div>
                            <div style="background-color: #ffff00; border: 1px solid black; display: table-cell;" class="td">111</div>
                        </div>
                    </div>
                    <div style="display: table-row-group;">
                        <div class="tr" style="display: table-row;">
                            <div style="border: 1px solid black; display: table-cell;" class="btn price-val" id="p0m" name="101"></div>
                            <div style="border: 1px solid black; display: table-cell;" class="btn price-val" id="p1m" name="102"></div>
                            <div style="border: 1px solid black; display: table-cell;" class="btn price-val" id="p2m" name="103"></div>
                            <div style="border: 1px solid black; display: table-cell;" class="btn price-val" id="p3m" name="104"></div>
                            <div style="border: 1px solid black; display: table-cell;" class="btn price-val" id="p4m" name="105"></div>
                            <div style="border: 1px solid black; display: table-cell;" class="btn price-val" id="p5m" name="106"></div>
                            <div style="border: 1px solid black; display: table-cell;" class="btn price-val" id="p6m" name="107"></div>
                            <div style="border: 1px solid black; display: table-cell;" class="btn price-val" id="p7m" name="108"></div>
                            <div style="border: 1px solid black; display: table-cell;" class="btn price-val" id="p8m" name="109"></div>
                            <div style="border: 1px solid black; display: table-cell;" class="btn price-val" id="p9m" name="110"></div>
                            <div style="background-color: #ffff00; border: 1px solid black; display: table-cell;" class="btn price-val" id="p10m" name="111"></div>
                        </div>
                    </div>
                </div>
            <input type="text" id="price-text" class="form-control" placeholder="Введите цену">
        </div>
        <div class="modal-body" style="width: 100%; align-content: center;">
        </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            <!--<button type="button" class="btn btn-default" data-dismiss="modal" id="modal-done">Готово</button> -->
        </div>
        </div>
	</div>
</div>

<div id="mModal" class="modal fade" role="dialog" hidden="hidden">
	<div class="modal-dialog modal-lg">
	    <div class="modal-content">
        <div class="modal-header">
            <button type="button" onclick="close()" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Прайс по товару</h4>
            <div hidden="hidden" id='m-modal-id'></div>
            <br/>
            {{ Form::label('descText', null, ['id' => 'descText', 'style' => 'display: none;']) }}
            {{ Form::label('descPL', null, ['id' => 'descPL', 'style' => 'display: none;']) }}
        </div>
        <div class="modal-body">
            <div id="table-modal" class="table table-responsive" style="display: table; margin: 0 auto; text-align: center; border: 1px solid black; border-collapse: collapse;">
                <div style="display: table-header-group;">
                    <div class="tr" style="display: table-row;">
                        <div style="border: 1px solid black; display: table-cell;" class="td">101</div>
                        <div style="border: 1px solid black; display: table-cell;" class="td">102</div>
                        <div style="border: 1px solid black; display: table-cell;" class="td">103</div>
                        <div style="border: 1px solid black; display: table-cell;" class="td">104</div>
                        <div style="border: 1px solid black; display: table-cell;" class="td">105</div>
                        <div style="border: 1px solid black; display: table-cell;" class="td">106</div>
                        <div style="border: 1px solid black; display: table-cell;" class="td">107</div>
                        <div style="border: 1px solid black; display: table-cell;" class="td">108</div>
                        <div style="border: 1px solid black; display: table-cell;" class="td">109</div>
                        <div style="border: 1px solid black; display: table-cell;" class="td">110</div>
                        <div style="background-color: #ffff00; border: 1px solid black; display: table-cell;" class="td">111</div>
                    </div>
                    <div class="tr tr-val" style="display: table-row;">
                        <div style="border: 1px solid black; display: table-cell;" class="btn m-price-val" id="p00m" name="101"></div>
                        <div style="border: 1px solid black; display: table-cell;" class="btn m-price-val" id="p01m" name="102"></div>
                        <div style="border: 1px solid black; display: table-cell;" class="btn m-price-val" id="p02m" name="103"></div>
                        <div style="border: 1px solid black; display: table-cell;" class="btn m-price-val" id="p03m" name="104"></div>
                        <div style="border: 1px solid black; display: table-cell;" class="btn m-price-val" id="p04m" name="105"></div>
                        <div style="border: 1px solid black; display: table-cell;" class="btn m-price-val" id="p05m" name="106"></div>
                        <div style="border: 1px solid black; display: table-cell;" class="btn m-price-val" id="p06m" name="107"></div>
                        <div style="border: 1px solid black; display: table-cell;" class="btn m-price-val" id="p07m" name="108"></div>
                        <div style="border: 1px solid black; display: table-cell;" class="btn m-price-val" id="p08m" name="109"></div>
                        <div style="border: 1px solid black; display: table-cell;" class="btn m-price-val" id="p09m" name="110"></div>
                        <div style="background-color: #ffff00; border: 1px solid black; display: table-cell;" class="btn m-price-val" id="p010m" name="111"></div>
                    </div>
                </div>
            </div>
            <br/>
            <input type="text" id="m-price-text" class="form-control" placeholder="Введите цену">
        </div>
        <div class="modal-footer">
		    <button type="button" class="btn btn-default" data-dismiss="modal" id="m-modal-close">Закрыть</button>
		   <!-- <button type="button" class="btn btn-default" data-dismiss="modal" id="m-modal-done">Готово</button> -->
	    </div>
	</div>
	</div>
</div>

@stop