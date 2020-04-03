<?php

namespace App\Events;

use App\Patient;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PatientRegistration
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(Patient $patient)
    {
        $this->patient = $patient;
    }

}
