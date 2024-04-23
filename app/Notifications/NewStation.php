<?php

namespace App\Notifications;

use App\Models\DessertStation;
use App\Models\UpdatePhase;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewStation extends Notification
{
    use Queueable;
    public $station;
    public $phase;

    /**
     * Create a new notification instance.
     */
    public function __construct($station , $phase)
    {
        $this->station = $station;
        $this->phase = $phase;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }
    public function toDatabase($notifiable)
    {
        return [
            'title' => 'New Follower',
            'body' => sprintf('%s One day left in the stage', $this->station->name ),
            'station_id' => $this->station->id,
//            'action' => url(route('user.station.show',$this->station->id))
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
