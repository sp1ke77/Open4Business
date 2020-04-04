<?php

namespace App\Http\Controllers\Backoffice\Submissions;

use App\Http\Controllers\Controller;
use App\SubmissionEntry;
use App\SubmissionEntrySchedule;
use Illuminate\Http\Request;

class SchedulesController extends Controller
{
    public function edit(SubmissionEntry $entry, SubmissionEntrySchedule $schedule)
    {
        return response()->view('backoffice.submissions.schedules.edit', ['schedule' => $schedule]);
    }

    public function update(SubmissionEntry $entry, SubmissionEntrySchedule $schedule, Request $request)
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

        return redirect()->route('backoffice.submissions.schedules', [$entry->id]);
    }
}