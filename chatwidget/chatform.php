<?php
require_once(__DIR__ . '/connection.inc.php');
require_once(__DIR__ . '/functions.inc.php');

// Initialize session and CSRF protection
init_session();

// Get current step with validation
$step = filter_input(INPUT_GET, 'step', FILTER_VALIDATE_INT) ?: 1;
$step = min(max($step, 1), 4); // Ensure step is between 1 and 4

// Add CSS for preloader
if ($step >0) {
    echo '
    <!DOCTYPE html>
    <html>
    <head>
        <style>
            .preloader {
                position: fixed;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(255, 255, 255, 0.97);
                z-index: 9999;
                display: none;
            }
            .preloader-content {
                position: absolute;
                left: 50%;
                top: 50%;
                transform: translate(-50%, -50%);
                text-align: center;
            }
            .dot-loader {
                width: 100px;
                height: 100px;
                background: linear-gradient(135deg, #8a2be2, #9370db);
                border-radius: 50%;
                margin: 0 auto;
                animation: pulse 1.5s ease-in-out infinite;
                box-shadow: 0 0 30px rgba(138, 43, 226, 0.2);
            }
            @keyframes pulse {
                0% {
                    transform: scale(0.8);
                    opacity: 0.5;
                }
                50% {
                    transform: scale(1.2);
                    opacity: 0.8;
                }
                100% {
                    transform: scale(0.8);
                    opacity: 0.5;
                }
            }
            .preloader-text {
                color: #8a2be2;
                font-size: 24px;
                font-family: Arial, sans-serif;
                font-weight: 500;
                margin-top: 30px;
                opacity: 0.8;
                animation: textPulse 1.5s ease-in-out infinite;
            }
            @keyframes textPulse {
                0% {
                    opacity: 0.5;
                }
                50% {
                    opacity: 0.9;
                }
                100% {
                    opacity: 0.5;
                }
            }
            .preloader-background {
                position: absolute;
                width: 100%;
                height: 100%;
                background: linear-gradient(135deg, rgba(238, 230, 255, 0.5), rgba(255, 255, 255, 0.95));
                z-index: -1;
            }
        </style>
    </head>
    <body>
        <div class="preloader">
            <div class="preloader-background"></div>
            <div class="preloader-content">
                <div class="dot-loader"></div>
                <p class="preloader-text">Please wait...</p>
            </div>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const forms = document.querySelectorAll("form");
                const preloader = document.querySelector(".preloader");
                
                forms.forEach(function(form) {
                    form.addEventListener("submit", function(e) {
                        // Show preloader only if form is valid
                        if(form.checkValidity()) {
                            preloader.style.display = "block";
                        }
                    });
                });

                // Also show preloader when navigating away
                window.addEventListener("beforeunload", function() {
                    preloader.style.display = "block";
                });
            });
        </script>
    </body>
    </html>
    ';
}

// Initialize session variables if not set
if (!isset($_SESSION['bot_config'])) {
    $_SESSION['bot_config'] = [
        'company_name' => '',
        'website_url' => '',
        'initial_message' => '',
        'theme_type' => '',
        'background_img' => '',
        'custom_theme' => []
    ];
}

// Redirect to step 1 if trying to access later steps without completing previous steps
/* if ($step > 1 && empty($_SESSION['bot_config']['company_name'])) {
    header('Location: chatform.php?step=1');
    exit();
} */

$error_msg = '';
$success_msg = '';

// Handle form submissions
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verify CSRF token
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        $error_msg = "Invalid form submission. Please try again.";
    } else {
        switch($step) {
            case 1:
                if (isset($_POST['step1_submit'])) {
                    handleStep1Submission();
                }
                break;
            case 2:
                if (isset($_POST['step2_submit'])) {
                    handleStep2Submission();
                }
                break;
            case 3:
                if (isset($_POST['step3_submit'])) {
                    handleStep3Submission();
                }
                break;
        }
    }
}
// echo $step;
// exit;
/**
 * Handle Step 1: Bot Configuration
 */
