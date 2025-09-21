<?php

namespace App\Notifications;

use App\Models\WeeklyReflection;
use App\Services\FonnteWhatsAppService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class WeeklyReflectionNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $reflection;

    /**
     * Create a new notification instance.
     */
    public function __construct(WeeklyReflection $reflection)
    {
        $this->reflection = $reflection;
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
        
        $reflectionData = [
            'student_name' => $this->reflection->user->name,
            'student_email' => $this->reflection->user->email,
            'week' => $this->reflection->week_start_date->format('d/m/Y') . ' - ' . $this->reflection->week_end_date->format('d/m/Y'),
            'department' => $this->reflection->clinicalRotation->rotation_title ?? 'N/A',
            'focus' => $this->reflection->what_learned_safe_healthcare,
            'reflection' => $this->reflection->what_went_well_quality_safety,
            'review_url' => route('weekly-reflections.show', $this->reflection)
        ];

        $result = $whatsappService->sendReflectionNotification($reflectionData);

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
            'reflection_id' => $this->reflection->id,
            'student_name' => $this->reflection->user->name,
            'week' => $this->reflection->week_start_date->format('d/m/Y') . ' - ' . $this->reflection->week_end_date->format('d/m/Y'),
            'clinical_rotation' => $this->reflection->clinicalRotation->rotation_title ?? 'N/A',
        ];
    }
}

