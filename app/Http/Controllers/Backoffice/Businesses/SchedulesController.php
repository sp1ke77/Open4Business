<?php

namespace App\Http\Controllers\Backoffice\Businesses;

use App\Business;
use App\BusinessSchedule;
use App\Http\Controllers\Controller;
use App\SubmissionEntry;
use App\SubmissionEntrySchedule;
use Illuminate\Http\Request;

class SchedulesController extends Controller
{
    public function edit(Business $business, BusinessSchedule $schedule)
    {
        return response()->view('backoffice.businesses.schedules.edit', ['schedule' => $schedule]);
    }

    public function update(Business $business, BusinessSchedule $schedule, Request $request)
    {
        $validated_data = $request->validate([
            'start_hour' => 'required',
            'end_hour'   => 'required',
            'sunday'     => 'required',
            'monday'     => 'required',
            'tuesday'    => 'required',
            'wednesday'  => 'required',
            'thrusday'   => 'required',
            'friday'     => 'required',
            'saturday'   => 'required',
            'type'       => 'required',
        ]);

        $schedule->update($validated_data);

        return redirect()->route('backoffice.businesses.schedules', [$business->id]);
    }
}