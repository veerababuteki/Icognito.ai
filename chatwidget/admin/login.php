<?php
require_once(__DIR__ . '/includes/Config.php');
require_once(__DIR__ . '/includes/Database.php');
require_once(__DIR__ . '/includes/Security.php');
require_once(__DIR__ . '/includes/AuthMiddleware.php');
require_once(__DIR__ . '/includes/helpers.php');

use Admin\Includes\AuthMiddleware;
use Admin\Includes\Database;
use Admin\Includes\Security;
use function Admin\Includes\log_error;

// Initialize security and session
$security = Security::getInstance();
$security->initSession();

// Redirect if already authenticated
if ($security->isAuthenticated()) {
    $role = $_SESSION['user_role'] ?? '';
    if ($role === 'admin') {
        header('Location: index.php');
    } else {
        header('Location: botlist.php');
    }
    exit;
}

$error = '';
$success = '';
$email = ''; // Initialize email variable

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validate CSRF token
        if (!isset($_POST['csrf_token']) || !$security->verifyCSRFToken($_POST['csrf_token'])) {
            throw new \Exception('Invalid form submission');
        }
        
        // Validate input
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = $_POST['password'] ?? '';
        $remember = isset($_POST['remember_me']); // Changed to match form field name
        
        if (!$email) {
            throw new \Exception('Please enter a valid email address');
        }
        
        if (empty($password)) {
            throw new \Exception('Please enter your password');
        }
        
        // Attempt login
        // print_r($security->login($email, $password, $remember));
        // exit;
        if ($security->login($email, $password, $remember)) {
            $success = 'Login successful! Redirecting...';
            header('Refresh: 2; URL=botlist.php');
        }
        
    } catch (\Exception $e) {
        $error = $e->getMessage();
        log_error('Login error', ['error' => $e->getMessage(), 'email' => $email]);
    }
}

// Generate new CSRF token
$csrf_token = $security->regenerateCSRFToken();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Chat Widget Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Prevent form resubmission
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full mx-4">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800">Welcome</h2>
                <p class="text-gray-600 mt-2">Login to your dashboard</p>
            </div>

            <?php if($error): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <?php echo htmlspecialchars($error); ?>
            </div>
            <?php endif; ?>

            <?php if($success): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                <?php echo htmlspecialchars($success); ?>
            </div>
            <?php endif; ?>

            <form method="post" class="space-y-6">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                    <input type="email" id="email" name="email" 
                           value="<?php echo htmlspecialchars($email); ?>" 
                           required 
                           autocomplete="email"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500">
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" id="password" name="password" 
                           required 
                           autocomplete="current-password"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500">
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input type="checkbox" id="remember_me" name="remember_me" 
                               class="h-4 w-4 text-gray-600 focus:ring-gray-500 border-gray-300 rounded">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-700">
                            Remember me
                        </label>
                    </div>
                    
                    <div class="text-sm">
                        <a href="forgot_password.php" class="text-gray-600 hover:text-gray-800">
                            Forgot your password?
                        </a>
                    </div>
                </div>
                
                <div>
                    <button type="submit" name="submit" 
                            class="w-full bg-gray-600 text-white py-2 px-4 rounded-lg hover:bg-gray-700 transition-colors">
                        Login
                    </button>
                </div>
                
                <div class="text-center">
                    <a href="../chatform.php" class="text-gray-600 hover:text-gray-800">
                        Don't have an account? Sign up
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html> 