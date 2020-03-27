<?php

namespace App\Http\Controllers\Backoffice;

use App\Business;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    public function index() {
        $businesses = Business::all();
        return view('backoffice.users.index',["businesses" => $businesses]);
    }
}
