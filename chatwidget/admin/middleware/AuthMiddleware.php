<?php
class AuthMiddleware {
    private static $instance = null;
    private $security;
    private $config;
    
    private function __construct() {
        $this->config = require dirname(__DIR__) . '/config/config.php';
        $this->security = Security::getInstance();
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function authenticate() {
        $this->security->initSession();
        
        // Skip authentication for login page and other public pages
        $publicPages = ['login.php', 'forgot_password.php', 'reset_password.php'];
        $currentPage = basename($_SERVER['SCRIPT_NAME']);
        
        if (in_array($currentPage, $publicPages)) {
            return true;
        }
        
        if (!$this->security->isAuthenticated()) {
            $this->redirectToLogin();
        }
        
        // Check CSRF token for POST requests
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['csrf_token']) || !$this->security->verifyCSRFToken($_POST['csrf_token'])) {
                $this->security->logout();
                $this->redirectToLogin('Invalid form submission. Please try again.');
            }
        }
        
        return true;
    }
    
    public function requireRole($requiredRole) {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== $requiredRole) {
            $this->redirectWithError('You do not have permission to access this page.');
        }
    }
    
    private function redirectToLogin($error = null) {
        if ($error) {
            $_SESSION['login_error'] = $error;
        }
        header('Location: ' . $this->config['url']['admin'] . '/login.php');
        exit();
    }
    
    private function redirectWithError($error) {
        $_SESSION['error_message'] = $error;
        header('Location: ' . $this->config['url']['admin'] . '/index.php');
        exit();
    }
    
    // Prevent cloning of the instance
    private function __clone() {}
    
    // Prevent unserialize of the instance
    private function __wakeup() {}
} 