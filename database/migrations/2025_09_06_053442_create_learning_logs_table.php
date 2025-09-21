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
        Schema::create('learning_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('clinical_rotation_id')->nullable()->constrained()->onDelete('set null');
            $table->string('learning_type'); // e.g., 'procedure', 'case_study', 'lecture', 'simulation'
            $table->string('title');
            $table->text('description');
            $table->text('learning_objectives')->nullable();
            $table->text('key_points');
            $table->text('practical_applications')->nullable();
            $table->text('reflection')->nullable();
            $table->string('competency_area')->nullable(); // e.g., 'clinical_skills', 'communication', 'diagnosis'
            $table->integer('difficulty_level')->nullable(); // 1-5 scale
            $table->integer('confidence_level')->nullable(); // 1-5 scale
            $table->text('resources_used')->nullable();
            $table->text('follow_up_actions')->nullable();
            $table->boolean('requires_practice')->default(false);
            $table->date('practice_scheduled_date')->nullable();
            $table->text('supervisor_notes')->nullable();
            $table->datetime('logged_at');
            $table->timestamps();
            
            $table->index(['user_id', 'logged_at']);
            $table->index(['clinical_rotation_id', 'learning_type']);
            $table->index(['competency_area', 'logged_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('learning_logs');
    }
};
