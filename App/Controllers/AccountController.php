<?php

namespace App\Controllers;

class AccountController extends Controller
{
	protected $template = 'userAccount.twig';

	/**
	 * Выводит личный кабинет
	 * @return string личный кибинет пользователя
	 * @throws - ошибки шаблонизатора
	 */
	public function index(): string
	{
		/**
		 * если не авторизован, переводит на страницу авторизации
		 */
		if (empty($this->app->session['login'])) {
			header('Location: /sign/');
			die;
		}

		$pages = $this->app->session['visited'];

		if (!empty($pages)) {
			array_reverse($pages);
		}

		return $this->render([
			'title' => 'Account',
			'pages' => $pages
		]);
	}
}