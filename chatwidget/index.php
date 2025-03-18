<?php
// Include database connection
require_once(__DIR__ . '/admin/connection.php');

// Define site path if not defined
if (!defined('BOT_IMAGE_SITE_PATH')) {
    define('BOT_IMAGE_SITE_PATH', 'http://' . $_SERVER['HTTP_HOST'] . '/icognito_new/chatwidget/');
}

// Get the bot ID from the URL
$bot_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Default settings in case no bot is selected
$bot_settings = [
    'company_name' => 'Demo Bot',
    'api_url' => 'http://localhost:5000/ask',
    'initial_message' => 'Hello! How can I help you?',
    'theme_type' => 'glassmorphism',
    'custom_theme' => null,
    'background_img' => '',
    'bot_title' => 'Chat Bot'
];

// If bot ID is provided, fetch the bot settings
if ($bot_id > 0) {
    // Get bot settings
    $sql = "SELECT s.*, ct.* FROM settings s 
            LEFT JOIN custom_themes ct ON s.id = ct.settings_id 
            WHERE s.id = " . $bot_id;
    $result = mysqli_query($con, $sql);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $bot_settings = mysqli_fetch_assoc($result);
        
        // Convert custom theme data to JSON if exists
        if ($bot_settings['theme_type'] === 'custom') {
            $custom_theme = [
                'primaryColor' => $bot_settings['primary_color'],
                'secondaryColor' => $bot_settings['secondary_color'],
                'headerBg' => $bot_settings['header_bg'],
                'headerText' => $bot_settings['header_text'],
                'buttonBg' => $bot_settings['button_bg'],
                'buttonText' => $bot_settings['button_text'],
                'chatBubbleUser' => $bot_settings['chat_bubble_user'],
                'chatBubbleBot' => $bot_settings['chat_bubble_bot'],
                'inputBorder' => $bot_settings['input_border'],
                'inputFocus' => $bot_settings['input_focus'],
                'fontFamily' => $bot_settings['font_family']
            ];
            $bot_settings['custom_theme'] = json_encode($custom_theme);
        }
    }
}

// Set default values if they're not in the database
$bot_title = isset($bot_settings['bot_title']) ? $bot_settings['bot_title'] : 'Chat Bot';
$company_name = isset($bot_settings['company_name']) ? $bot_settings['company_name'] : 'Demo Bot';
$api_url = isset($bot_settings['api_url']) ? $bot_settings['api_url'] : 'http://localhost:5000/ask';
$initial_message = isset($bot_settings['initial_message']) ? $bot_settings['initial_message'] : 'Hello! How can I help you?';
$theme_type = isset($bot_settings['theme_type']) ? $bot_settings['theme_type'] : 'glassmorphism';
$custom_theme = isset($bot_settings['custom_theme']) ? $bot_settings['custom_theme'] : 'null';
$background_image = isset($bot_settings['background_img']) ? $bot_settings['background_img'] : '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($company_name); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<style>
    .background-section {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        overflow: hidden;
        z-index: -1; /* Ensures it stays in the background */
    }

    .full-screen-image {
        width: 100vw;
        height: 100vh;
        object-fit: cover;
    }
</style>
<body>
    <!-- Background section -->
    <div class="background-section">
    <?php if (!empty($background_image)): ?>
        <img src="<?php echo BOT_IMAGE_SITE_PATH . htmlspecialchars($background_image); ?>" 
             alt="Background" 
             class="full-screen-image">
    <?php endif; ?>
</div>
<!--  -->
    <!-- <script src="dist/assets/index-Ch86yj2z.js"></script> -->
    <script src="https://widgetschats.s3.us-east-1.amazonaws.com/assets/index-Bd67SnqX.js"></script>

    <script>
        // Initialize the Chat Widget with the bot's settings
        window.ChatWidget({
            position: 'bottom-right',
            themeType: '<?php echo htmlspecialchars($theme_type); ?>',
            <?php if ($theme_type === 'custom' && !empty($custom_theme)): ?>
            customTheme: <?php echo $custom_theme; ?>,
            <?php endif; ?>
            initialMessage: '<?php echo htmlspecialchars($initial_message); ?>',
            companyName: '<?php echo htmlspecialchars($company_name); ?>',
            apiUrl: '<?php echo htmlspecialchars($api_url); ?>'
        });
    </script>
</body>

</html>

<!-- Fatal error: Uncaught mysqli_sql_exception: Unknown column 'updated_at' in 'field list' in C:\xampp\htdocs\icognito_new\chatwidget\admin\edit_bot.php:113 Stack trace: #0 C:\xampp\htdocs\icognito_new\chatwidget\admin\edit_bot.php(113): mysqli_query(Object(mysqli), 'UPDATE settings...') #1 {main} thrown in C:\xampp\htdocs\icognito_new\chatwidget\admin\edit_bot.php on line 113 -->
<!-- Fatal error: Maximum execution time of 120 seconds exceeded in C:\xampp\htdocs\icognito_new\chatwidget\chatform.php on line 142 -->