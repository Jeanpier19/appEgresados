<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="shortcut icon" href="{{asset('img/favicon.ico')}}">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('startui/css/lib/summernote/summernote.css')}}">
    <link rel="stylesheet" href="{{asset('startui/css/separate/pages/editor.min.css')}}">
    <link rel="stylesheet" href="{{asset('startui/css/separate/pages/mail.min.css')}}">
    <link rel="stylesheet" href="{{asset('startui/css/lib/lobipanel/lobipanel.min.css')}}">
    <link rel="stylesheet" href="{{asset('startui/css/separate/vendor/lobipanel.min.css')}}">
    <link rel="stylesheet" href="{{asset('startui/css/lib/jqueryui/jquery-ui.min.css')}}">
    <link rel="stylesheet" href="{{asset('startui/css/separate/pages/widgets.min.css')}}">
    <link rel="stylesheet" href="{{asset('startui/css/lib/font-awesome/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('startui/css/lib/fontawesome/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('startui/css/lib/bootstrap/bootstrap.min.css')}}">

    <link rel="stylesheet" href="{{asset('startui/css/lib/datatables-net/datatables.min.css')}}">
    <link rel="stylesheet" href="{{asset('startui/css/separate/vendor/datatables-net.min.css')}}">

    <link rel="stylesheet" href="{{asset('startui/css/lib/bootstrap-sweetalert/sweetalert.css')}}">
    <link rel="stylesheet" href="{{asset('startui/css/separate/vendor/sweet-alert-animations.min.css')}}">
    <link rel="stylesheet" href="{{asset('startui/css/separate/vendor/bootstrap-select/bootstrap-select.min.css')}}">
    <link rel="stylesheet" href="{{asset('startui/css/separate/vendor/select2.min.css')}}">

    <link href="{{asset('startui/plugins/dropzone/dropzone.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('startui/css/separate/vendor/jquery-steps.min.css')}}">
    <link rel="stylesheet" href="{{asset('startui/css/main.css')}}">
    @yield('css')
    <style>
        button.delete-confirm {
            margin-top: -1px;
        }
        button.action {
            margin-top: -1px;
        }
        a.btn-inline {
            margin-bottom: -20px !important;
        }
    </style>
</head>
<body class="with-side-menu control-panel control-panel-compact">
@include('partials.header')
@include('partials.side-menu')
<div class="mobile-menu-left-overlay"></div>

<div class="page-content">
    @yield('content')
</div><!--.page-content-->

{{--@include('partials.control-panel')--}}
<script src="{{asset('startui/js/lib/jquery/jquery.min.js')}}"></script>
<script src="{{asset('startui/js/lib/tether/tether.min.js')}}"></script>
<script src="{{asset('startui/js/lib/bootstrap/bootstrap.min.js')}}"></script>
<script src="{{asset('startui/js/plugins.js')}}"></script>

<script type="text/javascript" src="{{asset('startui/js/lib/jqueryui/jquery-ui.min.js')}}"></script>
<script type="text/javascript" src="{{asset('startui/js/lib/lobipanel/lobipanel.min.js')}}"></script>
<script type="text/javascript" src="{{asset('startui/js/lib/match-height/jquery.matchHeight.min.js')}}"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="{{asset('startui/js/lib/datatables-net/datatables.min.js')}}"></script>
<script src="{{asset('startui/js/lib/bootstrap-sweetalert/sweetalert.min.js')}}"></script>
<script src="{{asset('startui/js/lib/bootstrap-notify/bootstrap-notify.min.js')}}"></script>
<script src="{{asset('startui/js/lib/bootstrap-select/bootstrap-select.min.js')}}"></script>
<script src="{{asset('startui/js/lib/select2/select2.full.min.js')}}"></script>
<script src="{{asset('startui/plugins/dropzone/dropzone.js')}}"></script>
<script src="{{asset('startui/js/lib/jquery-validation/jquery.validate.min.js')}}"></script>
<script src="{{asset('startui/js/lib/jquery-steps/jquery.steps.min.js')}}"></script>
<script>
    $(document).ready(function () {
        $('.panel').lobiPanel({
            sortable: true
        });
        $('.panel').on('dragged.lobiPanel', function (ev, lobiPanel) {
            $('.dahsboard-column').matchHeight();
        });
        $(".alert.cerrar").delay(3000).slideUp(300);
    });
</script>
<script src="{{asset('startui/js/app.js')}}"></script>
@yield('js')
</body>
</html>
