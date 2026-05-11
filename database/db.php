<?php

$envConfigPath = dirname(__DIR__) . '/config/env.php';
if (file_exists($envConfigPath)) {
    require_once $envConfigPath;
}

$env = function_exists('loadEnv')
    ? loadEnv(dirname(__DIR__) . '/.env')
    : [];

defined('DB_HOST') || define('DB_HOST', $env['DB_HOST'] ?? 'localhost');
defined('DB_NAME') || define('DB_NAME', $env['DB_NAME'] ?? 'mini_forum');
defined('DB_USER') || define('DB_USER', $env['DB_USER'] ?? 'root');
defined('DB_PASS') || define('DB_PASS', $env['DB_PASS'] ?? 'root');
defined('DB_CHARSET') || define('DB_CHARSET', $env['DB_CHARSET'] ?? 'utf8mb4');

class Database
{
    private static $instance = null;
    private $connection;

    private function __construct()
    {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            $this->connection = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            die("Databasfel: " . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getConnection()
    {
        return $this->connection;
    }
}

function getDB()
{
    return Database::getInstance()->getConnection();
}
