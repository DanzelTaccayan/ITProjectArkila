<?php

namespace App\Notifications;

use Carbon\Carbon;
use App\User;
use App\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
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
        $message = null;
        $reservedate = Carbon::parse($this->reserve->reservationDate->reservation_date);
        $dateHuman = $reservedate->formatLocalized('%B %d,  %Y');
        $url = url('/home/transactions/reservation');
        //dd($dateHuman);
        if($this->case == 'Paid'){
            $message = 'You have successfully paid your reservation for ' . $this->reserve->destination_name .' on ' . $dateHuman. '.'.PHP_EOL;
            
        }else if($this->case == 'Expired'){
            $message = 'Your reservation slot for ' . $this->reserve->destination_name .' has expired because you have not paid on or before ' . $this->reserve->expiry_date . '.'.PHP_EOL;
            $message .= 'Please pay on time to avoid your reservation from being removed.'.PHP_EOL;
        }else if($this->case == 'Refunded'){
            $message = 'We noticed you initiated a refund for your supposed trip to ' . $this->reserve->destination_name . ' on ' .$dateHuman. '.'.PHP_EOL;
            $message .= 'The total refunded amount is ' . $this->reserve->fare . '.'.PHP_EOL;
            $message .= 'We apologize for any inconvenience this refund may have caused you.'.PHP_EOL;  
        }else if($this->case == 'Departed'){
            $message = 'Have a safe trip to ' . $this->reserve->destination_name . '.'.PHP_EOL;
        }
        //dd($this->case);
        return (new MailMessage)
                ->line($message)
                ->action('View Transaction',$url)
                ->line('We hope you enjoy our services. Thank You!');
        
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
