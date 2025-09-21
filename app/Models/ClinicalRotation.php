<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\Loggable;
use App\Services\CacheService;
use Carbon\Carbon;

class ClinicalRotation extends Model
{
    use HasFactory, Loggable;

    protected $fillable = [
        'user_id',
        'rotation_title',
        'status',
        'evaluation_score',
        'evaluation_comments',
    ];

    protected $casts = [
        'evaluation_score' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($clinicalRotation) {
            CacheService::clearClinicalRotationCaches();
        });

        static::updated(function ($clinicalRotation) {
            CacheService::clearClinicalRotationCaches();
        });

        static::deleted(function ($clinicalRotation) {
            CacheService::clearClinicalRotationCaches();
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function incidents(): HasMany
    {
        return $this->hasMany(Incident::class);
    }

    public function weeklyReflections(): HasMany
    {
        return $this->hasMany(WeeklyReflection::class);
    }

    public function learningLogs(): HasMany
    {
        return $this->hasMany(LearningLog::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }

    public function getDurationAttribute()
    {
        // Duration is no longer calculated since start_date and end_date are removed
        return 0;
    }

    public function getProgressPercentageAttribute()
    {
        if ($this->status === 'completed') {
            return 100;
        }

        if ($this->status === 'scheduled') {
            return 0;
        }

        if ($this->status === 'active') {
            return 50; // Default progress for active rotations
        }

        return 0;
    }
}
