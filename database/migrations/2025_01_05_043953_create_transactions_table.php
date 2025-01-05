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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained('stores')->onDelete('cascade'); // Toko terkait
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Kasir yang melakukan transaksi
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); // Produk terkait
            $table->integer('quantity')->default(1); // Jumlah produk dalam transaksi
            $table->string('transaction_code')->unique(); // Kode transaksi unik
            $table->decimal('total_amount', 10, 2); // Total pembayaran
            $table->timestamp('transaction_date'); // Tanggal transaksi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
