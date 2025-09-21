<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\Loggable;
use App\Services\CacheService;
use Carbon\Carbon;

class LearningLog extends Model
{
    use HasFactory, Loggable;

    protected $fillable = [
        'user_id',
        'clinical_rotation_id',
        'date',
        'topic_keyword',
        'what_learned',
        'logged_at',
    ];

    protected $casts = [
        'date' => 'date',
        'logged_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($learningLog) {
            CacheService::clearLearningLogCaches();
        });

        static::updated(function ($learningLog) {
            CacheService::clearLearningLogCaches();
        });

        static::deleted(function ($learningLog) {
            CacheService::clearLearningLogCaches();
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function clinicalRotation(): BelongsTo
    {
        return $this->belongsTo(ClinicalRotation::class);
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('logged_at', '>=', now()->subDays($days));
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeForDate($query, $date)
    {
        return $query->where('date', $date);
    }

}
