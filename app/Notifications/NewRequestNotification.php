<?php

namespace App\Notifications;

use DateTime;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewRequestNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $reservation;
    private $reservation_detail;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($reservation)
    {
        //
        $this->reservation = $reservation;
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
                    ->subject('New Reservation Request Submitted.')
                    ->greeting('Hello Admin!')
                    ->line("A New Reservation Request has been submitted on ".env('APP_NAME')."! Please find details below.")
                    ->line(" ")
                    ->line("Guest Name: ".$this->reservation->guest->full_name)
                    ->line("Requested Room Type: ".$this->reservation_detail->roomtype->name)
                    ->line("Check-In: ".date_format(new DateTime($this->reservation->check_in), 'l jS F, Y'))
                    ->line("Check-Out: ".date_format(new DateTime($this->reservation->check_out), 'l jS F, Y'))
                    ->line(" ")
                    ->line('Please verify and approve/reject. ')
                    ->line("Automated message from ".env('APP_NAME').".");
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
