<?php
return [
    'database' => [
        'host' => 'icognito.ai',
        'username' => 'iicl',
        'password' => 'IiclIndia@123',
        'name' => 'incognito_new',
        'charset' => 'utf8mb4'
    ],
    
    'security' => [
        'session_name' => 'ICOGNITO_SESS',
        'session_lifetime' => 3600,
        'max_login_attempts' => 5,
        'lockout_time' => 900,
        'password_min_length' => 8,
        'password_require_special' => true,
        'password_require_number' => true,
        'password_history_size' => 5,
        'csrf_token_name' => 'icognito_csrf',
        'csrf_token_length' => 32,
        'csrf_token_expiry' => 3600,
        'secure_cookies' => true,
        'cookie_httponly' => true,
        'cookie_samesite' => 'Lax'
    ],
    
    'paths' => [
        'root' => dirname(dirname(__FILE__)),
        'logs' => dirname(dirname(__FILE__)) . '/logs',
        'uploads' => dirname(dirname(__FILE__)) . '/uploads',
        'templates' => dirname(dirname(__FILE__)) . '/templates'
    ],
    
    'logging' => [
        'error_log' => dirname(dirname(__FILE__)) . '/logs/error.log',
        'security_log' => dirname(dirname(__FILE__)) . '/logs/security.log',
        'db_log' => dirname(dirname(__FILE__)) . '/logs/db_errors.log',
        'audit_log' => dirname(dirname(__FILE__)) . '/logs/audit.log'
    ],
    
    'public_pages' => [
        'login.php',
        'forgot-password.php',
        'reset-password.php'
    ],
    
    'rbac' => [
        'admin' => [
            'manage_users',
            'manage_settings',
            'view_logs',
            'manage_themes'
        ],
        'subscriber' => [
            'view_dashboard',
            'manage_own_settings',
            'manage_own_theme',
            'edit_own_bot',
            'view_botlist',
            'get_bot_code',
            'delete_own_bot',
            'preview_bot'
        ]
    ]
]; 