<?php
namespace Admin\Includes;

function log_error($message, $context = []) {
    $config = Config::getInstance();
    $logFile = $config->get('logging.error_log');
    
    // Ensure log directory exists
    $logDir = dirname($logFile);
    if (!is_dir($logDir)) {
        mkdir($logDir, 0755, true);
    }
    
    $logEntry = [
        'timestamp' => date('Y-m-d H:i:s'),
        'message' => $message,
        'context' => $context,
        'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown'
    ];
    
    $logMessage = json_encode($logEntry) . "\n";
    file_put_contents($logFile, $logMessage, FILE_APPEND);
}

function log_security($message, $context = []) {
    $config = Config::getInstance();
    $logFile = $config->get('logging.security_log');
    
    // Ensure log directory exists
    $logDir = dirname($logFile);
    if (!is_dir($logDir)) {
        mkdir($logDir, 0755, true);
    }
    
    $logEntry = [
        'timestamp' => date('Y-m-d H:i:s'),
        'message' => $message,
        'context' => $context,
        'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown'
    ];
    
    $logMessage = json_encode($logEntry) . "\n";
    file_put_contents($logFile, $logMessage, FILE_APPEND);
}

function log_audit($message, $context = []) {
    $config = Config::getInstance();
    $logFile = $config->get('logging.audit_log');
    
    // Ensure log directory exists
    $logDir = dirname($logFile);
    if (!is_dir($logDir)) {
        mkdir($logDir, 0755, true);
    }
    
    $logEntry = [
        'timestamp' => date('Y-m-d H:i:s'),
        'message' => $message,
        'context' => $context,
        'user_id' => $_SESSION['user_id'] ?? 'anonymous',
        'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown'
    ];
    
    $logMessage = json_encode($logEntry) . "\n";
    file_put_contents($logFile, $logMessage, FILE_APPEND);
}

function log_db_error($message, $context = []) {
    $config = Config::getInstance();
    $logFile = $config->get('logging.db_log');
    
    // Ensure log directory exists
    $logDir = dirname($logFile);
    if (!is_dir($logDir)) {
        mkdir($logDir, 0755, true);
    }
    
    $logEntry = [
        'timestamp' => date('Y-m-d H:i:s'),
        'message' => $message,
        'context' => $context,
        'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown'
    ];
    
    $logMessage = json_encode($logEntry) . "\n";
    file_put_contents($logFile, $logMessage, FILE_APPEND);
} 