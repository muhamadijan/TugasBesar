<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Validator::extend('transaction_date', function ($attribute, $value, $parameters, $validator) {
            // Contoh validasi: memastikan tanggal tidak di masa depan
            return strtotime($value) <= strtotime('today');
        });

        Validator::replacer('transaction_date', function ($message, $attribute, $rule, $parameters) {
            return "Tanggal transaksi tidak boleh di masa depan.";
        });
    }
}
