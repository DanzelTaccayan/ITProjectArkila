<?php

namespace App\Notifications;

use App\User;
use App\Rental;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CustomerRent extends Notification implements ShouldQueue
{
    use Queueable;

    protected $rent;
    protected $user;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, Rental $rent)
    {
        $this->rent = $rent;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
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
            'rent_info' => $this->rent,
            'user_id' => $this->user->id,
            'name' => $this->user->first_name . ' ' . $this->user->middle_name . ' ' . $this->user->last_name,
        ];
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
