<?php

namespace App\Providers;

use App\Interfaces\BaseInterface;
use App\Interfaces\MainClientInterface;
use App\Interfaces\MainRestaurantInterface;
use App\Repositories\CategoryRepository;
use App\Repositories\CityRepository;
use App\Repositories\ClientRepository;
use App\Repositories\ContactRepository;
use App\Repositories\HomeRepository;
use App\Repositories\MainClientRepository;
use App\Repositories\MainRestaurantRepository;
use App\Repositories\OfferRepository;
use App\Repositories\OrderRepository;
use App\Repositories\PaymentTypeRepository;
use App\Repositories\RegoinRepository;
use App\Repositories\RestaurantRepository;
use App\Repositories\RoleRepository;
use App\Repositories\SettingRepository;
use App\Repositories\UserRepository;
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
        $this->app->bind(BaseInterface::class, CategoryRepository::class);
        $this->app->bind(BaseInterface::class, CityRepository::class);
        $this->app->bind(BaseInterface::class, ClientRepository::class);
        $this->app->bind(BaseInterface::class, ContactRepository::class);
        $this->app->bind(BaseInterface::class, HomeRepository::class);
        $this->app->bind(BaseInterface::class, OfferRepository::class);
        $this->app->bind(BaseInterface::class, OrderRepository::class);
        $this->app->bind(BaseInterface::class, UserRepository::class);
        $this->app->bind(BaseInterface::class, SettingRepository::class);
        $this->app->bind(BaseInterface::class, PaymentTypeRepository::class);
        $this->app->bind(BaseInterface::class, RegoinRepository::class);
        $this->app->bind(BaseInterface::class, RestaurantRepository::class);
        $this->app->bind(BaseInterface::class, RoleRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}