<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    // Menampilkan daftar pengguna
    public function index()
    {
        $users = User::where('role', '!=', 'owner')->get();
        return view('users.index', compact('users'));
    }

    // Form untuk membuat akun baru
    public function create()
    {
        $stores = Store::all();
        return view('users.create', compact('stores'));
    }

    // Menyimpan akun baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:manager,supervisor,cashier,warehouse_staff',
            'store_id' => 'nullable|exists:stores,id',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role, // Pastikan ini menggunakan data dari request
            'store_id' => $request->store_id,
        ]);

        return redirect()->route('users.index')->with('success', 'Akun berhasil dibuat.');
    }


    // Form untuk mengedit akun
    public function edit(User $user)
    {
        $stores = Store::all();
        return view('users.edit', compact('user', 'stores'));
    }

    // Memperbarui data akun
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:manager,supervisor,cashier,warehouse_staff',
            'store_id' => 'nullable|exists:stores,id',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'role' => $request->role,
            'store_id' => $request->store_id,
        ]);

        return redirect()->route('users.index')->with('success', 'Akun berhasil diperbarui.');
    }

    // Menghapus akun
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Akun berhasil dihapus.');
    }
}
