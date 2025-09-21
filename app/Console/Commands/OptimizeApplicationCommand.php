<?php

namespace App\Console\Commands;

use App\Services\DashboardCacheService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class OptimizeApplicationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'settle:optimize 
                            {--cache : Warm up caches}
                            {--database : Optimize database}
                            {--assets : Build optimized assets}
                            {--all : Run all optimizations}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Optimize the Settle Medical application for better performance';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Starting Settle Medical optimization...');

        if ($this->option('all') || $this->option('cache')) {
            $this->optimizeCache();
        }

        if ($this->option('all') || $this->option('database')) {
            $this->optimizeDatabase();
        }

        if ($this->option('all') || $this->option('assets')) {
            $this->optimizeAssets();
        }

        $this->info('✅ Optimization completed successfully!');
    }

    /**
     * Optimize caching system
     */
    private function optimizeCache()
    {
        $this->info('📦 Optimizing cache system...');

        // Clear all caches
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');

        // Warm up caches
        DashboardCacheService::warmUpCaches();

        $this->info('✅ Cache optimization completed');
    }

    /**
     * Optimize database
     */
    private function optimizeDatabase()
    {
        $this->info('🗄️ Optimizing database...');

        // Run migrations for new indexes
        Artisan::call('migrate', ['--force' => true]);

        // Analyze tables for better query optimization
        $tables = ['users', 'clinical_rotations', 'incidents', 'weekly_reflections', 'learning_logs', 'activity_logs'];
        
        foreach ($tables as $table) {
            DB::statement("ANALYZE TABLE {$table}");
        }

        // Optimize tables
        foreach ($tables as $table) {
            DB::statement("OPTIMIZE TABLE {$table}");
        }

        $this->info('✅ Database optimization completed');
    }

    /**
     * Optimize assets
     */
    private function optimizeAssets()
    {
        $this->info('🎨 Optimizing assets...');

        // Install dependencies
        $this->info('Installing dependencies...');
        exec('npm install');

        // Build optimized assets
        $this->info('Building optimized assets...');
        exec('npm run build');

        $this->info('✅ Asset optimization completed');
    }
}
