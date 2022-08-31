<?php

declare(strict_types=1);

namespace App\Domain\Documents;

use App\Markdown\Parser;
use App\Services\Container;
use phpDocumentor\Reflection\Types\Void_;

class DocumentRepositoryFactory
{
    public const DRIVER_FS = 'fs';
    public const DRIVER_MYSQL = 'mysql';

    public function __construct(
        private readonly Container $container,
        private readonly Parser $parser,
        private readonly HeadlineExtractor $headlineExtractor
    ) {
    }

    public function create(): DocumentRepositoryInterface
    {
        $driver = $this->container->getConfig()['documents']['driver'];
        switch ($driver) {
            case static::DRIVER_FS:
                $driverConfig = $this->container->getConfig()['documents']['drivers'][$driver];
                return new DocumentFileSystemLoader(
                    $driverConfig['directory'],
                    $this->parser,
                    $this->headlineExtractor
                );

            case static::DRIVER_MYSQL:
                $driverConfig = $this->container->getConfig()['documents']['drivers'][$driver];
                return new DocumentMysqlLoader(
                    $driverConfig['dsn'],
                    $driverConfig['user'],
                    $driverConfig['pass'],
                    $this->parser
                );

            default:
                throw new \RuntimeException("Unknown datasource driver `{$driver}`. `fs` and `mysql` are available");
        }
    }
}
