<?php

namespace App\Controllers;

use App\Models\User;

class SignController extends Controller
{
	protected $template = 'signForm.twig';
	/**
	 * @var string Имя пользователя
	 */
	protected $name;
	/**
	 * @var string Логин пользователя
	 */
	protected $login;
	/**
	 * @var string Пароль пользователя
	 */
	protected $password;

	public function __construct()
	{
		parent::__construct();
		$this->name = $_POST['name'] ?? '';
		$this->login = $_POST['login'] ?? '';
		$this->password = md5($_POST['password'] ?? '');
	}

	/**
	 * Авторизация пользователя
	 * @return string|void страница авторизации
	 * @throws - ошибки шаблонизатора
	 */
	public function index()
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
					]
				]);

				if (password_verify($this->password, $user->password)) {
					$this->app->session['visited'] = [];
					$this->app->session['login'] = $user;
					return header('Location: /account/');
				} else {
					echo "<h2>User with Login: $this->login doesn't exist!</h2>";
					return $this->render(['title' => 'Sign in']);
				}
			}
		}
	}

	/**
	 * Регистрация пользователя
	 * @return string|void страница регистрации
	 * @throws - ошибки шаблонизатора
	 */
	public function up()
	{
		$this->template = 'signUpForm.twig';

		if (!(isset($_POST['login']) && isset($_POST['password']))) {
			return $this->render(['title' => 'Sign up',]);
		} else {
			/**
			 * @var User $user
			 */
			$user = new User([
				'name' => $this->name,
				'login' => $this->login,
				'password' => password_hash($this->password, PASSWORD_DEFAULT)
			]);
			$user->save();

			if ($user) {
				$this->app->session['login'] = $user;
				$this->app->session['visited'] = [];
				return header('Location: /account/');
			} else {
				echo "<h2>404! Please, try again later!</h2>";
				return $this->render(['title' => 'Sign up',]);
			}
		}
	}

	/**
	 * Выход пользователя
	 */
	public function out()
	{
		session_destroy();
		return header('Location: /');
	}
}