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
        Schema::create('incidents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('clinical_rotation_id')->nullable()->constrained()->onDelete('set null');
            $table->string('incident_type');
            $table->string('severity_level');
            $table->string('location');
            $table->datetime('incident_date');
            $table->text('description');
            $table->text('immediate_response')->nullable();
            $table->text('follow_up_actions')->nullable();
            $table->text('lessons_learned')->nullable();
            $table->enum('status', ['reported', 'under_review', 'resolved', 'closed'])->default('reported');
            $table->string('reported_by')->nullable();
            $table->string('supervisor_notified')->nullable();
            $table->boolean('requires_follow_up')->default(false);
            $table->date('follow_up_date')->nullable();
            $table->text('supervisor_comments')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'incident_date']);
            $table->index(['severity_level', 'status']);
            $table->index('incident_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidents');
    }
};
