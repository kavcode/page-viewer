<?php

declare(strict_types=1);

namespace App\Services;

class Container
{
    private array $config;

    /**
     * @var array<string, callable>
     */
    private array $definitions = [];

    /**
     * @var array<string, object>
     */
    private array $services = [];

    /**
     * @param array{
     *     templates: string,
     *     documents: array{
     *       driver: string,
     *       drivers: array<string, array<string, string|int|float|bool>>
     *     }
     * } $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
        $this->services['app'] = $this;
    }

    public function define(string $service, callable $definitionCallback): Container
    {
        if (isset($this->definitions[$service])) {
            throw new \RuntimeException("Service {$service} is already defined");
        }

        $this->definitions[$service] = $definitionCallback;
        return $this;
    }

    public function get(string $service): object
    {
        if (!isset($this->services[$service])) {
            if (!isset($this->definitions[$service])) {
                throw new \RuntimeException("There is no definition for service {$service}");
            }
            $instance = $this->definitions[$service]($this);
            if (!is_object($instance)) {
                throw new \RuntimeException("Service '{$service}' is not an object");
            }
            $this->services[$service] = $instance;
        }

        return $this->services[$service];
    }

    public function getConfig(): array
    {
        return $this->config;
    }
}
