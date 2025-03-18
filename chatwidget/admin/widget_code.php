<?php
require_once(__DIR__ . '/connection.php');
require_once(__DIR__ . '/functions.inc.php');

// Start session if not already started
if(!isset($_SESSION)) {
    session_start();
}

// Check authentication
if(!isset($_SESSION['username'])) {
    header('location:login.php');
    die();
}

// Define SITE_PATH if not already defined
if (!defined('SITE_PATH')) {
    define('SITE_PATH', 'http://' . $_SERVER['HTTP_HOST'] . '/icognito_new/chatwidget/');
}

// Get the bot ID from URL parameter or session
$bot_id = isset($_GET['id']) ? mysqli_real_escape_string($con, $_GET['id']) : '';

// Get the bot details
if($bot_id != '') {
    // If user is subscriber, only show their own bots
    if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'subscriber') {
        $user_id = $_SESSION['user_id'];
        $sql = "SELECT s.*, u.username as owner_name 
                FROM settings s 
                JOIN admin_users u ON s.user_id = u.id 
                WHERE s.id = '$bot_id' AND s.user_id = '$user_id'";
    } else {
        $sql = "SELECT s.*, u.username as owner_name 
                FROM settings s 
                JOIN admin_users u ON s.user_id = u.id 
                WHERE s.id = '$bot_id'";
    }
    
    $result = mysqli_query($con, $sql);
    $bot_details = mysqli_fetch_assoc($result);
    
    if(!$bot_details) {
        header('location: botlist.php');
        die();
    }

    // Extract bot details into variables
    $theme_type = $bot_details['theme_type'];
    $initial_message = $bot_details['initial_message'];
    $company_name = $bot_details['company_name'];
    $api_url = $bot_details['api_url'];
    
    // Get custom theme if exists
    $custom_theme = null;
    if ($theme_type === 'custom') {
        $theme_sql = "SELECT * FROM custom_themes WHERE settings_id = '$bot_id'";
        $theme_result = mysqli_query($con, $theme_sql);
        if ($theme_result && mysqli_num_rows($theme_result) > 0) {
            $theme_data = mysqli_fetch_assoc($theme_result);
            $custom_theme = json_encode([
                'primaryColor' => $theme_data['primary_color'],
                'secondaryColor' => $theme_data['secondary_color'],
                'headerBg' => $theme_data['header_bg'],
                'headerText' => $theme_data['header_text'],
                'buttonBg' => $theme_data['button_bg'],
                'buttonText' => $theme_data['button_text'],
                'chatBubbleUser' => $theme_data['chat_bubble_user'],
                'chatBubbleBot' => $theme_data['chat_bubble_bot'],
                'inputBorder' => $theme_data['input_border'],
                'inputFocus' => $theme_data['input_focus'],
                'fontFamily' => $theme_data['font_family']
            ]);
        }
    }
} else {
    header('location: botlist.php');
    die();
}

require('top.php');
?>

<div class="p-6">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold mb-6">Get Widget Code</h2>

        <!-- Platform Selection -->
        <div class="mb-8">
            <label class="block text-gray-700 text-sm font-bold mb-4">Select Your Website Platform:</label>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <button onclick="showCode('html')"
                    class="platform-btn bg-white border-2 border-gray-500 p-4 rounded-lg hover:bg-gray-50 transition-colors">
                    <i class="fas fa-code text-2xl mb-2 text-gray-600"></i>
                    <p class="font-semibold">HTML/Static Website</p>
                </button>
                <button onclick="showCode('wordpress')"
                    class="platform-btn bg-white border-2 border-gray-500 p-4 rounded-lg hover:bg-gray-50 transition-colors">
                    <i class="fab fa-wordpress text-2xl mb-2 text-gray-600"></i>
                    <p class="font-semibold">WordPress</p>
                </button>
                <button onclick="showCode('wix')"
                    class="platform-btn bg-white border-2 border-gray-500 p-4 rounded-lg hover:bg-gray-50 transition-colors">
                    <i class="fab fa-wix text-2xl mb-2 text-gray-600"></i>
                    <p class="font-semibold">Wix</p>
                </button>
                <button onclick="showCode('react')"
                    class="platform-btn bg-white border-2 border-gray-500 p-4 rounded-lg hover:bg-gray-50 transition-colors">
                    <i class="fab fa-react text-2xl mb-2 text-gray-600"></i>
                    <p class="font-semibold">React</p>
                </button>
                <button onclick="showCode('angular')"
                    class="platform-btn bg-white border-2 border-gray-500 p-4 rounded-lg hover:bg-gray-50 transition-colors">
                    <i class="fab fa-angular text-2xl mb-2 text-gray-600"></i>
                    <p class="font-semibold">Angular</p>
                </button>
            </div>
        </div>

        <!-- Code Display Sections -->
        <div id="html-code" class="code-section hidden">
            <h3 class="text-xl font-semibold mb-4">HTML Integration</h3>
            <p class="text-gray-600 mb-4">Add this code just before the closing &lt;/body&gt; tag of your HTML:</p>
            <div class="relative">
                <pre class="bg-gray-800 text-white p-4 rounded-lg overflow-x-auto"><code>&lt;!-- ChatWidget Integration --&gt;
