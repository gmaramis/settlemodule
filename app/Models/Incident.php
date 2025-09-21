<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\Loggable;
use App\Services\CacheService;

class Incident extends Model
{
    use HasFactory, Loggable;

    protected $fillable = [
        'user_id',
        'department',
        'event_type',
        'event_type_explanation',
        'incident_date',
        'what_happened',
        'why_did_it_happen',
        'contributing_factors',
        'outcome',
        'prevention_suggestions',
        'status',
    ];

    protected $casts = [
        'incident_date' => 'datetime',
        'contributing_factors' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($incident) {
            CacheService::clearIncidentCaches();
        });

        static::updated(function ($incident) {
            CacheService::clearIncidentCaches();
        });

        static::deleted(function ($incident) {
            CacheService::clearIncidentCaches();
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

    public function scopeByDepartment($query, $department)
    {
        return $query->where('department', $department);
    }

    public function scopeByEventType($query, $eventType)
    {
        return $query->where('event_type', $eventType);
    }

    public function scopeByOutcome($query, $outcome)
    {
        return $query->where('outcome', $outcome);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('incident_date', '>=', now()->subDays($days));
    }

    public function getOutcomeColorAttribute()
    {
        return match($this->outcome) {
            'No harm' => 'green',
            'Minor Harm' => 'yellow',
            'Significant harm' => 'red',
            default => 'gray'
        };
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'reported' => 'blue',
            'under_review' => 'yellow',
            'resolved' => 'green',
            'closed' => 'gray',
            default => 'gray'
        };
    }

    // Static methods for form options
    public static function getDepartments()
    {
        return [
            'Ilmu Penyakit Dalam',
            'Bedah',
            'Obstetri dan Ginekologi',
            'Ilmu Kesehatan Anak',
            'Anestesiologi & Terapi Intensif',
            'Neurologi',
            'Psikiatri',
            'Ilmu Kedokteran Fisik & Rehabilitasi',
            'Ilmu Kesehatan Mata',
            'Ilmu Penyakit THT-Kepala-Leher',
            'Dermatovenereologi & Estetika',
            'Radiologi',
            'Forensik & Medikolegal',
            'Ilmu Kedokteran Komunitas'
        ];
    }

    public static function getEventTypes()
    {
        return [
            'Kejadian Sentinel',
            'Kejadian tidak diharapkan',
            'Kejadian nyaris cedera',
            'Kejadian tidak cedera',
            'Kejadian potensi cedera'
        ];
    }

    public static function getContributingFactors()
    {
        return [
            'Teamwork',
            'Communication',
            'Work Environment',
            'Task Complexity',
            'Supervision',
            'Training',
            'Equipment',
            'Policies & Procedures',
            'Workload',
            'Fatigue',
            'Time Pressure',
            'Documentation',
            'Patient Factors',
            'System Design'
        ];
    }

    public static function getOutcomes()
    {
        return [
            'No harm',
            'Minor Harm',
            'Significant harm'
        ];
    }
}
