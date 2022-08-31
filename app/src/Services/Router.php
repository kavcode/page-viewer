<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\ControllerInterface;
use App\Exceptions\RouteNotFoundException;

class Router
{
    /**
     * @var array<string, ControllerInterface>
     */
    private array $pathMap = [];

    /**
     * @var array<string, string>
     */
    private array $nameMap = [];

    private ?string $default = null;

    /**
     * Router constructor.
     * @param array<string, ?array{?string, ?ControllerInterface, ?array{string:bool}}> $rotes Example [
     *      'name' => ['/path', new PathController()]
     * ]
     */
    public function __construct(array $rotes)
    {
        foreach ($rotes as $name => $config) {
            if (!is_array($config)) {
                throw new \RuntimeException("Route config for {$name} has bad format. It should be an array.");
            }

            [$path, $controller] = $config;
            if (!is_string($path) || !isset($path[0]) || !($path[0] === '/')) {
                throw new \RuntimeException("Route config for {$name} has bad format. " .
                    "The first element should be a string stars with '/' symbol");
            }

            if (!($controller instanceof ControllerInterface)) {
                throw new \RuntimeException("Route config for {$name} has bad format. " .
                    "The second element should be a callable");
            }

            if (isset($config[2]['default']) && $config[2]['default'] === true) {
                $this->default = $path;
            }

            $this->pathMap[$path] = $controller;
            $this->nameMap[$name] = $path;
        }
    }

    public function resolve(Request $request): ControllerInterface
    {
        $path = $request->getPath();
        if (!isset($this->pathMap[$path]) && !$this->default) {
            throw new RouteNotFoundException("Can't find any handler for path '{$path}'");
        }
        return $this->pathMap[$path] ?? $this->pathMap[$this->default];
    }

    /**
     * @param string $name
     * @param array<string, int|float|string> $params
     * @return string
     */
    public function link(string $name, array $params = []): string
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
