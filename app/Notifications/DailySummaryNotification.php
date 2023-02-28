<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class DailySummaryNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $summary;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($summary)
    {
        //
        $this->summary = $summary;
        // dd($this->summary->sent_messages);
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
            ->subject('Summary Report for '.date("jS F, Y",strtotime("-1 day")))
            ->greeting('Royal Elmount Hotel Summary Of Reservations On '.date("jS F, Y"/*,strtotime("-1 day")*/))
            ->line(new HtmlString('<br/>'))
            ->line(new HtmlString('<h3>SUMMARY OF RESERVATIONS YESTERDAY</h3>'))
            ->line(new HtmlString('<table border="2px"><tbody><tr><td>#</td><td><strong>Guest</strong></td><td><strong>Rooms</strong></td><td><strong>Days</strong></td><td><strong>Payment</strong></td><td><strong>Income</strong></td><td><strong>Received</strong></td><td><strong>Balance</strong></td><td><strong>Invoice</strong></td></tr>'.$this->summary->yesterdays_res_body.'</tbody></table>'))
            ->line(new HtmlString('Total:<strong>'.$this->summary->yesterdays_res_count.'</strong>'))
            ->line(new HtmlString('<br/>'))
            ->line(new HtmlString('<h3>SUMMARY OF RESERVATION ROOMS YESTERDAY</h3>'))
            ->line(new HtmlString('<table border="2px"><tbody><tr><td>#</td><td><strong>Guest</strong></td><td><strong>Room Type</strong></td><td><strong>Room</strong></td><td><strong>Income</strong></td></tr>'.$this->summary->yesterdays_detail_body.'</tbody></table>'))
            ->line(new HtmlString('Total:<strong>'.$this->summary->yesterdays_detail_count.'</strong>'))
            ->line(new HtmlString('<br/>'))

            ->line(new HtmlString('<h3>SUMMARY OF RESERVATIONS STAYING OVER TODAY</h3>'))
            ->line(new HtmlString('<table border="2px"><tbody><tr><td>#</td><td><strong>Guest</strong></td><td><strong>Rooms</strong></td><td><strong>Check-in</strong></td><td><strong>Check-out</strong></td><td><strong>Received</strong></td><td><strong>Balance</strong></td></tr>'.$this->summary->stay_over_res_body.'</tbody></table>'))
            ->line(new HtmlString('Total:<strong>'.$this->summary->stay_over_res_count.'</strong>'))
            ->line(new HtmlString('<br/>'))
            ->line(new HtmlString('<h3>SUMMARY OF RESERVATION ROOMS STAYING OVER TODAY</h3>'))
            ->line(new HtmlString('<table border="2px"><tbody><tr><td>#</td><td><strong>Guest</strong></td><td><strong>Room Type</strong></td><td><strong>Room</strong></td><td><strong>Check-in</strong></td><td><strong>Check-out</strong></td></tr>'.$this->summary->stay_over_detail_body.'</tbody></table>'))
            ->line(new HtmlString('Total:<strong>'.$this->summary->stay_over_detail_count.'</strong>'))
            ->line(new HtmlString('<br/>'))

            ->line(new HtmlString('<h3>SUMMARY OF RESERVATIONS CHECKING IN TODAY</h3>'))
            ->line(new HtmlString('<table border="2px"><tbody><tr><td>#</td><td><strong>Guest</strong></td><td><strong>Rooms</strong></td><td><strong>Check-in</strong></td><td><strong>Check-out</strong></td><td><strong>Payment</strong></td><td><strong>Income</strong></td><td><strong>Received</strong></td><td><strong>Balance</strong></td></tr>'.$this->summary->checking_in_res_body.'</tbody></table>'))
            ->line(new HtmlString('Total:<strong>'.$this->summary->checking_in_res_count.'</strong>'))
            ->line(new HtmlString('<br/>'))
            ->line(new HtmlString('<h3>SUMMARY OF RESERVATION ROOMS CHECKING IN TODAY</h3>'))
            ->line(new HtmlString('<table border="2px"><tbody><tr><td>#</td><td><strong>Guest</strong></td><td><strong>Room Type</strong></td><td><strong>Room</strong></td><td><strong>Check-in</strong></td><td><strong>Check-out</strong></td><td><strong>Income</strong></td></tr>'.$this->summary->checking_in_detail_body.'</tbody></table>'))
            ->line(new HtmlString('Total:<strong>'.$this->summary->checking_in_detail_count.'</strong>'))
            ->line(new HtmlString('<br/>'))

            ->line(new HtmlString('<h3>SUMMARY OF RESERVATIONS CHECKING OUT TODAY</h3>'))
            ->line(new HtmlString('<table border="2px"><tbody><tr><td>#</td><td><strong>Guest</strong></td><td><strong>Rooms</strong></td><td><strong>Check-in</strong></td><td><strong>Check-out</strong></td><td><strong>Payment</strong></td><td><strong>Income</strong></td><td><strong>Received</strong></td><td><strong>Balance</strong></td></tr>'.$this->summary->checking_out_res_body.'</tbody></table>'))
            ->line(new HtmlString('Total:<strong>'.$this->summary->checking_out_res_count.'</strong>'))
            ->line(new HtmlString('<br/>'))
            ->line(new HtmlString('<h3>SUMMARY OF RESERVATION ROOMS CHECKING OUT TODAY</h3>'))
            ->line(new HtmlString('<table border="2px"><tbody><tr><td>#</td><td><strong>Guest</strong></td><td><strong>Room Type</strong></td><td><strong>Room</strong></td><td><strong>Check-in</strong></td><td><strong>Check-out</strong></td><td><strong>Income</strong></td></tr>'.$this->summary->checking_out_detail_body.'</tbody></table>'))
            ->line(new HtmlString('Total:<strong>'.$this->summary->checking_out_detail_count.'</strong>'))
            ->line(new HtmlString('<br/>'))

            ->line('Automated message from Reservation Management System.');
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
