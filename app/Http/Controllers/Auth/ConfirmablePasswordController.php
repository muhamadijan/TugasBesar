<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ConfirmablePasswordController extends Controller
{
    /**
     * Show the confirm password view.
     */
    public function show(): View
    {
        return view('auth.confirm-password');
    }

    /**
     * Confirm the user's password.
     */
    public function store(Request $request): RedirectResponse
    {
        if (!Auth::guard('web')->validate([
            'email' => $request->user()->email,
            'password' => $request->password,
        ])) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        $request->session()->put('auth.password_confirmed_at', time());

        // Arahkan berdasarkan role pengguna
        $role = $request->user()->role_id; // Pastikan `role_id` ada di model User

        switch ($role) {
            case 1: // Admin
                $redirectTo = '/admin/dashboard';
                break;
            case 2: // Manajer
                $redirectTo = '/manager/dashboard';
                break;
            case 3: // Guru
                $redirectTo = '/guru/dashboard';
                break;
            case 4: // Siswa
                $redirectTo = '/siswa/dashboard';
                break;
            default:
                $redirectTo = '/home'; // Default halaman jika role tidak dikenal
                break;
        }

        return redirect()->intended($redirectTo);
    }
}
