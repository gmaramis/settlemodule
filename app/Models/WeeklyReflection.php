<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\Loggable;
use App\Services\CacheService;
use Carbon\Carbon;

class WeeklyReflection extends Model
{
    use HasFactory, Loggable;

    protected $fillable = [
        'user_id',
        'clinical_rotation_id',
        'week_start_date',
        'week_end_date',
        'what_went_well_quality_safety',
        'what_could_do_better',
        'what_learned_safe_healthcare',
        'goals_for_next_week',
        'submitted',
        'submitted_at',
        'supervisor_comments',
        'supervisor_reviewed_at',
    ];

    protected $casts = [
        'week_start_date' => 'datetime',
        'week_end_date' => 'datetime',
        'submitted' => 'boolean',
        'submitted_at' => 'datetime',
        'supervisor_reviewed_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($weeklyReflection) {
            CacheService::clearWeeklyReflectionCaches();
        });

        static::updated(function ($weeklyReflection) {
            CacheService::clearWeeklyReflectionCaches();
        });

        static::deleted(function ($weeklyReflection) {
            CacheService::clearWeeklyReflectionCaches();
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

    public function scopeSubmitted($query)
    {
        return $query->where('submitted', true);
    }

    public function scopePending($query)
    {
        return $query->where('submitted', false);
    }

    public function scopeReviewed($query)
    {
        return $query->whereNotNull('supervisor_reviewed_at');
    }

    public function scopePendingReview($query)
    {
        return $query->where('submitted', true)
                    ->whereNull('supervisor_reviewed_at');
    }

    public function scopeForWeek($query, $startDate)
    {
        return $query->where('week_start_date', $startDate);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function getWeekNumberAttribute()
    {
        return Carbon::parse($this->week_start_date)->weekOfYear;
    }

    public function getSatisfactionColorAttribute()
    {
        if (!$this->overall_satisfaction) {
            return 'gray';
        }

        return match(true) {
            $this->overall_satisfaction >= 8 => 'green',
            $this->overall_satisfaction >= 6 => 'yellow',
            $this->overall_satisfaction >= 4 => 'orange',
            default => 'red'
        };
    }

    public function getIsOverdueAttribute()
    {
        return Carbon::parse($this->week_end_date)->isPast() && !$this->submitted;
    }

}
