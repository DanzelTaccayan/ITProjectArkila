<?php

namespace App\Notifications;

use Carbon\Carbon;
use App\User;
use App\VanRental;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OnlineRentalCustomerNotification extends Notification
{
    use Queueable;

    protected $userCustomer;
    protected $rent;
    protected $case;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, VanRental $rent, $case)
    {
        $this->user = $user;
        $this->rent = $rent;
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
        $rentaldate = Carbon::parse($this->rent->departure_date);
        $dateHuman = $rentaldate->formatLocalized('%B %d,  %Y');
        $url = url('/home/transactions/rental');

        if($rent->status == 'Accepted'){
            $message = ''.PHP_EOL;
        }else if($rent->status == 'Declined'){
            $message = ''.PHP_EOL;
        }else if($rent->status == 'Cancelled'){
            $message = ''.PHP_EOL;
        }else if($rent->status == 'Departed'){
            $message = ''.PHP_EOL;
        }else if($rent->status == 'Refunded'){
            $message = ''.PHP_EOL;
        }else if($rent->status == 'Paid'){
            $message = ''.PHP_EOL;
        }else if($rent->status == 'Expired'){
            $message = ''.PHP_EOL;
        }

        return (new MailMessage)
                ->line($message)
                ->action('View Transaction',$url)
                ->line('We hope you enjoy our services. Thank You!');
    }
}
