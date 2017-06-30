@extends('master')

@section('content')

    <h2>Список предприятий</h2>
    <table id="comp-list" class="table table-bordered table-responsive" data-filtering="true" data-sorting="true"
           data-paging="true">
        <thead>
        <tr>
            <td data-breakpoints="xs">ИД предприятия</td>
            <td>Название предприятия</td>
            <td data-type="html">Действие</td>
        </tr>
        </thead>
        <tbody>
        @foreach($comps as $key => $value)
            <tr>
                <td class="CompID">{{ $value['CompID'] }}</td>
                <td class="CompName">{{ $value['CompName'] }}</td>
                <td>
                    <form method="POST" action="edit-comp">
                        <input type="text" style="display: none;" name="compID" value="{{ $value['CompID'] }}">
                        <input type="text" style="display: none;" name="compName" value="{{ $value['CompName'] }}">
                        <input type="submit" class="btn-primary" name="Редактировать" value="Редактировать">
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <br/>
    <br/>
    <a href='addnew'>{{ Form::button('Добавить новое предприятие',['id' => 'sender','class' => 'form-control  btn btn-primary btn-lg', 'style' => 'width: 100%; display: inline-block', 'style' => 'height: 10%;']) }}</a>

    <script src="{{ url('public/packages/manager/comps.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        function load(e) {
            var compName = $(e).children('.CompName').text();
            var compID = $(e).children('.CompID').text();
            console.log($(e).children('.CompName').text());
        }
    </script>
@stop
