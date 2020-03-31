<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
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

    private static function createUser($name,$email,$password,$type) {
        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->type = $type;
        $user->validation_token = Str::random();
        $user->save();
        return $user;
    }

    public static function createTeamUser($name,$email,$password) {
        return User::createUser($name,$email,$password,0);
    }

    public static function createBigCompanyUser($name,$email,$password) {
        $user = User::createUser($name,$email,$password,1);
        $user->generateAPIKeyAndAPISecret();
        return $user;
    }

    public function isTeamUser() {
        return $this->type == 0;
    }

    public function isBigCompanyUser() {
        return $this->type == 1;
    }

    public function updateInformation($name,$email) {
        $this->name = $name;
        $this->email = $email;
        $this->save();
    }

    public function updateName($name) {
        $this->name = $name;
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
}
