<?php declare(strict_types=1);

namespace App\Services;

class Container
{
    private $config;
    private $definitions = [];
    private $services = [];

    public function __construct(
        array $config
    )
    {
        $this->config = $config;
        $this->services['app'] = $this;
    }

    public function define(
        string $service,
        callable $definitionCallback
    ) : Container
    {
        if (isset($this->definitions[$service])) {
            throw new \RuntimeException(
                "Service {$service} is already defined"
            );
        }

        $this->definitions[$service] = $definitionCallback;
        return $this;
    }

    public function get(
        string $service
    ) : object
    {
        if (!isset($this->services[$service])) {
            if (!isset($this->definitions[$service])) {
                throw new \RuntimeException(
                    "There is no definition for service {$service}"
                );
            }
            $this->services[$service] = $this->definitions[$service]($this);
        }

        return $this->services[$service];
    }

    public function getConfig(): array
    {
        return $this->config;
    }
}