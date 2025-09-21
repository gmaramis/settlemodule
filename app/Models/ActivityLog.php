<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Carbon\Carbon;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'log_name',
        'description',
        'subject_type',
        'subject_id',
        'causer_type',
        'causer_id',
        'properties',
        'event',
        'batch_uuid',
        'ip_address',
        'user_agent',
        'severity',
        'status',
        'error_message',
        'context',
    ];

    protected $casts = [
        'properties' => 'array',
        'context' => 'array',
        'created_at' => 'datetime',
    ];

    // Relationships
    public function causer(): MorphTo
    {
        return $this->morphTo('causer');
    }

    public function subject(): MorphTo
    {
        return $this->morphTo('subject');
    }

    // Scopes
    public function scopeForUser($query, $userId)
    {
        return $query->where('causer_id', $userId);
    }

    public function scopeForSubject($query, $subjectType, $subjectId)
    {
        return $query->where('subject_type', $subjectType)
                    ->where('subject_id', $subjectId);
    }

    public function scopeByEvent($query, $event)
    {
        return $query->where('event', $event);
    }

    public function scopeBySeverity($query, $severity)
    {
        return $query->where('severity', $severity);
    }

    public function scopeByLogName($query, $logName)
    {
        return $query->where('log_name', $logName);
    }

    public function scopeRecent($query, $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    public function scopeSuccessful($query)
    {
        return $query->where('status', 'success');
    }

    // Accessors
    public function getFormattedDateAttribute()
    {
        return $this->created_at->format('M d, Y H:i:s');
    }

    public function getTimeAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getSeverityColorAttribute()
    {
        return match($this->severity) {
            'critical' => 'text-red-600 bg-red-100',
            'error' => 'text-red-500 bg-red-50',
            'warning' => 'text-yellow-600 bg-yellow-100',
            'info' => 'text-blue-600 bg-blue-100',
            'success' => 'text-green-600 bg-green-100',
            default => 'text-gray-600 bg-gray-100',
        };
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'success' => 'text-green-600 bg-green-100',
            'failed' => 'text-red-600 bg-red-100',
            'pending' => 'text-yellow-600 bg-yellow-100',
            default => 'text-gray-600 bg-gray-100',
        };
    }

    // Static methods for easy logging
    public static function logActivity(
        string $description,
        string $event = 'created',
        string $logName = 'default',
        $subject = null,
        $causer = null,
        array $properties = [],
        string $severity = 'info',
        string $status = 'success',
        ?string $errorMessage = null
    ): self {
        $log = new self([
            'log_name' => $logName,
            'description' => $description,
            'event' => $event,
            'severity' => $severity,
            'status' => $status,
            'error_message' => $errorMessage,
            'properties' => $properties,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        if ($subject) {
            $log->subject_type = get_class($subject);
            $log->subject_id = $subject->id;
        }

        if ($causer) {
            $log->causer_type = get_class($causer);
            $log->causer_id = $causer->id;
        } elseif (auth()->check()) {
            $log->causer_type = User::class;
            $log->causer_id = auth()->id();
        }

        $log->save();
        return $log;
    }

    // Batch logging for related actions
    public static function startBatch(?string $description = null): string
    {
        $batchUuid = \Str::uuid();
        
        if ($description) {
            self::logActivity(
                "Batch started: {$description}",
                'batch_started',
                'batch',
                null,
                auth()->user(),
                ['batch_uuid' => $batchUuid]
            );
        }
        
        return $batchUuid;
    }

    public static function logInBatch(
        string $batchUuid,
        string $description,
        string $event = 'created',
        $subject = null,
        array $properties = []
    ): self {
        return self::logActivity(
            $description,
            $event,
            'batch',
            $subject,
            auth()->user(),
            array_merge($properties, ['batch_uuid' => $batchUuid])
        );
    }
}