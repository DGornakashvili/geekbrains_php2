<?php

define('SITE_DIR', __DIR__ . '/../');
define('WWW_DIR', SITE_DIR . 'public/');
define('ENGINE_DIR', SITE_DIR . 'App/');
define('TPL_DIR', SITE_DIR . 'templates/');
define('VENDOR_DIR', SITE_DIR . 'vendor/');
define('IMG_DIR', 'img/');

define('DB_DNS', 'mysql:dbname=geek_brains_shop;host=localhost');
define('DB_USER', 'geek_brains');
define('DB_PASS', '123123');

require_once VENDOR_DIR . 'autoload.php';