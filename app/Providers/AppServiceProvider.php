<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Channels\WhatsAppChannel;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Define admin gate
        Gate::define('admin', function ($user) {
            return $user->role === 'admin';
        });

        // Define department admin gate
        Gate::define('department_admin', function ($user) {
            return $user->role === 'department_admin';
        });

        // Define admin or department admin gate
        Gate::define('admin_or_department_admin', function ($user) {
            return in_array($user->role, ['admin', 'department_admin']);
        });

        // Register WhatsApp notification channel
        Notification::extend('whatsapp', function ($app) {
            return new WhatsAppChannel();
        });
    }
}
