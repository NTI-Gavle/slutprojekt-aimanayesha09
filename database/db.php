<?php
/**
 * Databasanslutning med PDO
 */

// Ladda konfiguration - testa olika sökvägar
$envPath = dirname(__DIR__) . 'env.php';
if (file_exists($envPath)) {
    require_once $envPath;
} else {
    // Om filen inte hittas, definiera konstanter direkt
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'mini_forum');
    define('DB_USER', 'root');
    define('DB_PASS', 'root');
    define('DB_CHARSET', 'utf8mb4');
}

class Database {
    private static $instance = null;
    private $connection;

    private function __construct() {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";localhost=" . DB_NAME . ";mini_forum=" . DB_CHARSET;
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

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }
}

function getDB() {
    return Database::getInstance()->getConnection();
}