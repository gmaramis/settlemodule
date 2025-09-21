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
        Schema::table('weekly_reflections', function (Blueprint $table) {
            // Drop old columns
            $table->dropColumn([
                'what_went_well',
                'challenges_faced', 
                'key_learnings',
                'skills_developed',
                'areas_for_improvement',
                'supervisor_feedback',
                'overall_satisfaction'
            ]);
            
            // Add new columns
            $table->text('what_went_well_quality_safety')->after('week_end_date');
            $table->text('what_could_do_better')->after('what_went_well_quality_safety');
            $table->text('what_learned_safe_healthcare')->after('what_could_do_better');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('weekly_reflections', function (Blueprint $table) {
            // Drop new columns
            $table->dropColumn([
                'what_went_well_quality_safety',
                'what_could_do_better',
                'what_learned_safe_healthcare'
            ]);
            
            // Add back old columns
            $table->text('what_went_well')->after('week_end_date');
            $table->text('challenges_faced')->after('what_went_well');
            $table->text('key_learnings')->after('challenges_faced');
            $table->text('skills_developed')->after('key_learnings');
            $table->text('areas_for_improvement')->after('skills_developed');
            $table->text('supervisor_feedback')->nullable()->after('areas_for_improvement');
            $table->integer('overall_satisfaction')->nullable()->after('supervisor_feedback');
        });
    }
};
