<?php

namespace App\Policies;

use App\Models\Transaction;
use App\Models\User;

class TransactionPolicy
{
    /**
     * Determine if the user can view the transaction.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Transaction  $transaction
     * @return bool
     */
    public function view(User $user, Transaction $transaction)
    {
        // Owner dapat melihat semua transaksi
        // Kasir hanya dapat melihat transaksi dari toko mereka
        return $user->role === 'owner' ||
               ($user->role === 'cashier' && $user->store_id === $transaction->store_id);
    }

    /**
     * Determine if the user can edit the transaction.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Transaction  $transaction
     * @return bool
     */
    public function edit(User $user, Transaction $transaction)
    {
        // Hanya owner yang dapat mengedit transaksi
        return $user->role === 'owner';
    }

    /**
     * Determine if the user can delete the transaction.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Transaction  $transaction
     * @return bool
     */
    public function delete(User $user, Transaction $transaction)
    {
        // Hanya owner yang dapat menghapus transaksi
        return $user->role === 'owner';
    }
}
