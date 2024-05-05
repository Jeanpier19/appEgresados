<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="shortcut icon" href="{{asset('img/favicon.ico')}}">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="{{asset('startui/css/separate/pages/login.min.css')}}">
    <link rel="stylesheet" href="{{asset('startui/css/lib/font-awesome/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('startui/css/lib/bootstrap/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('startui/css/main.css')}}">
    <link rel="stylesheet" href="{{asset('startui/css/separate/elements/steps.min.css')}}">
</head>
<body>

<div class="page-center">
    @yield('content')
</div><!--.page-center-->


<script src="{{asset('startui/js/lib/jquery/jquery.min.js')}}"></script>
<script src="{{asset('startui/js/lib/tether/tether.min.js')}}"></script>
<script src="{{asset('startui/js/lib/bootstrap/bootstrap.min.js')}}"></script>
<script src="{{asset('startui/js/plugins.js')}}"></script>
<script type="text/javascript" src="{{asset('startui/js/lib/match-height/jquery.matchHeight.min.js')}}"></script>
<script src="{{asset('startui/js/app.js')}}"></script>
<script src="{{asset('startui/js/lib/bootstrap-notify/bootstrap-notify.min.js')}}"></script>
<script>
    $(function() {
        $('.page-center').matchHeight({
            target: $('html')
        });

        $(window).resize(function(){
            setTimeout(function(){
                $('.page-center').matchHeight({ remove: true });
                $('.page-center').matchHeight({
                    target: $('html')
                });
            },100);
        });
    });
</script>
@yield('js')
</body>
</html>
