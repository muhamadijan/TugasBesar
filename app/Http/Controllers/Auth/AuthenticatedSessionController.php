<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create()
    {
        return view('auth.login'); // Pastikan Anda memiliki view 'auth.login'
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Arahkan pengguna sesuai dengan role mereka
            switch ($user->role) {
                case 'owner':
                    return redirect()->route('owner.dashboard');
                case 'manager':
                    return redirect()->route('manager.dashboard');
                case 'supervisor':
                    return redirect()->route('supervisor.dashboard');
                case 'cashier':
                    return redirect()->route('cashier.dashboard');
                case 'warehouse_staff':
                    return redirect()->route('warehouse.dashboard');
                default:
                    Auth::logout();
                    return redirect()->route('login')->withErrors(['role' => 'Role tidak valid!']);
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Log the user out of the application.
     */
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
