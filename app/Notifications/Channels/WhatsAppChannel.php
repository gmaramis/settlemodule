<?php

namespace App\Notifications\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class WhatsAppChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        // Check if the notification has a toWhatsApp method
        if (!method_exists($notification, 'toWhatsApp')) {
            Log::warning('Notification does not have toWhatsApp method', [
                'notification_type' => get_class($notification)
            ]);
            return null;
        }

        $message = $notification->toWhatsApp($notifiable);
        
        Log::info('WhatsApp notification sent', [
            'notifiable_type' => get_class($notifiable),
            'notification_type' => get_class($notification),
            'message_result' => $message
        ]);

        return $message;
    }
}

