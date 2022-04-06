<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use DateTime;

class RequestResponseNotification extends Notification implements ShouldQueue
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
                    ->line("Thank you for considering ".$this->reservation->company->name." for your hospitality needs. We are at your service.")
                    ->line('We are happy to report that your requested '.$this->reservation->roomtype->name.' is available for the '.$this->reservation->days.' days you specified (i.e. '.date_format(new DateTime($this->reservation->check_in), 'l jS F Y').' - '.date_format(new DateTime($this->reservation->check_out), 'l jS F Y').') at a total rate of '.$this->reservation->currency.' '.number_format($this->reservation->price,2).' ( '.$this->reservation->currency.' '.number_format(($this->reservation->price / $this->reservation->days),2).' per night).')
                    ->line('In order to confirm your reservation, please make payment by clicking on the button below.')
                    ->action('Make Reservation Payment Now', route('paystack-payment-url',$this->reservation->id))
                    ->line('Please do not hesitate to reach out to us if you have any further inquiries or would like to give us information regarding your arrival and/or any special needs (such as allergies). The '.$this->reservation->company->name.' Team looks forward to hearing back from you and hosting you soon.')
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
