<?php
session_start();

// Configuration
define('DB_HOST', 'icognito.ai');
define('DB_USER', 'iicl');
define('DB_PASS', 'IiclIndia@123');
define('DB_NAME', 'incognito_new');

// Path configurations
define('BASE_PATH', dirname(__FILE__));
define('SERVER_PATH', rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/icognito_new/');
define('SITE_PATH', 'http://' . $_SERVER['HTTP_HOST'] . '/icognito_new/');

// Media paths
define('MEDIA_PATH', SERVER_PATH . 'media/');
define('PRODUCT_IMAGE_PATH', MEDIA_PATH . 'product/');
define('BOT_IMAGE_PATH', MEDIA_PATH . 'bot/');
define('UPLOAD_PATH', MEDIA_PATH . 'uploads/');

// Establish database connection with error handling
try {
    $con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if (!$con) {
        throw new Exception("Database connection failed: " . mysqli_connect_error());
    }
    mysqli_set_charset($con, "utf8mb4");
} catch (Exception $e) {
    error_log("Database connection error: " . $e->getMessage());
    die("A database error occurred. Please try again later.");
}

// Security headers
header("X-Frame-Options: SAMEORIGIN");
header("X-XSS-Protection: 1; mode=block");
header("X-Content-Type-Options: nosniff");
header("Referrer-Policy: strict-origin-when-cross-origin");
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    header("Strict-Transport-Security: max-age=31536000; includeSubDomains");
}

define('PRODUCT_IMAGE_SERVER_PATH', SERVER_PATH . 'media/product/');
define('PRODUCT_IMAGE_SITE_PATH', SITE_PATH . 'media/product/');
define('TESTIMONIALS_DOCS_PATH', SITE_PATH . 'upload_docs/');
define('BOT_IMAGE_SERVER_PATH', SERVER_PATH . 'media/bot/');
define('BOT_IMAGE_SITE_PATH', SITE_PATH . 'media/bot/');