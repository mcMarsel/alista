@extends('master')

@section('content')
    <script src="{{ url('public/packages/manager/pl.js') }}" type="text/javascript"></script>
    <h1>Прайс-листы</h1>
    </br>
    </br>
    {{-- Form::button('Сохранить', ['class' => 'btn btn-primary form-control btn-lg', 'id' => 'save']) --}}
    {{-- Form::button('Сохранить', ['class' => 'btn btn-primary form-control btn-lg', 'id' => 'save']) --}}
    {{ Form::button('Сохранить', ['class' => 'btn btn-primary form-control btn-lg', 'id' => 'save']) }}
    </br>
    </br>
    {{--data-expanded="true"--}}
    {{ Form::open(['route' => 'load', 'method' => 'post', 'enctype' => 'multipart/form-data']) }}
    {{ Form::submit('Load', ['class' => 'form-control']) }}
    <table class="table table-hover table-responsive">
        <thead>
        <tr>
            <th data-type="html"></th>
            <th data-breakpoints="xs">Название группы</th>
            <th data-breakpoints="xs">ИД группы</th>
            <th data-breakpoints="xs" data-type="html">Прайс-лист</th>
            <th data-breakpoints="all" data-type="html"></th>
        </tr>
        </thead>
        <tbody id="arr">
        @foreach($pgr as $key => $value)
            <tr>
                <td class="check-pl">{{ Form::checkbox('check', 1, null, ['class' => 'check-p']) }}</td>
                <td>{{ $value['PGrName3'] }}</td>
                <td>{{ $value['PGrID3'] }}</td>
                <td class="gr-pl">
                    {{ Form::select('pl', $pl,  null, ['id' => 'plg', 'class' => 'form-control']) }}
                </td>
                <td class="ch-td">
                    <div class="table table-hover table-responsive ch-table" style="display: table;">
                        @foreach($pr as $k => $val)
                            @if($value['PGrID3'] == $val['PGrID3'])
                                <div class="tr" style="display: table-row;">
                                    <div style="display: table-cell;" class="td prodName">{{ $val['ProdName'] }}</div>
                                    <div style="display: table-cell;" class="td prodID">{{ $val['ProdID'] }}</div>
                                    <div style="display: table-cell;" class="td pl">
                                        {{ Form::select('pl', $pl,  null, ['id' => 'plp', 'class' => 'form-control']) }}
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ Form::close() }}

@stop