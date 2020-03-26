<?php
declare(strict_types=1);

namespace App;

use App\Jobs\ProcessValidatedSubmission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Submission extends Model
{
    use SoftDeletes;

    protected $appends = ['image'];

    public static function createSubmission($firstname, $lastname, $contact, $email)
    {
        $submission            = new Submission();
        $submission->firstname = $firstname;
        $submission->lastname  = $lastname;
        $submission->contact   = $contact;
        $submission->email     = $email;
        $submission->confirmed = false;
        $submission->validated = false;
        $submission->save();
        return $submission;
    }

    public function entries()
    {
        return $this->hasMany(SubmissionEntry::class);
    }

    public function getImageAttribute()
    {
        $allowed_extensions = ['.jpg','.jpeg','.png'];
        $image_name = null;
        foreach ($allowed_extensions as $extension) {
            if(Storage::disk('public_submissions')->exists($this->id.$extension)) {
                $image_name = $this->id.$extension;
                break;
            }
        }        
        return $image_name;
    }

    public function addEntry($business_id, $store_name, $address, $parish, $county, $district, $postal_code, $lat, $long, $phone_number, $sector)
    {
        $submission_entry = SubmissionEntry::createSubmissionEntry($this->id, $business_id, $store_name, $address, $parish, $county, $district, $postal_code, $lat, $long, $phone_number, $sector);
        return $submission_entry;
    }

    public function updateFirstname($firstname)
    {
        $this->firstname = $firstname;
        $this->save();
    }

    public function updateLastname($lastname)
    {
        $this->lastname = $lastname;
        $this->save();
    }

    public function updateContact($contact)
    {
        $this->contact = $contact;
        $this->save();
    }

    public function updateEmail($email)
    {
        $this->email = $email;
        $this->save();
    }

    public function confirm()
    {
        if (! $this->confirmed) {
            $this->confirmed = true;
            $this->save();
            if ($this->validated) {
                ProcessValidatedSubmission::dispatch($this);
            }
        }
    }

    public function validate()
    {
        if (! $this->validated) {
            $this->validated = true;
            $this->save();
            if ($this->confirmed) {
                ProcessValidatedSubmission::dispatch($this);
            }
        }
    }
}
