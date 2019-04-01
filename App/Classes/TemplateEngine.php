<?php

namespace App\Classes;

use App\Traits\SingletonTrait;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TemplateEngine
{
    use SingletonTrait;

    public $twig;

    protected function __construct()
    {
        $loader = new FilesystemLoader(TPL_DIR);
        $this->twig = new Environment($loader);
    }
}