function handleStep1Submission() {
    global $con, $error_msg;
    
    try {
        // Validate inputs
        $company_name = get_safe_value($con, $_POST['company_name']);
        $website_url = filter_var($_POST['website_url'], FILTER_VALIDATE_URL);
        $initial_message = get_safe_value($con, $_POST['initial_message']);
        // $theme_type = in_array($_POST['theme_type'], ['default', 'custom']) ? $_POST['theme_type'] : 'default';
        $theme_type = isset($_POST['theme_type']) ? $_POST['theme_type'] : 'solid';
        
        if (!$website_url) {
            throw new Exception("Invalid website URL");
        }

        // Call Flask API to get bot configuration
        $api_url = 'http://3.230.115.210:5011/submit_business';
        $website_domain = parse_url($website_url, PHP_URL_HOST);
        $business_id = str_replace(['.', '-', ' '], '_', strtolower($website_domain));
        
        // Clean and prepare the data
        $company_name = trim($company_name);
        $website_url = trim($website_url);
        $initial_message = trim($initial_message);

        // Remove any trailing slashes from website URL
        $website_url = rtrim($website_url, '/');
        
        // Prepare API request data
        $api_data = [
            'name' => $company_name,
            'website' => $website_url,
            'descp' => empty($initial_message) ? "Welcome to our chat!" : $initial_message
        ];

        // Convert to JSON with proper encoding
        $json_data = json_encode($api_data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("JSON encoding error: " . json_last_error_msg());
        }
        
        // Debug log before API call
        log_error('API Request Data', [
            'url' => $api_url,
            'data' => $api_data,
            'json' => $json_data
        ]);
        
        // Initialize CURL with retry mechanism
        $max_retries = 3;
        $retry_count = 0;
        $success = false;
        
        while ($retry_count < $max_retries && !$success) {
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => $api_url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/json',
                    'Accept: application/json',
                    'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'
                ],
                CURLOPT_POSTFIELDS => $json_data,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_TIMEOUT => 300,           // Reduced timeout to 15 seconds
                // CURLOPT_CONNECTTIMEOUT => 5,     // Connection timeout of 5 seconds
                CURLOPT_VERBOSE => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_TCP_KEEPALIVE => 1,
                CURLOPT_TCP_NODELAY => 1
            ]);

            // Create a temporary file to store CURL debug info
            $verbose = fopen('php://temp', 'w+');
            curl_setopt($curl, CURLOPT_STDERR, $verbose);

            // Execute the request
            $response = curl_exec($curl);
            $curl_info = curl_getinfo($curl);
            $http_code = $curl_info['http_code'];
            
            // Get CURL errors if any
            $curl_error = '';
            if ($response === false) {
                $curl_error = curl_error($curl);
            }
            
            // Get debug information
            rewind($verbose);
            $verbose_log = stream_get_contents($verbose);
            fclose($verbose);
            
            curl_close($curl);

            // Log the complete API interaction
            log_error('API Interaction Details - Attempt ' . ($retry_count + 1), [
                'request_url' => $api_url,
                'request_data' => $api_data,
                'response' => $response,
                'http_code' => $http_code,
                'curl_info' => $curl_info,
                'curl_error' => $curl_error,
                'verbose_log' => $verbose_log
            ]);

            // Check if request was successful
            if ($response !== false && $http_code === 200) {
                $success = true;
                break;
            }

            // If not successful, wait before retrying
            $retry_count++;
            if ($retry_count < $max_retries) {
                sleep(2); // Wait 2 seconds before retrying
            }
        }

        if (!$success) {
            throw new Exception("API connection failed after {$max_retries} attempts. Last error: " . ($curl_error ?: "HTTP {$http_code}"));
        }

        // Try to decode the response
        $decoded_response = json_decode($response, true);
        if (!$decoded_response) {
            throw new Exception("Failed to decode API response. Response: " . substr($response, 0, 100));
        }

        if (!isset($decoded_response['ask_url'])) {
            throw new Exception("Invalid API response structure. Missing 'ask_url' field. Response: " . json_encode($decoded_response));
        }
        
        // Store in session
    $_SESSION['bot_config'] = [
        'company_name' => $company_name,
        'website_url' => $website_url,
        'initial_message' => $initial_message,
        'theme_type' => $theme_type,
        'background_img' => '',
            'custom_theme' => [],
            'api_response' => $decoded_response
        ];

        // Store API configuration
        $_SESSION['api_config'] = [
            'api_key' => $business_id,
            'api_endpoint' => $decoded_response['ask_url'],
            'widget_url' => $decoded_response['result'] ?? ''
    ];
    
    // Handle background image upload
        if (isset($_FILES['background_img']) && $_FILES['background_img']['name']) {
            $file_validation = validate_file($_FILES['background_img']);
            if ($file_validation['status']) {
                $background_img = uniqid('bot_') . '_' . basename($_FILES['background_img']['name']);
                $target_path = BOT_IMAGE_PATH . $background_img;
                
                if (move_uploaded_file($_FILES['background_img']['tmp_name'], $target_path)) {
                $_SESSION['bot_config']['background_img'] = 'media/bot/' . $background_img;
            }
            } else {
                throw new Exception($file_validation['message']);
        }
    }

        // Handle custom theme
        if ($theme_type === 'custom') {
        $_SESSION['bot_config']['custom_theme'] = [
                'primary_color' => filter_var($_POST['primary_color'], FILTER_SANITIZE_STRING),
                'secondary_color' => filter_var($_POST['secondary_color'], FILTER_SANITIZE_STRING),
                'header_bg' => filter_var($_POST['header_bg'], FILTER_SANITIZE_STRING),
                'header_text' => filter_var($_POST['header_text'], FILTER_SANITIZE_STRING),
                'button_bg' => filter_var($_POST['button_bg'], FILTER_SANITIZE_STRING),
                'button_text' => filter_var($_POST['button_text'], FILTER_SANITIZE_STRING),
                'chat_bubble_user' => filter_var($_POST['chat_bubble_user'], FILTER_SANITIZE_STRING),
                'chat_bubble_bot' => filter_var($_POST['chat_bubble_bot'], FILTER_SANITIZE_STRING),
                'input_border' => filter_var($_POST['input_border'], FILTER_SANITIZE_STRING),
                'input_focus' => filter_var($_POST['input_focus'], FILTER_SANITIZE_STRING),
                'font_family' => filter_var($_POST['font_family'], FILTER_SANITIZE_STRING)
            ];
        }
        
        header('Location: chatform.php?step=2');
        exit();
        
    } catch (Exception $e) {
        $error_msg = $e->getMessage();
        log_error('Step 1 submission error', [
            'error' => $e->getMessage(),
            'post_data' => $_POST,
            'session_data' => $_SESSION
        ]);
    }
}

