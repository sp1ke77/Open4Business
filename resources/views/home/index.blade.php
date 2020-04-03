@extends('layouts.public')

@section('styles')
<link href="https://api.mapbox.com/mapbox-gl-js/v1.9.0/mapbox-gl.css" rel="stylesheet" />
<style>
    #map {
        width: 100%;
        height: 70rem;
    }

    .marker {
        background-image: url('/img/pin.png');
        background-size: cover;
        width: 42px;
        height: 52px;
        top: -25px;
        cursor: pointer;
        transition: none;
    }

    .mapboxgl-popup {
        font-family: Nunito, sans-serif;
        transition: none;
    }

    .mapboxgl-popup-content {
        transition: none;
        padding: 2vh 2vw 2vh 2vw;
        min-width: 19vw;
        box-shadow: 8px 8px 17px -6px #B9AFF0;
    }

    .mapboxgl-popup-content p {
        margin: 0;
    }

    .mapboxgl-popup-content h4 {
        margin-top: 2vh;
        font-weight: bold;
    }

    .mapboxgl-popup-content h6 {
        font-weight: bold;
    }

    .mapboxgl-popup-close-button {
        right: 0.5vw;
        top: 1vh;
        font-size: 80%;
        color: #909090;
    }

    .mapboxgl-popup-close-button:before {
        content: 'FECHAR ';
    }
</style>
@endsection

@section('content')
<div class="section--primary">
    <div class="container">
        <p class="lead">Informa aqui que a tua empresa e/ou negócio continua aberta e como é que
            <wbr />
                podemos usufruir dos produtos e serviços neste período excecional.
        </p>
            <div class="button__wrapper">
                <a href="{{ route('single_submission.index') }}" class="button button--secondary">Pequenas e médias
                    empresas</a>
                <a href="{{ route('mass_submission.index') }}" class="button button--secondary">Grandes empresas e
                    cadeias</a>
            </div>
    </div>
</div>
<div id="map"></div>
@endsection

@section('script')
<script type="template/marker" id="template_marker">
    <h4>{store_name}</h4>
    <p class="small">{sector_string}, {parish}</p>
    <p>Telf.: {phone_number}</p>
    <p>{address}</p>
    <p>{postal_code} {parish}</p>
    <br />
    {schedules}
    {schedules_by_appointment}
</script>
<script type="template/schedules" id="template_schedules">
    <p><b>{type_string}</b></p>
    {schedule_rows}
</script>
<script type="template/schedules" id="template_schedule_row">
    <div class="row">
        <div class="col-5">
            <p>{days}:</p>
        </div>
        <div class="col-7">
            <p>{hours}</p>
        </div>
    </div>
</script>
<script type="template/schedules" id="template_schedule_by_appointment_row">
    <div class="row">
        <div class="col-5">
            <p>{days}:</p>
        </div>
        <div class="col-7">
            <p>{hours}</p>
        </div>
    </div>
    <div class="row">
        <div class="col-5">
            <p>Contactos:</p>
        </div>
        <div class="col-7">
            <p>{contacts}</p>
        </div>
    </div>
