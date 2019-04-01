<?php

namespace App\Controllers;

class AccountController extends Controller
{
    protected $template = 'userAccount.twig';

    /**
     * @param array $data
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index($data = [])
    {
        if (!isset($this->app->session['login'])) {
            $result = "<h1>Sign in first!!!</h1>";
        } else {
            $pages = $this->app->session['visited'];

            if (!empty($pages)) {
                array_reverse($pages);
            }

            $result = $this->render([
                'title' => 'Account',
                'pages' => $pages
            ]);
        }
        return $result;
    }
}