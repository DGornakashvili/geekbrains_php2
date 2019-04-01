<?php

namespace App\Controllers;

use App\App;
use App\Classes\TemplateEngine;

abstract class Controller
{
    protected $template;
    /**
     * @var \Twig\Environment
     */
    protected $twig;
    /**
     * @var App
     */
    protected $app;

    public function __construct()
    {
        $this->twig = TemplateEngine::getInstance()->twig;
        $this->app = App::getInstance();
    }

    /**
     * @param array $params
     * @param string|null $template
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    protected function render(?array $params = [], ?string $template = null): string
    {
        if (!$template) {
            $template = $this->template;
        }
        $twig = $this->twig->load($template);

        $params = array_merge(['session' => $this->app->session['login'] ?? false], $params);

        return $twig->render($params);
    }
}
