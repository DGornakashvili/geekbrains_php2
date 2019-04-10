<?php

namespace App\Controllers;

use App\Models\Product;
use \Exception;

class ProductsController extends Controller
{
	protected $template = 'products.twig';

	/**
	 * Выводит страницу продуктов
	 * @return string страница продуктов, если передан id, соответствеющий продукт
	 * @throws Exception Если пользователь не авторизован
	 */
	public function index(): string
	{
		if (isset($this->app->session['login'])) {
			$this->app->session['productsCount'] = Product::getCount();
			$this->app->session['productsPage'] = 1;

			if (isset($_GET['id'])) {
				$id = (int)($_GET['id'] ?? 0);
				$this->template = 'singleProduct.twig';

				/**
				 * @var Product $product
				 */
				$product = Product::getByKey($id);

				$renderData = [
					'title' => "Product $id",
					'product' => $product
				];
			} else {
				/**
				 * @var Product $products
				 */
				$products = Product::get(null, null, 15, 0);

				$renderData = [
					'title' => 'Products',
					'products' => $products
				];
			}
			return $this->render($renderData);
		} else {
			throw new Exception('Sign in first!');
		}
	}
}