<?php
// Database configuration
define('DB_HOST', 'icognito.ai');
define('DB_USER', 'iicl');
define('DB_PASS', 'IiclIndia@123');
define('DB_NAME', 'incognito_new');

// Bot image upload path
// define('BOT_IMAGE_SERVER_PATH', $_SERVER['DOCUMENT_ROOT'].'/icognito_new/chatwidget/media/bot/');

// First connect without database
$con = mysqli_connect(DB_HOST, DB_USER, DB_PASS);
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create database if not exists
$sql = "CREATE DATABASE IF NOT EXISTS " . DB_NAME;
if (!mysqli_query($con, $sql)) {
    die("Error creating database: " . mysqli_error($con));
}

// Select the database
if (!mysqli_select_db($con, DB_NAME)) {
    die("Error selecting database: " . mysqli_error($con));
}

// Create tables if they don't exist
$tables = [
    "admin_users" => "CREATE TABLE IF NOT EXISTS admin_users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        role VARCHAR(50) NOT NULL DEFAULT 'subscriber',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
    
    "settings" => "CREATE TABLE IF NOT EXISTS settings (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        company_name VARCHAR(255) NOT NULL,
        background_img VARCHAR(255),
        api_url VARCHAR(255),
        initial_message TEXT,
        theme_type VARCHAR(50) NOT NULL,
        status TINYINT(1) DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES admin_users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
    
    "custom_themes" => "CREATE TABLE IF NOT EXISTS custom_themes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        settings_id INT NOT NULL,
        primary_color VARCHAR(20),
        secondary_color VARCHAR(20),
        header_bg VARCHAR(20),
        header_text VARCHAR(20),
        button_bg VARCHAR(20),
        button_text VARCHAR(20),
        chat_bubble_user VARCHAR(20),
        chat_bubble_bot VARCHAR(20),
        input_border VARCHAR(20),
        input_focus VARCHAR(20),
        font_family VARCHAR(100),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (settings_id) REFERENCES settings(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
];

foreach ($tables as $table_name => $sql) {
    if (!mysqli_query($con, $sql)) {
        die("Error creating table $table_name: " . mysqli_error($con));
    }
}

// Create media directory if it doesn't exist
$media_path = dirname(__DIR__) . '/media/bot';
if (!file_exists($media_path)) {
    mkdir($media_path, 0777, true);
}

// Set charset to utf8mb4
mysqli_set_charset($con, "utf8mb4");

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
?> 