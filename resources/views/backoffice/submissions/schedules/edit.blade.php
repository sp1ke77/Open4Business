@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">Submission Entry Schedules</div>

            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <h2>Editar Horário #{{$schedule->id}}</h2>
                <form action="" method="post">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="start_hour">Hora de Inicio</label>
                                <input class="form-control" type="text" name="start_hour" id="start_hour"
                                       value="{{ old('start_hour', $schedule->start_hour) }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="end_hour">Hora de Fecho</label>
                                <input class="form-control" type="text" name="end_hour" id="end_hour"
                                       value="{{ old('end_hour', $schedule->end_hour) }}">
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center text-center">
                        <div class="col">
                            Sunday<br>
                            <input type="hidden" name="sunday" value="0">
                            <input type="checkbox" name="sunday" id="sunday" {{ $schedule->sunday ? 'checked' : ''}} value="1">
                        </div>
                        <div class="col">
                            Monday<br>
                            <input type="hidden" name="monday" value="0">
                            <input type="checkbox" name="monday" id="monday" {{ $schedule->monday ? 'checked' : ''}} value="1">
                        </div>
                        <div class="col">
                            Tuesday<br>
                            <input type="hidden" name="tuesday" value="0">
                            <input type="checkbox" name="tuesday" id="tuesday" {{ $schedule->tuesday ? 'checked' : ''}} value="1">
                        </div>
                        <div class="col">
                            Wednesday<br>
                            <input type="hidden" name="wednesday" value="0">
                            <input type="checkbox" name="wednesday" id="wednesday" {{ $schedule->wednesday ? 'checked' : ''}} value="1">
                        </div>
                        <div class="col">
                            Thursday<br>
                            <input type="hidden" name="thrusday" value="0">
                            <input type="checkbox" name="thrusday" id="thrusday" {{ $schedule->thrusday ? 'checked' : ''}} value="1">
                        </div>
                        <div class="col">
                            Friday<br>
                            <input type="hidden" name="friday" value="0">
                            <input type="checkbox" name="friday" id="friday" {{ $schedule->friday ? 'checked' : ''}} value="1">
                        </div>
                        <div class="col">
                            Saturday<br>
                            <input type="hidden" name="saturday" value="0">
                            <input type="checkbox" name="saturday" id="saturday" {{ $schedule->saturday ? 'checked' : ''}} value="1">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sector">Type</label>
                        <select name="type" id="type" class="form-control">
                            @foreach(\App\BusinessSchedule::typeStrings() as $i => $string)
                                <option value="{{ $i }}" {{ old('type', $schedule->type) == $i ? 'selected' : '' }}>{{ $string }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success push-right">Guardar Alterações</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection