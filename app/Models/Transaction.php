<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'user_id',
        'transaction_code',
        'total_amount',
        'transaction_date',
        'quantity',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        // Hubungkan produk dengan tabel pivot product_transaction
        return $this->belongsToMany(Product::class, 'product_transaction')
            ->withPivot('quantity')
            ->withTimestamps();
    }
}
