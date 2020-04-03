@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Submissions</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <h2>Submissions List</h2>
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Contact</th>
                                <th scope="col">Email</th>
                                <th scope="col">Entries</th>
                                <th scope="col">Confirmed</th>
                                <th scope="col">Validated</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($submissions as $submission)
                                <tr>
                                    <th scope="row">{{$submission->id}}</th>
                                    <td>{{$submission->firstname . ' ' . $submission->lastname}}</td>
                                    <td>{{$submission->contact}}</td>
                                    <td>{{$submission->email}}</td>
                                    <td>
                                        <a href="{{ route('backoffice.submissions.entries', $submission->id) }}">{{$submission->entries->count()}}
                                            Entries</a></td>
                                    <td>{{$submission->confirmed?"Yes":"No"}}</td>
                                    <td>{{$submission->validated?"Yes":"No"}}</td>
                                    <td><a href="#" onclick="confirmValidation({{$submission->id}})">Validate</a>|<a
                                                href="#" onclick="confirmDeletion({{$submission->id}})">Delete</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <form id="confirmValidation" style="display:none;" method="POST"
                              action="{{route('backoffice.submissions.validate')}}">
                            <hr/>
                            @csrf
                            <p>Confirm the deletion of Submission #<span id="confirmValidationDisplay_id"></span></p>
                            <input id="confirmValidation_id" name="id" type="hidden">
                            <a href="#" onclick="cancelValidation()" class="btn btn-dange">Cancel</a>
                            <button type="submit" class="btn btn-success">Confirm Validation</button>
                        </form>
                        <form id="confirmDeletion" style="display:none;" method="POST"
                              action="{{route('backoffice.submissions.delete')}}">
                            <hr/>
                            @csrf
                            <p>Confirm the deletion of Submission #<span id="confirmDeletionDisplay_id"></span></p>
                            <input id="confirmDeletion_id" name="id" type="hidden">
                            <a href="#" onclick="cancelDeletion()" class="btn btn-success">Cancel</a>
                            <button type="submit" class="btn btn-danger">Confirm Deletion</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function confirmDeletion(id) {
            cancelValidation();
            $("#confirmDeletionDisplay_id").html(id);
            $("#confirmDeletion_id").val(id);
            $("#confirmDeletion").show();
        }

        function cancelDeletion() {
            $("#confirmDeletion").hide();
            $("#confirmDeletionDisplay_id").html("");
            $("#confirmDeletion_id").val(null);
        }

        function confirmValidation(id) {
            cancelDeletion();
            $("#confirmValidationDisplay_id").html(id);
            $("#confirmValidation_id").val(id);
            $("#confirmValidation").show();
        }

        function cancelValidation() {
            $("#confirmValidation").hide();
            $("#confirmValidationDisplay_id").html("");
            $("#confirmValidation_id").val(null);
        }
    </script>
@endsection