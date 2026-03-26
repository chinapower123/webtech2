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

        // Maakt van ['naam' => 'Jesse'] de variabele $naam voor in html
        extract($data);

        ob_start();

        // we plakken de templatePath en de bestandsnaam aan elkaar
        $file = rtrim($this->templatePath, '/') . '/' . $template;

        if (file_exists($file)) {
            include $file;
        } else {
            echo "Fout: Template bestand niet gevonden: " . $file;
        }

        return ob_get_clean();
    }
}