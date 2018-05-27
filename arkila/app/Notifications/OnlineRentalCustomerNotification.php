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
            $message = 'The rental for ' . $this->rent->destination .' on' .$dateHuman. 'that you have requested have been accepted. Payment for rental should be paid 48 hours from now'.PHP_EOL;
            $message .= ''.PHP_EOL;
        }else if($rent->status == 'NoVanAvailable'){
            $message = 'There are no available vans for rental. We apologize for any inconvenience.'.PHP_EOL;
        }else if($rent->status == 'Departed'){
            $message = 'Have a safe trip to' . $this->rent->destination . '.' .PHP_EOL;
        }else if($rent->status == 'Refunded'){
             $message = 'We noticed you initiated a refund for your supposed trip to ' . $this->rent->destination. ' on ' .$dateHuman. '.'.PHP_EOL;
            $message .= 'The total refunded amount is ' . $this->rent->fare . '.'.PHP_EOL;
            $message .= 'We apologize for any inconvenience this refund may have caused you.'.PHP_EOL;
        }else if($rent->status == 'Paid'){
            $message = 'You have successfully paid your rental for ' . $this->rent->destination .' on ' . $dateHuman. '.'.PHP_EOL;
        }else if($rent->status == 'Expired'){
            $message = 'Your rent slot for ' . $this->rent->destination .' has expired because you have not paid' .  $this->rent->fare . '48 hours before the departure date.' .PHP_EOL;
        }

        return (new MailMessage)
                ->line($message)
                ->action('View Transaction',$url)
                ->line('We hope you enjoy our services. Thank You!');
    }
}
