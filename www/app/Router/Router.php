<?php

namespace App\Router;

use App\Http\Controller\Index;

/**
 * Class responsible to manage the route system
 */
class Router
{
    /**
     * Starting point of route system, this method must be called into index.php
     *
     * Note: If exists args, the function must be prepared to use, like (...$array), using this you can access all args
     *
     * @return void
     */
    public static function run(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $componentsToLoad = self::defineRouting();

        if (class_exists($componentsToLoad['controller'])) {
            $componentsToLoad['args']
                ? (new $componentsToLoad['controller'])->{$componentsToLoad['method']}(...$componentsToLoad['args'])
                : (new $componentsToLoad['controller'])->{$componentsToLoad['method']}();
            die;
        }

        (new Index())->{'fail'}();
    }

    /**
     * Method to get actual URI using REQUEST_URI key of $_SERVER array.
     *
     * Note: The 0 key must be destroyed because when the string is exploded, the first position is empty (string starts
     * with /, so explode create a new position based in this slash)
     *
     * @return array
     */
    private static function getActualUri(): array
    {
        $actualPath = $_SERVER['REQUEST_URI'];
        $dividedUri = explode('/', $actualPath);
        unset($dividedUri[0]);

        return array_values($dividedUri);
    }

    /**
     * Method to build a array with URI from $_SERVER. For args is needed a loop because from position 3 of Uri, is
     * possible N arguments.
     *
     * @return array
     */
    private static function defineRouting(): array
    {
        $route = self::getActualUri();
        $args = [];

        $controller = $route[0] ?? '';
        $method = $route[1] ?? '';
        $parameters = count($route);

        if ($parameters > 2) {
            $extraRoutes = $route;
            unset($extraRoutes[0]);
            unset($extraRoutes[1]);
            $extraRoutes = array_values($extraRoutes);

            for ($i = 0; $i < count($extraRoutes); $i++) {
                $args[] = $extraRoutes[$i];
            }
        }

        $controller = !empty($controller) ?
            'App\Http\Controller\\'. self::convertName($controller) :
            'App\Http\Controller\Index';

        $method = !empty($method) ?
            $method :
            'index';

        $args = !empty($args) ?
            $args :
            [];

        return [
            'controller' => $controller,
            'method' => $method,
            'args' => $args
        ];
    }

    /**
     * Method to convert routes with - in the name
     *
     * @param $controller
     * @return array|string
     */
    private static function convertName($controller): array|string
    {
        $string = str_replace('-', ' ', $controller);

        return str_replace(' ', '', ucwords($string));
    }
}
