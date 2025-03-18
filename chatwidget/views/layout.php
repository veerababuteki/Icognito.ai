<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="color-scheme" content="dark light">
    <title>iCognito AI</title>
    <link rel="shortcut icon" href="./image/favicon.ico" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        @import url('https://fonts.cdnfonts.com/css/clash-display');
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Syne:wght@500;600;700&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Public+Sans:wght@500;600;700;800;900&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Cabin:wght@500;600;700&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap');
        
        /* Prevent form resubmission on page refresh */
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen">
    <!-- Preloader -->
    <div class="fixed inset-0 flex items-center justify-center bg-white z-50 preloader-wrapper">
        <div class="flex space-x-2">
            <div class="w-3 h-3 bg-gray-600 rounded-full animate-bounce"></div>
            <div class="w-3 h-3 bg-gray-600 rounded-full animate-bounce delay-75"></div>
            <div class="w-3 h-3 bg-gray-600 rounded-full animate-bounce delay-150"></div>
            <div class="w-3 h-3 bg-gray-600 rounded-full animate-bounce delay-300"></div>
        </div>
    </div>

    <div class="overflow-hidden">
        <!-- Header Area -->
        <header class="sticky top-0 z-40 bg-white bg-opacity-90 backdrop-blur transition-all">
            <div class="container mx-auto px-4">
                <nav class="flex items-center justify-between py-4">
                    <!-- Brand Logo -->
                    <div class="brand-logo">
                        <a href="/" class="flex items-center">
                            <img class="h-10" src="../image/logo-icognito.svg" alt="logo">
                        </a>
                    </div>
                    
                    <!-- Desktop Menu -->
                    <div class="hidden lg:block">
                        <ul class="flex space-x-8">
                            <!-- Products Dropdown -->
                            <li class="relative group">
                                <a href="#" class="text-gray-800 font-medium flex items-center">
                                    Products
                                    <i class="fas fa-angle-down ml-1 text-xs"></i>
                                </a>
                                <div class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300">
                                    <ul class="py-2">
                                        <li><a href="conversational_ai_platform.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Conversational AI Platform</a></li>
                                        <li><a href="chat_automation.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Chat Automation</a></li>
                                        <li><a href="voice_call_automation.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Voice Call Automation</a></li>
                                        <li><a href="integration.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Integration</a></li>
                                    </ul>
                                </div>
                            </li>
                            
                            <!-- Industries Dropdown -->
                            <li class="relative group">
                                <a href="#" class="text-gray-800 font-medium flex items-center">
                                    Industries
                                    <i class="fas fa-angle-down ml-1 text-xs"></i>
                                </a>
                                <div class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300">
                                    <ul class="py-2">
                                        <li><a href="financial_service.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Financial Service</a></li>
                                        <li><a href="insurance.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Insurance</a></li>
                                        <li><a href="telecom.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Telecom</a></li>
                                        <li><a href="public_sector.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Public Sector</a></li>
                                    </ul>
                                </div>
                            </li>
                            
                            <!-- Use Cases Dropdown -->
                            <li class="relative group">
                                <a href="#" class="text-gray-800 font-medium flex items-center">
                                    Use Cases
                                    <i class="fas fa-angle-down ml-1 text-xs"></i>
                                </a>
                                <div class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300">
                                    <ul class="py-2">
                                        <li><a href="customer_self_service.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Customer Self Service</a></li>
                                        <li><a href="internal_virtual.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Internal Virtual Agent</a></li>
                                        <li><a href="agent_assist.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Agent Assist</a></li>
                                    </ul>
                                </div>
                            </li>
                            
                            <!-- Company -->
                            <li>
                                <a href="company.php" class="text-gray-800 font-medium">Company</a>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Mobile Menu Button -->
                    <div class="lg:hidden">
                        <button class="text-gray-800 focus:outline-none" id="mobile-menu-trigger">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <!-- CTA Button -->
                    <div class="hidden lg:block">
                        <!-- <a href="chatwidget/chatform.php" class="inline-block px-6 py-3 text-white bg-blue-600 hover:bg-blue-700 rounded-full shadow-md transition-all duration-300">
                            Launch your ChatBot
                        </a> -->
                    </div>
                </nav>
            </div>
        </header>
        
        <!-- Mobile Menu (Hidden by default) -->
        <div id="mobile-menu" class="fixed inset-0 z-50 bg-white transform translate-x-full transition-transform duration-300 lg:hidden">
            <div class="relative h-full overflow-y-auto p-4">
                <div class="flex justify-between items-center mb-6">
                    <a href="/">
                        <img class="h-8" src="./image/logo-icognito1.svg" alt="logo">
                    </a>
                    <button id="mobile-menu-close" class="text-gray-500 hover:text-gray-800">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <nav class="mt-8">
                    <ul class="space-y-4">
                        <!-- Products -->
                        <li class="border-b border-gray-200 pb-4">
                            <div class="flex justify-between items-center">
                                <span class="font-medium">Products</span>
                                <button class="mobile-submenu-trigger text-gray-500">
                                    <i class="fas fa-angle-down"></i>
                                </button>
                            </div>
                            <ul class="mt-2 ml-4 hidden">
                                <li class="mt-2"><a href="conversational_ai_platform.php" class="text-gray-600">Conversational AI Platform</a></li>
                                <li class="mt-2"><a href="chat_automation.php" class="text-gray-600">Chat Automation</a></li>
                                <li class="mt-2"><a href="voice_call_automation.php" class="text-gray-600">Voice Call Automation</a></li>
                                <li class="mt-2"><a href="integration.php" class="text-gray-600">Integration</a></li>
                            </ul>
                        </li>
                        
                        <!-- Industries -->
                        <li class="border-b border-gray-200 pb-4">
                            <div class="flex justify-between items-center">
                                <span class="font-medium">Industries</span>
                                <button class="mobile-submenu-trigger text-gray-500">
                                    <i class="fas fa-angle-down"></i>
                                </button>
                            </div>
                            <ul class="mt-2 ml-4 hidden">
                                <li class="mt-2"><a href="financial_service.php" class="text-gray-600">Financial Service</a></li>
                                <li class="mt-2"><a href="insurance.php" class="text-gray-600">Insurance</a></li>
                                <li class="mt-2"><a href="telecom.php" class="text-gray-600">Telecom</a></li>
                                <li class="mt-2"><a href="public_sector.php" class="text-gray-600">Public Sector</a></li>
                            </ul>
                        </li>
                        
                        <!-- Use Cases -->
                        <li class="border-b border-gray-200 pb-4">
                            <div class="flex justify-between items-center">
                                <span class="font-medium">Use Cases</span>
                                <button class="mobile-submenu-trigger text-gray-500">
                                    <i class="fas fa-angle-down"></i>
                                </button>
                            </div>
                            <ul class="mt-2 ml-4 hidden">
                                <li class="mt-2"><a href="customer_self_service.php" class="text-gray-600">Customer Self Service</a></li>
                                <li class="mt-2"><a href="internal_virtual.php" class="text-gray-600">Internal Virtual Agent</a></li>
                                <li class="mt-2"><a href="agent_assist.php" class="text-gray-600">Agent Assist</a></li>
                            </ul>
                        </li>
                        
                        <!-- Company -->
                        <li class="border-b border-gray-200 pb-4">
                            <a href="company.php" class="font-medium">Company</a>
                        </li>
                    </ul>
                    
             
                </nav>
            </div>
        </div>
    
        <!-- Main Content -->
        <div class="container mx-auto px-4 py-8">
            <div class="max-w-3xl mx-auto">
                <!-- Progress Bar -->
                <div class="mb-8">
                    <div class="flex justify-between mb-2">
                        <span class="text-sm font-medium <?php echo $step >= 1 ? 'text-gray-600' : 'text-gray-500'; ?>">Bot Configuration</span>
                        <span class="text-sm font-medium <?php echo $step >= 2 ? 'text-gray-600' : 'text-gray-500'; ?>">API Setup</span>
                        <span class="text-sm font-medium <?php echo $step >= 3 ? 'text-gray-600' : 'text-gray-500'; ?>">Account Setup</span>
                        <span class="text-sm font-medium <?php echo $step >= 4 ? 'text-gray-600' : 'text-gray-500'; ?>">Complete</span>
                    </div>
                    <div class="h-2 bg-gray-200 rounded-full">
                        <div class="h-2 bg-gray-600 rounded-full transition-all" style="width: <?php echo ($step/4)*100; ?>%"></div>
                    </div>
                </div>

                <?php if(isset($error_msg) && $error_msg): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <?php echo htmlspecialchars($error_msg); ?>
                    </div>
                <?php endif; ?>

                <?php if(isset($success_msg) && $success_msg): ?>
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        <?php echo htmlspecialchars($success_msg); ?>
                    </div>
                <?php endif; ?>

                <?php include($content); ?>
            </div>
        </div>
    </div>
    <footer class="bg-gray-900 text-white pt-16 pb-6">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
            <!-- Company Info Column -->
            <div class="md:col-span-4">
                <div class="mb-6">
                    <img src="../image/logo-icognito1.svg" alt="iCognito Logo" class="h-10 mb-4">
                    <p class="text-gray-400 mb-6">
                        Our value proposition is simple yet powerful. With cutting-edge technology and expertise,
                        we push the boundaries of conversational AI in a responsible way. We automate
                        human-to-organization interactions, delivering unparalleled experiences and remarkable
                        organizational outcomes.
                    </p>
                    <a href="mailto:support@icognito.com" class="text-blue-400 hover:text-blue-300 transition duration-300">support@icognito.com</a>
                    
                    <!-- Social Media Links -->
                    <ul class="flex space-x-4 mt-6">
                        <li>
                            <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-blue-600 transition duration-300">
                                <i class="fa-brands fa-facebook-f"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-blue-400 transition duration-300">
                                <i class="fa-brands fa-twitter"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-pink-600 transition duration-300">
                                <i class="fa-brands fa-instagram"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-gray-600 transition duration-300">
                                <i class="fa-brands fa-github"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Footer Links Columns -->
            <div class="md:col-span-8">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-8">
                    <!-- Products Column -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Products</h3>
                        <ul class="space-y-2">
                            <li>
                                <a href="conversational_ai_platform.php" class="text-gray-400 hover:text-white transition duration-300">Conversational AI Platform</a>
                            </li>
                            <li>
                                <a href="chat_automation.php" class="text-gray-400 hover:text-white transition duration-300">Chat Automation</a>
                            </li>
                            <li>
                                <a href="voice_call_automation.php" class="text-gray-400 hover:text-white transition duration-300">Voice Call Automation</a>
                            </li>
                            <li>
                                <a href="integration.php" class="text-gray-400 hover:text-white transition duration-300">Integrations</a>
                            </li>
                            <li>
                                <a href="Generative_ai.php" class="text-gray-400 hover:text-white transition duration-300">Generative AI</a>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Industries Column -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Industries</h3>
                        <ul class="space-y-2">
                            <li>
                                <a href="financial_service.php" class="text-gray-400 hover:text-white transition duration-300">Financial Services</a>
                            </li>
                            <li>
                                <a href="insurance.php" class="text-gray-400 hover:text-white transition duration-300">Insurance</a>
                            </li>
                            <li>
                                <a href="telecom.php" class="text-gray-400 hover:text-white transition duration-300">Telecom</a>
                            </li>
                            <li>
                                <a href="public_sector.php" class="text-gray-400 hover:text-white transition duration-300">Public Sector</a>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Use Cases Column -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Use Cases</h3>
                        <ul class="space-y-2">
                            <li>
                                <a href="customer_self_service.php" class="text-gray-400 hover:text-white transition duration-300">Customer Self-Service</a>
                            </li>
                            <li>
                                <a href="internal_virtual.php" class="text-gray-400 hover:text-white transition duration-300">Internal Virtual Agent</a>
                            </li>
                            <li>
                                <a href="agent_assist.php" class="text-gray-400 hover:text-white transition duration-300">Agent Assist</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Copyright Section -->
        <div class="pt-8 mt-8 border-t border-gray-800 text-center">
            <p class="text-gray-500">© Copyright 2024, All Rights Reserved by iCognito.</p>
        </div>
    </div>
