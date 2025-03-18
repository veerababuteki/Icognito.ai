<?php
if (!defined('SECURE_ACCESS')) {
    die('Direct access not permitted');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? 'Admin Dashboard'; ?> - Chat Widget</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="botlist.php" class="text-xl font-bold text-gray-800">
                            Chat Widget Admin
                        </a>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <a href="botlist.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'botlist.php' ? 'border-b-2 border-gray-500' : ''; ?> inline-flex items-center px-1 pt-1 text-gray-900">
                            Bot List
                        </a>
                        <?php if ($_SESSION['user_role'] === 'admin'): ?>
                        <a href="users.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'users.php' ? 'border-b-2 border-gray-500' : ''; ?> inline-flex items-center px-1 pt-1 text-gray-900">
                            Users
                        </a>
                        <a href="settings.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'settings.php' ? 'border-b-2 border-gray-500' : ''; ?> inline-flex items-center px-1 pt-1 text-gray-900">
                            Settings
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        <div class="relative" x-data="{ open: false }">
                            <div class="flex items-center space-x-4">
                                <span class="text-gray-700">
                                    Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>
                                </span>
                                <a href="logout.php" class="text-gray-700 hover:text-gray-900">
                                    Logout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8"><?php // Main content will go here ?> 