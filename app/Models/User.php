<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'student_id',
        'phone',
        'date_of_birth',
        'institution',
        'program',
        'bio',
        'profile_picture',
        'role',
        'is_active',
        'last_login_at',
        'emergency_contact_name',
        'emergency_contact_phone',
        'medical_notes',
        'department',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'date_of_birth' => 'date',
            'last_login_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    // Relationships
    public function clinicalRotations(): HasMany
    {
        return $this->hasMany(ClinicalRotation::class);
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

    // Scopes
    public function scopeStudents($query)
    {
        return $query->where('role', 'student');
    }

    public function scopeSupervisors($query)
    {
        return $query->where('role', 'supervisor');
    }

    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    public function scopeByDepartment($query, $department)
    {
        return $query->where('department', $department);
    }

    public function scopeByRole($query, $role)
    {
        return $query->where('role', $role);
    }

    public function scopeWithActiveRotations($query)
    {
        return $query->whereHas('clinicalRotations', function($q) {
            $q->where('status', 'active');
        });
    }

    public function scopeWithRecentActivity($query, $days = 7)
    {
        return $query->where(function($q) use ($days) {
            $q->whereHas('incidents', function($incidentQuery) use ($days) {
                $incidentQuery->where('incident_date', '>=', now()->subDays($days));
            })
            ->orWhereHas('learningLogs', function($logQuery) use ($days) {
                $logQuery->where('logged_at', '>=', now()->subDays($days));
            })
            ->orWhereHas('weeklyReflections', function($reflectionQuery) use ($days) {
                $reflectionQuery->where('submitted_at', '>=', now()->subDays($days));
            });
        });
    }

    public function scopeDepartmentAdmins($query)
    {
        return $query->where('role', 'department_admin');
    }

    // Accessors
    public function getFullNameAttribute()
    {
        return $this->name;
    }

    public function getIsStudentAttribute()
    {
        return $this->role === 'student';
    }

    public function getIsSupervisorAttribute()
    {
        return $this->role === 'supervisor';
    }

    public function getIsAdminAttribute()
    {
        return $this->role === 'admin';
    }

    /**
     * Send the password reset notification.
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Notifications\CustomResetPassword($token));
    }

}
