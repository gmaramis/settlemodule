<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ClinicalRotation;
use App\Models\User;
use Carbon\Carbon;

class ClinicalRotationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all users (or just students if you want to be more specific)
        $users = User::all();
        
        if ($users->isEmpty()) {
            $this->command->warn('No users found. Please run UserSeeder first.');
            return;
        }

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
            foreach ($departments as $department => $supervisorInfo) {
                ClinicalRotation::create([
                    'user_id' => $user->id,
                    'rotation_title' => "Rotasi {$department}",
                    'supervisor_name' => $supervisorInfo[0], // Nama supervisor
                    'supervisor_email' => $supervisorInfo[1], // Email supervisor
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

        $this->command->info("Created {$totalCreated} clinical rotations for " . $users->count() . " users.");
    }
}
