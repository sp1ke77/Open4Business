<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    use CanResetPassword;
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    private function generateAPIKeyAndAPISecret() {
        $this->api_key = Str::random(10);
        $this->api_secret = Str::random(60);
        $this->save();
    }

    private static function createUser($firstname,$lastname,$company,$position,$contact,$email,$password,$type) {
        $user = new User();
        $user->firstname = $firstname;
        $user->lastname = $lastname;
        $user->company = $company;
        $user->position = $position;
        $user->contact = $contact;
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->type = $type;
        $user->validation_token = Str::random();
        $user->save();
        return $user;
    }

    public static function createTeamUser($firstname,$lastname,$company,$position,$contact,$email,$password) {
        return User::createUser($firstname,$lastname,$company,$position,$contact,$email,$password,0);
    }

    public static function createBigCompanyUser($firstname,$lastname,$company,$position,$contact,$email,$password) {
        $user = User::createUser($firstname,$lastname,$company,$position,$contact,$email,$password,1);
        $user->generateAPIKeyAndAPISecret();
        return $user;
    }

    public function businesses() {
        return $this->hasMany(Business::class);
    }

    public function submissions() {
        return $this->hasMany(Submission::class);
    }

    public function isTeamUser() {
        return $this->type == 0;
    }

    public function isBigCompanyUser() {
        return $this->type == 1;
    }

    public function updateInformation($firstname,$lastname,$company,$position,$contact,$email) {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->company = $company;
        $this->position = $position;
        $this->contact = $contact;
        $this->email = $email;
        $this->save();
    }

    public function updateFirstName($firstname) {
        $this->firstname = $firstname;
        $this->save();
    }

    public function updateLastName($lastname) {
        $this->lastname = $lastname;
        $this->save();
    }

    public function updateCompany($company) {
        $this->company = $company;
        $this->save();
    }

    public function updatePosition($position) {
        $this->position = $position;
        $this->save();
    }

    public function updateContact($contact) {
        $this->contact = $contact;
        $this->save();
    }

    public function updateEmail($email) {
        $this->email = $email;
        $this->save();
    }

    public function updatePassword($password) {
        $this->password = Hash::make($password);
        $this->save();
    }

    public function validatePassword($password) {
        return Hash::check($password, $this->password);
    }
    
    public function setTeamUser() {
        $this->api_key = null;
        $this->api_secret = null;
        $this->type = 0;
        $this->save();
    }

    public function setBigCompanyUser() {
        $this->type = 1;
        $this->save();
        $this->generateAPIKeyAndAPISecret();
    }

    public function validate($password) {
        $this->password = Hash::make($password);
        $this->validation_token = null;
        $this->save();
    }

    public function authorize() {
        $this->authorized = true;
        $this->save();
    }
}
