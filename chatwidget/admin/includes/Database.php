<?php
namespace Admin\Includes;

class Database {
    private static $instance = null;
    private $connection;
    private $config;
    
    private function __construct() {
        $this->config = Config::getInstance();
        $this->connect();
    }
    
    private function connect() {
        $host = $this->config->get('database.host');
        $username = $this->config->get('database.username');
        $password = $this->config->get('database.password');
        $database = $this->config->get('database.name');
        
        $this->connection = new \mysqli($host, $username, $password, $database);
        
        if ($this->connection->connect_error) {
            throw new \Exception("Connection failed: " . $this->connection->connect_error);
        }
        
        $this->connection->set_charset("utf8mb4");
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function prepare($sql) {
        return $this->connection->prepare($sql);
    }
    
    public function query($sql) {
        return $this->connection->query($sql);
    }
    
    public function beginTransaction() {
        $this->connection->begin_transaction();
    }
    
    public function commit() {
        $this->connection->commit();
    }
    
    public function rollback() {
        $this->connection->rollback();
    }
    
    public function escape($string) {
        return $this->connection->real_escape_string($string);
    }
    
    public function getLastError() {
        return $this->connection->error;
    }
    
    public function getLastId() {
        return $this->connection->insert_id;
    }
    
    public function close() {
        if ($this->connection) {
            $this->connection->close();
        }
    }
    
    private function logError($exception) {
        $logFile = $this->config['paths']['logs'] . '/db_errors.log';
        $message = date('Y-m-d H:i:s') . " - " . $exception->getMessage() . "\n";
        file_put_contents($logFile, $message, FILE_APPEND);
    }
    
    public function __destruct() {
        $this->close();
    }
    
    // Prevent cloning of the instance
    private function __clone() {}
    
    // Prevent unserialize of the instance
    public function __wakeup() {
        throw new \Exception("Cannot unserialize singleton");
    }
} 