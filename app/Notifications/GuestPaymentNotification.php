<?php

namespace App\Notifications;

use DateTime;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GuestPaymentNotification extends Notification
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
        ->subject('Royal Elmount Hotel Reservation Confirmed.')
        ->greeting('Hello '.($this->reservation->guest->full_name ?? $this->reservation->guest->email).',')
        ->line('Thank you for confirming your reservation with Royal Elmount Hotel.')
        ->line('We have received your payment of GHS '.number_format($this->reservation->grand_total,2).', and have reserved your requested room(s) for the '.$this->reservation->days.' days you specified (i.e. '.date_format(new DateTime($this->reservation->check_in), 'l jS F Y').' - '.date_format(new DateTime($this->reservation->check_out), 'l jS F Y').').')
        ->line('Please do not hesitate to reach out to us if you have any inquiries or would like to give us information regarding your upcoming stay. The Royal Elmount Hotel Team looks forward to hosting you soon.');
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
