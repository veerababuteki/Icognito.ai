<?php
namespace Admin\Includes;

class Security {
    private static $instance = null;
    private $config;
    private $db;
    
    private function __construct() {
        $this->config = Config::getInstance();
        $this->db = Database::getInstance();
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function initSession() {
        // Set secure session parameters before starting the session
        if (session_status() === PHP_SESSION_NONE) {
            ini_set('session.cookie_httponly', 1);
            ini_set('session.use_only_cookies', 1);
            if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
                ini_set('session.cookie_secure', 1);
            }
            session_start();
        }
        
        // Generate CSRF token if not exists
        if (!isset($_SESSION['csrf_token']) || 
            !isset($_SESSION['csrf_token_time']) || 
            time() - $_SESSION['csrf_token_time'] > $this->config->get('security.csrf_token_expiry')) {
            $this->regenerateCSRFToken();
        }
    }
    
    public function regenerateCSRFToken() {
        $token = bin2hex(random_bytes($this->config->get('security.csrf_token_length')));
        $_SESSION['csrf_token'] = $token;
        $_SESSION['csrf_token_time'] = time();
        return $token;
    }
    
    public function verifyCSRFToken($token) {
        if (!isset($_SESSION['csrf_token']) || !isset($_SESSION['csrf_token_time'])) {
            return false;
        }
        
        if (time() - $_SESSION['csrf_token_time'] > $this->config->get('security.csrf_token_expiry')) {
            return false;
        }
        
        return hash_equals($_SESSION['csrf_token'], $token);
    }
    
    public function login($email, $password, $remember = false) {
        try {
            // Check login attempts
            if ($this->isLockedOut($email)) {
                throw new \Exception("Too many failed attempts. Please try again later.");
            }
            
            // Get user
            $stmt = $this->db->prepare("SELECT id, username, email, password, role FROM admin_users WHERE email = ?");
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            
            if (!$user || !password_verify($password, $user['password'])) {
                $this->logLoginAttempt($email, false);
                throw new \Exception("Invalid email or password");
            }
            
            // Set session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['authenticated'] = true;
            $_SESSION['last_activity'] = time();
            
            // Update last login
            $stmt = $this->db->prepare("UPDATE admin_users SET created_at = NOW() WHERE id = ?");
            $stmt->bind_param('i', $user['id']);
            $stmt->execute();
            
            // Log successful attempt
            $this->logLoginAttempt($email, true);
            
            // Handle remember me
            if ($remember) {
                $this->setRememberMeToken($user['id']);
            }
            
            return true;
            
        } catch (\Exception $e) {
            log_error('Login error', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
    
    public function isAuthenticated() {
        if (!isset($_SESSION['authenticated']) || !$_SESSION['authenticated']) {
            return false;
        }
        
        if (!isset($_SESSION['last_activity']) || 
            time() - $_SESSION['last_activity'] > $this->config->get('security.session_lifetime')) {
            $this->logout();
            return false;
        }
        
        $_SESSION['last_activity'] = time();
        return true;
    }
    
    public function logout() {
        // Clear session
        session_unset();
        session_destroy();
        
        // Clear remember me cookie if exists
        if (isset($_COOKIE['remember_token'])) {
            setcookie('remember_token', '', time() - 3600, '/', '', true, true);
        }
    }
    
    private function isLockedOut($email) {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as attempts 
            FROM login_attempts 
            WHERE email = ? 
            AND success = 0 
            AND attempt_time > DATE_SUB(NOW(), INTERVAL ? SECOND)
        ");
        
        $lockout_time = $this->config->get('security.lockout_time');
        $stmt->bind_param('si', $email, $lockout_time);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        return $row['attempts'] >= $this->config->get('security.max_login_attempts');
    }
    
    private function logLoginAttempt($email, $success) {
        $stmt = $this->db->prepare("
            INSERT INTO login_attempts (email, ip_address, success) 
            VALUES (?, ?, ?)
        ");
        
        $ip = $_SERVER['REMOTE_ADDR'];
        $success_int = $success ? 1 : 0;
        $stmt->bind_param('ssi', $email, $ip, $success_int);
        $stmt->execute();
    }
    
    private function setRememberMeToken($user_id) {
        $token = bin2hex(random_bytes(32));
        $expires = time() + (30 * 24 * 60 * 60); // 30 days
        
        $stmt = $this->db->prepare("
            INSERT INTO user_sessions (user_id, session_id, ip_address, user_agent, last_activity) 
            VALUES (?, ?, ?, ?, NOW())
        ");
        
        $ip = $_SERVER['REMOTE_ADDR'];
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $stmt->bind_param('isss', $user_id, $token, $ip, $user_agent);
        $stmt->execute();
        
        setcookie('remember_token', $token, $expires, '/', '', true, true);
    }
    
    // Prevent cloning of the instance
    private function __clone() {}
    
    // Prevent unserialize of the instance
    public function __wakeup() {
        throw new \Exception("Cannot unserialize singleton");
    }
} 