<?php

namespace App\Http\Controllers\Backoffice;

use App\Business;
use App\BusinessSchedule;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteBusiness;
use App\Http\Requests\DeleteBusinessSchedule;
use Illuminate\Http\Request;

class BusinessesController extends Controller
{
    public function index() {
        $businesses = Business::all();
        return view('backoffice.businesses.index',["businesses" => $businesses]);
    }

    public function schedules($id) {
        $business = Business::find($id);
        return view('backoffice.businesses.schedules',["business" => $business]);
    }

    public function delete(DeleteBusiness $request) {
        $validated = $request->validated();
        $business = Business::find($validated["id"]);
        $business->delete();
        return redirect()->route('backoffice.businesses.index');
    }

    public function schedules_delete(DeleteBusinessSchedule $request) {
        $validated = $request->validated();
        $business_schedule = BusinessSchedule::find($validated["id"]);
        $business_id = $business_schedule->business->id;
        $business_schedule->delete();
        return redirect()->route('backoffice.businesses.schedules',$business_id);
    }
}
