<?php
// No need to require files here as they are already included in index.php
// and other pages that include top.php
require('functions.inc.php');
require_once(__DIR__ . '/connection.php');

// Check admin authentication
if(!isset($_SESSION)) {
    session_start();
}

if(!isset($_SESSION['username'])) {
    header('location:login.php');
    die();
}

// // Restrict access for subscribers
// if (isset($_SESSION['USER_ROLE']) && $_SESSION['USER_ROLE'] === 'subscriber' && basename($_SERVER['PHP_SELF']) !== 'botlist.php') {
//     header('location:botlist.php'); // Redirect to bot list page
//     die();
// }

// Only get data if not already set by parent file
if (!isset($settingsCount) || !isset($botCount)) {
    $sql = "SELECT * FROM settings";
    $result = mysqli_query($con, $sql);
    $settingsCount = mysqli_num_rows($result);

    $botsQuery = "SELECT COUNT(*) as bot_count FROM settings";
    $botsResult = mysqli_query($con, $botsQuery);
    $botCount = mysqli_fetch_assoc($botsResult)['bot_count'];
}

// if (isset($_SESSION['USER_ROLE'])) {
//     echo "User role is set: " . $_SESSION['USER_ROLE'];
// } else {
//     echo "User role is not set.";
// }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Widget Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-700 text-white p-4">
            <div class="text-2xl font-bold mb-8 pl-2 py-4 border-b border-gray-600">
                BotControl Hub
            </div>
            <nav>
                <a href="index.php" class="flex items-center py-3 px-4 bg-gray-800 rounded mb-2">
                    <i class="fas fa-home mr-3"></i>
                    <span>Dashboard</span>
                </a>
                <a href="botlist.php" class="flex items-center py-3 px-4 hover:bg-gray-800 rounded mb-2">
                    <i class="fas fa-robot mr-3"></i>
                    <span>Bot List</span>
                </a>
                <a href="addbot.php" class="flex items-center py-3 px-4 hover:bg-gray-800 rounded mb-2">
                    <i class="fas fa-plus-circle mr-3"></i>
                    <span>Add New Bot</span>
                </a>
                <a href="widget_code.php" class="flex items-center py-3 px-4 hover:bg-gray-800 rounded mb-2">
                    <i class="fas fa-code mr-3"></i>
                    <span>Get Widget Code</span>
                </a>
                <a href="#" class="flex items-center py-3 px-4 hover:bg-gray-800 rounded mb-2">
                    <i class="fas fa-cog mr-3"></i>
                    <span>Settings</span>
                </a>
                <a href="logout.php" class="flex items-center py-3 px-4 hover:bg-gray-800 rounded mt-8">
                    <i class="fas fa-sign-out-alt mr-3"></i>
                    <span>Logout</span>
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1">
            <!-- Header -->
            <header class="bg-white shadow p-4">
                <div class="flex justify-between items-center">
                    <h1 class="text-xl font-semibold">Dashboard</h1>
                    <div class="flex items-center">
                        <div class="mr-4">
                            <span class="text-gray-500">Welcome,
                                <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                        </div>
                        <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-gray-700"></i>
                        </div>
                    </div>
                </div>
            </header>