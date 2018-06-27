<?php

namespace App\Notifications;
use App\VanRental;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
class RentalOneDayBeforeNotification extends Notification
{
    use Queueable;

    protected $rental;
    protected $departure_date;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($rental, $departure_date)
    {
        $this->rental = $rental;
        $this->departure_date = $departure_date;
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
          'notif_type' => 'One Day Rental Notice',
          'info' => $this->rental,
          'date' => $this->departure_date,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
          'notif_type' => 'One Day Rental Notice',
          'info' => $this->rental,
          'date' => $this->departure_date,
        ]);
    }
}
