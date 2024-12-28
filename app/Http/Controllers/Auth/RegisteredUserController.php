<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role; // Ensure you import the Role model
use App\Models\Store;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        // Fetch available roles for the registration form
        $roles = Role::all(); // Assuming you have a Role model with these predefined roles
        $stores = Store::all(); // Assuming you have a Store model

        return view('auth.register', [
            'roles' => $roles,
            'stores' => $stores,
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validation with role_id and store_id as needed
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:owner,manager,supervisor,cashier,warehouse_staff'], // Validate the role against the predefined enum values
            'store_id' => ['nullable', 'exists:stores,id'], // Validates store_id exists or can be null
        ]);

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role, // Directly assign the role from the request
            'store_id' => $request->store_id, // Store_id can be null for non-store related roles
        ]);

        // Trigger the Registered event
        event(new Registered($user));

        // Log the user in
        Auth::login($user);

        // Redirect based on the role of the user
        switch ($user->role) { // Now checking the role directly from the enum value
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
                return redirect(RouteServiceProvider::HOME);
        }
    }
}
