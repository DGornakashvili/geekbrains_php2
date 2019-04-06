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
     * @throws Exception
     */
    public function showMore()
    {
        try {
            if (empty($this->app->session['login'])) {
                throw new Exception('Sign in first!');
            }

            $method = $_POST['method'] ?? '';
            if ($method === 'showMore') {
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
                Functions::ajaxResponse($responseType, $responseData);
            }
        } catch (Exception $e) {
            Functions::ajaxResponse('error', $e->getMessage(), true);
        }
        exit();
    }

    /**
     *
     */
    public function addToCart()
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

            Functions::ajaxResponse($type, $basket->amount);
        } catch (Exception $e) {
            Functions::ajaxResponse('error', $e->getMessage(), true);
        }
        exit();
    }

    /**
     * Изменяет количество товара в корзине или удаляет, если количество = 0
     * @throws Exception
     */
    public function update()
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

            Functions::ajaxResponse('update', $basketItem->amount);
        } catch (Exception $e) {
            Functions::ajaxResponse('error', $e->getMessage(), true);
        }
        exit();
    }

    /**
     * Изменяет статус заказа
     * @throws Exception
     */
    public function status()
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

            Functions::ajaxResponse('update', $order->status);
        } catch (Exception $e) {
            Functions::ajaxResponse('error', $e->getMessage(), true);
        }
        exit();
    }

    /**
     * Формирует и сохраняет в БД заказ
     * @throws Exception
     */
    public function order()
    {
        try {
            /**
             * @var User $user
             */
            $user = $this->app->session['login'];

            if (!$user) {
                throw new Exception('Sign in first!');
            }
            /**
             * @var Basket $basket
             */
            $basket = $user->getBasket();

            /**
             * @var Order $order
             */
            $order = new Order([
                'userId' => $user->id
            ]);

            $order->save();

            $basketIds = [];
            foreach ($basket as $product) {
                $basketIds[] = $product->id;
                $orderItem = new OrderProduct([
                    'orderId' => $order->id,
                    'productId' => $product->productId,
                    'price' => $product->product->price,
                    'amount' => $product->amount,
                ]);
                $orderItem->save();
            }

            $basket->delete($basketIds);

            Functions::ajaxResponse('newOrder', $order->id);
        } catch (Exception $e) {
            Functions::ajaxResponse('error', $e->getMessage(), true);
        }
        exit();
    }
}