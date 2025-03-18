<?php
namespace Admin\Includes;

class AuthMiddleware {
    private static $instance = null;
    private $config;
    private $security;
    
    private function __construct() {
        $this->config = Config::getInstance();
        $this->security = Security::getInstance();
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function authenticate() {
        // Initialize session
        $this->security->initSession();
        
        // Get current page name
        $current_page = basename($_SERVER['PHP_SELF']);
        
        // Check if current page is public
        $public_pages = $this->config->get('public_pages', []);
        if (in_array($current_page, $public_pages)) {
            return true;
        }
        
        // Check if user is authenticated
        if (!$this->security->isAuthenticated()) {
            $this->redirectToLogin();
            return false;
        }
        
        // Get user role
        $user_role = $_SESSION['user_role'] ?? '';
        
        // Allow subscribers to access specific pages
        $subscriber_pages = [
            'botlist.php',
            'edit_bot.php',
            'widget_code.php',
            'delete_bot.php',
            'preview.php'
        ];
        
        if ($user_role === 'subscriber' && !in_array($current_page, $subscriber_pages)) {
            $this->handleError('You do not have permission to access this page.');
            return false;
        }
        
        // For POST requests, verify CSRF token
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->security->verifyCSRFToken($_POST['csrf_token'] ?? '')) {
                $this->handleError('Invalid form submission. Please try again.');
                return false;
            }
        }
        
        return true;
    }
    
    public function requireRole($required_role) {
        if (!$this->security->isAuthenticated()) {
            $this->redirectToLogin();
            return false;
        }
        
        $user_role = $_SESSION['user_role'] ?? '';
        if ($user_role !== $required_role) {
            $this->handleError('You do not have permission to access this page.');
            return false;
        }
        
        return true;
    }
    
    private function redirectToLogin() {
        $login_url = $this->config->get('paths.root') . '/login.php';
        $current_url = $_SERVER['REQUEST_URI'];
        
        // Store the current URL in session for redirect after login
        $_SESSION['redirect_after_login'] = $current_url;
        
        header("Location: " . $login_url);
        exit();
    }
    
    private function handleError($message) {
        $_SESSION['error'] = $message;
        header("Location: " . $_SERVER['HTTP_REFERER'] ?? 'index.php');
        exit();
    }
    
    // Prevent cloning of the instance
    private function __clone() {}
    
    // Prevent unserialize of the instance
    public function __wakeup() {
        throw new Exception("Cannot unserialize singleton");
    }
} 