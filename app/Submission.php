<?php
declare(strict_types=1);

namespace App;

use App\Jobs\ProcessValidatedSubmission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Submission extends Model
{
    use Notifiable;
    use SoftDeletes;

    protected $appends = ['image'];

    public static function createSubmission($firstname, $lastname, $contact, $email, $user_id = null)
    {
        $submission                   = new Submission();
        $submission->firstname        = $firstname;
        $submission->lastname         = $lastname;
        $submission->contact          = $contact;
        $submission->email            = $email;
        $submission->user_id          = $user_id;
        $submission->confirmed        = false;
        $submission->validated        = false;
        $submission->validation_token = Str::random();
        $submission->save();

        return $submission;
    }

    public static function open()
    {
        return Submission::where('validated', '=', '0')->orWhere('confirmed', '=', '0')->get();
    }

    public function entries()
    {
        return $this->hasMany(SubmissionEntry::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function getImageAttribute()
    {
        $allowed_extensions = ['.jpg', '.jpeg', '.png'];
        $image_name         = null;
        foreach ($allowed_extensions as $extension) {
            if (Storage::disk('public_submissions')->exists($this->id.$extension)) {
                $image_name = $this->id.$extension;
                break;
            }
        }

        return $image_name;
    }

    public function addEntry(
        $business_id,
        $company,
        $store_name,
        $address,
        $parish,
        $county,
        $district,
        $postal_code,
        $lat,
        $long,
        $phone_number,
        $sector
    ) {
        $submission_entry = SubmissionEntry::createSubmissionEntry($this->id, $business_id, $company, $store_name,
            $address, $parish, $county, $district, $postal_code, $lat, $long, $phone_number, $sector);

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
        if ( ! $this->confirmed) {
            $this->confirmed        = true;
            $this->validation_token = null;
            $this->save();
            if ($this->validated) {
                ProcessValidatedSubmission::dispatch($this);
            }
        }
    }

    public function validate()
    {
        if ( ! $this->validated) {
            $this->validated = true;
            $this->save();
            if ($this->confirmed) {
                ProcessValidatedSubmission::dispatch($this);
            }
        }
    }
}
