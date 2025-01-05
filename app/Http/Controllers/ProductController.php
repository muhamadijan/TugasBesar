<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Store;
use App\Models\AuditLog; // Import model AuditLog
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Jika owner, tampilkan semua produk; jika tidak, filter berdasarkan store_id
        $products = $user->role === 'owner'
            ? Product::with('store')->latest()->paginate(10)
            : Product::with('store')->where('store_id', $user->store_id)->latest()->paginate(10);

        return view('products.index', compact('products'));
    }


    public function create()
    {
        $user = auth()->user();

        // Ambil toko yang terkait dengan pengguna (jika role-nya owner, tampilkan semua)
        $stores = $user->role === 'owner'
            ? Store::all()
            : Store::where('id', $user->store_id)->get();

        return view('products.create', compact('stores'));
    }


    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'store_id' => 'required|exists:stores,id',
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:255|unique:products,sku',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
        ]);

        // Tambahkan SKU jika tidak disediakan
        $sku = $request->input('sku') ?: 'SKU-' . strtoupper(uniqid());

        // Simpan produk baru
        $product = Product::create([
            'store_id' => $request->store_id,
            'name' => $request->name,
            'sku' => $sku,
            'stock' => $request->stock,
            'price' => $request->price,
        ]);

        // Catat aktivitas ke audit_logs
        AuditLogController::store(
            auth()->id(),
            "Menambahkan produk baru: {$product->name} dengan SKU: {$product->sku}",
            'create',
            'products'
        );

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }


    public function edit(Product $product)
{
    $user = auth()->user();

    // Pastikan pengguna memiliki akses ke produk ini
    if ($user->role !== 'owner' && $product->store_id !== $user->store_id) {
        abort(403, 'Anda tidak memiliki akses untuk mengedit produk ini.');
    }

    // Ambil daftar toko untuk form edit
    $stores = $user->role === 'owner'
        ? Store::all()
        : Store::where('id', $user->store_id)->get();

    return view('products.edit', compact('product', 'stores'));
}

public function update(Request $request, Product $product)
{
    $user = auth()->user();

    // Pastikan pengguna memiliki akses ke produk ini
    if ($user->role !== 'owner' && $product->store_id !== $user->store_id) {
        abort(403, 'Anda tidak memiliki akses untuk memperbarui produk ini.');
    }

    // Validasi data
    $request->validate([
        'store_id' => 'required|exists:stores,id',
        'name' => 'required|string|max:255',
        'sku' => 'required|string|max:255|unique:products,sku,' . $product->id,
        'stock' => 'required|integer|min:0',
        'price' => 'required|numeric|min:0',
    ]);

    // Perbarui produk
    $product->update([
        'store_id' => $request->store_id,
        'name' => $request->name,
        'sku' => $request->sku,
        'stock' => $request->stock,
        'price' => $request->price,
    ]);

    // Catat aktivitas ke audit_logs
    AuditLog::create([
        'user_id' => auth()->id(),
        'activity' => "Memperbarui produk: {$product->name} dengan SKU: {$product->sku}",
        'action' => 'update',
        'module' => 'products',
        'description' => "Memperbarui informasi produk: {$product->name} dengan SKU: {$product->sku}",
        'ip_address' => request()->ip(),
        'user_agent' => request()->header('User-Agent'),
        'created_at' => now(),
    ]);


    return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
}


    public function destroy(Product $product)
    {
        $user = auth()->user();

        // Pastikan pengguna memiliki akses ke produk ini
        if ($user->role !== 'owner' && $product->store_id !== $user->store_id) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus produk ini.');
        }

        // Catat data produk sebelum dihapus
        $productName = $product->name;
        $productSku = $product->sku;

        // Hapus produk
        $product->delete();

        // Catat aktivitas ke audit_logs
        AuditLog::create([
            'user_id' => auth()->id(),
            'activity' => "Menghapus produk: {$productName} dengan SKU: {$productSku}",
            'action' => 'delete',
            'module' => 'products',
            'description' => "Menghapus produk: {$productName} dengan SKU: {$productSku}",
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'created_at' => now(),
        ]);

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }

}
