<?php

namespace App\Notifications;

use App\User;
use App\Trip;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;

class TripReportsDriverNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $user;
    protected $trip;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, Trip $trip)
    {
        $this->user = $user;
        $this->trip = $trip;
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

    public function toDatabase($notifiable)
    {
        return [
          'notif_type' => 'Trip',
          'info' => $this->trip,
          'id' => $this->user->id,
          'name' => $this->user->first_name . ' ' . $this->user->middle_name . ' ' . $this->user->last_name,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
          'notif_type' => 'Trip',  
          'info' => $this->trip,
          'id' => $this->user->id,
          'name' => $this->user->first_name . ' ' . $this->user->middle_name . ' ' . $this->user->last_name,
        ]);
    }
}
