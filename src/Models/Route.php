<?php

namespace Iperamuna\PrettyRoutesExtended\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route as LaravelRoute;
use Sushi\Sushi;

class Route extends Model
{
    use Sushi;

    protected $schema = [
        'id' => 'integer',
        'uri' => 'string',
        'name' => 'string',
        'method' => 'string',
        'action' => 'string',
        'middleware' => 'string',
    ];

    public function getRows(): array
    {
        $routes = LaravelRoute::getRoutes();
        $rows = [];

        $hideMatching = config('pretty-routes-extended.hide_matching', []);
        $hideMethods = config('pretty-routes-extended.hide_methods', []);

        $index = 1;
        foreach ($routes as $route) {
            $uri = $route->uri();

            // Filter out hidden routes based on config
            foreach ($hideMatching as $regex) {
                if (preg_match($regex, $uri)) {
                    continue 2;
                }
            }

            $methods = array_diff($route->methods(), $hideMethods);

            $middleware = collect($route->gatherMiddleware() ?: [])->map(function ($m) {
                return $m instanceof \Closure ? 'Closure' : (string) $m;
            })->implode(', ');

            $rows[] = [
                'id' => $index++,
                'uri' => $uri,
                'name' => $route->getName() ?? '',
                'method' => implode('|', $methods),
                'action' => $route->getActionName() ?? '',
                'middleware' => $middleware,
            ];
        }

        return $rows;
    }
}
