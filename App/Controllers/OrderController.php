<?php


namespace App\Controllers;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use \Exception;

class OrderController extends Controller
{
    protected $template = 'orders.twig';

    /**
     * Выводит страницу заказа
     * @param array $data
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index(array $data = [])
    {
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
     * @param array $data
     * @return string
     * @throws Exception
     */
    public function getAllOrders(array $data = [])
    {
        if (empty($this->app->session['login'])) {
            header('Location: /sign/');
            die;
        }

        if ($this->app->session['login']->role !== 1) {
            throw new Exception('Access dined!');
        }

        $orders = Order::getWithProducts();
        arsort($orders);

        return $this->render([
            'title' => 'Orders',
            'orders' => $orders
        ]);
    }
}