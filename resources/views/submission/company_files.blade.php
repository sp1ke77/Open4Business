
@extends('layouts.public')
@section('title', 'Formulário')

@section('content')
<div class='content'>
    <div class="open4biz-header">
        
        <div class="row">
            <div class="col-sm">
            <img src="https://info.vost.pt/wp-content/uploads/2019/08/cropped-TEMPWEBSITE_ELEMENTS_VOSTPTLOGO_w160px-1.png">
            </div>
            <div class="col-sm header-title">
            <h1>Open4Business</h1>
            </div>
            <div class="col-sm">
            &nbsp;
            </div>
            <div class="col-sm">
            &nbsp;
            </div>
        </div>

    </div>
    <p>Este formulário destina-se à submissão dos dados sobre vários equipamentos em functionamento e seus horários na plataforma <b>Open4Business</b>. Para fazer download do ficheiro modelo a preencher, <a href="/examples/upload.csv">clique aqui</a>.
    O ficheiro deverá conter uma linha por cada horário de cada equipamento. Para melhor esclarecer a forma correta de preenchimento veja a seguinte imagem:<p>
    <a href="{{url('examples/uploadcsv.png')}}" data-lightbox="image-csvexample" data-title="exemplo csv"><img width="100%" src="{{url('examples/uploadcsv.png')}}"></a>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if(session()->has('success_message'))
    <div class="alert alert-success">
        {{ session()->get('success_message') }}
    </div>
    @endif
    <!-- Dropzone -->
    <h3>1) Faça aqui upload do ficheiro CSV e do logótipo da Marca</h3>
    <form action="{{route('company.infoupload')}}" class='dropzone' >

    </form> 
    <h3>2) Contacto responsável</h3>
    <form action="{{route('company.submitform')}}" method="POST">
    <input type="hidden" name = "_token" value="{{ csrf_token() }}">
    <div class="row">
        <div class="col-sm">
            <div class="form-group">
                <label for="nome">Nome*: </label><input class="form-control" type="text" name = "nome" value="{{old('nome')}}  ">
            </div>
        </div>  
        <div class="col-sm">
            <div class="form-group">
                <label for="telefone">Telefone*: </label><input class="form-control" type="text" name = "telefone" value="{{old('telefone')}}">
            </div>
        </div>
        <div class="col-sm">
            <div class="form-group">
                <label for="email">Email*: </label><input class="form-control" type="text" name = "email" value="{{old('email')}}">
            </div>
        </div>
    </div>
    <small id="submitHelp" class="form-text text-muted">Antes de submeter, verifique por favor que introduziu o logótipo da empresa e um ficheiro CSV.</small>
    <small id="submitHelp" class="form-text text-muted">*Todos os campos deste formulário são de preenchimento obrigatório.</small>
    <button type="submit" name="submit" class="btn btn-primary">Enviar</button>
</div>


<!-- Script -->
<script>
var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

Dropzone.autoDiscover = false;
var fileDropZone = new Dropzone(".dropzone",{ 
    maxFiles: 2,
    maxFilesize: 500,
    acceptedFiles: ".jpeg,.jpg,.png,.csv",
});
fileDropZone.on("sending", function(file, xhr, formData) {
    formData.append("_token", CSRF_TOKEN);
});

</script>
@endsection
