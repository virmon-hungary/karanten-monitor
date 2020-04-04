<?php

namespace App\Listeners;

use App\Events\PatientRegistration;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PatientRegistrationNotification
{
    public function handle(PatientRegistration $event)
    {
        $event->patient->sendVerificationEmail();
    }
}
