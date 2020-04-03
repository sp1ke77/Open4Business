@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="card">
            <div class="card-header">Submission Entries</div>

            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <h2>Submission #{{$submission->id}} Entries List</h2>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Associated Business</th>
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
                        <th scope="col">Schedules</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($submission->entries as $entry)
                        <tr>
                            <th scope="row">{{$entry->id}}</th>
                            @if ($entry->business)
                                <td><a href="#">#{{$entry->business->id}} - {{$entry->business->store_name}}</a></td>
                            @else
                                <td>None</td>
                            @endif
                            <td>{{$entry->company}}</td>
                            <td>{{$entry->store_name}}</td>
                            <td>{{$entry->address}}</td>
                            <td>{{$entry->parish}}</td>
                            <td>{{$entry->county}}</td>
                            <td>{{$entry->district}}</td>
                            <td>{{$entry->postal_code}}</td>
                            <td>{{$entry->lat}},{{$entry->long}}</td>
                            <td>{{$entry->phone_number}}</td>
                            <td>{{$entry->sector_string}}</td>
                            <td>
                                <a href="{{ route('backoffice.submissions.schedules', $entry->id) }}">{{$entry->schedules->count()}}
                                    Schedules</a></td>
                            <td>
                                <a href="{{ route('backoffice.submissions.entries.edit', ['submission' => $submission, 'entry' => $entry]) }}">Editar</a>
                                | <a href="#" onclick="confirmDeletion({{$entry->id}})">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <form id="confirmDeletion" style="display:none;" method="POST"
                      action="{{route('backoffice.submissions.entries.delete')}}">
                    <hr/>
                    @csrf
                    <p>Confirm the deletion of Submission Entry #<span id="confirmDeletionDisplay_id"></span></p>
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