@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Users</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <h2>Users List</h2>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Type</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <th scope="row">{{$user->id}}</th>
                                <td>{{$user->firstname}} {{$user->lastname}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->type == 0?"Team":"Big Company"}}</td>
                                <td><a href="{{route('backoffice.users.edit', $user->id)}}">Edit</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                <a href="{{route('backoffice.users.new')}}" class="btn btn-primary">Add New User</a>
                </div>
            </div>
            <div class="card">
                <div class="card-header">Pending Users</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <h2>Pending Users List</h2>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Company</th>
                                <th scope="col">Position</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users_not_authorized as $user)
                            <tr>
                                <th scope="row">{{$user->id}}</th>
                                <td>{{$user->firstname}} {{$user->lastname}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->company}}</td>
                                <td>{{$user->position}}</td>
                                <td><a href="{{route('backoffice.users.edit', $user->id)}}">View</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection