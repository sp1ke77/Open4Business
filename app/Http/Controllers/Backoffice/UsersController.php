<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateNewUser;
use App\Http\Requests\DeleteUser;
use App\Http\Requests\UpdateUser;
use App\User;
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
        if($validated["type"] == 0) {
            User::createTeamUser($validated["name"],$validated["email"],$validated["password"]);
        }
        else {
            User::createBigCompanyUser($validated["name"],$validated["email"],$validated["password"]);
        }
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
}
