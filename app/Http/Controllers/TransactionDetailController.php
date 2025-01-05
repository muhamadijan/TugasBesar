<?php

namespace App\Http\Controllers;

use App\Models\TransactionDetail;
use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Http\Request;

class TransactionDetailController extends Controller
{
    public function index()
{
    $user = auth()->user();

    // Jika owner, tampilkan semua detail transaksi; jika tidak, filter berdasarkan store_id
    $transactionDetails = $user->role === 'owner'
        ? TransactionDetail::with(['transaction', 'product'])->latest()->paginate(10)
        : TransactionDetail::with(['transaction', 'product'])
            ->whereHas('transaction', function ($query) use ($user) {
                $query->where('store_id', $user->store_id);
            })
            ->latest()
            ->paginate(10);

    return view('transaction_details.index', compact('transactionDetails'));
}


public function create()
{
    $user = auth()->user();

    // Ambil transaksi yang terkait dengan store pengguna
    $transactions = Transaction::where('store_id', $user->store_id)->get();

    // Ambil produk yang terkait dengan store pengguna
    $products = Product::where('store_id', $user->store_id)->get();

    return view('transaction_details.create', compact('transactions', 'products'));
}


public function store(Request $request)
{
    $request->validate([
        'transaction_id' => 'required|exists:transactions,id',
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1',
    ]);

    // Ambil produk dari database
    $product = Product::find($request->product_id);

    // Cek stok
    if ($product->stock < $request->quantity) {
        return redirect()->back()->withErrors(['quantity' => 'Stok produk tidak mencukupi.'])->withInput();
    }

    // Kurangi stok produk
    $product->stock -= $request->quantity;
    $product->save();

    // Hitung subtotal
    $subtotal = $product->price * $request->quantity;

    // Simpan detail transaksi
    TransactionDetail::create([
        'transaction_id' => $request->transaction_id,
        'product_id' => $request->product_id,
        'quantity' => $request->quantity,
        'subtotal' => $subtotal,
    ]);

    return redirect()->route('transaction_details.index')->with('success', 'Detail transaksi berhasil ditambahkan.');
}






    public function edit(TransactionDetail $transactionDetail)
    {
        $transactions = Transaction::all();
        $products = Product::all();
        return view('transaction_details.edit', compact('transactionDetail', 'transactions', 'products'));
    }

    public function update(Request $request, TransactionDetail $transactionDetail)
    {
        $request->validate([
            'transaction_id' => 'required|exists:transactions,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'subtotal' => 'required|numeric|min:0',
        ]);

        $transactionDetail->update($request->all());

        return redirect()->route('transaction_details.index')->with('success', 'Detail transaksi berhasil diperbarui.');
    }

    public function destroy(TransactionDetail $transactionDetail)
    {
        $transactionDetail->delete();

        return redirect()->route('transaction_details.index')->with('success', 'Detail transaksi berhasil dihapus.');
    }
}
