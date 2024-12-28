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
        Schema::create('stock_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); // Barang terkait
            $table->integer('quantity'); // Perubahan jumlah stok (positif/negatif)
            $table->enum('type', ['in', 'out']); // Jenis perubahan stok
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Pegawai yang mengubah stok
            $table->timestamp('log_date'); // Tanggal log stok
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_stock_logs');
    }
};
