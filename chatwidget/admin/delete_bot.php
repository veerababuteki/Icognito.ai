<?php
require_once(__DIR__ . '/includes/Config.php');
require_once(__DIR__ . '/includes/Database.php');
require_once(__DIR__ . '/includes/Security.php');
require_once(__DIR__ . '/includes/AuthMiddleware.php');
require_once(__DIR__ . '/includes/helpers.php');

use Admin\Includes\AuthMiddleware;
use Admin\Includes\Database;
use Admin\Includes\Security;

// Initialize authentication
$auth = AuthMiddleware::getInstance();
$auth->authenticate();

// Initialize database connection
$db = Database::getInstance();

// Set JSON response header
header('Content-Type: application/json');

try {
    // Get JSON input
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input || !isset($input['bot_id']) || !isset($input['csrf_token'])) {
        throw new \Exception('Invalid request data');
    }
    
    // Verify CSRF token
    $security = Security::getInstance();
    if (!$security->verifyCSRFToken($input['csrf_token'])) {
        throw new \Exception('Invalid form submission');
    }
    
    $bot_id = (int)$input['bot_id'];
    $user_id = $_SESSION['user_id'] ?? 0;
    $role = $_SESSION['user_role'] ?? '';
    
    // Check if user has permission to delete this bot
    if ($role !== 'admin') {
        // Verify bot ownership
        $stmt = $db->prepare("SELECT user_id FROM settings WHERE id = ?");
        $stmt->bind_param('i', $bot_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $bot = $result->fetch_assoc();
        
        if (!$bot || $bot['user_id'] != $user_id) {
            throw new \Exception('You do not have permission to delete this bot');
        }
    }
    
    // Start transaction
    $db->beginTransaction();
    
    try {
        // Delete custom theme if exists
        $stmt = $db->prepare("DELETE FROM custom_themes WHERE settings_id = ?");
        $stmt->bind_param('i', $bot_id);
        $stmt->execute();
        
        // Delete the bot settings
        $stmt = $db->prepare("DELETE FROM settings WHERE id = ?");
        $stmt->bind_param('i', $bot_id);
        $stmt->execute();
        
        // Commit transaction
        $db->commit();
        
        // Log the deletion
        log_audit('Bot deleted', [
            'bot_id' => $bot_id,
            'user_id' => $user_id,
            'role' => $role
        ]);
        
        echo json_encode([
            'success' => true,
            'message' => 'Bot deleted successfully'
        ]);
        
    } catch (\Exception $e) {
        // Rollback transaction on error
        $db->rollback();
        throw $e;
    }
    
} catch (\Exception $e) {
    // Log error
    log_error('Bot deletion error', [
        'error' => $e->getMessage(),
        'user_id' => $_SESSION['user_id'] ?? 0,
        'bot_id' => $input['bot_id'] ?? 0
    ]);
    
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
} 