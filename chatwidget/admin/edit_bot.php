<?php
require('top.php');

// Define image path constant if not defined elsewhere
// if(!defined('BOT_IMAGE_SERVER_PATH')){
//     define('BOT_IMAGE_SERVER_PATH', 'media/bot');
// }

$msg = '';
$company_name = '';
$api_url = '';
$initial_message = '';
$theme_type = '';
$status = '';
$background_img = '';

// Custom theme variables
$primary_color = '#6366F1';
$secondary_color = '#4F46E5';
$header_bg = '#4F46E5';
$header_text = '#FFFFFF';
$button_bg = '#4F46E5';
$button_text = '#FFFFFF';
$chat_bubble_user = '#E0E7FF';
$chat_bubble_bot = '#F3F4F6';
$input_border = '#D1D5DB';
$input_focus = '#6366F1';
$font_family = 'Inter, sans-serif';

if(isset($_GET['id']) && $_GET['id'] > 0){
    $id = mysqli_real_escape_string($con, $_GET['id']);
    $res = mysqli_query($con, "SELECT * FROM settings WHERE id='$id'");
    if(mysqli_num_rows($res) > 0){
        $row = mysqli_fetch_assoc($res);
        $company_name = $row['company_name'];
        $api_url = $row['api_url'];
        $initial_message = $row['initial_message'];
        $theme_type = $row['theme_type'];
        $status = $row['status'];
        $background_img = $row['background_img'];
        
        // If theme type is custom, get custom theme details
        if($theme_type == 'custom'){
            $customThemeRes = mysqli_query($con, "SELECT * FROM custom_themes WHERE settings_id='$id'");
            if(mysqli_num_rows($customThemeRes) > 0){
                $customThemeRow = mysqli_fetch_assoc($customThemeRes);
                $primary_color = $customThemeRow['primary_color'];
                $secondary_color = $customThemeRow['secondary_color'];
                $header_bg = $customThemeRow['header_bg'];
                $header_text = $customThemeRow['header_text'];
                $button_bg = $customThemeRow['button_bg'];
                $button_text = $customThemeRow['button_text'];
                $chat_bubble_user = $customThemeRow['chat_bubble_user'];
                $chat_bubble_bot = $customThemeRow['chat_bubble_bot'];
                $input_border = $customThemeRow['input_border'];
                $input_focus = $customThemeRow['input_focus'];
                $font_family = $customThemeRow['font_family'];
            }
        }
    } else {
        header('location: botlist.php');
        die();
    }
}

if(isset($_POST['submit'])){
    $company_name = mysqli_real_escape_string($con, $_POST['company_name']);
    $api_url = mysqli_real_escape_string($con, $_POST['api_url']);
    $initial_message = mysqli_real_escape_string($con, $_POST['initial_message']);
    $theme_type = mysqli_real_escape_string($con, $_POST['theme_type']);
    $status = mysqli_real_escape_string($con, $_POST['status']);
    
    // Process image upload
    if(isset($_GET['id']) && $_GET['id'] > 0){
        $id = mysqli_real_escape_string($con, $_GET['id']);
        
        if($_FILES['background_img']['name'] != ''){
            // Validate image type
            if($_FILES['background_img']['type'] != 'image/png' && 
               $_FILES['background_img']['type'] != 'image/jpg' && 
               $_FILES['background_img']['type'] != 'image/jpeg'){
                $msg = "Please select only png, jpg and jpeg image format";
            } else {
                // Generate unique image name and upload
                $background_img = rand(111111111, 999999999).'_'.$_FILES['background_img']['name'];
                move_uploaded_file($_FILES['background_img']['tmp_name'], BOT_IMAGE_SERVER_PATH.'/'.$background_img);
                
                // Update with new image
                $update_sql = "UPDATE settings SET 
                    company_name='$company_name', 
                    background_img='$background_img', 
                    api_url='$api_url', 
                    initial_message='$initial_message', 
                    theme_type='$theme_type', 
                    status='$status'
                    WHERE id='$id'";
            }
        } else {
            // Update without changing image
            $update_sql = "UPDATE settings SET 
                company_name='$company_name', 
                api_url='$api_url', 
                initial_message='$initial_message', 
                theme_type='$theme_type', 
                status='$status'
                WHERE id='$id'";
        }
        
        if($msg == ''){
            if(mysqli_query($con, $update_sql)){
                // Handle custom theme if selected
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
                    
                    // Check if custom theme already exists
                    $checkTheme = mysqli_query($con, "SELECT * FROM custom_themes WHERE settings_id='$id'");
                    if(mysqli_num_rows($checkTheme) > 0){
                        // Update existing theme
                        $updateTheme = "UPDATE custom_themes SET 
                            primary_color='$primary_color', 
                            secondary_color='$secondary_color', 
                            header_bg='$header_bg', 
                            header_text='$header_text', 
                            button_bg='$button_bg', 
                            button_text='$button_text', 
                            chat_bubble_user='$chat_bubble_user', 
                            chat_bubble_bot='$chat_bubble_bot', 
                            input_border='$input_border', 
                            input_focus='$input_focus', 
                            font_family='$font_family' 
                            WHERE settings_id='$id'";
                        mysqli_query($con, $updateTheme);
                    } else {
                        // Insert new theme
                        $insertTheme = "INSERT INTO custom_themes (
                            settings_id, primary_color, secondary_color, header_bg, header_text, 
                            button_bg, button_text, chat_bubble_user, chat_bubble_bot, 
                            input_border, input_focus, font_family
                        ) VALUES (
                            '$id', '$primary_color', '$secondary_color', '$header_bg', '$header_text', 
                            '$button_bg', '$button_text', '$chat_bubble_user', '$chat_bubble_bot', 
                            '$input_border', '$input_focus', '$font_family'
                        )";
                        mysqli_query($con, $insertTheme);
                    }
                }
                
                header('location: botlist.php');
                die();
            } else {
                $msg = "Error updating settings: " . mysqli_error($con);
            }
        }
    } else {
        $msg = "Invalid bot ID";
    }
}
?>