&lt;script src="https://widgetschats.s3.us-east-1.amazonaws.com/assets/index-Bd67SnqX.js"&gt;&lt;/script&gt;
&lt;script&gt;
    window.ChatWidget({
        botId: '<?php echo htmlspecialchars($bot_id); ?>',
        themeType: '<?php echo htmlspecialchars($theme_type); ?>',
        <?php if ($theme_type === 'custom' && $custom_theme): ?>
        customTheme: <?php echo $custom_theme; ?>,
        <?php endif; ?>
        initialMessage: '<?php echo htmlspecialchars($initial_message); ?>',
        companyName: '<?php echo htmlspecialchars($company_name); ?>',
        apiUrl: '<?php echo htmlspecialchars($api_url); ?>',
        position: 'bottom-right'
    });
&lt;/script&gt;</code></pre>
                <button onclick="copyCode('html')"
                    class="absolute top-2 right-2 bg-gray-500 text-white px-3 py-1 rounded hover:bg-gray-600">
                    <i class="fas fa-copy mr-1"></i> Copy
                </button>
            </div>
        </div>

        <div id="wordpress-code" class="code-section hidden">
            <h3 class="text-xl font-semibold mb-4">WordPress Integration</h3>
            <p class="text-gray-600 mb-4">Option 1: Add this code to your theme's footer.php file:</p>
            <div class="relative mb-6">
                <pre class="bg-gray-800 text-white p-4 rounded-lg overflow-x-auto"><code>&lt;?php
// Add this code to your functions.php
function add_chat_widget() {
    echo '&lt;script src="https://widgetschats.s3.us-east-1.amazonaws.com/assets/index-Bd67SnqX.js"&gt;&lt;/script&gt;
    &lt;script&gt;
        window.ChatWidget({
            botId: "<?php echo htmlspecialchars($bot_id); ?>",
            themeType: "<?php echo htmlspecialchars($theme_type); ?>",
            <?php if ($theme_type === 'custom' && $custom_theme): ?>
            customTheme: <?php echo $custom_theme; ?>,
            <?php endif; ?>
            initialMessage: "<?php echo htmlspecialchars($initial_message); ?>",
            companyName: "<?php echo htmlspecialchars($company_name); ?>",
            apiUrl: "<?php echo htmlspecialchars($api_url); ?>",
            position: "bottom-right"
        });
    &lt;/script&gt;';
}
add_action('wp_footer', 'add_chat_widget');
?&gt;</code></pre>
                <button onclick="copyCode('wordpress')"
                    class="absolute top-2 right-2 bg-gray-500 text-white px-3 py-1 rounded hover:bg-gray-600">
                    <i class="fas fa-copy mr-1"></i> Copy
                </button>
            </div>
            <p class="text-gray-600 mb-4">Option 2: Use a header/footer plugin and paste the HTML code:</p>
            <div class="relative">
                <pre class="bg-gray-800 text-white p-4 rounded-lg overflow-x-auto"><code>&lt;script src="https://widgetschats.s3.us-east-1.amazonaws.com/assets/index-Bd67SnqX.js"&gt;&lt;/script&gt;
&lt;script&gt;
    window.ChatWidget({
        botId: '<?php echo htmlspecialchars($bot_id); ?>',
        themeType: '<?php echo htmlspecialchars($theme_type); ?>',
        <?php if ($theme_type === 'custom' && $custom_theme): ?>
        customTheme: <?php echo $custom_theme; ?>,
        <?php endif; ?>
        initialMessage: '<?php echo htmlspecialchars($initial_message); ?>',
        companyName: '<?php echo htmlspecialchars($company_name); ?>',
        apiUrl: '<?php echo htmlspecialchars($api_url); ?>',
        position: 'bottom-right'
    });
