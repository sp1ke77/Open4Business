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
            <a class="navbar-brand font-weight-bold d-flex align-items-center" rel="home" href="{{ route('home') }}"
               title="#Open4Business" itemprop="url">
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
                            <a href="#" class="nav-link text-secondary" id="sidebar-menu">Menu <i
                                        class="fas fa-bars"></i></a>
                        </li>
                    </ul>
                </div>
            </div>

        </div><!-- .container -->

    </nav>

    <nav class="navbar navbar-expand navbar-dark bg-secondary fixed-right sidebar-menu">

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav text-uppercase">
                <li class="nav-item" id="close-menu">
                    <a href="#" class="nav-link">Fechar Menu</a>
                </li>
            </ul>
            <ul class="navbar-nav text-uppercase">
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link">Entrada</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link">Lista de Empresas</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link">Formulário para grandes empresas e cadeias</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link">Sobre</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link">Política de Privacidade e Política de Cookies</a>
                </li>
            </ul>
        </div>
    </nav>
</header>
<main class="">
    <div class="main__alert" id="cookie-alert">
        <small class="container">
            Utilizamos cookies para melhorar a experiência de navegação. Sabe mais sobre a nossa política de cookies <a
                    href="#">aqui</a>. <a href="#" class="icon icon--close" id="cookie-alert--close">&times;</a>
        </small>
    </div>

    @yield('content')
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