<!-- Form Content -->
<div class="p-6">
    <div class="bg-white rounded-lg shadow p-6">
        <?php if($msg != ''){ ?>
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                <?php echo $msg; ?>
            </div>
        <?php } ?>
        
        <form method="post" enctype="multipart/form-data">
            <div class="mb-6">
                <h2 class="text-lg font-semibold mb-4">Bot Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="company_name" class="block text-sm font-medium text-gray-700 mb-1">Bot Name / Company</label>
                        <input type="text" id="company_name" name="company_name" value="<?php echo $company_name; ?>" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500">
                    </div>
                    <div>
                        <label for="api_url" class="block text-sm font-medium text-gray-700 mb-1">API URL</label>
                        <input type="url" id="api_url" name="api_url" value="<?php echo $api_url; ?>" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500">
                    </div>
                    <div>
                        <label for="background_img" class="block text-sm font-medium text-gray-700 mb-1">Background Image</label>
                        <input type="file" id="background_img" name="background_img" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500">
                        <?php if($background_img != ''){ ?>
                            <div class="mt-2">
                                <p class="text-sm text-gray-600">Current: <?php echo $background_img; ?></p>
                                <img src="<?php echo SITE_PATH .'media/bot/'. $background_img; ?>" class="h-16 mt-1 rounded">                        <?php } ?>
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select id="status" name="status" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500">
                            <option value="1" <?php if($status == '1'){ echo "selected"; } ?>>Active (1)</option>
                            <option value="0" <?php if($status == '0'){ echo "selected"; } ?>>Inactive (0)</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <label for="initial_message" class="block text-sm font-medium text-gray-700 mb-1">Initial Message</label>
                <textarea id="initial_message" name="initial_message" rows="3" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500"><?php echo $initial_message; ?></textarea>
            </div>

            <div class="mb-6">
                <h2 class="text-lg font-semibold mb-4">Theme Settings</h2>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Theme Type</label>
                    <div class="flex space-x-4">
                        <label class="flex items-center">
                            <input type="radio" name="theme_type" value="solid" <?php if($theme_type == 'solid'){ echo "checked"; } ?> class="mr-2">
                            <span>Solid</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="theme_type" value="gradient" <?php if($theme_type == 'gradient'){ echo "checked"; } ?> class="mr-2">
                            <span>Gradient</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="theme_type" value="glassmorphism" <?php if($theme_type == 'glassmorphism'){ echo "checked"; } ?> class="mr-2">
                            <span>Glassmorphism</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="theme_type" value="custom" <?php if($theme_type == 'custom'){ echo "checked"; } ?> class="mr-2" id="custom_theme_radio">
                            <span>Custom</span>
                        </label>
                    </div>
                </div>

                <div id="custom_theme_options" class="<?php if($theme_type != 'custom'){ echo 'hidden'; } ?> border-t pt-4 mt-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="primary_color" class="block text-sm font-medium text-gray-700 mb-1">Primary Color</label>
                            <div class="flex">
                                <input type="color" id="primary_color" name="primary_color" value="<?php echo $primary_color; ?>" class="h-10 w-10 rounded border">
                                <input type="text" value="<?php echo $primary_color; ?>" class="ml-2 w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500" readonly>
                            </div>
                        </div>
                        <div>
                            <label for="secondary_color" class="block text-sm font-medium text-gray-700 mb-1">Secondary Color</label>
                            <div class="flex">
                                <input type="color" id="secondary_color" name="secondary_color" value="<?php echo $secondary_color; ?>" class="h-10 w-10 rounded border">
                                <input type="text" value="<?php echo $secondary_color; ?>" class="ml-2 w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500" readonly>
                            </div>
                        </div>
                        <div>
                            <label for="header_bg" class="block text-sm font-medium text-gray-700 mb-1">Header Background</label>
                            <div class="flex">
                                <input type="color" id="header_bg" name="header_bg" value="<?php echo $header_bg; ?>" class="h-10 w-10 rounded border">
                                <input type="text" value="<?php echo $header_bg; ?>" class="ml-2 w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500" readonly>
                            </div>
                        </div>
                        <div>
                            <label for="header_text" class="block text-sm font-medium text-gray-700 mb-1">Header Text</label>
                            <div class="flex">
                                <input type="color" id="header_text" name="header_text" value="<?php echo $header_text; ?>" class="h-10 w-10 rounded border">
                                <input type="text" value="<?php echo $header_text; ?>" class="ml-2 w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500" readonly>
                            </div>
                        </div>
                        <div>
                            <label for="button_bg" class="block text-sm font-medium text-gray-700 mb-1">Button Background</label>
                            <div class="flex">
                                <input type="color" id="button_bg" name="button_bg" value="<?php echo $button_bg; ?>" class="h-10 w-10 rounded border">
                                <input type="text" value="<?php echo $button_bg; ?>" class="ml-2 w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500" readonly>
                            </div>
                        </div>
                        <div>
                            <label for="button_text" class="block text-sm font-medium text-gray-700 mb-1">Button Text</label>
                            <div class="flex">
                                <input type="color" id="button_text" name="button_text" value="<?php echo $button_text; ?>" class="h-10 w-10 rounded border">
                                <input type="text" value="<?php echo $button_text; ?>" class="ml-2 w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500" readonly>
                            </div>
                        </div>
                        <div>
                            <label for="chat_bubble_user" class="block text-sm font-medium text-gray-700 mb-1">User Chat Bubble</label>
                            <div class="flex">
                                <input type="color" id="chat_bubble_user" name="chat_bubble_user" value="<?php echo $chat_bubble_user; ?>" class="h-10 w-10 rounded border">
                                <input type="text" value="<?php echo $chat_bubble_user; ?>" class="ml-2 w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500" readonly>
                            </div>
                        </div>
                        <div>
                            <label for="chat_bubble_bot" class="block text-sm font-medium text-gray-700 mb-1">Bot Chat Bubble</label>
                            <div class="flex">
                                <input type="color" id="chat_bubble_bot" name="chat_bubble_bot" value="<?php echo $chat_bubble_bot; ?>" class="h-10 w-10 rounded border">
                                <input type="text" value="<?php echo $chat_bubble_bot; ?>" class="ml-2 w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500" readonly>
                            </div>
                        </div>
                        <div>
                            <label for="input_border" class="block text-sm font-medium text-gray-700 mb-1">Input Border</label>
                            <div class="flex">
                                <input type="color" id="input_border" name="input_border" value="<?php echo $input_border; ?>" class="h-10 w-10 rounded border">
                                <input type="text" value="<?php echo $input_border; ?>" class="ml-2 w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500" readonly>
                            </div>
                        </div>
                        <div>
                            <label for="input_focus" class="block text-sm font-medium text-gray-700 mb-1">Input Focus</label>
                            <div class="flex">
                                <input type="color" id="input_focus" name="input_focus" value="<?php echo $input_focus; ?>" class="h-10 w-10 rounded border">
                                <input type="text" value="<?php echo $input_focus; ?>" class="ml-2 w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500" readonly>
                            </div>
                        </div>
                        <div>
                            <label for="font_family" class="block text-sm font-medium text-gray-700 mb-1">Font Family</label>
                            <select id="font_family" name="font_family" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500">
                                <option value="Inter, sans-serif" <?php if($font_family == 'Inter, sans-serif'){ echo "selected"; } ?>>Inter</option>
                                <option value="Roboto, sans-serif" <?php if($font_family == 'Roboto, sans-serif'){ echo "selected"; } ?>>Roboto</option>
                                <option value="Poppins, sans-serif" <?php if($font_family == 'Poppins, sans-serif'){ echo "selected"; } ?>>Poppins</option>
                                <option value="Open Sans, sans-serif" <?php if($font_family == 'Open Sans, sans-serif'){ echo "selected"; } ?>>Open Sans</option>
                                <option value="Lato, sans-serif" <?php if($font_family == 'Lato, sans-serif'){ echo "selected"; } ?>>Lato</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="botlist.php" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Cancel</a>
                <button type="submit" name="submit" class="px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">Update Bot</button>
            </div>
        </form>
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