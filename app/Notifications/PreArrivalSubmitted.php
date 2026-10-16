<?php

namespace App\Notifications;

use App\Models\Visitor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PreArrivalSubmitted extends Notification implements ShouldQueue
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
            ->subject(__('New Pre-Arrival Submission'))
            ->line(__('A new visitor has submitted their pre-arrival form.'))
            ->line(__('Visitor: :name', ['name' => $this->visitor->full_name]))
            ->line(__('Email: :email', ['email' => $this->visitor->email]))
            ->line(__('Arrival Date: :date', ['date' => $this->visitor->arrival_date->format('Y-m-d')]))
            ->action(__('View Visitor'), route('dashboard.visitors.show', $this->visitor));
    }

    public function toArray($notifiable): array
    {
        return [
            'type' => 'pre_arrival_submitted',
            'visitor_id' => $this->visitor->id,
            'visitor_name' => $this->visitor->full_name,
            'message' => __('New pre-arrival submission from :name', ['name' => $this->visitor->full_name]),
        ];
    }
}
