<?php

namespace App\Providers;

use App\Models\Donor;
use App\Observers\DonorObserver;
use Illuminate\Support\ServiceProvider;

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
    public function boot(): void
    {
        Donor::observe(DonorObserver::class);
    }
}
