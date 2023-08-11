<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FeedbackNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $reported_by;
    public $feedback;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($reported_by,$feedback)
    {
        //
        $this->reported_by = $reported_by;
        $this->feedback = $feedback;
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
        return (new MailMessage)
                    ->subject('New Feedback Submitted From Front Desk.')
                    ->greeting('Hello!')
                    ->line("A New Feedback has been submitted on from the Royal Elmount Front Desk!")
                    ->line('Reported By: '.$this->reported_by ?? null)
                    ->line('Feedback: '.$this->feedback ?? null)
                    ->line('Automated message from Royal Elmount Hotel.');
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
