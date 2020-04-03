@extends('layouts.public')

@section('styles')
<link href="https://api.mapbox.com/mapbox-gl-js/v1.9.0/mapbox-gl.css" rel="stylesheet" />
<style>
    #map {
        width: 100%;
        height: 50vh;
    }

    .marker {
        background-image: url('img/pin.png');
        background-size: cover;
        width: 42px;
        height: 52px;
        top: -25px;
        cursor: pointer;
        transition: none;
    }
</style>
@endsection

@section('content')
<div class="container" style="padding-top:2vh;padding-bottom:2vh;">
    <h1>Submissão de Pequenas Empresas</h1>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form action="{{route('single_submission.submit')}}" method="POST">
        @csrf
        <h3>Informações da Loja</h3>
        <div class="row">
            <div class="form-group col-6">
                <input type="text" class="form-control" placeholder="Nome da Empresa" name="company" required>
            </div>
            <div class="form-group col-6">
                <input type="text" class="form-control" placeholder="Nome da Loja" name="store_name" required>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-3">
                <input type="text" class="form-control" placeholder="Contacto da Loja" name="phone_number" required>
            </div>
            <div class="form-group col-9">
                <select class="form-control" name="sector">
                    <option selected>Selecione o Sector da Loja</option>
                    <option value="0">Minimercados, supermercados, hipermercados</option>
                    <option value="1">Frutarias, talhos, peixarias, padarias</option>
                    <option value="2">Mercados, para venda de produtos alimentares</option>
                    <option value="3">Produção e distribuição agroalimentar</option>
                    <option value="4">Lotas</option>
                    <option value="5">Restauração e bebidas, apenas para take-away</option>
                    <option value="6">Confeção de refeições prontas a levar para casa, apenas take-away</option>
                    <option value="7">Serviços médicos ou outros serviços de saúde e apoio social</option>
                    <option value="8">Farmácias e Parafarmácias</option>
                    <option value="9">Lojas de produtos médicos e ortopédicos</option>
                    <option value="10">Oculistas</option>
                    <option value="11">Lojas de produtos cosméticos e de higiene</option>
                    <option value="12">Lojas de produtos naturais e dietéticos</option>
                    <option value="13">Serviços públicos essenciais de água, energia elétrica, gás natural e gases de
                        petróleo liquefeitos canalizados</option>
                    <option value="14">Serviços recolha e tratamento de águas residuais, recolha e tratamento de águas
                        residuais e resíduos sólidos urbanos, higiene urbana e serviço de transporte de passageiros
                    </option>
                    <option value="15">Serviços de comunicações eletrónicas e correios</option>
                    <option value="16">Papelarias, tabacarias e jogos sociais</option>
                    <option value="17">Clínicas veterinárias</option>
                    <option value="18">Lojas de venda de animais de companhia e respetivos alimentos</option>
                    <option value="19">Lojas de venda de flores, plantas, sementes e fertilizantes</option>
                    <option value="20">Lojas de lavagem e limpeza a seco de roupa</option>
                    <option value="21">Drogarias</option>
                    <option value="22">Lojas de bricolage e outros</option>
                    <option value="23">Postos de abastecimento de combustível</option>
                    <option value="24">Estabelecimentos de venda de combustíveis para uso doméstico;</option>
                    <option value="25">Oficinas e venda de peças mecânicas</option>
                    <option value="26">Lojas de venda e reparação de eletrodomésticos, equipamento informático e de
                        comunicações e respetiva reparação</option>
                    <option value="27">Bancos, Seguros e Serviços Financeiros</option>
                    <option value="28">Funerárias</option>
                    <option value="29">Serviços de manutenção e reparações, em casa</option>
                    <option value="30">Serviços de segurança ou de vigilância, em casa</option>
                    <option value="31">Atividades de limpeza, desinfeção, desratização e similares</option>
                    <option value="32">Serviços de entrega ao domicílio</option>
                    <option value="33">Estabelecimentos turísticos, exceto parques de campismo, apenas com serviço de
                        restaurante e bar para os respectivos hóspedes</option>
                    <option value="34">Serviços que garantam alojamento estudantil</option>
                    <option value="35">Atividades e estabelecimentos enunciados nos números anteriores, ainda que
                        integrados em centros comerciais</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-12">
                <input type="text" class="form-control" placeholder="Morada" name="address" id="address" required>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-3">
                <input type="text" class="form-control" placeholder="Código Postal" name="postal_code" required>
            </div>
            <div class="form-group col-3">
                <input type="text" class="form-control" placeholder="Freguesia" name="parish" id="parish" required>
            </div>
            <div class="form-group col-3">
                <input type="text" class="form-control" placeholder="Concelho" name="county" id="county" required>
            </div>
            <div class="form-group col-3">
                <input type="text" class="form-control" placeholder="Distrito" name="district" id="district" required>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="find_address_on_map">
                    <label class="form-check-label" for="find_address_on_map">
                        Seguir Morada no Mapa
                    </label>
                </div>
            </div>
        </div>
        <div id="map"></div>
        <input type="hidden" id="lat" name="lat">
        <input type="hidden" id="long" name="long">
        <h3>Horários</h3>
        <div id="schedules">
        </div>
        <div class="row">
            <div class="form-group col-3">
                <a href="#0" class="btn btn-success" onclick="addSchedule()">Adicionar Novo Horário</a>
            </div>
        </div>
        <h3>Contactos Pessoais</h3>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Nome" name="firstname" required>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Apelido" name="lastname" required>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Telefone" name="contact" required>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Email" name="email" required>
        </div>
        <button type="submit" class="btn btn-primary">Submeter</button>
    </form>
