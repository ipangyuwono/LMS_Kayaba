<?php

use Illuminate\Support\Facades\Route;

if (!function_exists('active_menu')) {
    function active_menu($routes): string
    {
        $routes = (array) $routes;
        $currentRoute = Route::currentRouteName() ?? '';

        foreach ($routes as $route) {
            if (str_contains($route, '*')) {
                $pattern = str_replace(['*', '.'], ['.*', '\.'], preg_quote($route, '/'));
                if (preg_match("/^$pattern$/", $currentRoute)) {
                    return 'bg-pink-700 shadow-inner';
                }
            } elseif (request()->routeIs($route)) {
                return 'bg-pink-700 shadow-inner';
            }
        }
        return '';
    }
}
