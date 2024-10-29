<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerifyRecruiterEmail extends Notification
{
    use Queueable;

    use Queueable;
    public $recruiter, $verify_token;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($recruiter, $verify_token)
    {
        $this->recruiter = $recruiter;
        $this->verify_token = $verify_token;
    }


    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $token = $this->verify_token;
        return (new MailMessage)
            ->subject('Verify Email')
            ->greeting('Hello ' . $this->recruiter->first_name . ' ' . $this->recruiter->last_name . ' !')
            ->line('You are receiving this email for verifying your email.')
            ->line('This verify email link will expire in 60 minutes.
            If you did not request to verify email, no further action is
            required.')
            ->action('Verify Email', url('/recruiter/verify/' . $token))
            ->line('Thank you !');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
