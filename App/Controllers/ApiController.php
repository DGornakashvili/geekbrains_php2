<?php

namespace App\Controllers;

use App\Classes\Functions;
use App\Models\Basket;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\User;
use \Exception;

class ApiController extends Controller
{
	/**
	 * Выводит еще 15 товаров, если есть в БД
	 * @return string данные в формате JSON
	 */
	public function showMore(): string
	{
		try {
			if (empty($this->app->session['login'])) {
				throw new Exception('Sign in first!');
			}
			$productsCount = (int)($this->app->session['productsCount'] ?? 0);
			$page = (int)($this->app->session['productsPage'] ?? 0);
			$count = $page * 15;

			$this->template = 'productItem.twig';
			/**
			 * @var Product $products
			 */
			$products = Product::get(null, null, 15, $count);

			$newPage = ++$page;
			$responseType = 'else';
			$responseData = $this->render([
				'products' => $products
			]);

			if (empty($responseData)) {
				throw new Exception('There are no more products!');
			}

			if ($newPage * 15 >= $productsCount) {
				$responseType = '';
			}
			$_SESSION['productsPage'] = $newPage;

			return Functions::ajaxResponse($responseType, $responseData);
		} catch (Exception $e) {
			return Functions::ajaxResponse('error', $e->getMessage(), true);
		}
	}

	/**
	 * Добавляет товар в корзину
	 * @return string данные в формате JSON
	 */
	public function addToCart(): string
	{
		try {
			$productId = (int)$_POST['id'] ?? 0;

			/**
			 * @var User $user
			 */
			$user = $this->app->session['login'] ?? null;

			if (!$user) {
				throw new Exception('Sign in first!');
			}

			if (!$productId) {
				throw new Exception("Product with ID: $productId doesn't exist!");
			}

			/**
			 * @var Basket $basket
			 */
			$basket = Basket::getOne([
				[
					'col' => 'userId',
					'oper' => '=',
					'value' => $user->id
				],
				[
					'col' => 'productId',
					'oper' => '=',
					'value' => $productId
				]
			]);

			if (!$basket) {
				$basket = new Basket([
					'userId' => $user->id,
					'productId' => $productId,
				]);
			}
			$basket->amount++;
			$basket->save();

			if ($basket->amount > 1) {
				$type = 'update';
			} else {
				$type = 'add';
			}

			return Functions::ajaxResponse($type, $basket->amount);
		} catch (Exception $e) {
			return Functions::ajaxResponse('error', $e->getMessage(), true);
		}
	}

	/**
	 * Изменяет количество товара в корзине или удаляет, если количество = 0
	 * @return string данные в формате JSON
	 */
	public function update(): string
	{
		try {
			$data = $_POST ?? null;
			$id = (int)$data['id'] ?? 0;

			/**
			 * @var Basket $basketItem
			 */
			$basketItem = Basket::getByKey($id);
			if (!$basketItem) {
				throw new Exception("Your cart doesn't exist yet!");
			}
			$value = $data['value'] ?? 0;

			if ($value === '+') {
				$basketItem->amount++;
			} elseif ($value === '-') {
				$basketItem->amount--;
			} else {
				$basketItem->amount = $value;
			}
			$basketItem->save();

			if ($basketItem->amount === 0) {
				$basketItem->delete();
			}

			return Functions::ajaxResponse('update', $basketItem->amount);
		} catch (Exception $e) {
			return Functions::ajaxResponse('error', $e->getMessage(), true);
		}
	}

	/**
	 * Изменяет статус заказа
	 * @return string данные в формате JSON
	 */
	public function status(): string
	{
		try {
			$data = $_POST ?? null;
			$id = (int)$data['id'] ?? 0;

			/**
			 * @var Order $order
			 */
			$order = Order::getByKey($id);
			if (!$order) {
				throw new Exception("Order doesn't exist!");
			}
			$value = (int)$data['value'] ?? false;

			$order->status = $value;

			$order->save();

			return Functions::ajaxResponse('update', $order->status);
		} catch (Exception $e) {
			return Functions::ajaxResponse('error', $e->getMessage(), true);
		}
	}

	/**
	 * Формирует и сохраняет в БД заказ
	 * @return string данные в формате JSON
	 */
	public function order(): string
	{
		try {
			/**
			 * @var User $user
			 */
			$user = $this->app->session['login'];

			if (!$user) {
				throw new Exception('Sign in first!');
			}

			$basket = $user->getBasket();

			/**
			 * @var Order $order
			 */
			$order = new Order([
				'userId' => $user->id
			]);

			$order->save();

			$basketIds = [];
			foreach ($basket as $basketItem) {
				$basketIds[] = $basketItem->id;
				$orderItem = new OrderProduct([
					'orderId' => $order->id,
					'productId' => $basketItem->productId,
					'price' => $basketItem->product->price,
					'amount' => $basketItem->amount,
				]);
				$orderItem->save();
			}

			(new Basket([]))->delete($basketIds);

			return Functions::ajaxResponse('newOrder', $order->id);
		} catch (Exception $e) {
			return Functions::ajaxResponse('error', $e->getMessage(), true);
		}
	}
}