/**
 * Handle Step 2: API Configuration
 */
function handleStep2Submission() {
    global $con, $error_msg;
    
    try {
        // API configuration is already set in step 1
        if (!isset($_SESSION['api_config'])) {
            throw new Exception("API configuration not found. Please complete step 1 first.");
        }
        
        header('Location: chatform.php?step=3');
        exit();
        
    } catch (Exception $e) {
        $error_msg = $e->getMessage();
        log_error('Step 2 submission error', ['error' => $e->getMessage()]);
    }
}

/**
 * Handle Step 3: Account Creation
 */
function handleStep3Submission() {
    global $con, $error_msg;
    
    try {
        // Validate inputs
        $business_name = get_safe_value($con, $_POST['business_name']);
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $password = $_POST['password'];
        
        if (!$email) {
            throw new Exception("Invalid email address");
        }
        
        if (strlen($password) < 8) {
            throw new Exception("Password must be at least 8 characters long");
        }
        
        // Check if email exists
        $stmt = mysqli_prepare($con, "SELECT id FROM admin_users WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        
        if (mysqli_stmt_num_rows($stmt) > 0) {
            throw new Exception("Email already exists");
        }
        
        // Start transaction
        mysqli_begin_transaction($con);
        
        try {
            // Insert user
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $role = 'subscriber';
            
            $sql = "INSERT INTO admin_users (username, email, password, role) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, "ssss", $business_name, $email, $hashed_password, $role);
            mysqli_stmt_execute($stmt);
            $user_id = mysqli_insert_id($con);
            
            // Insert bot settings
            $bot_config = $_SESSION['bot_config'];
            $api_config = $_SESSION['api_config'];
            
            $sql = "INSERT INTO settings (user_id, company_name, background_img, api_url, initial_message, theme_type, status, created_at) 
                    VALUES (?, ?, ?, ?, ?, ?, 1, NOW())";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, "isssss", 
                $user_id,
                $bot_config['company_name'],
                $bot_config['background_img'],
                $api_config['api_endpoint'],
                $bot_config['initial_message'],
                $bot_config['theme_type']
            );
            mysqli_stmt_execute($stmt);
            $settings_id = mysqli_insert_id($con);
            
            // Insert custom theme if selected
            if ($bot_config['theme_type'] === 'custom' && !empty($bot_config['custom_theme'])) {
                $theme = $bot_config['custom_theme'];
                $sql = "INSERT INTO custom_themes (settings_id, primary_color, secondary_color, header_bg, header_text, 
                        button_bg, button_text, chat_bubble_user, chat_bubble_bot, input_border, input_focus, font_family) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($con, $sql);
                mysqli_stmt_bind_param($stmt, "isssssssssss",
                    $settings_id,
                    $theme['primary_color'],
                    $theme['secondary_color'],
                    $theme['header_bg'],
                    $theme['header_text'],
                    $theme['button_bg'],
                    $theme['button_text'],
                    $theme['chat_bubble_user'],
                    $theme['chat_bubble_bot'],
                    $theme['input_border'],
                    $theme['input_focus'],
                    $theme['font_family']
                );
                mysqli_stmt_execute($stmt);
            }
            
            mysqli_commit($con);
            
            // Set session and redirect
            $_SESSION['user_id'] = $user_id;
            $_SESSION['success_msg'] = "Account created successfully!";
            
            // Clean up session data
            unset($_SESSION['bot_config']);
            unset($_SESSION['api_config']);
            
            header('Location: chatform.php?step=4');
            exit();
            
        } catch (Exception $e) {
            mysqli_rollback($con);
            throw $e;
        }
        
    } catch (Exception $e) {
        $error_msg = $e->getMessage();
        log_error('Step 3 submission error', ['error' => $e->getMessage()]);
    }
}
// echo $step;
// exit;

// Include the appropriate view file based on step
$view_file = "views/step{$step}.php";
if (file_exists($view_file)) {
    include($view_file);
} else {
    $error_msg = "View file not found";
    include("views/error.php");
}

