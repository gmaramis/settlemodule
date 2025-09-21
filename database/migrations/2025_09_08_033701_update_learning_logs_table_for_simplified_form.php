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
        Schema::table('learning_logs', function (Blueprint $table) {
            // Drop foreign key constraint first
            $table->dropForeign(['clinical_rotation_id']);
            
            // Drop indexes that reference columns we're about to drop
            $table->dropIndex(['clinical_rotation_id', 'learning_type']);
            $table->dropIndex(['competency_area', 'logged_at']);
            
            // Check if columns exist before dropping them
            $columnsToDrop = [];
            if (Schema::hasColumn('learning_logs', 'learning_type')) {
                $columnsToDrop[] = 'learning_type';
            }
            if (Schema::hasColumn('learning_logs', 'title')) {
                $columnsToDrop[] = 'title';
            }
            if (Schema::hasColumn('learning_logs', 'description')) {
                $columnsToDrop[] = 'description';
            }
            if (Schema::hasColumn('learning_logs', 'learning_objectives')) {
                $columnsToDrop[] = 'learning_objectives';
            }
            if (Schema::hasColumn('learning_logs', 'key_points')) {
                $columnsToDrop[] = 'key_points';
            }
            if (Schema::hasColumn('learning_logs', 'practical_applications')) {
                $columnsToDrop[] = 'practical_applications';
            }
            if (Schema::hasColumn('learning_logs', 'reflection')) {
                $columnsToDrop[] = 'reflection';
            }
            if (Schema::hasColumn('learning_logs', 'competency_area')) {
                $columnsToDrop[] = 'competency_area';
            }
            if (Schema::hasColumn('learning_logs', 'difficulty_level')) {
                $columnsToDrop[] = 'difficulty_level';
            }
            if (Schema::hasColumn('learning_logs', 'confidence_level')) {
                $columnsToDrop[] = 'confidence_level';
            }
            if (Schema::hasColumn('learning_logs', 'resources_used')) {
                $columnsToDrop[] = 'resources_used';
            }
            if (Schema::hasColumn('learning_logs', 'follow_up_actions')) {
                $columnsToDrop[] = 'follow_up_actions';
            }
            if (Schema::hasColumn('learning_logs', 'requires_practice')) {
                $columnsToDrop[] = 'requires_practice';
            }
            if (Schema::hasColumn('learning_logs', 'practice_scheduled_date')) {
                $columnsToDrop[] = 'practice_scheduled_date';
            }
            if (Schema::hasColumn('learning_logs', 'supervisor_notes')) {
                $columnsToDrop[] = 'supervisor_notes';
            }
            
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
            
            // Add new simplified columns
            $table->date('date')->after('clinical_rotation_id');
            $table->string('topic_keyword')->after('date');
            $table->text('what_learned')->after('topic_keyword');
            
            // Re-add foreign key constraint
            $table->foreign('clinical_rotation_id')->references('id')->on('clinical_rotations')->onDelete('set null');
            
            // Add new indexes
            $table->index(['clinical_rotation_id', 'date']);
            $table->index(['topic_keyword', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('learning_logs', function (Blueprint $table) {
            // Drop new columns
            $table->dropColumn([
                'date',
                'topic_keyword',
                'what_learned'
            ]);
            
            // Add back old columns
            $table->string('learning_type')->after('clinical_rotation_id');
            $table->string('title')->after('learning_type');
            $table->text('description')->after('title');
            $table->text('learning_objectives')->nullable()->after('description');
            $table->text('key_points')->after('learning_objectives');
            $table->text('practical_applications')->nullable()->after('key_points');
            $table->text('reflection')->nullable()->after('practical_applications');
            $table->string('competency_area')->nullable()->after('reflection');
            $table->integer('difficulty_level')->nullable()->after('competency_area');
            $table->integer('confidence_level')->nullable()->after('difficulty_level');
            $table->text('resources_used')->nullable()->after('confidence_level');
            $table->text('follow_up_actions')->nullable()->after('resources_used');
            $table->boolean('requires_practice')->default(false)->after('follow_up_actions');
            $table->date('practice_scheduled_date')->nullable()->after('requires_practice');
            $table->text('supervisor_notes')->nullable()->after('practice_scheduled_date');
        });
    }
};
