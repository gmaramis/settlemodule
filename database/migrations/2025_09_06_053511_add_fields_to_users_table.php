<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('student_id')->unique()->nullable();
            $table->string('phone')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('institution')->nullable();
            $table->string('program')->nullable(); // e.g., 'Medicine', 'Nursing', 'Pharmacy'
            $table->integer('year_of_study')->nullable();
            $table->string('specialization')->nullable();
            $table->text('bio')->nullable();
            $table->string('profile_picture')->nullable();
            $table->enum('role', ['student', 'supervisor', 'admin'])->default('student');
            $table->boolean('is_active')->default(true);
            $table->datetime('last_login_at')->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone')->nullable();
            $table->text('medical_notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'student_id',
                'phone',
                'date_of_birth',
                'institution',
                'program',
                'year_of_study',
                'specialization',
                'bio',
                'profile_picture',
                'role',
                'is_active',
                'last_login_at',
                'emergency_contact_name',
                'emergency_contact_phone',
                'medical_notes'
            ]);
        });
    }
};
