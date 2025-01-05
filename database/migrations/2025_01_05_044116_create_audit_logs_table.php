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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Pengguna terkait
            $table->string('action'); // Jenis aksi (contoh: 'create', 'update', 'delete', 'login', dll)
            $table->string('module'); // Modul atau entitas yang dipengaruhi (contoh: 'products', 'transactions', dll)
            $table->text('description')->nullable(); // Deskripsi aktivitas secara rinci
            $table->ipAddress('ip_address')->nullable(); // Alamat IP pengguna
            $table->string('user_agent')->nullable(); // Informasi browser atau perangkat
            $table->timestamps(); // Tanggal log dibuat (created_at dan updated_at)
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
