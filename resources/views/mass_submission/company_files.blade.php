@extends('layouts.public')
@section('title', 'Formulário')

@section('content')
    <div class='container'>
        <div class="open4biz-header">

            <div class="row">
                <div class="col-sm">
                    <img
                            src="https://info.vost.pt/wp-content/uploads/2019/08/cropped-TEMPWEBSITE_ELEMENTS_VOSTPTLOGO_w160px-1.png">
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

        <div class="mass-submission--intro">
            {{--<p>Obrigado pelo teu interesse em nos ajudar a informar todos os cidadãos, neste período que atravessamos.
                <br>
                Esta área do site destina-se a empresas que tenham mais de 10 estabelecimentos, espalhados por todo o
                território nacional continental. <br>
                Pedimos que faças download deste ficheiro CSV e que sigas o seu formato para adicionares os teus dados.
            </p>

            <h5>Notas importantes</h5>
            <p>O formato de hora deve ser HH:MM - HH:MM (24H) exemplo 09:30 - 17:00<br>
                O formato das coordenados deve ser decimal, separada por pontos. <br>
                O e-mail de registo na plataforma deve ser válido, e estar monitorizado, pois será enviada um e-mail de
                validação da submissão de dados. </p>

            <h5>O que fazemos com estes dados?</h5>

            <p>Os dados públicos ficam online, após validação, no URL: <br>
                Os dados pessoais ficam guardados na nossa base de dados até ao final deste projeto (esperemos que seja
                muito em breve) e depois serão destruídos. </p>

            <h5>Dúvidas?</h5>
            <p>A VOST Portugal disponibiliza um e-mail dedicado para suporte desta plataforma. Pode nos contactar via
                o4bpt@vost.pt</p>--}}

            <p>Bem vindo à area de upload de dados em bulk para a plataforma "Open4Business", uma iniciativa da VOST
                Portugal em parceria com o Governo Português, para melhor informar os cidadãos sobre os estabelecimentos
                que continuam abertos no nosso país, nesta altura. Aconselhamos a que façam o download do template como
                base de trabalho para o parse dos dados necessários.</p>
            <p><strong>Notas importantes:</strong><br>
                Seguir, estritamente, os formatos indicados de hora, dia da semana, e latitude/longitude.<br>
                Fazer o upload do ficheiro CSV preenchendo todos os campos do formulário.<br>
                Obrigado pela sua ajuda nesta iniciativa que tem por objectivo ter uma população mais informada e mais
                segura.</p>

            <div class="text-center mt-5 text-uppercase">
                <a href="https://bit.ly/VOSTPT_O4B_TEMPLATE" class="btn btn-secondary btn-lg">Descarregar Template de
                    CSV</a>
            </div>
            <hr>
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

        <h3>Preencha os dados da sua Empresa</h3>

        <div class="row">
            <div class="col-12 mb-3">
                <label for="business_name">Nome da empresa*:</label>
                <input type="text" class="form-control" name="business_name" id="business_name">
            </div>
            <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="logotipo">Logótipo da empresa (.jpg ou .png)</label>
                </div>
                <form action="{{route('mass_submission.infoupload')}}" class='dropzone dropzone-logo'>
                    @csrf
                    <div class="dz-message" data-dz-message>
                        <span>Arraste para aqui <br> ou<br> <button class="btn btn-secondary">Carregar ficheiro</button></span>
                    </div>
                </form>
            </div>
            <div class="col-12 col-sm-6">
                <div class="form-group">
                    <label for="logotipo">Ficheiro CSV</label>
                </div>
                <form action="{{route('mass_submission.infoupload')}}" class='dropzone dropzone-csv'>
                    <div class="dz-message" data-dz-message><span>Arraste para aqui <br> ou<br> <button
                                    class="btn btn-secondary">Carregar ficheiro</button></span></div>
                </form>
            </div>
        </div>
        <form action="{{route('mass_submission.submitform')}}" method="POST">
            @csrf
            <h3>Dados de contacto</h3>
            <div class="row">
                <div class="col-sm">
                    <div class="form-group">
                        <label for="firstname">Nome*: </label><input class="form-control" type="text" name="firstname"
                                                                     value="{{old('firstname')}}  ">
                    </div>
                </div>
                <div class="col-sm">
                    <div class="form-group">
                        <label for="lastname">Apelido*: </label>
                        <input class="form-control" type="text" name="lastname"
                               value="{{old('lastname')}}  ">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm">
                    <div class="form-group">
                        <label for="contact">Telefone*: </label>
                        <input class="form-control" type="text" name="contact"
                               value="{{old('contact')}}">
                    </div>
                </div>
                <div class="col-sm">
                    <div class="form-group">
                        <label for="email">Email*: </label>
                        <input class="form-control" type="email" name="email"
                               value="{{old('email')}}">
                    </div>
                </div>
            </div>

            <small id="submitHelp" class="form-text text-muted">Antes de submeter, verifique por favor que introduziu o
                logótipo da empresa e um ficheiro CSV.</small>
            <small id="submitHelp" class="form-text text-muted">*Todos os campos deste formulário são de preenchimento
                obrigatório.</small>

            <div class="form-group text-center">
                <button type="submit" name="submit" class="btn btn-secondary btn-lg">Submeter Dados</button>
            </div>

    </div>
@endsection

@section('script')
    <!-- Script -->
    <script>
        var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

        Dropzone.autoDiscover = false;


        var fileDropZone1 = new Dropzone(".dropzone-logo", {
            maxFiles: 1,
            maxFilesize: 500,
            acceptedFiles: ".jpeg,.jpg,.png",
        });
        fileDropZone1.on("sending", function (file, xhr, formData) {
            formData.append("_token", CSRF_TOKEN);
        });
        var fileDropZone2 = new Dropzone(".dropzone-csv", {
            maxFiles: 1,
            maxFilesize: 500,
            acceptedFiles: ".csv",
        });
        fileDropZone2.on("sending", function (file, xhr, formData) {
            formData.append("_token", CSRF_TOKEN);
        });
    </script>
@endsection