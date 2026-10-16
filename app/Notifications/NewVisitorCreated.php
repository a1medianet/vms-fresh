<?php

namespace App\Notifications;

use App\Models\Visitor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewVisitorCreated extends Notification implements ShouldQueue
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
            ->subject(__('New Visitor Created'))
            ->line(__('A new visitor has been added to the system.'))
            ->line(__('Visitor: :name', ['name' => $this->visitor->full_name]))
            ->line(__('Email: :email', ['email' => $this->visitor->email]))
            ->action(__('View Visitor'), route('dashboard.visitors.show', $this->visitor));
    }

    public function toArray($notifiable): array
    {
        return [
            'type' => 'new_visitor_created',
            'visitor_id' => $this->visitor->id,
            'visitor_name' => $this->visitor->full_name,
            'message' => __('New visitor :name has been created', ['name' => $this->visitor->full_name]),
        ];
    }
}
