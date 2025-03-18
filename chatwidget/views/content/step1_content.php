<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-2xl font-semibold mb-6">Bot Configuration</h2>
    <form method="post" action="" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
        <div class="space-y-4">
            <div>
                <label for="company_name" class="block text-sm font-medium text-gray-700 mb-1">Company Name</label>
                <input type="text" id="company_name" name="company_name" required
                       value="<?php echo htmlspecialchars($_SESSION['bot_config']['company_name'] ?? ''); ?>"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500">
            </div>
            <div>
                <label for="website_url" class="block text-sm font-medium text-gray-700 mb-1">Website URL</label>
                <input type="url" id="website_url" name="website_url" required
                       value="<?php echo htmlspecialchars($_SESSION['bot_config']['website_url'] ?? ''); ?>"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500">
            </div>
            <div>
                <label for="initial_message" class="block text-sm font-medium text-gray-700 mb-1">Make Your Welcome Message</label>
                <textarea id="initial_message" name="initial_message" required
                          class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500"
                          rows="3"><?php echo htmlspecialchars($_SESSION['bot_config']['initial_message'] ?? ''); ?></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">Theme Type</label>
                <div class="flex space-x-4">
                    <label class="inline-flex items-center">
                        <input type="radio" name="theme_type" value="solid" class="form-radio h-4 w-4 text-gray-600"
                            <?php echo ($_SESSION['bot_config']['theme_type'] ?? '') === 'solid' ? 'checked' : ''; ?>
                            onchange="toggleCustomTheme(this.value)">
                        <span class="ml-2">Solid</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="theme_type" value="gradient" class="form-radio h-4 w-4 text-gray-600"
                            <?php echo ($_SESSION['bot_config']['theme_type'] ?? '') === 'gradient' ? 'checked' : ''; ?>
                            onchange="toggleCustomTheme(this.value)">
                        <span class="ml-2">Gradient</span>
                    </label>
                    <label class="inline-flex items-center">
                        <label class="inline-flex items-center">
                        <input type="radio" name="theme_type" value="glassmorphism" class="form-radio h-4 w-4 text-gray-600"
                            <?php echo ($_SESSION['bot_config']['theme_type'] ?? '') === 'glassmorphism' ? 'checked' : ''; ?>
                            onchange="toggleCustomTheme(this.value)">
                        <span class="ml-2">Glassmorphism</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="theme_type" value="custom" class="form-radio h-4 w-4 text-gray-600"
                            <?php echo ($_SESSION['bot_config']['theme_type'] ?? '') === 'custom' ? 'checked' : ''; ?>
                            onchange="toggleCustomTheme(this.value)">
                        <span class="ml-2">Custom</span>
                    </label>
                </div>
            </div>
            <div>
                <label for="background_img" class="block text-sm font-medium text-gray-700 mb-1">Background Image (Optional)</label>
                <input type="file" id="background_img" name="background_img" accept="image/png,image/jpeg,image/jpg"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500">
                <?php if (!empty($_SESSION['bot_config']['background_img'])): ?>
                    <p class="text-sm text-gray-600 mt-1">Current image: <?php echo htmlspecialchars($_SESSION['bot_config']['background_img']); ?></p>
                <?php endif; ?>
            </div>
            
            <div id="custom_theme_options" class="space-y-6 mt-6" style="display: <?php echo ($_SESSION['bot_config']['theme_type'] ?? '') === 'custom' ? 'block' : 'none'; ?>">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Theme Settings</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Primary Color -->
                    <div>
                        <label for="primary_color" class="block text-sm font-medium text-gray-700 mb-2">Primary Color</label>
                        <div class="flex items-center">
                            <input type="color" id="primary_color" name="primary_color"
                                value="<?php echo htmlspecialchars($_SESSION['bot_config']['custom_theme']['primary_color'] ?? '#6366F1'); ?>"
                                class="h-10 w-20 p-1 rounded-lg border border-gray-300">
                            <input type="text" 
                                value="<?php echo htmlspecialchars($_SESSION['bot_config']['custom_theme']['primary_color'] ?? '#6366F1'); ?>"
                                class="ml-2 w-28 px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500"
                                onchange="document.getElementById('primary_color').value = this.value">
                        </div>
                    </div>

                    <!-- Secondary Color -->
                    <div>
                        <label for="secondary_color" class="block text-sm font-medium text-gray-700 mb-2">Secondary Color</label>
                        <div class="flex items-center">
                            <input type="color" id="secondary_color" name="secondary_color"
                                value="<?php echo htmlspecialchars($_SESSION['bot_config']['custom_theme']['secondary_color'] ?? '#4F46E5'); ?>"
                                class="h-10 w-20 p-1 rounded-lg border border-gray-300">
                            <input type="text" 
                                value="<?php echo htmlspecialchars($_SESSION['bot_config']['custom_theme']['secondary_color'] ?? '#4F46E5'); ?>"
                                class="ml-2 w-28 px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500"
                                onchange="document.getElementById('secondary_color').value = this.value">
                        </div>
                    </div>

                    <!-- Header Background -->
                    <div>
                        <label for="header_bg" class="block text-sm font-medium text-gray-700 mb-2">Header Background</label>
                        <div class="flex items-center">
                            <input type="color" id="header_bg" name="header_bg"
                                value="<?php echo htmlspecialchars($_SESSION['bot_config']['custom_theme']['header_bg'] ?? '#4F46E5'); ?>"
                                class="h-10 w-20 p-1 rounded-lg border border-gray-300">
                            <input type="text" 
                                value="<?php echo htmlspecialchars($_SESSION['bot_config']['custom_theme']['header_bg'] ?? '#4F46E5'); ?>"
                                class="ml-2 w-28 px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500"
                                onchange="document.getElementById('header_bg').value = this.value">
                        </div>
                    </div>

                    <!-- Header Text -->
                    <div>
                        <label for="header_text" class="block text-sm font-medium text-gray-700 mb-2">Header Text</label>
                        <div class="flex items-center">
                            <input type="color" id="header_text" name="header_text"
                                value="<?php echo htmlspecialchars($_SESSION['bot_config']['custom_theme']['header_text'] ?? '#FFFFFF'); ?>"
                                class="h-10 w-20 p-1 rounded-lg border border-gray-300">
                            <input type="text" 
                                value="<?php echo htmlspecialchars($_SESSION['bot_config']['custom_theme']['header_text'] ?? '#FFFFFF'); ?>"
                                class="ml-2 w-28 px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500"
                                onchange="document.getElementById('header_text').value = this.value">
                        </div>
                    </div>

                    <!-- Button Background -->
                    <div>
                        <label for="button_bg" class="block text-sm font-medium text-gray-700 mb-2">Button Background</label>
                        <div class="flex items-center">
                            <input type="color" id="button_bg" name="button_bg"
                                value="<?php echo htmlspecialchars($_SESSION['bot_config']['custom_theme']['button_bg'] ?? '#4F46E5'); ?>"
                                class="h-10 w-20 p-1 rounded-lg border border-gray-300">
                            <input type="text" 
                                value="<?php echo htmlspecialchars($_SESSION['bot_config']['custom_theme']['button_bg'] ?? '#4F46E5'); ?>"
                                class="ml-2 w-28 px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500"
                                onchange="document.getElementById('button_bg').value = this.value">
                        </div>
                    </div>

                    <!-- Button Text -->
                    <div>
                        <label for="button_text" class="block text-sm font-medium text-gray-700 mb-2">Button Text</label>
                        <div class="flex items-center">
                            <input type="color" id="button_text" name="button_text"
                                value="<?php echo htmlspecialchars($_SESSION['bot_config']['custom_theme']['button_text'] ?? '#FFFFFF'); ?>"
                                class="h-10 w-20 p-1 rounded-lg border border-gray-300">
                            <input type="text" 
                                value="<?php echo htmlspecialchars($_SESSION['bot_config']['custom_theme']['button_text'] ?? '#FFFFFF'); ?>"
                                class="ml-2 w-28 px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500"
                                onchange="document.getElementById('button_text').value = this.value">
                        </div>
                    </div>

                    <!-- User Chat Bubble -->
                    <div>
                        <label for="chat_bubble_user" class="block text-sm font-medium text-gray-700 mb-2">User Chat Bubble</label>
                        <div class="flex items-center">
                            <input type="color" id="chat_bubble_user" name="chat_bubble_user"
                                value="<?php echo htmlspecialchars($_SESSION['bot_config']['custom_theme']['chat_bubble_user'] ?? '#E0E7FF'); ?>"
                                class="h-10 w-20 p-1 rounded-lg border border-gray-300">
                            <input type="text" 
                                value="<?php echo htmlspecialchars($_SESSION['bot_config']['custom_theme']['chat_bubble_user'] ?? '#E0E7FF'); ?>"
                                class="ml-2 w-28 px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500"
                                onchange="document.getElementById('chat_bubble_user').value = this.value">
                        </div>
                    </div>

                    <!-- Bot Chat Bubble -->
                    <div>
                        <label for="chat_bubble_bot" class="block text-sm font-medium text-gray-700 mb-2">Bot Chat Bubble</label>
                        <div class="flex items-center">
                            <input type="color" id="chat_bubble_bot" name="chat_bubble_bot"
                                value="<?php echo htmlspecialchars($_SESSION['bot_config']['custom_theme']['chat_bubble_bot'] ?? '#F3F4F6'); ?>"
                                class="h-10 w-20 p-1 rounded-lg border border-gray-300">
                            <input type="text" 
                                value="<?php echo htmlspecialchars($_SESSION['bot_config']['custom_theme']['chat_bubble_bot'] ?? '#F3F4F6'); ?>"
                                class="ml-2 w-28 px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500"
                                onchange="document.getElementById('chat_bubble_bot').value = this.value">
                        </div>
                    </div>

                    <!-- Input Border -->
                    <div>
                        <label for="input_border" class="block text-sm font-medium text-gray-700 mb-2">Input Border</label>
                        <div class="flex items-center">
                            <input type="color" id="input_border" name="input_border"
                                value="<?php echo htmlspecialchars($_SESSION['bot_config']['custom_theme']['input_border'] ?? '#E5E7EB'); ?>"
                                class="h-10 w-20 p-1 rounded-lg border border-gray-300">
                            <input type="text" 
                                value="<?php echo htmlspecialchars($_SESSION['bot_config']['custom_theme']['input_border'] ?? '#E5E7EB'); ?>"
                                class="ml-2 w-28 px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500"
                                onchange="document.getElementById('input_border').value = this.value">
                        </div>
                    </div>

                    <!-- Input Focus -->
                    <div>
                        <label for="input_focus" class="block text-sm font-medium text-gray-700 mb-2">Input Focus</label>
                        <div class="flex items-center">
                            <input type="color" id="input_focus" name="input_focus"
                                value="<?php echo htmlspecialchars($_SESSION['bot_config']['custom_theme']['input_focus'] ?? '#4F46E5'); ?>"
                                class="h-10 w-20 p-1 rounded-lg border border-gray-300">
                            <input type="text" 
                                value="<?php echo htmlspecialchars($_SESSION['bot_config']['custom_theme']['input_focus'] ?? '#4F46E5'); ?>"
                                class="ml-2 w-28 px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500"
                                onchange="document.getElementById('input_focus').value = this.value">
                        </div>
                    </div>

                    <!-- Font Family -->
                    <div class="md:col-span-2">
                        <label for="font_family" class="block text-sm font-medium text-gray-700 mb-2">Font Family</label>
                        <select id="font_family" name="font_family"
                                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500">
                            <?php
                            $fonts = ['Inter', 'Arial', 'Helvetica', 'Times New Roman', 'Georgia', 'Verdana', 'system-ui'];
                            foreach ($fonts as $font):
                                $selected = ($_SESSION['bot_config']['custom_theme']['font_family'] ?? '') === $font ? 'selected' : '';
                            ?>
                            <option value="<?php echo $font; ?>" <?php echo $selected; ?>><?php echo $font; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-end">
                <button type="submit" name="step1_submit" 
                        class="px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">Continue</button>
            </div>
        </div>
    </form>
</div>

<script>
function toggleCustomTheme(value) {
    const customThemeOptions = document.getElementById('custom_theme_options');
    customThemeOptions.style.display = value === 'custom' ? 'block' : 'none';
}

// Add event listeners to sync color inputs with text inputs
document.querySelectorAll('input[type="color"]').forEach(colorInput => {
    colorInput.addEventListener('input', function() {
        const textInput = this.nextElementSibling;
        textInput.value = this.value.toUpperCase();
    });
});
</script> 