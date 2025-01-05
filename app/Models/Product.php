<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Field yang dapat diisi secara massal
    protected $fillable = ['name', 'sku', 'price', 'stock', 'store_id'];

    // Cast untuk field tertentu
    protected $casts = [
        'price' => 'float', // Mengubah harga menjadi float
    ];

    /**
     * Relasi ke model Store
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * Relasi ke model Transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        // Hubungkan produk dengan tabel pivot product_transaction
        return $this->belongsToMany(Transaction::class, 'product_transaction')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    /**
     * Relasi ke model Stock
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }
}
