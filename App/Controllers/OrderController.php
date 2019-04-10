<?php

namespace App\Controllers;

use App\Models\Order;
use App\Models\User;
use \Exception;

class OrderController extends Controller
{
	protected $template = 'orders.twig';

	/**
	 * Выводит страницу заказов
	 * @return string страница заказов пользователя
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
			'title' => 'My orders',
			'orders' => $user->getOrders()
		]);
	}

	/**
	 * Выводит страницу заказов если пользователь администратор
	 * @return string страница с заказами всех пользователей
	 * @throws Exception если не администратор
	 */
	public function getAllOrders(): string
	{
		/**
		 * если не авторизован, переводит на страницу авторизации
		 */
		if (empty($this->app->session['login'])) {
			header('Location: /sign/');
			die;
		}

		if ($this->app->session['login']->role !== 1) {
			throw new Exception('Access dined!');
		}

		/**
		 * @var array Order $orders
		 */
		$orders = Order::getWithProducts();
		arsort($orders);

		return $this->render([
			'title' => 'Orders',
			'orders' => $orders
		]);
	}
}