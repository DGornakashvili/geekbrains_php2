<?php


namespace App\Controllers;

use App\Models\User;

class BasketController extends Controller
{
    /**
     * Выводит страницу корзины
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        if (empty($this->app->session['login'])) {
            header('Location: /sign/');
            die;
        }
        /**
         * @var User $user
         */
        $user = $this->app->session['login'];
        $this->template = 'cart.twig';
        return $this->render([
            'basket' => $user->getBasket()
        ]);
    }
}