<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Store;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    // Menampilkan daftar transaksi
    public function index()
    {
        $user = auth()->user();

        $transactions = $user->role === 'owner'
            ? Transaction::with(['store', 'user', 'products'])  // Ganti 'product' menjadi 'products'
                ->latest()
                ->paginate(10)
            : Transaction::with(['store', 'user', 'products'])  // Ganti 'product' menjadi 'products'
                ->where('store_id', $user->store_id)
                ->latest()
                ->paginate(10);

        return view('transactions.index', compact('transactions'));
    }

    // Menampilkan form tambah transaksi
    public function create()
    {
        $user = auth()->user();

        $stores = $user->role === 'owner'
            ? Store::all()
            : Store::where('id', $user->store_id)->get();

        $users = User::where('role', 'cashier')
            ->where('store_id', $user->store_id)
            ->get();

        $products = Product::where('store_id', $user->store_id)->get();

        return view('transactions.create', compact('stores', 'users', 'products'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'store_id' => 'required|exists:stores,id',
            'user_id' => 'required|exists:users,id',
            'total_amount' => 'required|numeric|min:0',
            'transaction_date' => 'required|date',
            'quantity' => 'required|array|min:1', // pastikan kuantitas adalah array produk yang dibeli
            'product_ids' => 'required|array|min:1', // pastikan product_ids adalah array
        ]);

        // Generate kode transaksi unik
        $datePrefix = date('Ymd');
        $lastTransaction = Transaction::whereDate('created_at', now()->toDateString())
            ->latest('id')
            ->first();

        $lastNumber = $lastTransaction ? (int)substr($lastTransaction->transaction_code, -4) : 0;
        $transactionCode = 'TXN-' . $datePrefix . '-' . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        // Simpan transaksi baru
        $transaction = Transaction::create([
            'store_id' => $request->store_id,
            'user_id' => $request->user_id,
            'transaction_code' => $transactionCode,
            'total_amount' => $request->total_amount,
            'transaction_date' => $request->transaction_date,
        ]);

        // Hubungkan produk dengan transaksi dan simpan kuantitas di tabel pivot
        $products = $request->product_ids;
        $quantities = $request->quantity;

        foreach ($products as $index => $productId) {
            $transaction->products()->attach($productId, ['quantity' => $quantities[$index]]);

            // Kurangi stok produk yang dijual
            $product = Product::find($productId);
            $product->decrement('stock', $quantities[$index]);
        }

        // Catat log transaksi berhasil
        Log::info('Transaction created successfully:', $transaction->toArray());

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil ditambahkan dan stok produk diperbarui.');
    }


    public function show($id)
    {
        // Ambil transaksi berdasarkan ID dan relasi dengan produk
        $transaction = Transaction::with(['store', 'user', 'products'])->findOrFail($id);

        // Hitung total transaksi jika belum
        $totalAmount = $transaction->products->sum(function ($product) {
            return $product->pivot->quantity * $product->price;
        });

        // Kirim data ke view
        return view('transactions.show', compact('transaction', 'totalAmount'));
    }




    // Menampilkan riwayat transaksi pengguna
    public function history()
    {
        $user = auth()->user();

        $transactions = Transaction::with(['store', 'user', 'product'])
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        return view('transactions.history', compact('transactions'));
    }

    public function edit(Transaction $transaction)
    {
        // Ambil semua data yang diperlukan
        $stores = Store::all();
        $users = User::where('role', 'cashier')->get();
        $products = Product::all();

        // Kirim data transaksi beserta produk yang terhubung
        return view('transactions.edit', compact('transaction', 'stores', 'users', 'products'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        // Validasi input
        $request->validate([
            'store_id' => 'required|exists:stores,id',
            'user_id' => 'required|exists:users,id',
            'transaction_code' => 'required|string|unique:transactions,transaction_code,' . $transaction->id,
            'total_amount' => 'required|numeric|min:0',
            'transaction_date' => 'required|date',
        ]);

        // Update data transaksi
        $transaction->update($request->only([
            'store_id',
            'user_id',
            'transaction_code',
            'total_amount',
            'transaction_date',
        ]));

        // Update produk yang terhubung dengan transaksi (many-to-many)
        $productQuantities = $request->input('quantity'); // Ambil kuantitas produk dari form
        $products = $transaction->products; // Ambil produk yang terhubung dengan transaksi

        foreach ($products as $product) {
            // Update kuantitas untuk setiap produk
            if (isset($productQuantities[$product->id])) {
                $quantity = $productQuantities[$product->id];
                // Update pivot table untuk transaksi produk
                $transaction->products()->updateExistingPivot($product->id, ['quantity' => $quantity]);
            }
        }

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diperbarui!');
    }

    // Menghapus transaksi
    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus!');
    }
}
