<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    // Izinkan Owner dan Manager untuk mengedit produk
    public function editProduct(User $user, Product $product)
    {
        return $user->role === 'owner' || ($user->role === 'manager' && $user->store_id === $product->store_id);
    }

    // Izinkan Owner dan Manager untuk menghapus produk
    public function deleteProduct(User $user, Product $product)
    {
        return $user->role === 'owner' || ($user->role === 'manager' && $user->store_id === $product->store_id);
    }
}
