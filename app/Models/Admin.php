<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Admin extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'whatsapp_number',
        'is_active',
    ];

    /**
     * Get the admin for notifications with caching
     */
    public static function getAdminForNotifications()
    {
        return cache()->remember('whatsapp_admin_for_notifications', 3600, function () {
            return static::where('is_active', true)->first() ?? static::createDefaultAdmin();
        });
    }

    /**
     * Clear admin cache
     */
    public static function clearAdminCache(): void
    {
        cache()->forget('whatsapp_admin_for_notifications');
    }

    /**
     * Create default admin if none exists
     */
    protected static function createDefaultAdmin()
    {
        $admin = static::create([
            'name' => 'Admin Settle Medical',
            'email' => config('mail.from.address', 'admin@settlemedical.com'),
            'whatsapp_number' => config('services.fonnte.admin_number', env('ADMIN_WHATSAPP_NUMBER')),
            'is_active' => true,
        ]);

        // Clear cache after creating new admin
        static::clearAdminCache();

        return $admin;
    }

    /**
     * Boot method to clear cache on model events
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($admin) {
            static::clearAdminCache();
        });

        static::updated(function ($admin) {
            static::clearAdminCache();
        });

        static::deleted(function ($admin) {
            static::clearAdminCache();
        });
    }

    /**
     * Route notifications for the WhatsApp channel.
     */
    public function routeNotificationForWhatsApp()
    {
        return $this->whatsapp_number;
    }
}
