<?php
declare(strict_types=1);

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthorizeUser;
use App\Http\Requests\CreateNewUser;
use App\Http\Requests\DeleteUser;
use App\Http\Requests\RequestUser;
use App\Http\Requests\UpdateUser;
use App\Http\Requests\ValidateUser;
use App\Notifications\SendUserCreationEmail;
use App\User;
use Illuminate\Support\Str;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::where('authorized', true)->get();
        $users_not_authorized = User::where('authorized', false)->get();
        return view('backoffice.users.index', ['users' => $users, 'users_not_authorized' => $users_not_authorized]);
    }

    public function new()
    {
        return view('backoffice.users.form', ['user' => null]);
    }

    public function request_user_view()
    {
        return view('auth.register');
    }

    

    public function edit($id)
    {
        $user = User::find($id);
        return view('backoffice.users.form', ['user' => $user]);
    }

    public function create(CreateNewUser $request)
    {
        $validated = $request->validated();
        $password  = Str::random(20);
        $user      = null;
        if ($validated['type'] == 0) {
            $user = User::createTeamUser($validated['firstname'],$validated['lastname'],$validated['company'],$validated['position'],$validated['contact'], $validated['email'], $password);
        } else {
            $user = User::createBigCompanyUser($validated['firstname'],$validated['lastname'],$validated['company'],$validated['position'],$validated['contact'], $validated['email'], $password);
        }
        $user->notify(new SendUserCreationEmail($user));
        return redirect()->route('backoffice.users.index');
    }
    
    public function request_user(RequestUser $request)
    {
        $validated = $request->validated();
        $password  = Str::random(20);
        User::createBigCompanyUser($validated['firstname'],$validated['lastname'],$validated['company'],$validated['position'],$validated['contact'], $validated['email'], $password);
        return redirect()->route('home');
    }

    public function update(UpdateUser $request)
    {
        $validated = $request->validated();
        $user      = User::find($validated['id']);
        $user->updateInformation($validated['firstname'],$validated['lastname'],$validated['company'],$validated['position'],$validated['contact'], $validated['email']);
        if ($validated['password'] != null) {
            if (! $user->validatePassword($validated['password'])) {
                $user->updatePassword($validated['password']);
            }
        }
        if ($user->type != $validated['type']) {
            if ($validated['type'] == 0) {
                $user->setTeamUser();
            } else {
                $user->setBigCompanyUser();
            }
        }
        return redirect()->route('backoffice.users.index');
    }

    public function delete(DeleteUser $request)
    {
        $validated = $request->validated();
        $user      = User::find($validated['id']);
        $user->delete();
        return redirect()->route('backoffice.users.index');
    }

    public function validate_token($validation_token)
    {
        return view('auth.validate_token', ['validation_token' => $validation_token]);
    }

    public function validation(ValidateUser $request)
    {
        $validated = $request->validated();
        $user      = User::where('validation_token', $validated['validation_token'])->get()->first();
        $user->validate($validated['password']);
        return redirect()->route('login');
    }

    public function authorized(AuthorizeUser $request)
    {
        $validated = $request->validated();
        $user      = User::find($validated['id']);
        $user->authorized();
        $user->notify(new SendUserCreationEmail($user));
        return redirect()->route('backoffice.users.index');
    }
}
