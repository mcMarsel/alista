<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    {{--<title>{{ Config::get('app.name','Larabox') }}</title>--}}
    <link href="{{ url('public/packages/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url('public/packages/bootstrap/dist/css/bootstrap-theme.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('public/packages/fontawesome/css/font-awesome.min.css') }}">
    <link href="{{ url('public/packages/admin/style.css') }}" rel="stylesheet">
    <style>
        @import "{{ url('/public/packages/font/osans.css') }}";

        * {
            font-family: 'OpenSansLightRegular';
        }
    </style>
</head>

<body>
@yield('login')
<div class="container">
    {{--@include('flash::message')--}}
    @yield('content')
</div>

<script src="{{ url('public/packages/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ url('public/packages/bootstrap/dist/js/bootstrap.min.js') }}"></script>

</body>
</html>