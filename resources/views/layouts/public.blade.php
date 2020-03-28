<!DOCTYPE html>
<html>

<head>
    <title>VOST Open4Business - @yield('title')</title>

    <!-- Meta -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('css/website.css') }}">
    <!-- JS -->
</head>

<body>
    <header class="container">
        <h1 class="logo">
            <a href="/">
                <span>#open</span>
                4businesspt
            </a>
        </h1>
    </header>
    <main class="">
        <div class="main__alert" id="cookie-alert">
            <small class="container">
                Utilizamos cookies para melhorar a experiência de navegação. Sabe mais sobre a nossa política de cookies <a href="#">aqui</a>. <a href="#" class="icon icon--close">&times;</a>
            </small>
        </div>

        <div class="section--primary mb-5">
            <div class="container">
                <p class="lead">Informa aqui que a tua empresa e/ou negócio continua aberta e como é que <wbr> podemos usufruir dos produtos e serviços neste período excecional.</p>
                <div class="button__wrapper">
                    <a href="" class="button button--secondary">Pequenas e médias empresas</a>
                    <a href="" class="button button--secondary">Grandes empresas e cadeias</a>
                </div>
            </div>
        </div>
        <div class="container">
            @yield('content')
        </div>
    </main>
    <section class="section--primary section__cta">
        <div class="container">
            <div class="row">
                <div class="col-3 section__cta__hash">
                    #open4businesspt
                </div>
                <div class="col-9 section__cta__info">
                    Partilhe esta hashtag e este site com os negócios locais para que possam incluir a sua atividade, disponibilidade e modo de funcionamento nesta altura excecional.

                </div>
            </div>
        </div>
    </section>
    <script src="{{asset('js/app.js')}}" type="text/javascript"></script>
    @yield('script')
</body>

</html>