&lt;/script&gt;</code></pre>
                <button onclick="copyCode('wordpress-simple')"
                    class="absolute top-2 right-2 bg-gray-500 text-white px-3 py-1 rounded hover:bg-gray-600">
                    <i class="fas fa-copy mr-1"></i> Copy
                </button>
            </div>
        </div>

        <div id="wix-code" class="code-section hidden">
            <h3 class="text-xl font-semibold mb-4">Wix Integration</h3>
            <p class="text-gray-600 mb-4">Follow these steps to add the chat widget to your Wix site:</p>
            <ol class="list-decimal pl-6 mb-4 text-gray-600">
                <li class="mb-2">Go to your Wix Editor</li>
                <li class="mb-2">Click on the "+" button to add elements</li>
                <li class="mb-2">Search for "Custom Code" or "HTML Embed"</li>
                <li class="mb-2">Drag it to your page (preferably in the footer area)</li>
                <li class="mb-2">Paste this code:</li>
            </ol>
            <div class="relative">
                <pre class="bg-gray-800 text-white p-4 rounded-lg overflow-x-auto"><code>&lt;script src="https://widgetschats.s3.us-east-1.amazonaws.com/assets/index-Bd67SnqX.js"&gt;&lt;/script&gt;
&lt;script&gt;
    window.ChatWidget({
        botId: '<?php echo htmlspecialchars($bot_id); ?>',
        themeType: '<?php echo htmlspecialchars($theme_type); ?>',
        <?php if ($theme_type === 'custom' && $custom_theme): ?>
        customTheme: <?php echo $custom_theme; ?>,
        <?php endif; ?>
        initialMessage: '<?php echo htmlspecialchars($initial_message); ?>',
        companyName: '<?php echo htmlspecialchars($company_name); ?>',
        apiUrl: '<?php echo htmlspecialchars($api_url); ?>',
        position: 'bottom-right'
    });
&lt;/script&gt;</code></pre>
                <button onclick="copyCode('wix')"
                    class="absolute top-2 right-2 bg-gray-500 text-white px-3 py-1 rounded hover:bg-gray-600">
                    <i class="fas fa-copy mr-1"></i> Copy
                </button>
            </div>
        </div>

        <div id="react-code" class="code-section hidden">
            <h3 class="text-xl font-semibold mb-4">React Integration</h3>
            <p class="text-gray-600 mb-4">Follow these steps to add the chat widget to your React application:</p>

            <h4 class="text-lg font-semibold mt-6 mb-2">Step 1: Install Dependencies</h4>
            <p class="text-gray-600 mb-4">First, create a new component file (e.g., ChatWidget.js):</p>
            <div class="relative mb-6">
                <pre class="bg-gray-800 text-white p-4 rounded-lg overflow-x-auto"><code>import React, { useEffect } from 'react';

const ChatWidget = () => {
    useEffect(() => {
        // Load chat widget script
        const script = document.createElement('script');
        script.src = 'https://widgetschats.s3.us-east-1.amazonaws.com/assets/index-Bd67SnqX.js';
        script.async = true;
        script.onload = () => {
            // Initialize widget after script loads
            window.ChatWidget({
                botId: '<?php echo htmlspecialchars($bot_id); ?>',
                themeType: '<?php echo htmlspecialchars($theme_type); ?>',
                <?php if ($theme_type === 'custom' && $custom_theme): ?>
                customTheme: <?php echo $custom_theme; ?>,
                <?php endif; ?>
                initialMessage: '<?php echo htmlspecialchars($initial_message); ?>',
                companyName: '<?php echo htmlspecialchars($company_name); ?>',
                apiUrl: '<?php echo htmlspecialchars($api_url); ?>',
                position: 'bottom-right'
            });
        };
        document.body.appendChild(script);

        // Cleanup on unmount
        return () => {
            document.body.removeChild(script);
        };
    }, []);

    return null;
};

export default ChatWidget;</code></pre>
                <button onclick="copyCode('react-component')"
                    class="absolute top-2 right-2 bg-gray-500 text-white px-3 py-1 rounded hover:bg-gray-600">
                    <i class="fas fa-copy mr-1"></i> Copy
                </button>
            </div>

            <h4 class="text-lg font-semibold mt-6 mb-2">Step 2: Use the Component</h4>
            <p class="text-gray-600 mb-4">Import and use the ChatWidget component in your app:</p>
            <div class="relative">
                <pre class="bg-gray-800 text-white p-4 rounded-lg overflow-x-auto"><code>import ChatWidget from './ChatWidget';

function App() {
    return (
        <div>
            {/* Your other components */}
            <ChatWidget />
        </div>
    );
}</code></pre>
                <button onclick="copyCode('react-usage')"
                    class="absolute top-2 right-2 bg-gray-500 text-white px-3 py-1 rounded hover:bg-gray-600">
                    <i class="fas fa-copy mr-1"></i> Copy
                </button>
            </div>
        </div>

        <div id="angular-code" class="code-section hidden">
            <h3 class="text-xl font-semibold mb-4">Angular Integration</h3>
            <p class="text-gray-600 mb-4">Follow these steps to add the chat widget to your Angular application:</p>

            <h4 class="text-lg font-semibold mt-6 mb-2">Step 1: Create Chat Widget Component</h4>
            <p class="text-gray-600 mb-4">Create a new component (e.g., chat-widget.component.ts):</p>
            <div class="relative mb-6">
                <pre class="bg-gray-800 text-white p-4 rounded-lg overflow-x-auto"><code>import { Component, OnInit, OnDestroy } from '@angular/core';

