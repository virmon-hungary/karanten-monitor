<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class PatientAccountVerifyEmail extends Notification
{
    use Queueable;

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject(__('Account Verification'))
            ->line(__('Please click the button below to verify your account.'))
            ->action(__('Verify account'), $verificationUrl);
    }

    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'patient.firstLogin.login',
            Carbon::now()->addMinutes(Config::get('patient.registration.email.expire',60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmail()),
            ]
        );
    }
}
