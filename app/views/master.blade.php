<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta http-equiv="Pragma" content="no-cache" />
    <title>@yield('title', '' ) - Система для менеджеров</title>
    <link href="{{ url('public/packages/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url('public/packages/admin/metro-bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('public/packages/fontawesome/css/font-awesome.min.css') }}">
    <link href="{{ url('public/packages/admin/style.css') }}" rel="stylesheet">
    <link href="{{ url('public/packages/admin/timeline.css') }}" rel="stylesheet">
    <link href="{{ url('public/packages/bootstrap-tour/build/css/bootstrap-tour.css') }}" rel="stylesheet">
    <link href="{{ url('public/packages/table/table.css') }}" rel="stylesheet">
    <style>
        @import "{{ url('public/packages/font/osans.css') }}";

        * {
            font-family: 'OpenSansRegular';
            
        }
        
    </style>
    <script src="{{ url('public/packages/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ url('public/packages/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ url('public/packages/bootstrap-tour/build/js/bootstrap-tour.js') }}"></script>
    <script src="{{ url('public/packages/manager/underscore-min.js') }}" type="text/javascript"></script>
    <script src="{{ url('public/packages/manager/jquery.livequery.min.js') }}" type="text/javascript"></script>
    <link type="text/css" media="screen" rel="stylesheet" href="{{ url('public/packages/table/responsive-tables.css') }}" />
    <script type="text/javascript" src="{{ url('public/packages/table/responsive-tables.js') }}"></script>
    <link href="{{ url('public/packages/select2/dist/css/select2.min.css') }}" rel="stylesheet">
    <script src="{{ url('public/packages/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <link href="{{ url('public/packages/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet">
    <link href="{{ url('public/packages/bootstrap-switch-master/dist/css/bootstrap3/bootstrap-switch.min.css') }}" rel="stylesheet">
    <script src="{{ url('public/packages/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('public/packages/bootstrap-switch-master/dist/js/bootstrap-switch.min.js') }}" type="text/javascript"></script>
    {{--<script src="{{ url('public/packages/bootstrap-checkbox/dist/js/bootstrap-checkbox.min.js') }}" type="text/javascript"></script>--}}
    <link href="{{ url('public/packages/footable/css/footable.bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ url('public/packages/footable/js/footable.min.js') }}" type="text/javascript"></script>
    <script>
        $(document).on("click", ".del", function (e) {
            var link = $(this).attr("href"); // "get" the intended link in a var
            e.preventDefault();
            bootbox.confirm("Вы уверены?", function (result) {
                if (result) {
                    document.location.href = link;  // if result, "set" the document location
                }
            });
        });
    </script>
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-74105479-1', 'auto');
    ga('send', 'pageview');

    function trackJavaScriptError(e) {
        var ie = window.event || {},
                errMsg = e.message || ie.errorMessage;
        var errSrc = (e.filename || ie.errorUrl) + ': ' + (e.lineno || ie.errorLine);
        ga('send', 'event', 'JavaScript Error', errMsg, errSrc, { 'nonInteraction': 1 });
    }
    if (window.addEventListener) {
        window.addEventListener('error', trackJavaScriptError, false);
    } else if (window.attachEvent) {
        window.attachEvent('onerror', trackJavaScriptError);
    } else {
        window.onerror = trackJavaScriptError;
    }
</script>    
</head>
<body>

@include('partials/navbar')

<div class="container">
    @yield('content')

    <div class="footer">
        <a href="mailto:admin@alista.org.ua">admin@alista.org.ua</a>
        &copy; {{ date('Y') }}

    </div>
</div>
</body>
</html>