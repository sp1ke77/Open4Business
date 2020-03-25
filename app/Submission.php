<?php
declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Submission extends Model
{
    use SoftDeletes;

    public static function createSubmission($firstname,$lastname,$contact,$email) {
        $submission = new Submission();
        $submission->firstname = $firstname;
        $submission->lastname = $lastname;
        $submission->contact = $contact;
        $submission->email = $email;
        $submission->confirmed = false;
        $submission->validated = true;
        $submission->save();
        return $submission;
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
        }
    }

    public function validate()
    {
        if (! $this->validated) {
            //Trigger 'validated submission and merge it to a business or create a new business' job
            $this->validated = true;
            $this->save();
        }
    }
}
