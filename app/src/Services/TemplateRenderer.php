<?php

declare(strict_types=1);

namespace App\Services;

class TemplateRenderer
{
    public function __construct(
        private readonly string $templatesRootDir,
        private readonly array $globals = []
    ) {
    }

    /**
     * @psalm-suppress UnresolvableInclude
     * @param string $templatePath
     * @param array $context
     * @return string
     */
    public function render(string $templatePath, array $context = []): string
    {
        extract(array_merge($this->globals, $context), EXTR_OVERWRITE);
        ob_start();
        include($this->templatesRootDir . DIRECTORY_SEPARATOR  . $templatePath);
        return  ob_get_clean();
    }
}