</div>
@endsection

@section('script')
<script type="template/schedule" id="schedule_template">
    <div class="schedule">
        <div class="row">
            <div class="form-group col-6">
                <label>Hora de Abertura</label>
                <input type="time" class="form-control" name="start_hour[]" min="00:00" max="23:59" required>
            </div>
            <div class="form-group col-6">
                <label>Hora de Fecho</label>
                <input type="time" class="form-control" name="end_hour[]" min="00:00" max="23:59" required>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-6">
                <label>Altura do Dia</label>
                <select class="form-control" name="section_of_day[]" required>
                    <option value="0">Manhã</option>
                    <option value="1">Tarde</option>
                    <option value="2">Dia Completo</option>
                </select>
            </div>
            <div class="form-group col-6">
                <label>Tipo de Horário</label>
                <select class="form-control" name="type[]" required>
                    <option value="0">Forças de Segurança, Entidades de Proteção Civil e Profissionais de Saúde
                    </option>
                    <option value="1">Idosos / Maiores de 65 anos / Grupo de Risco</option>
                    <option value="2">Público Geral</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" onclick="scheduleByAppointment(this)" value="true" name="by_appointment[]">
                    <input class='by_appointment_hidden' type='hidden' value="false" name='by_appointment[]'>
                    <label class="form-check-label">
                        Por Marcação
                    </label>
                </div>
            </div>
            <div class="form-group col-9 by_appointment_contacts" style="display:none;">
                <label>Contactos Para Marcações</label>
                <input type="text" class="form-control" name="by_appointment_contacts[]">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-9">
                <label>Dias (Pode Selecionar Múltiplos)</label>
                <select multiple class="form-control" name="days[]">
                    <option value="monday">Segunda-Feira</option>
                    <option value="tuesday">Terça-Feira</option>
                    <option value="wednesday">Quarta-Feira</option>
                    <option value="thrusday">Quinta-Feira</option>
                    <option value="friday">Sexta-Feira</option>
                    <option value="saturday">Sabádo</option>
                    <option value="sunday">Domingo</option>
                </select>
                <input type="hidden" name="days[]" value="seperator">
            </div>
            <div class="form-group col-3" style="margin-top: 5.25%;">
                <a href="#0" class="btn btn-danger" onclick="removeSchedule(this)">Remover Este Horário</a>
            </div>
        </div>
        <hr />
    </div>
</script>
<script src="https://api.mapbox.com/mapbox-gl-js/v1.9.0/mapbox-gl.js"></script>
<script>
    mapboxgl.accessToken = 'pk.eyJ1Ijoidm9zdHB0IiwiYSI6ImNrOGo5YnJtYTAzMDgzbG51dTE3dTUzdWEifQ.yphCGp76UE5W-mPWYQ9MsQ';
    var map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',
        center: [-7.8536599, 39.557191], // [lng, lat]
        zoom: 5.5
    });
    let marker = null;
    function zoomToNewLocation() {
        if($("#find_address_on_map").is(":checked")) {
            let address = $("#address").val();
            let parish = $("#parish").val();
            let county = $("#county").val();
            let district = $("#district").val();
            if(address != "" || parish != "" || county != "" || district != "") {
                if(parish != "") {
                    address += ", " + parish;
                }
                if(county != "") {
                    address += ", " + county;
                }
                if(district != "") {
                    address += ", " + district;
                }
                address += ", Portugal";
                $.get('https://nominatim.openstreetmap.org/search?format=json&q='+address, function(data){
                    if(data.length != 0) {
                        if($("#find_address_on_map").is(":checked")) {
                            map.setCenter([data[0].lon, data[0].lat,]);
                            map.setZoom(14);
                        }
                    }
                });
            }
        }
    }

    function addSchedule() {
        let template = $("#schedule_template").html();
        $("#schedules").append(template);
    }

    function scheduleByAppointment(obj) {
        if($(obj).is(":checked")) {
            $(obj).closest(".schedule").find(".by_appointment_contacts").show();
            $(obj).closest(".schedule").find(".by_appointment_hidden").prop("disabled", true);
        }
        else {
            $(obj).closest(".schedule").find(".by_appointment_hidden").prop("disabled", false);
            $(obj).closest(".schedule").find(".by_appointment_contacts").hide();

        }
    }

    function removeSchedule(obj) {
        $(obj).closest(".schedule").remove();
    }

    $(document).ready(function () {
        $("#address").change(zoomToNewLocation);
        $("#parish").change(zoomToNewLocation);
        $("#county").change(zoomToNewLocation);
        $("#district").change(zoomToNewLocation);
        addSchedule();
        map.on('click', function(e) {
            if(marker == null) {
                if(map.getZoom() > 14) {
                    var marker_element = document.createElement('div');
                    marker_element.className = 'marker';
                    marker = new mapboxgl.Marker(marker_element)
                            .setLngLat(e.lngLat)
                            .addTo(map);
                    $("#lat").val(e.lngLat.lat);
                    $("#long").val(e.lngLat.lng);
                }
            }
            else {
                marker.remove();
                marker = null;
                $("#lat").val("");
                $("#long").val("");
            }
        });
    });
</script>
@endsection