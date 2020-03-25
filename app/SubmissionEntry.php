<?php
declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubmissionEntry extends Model
{
    public static function createSubmissionEntry($business_id, $submission_id, $store_name, $address, $parish, $county, $district, $postal_code, $lat, $long, $phone_number, $sector)
    {
        if (\is_string($sector)) {
            $sector = Business::getSectorNumberFromString($sector);
        }
        $submission_entry                = new SubmissionEntry();
        $submission_entry->business_id   = $business_id;
        $submission_entry->submission_id = $submission_id;
        $submission_entry->store_name    = $store_name;
        $submission_entry->address       = $address;
        $submission_entry->parish        = $parish;
        $submission_entry->county        = $county;
        $submission_entry->district      = $district;
        $submission_entry->postal_code   = $postal_code;
        $submission_entry->lat           = $lat;
        $submission_entry->long          = $long;
        $submission_entry->phone_number  = $phone_number;
        $submission_entry->sector        = $sector;
        $submission_entry->save();
        return $submission_entry;
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }

    public function schedules() {
        return $this->hasMany(SubmissionEntrySchedule::class);
    }

    public function updateBusiness($business_id) {
        $this->business_id = $business_id;
    }

    public function updateStoreName($store_name)
    {
        $this->store_name = $store_name;
        $this->save();
    }

    public function updateAddress($address)
    {
        $this->address = $address;
        $this->save();
    }

    public function updateParish($parish)
    {
        $this->parish = $parish;
        $this->save();
    }

    public function updateCounty($county)
    {
        $this->county = $county;
        $this->save();
    }

    public function updateDistrict($district)
    {
        $this->district = $district;
        $this->save();
    }

    public function updatePostalCode($postal_code)
    {
        $this->postal_code = $postal_code;
        $this->save();
    }

    public function updateLatitute($lat)
    {
        $this->lat = $lat;
        $this->save();
    }

    public function updateLongitude($long)
    {
        $this->long = $long;
        $this->save();
    }

    public function updatePhoneNumber($phone_number)
    {
        $this->phone_number = $phone_number;
        $this->save();
    }

    public function updateSector($sector)
    {
        if (\is_string($sector)) {
            $sector = Business::getSectorNumberFromString($sector);
        }
        $this->sector = $sector;
        $this->save();
    }
}
