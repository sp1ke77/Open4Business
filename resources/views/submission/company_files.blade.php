
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
    
    <div class="intro">
        <p>Obrigado pelo teu interesse em nos ajudar a informar todos os cidadãos, neste período que atravessamos. <br>
        Esta área do site destina-se a empresas que tenham mais de 10 estabelecimentos, espalhados por todo o território nacional continental. <br>
        Pedimos que faças download deste ficheiro CSV e que sigas o seu formato para adicionares os teus dados. </p>
        
        <h5>Notas importantes</h5>
        <p>O formato de hora deve ser HH:MM - HH:MM (24H) exemplo 09:30 - 17:00<br>
        O formato das coordenados deve ser decimal, separada por pontos. <br>
        O e-mail de registo na plataforma deve ser válido, e estar monitorizado, pois será enviada um e-mail de validação da submissão de dados. </p>

        <h5>O que fazemos com estes dados?</h5>

        <p>Os dados públicos ficam online, após validação, no URL: <br>
        Os dados pessoais ficam guardados na nossa base de dados até ao final deste projeto (esperemos que seja muito em breve) e depois serão destruídos. </p>

        <h5>Dúvidas?</h5>
        <p>A VOST Portugal disponibiliza um e-mail dedicado para suporte desta plataforma. Pode nos contactar via o4bpt@vost.pt</p>
        <a href="{{url('examples/uploadcsv.png')}}" data-lightbox="image-csvexample" data-title="exemplo csv"><img width="100%" src="{{url('examples/uploadcsv.png')}}"></a>
    </div>
    
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
    
    <h3>Dados de empresa</h3>
    
    <div class="row">
        <div class="col-sm">
            <form action="{{route('company.infoupload')}}" class='dropzone dropzone-logo' >
                <div class="dz-message" data-dz-message><span>Arraste para aqui o logótipo ou <br>clique para fazer upload</span></div>
            </form> 
        </div>
        <div class="col-sm">
            <form action="{{route('company.infoupload')}}" class='dropzone dropzone-csv' >
                <div class="dz-message" data-dz-message><span>Arraste para aqui o CSV ou <br>clique para fazer upload</span></div>
            </form> 
        </div>
    </div>
    <form action="{{route('company.submitform')}}" method="POST">
    <div class="row">
        <div class="col-sm">
            <div class="form-group">
                <label for="nome">Nome da empresa*: </label><input class="form-control" type="text" name="nome_empresa" value="{{old('nome_empresa')}}  ">
            </div>
        </div>
    </div>
    
    <h3>Dados do contacto</h3>

    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="row">
        <div class="col-sm">
            <div class="form-group">
                <label for="nome">Nome*: </label><input class="form-control" type="text" name="nome" value="{{old('nome')}}  ">
            </div>
        </div>
        <div class="col-sm">
            <div class="form-group">
                <label for="nome">Apelido*: </label><input class="form-control" type="text" name="apelido" value="{{old('apelido')}}  ">
            </div>
        </div>  
    </div>
    <div class="row">
        <div class="col-sm">
            <div class="form-group">
                <label for="telefone">Telefone*: </label><input class="form-control" type="text" name="telefone" value="{{old('telefone')}}">
            </div>
        </div>
        <div class="col-sm">
            <div class="form-group">
                <label for="email">Email*: </label><input class="form-control" type="text" name="email" value="{{old('email')}}">
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
    var fileDropZone1 = new Dropzone(".dropzone-logo",{ 
        maxFiles: 1,
        maxFilesize: 500,
        acceptedFiles: ".jpeg,.jpg,.png,.csv",
    });
    fileDropZone1.on("sending", function(file, xhr, formData) {
        formData.append("_token", CSRF_TOKEN);
    });

    var fileDropZone2 = new Dropzone(".dropzone-csv",{ 
        maxFiles: 1,
        maxFilesize: 500,
        acceptedFiles: ".csv",
    });
    fileDropZone2.on("sending", function(file, xhr, formData) {
        formData.append("_token", CSRF_TOKEN);
    });
</script>
@endsection
