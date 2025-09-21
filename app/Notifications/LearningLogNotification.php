<?php

namespace App\Notifications;

use App\Models\LearningLog;
use App\Services\FonnteWhatsAppService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Carbon\Carbon;

class LearningLogNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $learningLog;

    /**
     * Create a new notification instance.
     */
    public function __construct(LearningLog $learningLog)
    {
        $this->learningLog = $learningLog;
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
        
        $learningLogData = [
            'student_name' => $this->learningLog->user->name,
            'student_email' => $this->learningLog->user->email,
            'date' => $this->learningLog->date ? Carbon::parse($this->learningLog->date)->format('d/m/Y') : 'N/A',
            'department' => $this->learningLog->clinicalRotation->rotation_title ?? 'N/A',
            'topic' => $this->learningLog->topic_keyword,
            'what_learned' => $this->learningLog->what_learned,
            'review_url' => route('learning-logs.show', $this->learningLog)
        ];

        $result = $whatsappService->sendLearningLogNotification($learningLogData);

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
            'learning_log_id' => $this->learningLog->id,
            'student_name' => $this->learningLog->user->name,
            'date' => $this->learningLog->date,
            'topic' => $this->learningLog->topic_keyword,
            'clinical_rotation' => $this->learningLog->clinicalRotation->rotation_title ?? 'N/A',
        ];
    }
}

