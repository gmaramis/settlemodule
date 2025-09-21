<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Services\CacheService;

class OptimizeDatabaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'optimize:database {--analyze : Analyze tables for query optimization}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Optimize database performance by running ANALYZE and warm up caches';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting database optimization...');

        if ($this->option('analyze')) {
            $this->analyzeTables();
        }

        $this->warmUpCaches();
        $this->optimizeQueries();

        $this->info('Database optimization completed successfully!');
    }

    /**
     * Analyze database tables for query optimization
     */
    private function analyzeTables()
    {
        $this->info('Analyzing database tables...');

        $tables = [
            'users',
            'incidents',
            'clinical_rotations',
            'weekly_reflections',
            'learning_logs',
            'activity_logs'
        ];

        foreach ($tables as $table) {
            try {
                DB::statement("ANALYZE TABLE {$table}");
                $this->line("✓ Analyzed table: {$table}");
            } catch (\Exception $e) {
                $this->error("✗ Failed to analyze table {$table}: " . $e->getMessage());
            }
        }
    }

    /**
     * Warm up frequently accessed caches
     */
    private function warmUpCaches()
    {
        $this->info('Warming up caches...');

        try {
            CacheService::warmUpCaches();
            $this->line('✓ Caches warmed up successfully');
        } catch (\Exception $e) {
            $this->error('✗ Failed to warm up caches: ' . $e->getMessage());
        }
    }

    /**
     * Optimize database queries
     */
    private function optimizeQueries()
    {
        $this->info('Optimizing database queries...');

        try {
            // Enable query logging temporarily
            DB::enableQueryLog();

            // Run some common queries to populate caches
            $this->runCommonQueries();

            $this->line('✓ Query optimization completed');
        } catch (\Exception $e) {
            $this->error('✗ Failed to optimize queries: ' . $e->getMessage());
        }
    }

    /**
     * Run common queries to populate caches
     */
    private function runCommonQueries()
    {
        // Admin dashboard queries
        \App\Models\User::students()->count();
        \App\Models\User::supervisors()->count();
        \App\Models\ClinicalRotation::active()->count();
        \App\Models\ClinicalRotation::completed()->count();
        \App\Models\Incident::recent(7)->count();
        \App\Models\WeeklyReflection::pendingReview()->count();

        // Recent data queries
        \App\Models\Incident::with(['user:id,name,email', 'clinicalRotation:id,rotation_title'])
            ->recent(7)
            ->latest('incident_date')
            ->limit(5)
            ->get();

        \App\Models\WeeklyReflection::with(['user:id,name,email', 'clinicalRotation:id,rotation_title'])
            ->where('week_end_date', '<', now())
            ->where('submitted', false)
            ->latest('week_end_date')
            ->limit(5)
            ->get();

        $this->line('✓ Common queries executed');
    }
}