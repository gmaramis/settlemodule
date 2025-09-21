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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->string('log_name')->nullable(); // Channel/context (e.g., 'clinical_rotations', 'incidents')
            $table->text('description'); // What happened
            $table->string('subject_type')->nullable(); // Model class (e.g., 'App\Models\ClinicalRotation')
            $table->unsignedBigInteger('subject_id')->nullable(); // Model ID
            $table->string('causer_type')->nullable(); // Who did it (e.g., 'App\Models\User')
            $table->unsignedBigInteger('causer_id')->nullable(); // User ID
            $table->json('properties')->nullable(); // Additional data/metadata
            $table->string('event')->nullable(); // Action type (created, updated, deleted, etc.)
            $table->string('batch_uuid')->nullable(); // For grouping related actions
            $table->string('ip_address', 45)->nullable(); // User's IP
            $table->string('user_agent')->nullable(); // Browser info
            $table->string('severity')->default('info'); // info, warning, error, critical
            $table->string('status')->default('success'); // success, failed, pending
            $table->text('error_message')->nullable(); // Error details if failed
            $table->json('context')->nullable(); // Additional context data
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['log_name', 'created_at']);
            $table->index(['subject_type', 'subject_id']);
            $table->index(['causer_type', 'causer_id']);
            $table->index(['event', 'created_at']);
            $table->index(['severity', 'created_at']);
            $table->index('batch_uuid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};