<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BroadcastMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'message',
        'status',
        'created_by',
        'scheduled_at',
        'sent_at',
        'total_recipients',
        'sent_count',
        'failed_count',
        'delivery_log',
        'target_criteria',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'sent_at' => 'datetime',
        'target_criteria' => 'array',
        'delivery_log' => 'array',
    ];

    // Relationships
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scopes
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeSent($query)
    {
        return $query->where('status', 'sent');
    }

    public function scopeSending($query)
    {
        return $query->where('status', 'sending');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    public function scopeScheduled($query)
    {
        return $query->whereNotNull('scheduled_at')
                    ->where('scheduled_at', '>', now());
    }

    // Accessors & Mutators
    public function getDeliveryStatusAttribute(): string
    {
        if ($this->status === 'sent') {
            if ($this->total_recipients > 0) {
                $successRate = ($this->sent_count / $this->total_recipients) * 100;
                return "Berhasil {$this->sent_count}/{$this->total_recipients} ({$successRate}%)";
            }
            return 'Berhasil dikirim';
        }
        
        return match($this->status) {
            'draft' => 'Draft',
            'sending' => 'Sedang dikirim',
            'failed' => 'Gagal dikirim',
            default => ucfirst($this->status)
        };
    }

    public function getIsScheduledAttribute(): bool
    {
        return $this->scheduled_at && $this->scheduled_at->isFuture();
    }

    // Methods
    public function canBeEdited(): bool
    {
        return $this->status === 'draft';
    }

    public function canBeSent(): bool
    {
        return $this->status === 'draft' && !empty($this->message);
    }

    public function canBeDeleted(): bool
    {
        return $this->status === 'draft';
    }

    public function markAsSending(): void
    {
        $this->update(['status' => 'sending']);
    }

    public function markAsSent(int $sentCount, int $failedCount = 0): void
    {
        $this->update([
            'status' => 'sent',
            'sent_at' => now(),
            'sent_count' => $sentCount,
            'failed_count' => $failedCount,
        ]);
    }

    public function markAsFailed(string $reason = null): void
    {
        $this->update([
            'status' => 'failed',
            'delivery_log' => $reason ? ['error' => $reason] : null,
        ]);
    }

    public function addDeliveryLog(array $log): void
    {
        $currentLog = $this->delivery_log ?? [];
        $currentLog[] = $log;
        $this->update(['delivery_log' => $currentLog]);
    }
}