@Component({
    selector: 'app-chat-widget',
    template: ''
})
export class ChatWidgetComponent implements OnInit, OnDestroy {
    private script: HTMLScriptElement;

    ngOnInit() {
        // Load chat widget script
        this.script = document.createElement('script');
        this.script.src = 'https://widgetschats.s3.us-east-1.amazonaws.com/assets/index-Bd67SnqX.js';
        this.script.async = true;
        this.script.onload = () => {
            // Initialize widget after script loads
            (window as any).ChatWidget({
                botId: '<?php echo htmlspecialchars($bot_id); ?>',
                themeType: '<?php echo htmlspecialchars($theme_type); ?>',
                <?php if ($theme_type === 'custom' && $custom_theme): ?>
                customTheme: <?php echo $custom_theme; ?>,
                <?php endif; ?>
                initialMessage: '<?php echo htmlspecialchars($initial_message); ?>',
                companyName: '<?php echo htmlspecialchars($company_name); ?>',
                apiUrl: '<?php echo htmlspecialchars($api_url); ?>',
                position: 'bottom-right'
            });
        };
        document.body.appendChild(this.script);
    }

    ngOnDestroy() {
        // Cleanup
        if (this.script) {
            document.body.removeChild(this.script);
        }
    }
}</code></pre>
                <button onclick="copyCode('angular-component')"
                    class="absolute top-2 right-2 bg-gray-500 text-white px-3 py-1 rounded hover:bg-gray-600">
                    <i class="fas fa-copy mr-1"></i> Copy
                </button>
            </div>

            <h4 class="text-lg font-semibold mt-6 mb-2">Step 2: Add to Module</h4>
            <p class="text-gray-600 mb-4">Add the component to your module declarations:</p>
            <div class="relative mb-6">
                <pre class="bg-gray-800 text-white p-4 rounded-lg overflow-x-auto"><code>import { NgModule } from '@angular/core';
import { ChatWidgetComponent } from './chat-widget.component';

@NgModule({
    declarations: [
        ChatWidgetComponent
    ],
    exports: [
        ChatWidgetComponent
    ]
})
export class ChatWidgetModule { }</code></pre>
                <button onclick="copyCode('angular-module')"
                    class="absolute top-2 right-2 bg-gray-500 text-white px-3 py-1 rounded hover:bg-gray-600">
                    <i class="fas fa-copy mr-1"></i> Copy
                </button>
            </div>

            <h4 class="text-lg font-semibold mt-6 mb-2">Step 3: Use the Component</h4>
            <p class="text-gray-600 mb-4">Add the component to your template:</p>
            <div class="relative">
                <pre class="bg-gray-800 text-white p-4 rounded-lg overflow-x-auto"><code>&lt;!-- In your app.component.html or any other template --&gt;
&lt;app-chat-widget&gt;&lt;/app-chat-widget&gt;</code></pre>
                <button onclick="copyCode('angular-usage')"
                    class="absolute top-2 right-2 bg-gray-500 text-white px-3 py-1 rounded hover:bg-gray-600">
                    <i class="fas fa-copy mr-1"></i> Copy
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function showCode(platform) {
    // Hide all code sections
    document.querySelectorAll('.code-section').forEach(section => {
        section.classList.add('hidden');
    });

    // Show selected platform's code
    document.getElementById(platform + '-code').classList.remove('hidden');

    // Update button styles
    document.querySelectorAll('.platform-btn').forEach(btn => {
        btn.classList.remove('bg-gray-500', 'text-white');
        btn.classList.add('bg-white');
    });
    event.currentTarget.classList.remove('bg-white');
    event.currentTarget.classList.add('bg-gray-500', 'text-white');
}

function copyCode(platform) {
    const codeElement = document.querySelector(`#${platform}-code pre code`);
    const textArea = document.createElement('textarea');
    textArea.value = codeElement.textContent;
    document.body.appendChild(textArea);
    textArea.select();
    document.execCommand('copy');
    document.body.removeChild(textArea);

    // Show feedback
    const button = document.querySelector(`#${platform}-code button`);
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="fas fa-check mr-1"></i> Copied!';
    setTimeout(() => {
        button.innerHTML = originalText;
    }, 2000);
}

// Show HTML code by default
showCode('html');
</script>
</div>
</div>
</body>

</html>