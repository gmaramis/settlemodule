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
        Schema::table('clinical_rotations', function (Blueprint $table) {
            // Combine rotation_name and department into a single field
            $table->string('rotation_title')->nullable()->after('user_id');
        });
        
        // Update existing records to combine rotation_name and department
        if (DB::getDriverName() === 'mysql') {
            DB::statement("UPDATE clinical_rotations SET rotation_title = CONCAT(rotation_name, ' - ', department)");
        } else {
            // For SQLite and other databases, use || operator
            DB::statement("UPDATE clinical_rotations SET rotation_title = rotation_name || ' - ' || department");
        }
        
        Schema::table('clinical_rotations', function (Blueprint $table) {
            // Make rotation_title not nullable after data migration
            $table->string('rotation_title')->nullable(false)->change();
            
            // Drop the old columns
            $table->dropColumn(['rotation_name', 'department']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clinical_rotations', function (Blueprint $table) {
            // Add back the original columns
            $table->string('rotation_name')->after('user_id');
            $table->string('department')->after('rotation_name');
        });
        
        // Try to split rotation_title back (this might not work perfectly)
        DB::statement("UPDATE clinical_rotations SET rotation_name = SUBSTRING_INDEX(rotation_title, ' - ', 1)");
        DB::statement("UPDATE clinical_rotations SET department = SUBSTRING_INDEX(rotation_title, ' - ', -1)");
        
        Schema::table('clinical_rotations', function (Blueprint $table) {
            $table->dropColumn('rotation_title');
        });
    }
};
