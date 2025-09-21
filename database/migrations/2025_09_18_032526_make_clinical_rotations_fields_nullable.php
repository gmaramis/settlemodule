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
        Schema::table('clinical_rotations', function (Blueprint $table) {
            // Make fields nullable that are no longer required
            $table->string('supervisor_name')->nullable()->change();
            $table->string('supervisor_email')->nullable()->change();
            $table->date('start_date')->nullable()->change();
            $table->date('end_date')->nullable()->change();
            $table->integer('total_hours')->nullable()->change();
            $table->text('description')->nullable()->change();
            $table->text('learning_objectives')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clinical_rotations', function (Blueprint $table) {
            // Revert back to required fields
            $table->string('supervisor_name')->nullable(false)->change();
            $table->string('supervisor_email')->nullable(false)->change();
            $table->date('start_date')->nullable(false)->change();
            $table->date('end_date')->nullable(false)->change();
            $table->integer('total_hours')->nullable(false)->change();
            $table->text('description')->nullable(false)->change();
            $table->text('learning_objectives')->nullable(false)->change();
        });
    }
};
