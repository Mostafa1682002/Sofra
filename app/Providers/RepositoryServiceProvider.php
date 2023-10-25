<?php

namespace App\Providers;

use App\Interfaces\MainClientInterface;
use App\Interfaces\MainRestaurantInterface;
use App\Repositories\MainClientRepository;
use App\Repositories\MainRestaurantRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(MainRestaurantInterface::class, MainRestaurantRepository::class);
        $this->app->bind(MainClientInterface::class, MainClientRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
