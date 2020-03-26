<?php

namespace App\Jobs;

use App\Submission;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Storage;

class ProcessMassSubmission implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $firstname; 
    private $lastname;
    private $contact;
    private $email;
    private $entries;
    private $img_file;
    private $img_file_extension;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($firstname,$lastname,$contact,$email,$entries,$img_file,$img_file_extension)
    {
        /** ENTRIES
         * - business_id
         * - store_name
         * - address
         * - parish
         * - county
         * - district
         * - postal_code
         * - lat
         * - long
         * - phone_number
         * - sector
         * - schedules
         */

        /** SCHEDULES
         * - start_hour
         * - end_hour
         * - type
         * - sunday
         * - monday
         * - tuesday
         * - wednesday
         * - thrusday
         * - friday
         * - saturday
         */  
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->contact = $contact;
        $this->email = $email;
        $this->entries = $entries;
        $this->img_file = $img_file;
        $this->img_file_extension = $img_file_extension;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $submission = Submission::createSubmission($this->firstname, $this->lastname, $this->contact, $this->email);
        Storage::disk('public_submission')->put($this->submission->id.'.'.$this->img_file_extension, $this->img_file);
        foreach ($this->entries as $entry) {
            ProcessSingleSubmission::dispatch(null,null,null,null,$entry->business_id, $entry->store_name, $entry->address, $entry->parish, $entry->county, $entry->district, $entry->postal_code, $entry->lat, $entry->long, $entry->phone_number, $entry->sector, $entry->schedules, null, null, $submission, true);
        }
    }
}
