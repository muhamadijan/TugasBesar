<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    // Tampilkan semua store (index)
    public function index()
    {
        $stores = Store::all();
        return view('admin.stores.index', compact('stores'));
    }

    // Tampilkan form untuk membuat store baru (create)
    public function create()
    {
        return view('admin.stores.create');
    }

    // Simpan store baru ke database (store)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        Store::create($request->all());
        return redirect()->route('stores.index')->with('success', 'Store berhasil ditambahkan.');
    }

    // Tampilkan form untuk mengedit store (edit)
    public function edit(Store $store)
    {
        return view('admin.stores.edit', compact('store'));
    }

    // Update store ke database (update)
    public function update(Request $request, Store $store)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        $store->update($request->all());
        return redirect()->route('stores.index')->with('success', 'Store berhasil diperbarui.');
    }

    // Hapus store dari database (destroy)
    public function destroy(Store $store)
    {
        $store->delete();
        return redirect()->route('stores.index')->with('success', 'Store berhasil dihapus.');
    }
}
