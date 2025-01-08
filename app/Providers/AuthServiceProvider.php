<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        \App\Models\Store::class => \App\Policies\StorePolicy::class, // Store Policy
        \App\Models\Product::class => \App\Policies\ProductPolicy::class, // Product Policy
        \App\Models\Transaction::class => \App\Policies\TransactionPolicy::class, // Transaction Policy
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
