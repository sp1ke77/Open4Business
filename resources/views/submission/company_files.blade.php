
@extends('layouts.public')
@section('title', 'Formulário')

@section('content')
<div class="open4biz-header">
    <h1>VOST Open4Business</h1>
</div>
<div class='content'>
    <p>Este formulário destina-se à submissão de um ficheiro com dados dos vários equipamentos abertos e seus horários. Para fazer download do ficheiro modelo a preencher, <a href="/examples/upload.csv">clique aqui</a>.
    O ficheiro deverá conter uma linha por cada horário de cada equipamento. Para melhor esclarecer a forma correta de preenchimento veja a seguinte imagem:<p>
    <img src="{{url('examples/uploadcsv.png')}}">
    <!-- Dropzone -->
    <h3>Faça aqui upload do ficheiro CSV e do logótipo da Marca</h3>
    <form action="{{route('company.infoupload')}}" class='dropzone' >

    </form> 
    <h3>Contacto responsável</h3>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <form action="{{route('company.submitform')}}" class='dropzone' method="POST">
    <input type="hidden" name = "_token" value="{{ csrf_token() }}">
    <label for="nome">Nome: </label><input type="text" name = "nome" value="{{old('nome')}}  ">
    <label for="telefone">Telefone: </label><input type="text" name = "telefone" value="{{old('telefone')}}">
    <label for="email">Email: </label><input type="text" name = "email" value="{{old('email')}}">
    <button type="submit" name="submit">submit</button>
    </form> 
</div>

@if(session()->has('success_message'))
<div class="alert alert-success">
    {{ session()->get('success_message') }}
</div>
@endif

<!-- Script -->
<script>
var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

Dropzone.autoDiscover = false;
var fileDropZone = new Dropzone(".dropzone",{ 
    maxFilesize: 500,
    acceptedFiles: ".jpeg,.jpg,.png,.csv",
});
fileDropZone.on("sending", function(file, xhr, formData) {
    formData.append("_token", CSRF_TOKEN);
});

</script>
@endsection
