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
        Schema::create('weekly_reflections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('clinical_rotation_id')->nullable()->constrained()->onDelete('set null');
            $table->date('week_start_date');
            $table->date('week_end_date');
            $table->text('what_went_well');
            $table->text('challenges_faced');
            $table->text('key_learnings');
            $table->text('skills_developed');
            $table->text('areas_for_improvement');
            $table->text('goals_for_next_week');
            $table->text('supervisor_feedback')->nullable();
            $table->integer('overall_satisfaction')->nullable(); // 1-10 scale
            $table->boolean('submitted')->default(false);
            $table->datetime('submitted_at')->nullable();
            $table->text('supervisor_comments')->nullable();
            $table->datetime('supervisor_reviewed_at')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'week_start_date']);
            $table->index(['clinical_rotation_id', 'week_start_date']);
            $table->unique(['user_id', 'week_start_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weekly_reflections');
    }
};
