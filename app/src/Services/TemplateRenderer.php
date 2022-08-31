<?php

declare(strict_types=1);

namespace App\Services;

class TemplateRenderer
{
    private $templatesRootDir;
    private $globals;
    public function __construct(string $templatesRootDir, array $globals = [])
    {
        $this->templatesRootDir = $templatesRootDir;
        $this->globals = $globals;
    }

    public function render(string $templatePath, array $context = []): string
    {
        extract(array_merge($this->globals, $context), EXTR_OVERWRITE);
        ob_start();
        include($this->templatesRootDir . DIRECTORY_SEPARATOR  . $templatePath);
        return  ob_get_clean();
    }
}
