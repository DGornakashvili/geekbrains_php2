<?php

namespace App\Controllers;

use App\Models\User;

class SignController extends Controller
{
    protected $template = 'signForm.twig';
    protected $name;
    protected $login;
    protected $password;

    public function __construct()
    {
        parent::__construct();
        $this->name = $_POST['name'] ?? '';
        $this->login = $_POST['login'] ?? '';
        $this->password = md5($_POST['password'] ?? '');
    }

    /**
     * @param array $data
     * @return string|void
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index($data = [])
    {
        if (!isset($this->app->session['login'])) {
            if (!(isset($_POST['login']) && isset($_POST['password']))) {
                return $this->render(['title' => 'Sign in']);
            } else {

                $user = User::getOne([
                    [
                        'col' => 'login',
                        'oper' => '=',
                        'value' => $this->login
                    ],
                    [
                        'col' => 'password',
                        'oper' => '=',
                        'value' =>  $this->password
                    ]
                ]);

                if ($user) {
                    $this->app->session['visited'] = [];
                    $this->app->session['login'] = $user;
                    return header('Location: /account/');
                } else {
                    echo "<h2>User with Login: $this->login doesn't exist!</h2>";
                    return $this->render();
                }
            }
        }
    }

    /**
     * @return string|void
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function up()
    {
        $this->template = 'signUpForm.twig';

        if (!(isset($_POST['login']) && isset($_POST['password']))) {
            return $this->render(['title' => 'Sign up',]);
        } else {
            $user = (new User([
                'name' => $this->name,
                'login' => $this->login,
                'password' => $this->password
            ]))->save();

            if ($user) {
                $this->app->session['login'] = $user;
                $this->app->session['visited'] = [];
                return header('Location: /account/');
            } else {
                echo "<h2>404! Please, try again later!</h2>";
                return $this->render();
            }
        }
    }

    /**
     *
     */
    public function out()
    {
        session_destroy();
        return header('Location: /');
    }
}