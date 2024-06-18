<?php

namespace App\Notifications;

use App\Models\Follow;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewFollow extends Notification
{
    use Queueable;
    protected $follow;
    /**
     * Create a new notification instance.
     */
    public function __construct(Follow $follow)
    {
        $this->follow = $follow;
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
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'follower_id' => $this->follow->customer_id
        ];
    }
}
