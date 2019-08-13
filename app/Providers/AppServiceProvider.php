<?php

namespace App\Providers;

use App\Interaction;
use App\Observers\InteractionObserver;
use App\Ticket;
use App\Observers\TicketObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Ticket::observe(TicketObserver::class);
        Interaction::observe(InteractionObserver::class);
    }
}
