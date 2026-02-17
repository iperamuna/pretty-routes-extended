<?php

namespace Iperamuna\PrettyRoutesExtended;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Iperamuna\PrettyRoutesExtended\Livewire\PrettyRoutesComponent;
use Livewire\Livewire;

class PrettyRoutesServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if (config('pretty-routes-extended.debug_only', true) && empty(config('app.debug'))) {
            return;
        }

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'pretty-routes-extended');

        $this->publishes([
            __DIR__.'/../config/pretty-routes-extended.php' => config_path('pretty-routes-extended.php'),
        ], 'pretty-routes-extended-config');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/pretty-routes-extended'),
        ], 'pretty-routes-extended-views');

        Livewire::component('pretty-routes-extended', PrettyRoutesComponent::class);

        Route::get(config('pretty-routes-extended.url'), function () {
            return view('pretty-routes-extended::routes');
        })
            ->name('pretty-routes-extended.show')
            ->middleware(config('pretty-routes-extended.middlewares'));
    }

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/pretty-routes-extended.php',
            'pretty-routes-extended'
        );
    }
}
