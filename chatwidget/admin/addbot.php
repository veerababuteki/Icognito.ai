<?php

require('top.php');
if(isset($_POST['submit'])){
    $company_name = mysqli_real_escape_string($con, $_POST['company_name']);
    $api_url = mysqli_real_escape_string($con, $_POST['api_url']);
    $initial_message = mysqli_real_escape_string($con, $_POST['initial_message']);
    $theme_type = mysqli_real_escape_string($con, $_POST['theme_type']);
    $status = mysqli_real_escape_string($con, $_POST['status']);
    $created_at = date('Y-m-d H:i:s');
    
    // Initialize variable
    $background_img_path = '';
    
    // Handle file upload first
    if ($_FILES['background_img']['name'] != '') {
        // Validate image type
        $allowed_types = ['image/png', 'image/jpg', 'image/jpeg'];
        if (!in_array($_FILES['background_img']['type'], $allowed_types)) {
            $msg = "Please select only png, jpg, or jpeg image format";
        } else {
            // Generate a unique file name
            $background_img = rand(111111111, 999999999) . '_' . basename($_FILES['background_img']['name']);
            $target_path = BOT_IMAGE_SERVER_PATH . $background_img;
    
            // Move uploaded file
            if (move_uploaded_file($_FILES['background_img']['tmp_name'], $target_path)) {
                // Save the file path in the database
                $background_img_path = 'media/bot/' . $background_img;
            } else {
                $msg = "Failed to upload image.";
            }
        }
    }
    
    // Now create the SQL query with the background_img_path
    $sql = "INSERT INTO settings (company_name, background_img, api_url, initial_message, theme_type, status, created_at) VALUES 
            ('$company_name', '$background_img_path', '$api_url', '$initial_message', '$theme_type', '$status', '$created_at')";
    
    

    if(mysqli_query($con, $sql)){
        $settings_id = mysqli_insert_id($con);
        
        if($theme_type == 'custom'){
            $primary_color = mysqli_real_escape_string($con, $_POST['primary_color']);
            $secondary_color = mysqli_real_escape_string($con, $_POST['secondary_color']);
            $header_bg = mysqli_real_escape_string($con, $_POST['header_bg']);
            $header_text = mysqli_real_escape_string($con, $_POST['header_text']);
            $button_bg = mysqli_real_escape_string($con, $_POST['button_bg']);
            $button_text = mysqli_real_escape_string($con, $_POST['button_text']);
            $chat_bubble_user = mysqli_real_escape_string($con, $_POST['chat_bubble_user']);
            $chat_bubble_bot = mysqli_real_escape_string($con, $_POST['chat_bubble_bot']);
            $input_border = mysqli_real_escape_string($con, $_POST['input_border']);
            $input_focus = mysqli_real_escape_string($con, $_POST['input_focus']);
            $font_family = mysqli_real_escape_string($con, $_POST['font_family']);
            
            $customThemeSql = "INSERT INTO custom_themes (settings_id, primary_color, secondary_color, header_bg, header_text, button_bg, button_text, chat_bubble_user, chat_bubble_bot, input_border, input_focus, font_family) 
            VALUES ('$settings_id', '$primary_color', '$secondary_color', '$header_bg', '$header_text', '$button_bg', '$button_text', '$chat_bubble_user', '$chat_bubble_bot', '$input_border', '$input_focus', '$font_family')";
            
            mysqli_query($con, $customThemeSql);
        }
        
        header('location: botlist.php');
        die();
    }
}
?>



            <!-- Form Content -->
            <div class="p-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <form method="post" enctype="multipart/form-data">
                        <div class="mb-6">
                            <h2 class="text-lg font-semibold mb-4">Bot Information</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="company_name" class="block text-sm font-medium text-gray-700 mb-1">Bot Name / Company</label>
                                    <input type="text" id="company_name" name="company_name" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500">
                                </div>
                                <div>
                                    <label for="api_url" class="block text-sm font-medium text-gray-700 mb-1">API URL</label>
                                    <input type="url" id="api_url" name="api_url" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500">
                                </div>
                                <div>
                                    <label for="background_img" class="block text-sm font-medium text-gray-700 mb-1">Background Image</label>
                                    <input type="file" id="background_img" name="background_img" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500">
                                </div>
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">status</label>
                                    <input type="boolean" id="status" name="status" placholder=' give 0 or 1 only' required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500">
                                </div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="initial_message" class="block text-sm font-medium text-gray-700 mb-1">Initial Message</label>
                            <textarea id="initial_message" name="initial_message" rows="3" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500">Hello! How can I help you?</textarea>
                        </div>

                        <div class="mb-6">
                            <h2 class="text-lg font-semibold mb-4">Theme Settings</h2>
                            <div class="mb-4">
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
                                            <input type="text" value="#6366F1" class="ml-2 w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500" readonly>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="secondary_color" class="block text-sm font-medium text-gray-700 mb-1">Secondary Color</label>
                                        <div class="flex">
                                            <input type="color" id="secondary_color" name="secondary_color" value="#4F46E5" class="h-10 w-10 rounded border">
                                            <input type="text" value="#4F46E5" class="ml-2 w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500" readonly>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="header_bg" class="block text-sm font-medium text-gray-700 mb-1">Header Background</label>
                                        <div class="flex">
                                            <input type="color" id="header_bg" name="header_bg" value="#4F46E5" class="h-10 w-10 rounded border">
                                            <input type="text" value="#4F46E5" class="ml-2 w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500" readonly>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="header_text" class="block text-sm font-medium text-gray-700 mb-1">Header Text</label>
                                        <div class="flex">
                                            <input type="color" id="header_text" name="header_text" value="#FFFFFF" class="h-10 w-10 rounded border">
                                            <input type="text" value="#FFFFFF" class="ml-2 w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500" readonly>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="button_bg" class="block text-sm font-medium text-gray-700 mb-1">Button Background</label>
                                        <div class="flex">
                                            <input type="color" id="button_bg" name="button_bg" value="#4F46E5" class="h-10 w-10 rounded border">
                                            <input type="text" value="#4F46E5" class="ml-2 w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500" readonly>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="button_text" class="block text-sm font-medium text-gray-700 mb-1">Button Text</label>
                                        <div class="flex">
                                            <input type="color" id="button_text" name="button_text" value="#FFFFFF" class="h-10 w-10 rounded border">
                                            <input type="text" value="#FFFFFF" class="ml-2 w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500" readonly>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="chat_bubble_user" class="block text-sm font-medium text-gray-700 mb-1">User Chat Bubble</label>
                                        <div class="flex">
                                            <input type="color" id="chat_bubble_user" name="chat_bubble_user" value="#E0E7FF" class="h-10 w-10 rounded border">
                                            <input type="text" value="#E0E7FF" class="ml-2 w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500" readonly>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="chat_bubble_bot" class="block text-sm font-medium text-gray-700 mb-1">Bot Chat Bubble</label>
                                        <div class="flex">
                                            <input type="color" id="chat_bubble_bot" name="chat_bubble_bot" value="#F3F4F6" class="h-10 w-10 rounded border">
                                            <input type="text" value="#F3F4F6" class="ml-2 w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500" readonly>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="input_border" class="block text-sm font-medium text-gray-700 mb-1">Input Border</label>
                                        <div class="flex">
                                            <input type="color" id="input_border" name="input_border" value="#D1D5DB" class="h-10 w-10 rounded border">
                                            <input type="text" value="#D1D5DB" class="ml-2 w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500" readonly>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="input_focus" class="block text-sm font-medium text-gray-700 mb-1">Input Focus</label>
                                        <div class="flex">
                                            <input type="color" id="input_focus" name="input_focus" value="#6366F1" class="h-10 w-10 rounded border">
                                            <input type="text" value="#6366F1" class="ml-2 w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500" readonly>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="font_family" class="block text-sm font-medium text-gray-700 mb-1">Font Family</label>
                                        <select id="font_family" name="font_family" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500">
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

                        <div class="flex justify-end space-x-4">
                            <a href="index.php" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Cancel</a>
                            <button type="submit" name="submit" class="px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">Add Bot</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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
                    this.nextElementSibling.value = this.value;
                });
            });
        });
    </script>
</body>
</html>