@extends('layouts.public')


@section('content')
    <div class="section--primary mb-5">
        <div class="container">
            <p class="lead">Informa aqui que a tua empresa e/ou negócio continua aberta e como é que
                <wbr>
                podemos usufruir dos produtos e serviços neste período excecional.
            </p>
            <div class="button__wrapper">
                <a href="" class="button button--secondary">Pequenas e médias empresas</a>
                <a href="{{ route('mass_submission.index') }}" class="button button--secondary">Grandes empresas e cadeias</a>
            </div>
        </div>
    </div>
    <div class="container">

    </div>
@endsection