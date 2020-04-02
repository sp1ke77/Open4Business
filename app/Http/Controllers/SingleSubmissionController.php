<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ConfirmSubmission;
use App\Http\Requests\SubmitSingleSubmission;
use App\Jobs\ProcessSingleSubmission;
use App\Submission;
use Illuminate\Support\Facades\Auth;

class SingleSubmissionController extends Controller
{
    public function index()
    {
        return view('single_submission.form');
    }

    public function submit(SubmitSingleSubmission $request)
    {
        $validated = $request->validated();
        $user_id   = null;
        $user      = Auth::user();
        if ($user) {
            if ($user->isBigCompanyUser()) {
                $user_id = $user->id;
            }
        }
        //Create Schedules
        $schedules        = [];
        $separated_days   = [];
        $current_day      = 0;
        $separated_days[] = [
            'sunday'    => false,
            'monday'    => false,
            'tuesday'   => false,
            'wednesday' => false,
            'thrusday'  => false,
            'friday'    => false,
            'saturday'  => false,
        ];
        foreach ($validated['days'] as $day) {
            if ($day != 'separator') {
                $separated_days[$current_day][$day] = true;
            } else {
                $current_day++;
                $separated_days[] = [
                    'sunday'    => false,
                    'monday'    => false,
                    'tuesday'   => false,
                    'wednesday' => false,
                    'thrusday'  => false,
                    'friday'    => false,
                    'saturday'  => false,
                ];
            }
        }
        foreach ($validated['start_hour'] as $index => $start_hour) {
            $schedules[] = [
                'start_hour'              => $start_hour,
                'end_hour'                => $validated['end_hour'][$index],
                'type'                    => \intval($validated['type'][$index]),
                'section_of_day'          => \intval($validated['section_of_day'][$index]),
                'by_appointment'          => $validated['by_appointment'][$index],
                'by_appointment_contacts' => $validated['by_appointment_contacts'][$index],
                'section_of_day'          => \intval($validated['section_of_day'][$index]),
                'sunday'                  => $separated_days[$index]['sunday'],
                'monday'                  => $separated_days[$index]['monday'],
                'tuesday'                 => $separated_days[$index]['tuesday'],
                'wednesday'               => $separated_days[$index]['wednesday'],
                'thrusday'                => $separated_days[$index]['thrusday'],
                'friday'                  => $separated_days[$index]['friday'],
                'saturday'                => $separated_days[$index]['saturday'],
            ];
        }
        //Create Job
        ProcessSingleSubmission::dispatch($validated['firstname'], $validated['lastname'], $validated['contact'], $validated['email'], null, $validated['company'], $validated['store_name'], $validated['address'], $validated['parish'], $validated['county'], $validated['district'], $validated['postal_code'], $validated['lat'], $validated['long'], $validated['phone_number'], $validated['sector'], $schedules, $user_id);
        return redirect()->route('single_submission.index');
    }

    public function validate_token($validation_token)
    {
        return view('single_submission.validate_token', ['validation_token' => $validation_token]);
    }

    public function validation(ConfirmSubmission $request)
    {
        $validated  = $request->validated();
        $submission = Submission::where('validation_token', $validated['validation_token'])->get()->first();
        $submission->confirm();
        return redirect()->route('home');
    }
}
