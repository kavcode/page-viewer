<?php

declare(strict_types=1);

namespace App\Services;

use App\Controllers\HomeController;
use App\Controllers\PageController;
use App\Controllers\SearchController;
use App\Exceptions\RouteNotFoundException;

class Router
{
    private $pathMap = [];
    private $nameMap = [];
    private $default;
/**
     * Router constructor.
     * @param array $rotes Example [
     *      'name' => ['/path', new PathController()]
     * ]
     */
    public function __construct(array $rotes)
    {
        foreach ($rotes as $name => $config) {
            if (!is_array($config)) {
                throw new \RuntimeException("Route config for {$name} has bad format. It should be an array.");
            }

            [$path, $callback] = $config;
            if (!is_string($path) || !isset($path[0]) || !$path[0] === '/') {
                throw new \RuntimeException("Route config for {$name} has bad format. " .
                    "The first element should be a string stars with '/' symbol");
            }

            if (!is_callable($callback)) {
                throw new \RuntimeException("Route config for {$name} has bad format. " .
                    "The second element should be a callable");
            }

            if (isset($config['default'])) {
                $this->default = $path;
            }

            $this->pathMap[$path] = $callback;
            $this->nameMap[$name] = $path;
        }
    }

    public function resolve(Request $request): callable
    {
        $path = $request->getPath();
        if (!isset($this->pathMap[$path]) && !$this->default) {
            throw new RouteNotFoundException("Can't find any handler for path '{$path}'");
        }
        return $this->pathMap[$path] ?? $this->pathMap[$this->default];
    }

    public function link(string $name, array $params = [])
    {
        if (!isset($this->nameMap[$name])) {
            throw new \RuntimeException("Can't find any route with name '{$name}'");
        }

        $query = [];
        foreach ($params as $k => $v) {
            $query[] = "$k=$v";
        }

        return $query
            ? $this->nameMap[$name] . '?' . implode('&', $query)
            : $this->nameMap[$name];
    }
}
