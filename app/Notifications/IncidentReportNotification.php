<?php

namespace App\Notifications;

use App\Models\Incident;
use App\Services\FonnteWhatsAppService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class IncidentReportNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $incident;

    /**
     * Create a new notification instance.
     */
    public function __construct(Incident $incident)
    {
        $this->incident = $incident;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['whatsapp'];
    }

    /**
     * Get the WhatsApp representation of the notification.
     */
    public function toWhatsApp(object $notifiable): array
    {
        $whatsappService = new FonnteWhatsAppService();
        
        $incidentData = [
            'student_name' => $this->incident->user->name,
            'student_email' => $this->incident->user->email,
            'department' => $this->incident->department,
            'incident_date' => $this->incident->incident_date->format('d/m/Y H:i'),
            'event_type' => $this->incident->event_type,
            'outcome' => $this->incident->outcome,
            'what_happened' => $this->incident->what_happened,
            'review_url' => route('incidents.show', $this->incident)
        ];

        $result = $whatsappService->sendIncidentNotification($incidentData);

        return [
            'success' => $result['success'],
            'data' => $result['data'] ?? null,
            'error' => $result['error'] ?? null
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
            'incident_id' => $this->incident->id,
            'student_name' => $this->incident->user->name,
            'department' => $this->incident->department,
            'event_type' => $this->incident->event_type,
            'incident_date' => $this->incident->incident_date,
        ];
    }
}


