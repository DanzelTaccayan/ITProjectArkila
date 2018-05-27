<?php

namespace App\Notifications;

use Carbon\Carbon;
use App\User;
use App\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OnlineReserveCustomerNotification extends Notification
{
    use Queueable;

    protected $userCustomer;
    protected $reserve;
    protected $case;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $userCustomer, Reservation $reserve, $case)
    {
        $this->userCustomer = $userCustomer;
        $this->reserve = $reserve;
        $this->case = $case;
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
        $reservedate = Carbon::parse($this->reserve->reservationDate->reservation_date);
        $dateHuman = $reservedate->formatLocalized('%B %d,  %Y');
        if($this->case == 'PAID'){
            return (new MailMessage)
                ->line('You have successfully paid your reservation for ' . $this->reserve->destination_name .' on ' . $dateHuman)
                ->line('We hope you enjoy our service. Thank You!');
        }else if($this->case == 'EXPIRED'){
            return (new MailMessage)
                ->line('Your reservation slot for ' . $this->reserve->destination_name .' has expired because you have not paid on or before ' . $this->reserve->expiry_date . '.')
                ->line('Please pay on time to avoid your reservation from being removed')
                ->action('Notification Action', url('/'))
                ->line('Thank you for using our application!');
        }else if($this->case == 'REFUNDED'){
            return (new MailMessage)
                ->line('The introduction to the notification.')
                ->action('Notification Action', url('/'))
                ->line('Thank you for using our application!');
        }else if($this->case == 'DEPARTED'){
            return (new MailMessage)
                ->line('Have a safe trip to ' . $this->reserve->destination_name)
                ->action('Notification Action', url('/'))
                ->line('We hope you enjoy our service. Thank You!');
        }
        
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
