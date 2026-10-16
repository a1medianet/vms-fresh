<?php

namespace App\Notifications;

use App\Models\Visitor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PendingCheckIn extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Visitor $visitor)
    {
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(__('Pending Check-In'))
            ->line(__('A visitor is pending check-in.'))
            ->line(__('Visitor: :name', ['name' => $this->visitor->full_name]))
            ->line(__('Arrival Date: :date', ['date' => $this->visitor->arrival_date->format('Y-m-d')]))
            ->action(__('View Visitor'), route('dashboard.visitors.show', $this->visitor));
    }

    public function toArray($notifiable): array
    {
        return [
            'type' => 'pending_check_in',
            'visitor_id' => $this->visitor->id,
            'visitor_name' => $this->visitor->full_name,
            'message' => __('Visitor :name is pending check-in', ['name' => $this->visitor->full_name]),
        ];
    }
}
