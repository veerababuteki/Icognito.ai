<?php
require('connection.inc.php');
require('functions.inc.php');
check_admin_auth();

// Get the bot ID from URL parameter
$bot_id = isset($_GET['bot_id']) ? mysqli_real_escape_string($con, $_GET['bot_id']) : '';

// Get the bot details
if($bot_id != '') {
    $sql = "SELECT * FROM settings WHERE id = '$bot_id'";
    $result = mysqli_query($con, $sql);
    $bot_details = mysqli_fetch_assoc($result);
    
    if(!$bot_details) {
        die('Bot not found');
    }
} else {
    die('Bot ID not provided');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Widget Preview - <?php echo htmlspecialchars($bot_details['company_name']); ?></title>
    <style>
        body {
            margin: 0;
            padding: 20px;
            font-family: Arial, sans-serif;
            background: #f5f5f5;
        }
        .preview-info {
            max-width: 600px;
            margin: 0 auto 20px;
            padding: 15px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1 {
            margin: 0 0 10px;
            font-size: 24px;
            color: #333;
        }
        p {
            margin: 0;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="preview-info">
        <h1><?php echo htmlspecialchars($bot_details['company_name']); ?> Chat Widget</h1>
        <p>This is a preview of how your chat widget will appear on your website.</p>
    </div>

    <!-- Chat Widget Integration -->
    <script src="<?php echo $bot_details['api_url']; ?>/dist/assets/index-Ch86yj2z.js"></script>
    <script>
        window.ChatWidget({
            botId: '<?php echo $bot_id; ?>',
            position: 'bottom-right',
            themeType: 'solid',
            initialMessage: 'Hello! How can I help you?',
            companyName: '<?php echo htmlspecialchars($bot_details['company_name']); ?>',
            apiUrl: '<?php echo $bot_details['api_url']; ?>/ask'
        });
    </script>
</body>
</html> 