<?php

namespace App\Notifications;

use App\User;
use App\VanRental;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;

class OnlineRentalDriverNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $user;
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
        return ['database','broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toDatabase($notifiable)
    {
        return [
          'notif_type' => 'VanRentalDriver', 
          'info' => $this->rent,
          'id' => $this->user->id,
          'name' => $this->user->first_name . ' ' . $this->user->middle_name . ' ' . $this->user->last_name,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
          'notif_type' => 'VanRentalDriver',
          'info' => $this->rent,
          'id' => $this->user->id,
          'name' => $this->user->first_name . ' ' . $this->user->middle_name . ' ' . $this->user->last_name,
        ]);
    }
}
