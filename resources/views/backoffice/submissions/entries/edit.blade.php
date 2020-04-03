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
                <h2>Editar Entry #{{$entry->id}}</h2>
                <form action="" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="company">Empresa</label>
                        <input class="form-control" type="text" name="company" id="company" readonly
                               value="{{ old('company', $entry->company) }}">
                    </div>
                    <div class="form-group">
                        <label for="store_name">Store Name</label>
                        <input class="form-control" type="text" name="store_name" id="store_name"
                               value="{{ old('store_name', $entry->store_name) }}">
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input class="form-control" type="text" name="address" id="address"
                               value="{{ old('address', $entry->address) }}">
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="parish">Parish</label>
                                <input class="form-control" type="text" name="parish" id="parish"
                                       value="{{ old('parish', $entry->parish) }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="county">County</label>
                                <input class="form-control" type="text" name="county" id="county"
                                       value="{{ old('county', $entry->county) }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="district">District</label>
                                <input class="form-control" type="text" name="district" id="district"
                                       value="{{ old('district', $entry->district) }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="postal_code">Postal Code</label>
                                <input class="form-control" type="text" name="postal_code" id="postal_code"
                                       value="{{ old('postal_code', $entry->postal_code) }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="lat">Latitude</label>
                                <input class="form-control" type="text" name="lat" id="lat"
                                       value="{{ old('lat', $entry->lat) }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="long">Longitude</label>
                                <input class="form-control" type="text" name="long" id="long"
                                       value="{{ old('long', $entry->long) }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="phone_number">Phone Number</label>
                        <input class="form-control" type="text" name="phone_number" id="phone_number"
                               value="{{ old('phone_number', $entry->phone_number) }}">
                    </div>
                    <div class="form-group">
                        <label for="sector">Sector</label>
                        <select name="sector" id="sector" class="form-control">
                            @foreach(\App\Business::sectorStrings() as $i => $string)
                                <option value="{{ $i }}" {{ old('sector', $entry->sector) == $i ? 'selected' : '' }}>{{ $string }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success push-right">Editar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection