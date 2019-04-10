<?php

namespace App\Controllers;

use App\App;
use App\Classes\TemplateEngine;
use Twig;

abstract class Controller
{
	/**
	 * @var string $template шаблон по умолчанию
	 */
	protected $template;

	/**
	 * @var Twig\Environment Шаблонизатор
	 */
	protected $twig;

	/**
	 * @var App $app
	 */
	protected $app;

	public function __construct()
	{
		$this->twig = TemplateEngine::getInstance()->twig;
		$this->app = App::getInstance();
	}

	/**
	 * @param array $params Данные для отображения в шаблоне ['ключ' => 'данные']
	 * @param string|null $template Шаблон страници или ее части (блока), если не передан дефолтный
	 * @return string Собранный шаблон
	 * @throws Twig\Error\LoaderError
	 * @throws Twig\Error\RuntimeError
	 * @throws Twig\Error\SyntaxError
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
