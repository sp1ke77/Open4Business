<?php
declare(strict_types=1);

namespace App\Jobs;

use App\Business;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\FileHelpers;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ProcessValidatedSubmission implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $submission;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($submission)
    {
        $this->submission = $submission;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->submission->entries as $entry) {
            if ($entry->business_id == null) {
                $business = Business::createBusiness($entry->company,$entry->store_name, $entry->address, $entry->parish, $entry->county, $entry->district, $entry->postal_code, $entry->lat, $entry->long, $entry->phone_number, $entry->sector, $this->submission->firstname, $this->submission->lastname, $this->submission->contact, $this->submission->email);
                $entry->updateBusiness($business->id);
            } else {
                $entry->business->removeSchedules();
                $entry->business->updateContactInformation($this->submission->firstname, $this->submission->lastname, $this->submission->contact, $this->submission->email);
                $entry->business->updateStoreInformation($entry->company,$entry->store_name, $entry->address, $entry->parish, $entry->county, $entry->district, $entry->postal_code, $entry->lat, $entry->long, $entry->phone_number, $entry->sector);
            }
            foreach ($entry->schedules as $schedule) {
                $entry->business->addSchedule($schedule->start_hour, $schedule->end_hour, $schedule->sunday, $schedule->monday, $schedule->tuesday, $schedule->wednesday, $schedule->thrusday, $schedule->friday, $schedule->saturday, $schedule->type, $schedule->section_of_day);
            }
            $img_file = Storage::disk('public_submissions')->get($this->submission->image);
            $img_file_extension = \pathinfo($this->submission->image, PATHINFO_EXTENSION);
            Storage::disk('public_businesses')->put($entry->business_id.'.'.$img_file_extension, $img_file); 
        }
    }
}
