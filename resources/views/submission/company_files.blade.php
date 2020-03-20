<!DOCTYPE html>
<html>
  <head>
    <title>VOST Open4Business - Formulário</title>

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

    <div class='content'>
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

  </body>
</html>x
