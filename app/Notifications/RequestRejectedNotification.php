<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use DateTime;

class RequestRejectedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $reservation;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($reservation)
    {
        //
        $this->reservation = $reservation;
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
                    ->subject('Reservation Request Response From '.$this->reservation->company->name.'.')
                    ->greeting('Hello '.($this->reservation->guest->full_name ?? $this->reservation->guest->email).',')
                    ->line("Thank you for considering ".$this->reservation->company->name." for your hospitality needs. ")
                    ->line('We regret to report that your requested '.$this->reservation->roomtype->name.' is unavailable for the '.$this->reservation->days.' days you specified (i.e. '.date_format(new DateTime($this->reservation->check_in), 'l jS F Y').' - '.date_format(new DateTime($this->reservation->check_out), 'l jS F Y').')')
                    ->line('If you would like to submit another request with different dates, please click on the button below.')
                    ->action('Book Now', route('home.reservation'))
                    ->line('Please do not hesitate to reach out to us if you have any further inquiries.')
                    ->line(' ')
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
