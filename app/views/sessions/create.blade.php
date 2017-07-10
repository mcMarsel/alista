@extends('login')

@section('login')

    <link rel="stylesheet" type="text/css" href="{{url('public/packages/login/login.css')}}"/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <section id="content">

            {{ Form::open(['route' => 'sessions.store'])  }}

            
            <div class="div-logo" style="text-align: center; align-content: center;">
            	<a id='logo' class="img-responsive" rel="logo"></a>
	    </div>
	    

            <div>
                <input type="text" autocorrect="off" autocapitalize="off" placeholder="Логин{{--trans('login.username')--}}" required="" name="username" id="username"/>
            </div>
            <div>
                <input type="password" autocorrect="off" autocapitalize="off" placeholder="Пароль{{--trans('login.password')--}}" required="" id="password"
                       name="password"/>
            </div>
            <div>
                <input class="btn btn-primary form-control" type="submit" value="Войти{{--trans('login.button_text')--}}"/>
                {{--<a href="#">{{trans('login.lost_password')}}</a>--}}

            </div>
            {{ Form::close() }}
            <!-- form -->
            <div class="button">
                <a href="">by Peter Glazunov</a>
            </div>
           
    </section>

@stop