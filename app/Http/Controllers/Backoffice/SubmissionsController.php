<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteSubmission;
use App\Http\Requests\DeleteSubmissionEntry;
use App\Http\Requests\DeleteSubmissionEntrySchedule;
use App\Http\Requests\ValidateSubmission;
use App\Submission;
use App\SubmissionEntry;
use App\SubmissionEntrySchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubmissionsController extends Controller
{
    private $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }

    public function index()
    {
        if (Auth::user()->isBigCompanyUser()) {
            $submissions = Submission::where('user_id', Auth::user()->id)
                                     ->where(function ($q) {
                                         $q->where('validated', '=', '0')
                                           ->orWhere('confirmed', '=', '0');
                                     })->get();
        } else {
            $submissions = Submission::open();
        }

        return view('backoffice.submissions.index', ["submissions" => $submissions]);
    }

    public function entries($id)
    {
        $submission = Submission::find($id);

        return view('backoffice.submissions.entries', ["submission" => $submission]);
    }

    public function schedules($id)
    {
        $entry = SubmissionEntry::find($id);

        return view('backoffice.submissions.schedules', ["entry" => $entry]);
    }

    public function validation(ValidateSubmission $request)
    {
        $validated  = $request->validated();
        $submission = Submission::find($validated["id"]);
        $submission->validate();

        return redirect()->route('backoffice.submissions.index');
    }

    public function edit(Submission $submission, SubmissionEntry $entry)
    {
        return response()->view('backoffice.submissions.entries.edit',
            ['entry' => $entry, 'submission' => $submission]);
    }

    public function update(Submission $submission, SubmissionEntry $entry, Request $request)
    {
        $validated_data = $request->validate([
            'company'      => 'required',
            'store_name'   => 'required',
            'address'      => 'required',
            'county'       => 'required',
            'district'     => 'required',
            'parish'       => 'required',
            'postal_code'  => 'required',
            'lat'          => 'required',
            'long'         => 'required',
            'phone_number' => 'required',
            'sector'       => 'required',
        ]);

        $entry->update($validated_data);

        return redirect()->route('backoffice.submissions.entries', [$submission->id]);
    }

    public function delete(DeleteSubmission $request)
    {
        $validated  = $request->validated();
        $submission = Submission::find($validated["id"]);
        $submission->delete();

        return redirect()->route('backoffice.submissions.index');
    }

    public function entries_delete(DeleteSubmissionEntry $request)
    {
        $validated        = $request->validated();
        $submission_entry = SubmissionEntry::find($validated["id"]);
        $submission_id    = $submission_entry->submission->id;
        $submission_entry->delete();

        return redirect()->route('backoffice.submissions.entries', $submission_id);
    }

    public function schedules_delete(DeleteSubmissionEntrySchedule $request)
    {
        $validated                 = $request->validated();
        $submission_entry_schedule = SubmissionEntrySchedule::find($validated["id"]);
        $entry_id                  = $submission_entry_schedule->entry->id;
        $submission_entry_schedule->delete();

        return redirect()->route('backoffice.submissions.schedules', $entry_id);
    }
}
