<?php

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
    Livewire::test(PrettyRoutesComponent::class)
        ->set('search', 'test-search-route')
        ->assertSee('/test-search-route');
});

it('can filter routes by prefix', function () {
    Livewire::test(PrettyRoutesComponent::class)
        ->set('filter', 'admin')
        ->assertSee('/admin/users')
        ->assertDontSee('/api/data');
});
