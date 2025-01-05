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
        // Menghapus constraint foreign key 'transactions_product_id_foreign' yang menghubungkan kolom product_id ke tabel products
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['product_id']); // Hapus foreign key
        });

        // Menghapus kolom 'product_id' dari tabel 'transactions' karena kita akan menggunakan tabel pivot
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('product_id'); // Hapus kolom product_id
        });

        // Membuat tabel pivot 'product_transaction' untuk hubungan banyak ke banyak
        Schema::create('product_transaction', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained('transactions')->onDelete('cascade'); // Hubungkan dengan transaksi
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); // Hubungkan dengan produk
            $table->integer('quantity'); // Menyimpan kuantitas produk yang dibeli
            $table->timestamps(); // Waktu saat data dibuat dan diperbarui
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
