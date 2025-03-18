<?php
require_once(__DIR__ . '/Database.php');
require_once(__DIR__ . '/Security.php');
require_once(__DIR__ . '/../middleware/AuthMiddleware.php');

// Initialize authentication
$auth = AuthMiddleware::getInstance();
$auth->authenticate();

// Get configuration
$config = require dirname(__DIR__) . '/config/config.php';

// Initialize security
$security = Security::getInstance();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="noindex, nofollow">
    <meta name="csrf-token" content="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
    
    <title><?php echo htmlspecialchars($pageTitle ?? 'Admin Dashboard'); ?> - Chat Widget</title>
    
    <!-- Security Headers -->
    <?php
    header("X-Frame-Options: DENY");
    header("X-XSS-Protection: 1; mode=block");
    header("X-Content-Type-Options: nosniff");
    header("Referrer-Policy: same-origin");
    header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' https://cdn.tailwindcss.com; style-src 'self' 'unsafe-inline' https://cdn.tailwindcss.com; img-src 'self' data:;");
    ?>
    
    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .sidebar-link {
            @apply flex items-center px-4 py-2 text-gray-600 hover:bg-gray-100 hover:text-gray-800;
        }
        .sidebar-link.active {
            @apply bg-gray-100 text-gray-800;
        }
    </style>
    
    <!-- Prevent form resubmission -->
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-lg">
            <div class="p-4">
                <h1 class="text-xl font-bold text-gray-800">Chat Widget</h1>
                <p class="text-sm text-gray-600">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></p>
            </div>
            
            <nav class="mt-4">
                <?php if ($_SESSION['role'] === 'admin'): ?>
                <a href="index.php" class="sidebar-link <?php echo basename($_SERVER['SCRIPT_NAME']) === 'index.php' ? 'active' : ''; ?>">
                    Dashboard
                </a>
                <a href="create_admin.php" class="sidebar-link <?php echo basename($_SERVER['SCRIPT_NAME']) === 'create_admin.php' ? 'active' : ''; ?>">
                    Manage Admins
                </a>
                <?php endif; ?>
                
                <a href="botlist.php" class="sidebar-link <?php echo basename($_SERVER['SCRIPT_NAME']) === 'botlist.php' ? 'active' : ''; ?>">
                    My Bots
                </a>
                <a href="addbot.php" class="sidebar-link <?php echo basename($_SERVER['SCRIPT_NAME']) === 'addbot.php' ? 'active' : ''; ?>">
                    Add New Bot
                </a>
                <a href="widget_code.php" class="sidebar-link <?php echo basename($_SERVER['SCRIPT_NAME']) === 'widget_code.php' ? 'active' : ''; ?>">
                    Get Widget Code
                </a>
                <a href="../index.php" class="sidebar-link <?php echo basename($_SERVER['SCRIPT_NAME']) === 'preview.php' ? 'active' : ''; ?>">
                    Preview Bot
                </a>
                
                <div class="border-t border-gray-200 mt-4 pt-4">
                    <a href="profile.php" class="sidebar-link <?php echo basename($_SERVER['SCRIPT_NAME']) === 'profile.php' ? 'active' : ''; ?>">
                        My Profile
                    </a>
                    <a href="logout.php" class="sidebar-link text-red-600 hover:text-red-800">
                        Logout
                    </a>
                </div>
            </nav>
        </div>
        
        <!-- Main Content -->
        <div class="flex-1 p-8">
            <?php if (isset($_SESSION['success_message'])): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    <?php 
                    echo htmlspecialchars($_SESSION['success_message']);
                    unset($_SESSION['success_message']);
                    ?>
                </div>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['error_message'])): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <?php 
                    echo htmlspecialchars($_SESSION['error_message']);
                    unset($_SESSION['error_message']);
                    ?>
                </div>
            <?php endif; ?>
            
            <div class="bg-white rounded-lg shadow-lg p-6">
                <?php if (isset($pageTitle)): ?>
                    <h2 class="text-2xl font-semibold mb-6"><?php echo htmlspecialchars($pageTitle); ?></h2>
                <?php endif; ?>
                
                <?php echo $content ?? ''; ?>
            </div>
        </div>
    </div>
    
    <!-- CSRF Token for AJAX requests -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add CSRF token to all AJAX requests
            let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            let oldXHR = window.XMLHttpRequest;
            function newXHR() {
                let xhr = new oldXHR();
                xhr.addEventListener('open', function() {
                    xhr.setRequestHeader('X-CSRF-Token', token);
                });
                return xhr;
            }
            window.XMLHttpRequest = newXHR;
        });
    </script>
</body>
</html> 