<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!defined('DB_INCLUDED')) {
    define('DB_INCLUDED', true);
    
    $con = mysqli_connect("icognito.ai", "iicl", "IiclIndia@123", "incognito_new");
    
    if (!defined('SERVER_PATH')) define('SERVER_PATH', $_SERVER['DOCUMENT_ROOT'] . '/icognito_new/');
    if (!defined('SITE_PATH')) define('SITE_PATH', 'http://127.0.0.1/icognito_new/');
    
    if (!defined('PRODUCT_IMAGE_SERVER_PATH')) define('PRODUCT_IMAGE_SERVER_PATH', SERVER_PATH . 'media/product/');
    if (!defined('PRODUCT_IMAGE_SITE_PATH')) define('PRODUCT_IMAGE_SITE_PATH', SITE_PATH . 'media/product/');
    if (!defined('TESTIMONIALS_DOCS_PATH')) define('TESTIMONIALS_DOCS_PATH', SITE_PATH . 'upload_docs/');
    if (!defined('BOT_IMAGE_SERVER_PATH')) define('BOT_IMAGE_SERVER_PATH', SERVER_PATH . 'media/bot/');
    if (!defined('BOT_IMAGE_SITE_PATH')) define('BOT_IMAGE_SITE_PATH', SITE_PATH . 'media/bot/');
}
?>