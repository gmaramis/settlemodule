<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@settle.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'student_id' => 'ADM001',
            'institution' => 'Medical University',
            'program' => 'Administration',
            'is_active' => true,
        ]);


        // Create Student User
        User::create([
            'name' => 'John Doe',
            'email' => 'student@settle.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'student_id' => 'STU001',
            'institution' => 'Medical University',
            'program' => 'Medicine',
            'is_active' => true,
        ]);

        // Create another Student User
        User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@settle.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'student_id' => 'STU002',
            'institution' => 'Medical University',
            'program' => 'Medicine',
            'is_active' => true,
        ]);
    }
}