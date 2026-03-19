<?php

namespace Framework\Templating;

class TemplateEngine implements TemplateEngineInterface {
    public function __construct(
        private string $templatePath
    ) {}

    public function render(string $template, mixed ...$params): string
    {
        // Zet de params om naar losse variabelen
        extract($params);

        ob_start();
        include $this->templatePath . '/' . $template . '.php';
        return ob_get_clean();
    }
}