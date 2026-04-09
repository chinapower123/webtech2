<?php

namespace Framework\Templating;

class TemplateEngine implements TemplateEngineInterface
{
    public function __construct(
        private string $templatePath
    ) {}

    public function render(string $template, mixed ...$params): string
    {
        $data = (isset($params[0]) && is_array($params[0])) ? $params[0] : $params;

        extract($data);

        ob_start();

        $file = rtrim($this->templatePath, '/') . '/' . ltrim($template, '/');

        if (file_exists($file)) {
            include $file;
        } else {
            echo "Fout: Template bestand niet gevonden: " . $file;
        }

        return ob_get_clean();
    }
}