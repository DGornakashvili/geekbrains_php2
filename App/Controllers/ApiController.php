<?php

namespace App\Controllers;

use App\Classes\Functions;
use App\Models\Basket;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use \Exception;

class ApiController extends Controller
{
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
                $products = Product::get(null, null, 15, $count);

                $newPage = ++$page;
                $responseType = 'else';
                $responseData = $this->render([
                    'products' => $products,
                    'userStatus' => isset($this->app->session['login']) ? true : false
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
            $user = $this->app->session['login'] ?? null;

            if (!$user) {
                throw new Exception('Sign in first!');
            }

            if (!$productId) {
                throw new Exception("Product with ID: $productId doesn't exist!");
            }
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

    public function order()
    {
        try {
            $user = $this->app->session['login'];

            if (!$user) {
                throw new Exception('Sign in first!');
            }
            $basket = $user->getBasket();

            $order = new Order([
                'userId' => $user->id
            ]);

            $order->save();

            $order = $order->getOne([
                [
                    'col' => 'userId',
                    'oper' => '=',
                    'value' => $user->id
                ]
            ],[['col' => 'id', 'direction' => 'desc']]);

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
            $basket = new Basket([]);

            $basket->delete($basketIds);

            Functions::ajaxResponse('newOrder', $order->id);
        } catch (Exception $e) {
            Functions::ajaxResponse('error', $e->getMessage(), true);
        }
        exit();
    }
}