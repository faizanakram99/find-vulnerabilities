<?php

namespace Gounsch;

class View
{
    public function __construct(private ?string $user)
    {
    }

    public function render(string $template, array $vars): string
    {
        if (!file_exists($template)) {
            throw new \InvalidArgumentException("Template '{$template}' not found.");
        }

        if (null === $this->user) {
            $vars['action'] = 'login';
        }

        extract($vars);

        ob_start();

        include $template;

        return ob_get_clean();
    }
}