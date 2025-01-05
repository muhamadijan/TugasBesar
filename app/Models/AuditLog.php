<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    use HasFactory;


    // Field yang dapat diisi secara massal
    protected $fillable = [
        'user_id',
        'action',
        'module',
        'description',
        'ip_address',
        'user_agent',
        'activity'
    ];

    protected $casts = [
        'ip_address' => 'string',
        'user_agent' => 'string',
    ];

    /**
     * Relasi ke model User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function TransactionDetail()
    {
        return $this->hasMany(TransactionDetail::class);
    }


}
