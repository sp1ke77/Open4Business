<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateNewUser;
use App\Http\Requests\DeleteUser;
use App\Http\Requests\UpdateUser;
use App\Http\Requests\ValidateUser;
use App\Notifications\SendUserCreationEmail;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index() {
        $users = User::all();
        return view('backoffice.users.index',["users" => $users]);
    }

    public function new() {
        return view('backoffice.users.form',["user" => null]);
    }

    public function edit($id) {
        $user = User::find($id);
        return view('backoffice.users.form',["user" => $user]);
    }

    public function create(CreateNewUser $request) {
        $validated = $request->validated();
        $password = Str::random(20);
        $user = null;
        if($validated["type"] == 0) {
            $user = User::createTeamUser($validated["name"],$validated["email"],$password);
        }
        else {
            $user = User::createBigCompanyUser($validated["name"],$validated["email"],$password);
        }
        $user->notify(new SendUserCreationEmail($user,$password));
        return redirect()->route('backoffice.users.index');
    }

    public function update(UpdateUser $request) {
        $validated = $request->validated();
        $user = User::find($validated["id"]);
        $user->updateInformation($validated["name"],$validated["email"]);
        if ($validated['password'] != null) {
            if (! $user->validatePassword($validated['password'])) {
                $user->updatePassword($validated['password']);
            }
        }
        if($user->type != $validated["type"]) {
            if($validated["type"] == 0) {
                $user->setTeamUser();
            }
            else {
                $user->setBigCompanyUser();
            }
        }
        return redirect()->route('backoffice.users.index');
    }

    public function delete(DeleteUser $request) {
        $validated = $request->validated();
        $user = User::find($validated["id"]);
        $user->delete();
        return redirect()->route('backoffice.users.index');
    }

    public function validate_token($validation_token) {
        return view('auth.validate_token',["validate_token" => $validation_token]);
    }

    public function validate(ValidateUser $request) {
        $validated = $request->validated();
        $user = User::find('validation_token',$validated["validation_token"]);
        $user->validate($validated["password"]);
        return redirect()->route('login');
    }
}
