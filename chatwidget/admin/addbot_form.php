<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-2xl font-semibold mb-6">Configure Your Chatbot</h2>
    <form method="post" action="" enctype="multipart/form-data">
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="company_name" class="block text-sm font-medium text-gray-700 mb-1">Bot Name / Company</label>
                    <input type="text" id="company_name" name="company_name" required value="<?php echo isset($_SESSION['business_name']) ? $_SESSION['business_name'] : ''; ?>"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500">
                </div>
                <div>
                    <label for="website_url" class="block text-sm font-medium text-gray-700 mb-1">Website URL</label>
                    <input type="url" id="website_url" name="website_url" required placeholder="https://example.com"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500">
                </div>
                <div>
                    <label for="background_img" class="block text-sm font-medium text-gray-700 mb-1">Background Image (Optional)</label>
                    <input type="file" id="background_img" name="background_img" accept="image/png,image/jpeg,image/jpg"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500">
                </div>
            </div>

            <div>
                <label for="initial_message" class="block text-sm font-medium text-gray-700 mb-1">Initial Message</label>
                <textarea id="initial_message" name="initial_message" rows="3" 
                          class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500">Hello! How can I help you today?</textarea>
            </div>

            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Theme Settings</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Theme Type</label>
                        <div class="flex space-x-4">
                            <label class="flex items-center">
                                <input type="radio" name="theme_type" value="solid" checked class="mr-2">
                                <span>Solid</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="theme_type" value="gradient" class="mr-2">
                                <span>Gradient</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="theme_type" value="glassmorphism" class="mr-2">
                                <span>Glassmorphism</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="theme_type" value="custom" class="mr-2" id="custom_theme_radio">
                                <span>Custom</span>
                            </label>
                        </div>
                    </div>

                    <div id="custom_theme_options" class="hidden border-t pt-4 mt-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="primary_color" class="block text-sm font-medium text-gray-700 mb-1">Primary Color</label>
                                <div class="flex">
                                    <input type="color" id="primary_color" name="primary_color" value="#6366F1" class="h-10 w-10 rounded border">
                                    <input type="text" value="#6366F1" class="ml-2 w-full px-3 py-2 border rounded-lg" readonly>
                                </div>
                            </div>
                            <div>
                                <label for="secondary_color" class="block text-sm font-medium text-gray-700 mb-1">Secondary Color</label>
                                <div class="flex">
                                    <input type="color" id="secondary_color" name="secondary_color" value="#4F46E5" class="h-10 w-10 rounded border">
                                    <input type="text" value="#4F46E5" class="ml-2 w-full px-3 py-2 border rounded-lg" readonly>
                                </div>
                            </div>
                            <div>
                                <label for="font_family" class="block text-sm font-medium text-gray-700 mb-1">Font Family</label>
                                <select id="font_family" name="font_family" class="w-full px-3 py-2 border rounded-lg">
                                    <option value="Inter, sans-serif">Inter</option>
                                    <option value="Roboto, sans-serif">Roboto</option>
                                    <option value="Poppins, sans-serif">Poppins</option>
                                    <option value="Open Sans, sans-serif">Open Sans</option>
                                    <option value="Lato, sans-serif">Lato</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-between">
                <a href="chatform.php?step=1" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Back</a>
                <button type="submit" name="step2_submit" class="px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                    Continue
                </button>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const customThemeRadio = document.getElementById('custom_theme_radio');
    const customThemeOptions = document.getElementById('custom_theme_options');
    
    // Show/hide custom theme options based on radio selection
    document.querySelectorAll('input[name="theme_type"]').forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'custom') {
                customThemeOptions.classList.remove('hidden');
            } else {
                customThemeOptions.classList.add('hidden');
            }
        });
    });
    
    // Update text inputs when color inputs change
    document.querySelectorAll('input[type="color"]').forEach(colorInput => {
        colorInput.addEventListener('input', function() {
            this.nextElementSibling.value = this.value.toUpperCase();
        });
    });
});
</script> 