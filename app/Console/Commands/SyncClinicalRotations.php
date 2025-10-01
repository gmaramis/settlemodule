<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ClinicalRotation;
use App\Models\Incident;

class SyncClinicalRotations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:clinical-rotations {--force : Force recreate even if rotations exist}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync clinical rotations with incident form departments (14 departments)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $force = $this->option('force');
        
        // Check if rotations already exist
        $existingCount = ClinicalRotation::count();
        if ($existingCount > 0 && !$force) {
            $this->warn("Found {$existingCount} existing clinical rotations. Use --force to recreate them.");
            return;
        }

        if ($force) {
            $this->info('Deleting existing clinical rotations...');
            ClinicalRotation::query()->delete();
        }

        // Get departments from incident form
        $departments = Incident::getDepartments();
        
        $this->info("Creating {$departments->count()} clinical rotations to match incident form...");

        $created = 0;
        foreach ($departments as $department) {
            ClinicalRotation::create([
                'user_id' => 1, // Admin User
                'rotation_title' => "Rotasi {$department}",
                'supervisor_name' => "Dr. Supervisor {$department}",
                'supervisor_email' => 'supervisor.' . strtolower(str_replace(' ', '.', $department)) . '@hospital.com',
                'start_date' => now()->addDays(rand(1, 30)),
                'end_date' => now()->addDays(rand(31, 90)),
                'status' => 'active',
                'description' => "Rotasi klinik di departemen {$department} untuk mengembangkan kompetensi klinis dan profesional.",
                'learning_objectives' => "Menguasai dasar-dasar diagnosis dan penatalaksanaan kasus di departemen {$department}.",
                'total_hours' => rand(160, 320),
            ]);
            $created++;
        }

        $this->info("✅ Created {$created} clinical rotations.");
        $this->info("🎯 Clinical rotations now match incident form departments.");
        $this->info("📊 Weekly reflections and learning logs will use these rotations.");
    }
}