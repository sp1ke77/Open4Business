@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="card">
        <div class="card-header">Businessess</div>

        <div class="card-body">
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif
            <h2>Businesses List</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Company</th>
                        <th scope="col">Store Name</th>
                        <th scope="col">Address</th>
                        <th scope="col">Parish</th>
                        <th scope="col">County</th>
                        <th scope="col">District</th>
                        <th scope="col">Postal Code</th>
                        <th scope="col">Coordinates</th>
                        <th scope="col">Phone Number</th>
                        <th scope="col">Sector</th>
                        <th scope="col">Name</th>
                        <th scope="col">Contact</th>
                        <th scope="col">Email</th>
                        <th scope="col">Schedules</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($businesses as $business)
                    <tr>
                        <th scope="row">{{$business->id}}</th>
                        <td>{{$business->company}}</td>
                        <td>{{$business->store_name}}</td>
                        <td>{{$business->address}}</td>
                        <td>{{$business->parish}}</td>
                        <td>{{$business->county}}</td>
                        <td>{{$business->district}}</td>
                        <td>{{$business->postal_code}}</td>
                        <td>{{$business->lat}},{{$business->long}}</td>
                        <td>{{$business->phone_number}}</td>
                        <td>{{$business->sector_string}}</td>
                        <td>{{$business->firstname . ' ' . $business->lastname}}</td>
                        <td>{{$business->contact}}</td>
                        <td>{{$business->email}}</td>
                        <td><a href="{{ route('backoffice.businesses.schedules', $business->id) }}">{{$business->schedules->count()}}
                                Schedules</a></td>
                        <td><a href="#" onclick="confirmDeletion({{$business->id}})">Delete</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <form id="confirmDeletion" style="display:none;" method="POST"
                action="{{route('backoffice.businesses.delete')}}">
                <hr />
                @csrf
                <p>Confirm the deletion of Business #<span id="confirmDeletionDisplay_id"></span></p>
                <input id="confirmDeletion_id" name="id" type="hidden">
                <a href="#" onclick="cancelDeletion()" class="btn btn-success">Cancel</a>
                <button type="submit" class="btn btn-danger">Confirm Deletion</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function confirmDeletion(id) {
        $("#confirmDeletionDisplay_id").html(id);
        $("#confirmDeletion_id").val(id);
        $("#confirmDeletion").show();
    }
    function cancelDeletion() {
        $("#confirmDeletion").hide();
        $("#confirmDeletionDisplay_id").html("");
        $("#confirmDeletion_id").val(null);
    }
</script>
@endsection