<?php
declare(strict_types=1);

namespace App\Jobs;

use App\Business;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class GenerateBusinessListings implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $final_array = [];
        $businesses  = Business::all();
        foreach ($businesses as $business) {
            $schedules = [];
            foreach ($business->schedules as $schedule) {
                $schedules[] = [
                    'start_hour'  => $schedule->start_hour,
                    'end_hour'    => $schedule->end_hour,
                    'sunday'      => $schedule->sunday,
                    'monday'      => $schedule->monday,
                    'tuesday'     => $schedule->tuesday,
                    'wednesday'   => $schedule->wednesday,
                    'thrusday'    => $schedule->thrusday,
                    'friday'      => $schedule->friday,
                    'saturday'    => $schedule->saturday,
                    'type'        => $schedule->type,
                    'type_string' => $schedule->type_string,
                ];
            }
            $final_array[] = [
                'company'       => $business->company,
                'store_name'    => $business->store_name,
                'address'       => $business->address,
                'parish'        => $business->parish,
                'county'        => $business->county,
                'district'      => $business->district,
                'postal_code'   => $business->postal_code,
                'lat'           => $business->lat,
                'long'          => $business->long,
                'phone_number'  => $business->phone_number,
                'sector'        => $business->sector,
                'sector_string' => $business->sector_string,
                'image'         => $business->image,
                'schedules'     => $schedules,
            ];
        }
        Storage::disk('public')->put('businesses.json', \json_encode($final_array));
    }
}
