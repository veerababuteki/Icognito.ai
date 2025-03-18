<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-2xl font-semibold mb-6">API Configuration</h2>
    <form method="post" action="">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Selected Configuration</label>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <?php 
                    $bot_config = $_SESSION['bot_config'] ?? [];
                    $company_name = $bot_config['company_name'] ?? '';
                    $theme_type = $bot_config['theme_type'] ?? '';
                    $custom_theme = $bot_config['custom_theme'] ?? [];
                    ?>
                    <p><strong>Company Name:</strong> <?php echo htmlspecialchars($company_name); ?></p>
                    <p><strong>Theme Type:</strong> <?php echo htmlspecialchars($theme_type); ?></p>
                    <?php if($theme_type === 'custom' && !empty($custom_theme)): ?>
                    <div class="mt-2">
                        <p class="font-medium">Custom Theme Details:</p>
                        <div class="grid grid-cols-2 gap-2 mt-1">
                            <?php foreach($custom_theme as $key => $value): ?>
                            <div>
                                <span class="text-sm text-gray-600"><?php echo ucwords(str_replace('_', ' ', $key)); ?>:</span>
                                <span class="text-sm ml-1"><?php echo htmlspecialchars($value); ?></span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <div>
                <label for="api_key" class="block text-sm font-medium text-gray-700 mb-1">API Key</label>
                <input type="text" id="api_key" name="api_key" required 
                       value="<?php echo htmlspecialchars($_SESSION['api_config']['api_key'] ?? ''); ?>"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500">
                <p class="text-sm text-gray-500 mt-1">Your API key for authentication</p>
            </div>
            <div>
                <label for="api_endpoint" class="block text-sm font-medium text-gray-700 mb-1">API Endpoint</label>
                <input type="url" id="api_endpoint" name="api_endpoint" required 
                       value="<?php echo htmlspecialchars($_SESSION['api_config']['api_endpoint'] ?? ''); ?>"
                       placeholder="https://api.example.com/v1/chat"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500">
                <p class="text-sm text-gray-500 mt-1">The URL where chat messages will be sent</p>
            </div>
            <div class="flex justify-between">
                <a href="chatform.php?step=1" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">Back</a>
                <button type="submit" name="step2_submit" 
                        class="px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">Continue</button>
            </div>
        </div>
    </form>
</div> 