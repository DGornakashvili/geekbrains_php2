<?php

namespace App;
require_once __DIR__ . '/../config/config.php';

use App\Traits\SingletonTrait;
use \Exception;

class App
{
    use SingletonTrait;

    public $session = false;

    public function run()
    {
        session_start();
        $this->session = &$_SESSION;

        try {
            $path = $_REQUEST['path'] ?? '';

            $params = [];

            foreach (explode('/', $path) as $item) {
                if (!$item) {
                    continue;
                }
                $params[] = $item;
            }

            $controller = ucfirst($params[0] ?? 'index');
            $method = $params[1] ?? 'index';

            if (isset($this->session['login']) && $controller !== 'Api') {
                $this->session['visited'][] = [
                    'name' => $controller,
                    'url' => $path === '' ? '/' : "/$path/"
                ];
                if (count($this->session['visited']) > 4) {
                    array_shift($this->session['visited']);
                }
            }

            $controllerName = 'App\\Controllers\\' . $controller . 'Controller';

            if (!class_exists($controllerName)) {
                throw new Exception('Контроллер не найден');
            }

            $controller = new $controllerName;

            if (!method_exists($controller, $method)) {
                throw new Exception('Метод не найден');
            }

            echo $controller->$method();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}