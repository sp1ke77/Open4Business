<!DOCTYPE html>
<html>
    <head>
        <title>VOST Open4Business - @yield('title')</title>

        <!-- Meta -->
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- CSS -->
        <link rel="stylesheet" type="text/css" href="{{asset('dropzone-5.7.0/dist/min/dropzone.min.css')}}">

        <!-- JS -->
        <script src="{{asset('dropzone-5.7.0/dist/min/dropzone.min.js')}}" type="text/javascript"></script>
    </head>
    <body>

        <div class="container">
            @yield('content')
        </div>
    </body>
</html>