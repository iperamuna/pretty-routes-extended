<?php

namespace Iperamuna\PrettyRoutesExtended\Tests;

use Iperamuna\PrettyRoutesExtended\PrettyRoutesServiceProvider;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            LivewireServiceProvider::class,
            PrettyRoutesServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('app.key', '6rE9EB9l2icPq9D669Y9CUv9Bc2vxS2y');
    }

    protected function defineRoutes($router)
    {
        // Register some test routes for Sushi to pick up
        $router->get('/test-search-route', fn () => 'test')->name('test.search');
        $router->get('/admin/users', fn () => 'admin')->name('admin.users');
        $router->get('/api/data', fn () => 'api')->name('api.data');
    }
}
