<?php

namespace App\Providers;

use App\Models\Item;
use App\Models\Order;
use App\Policies\ItemPolicy;
use App\Policies\OrderPolicy;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(Item::class, ItemPolicy::class);
        Gate::policy(Order::class, OrderPolicy::class);
    }
}