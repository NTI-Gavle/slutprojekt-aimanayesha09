<?php
if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', dirname(__DIR__));
}

define('SITE_NAME', 'Mini Forum');

ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);

error_reporting(E_ALL);
ini_set('display_errors', 1);

date_default_timezone_set('Europe/Stockholm');
