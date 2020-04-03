<?php

namespace App;

use App\Notifications\PatientAccountVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;

class Patient extends Authenticatable
{
    use Notifiable;

    protected $guard = 'patient';

    protected $fillable = [
        'name', 'email', 'password', 'taj'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];


    public function sendVerificationEmail()
    {
        $this->notify(new PatientAccountVerifyEmail);
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function firstPasswordSave($password)
    {
        $this->fill([
            'email_verified_at' => Date::now(),
            'password' => Hash::make($password)
        ])->save();
    }

}
