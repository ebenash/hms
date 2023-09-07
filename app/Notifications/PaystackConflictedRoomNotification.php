<?php

namespace App\Notifications;

use DateTime;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaystackConflictedRoomNotification extends Notification
{
    use Queueable;

    private $reservation;
    private $roombooked;
    private $reservation_detail;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($reservation,$roombooked)
    {
        //
        $this->reservation = $reservation;
        $this->roombooked = $roombooked;
        $this->reservation_detail = $reservation->details->first();
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
        ->subject('Urgent: Paystack Payment Confirmed Already Booked Room.')
        ->greeting('Hello Admin,')
        ->line('Please note that a recent paystack payment for Reservation #'.$this->reservation->id.' has confirmed the reservation even though another reservation (#'.$this->roombooked->id.') has the same room(s) booked.')
        ->line('Please review both reservations and assign one a different room if available.')
        ->line("Automated message from ".$this->reservation->company->name.".");
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
