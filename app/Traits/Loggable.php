<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;

trait Loggable
{
    protected static function bootLoggable()
    {
        // Log when model is created
        static::created(function (Model $model) {
            $model->logActivity(
                "Created {$model->getModelName()}",
                'created',
                $model->getLoggableAttributes()
            );
        });

        // Log when model is updated
        static::updated(function (Model $model) {
            $changes = $model->getChanges();
            $original = $model->getOriginal();
            
            $changedAttributes = [];
            foreach ($changes as $key => $value) {
                if ($key !== 'updated_at') {
                    $changedAttributes[$key] = [
                        'from' => $original[$key] ?? null,
                        'to' => $value
                    ];
                }
            }

            if (!empty($changedAttributes)) {
                $model->logActivity(
                    "Updated {$model->getModelName()}",
                    'updated',
                    ['changes' => $changedAttributes]
                );
            }
        });

        // Log when model is deleted
        static::deleted(function (Model $model) {
            $model->logActivity(
                "Deleted {$model->getModelName()}",
                'deleted',
                $model->getLoggableAttributes()
            );
        });
    }

    /**
     * Get the model name for logging
     */
    protected function getModelName(): string
    {
        return class_basename($this);
    }

    /**
     * Get the log name/channel for this model
     */
    protected function getLogName(): string
    {
        return strtolower(class_basename($this));
    }

    /**
     * Get attributes that should be logged
     */
    protected function getLoggableAttributes(): array
    {
        $attributes = $this->getAttributes();
        
        // Remove sensitive fields
        $hidden = $this->getHidden();
        foreach ($hidden as $field) {
            unset($attributes[$field]);
        }

        // Remove timestamps if not needed
        if (!$this->shouldLogTimestamps()) {
            unset($attributes['created_at'], $attributes['updated_at']);
        }

        return $attributes;
    }

    /**
     * Whether to include timestamps in logs
     */
    protected function shouldLogTimestamps(): bool
    {
        return true;
    }

    /**
     * Log a custom activity for this model
     */
    public function logActivity(
        string $description,
        string $event = 'custom',
        array $properties = [],
        string $severity = 'info',
        string $status = 'success',
        ?string $errorMessage = null
    ): ActivityLog {
        return ActivityLog::logActivity(
            $description,
            $event,
            $this->getLogName(),
            $this,
            auth()->user(),
            $properties,
            $severity,
            $status,
            $errorMessage
        );
    }

    /**
     * Get activity logs for this model
     */
    public function activityLogs()
    {
        return $this->morphMany(ActivityLog::class, 'subject');
    }

    /**
     * Get recent activity logs for this model
     */
    public function recentActivityLogs($days = 7)
    {
        return $this->activityLogs()->recent($days);
    }
}
