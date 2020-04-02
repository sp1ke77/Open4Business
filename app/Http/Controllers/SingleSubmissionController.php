<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\SubmitSingleSubmission;
use App\Jobs\ProcessSingleSubmission;

class SingleSubmissionController extends Controller
{
    public function index()
    {
        return view('single_submission.form');
    }

    public function submit(SubmitSingleSubmission $request)
    {
        $validated = $request->validate();
        $schedules = [];
        $separated_days = [];
        $current_day = 0;
        $separated_days[] = [
            "sunday" => false,
            "monday" => false,
            "tuesday" => false,
            "wednesday" => false,
            "thrusday" => false,
            "friday" => false,
            "saturday" => false,
        ];
        foreach ($validated["days"] as $day) {
            if($day != "separator") {
                $separated_days[$current_day][$day] = true;
            }
            else {
                $current_day++;
                $separated_days[] = [
                    "sunday" => false,
                    "monday" => false,
                    "tuesday" => false,
                    "wednesday" => false,
                    "thrusday" => false,
                    "friday" => false,
                    "saturday" => false,
                ];
            }
        }
        foreach ($validated["start_hour"] as $index => $start_hour) {
            $schedules[] = [
                "start_hour"=> $start_hour,
                "end_hour"=> $validated["end_hour"][$index],
                "type"=> $validated["type"][$index],
                "section_of_day"=> $validated["section_of_day"][$index],
                "sunday" => $separated_days[$index]["sunday"],
                "monday" => $separated_days[$index]["monday"],
                "tuesday" => $separated_days[$index]["tuesday"],
                "wednesday" => $separated_days[$index]["wednesday"],
                "thrusday" => $separated_days[$index]["thrusday"],
                "friday" => $separated_days[$index]["friday"],
                "saturday" => $separated_days[$index]["saturday"],
            ];
        }
        ProcessSingleSubmission::dispatch($validated["firstname"],$validated["lastname"],$validated["contact"],$validated["email"], null ,$validated["company"], $validated["store_name"], $validated["address"], $validated["parish"], $validated["county"], $validated["district"], $validated["postal_code"], $validated["lat"], $validated["long"], $validated["phone_number"], $validated["sector"], $schedules);
    }
}
