<?php

namespace App\Policies;

use App\Models\Store;
use App\Models\User;

class StorePolicy
{
    // Izinkan Owner dan Manager untuk mengedit Store
    public function editStore(User $user, Store $store)
    {
        return $user->role === 'owner' || ($user->role === 'manager' && $user->store_id === $store->id);
    }

    // Izinkan hanya Owner untuk menghapus Store
    public function deleteStore(User $user, Store $store)
    {
        return $user->role === 'owner';
    }
}
