<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{csrf_token()}}">

    <link href=" {{ mix('css/app.css') }}" rel="stylesheet">
{{--    <link rel="stylesheet" href="/assets/plugins/fontawesome-free/css/all.min.css">--}}
{{--    <script src="/assets/plugins/jquery/jquery.min.js"></script>--}}
{{--    <script src="/assets/plugins/jquery-ui/jquery-ui.js"></script>--}}
{{--    <link rel="stylesheet" href="/assets/plugins/jquery-ui/jquery-ui.css">--}}
{{--    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">--}}
{{--    <link rel="stylesheet" href="/assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">--}}
{{--    <link rel="stylesheet" href="/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">--}}


    {{--<link rel="stylesheet" href="/assets/dist/css/skins/_all-skins.min.css">--}}

{{--    <link rel="stylesheet" href="/assets/dist/css/adminlte.min.css">--}}
{{--    <link rel="stylesheet" href="/assets/dist/css/custom/style.css">--}}
{{--    <!-- summernote -->--}}
{{--    <link rel="stylesheet" href="/assets/plugins/summernote/summernote.css">--}}
{{--    <script src="/assets/plugins/summernote/summernote.js"></script>--}}
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body>



<v-app id="app">

    @include('user.templates.header')
    @include('user.templates.sidebar')

    <v-content>
        @yield('content')
    </v-content>

    @include('user.templates.footer')

</v-app>
<script src="{{ mix('js/app.js') }}"></script>
<!-- Bootstrap 4 -->
{{--<script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>--}}
{{--<!-- bs-custom-file-input -->--}}
{{--<script src="/assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>--}}
{{--<!-- AdminLTE App -->--}}
{{--<script src="/assets/dist/js/adminlte.min.js"></script>--}}
{{--<!-- AdminLTE for demo purposes -->--}}
{{--<script src="/assets/dist/js/demo.js"></script>--}}
{{--<script src="/assets/dist/js/custom/user.js"></script>--}}

@yield('scripts')

</body>
</html>
