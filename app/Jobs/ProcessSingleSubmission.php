<?php

namespace App\Jobs;

use App\Business;
use App\Submission;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Storage;

class ProcessSingleSubmission implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $firstname; 
    private $lastname;
    private $contact;
    private $email;
    private $business_id;
    private $company;
    private $store_name;
    private $address;
    private $parish; 
    private $county;
    private $district; 
    private $postal_code;
    private $lat;
    private $long;
    private $phone_number;
    private $sector;
    private $schedules;
    private $img_file;
    private $img_file_extension;
    private $submission = null;
    private $auto_validation = false;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($firstname,$lastname,$contact,$email, $business_id,$company, $store_name, $address, $parish, $county, $district, $postal_code, $lat, $long, $phone_number, $sector, $schedules, $img_file = null, $img_file_extension = null, $submission = null, $auto_validation = false)
    {
        /** SCHEDULES
         * - start_hour
         * - end_hour
         * - type
         * - section_of_day
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
        $this->business_id = $business_id;
        $this->company = $company;
        $this->store_name = $store_name;
        $this->address = $address;
        $this->parish = $parish;
        $this->county = $county;
        $this->district = $district;
        $this->postal_code = $postal_code;
        $this->lat = $lat;
        $this->long = $long;
        $this->phone_number = $phone_number;
        $this->sector = $sector;
        $this->schedules = $schedules;
        $this->img_file = $img_file;
        $this->img_file_extension = $img_file_extension;
        $this->submission = $submission;
        $this->auto_validation = $auto_validation;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {       
        if ($this->submission == null) {
            $this->submission = Submission::createSubmission($this->firstname, $this->lastname, $this->contact, $this->email);
            if ($this->img_file != null) {
                Storage::disk('public_submission')->put($this->submission->id.'.'.$this->img_file_extension, $this->img_file);
            }
        }

        if ($this->business_id == null) {
            $businesses = Business::findBusinesses($this->lat, $this->long, $this->store_name);
            if ($businesses->count() != 0) {
                $this->business_id = $businesses->first()->id;
            }
        }

        $entry = $this->submission->addEntry($this->business_id,$this->company, $this->store_name, $this->address, $this->parish, $this->county, $this->district, $this->postal_code, $this->lat, $this->long, $this->phone_number, $this->sector);
        foreach ($this->schedules as $schedule) {
            $entry->addSchedule($schedule['start_hour'],$schedule['end_hour'],$schedule['sunday'],$schedule['monday'],$schedule['tuesday'],$schedule['wednesday'],$schedule['thrusday'],$schedule['friday'],$schedule['saturday'],$schedule['type'],$schedule['section_of_day']);
        }
        if($this->auto_validation) {
            $this->submission->validate();
        }
    }
}
