@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="card">
        <div class="card-header">Business Schedules</div>

        <div class="card-body">
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif
            <h2>Business #{{$business->id}} Schedules List</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Start Hour</th>
                        <th scope="col">End Hour</th>
                        <th scope="col">Open on Sundays</th>
                        <th scope="col">Open on Mondays</th>
                        <th scope="col">Open on Tuedays</th>
                        <th scope="col">Open on Wednesdays</th>
                        <th scope="col">Open on Thrusdays</th>
                        <th scope="col">Open on Fridays</th>
                        <th scope="col">Open on Saturdays</th>
                        <th scope="col">Type</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($business->schedules as $schedule)
                    <tr>
                        <th scope="row">{{$schedule->id}}</th>
                        <td>{{$schedule->start_hour}}</td>
                        <td>{{$schedule->end_hour}}</td>
                        <td>{{$schedule->sunday ? "Yes":"No"}}</td>
                        <td>{{$schedule->monday ? "Yes":"No"}}</td>
                        <td>{{$schedule->tuesday ? "Yes":"No"}}</td>
                        <td>{{$schedule->wednesday ? "Yes":"No"}}</td>
                        <td>{{$schedule->thrusday ? "Yes":"No"}}</td>
                        <td>{{$schedule->friday ? "Yes":"No"}}</td>
                        <td>{{$schedule->saturday ? "Yes":"No"}}</td>
                        <td>{{$schedule->type_string}}</td>
                        <td><a href="#" onclick="confirmDeletion({{$schedule->id}})">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <form id="confirmDeletion" style="display:none;" method="POST"
                action="{{route('backoffice.businesses.schedules.delete')}}">
                <hr />
                @csrf
                <p>Confirm the deletion of Business Schedule#<span id="confirmDeletionDisplay_id"></span></p>
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