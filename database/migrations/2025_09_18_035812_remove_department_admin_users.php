<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Delete all users with department_admin role
        DB::table('users')->where('role', 'department_admin')->delete();
        
        // Update role enum to only allow student, supervisor, admin
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['student', 'supervisor', 'admin'])->default('student')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration cannot be reversed as we deleted users
        // The role enum change is also irreversible
    }
};
