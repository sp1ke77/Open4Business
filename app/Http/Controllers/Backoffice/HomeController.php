<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index() {
        return view('backoffice.index');
    }

    public function updatePassword(UpdatePassword $request) {
        $validated = $request->validate();
        Auth::user()->updatePassword($validated["new_password"]);
        Auth::logout();
        return redirect()->route('login');
    }
}
