<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['store', 'user'])->latest()->paginate(10);
        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $stores = Store::all();
        $users = User::where('role', 'cashier')->get(); // Menarik user dengan role cashier

        return view('transactions.create', compact('stores', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'store_id' => 'required|exists:stores,id',
            'user_id' => 'required|exists:users,id',
            'transaction_code' => 'nullable|unique:transactions,transaction_code', // Tidak wajib, otomatis jika kosong
            'total_amount' => 'required|numeric',
            'transaction_date' => 'required|date',
        ]);

        // Jika kode transaksi tidak diisi, buat kode otomatis
        $transactionCode = $request->transaction_code ?? 'TXN-' . strtoupper(uniqid());

        // Simpan transaksi
        Transaction::create([
            'store_id' => $request->store_id,
            'user_id' => $request->user_id,
            'transaction_code' => $transactionCode,
            'total_amount' => $request->total_amount,
            'transaction_date' => $request->transaction_date,
        ]);

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil ditambahkan.');
    }








    public function edit(Transaction $transaction)
    {
        $stores = Store::all();
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'cashier');
        })->get();

        return view('transactions.edit', compact('transaction', 'stores', 'users'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'store_id' => 'required|exists:stores,id',
            'user_id' => 'required|exists:users,id',
            'transaction_code' => 'required|string|unique:transactions,transaction_code,' . $transaction->id,
            'total_amount' => 'required|numeric|min:0',
            'transaction_date' => 'required|transaction_date',
        ]);

        $transaction->update($request->all());

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diperbarui!');
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus!');
    }
}