</footer>


    <script>
        // Mobile menu functionality
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuTrigger = document.getElementById('mobile-menu-trigger');
            const mobileMenuClose = document.getElementById('mobile-menu-close');
            const mobileMenu = document.getElementById('mobile-menu');
            
            if (mobileMenuTrigger && mobileMenuClose && mobileMenu) {
                mobileMenuTrigger.addEventListener('click', function() {
                    mobileMenu.classList.remove('translate-x-full');
                });
                
                mobileMenuClose.addEventListener('click', function() {
                    mobileMenu.classList.add('translate-x-full');
                });
                
                // Toggle mobile submenus
                const mobileSubmenuTriggers = document.querySelectorAll('.mobile-submenu-trigger');
                mobileSubmenuTriggers.forEach(trigger => {
                    trigger.addEventListener('click', function() {
                        const submenu = this.closest('li').querySelector('ul');
                        const icon = this.querySelector('i');
                        
                        if (submenu.classList.contains('hidden')) {
                            submenu.classList.remove('hidden');
                            icon.classList.remove('fa-angle-down');
                            icon.classList.add('fa-angle-up');
                        } else {
                            submenu.classList.add('hidden');
                            icon.classList.remove('fa-angle-up');
                            icon.classList.add('fa-angle-down');
                        }
                    });
                });
            }
            
            // Preloader
            const preloader = document.querySelector('.preloader-wrapper');
            if (preloader) {
                window.addEventListener('load', function() {
                    preloader.style.display = 'none';
                });
            }
        });
        
        // Prevent form resubmission on page refresh
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>
</html>