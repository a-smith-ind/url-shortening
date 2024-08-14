<?php

namespace App\Providers;

use App\Services\RedisService;
use App\Services\RedisServiceInterface;
use App\Services\UrlShorteningService;
use App\Services\UrlShorteningServiceInterface;
use Hashids\Hashids;
use Hashids\HashidsInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public $bindings = [
        UrlShorteningServiceInterface::class => UrlShorteningService::class,
        HashidsInterface::class => Hashids::class,
        RedisServiceInterface::class => RedisService::class,
    ];

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
        //
    }
}
