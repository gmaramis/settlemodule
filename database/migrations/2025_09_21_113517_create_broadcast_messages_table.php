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
        Schema::create('broadcast_messages', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Judul pesan broadcast
            $table->text('message'); // Isi pesan yang akan dikirim
            $table->enum('status', ['draft', 'sending', 'sent', 'failed'])->default('draft');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade'); // Admin yang membuat pesan
            $table->timestamp('scheduled_at')->nullable(); // Waktu terjadwal untuk pengiriman
            $table->timestamp('sent_at')->nullable(); // Waktu pengiriman aktual
            $table->integer('total_recipients')->default(0); // Total penerima
            $table->integer('sent_count')->default(0); // Jumlah yang berhasil dikirim
            $table->integer('failed_count')->default(0); // Jumlah yang gagal dikirim
            $table->text('delivery_log')->nullable(); // Log detail pengiriman
            $table->json('target_criteria')->nullable(); // Kriteria target (role, department, dll)
            $table->timestamps();
            
            // Index untuk performa
            $table->index(['status', 'created_at']);
            $table->index(['created_by', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('broadcast_messages');
    }
};
