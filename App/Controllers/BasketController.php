<?php


namespace App\Controllers;

use App\Models\User;

class BasketController extends Controller
{
	protected $template = 'cart.twig';

	/**
	 * Выводит страницу корзины
	 * @return string страница корзины
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
		/**
		 * @var User $user
		 */
		$user = $this->app->session['login'];

		return $this->render([
			'basket' => $user->getBasket()
		]);
	}
}