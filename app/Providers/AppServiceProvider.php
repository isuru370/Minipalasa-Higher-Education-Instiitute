<?php

namespace App\Providers;

use App\Models\Payment;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use App\Models\Product;
use App\Models\Student;
use App\Observers\PaymentObserver;
use App\Observers\ProductObserver;
use App\Observers\StudentObserver;
use Spatie\DbDumper\Databases\MySql;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register any application services.

    }


    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        MySql::create()
            ->addExtraOption('--skip-ssl');

        Schema::defaultStringLength(191);
        Paginator::useBootstrap();
        Student::observe(StudentObserver::class);
        Payment::observe(PaymentObserver::class);
    }
}
