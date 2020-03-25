<!DOCTYPE html>
<html>

<head>
    <title>VOST Open4Business - @yield('title')</title>

    <!-- Meta -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('css/website.css')}}">
    <!-- JS -->
</head>

<body>

    <div class="website container">
        @yield('content')
    </div>
    <script src="{{asset('js/app.js')}}" type="text/javascript"></script>
    @yield('script')
</body>

</html>