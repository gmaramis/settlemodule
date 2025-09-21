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
        Schema::create('clinical_rotations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('rotation_name');
            $table->string('department');
            $table->string('supervisor_name')->nullable();
            $table->string('supervisor_email')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['scheduled', 'active', 'completed', 'cancelled'])->default('scheduled');
            $table->text('description')->nullable();
            $table->text('learning_objectives')->nullable();
            $table->integer('total_hours')->nullable();
            $table->decimal('evaluation_score', 3, 2)->nullable();
            $table->text('evaluation_comments')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'status']);
            $table->index(['start_date', 'end_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinical_rotations');
    }
};
