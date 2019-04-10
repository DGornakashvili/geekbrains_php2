<?php

require_once __DIR__ . '/../config/config.php';

use \App\App;

$app = App::getInstance();
$app->run();