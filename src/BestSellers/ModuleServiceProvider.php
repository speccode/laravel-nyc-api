<?php

namespace Speccode\BestSellers;

use Illuminate\Support\ServiceProvider;
use Speccode\BestSellers\Application\Repositories\BestSellersRepository;
use Speccode\BestSellers\Infrastructure\Repositories\NycBestSellersRepository;

class ModuleServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(BestSellersRepository::class, function () {
            return new NycBestSellersRepository(config('services.nyc.key'));
        });
    }
}
