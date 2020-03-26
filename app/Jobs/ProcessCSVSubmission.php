<?php
declare(strict_types=1);

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessCSVSubmission implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $firstname; 
    private $lastname;
    private $contact;
    private $email;
    private $csv_file;
    private $img_file;
    private $img_file_extension;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($firstname,$lastname,$contact,$email,$csv_file, $img_file, $img_file_extension)
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->contact = $contact;
        $this->email = $email;
        $this->csv_file           = $csv_file;
        $this->img_file           = $img_file;
        $this->img_file_extension = $img_file_extension;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $entries   = [
            [
                'business_id'  => null,
                'store_name'   => '',
                'store_name'   => '',
                'address'      => '',
                'parish'       => '',
                'county'       => '',
                'district'     => '',
                'postal_code'  => '',
                'lat'          => '',
                'long'         => '',
                'phone_number' => '',
                'sector'       => '',
                'schedules'    => [
                    [
                        "start_hour" => "HH:MM",
                        "end_hour" => "HH:MM",
                        "type" => 0,
                        "sunday" => true,
                        "monday" => true,
                        "tuesday" => true,
                        "wednesday" => true,
                        "thrusday" => true,
                        "friday" => true,
                        "saturday" => true
                    ],
                ],
            ],
        ];
        ProcessMassSubmission::dispatch($this->firstname, $this->lastname, $this->contact, $this->email, $entries, $this->img_file, $this->img_file_extension);
    }
}
