<?php

namespace App\Services;

class WhatsAppMessageTemplate
{
    /**
     * Format incident report message
     *
     * @param array $data
     * @return string
     */
    public static function incidentReport(array $data): string
    {
        $currentTime = now()->format('d/m/Y H:i:s');
        
        $message = "🚨 *LAPORAN INCIDENT BARU* 🚨\n\n";
        $message .= "Mahasiswa *" . self::escapeMarkdown($data['student_name']) . "* sudah melakukan incident report pada jam *" . $currentTime . " WITA*\n\n";
        
        // Basic incident info
        $message .= "📋 *Detail Incident:*\n";
        $message .= "• Departemen: " . self::escapeMarkdown($data['department']) . "\n";
        $message .= "• Tipe Event: " . self::escapeMarkdown($data['event_type']) . "\n";
        $message .= "• Outcome: " . self::escapeMarkdown($data['outcome']) . "\n";
        $message .= "• Tanggal Incident: " . self::escapeMarkdown($data['incident_date']) . "\n\n";
        
        // Action link
        $message .= "🔗 *Link Review:* " . $data['review_url'] . "\n\n";
        $message .= "_Settle Medical System_";
        
        return $message;
    }

    /**
     * Format weekly reflection message
     *
     * @param array $data
     * @return string
     */
    public static function weeklyReflection(array $data): string
    {
        $currentTime = now()->format('d/m/Y H:i:s');
        
        $message = "📝 *REFLECTION MINGGUAN BARU* 📝\n\n";
        $message .= "Mahasiswa *" . self::escapeMarkdown($data['student_name']) . "* sudah melakukan weekly reflection pada jam *" . $currentTime . " WITA*\n\n";
        
        // Basic reflection info
        $message .= "📋 *Detail Reflection:*\n";
        $message .= "• Minggu: " . self::escapeMarkdown($data['week']) . "\n";
        $message .= "• Departemen: " . self::escapeMarkdown($data['department']) . "\n";
        
        // Truncate content if too long
        $focus = self::truncateText($data['focus'], 100);
        $message .= "• Fokus Pembelajaran: " . self::escapeMarkdown($focus) . "\n\n";
        
        // Action link
        $message .= "🔗 *Link Review:* " . $data['review_url'] . "\n\n";
        $message .= "_Settle Medical System_";
        
        return $message;
    }

    /**
     * Format learning log message
     *
     * @param array $data
     * @return string
     */
    public static function learningLog(array $data): string
    {
        $currentTime = now()->format('d/m/Y H:i:s');
        
        $message = "📚 *LEARNING LOG BARU* 📚\n\n";
        $message .= "Mahasiswa *" . self::escapeMarkdown($data['student_name']) . "* sudah melakukan learning log pada jam *" . $currentTime . " WITA*\n\n";
        
        // Basic learning log info
        $message .= "📋 *Detail Learning Log:*\n";
        $message .= "• Tanggal: " . self::escapeMarkdown($data['date']) . "\n";
        $message .= "• Departemen: " . self::escapeMarkdown($data['department']) . "\n";
        $message .= "• Topik: " . self::escapeMarkdown($data['topic']) . "\n";
        
        // Truncate content if too long
        $whatLearned = self::truncateText($data['what_learned'], 100);
        $message .= "• Yang Dipelajari: " . self::escapeMarkdown($whatLearned) . "\n\n";
        
        // Action link
        $message .= "🔗 *Link Review:* " . $data['review_url'] . "\n\n";
        $message .= "_Settle Medical System_";
        
        return $message;
    }

    /**
     * Format test connection message
     *
     * @return string
     */
    public static function testConnection(): string
    {
        $message = "🧪 *TEST CONNECTION* 🧪\n\n";
        $message .= "Sistem Settle Medical WhatsApp notification berhasil terhubung!\n";
        $message .= "⏰ *Waktu:* " . now()->format('d/m/Y H:i:s') . "\n\n";
        $message .= "_Test dari Settle Medical System_";
        
        return $message;
    }

    /**
     * Format system alert message
     *
     * @param string $alertType
     * @param string $message
     * @param array $data
     * @return string
     */
    public static function systemAlert(string $alertType, string $message, array $data = []): string
    {
        $emoji = match($alertType) {
            'error' => '❌',
            'warning' => '⚠️',
            'info' => 'ℹ️',
            'success' => '✅',
            default => '📢'
        };

        $alertMessage = "{$emoji} *SYSTEM ALERT - " . strtoupper($alertType) . "* {$emoji}\n\n";
        $alertMessage .= self::escapeMarkdown($message) . "\n\n";
        
        if (!empty($data)) {
            $alertMessage .= "📊 *Details:*\n";
            foreach ($data as $key => $value) {
                $alertMessage .= "• " . self::escapeMarkdown($key) . ": " . self::escapeMarkdown($value) . "\n";
            }
            $alertMessage .= "\n";
        }
        
        $alertMessage .= "⏰ *Waktu:* " . now()->format('d/m/Y H:i:s') . "\n";
        $alertMessage .= "_Settle Medical System_";
        
        return $alertMessage;
    }

    /**
     * Escape WhatsApp markdown characters
     *
     * @param string $text
     * @return string
     */
    protected static function escapeMarkdown(string $text): string
    {
        // Escape WhatsApp markdown characters
        $text = str_replace(['*', '_', '~', '`', '[', ']', '(', ')'], 
                           ['\\*', '\\_', '\\~', '\\`', '\\[', '\\]', '\\(', '\\)'], 
                           $text);
        
        return $text;
    }

    /**
     * Truncate text to specified length
     *
     * @param string $text
     * @param int $length
     * @return string
     */
    protected static function truncateText(string $text, int $length): string
    {
        if (strlen($text) <= $length) {
            return $text;
        }
        
        return substr($text, 0, $length - 3) . '...';
    }

    /**
     * Format quota alert message
     *
     * @param array $quotaData
     * @return string
     */
    public static function quotaAlert(array $quotaData): string
    {
        $message = "⚠️ *QUOTA ALERT* ⚠️\n\n";
        $message .= "Peringatan: Kuota WhatsApp hampir habis!\n\n";
        
        foreach ($quotaData as $phone => $info) {
            $maskedPhone = self::maskPhoneNumber($phone);
            $message .= "📱 *{$maskedPhone}:*\n";
            $message .= "• Digunakan: " . ($info['used'] ?? 0) . "\n";
            $message .= "• Tersisa: " . ($info['remaining'] ?? 0) . "\n";
            $message .= "• Total: " . ($info['total'] ?? 0) . "\n\n";
        }
        
        $message .= "🔗 *Action:* Segera top up kuota di Fonnte dashboard\n";
        $message .= "⏰ *Waktu:* " . now()->format('d/m/Y H:i:s') . "\n";
        $message .= "_Settle Medical System_";
        
        return $message;
    }

    /**
     * Mask phone number for privacy
     *
     * @param string $phoneNumber
     * @return string
     */
    protected static function maskPhoneNumber(string $phoneNumber): string
    {
        if (strlen($phoneNumber) <= 8) {
            return str_repeat('*', strlen($phoneNumber));
        }
        
        return substr($phoneNumber, 0, 4) . str_repeat('*', strlen($phoneNumber) - 8) . substr($phoneNumber, -4);
    }
}