</script>
<script src="https://api.mapbox.com/mapbox-gl-js/v1.9.0/mapbox-gl.js"></script>
<script>
    function getDayStringFromNumber(day) {
        switch (day) {
            case 0:
                return "Seg.";
            case 1:
                return "Ter.";
            case 2:
                return "Qua.";
            case 3:
                return "Qui.";    
            case 4:
                return "Sex.";    
            case 5:
                return "Sáb.";    
            case 6:
                return "Dom.";      
            default:
                break;
        }
    }
    function getDaysOpenString(schedule) {
        let days = [];
        days[0] = schedule.monday;
        days[1] = schedule.tuesday;
        days[2] = schedule.wednesday;
        days[3] = schedule.thrusday;
        days[4] = schedule.friday;
        days[5] = schedule.saturday;
        days[6] = schedule.sunday;
        console.log(days);
        let schedules = [];
        let found_first = false;
        let steps = 0;
        let current_schedule = 0;
        for (let i = 0; i < 7; i++) {
            if(days[i]) {
                if(found_first == false) {
                    found_first = true;       
                    steps = 0;
                    schedules[current_schedule] = getDayStringFromNumber(days[i]);           
                }
                else {
                    steps++;
                }
            } 
            else {
                if(found_first == true) {
                    if(steps == 1) {
                        schedules[current_schedule] += " e ";
                    }
                    else {
                        schedules[current_schedule] += " a ";
                    }
                    schedules[current_schedule] += getDayStringFromNumber(days[i-1]);
                    found_first = false;
                    steps = 0;
                    current_schedule++;
                } 
            }
        }
        if(found_first == true) {
            if(steps == 1) {
                schedules[current_schedule] += " e ";
            }
            else {
                 schedules[current_schedule] += " a ";
            }
            schedules[current_schedule] += getDayStringFromNumber(6);
        }
        return schedules;
    }

    mapboxgl.accessToken = 'pk.eyJ1Ijoidm9zdHB0IiwiYSI6ImNrOGo5YnJtYTAzMDgzbG51dTE3dTUzdWEifQ.yphCGp76UE5W-mPWYQ9MsQ';
    var map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11', 
        center: [-7.8536599, 39.557191], // [lng, lat]
        zoom: 7 
    });    
    $(document).ready(function () {
        $.getJSON( "/storage/businesses.json", function( data ) {
            data.forEach(element => {
                var marker_element = document.createElement('div');
                marker_element.className = 'marker';
                let schedules_html = "";
                let schedule_by_appointment_html = "";
                element.schedules.forEach(schedule => {
                    let schedule_rows = "";
                    let days = getDaysOpenString(schedule);
                    days.forEach(day => {
                        let formated_start_hour = schedule.start_hour.substring(0, schedule.start_hour.length - 3);;
                        let formated_end_hour = schedule.end_hour.substring(0, schedule.end_hour.length - 3);
                        let hours = formated_start_hour + " às " + formated_end_hour;
                        if(schedule.by_appointment) {
                            let template_schedule_by_appointment_row = $("#template_schedule_by_appointment_row").html();
                            template_schedule_by_appointment_row = template_schedule_by_appointment_row.split("{days}").join(day);
                            template_schedule_by_appointment_row = template_schedule_by_appointment_row.split("{hours}").join(hours);
                            template_schedule_by_appointment_row = template_schedule_by_appointment_row.split("{contacts}").join(schedule.by_appointment_contacts);
                            schedule_by_appointment_html += template_schedule_by_appointment_row; 
                        }
                        else {
                            let template_schedule_row = $("#template_schedule_row").html();
                            template_schedule_row = template_schedule_row.split("{days}").join(day);
                            template_schedule_row = template_schedule_row.split("{hours}").join(hours);
                            schedule_rows += template_schedule_row; 
                        }
                    });
                    if(schedule_rows != "") {
                        schedule_rows = "<h6>Horário de Funcionamento</h6>" + schedule_rows;
                    }
                    if(schedule_by_appointment_html != "") {
                        schedule_by_appointment_html = "<h6>Horários por Marcação</h6>" + schedule_by_appointment_rows;
                    }
                    schedules_html = $("#template_schedules").html();
                    schedules_html = schedules_html.split("{type_string}").join(schedule.type_string);
                    schedules_html = schedules_html.split("{schedule_rows}").join(schedule_rows);                  
                });                
                let template_html = $("#template_marker").html();
                template_html = template_html.split("{store_name}").join(element.store_name);
                template_html = template_html.split("{sector_string}").join(element.sector_string);
                template_html = template_html.split("{parish}").join(element.parish);
                template_html = template_html.split("{phone_number}").join(element.phone_number);
                template_html = template_html.split("{address}").join(element.address);
                template_html = template_html.split("{postal_code}").join(element.postal_code);
                template_html = template_html.split("{schedules}").join(schedules_html);
                template_html = template_html.split("{schedules_by_appointment}").join(schedule_by_appointment_html);
                new mapboxgl.Marker(marker_element)
                    .setLngLat([element.long,element.lat])
                    .setPopup(new mapboxgl.Popup({ offset: 25, maxWidth: "100vw" }) // add popups
                    .setHTML(template_html))
                    .addTo(map);
            });
        });
    });
</script>
@endsection