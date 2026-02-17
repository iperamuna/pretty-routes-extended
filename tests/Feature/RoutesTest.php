<?php

use Illuminate\Support\Facades\Route;
use Iperamuna\PrettyRoutesExtended\Livewire\PrettyRoutesComponent;
use Livewire\Livewire;

it('can access the routes page', function () {
    $this->get(config('pretty-routes-extended.url'))
        ->assertStatus(200);
});

it('renders the livewire component', function () {
    $this->get(config('pretty-routes-extended.url'))
        ->assertSeeLivewire('pretty-routes-extended');
});

it('can search for routes', function () {
    Route::get('/test-search-route', fn () => 'test')->name('test.search');

    Livewire::test(PrettyRoutesComponent::class)
        ->set('search', 'test-search-route')
        ->assertSee('/test-search-route');
});

it('can filter routes by prefix', function () {
    Route::get('/admin/users', fn () => 'admin')->name('admin.users');
    Route::get('/api/data', fn () => 'api')->name('api.data');

    Livewire::test(PrettyRoutesComponent::class)
        ->set('filter', 'admin')
        ->assertSee('/admin/users')
        ->assertDontSee('/api/data');
});
