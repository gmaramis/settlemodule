<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ClinicalRotation;
use App\Models\User;
use Carbon\Carbon;

class SeedClinicalRotations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:clinical-rotations {--force : Force create even if rotations exist}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed clinical rotations for all users';

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

        // Get all users
        $users = User::where('is_admin', false)->get();
        
        if ($users->isEmpty()) {
            $this->error('No users found. Please create users first.');
            return;
        }

        $this->info("Creating clinical rotations for {$users->count()} users...");

        $departments = [
            'Ilmu Penyakit Dalam' => ['Dr. Ahmad Wijaya', 'ahmad.wijaya@hospital.com'],
            'Bedah' => ['Dr. Siti Rahayu', 'siti.rahayu@hospital.com'],
            'Obstetri dan Ginekologi' => ['Dr. Budi Santoso', 'budi.santoso@hospital.com'],
            'Ilmu Kesehatan Anak' => ['Dr. Dewi Kartika', 'dewi.kartika@hospital.com'],
            'Anestesiologi & Terapi Intensif' => ['Dr. Eko Prasetyo', 'eko.prasetyo@hospital.com'],
            'Neurologi' => ['Dr. Fitriani', 'fitriani@hospital.com'],
            'Psikiatri' => ['Dr. Guntur Wibowo', 'guntur.wibowo@hospital.com'],
            'Ilmu Kedokteran Fisik & Rehabilitasi' => ['Dr. Hesti Lestari', 'hesti.lestari@hospital.com'],
            'Ilmu Kesehatan Mata' => ['Dr. Indra Kurniawan', 'indra.kurniawan@hospital.com'],
            'Ilmu Penyakit THT-Kepala-Leher' => ['Dr. Joko Susilo', 'joko.susilo@hospital.com'],
            'Dermatovenereologi & Estetika' => ['Dr. Kartika Sari', 'kartika.sari@hospital.com'],
            'Radiologi' => ['Dr. Lina Marlina', 'lina.marlina@hospital.com'],
            'Forensik & Medikolegal' => ['Dr. Mulyadi', 'mulyadi@hospital.com'],
            'Ilmu Kedokteran Komunitas' => ['Dr. Nina Wulandari', 'nina.wulandari@hospital.com']
        ];

        $totalCreated = 0;
        
        foreach ($users as $user) {
            $this->info("Creating rotations for user: {$user->name}");
            
            foreach ($departments as $department => $supervisorInfo) {
                ClinicalRotation::create([
                    'user_id' => $user->id,
                    'rotation_title' => "Rotasi {$department}",
                    'supervisor_name' => $supervisorInfo[0],
                    'supervisor_email' => $supervisorInfo[1],
                    'start_date' => Carbon::now()->addDays(rand(1, 30)),
                    'end_date' => Carbon::now()->addDays(rand(31, 90)),
                    'status' => 'active',
                    'description' => "Rotasi klinik di departemen {$department} untuk mengembangkan kompetensi klinis dan profesional.",
                    'learning_objectives' => "Menguasai dasar-dasar diagnosis dan penatalaksanaan kasus di departemen {$department}.",
                    'total_hours' => rand(160, 320),
                    'evaluation_score' => null,
                    'evaluation_comments' => null,
                ]);
                $totalCreated++;
            }
        }

        $this->info("✅ Created {$totalCreated} clinical rotations for {$users->count()} users.");
        $this->info("🎯 Users can now create weekly reflections with clinical rotations.");
    }
}