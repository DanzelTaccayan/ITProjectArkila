<?php

namespace App\Notifications;

use App\User;
use App\VanRental;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;

class OnlineRentalAdminNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $user;
    protected $rent;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, VanRental $rent)
    {
        $this->user = $user;
        $this->rent = $rent;
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
          'notif_type' => 'rental',
          'rental_info' => $this->rent,
          'user_id' => $this->user->id,
          'name' => $this->user->first_name . ' ' . $this->user->middle_name . ' ' . $this->user->last_name,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
          'notif_type' => 'rental',  
          'rental_info' => $this->rent,
          'user_id' => $this->user->id,
          'name' => $this->user->first_name . ' ' . $this->user->middle_name . ' ' . $this->user->last_name,
        ]);
    }
}
