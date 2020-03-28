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
<header class="">
    <nav class="navbar navbar-expand-md navbar-white bg-white text-uppercase text-secondary">

        <div class="container-fluid">
            <a class="navbar-brand font-weight-bold d-flex align-items-center" rel="home" href="https://covid19estamoson.gov.pt/" title="EstamosON" itemprop="url">
                <div class="logo-img-container">

                </div>

                <div class="logo-text-container d-none d-md-block">
                    <p><span class="text-primary">#Open</span><span class="text-secondary">4Business</span></p>
                </div>
            </a>
            <div class="row">
                <div class="col">
                </div>
                <div class="col-auto">
                    <ul class="navbar-nav">
                        <!-- <li class="nav-item">
                            <a href="#" class="nav-link text-secondary">Pesquisa <i class="fas fa-search"></i></a>
                        </li> -->
                        <li class="nav-item">
                            <a href="#" class="nav-link text-secondary" id="sidebar-menu">Menu <i class="fas fa-bars"></i></a>
                        </li>
                    </ul>
                </div>
            </div>

        </div><!-- .container -->

    </nav>
</header>
<main class="">
    <div class="main__alert" id="cookie-alert">
        <small class="container">
            Utilizamos cookies para melhorar a experiência de navegação. Sabe mais sobre a nossa política de cookies <a
                    href="#">aqui</a>. <a href="#" class="icon icon--close" id="cookie-alert--close">&times;</a>
        </small>
    </div>

    <div class="section--primary mb-5">
        <div class="container">
            <p class="lead">Informa aqui que a tua empresa e/ou negócio continua aberta e como é que
                <wbr>
                podemos usufruir dos produtos e serviços neste período excecional.
            </p>
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
                Partilhe esta hashtag e este site com os negócios locais para que possam incluir a sua atividade,
                disponibilidade e modo de funcionamento nesta altura excecional.

            </div>
        </div>
    </div>
</section>
<script src="{{asset('js/app.js')}}" type="text/javascript"></script>
<script src="https://kit.fontawesome.com/43bb6c105b.js" crossorigin="anonymous"></script>
@yield('script')
</body>

</html>