<?php

declare(strict_types=1);

namespace App\Services;

class Response
{
    private $content;
    private $code;
    public function __construct(string $content, int $code = 200)
    {
        $this->content = $content;
        $this->code = $code;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function send(float $startTime = null): void
    {
        header('Content-Type: text/html', true, $this->code);
        echo $this->content;
        if ($startTime) {
            $time = sprintf("%.5f", microtime(true) - $startTime);
            echo "<!-- Generation time: {$time} -->";
        }
    }
}
