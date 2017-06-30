@extends('master')
@section('content')
    <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="#prod_settings" role="tab" data-toggle="tab">Доступные группы товаров</a></li>
        <li class=""><a href="#user_settings" role="tab" data-toggle="tab">Пользователи</a></li>
        <li class=""><a href="#head_settings" role="tab" data-toggle="tab">Руководители</a></li>
        <li class=""><a href="#currency_settings" role="tab" data-toggle="tab">Настройки курса</a></li>
    </ul>

    <div class="tab-content">
        <div class="active tab-pane fade in" id="prod_settings">
            <h1>
                <small>Редактирование и добавление групп товара</small>
            </h1>
            <br/>
            {{ Form::text('addID', '', ['class' => '', 'placeholder' => 'Введите код группы 3']) }}
            {{ Form::text('addText', '', ['class' => '', 'placeholder' => 'Введите наименование группы 3']) }}
            {{ Form::button('Добавить группу', ['class' => 'btn btn-primary addGr3']) }}
            <br/>
            <table class="table-striped table-responsive" id="pgr3" data-filtering="true" data-paging="true">
                <thead>
                <tr>
                    <th data-breakpoints="">Имя группы 3</th>
                    <th data-type="html">Действие</th>
                </tr>
                </thead>
                <tbody>
                @foreach($pgr3Obj as $key => $value)
                    <tr>
                        @if($value['status'] ==  1)
                            <td>{{ $value['PGrName3'] }}</td>
                            <td>
                                <input type="submit" class="btn btn-primary hideGr3" name="Скрыть" value="Скрыть"
                                       id="{{ $value['PGrID3'] }}">
                            </td>
                        @else
                            <td>{{ $value['PGrName3'] }}</td>
                            <td>
                                <input type="submit" class="btn btn-primary showGr3" name="Показать" value="Показать"
                                       id="{{ $value['PGrID3'] }}">
                            </td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade in" id="user_settings">
            <h1>
                <small>Управление пользователями</small>
            </h1>
            <br/>
            {{ Form::button('Добавить пользователя', ['class' => 'btn btn-primary addUser', 'id' => 'addUser']) }}
            <br/>
            <table class="table-striped table-responsive" id="user" data-filtering="true" data-paging="true">
                <thead>
                <tr>
                    <th data-breakpoints="">Имя пользователя</th>
                    <th data-breakpoints="">Код служащего</th>
                    <th data-type="html">Статус</th>
                    <th data-type="html">Редактировать</th>
                    <th data-type="html">Удалить</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $key => $value)
                    <tr>
                        @if($value['status'] ==  1)
                            <td>{{ $value['EmpName'] }}</td>
                            <td>{{ $value['EmpID'] }}</td>
                            <td>
                                <input type="button" status="0" class="btn btn-primary degrade" name="Розжаловать"
                                       value="Розжаловать" id="{{ $value['id'] }}">
                            </td>
                            <td>
                                <input type="button" class="btn btn-primary edit" name="Редактировать"
                                       value="Редактировать" id="{{ $value['id'] }}">
                            </td>
                            <td>
                                <input type="button" class="btn btn-primary del_user" name="Удалить" value="Удалить"
                                       id="{{ $value['id'] }}">
                            </td>
                        @else
                            <td>{{ $value['EmpName'] }}</td>
                            <td>{{ $value['EmpID'] }}</td>
                            <td>
                                <input type="button" status="1" class="btn btn-primary increase" name="Повысить"
                                       value="Повысить" id="{{ $value['id'] }}">
                            </td>
                            <td>
                                <input type="button" class="btn btn-primary edit" name="Редактировать"
                                       value="Редактировать" id="{{ $value['id'] }}">
                            </td>
                            <td>
                                <input type="button" class="btn btn-primary del_user" name="Удалить" value="Удалить"
                                       id="{{ $value['id'] }}">
                            </td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade in" id="head_settings">
            <h1>
                <small>Управление руководителями</small>
            </h1>
            <br/>
            {{ Form::select('Emps', $emp, null, ['class' => 'btn form-control', 'id' => 'selHead']) }}
            {{ Form::button('Назначить руководителем', ['class' => 'btn btn-primary form-control', 'id' => 'addHead']) }}
            <br/>
            <table class="table-striped table-responsive" id="head" data-filtering="true" data-paging="true">
                <thead>
                <tr>
                    <th data-breakpoints="">Код служащего</th>
                    <th data-breakpoints="">Имя служащего</th>
                    <th data-breakpoints="">Прайс-лист</th>
                    <th data-type="html">Розжаловать</th>
                </tr>
                </thead>
                <tbody>
                @foreach($head as $key => $value)
                    <tr>
                        <td>{{ $value['EmpID'] }}</td>
                        <td>{{ $value['EmpName'] }}</td>
                        <td>{{ $value['MinPLID'] }}</td>
                        <td>
                            <input type="button" class="btn btn-primary degrade_head" name="Розжаловать"
                                   value="Розжаловать" id="{{ $value['id'] }}">
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade in" id="currency_settings">
            <h1>
                <small>Управление курсом</small>
            </h1>
            <br/>
            {{ Form::text('uncash', '', ['id' => 'uncash', 'class' => '', 'placeholder' => 'Безналичный курс']) }}
            {{ Form::text('cash', '', ['id' => 'cash', 'class' => '', 'placeholder' => 'Наличный курс']) }}
            <br/>
            {{ Form::button('Сохранить курс', ['class' => 'btn btn-primary saveKurs', 'id' => 'saveKurs']) }}
        </div>
    </div>

    <div id="editModal" class="modal fade" role="dialog" hidden="hidden">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="modal-title">Редактирование</h4>
                    {{ Form::label('idLabel', 'ИД пользователя', ['id' => 'idLabel']) }}
                    {{ Form::label('id', '', ['id' => 'id']) }}
                    <br/>
                    Код служащего {{ Form::text('EmpID', '', ['id' => 'EmpID']) }}
                </div>
                <div class="modal-body">
                    {{ Form::label('usernameLabel', 'Имя пользователя', ['id' => 'usernameLabel']) }}
                    {{ Form::text('username', '', ['id' => 'username', 'class' => 'form-control']) }}<br/>
                    {{ Form::label('EmpNameLabel', 'Имя служащего', ['id' => 'EmpNameLabel']) }}
                    {{ Form::text('EmpName', '', ['id' => 'EmpName', 'class' => 'form-control']) }}<br/>
                    {{ Form::label('UAEmpNameLabel', 'Имя служащего(УКР)', ['id' => 'UAEmpNameLabel']) }}
                    {{ Form::text('UAEmpName', '', ['id' => 'UAEmpName', 'class' => 'form-control']) }}<br/>
                    {{ Form::label('EMailLabel', 'EMail', ['id' => 'EMailLabel']) }}
                    {{ Form::text('EMail', '', ['id' => 'EMail', 'class' => 'form-control']) }}<br/>
                    {{ Form::label('PLIDLabel', 'Прайс-лист', ['id' => 'PLIDLabel']) }}
                    {{ Form::text('PLID', '', ['id' => 'PLID', 'class' => 'form-control']) }}<br/>
                    {{ Form::label('HeadIDLabel', 'Выберете руководителя', ['id' => 'HeadIDLabel']) }}
                    {{ Form::select('heads', $heads, null, ['class' => 'btn form-control', 'id' => 'heads']) }}<br/>
                    {{ Form::text('HeadID', '', ['id' => 'HeadID', 'class' => 'form-control']) }}<br/>
                    {{ Form::label('passwordLabel', 'Пароль', ['id' => 'passwordLabel']) }}
                    {{Form::text('password', '', ['id' => 'password', 'class' => 'form-control']) }}
                    {{ Form::button('Задать новый пароль', ['class' => 'btn-primary', 'id' => 'spw']) }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" id="close">Закрыть</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal" id="modal-done">Сохранить
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ url('public/packages/setting-main.js') }}" type="text/javascript"></script>
@stop