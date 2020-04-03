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
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form method="POST"
                        action="{{$user == null ? route('backoffice.users.create'):route('backoffice.users.update')}}">
                        @csrf
                        @if ($user != null)
                        <input id="user_id" name="id" type="hidden" value="{{$user->id}}">
                        @endif
                        <div class="form-group">
                            <label>Primeiro Nome</label>
                            <input type="text" class="form-control" name="firstname"
                                value="{{$user == null ? "":$user->firstname}}">
                        </div>
                        <div class="form-group">
                            <label>Último Nome</label>
                            <input type="text" class="form-control" name="lastname"
                                value="{{$user == null ? "":$user->lastname}}">
                        </div>
                        <div class="form-group">
                            <label>Empresa</label>
                            <input type="text" class="form-control" name="company"
                                value="{{$user == null ? "":$user->company}}">
                        </div>
                        <div class="form-group">
                            <label>Cargo</label>
                            <input type="text" class="form-control" name="position"
                                value="{{$user == null ? "":$user->company}}">
                        </div>
                        <div class="form-group">
                            <label>Contacto Telefónico</label>
                            <input type="text" class="form-control" name="contact"
                                value="{{$user == null ? "":$user->contact}}">
                        </div>
                        <div class="form-group">
                            <label for="user_email">Email address</label>
                            <input type="email" class="form-control" id="user_email" name="email"
                                value="{{$user == null ? "":$user->email}}">
                        </div>
                        @if ($user != null)
                        <div class="form-group">
                            <label for="user_password">Password</label>
                            <input type="password" class="form-control" id="user_password" name="password" value=""
                                placeholder="Leave empty to keep the same password">
                        </div>
                        @endif
                        <div class="form-group">
                            <label for="user_type">Type</label>
                            <select class="form-control" id="user_type" name="type"
                                value="{{$user == null ? 0:$user->type}}">
                                <option value="0">Team Member</option>
                                <option value="1">Big Company</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                    @if ($user != null)
                    @if ($user->authorized == false)
                    <form method="POST" action="{{route('backoffice.users.authorize')}}">
                        @csrf
                        <input id="user_id" name="id" type="hidden" value="{{$user->id}}">
                        <button type="submit" class="btn btn-success">Validate</button>
                    </form>
                    @endif
                    <form method="POST" action="{{route('backoffice.users.delete')}}">
                        @csrf
                        <input id="user_id" name="id" type="hidden" value="{{$user->id}}">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection