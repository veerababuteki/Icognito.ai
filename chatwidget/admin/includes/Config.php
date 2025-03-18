<?php
namespace Admin\Includes;

class Config {
    private static $instance = null;
    private $config = [];
    
    private function __construct() {
        $this->loadConfig();
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function loadConfig() {
        $configFile = dirname(__DIR__) . '/config/config.php';
        if (file_exists($configFile)) {
            $this->config = require $configFile;
        } else {
            throw new \Exception("Configuration file not found");
        }
    }
    
    public function get($key, $default = null) {
        $keys = explode('.', $key);
        $value = $this->config;
        
        foreach ($keys as $k) {
            if (!isset($value[$k])) {
                return $default;
            }
            $value = $value[$k];
        }
        
        return $value;
    }
    
    public function set($key, $value) {
        $keys = explode('.', $key);
        $config = &$this->config;
        
        foreach ($keys as $k) {
            if (!isset($config[$k])) {
                $config[$k] = [];
            }
            $config = &$config[$k];
        }
        
        $config = $value;
    }
    
    public function has($key) {
        $keys = explode('.', $key);
        $value = $this->config;
        
        foreach ($keys as $k) {
            if (!isset($value[$k])) {
                return false;
            }
            $value = $value[$k];
        }
        
        return true;
    }
    
    // Prevent cloning of the instance
    private function __clone() {}
    
    // Prevent unserialize of the instance
    public function __wakeup() {
        throw new \Exception("Cannot unserialize singleton");
    }
} 