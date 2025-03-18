<?php
// Ensure API config exists
if (!isset($_SESSION['api_config'])) {
    header('Location: chatform.php?step=1');
    exit();
}

$api_config = $_SESSION['api_config'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Step 2: API Configuration</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold mb-6">Step 2: API Configuration</h2>
            
            <?php if ($error_msg): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <?php echo $error_msg; ?>
                </div>
            <?php endif; ?>

            <form method="post" class="space-y-6">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">API Key</label>
                        <input type="text" 
                               value="<?php echo htmlspecialchars($api_config['api_key']); ?>" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100" 
                               readonly>
                        <p class="text-sm text-gray-500 mt-1">This is your unique API key for authentication</p>
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">API Endpoint</label>
                        <input type="text" 
                               value="<?php echo htmlspecialchars($api_config['api_endpoint']); ?>" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100" 
                               readonly>
                        <p class="text-sm text-gray-500 mt-1">This is your configured API endpoint for the chatbot</p>
                    </div>
                </div>

                <div class="flex items-center justify-between mt-6">
                    <a href="chatform.php?step=1" 
                       class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                        Back
                    </a>
                    <button type="submit" 
                            name="step2_submit" 
                            class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                        Continue
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html> 