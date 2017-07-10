@extends('master')
@section('title')
    Набитие счета
@stop

@section('content')
<div class="">

<div id="myModal" class="modal fade" role="dialog" hidden="hidden">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" onclick="CloseModal()" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Прайс по товару</h4>
                <br/>
                {{ Form::label('descText', null, ['id' => 'descText', 'style' => 'display: none;']) }}
                {{ Form::label('descPL', null, ['id' => 'descPL', 'style' => 'display: none;']) }}
                <div hidden="hidden" id='modal-id'></div>
            </div>
            <div class="modal-body">
                <div class="table table-responsive" style="margin: 0 auto; text-align: center; border: 1px solid black; border-collapse: collapse; display: table;">
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
                            <div style="border: 1px solid black; display: table-cell; background-color: #ffff00" class="td">111</div>
                        </div>
                    </div>
                    <div style="display: table-row-group;">
                        <div class="tr" style="display: table-row;">
                            <div style="border: 1px solid black; display: table-cell;" class="td btn price-val" id="p101" name="101"></div>
                            <div style="border: 1px solid black; display: table-cell;" class="btn price-val" id="p102" name="102"></div>
                            <div style="border: 1px solid black; display: table-cell;" class="btn price-val" id="p103" name="103"></div>
                            <div style="border: 1px solid black; display: table-cell;" class="btn price-val" id="p104" name="104"></div>
                            <div style="border: 1px solid black; display: table-cell;" class="btn price-val" id="p105" name="105"></div>
                            <div style="border: 1px solid black; display: table-cell;" class="btn price-val" id="p106" name="106"></div>
                            <div style="border: 1px solid black; display: table-cell;" class="btn price-val" id="p107" name="107"></div>
                            <div style="border: 1px solid black; display: table-cell;" class="btn price-val" id="p108" name="108"></div>
                            <div style="border: 1px solid black; display: table-cell;" class="btn price-val" id="p109" name="109"></div>
                            <div style="border: 1px solid black; display: table-cell;" class="btn price-val" id="p110" name="110"></div>
                            <div style="border: 1px solid black; display: table-cell; background-color: #ffff00" class="td btn price-val" id="p111" name="111"></div>
                        </div>
                    </div>
                </div>
                <input type="number" autocorrect="off" pattern="\d*" novalidate id="price-text" class="form-control" placeholder="Введите цену">
            </div>
            <div class="modal-footer">
                <button type="button" onclick="CloseModal()" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                <button type="button" onclick="CloseModal()" class="btn btn-default" data-dismiss="modal" id="modal-done">Готово</button>
            </div>
        </div>
    </div>
</div>
    Текущий курс: {{ Form::label('', '', ['id' => 'Kurs', 'style' => 'display:none;']) }}
    {{ Form::label($EmpPL, $EmpPL, ['id' => 'EmpPL', 'style' => 'display:none;']) }}
    <input type="text" readonly="true" style="border: hidden">
    {{ Form::open(['route'=>'form', 'method' => 'post', 'enctype' => 'multipart/form-data']) }}
    	<div style="text-align: center">
	        <div class="inv" style="display:inline-block;">
	        Безналичный счет {{ Form::radio('invoice', '1', '', ['class' => 'form-control']) }}<br/>
			Наличный счет {{ Form::radio('invoice', '0', true, ['class' => 'form-control']) }}
	        </div>
	        <div class="stock" style="display:inline-block;">
	        Склад Днепропетровск (110) {{ Form::radio('stock', '1', true, ['class' => 'form-control']) }}<br/>
			Склад Киев (118) {{ Form::radio('stock', '0', '', ['class' => 'form-control']) }}
	        </div>
        </div>
        <br/>
        <br/>
        <div id="comps">
        {{ Form::select('comp', $comps,  null, ['id' => 'comp',
        'class' => 'form-control btn btn-primary btn-lg', "style" => "height: 10%; width: 100%; align-content: center;"]) }}
        </div>
        <br/>
        <br/>
        <div>
        	<table hidden="hidden" id="tposition" class="table table-hover table-responsive" style="width: 100%">
        		<thead>
        		<tr>
        			<th><div>Код товара</div></th>
                                <th><div>Название товара</div></th>
                                <th><div>Кол-во</div></th>
                                <th><div>Ед. изм.</div></th>
                                <th><div>Цена</div></th>
                                <th><div>Удалить</div></th>
                        </tr>
                        </thead>
                        <tbody id="tbody">
                        	<tr id="tbody-pos"></tr>
                        </tbody>
        	</table>
        </div>
        <br/>
        <br/>
        {{ Form::select("category", $pgr3Obj, null, 
        ["disabled" => true, "class" => "form-control  btn btn-primary btn-lg", "id" => "category", "style" => "height: 10%; width: 100%; align-content: center;"]) }}
        <br/>
        <br/>
        {{ Form::button('Сформировать',["disabled" => true, 'id' => 'sender','class' => 'form-control  btn btn-primary btn-lg', 'style' => 'width: 100%; display: inline-block', 'style' => 'height: 10%;']) }}
        
        <a href="manager" id="a-createOrder">{{ Form::button('Новый счет',['id' => 'createOrder','class' => 'form-control  btn btn-primary btn-lg',  'style' => 'display: none; width: 100%;']) }}</a>
        <br/>
        <br/>
        <br/>
        <div class="table-container">
        <table class="table table-bordered table-responsive" style="width: 100%">
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
                <tbody id="table-filter" class="table-filter">
                </tbody>
            </table>
        </div>
    {{ Form::close() }}
    <div id="error"></div>
</div>
<script type="text/javascript">

    function CloseModal()
    {
        $('#div-price').remove();
        $('#descPL').hide();
        $('#descPL').text('');
        $('#descText').hide();
        $('#descText').text('');
        $('#price-text').val('');
    }
</script>
<script src="{{ url('public/packages/manager/jquery.livequery.min.js') }}" type="text/javascript"></script>
<script src="{{ url('public/packages/manager/manager-order.js') }}" type="text/javascript"></script>


@stop