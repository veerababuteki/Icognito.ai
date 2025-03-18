<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="color-scheme" content="dark light">
    <title>
        iCognito AI
    </title>
    <link rel="shortcut icon" href="./image/favicon.ico" type="image/x-icon">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Plugin'stylesheets  -->
    <link rel="stylesheet" type="text/css" href="./fonts/typography/fonts.css">
    <link rel="stylesheet" href="./fonts/fontawesome/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="./plugins/aos/aos.min.css">
    <link rel="stylesheet" type="text/css" href="./plugins/fancybox/jquery.fancybox.min.css">
    <link rel="stylesheet" type="text/css" href="./plugins/slick/slick.min.css">
    <link rel="stylesheet" type="text/css" href="./plugins/slick/slick-theme.css">
    <!-- Vendor stylesheets  -->
    <link rel="stylesheet" type="text/css" href="./plugins/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="./css/style.css">
    <link rel="stylesheet" type="text/css" href="./css/custom.css">
    <link rel="stylesheet" type="text/css" href="./css/form.css">

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
    @import url('https://fonts.cdnfonts.com/css/clash-display');
    </style>
</head>

<body>
    <div class="preloader-wrapper">
        <div class="lds-ellipsis">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <div class="page-wrapper overflow-hidden">
        <!--~~~~~~~~~~~~~~~~~~~~~~~~
     Header Area
 ~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
        <header class="site-header site-header--transparent site-header--sticky">
            <div class="container">
                <nav class="navbar site-navbar">

                    <div class="brand-logo">
                        <a href="/">

                            <img class="logo-light" src="./image/logo-icognito.svg" alt="logo">

                            <img class="logo-dark" src="./image/logo-icognito.svg" alt="logo">
                        </a>
                    </div>
                    <div class="menu-block-wrapper ">
                        <div class="menu-overlay"></div>
                        <nav class="menu-block" id="append-menu-header">
                            <div class="mobile-menu-head">
                                <a href="index.html">
                                    <img src="./image/logo-icognito1.svg" alt="brand logo">
                                </a>
                                <div class="current-menu-title"></div>
                                <div class="mobile-menu-close">&times;</div>
                            </div>
                            <ul class="site-menu-main">

                                <!-- <li class="nav-item">
                                    <a href="" class="nav-link-item drop-trigger">Product</a>
                                </li> -->
                                <li class="nav-item nav-item-has-children">
                                    <a href="#" class="nav-link-item drop-trigger">Products<i
                                            class="fas fa-angle-down"></i>
                                    </a>
                                    <div class="sub-menu" id="submenu-13">
                                        <ul class="sub-menu_list">
                                            <li class="sub-menu_item">
                                                <a href="conversational_ai_platform.php">
                                                    <span class="menu-item-text">Conversational AI Platform</span>
                                                </a>
                                            </li>
                                            <li class="sub-menu_item">
                                                <a href="chat_automation.php">
                                                    <span class="menu-item-text">Chat Automation</span>
                                                </a>
                                            </li>
                                            <li class="sub-menu_item">
                                                <a href="voice_call_automation.php">
                                                    <span class="menu-item-text">Voice Call Automation</span>
                                                </a>
                                            </li>
                                            <li class="sub-menu_item">
                                                <a href="integration.php">
                                                    <span class="menu-item-text">Integration</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item nav-item-has-children">
                                    <a href="#" class="nav-link-item drop-trigger">Industries<i
                                            class="fas fa-angle-down"></i>
                                    </a>
                                    <div class="sub-menu" id="submenu-13">
                                        <ul class="sub-menu_list">
                                            <li class="sub-menu_item">
                                                <a href="financial_service.php">
                                                    <span class="menu-item-text">financial Service</span>
                                                </a>
                                            </li>
                                            <li class="sub-menu_item">
                                                <a href="insurance.php">
                                                    <span class="menu-item-text">Insurance</span>
                                                </a>
                                            </li>
                                            <li class="sub-menu_item">
                                                <a href="telecom.php">
                                                    <span class="menu-item-text">Telecom</span>
                                                </a>
                                            </li>
                                            <li class="sub-menu_item">
                                                <a href="public_sector.php">
                                                    <span class="menu-item-text">Public Sector</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item nav-item-has-children">
                                    <a href="#" class="nav-link-item drop-trigger">Use Cases<i
                                            class="fas fa-angle-down"></i>
                                    </a>
                                    <div class="sub-menu" id="submenu-13">
                                        <ul class="sub-menu_list">
                                            <li class="sub-menu_item">
                                                <a href="customer_self_service.php">
                                                    <span class="menu-item-text">Customer Self Service</span>
                                                </a>
                                            </li>
                                            <li class="sub-menu_item">
                                                <a href="internal_virtual.php">
                                                    <span class="menu-item-text">Internal Virtual Agent</span>
                                                </a>
                                            </li>
                                            <li class="sub-menu_item">
                                                <a href="agent_assist.php">
                                                    <span class="menu-item-text">Agent Assist</span>
                                                </a>
                                            </li>
                                           
                                        </ul>
                                    </div>
                                </li>
                                <!-- <li class="nav-item">
                                    <a href="" class="nav-link-item drop-trigger">Industries</a>
                                </li>
                                <li class="nav-item">
                                    <a href="" class="nav-link-item drop-trigger">Use Cases</a>
                                </li>-->
                                <li class="nav-item">
                                    <a href="company.php" class="nav-link-item drop-trigger">Company</a>
                                </li> 


                                <!-- <li class="nav-item nav-item-has-children">
                                    <a href="#" class="nav-link-item drop-trigger">Company<i
                                            class="fas fa-angle-down"></i>
                                    </a>
                                    <div class="sub-menu" id="submenu-13">
                                        <ul class="sub-menu_list">
                                            <li class="sub-menu_item">
                                                <a href="">
                                                    <span class="menu-item-text">About</span>
                                                </a>
                                            </li>
                                            <li class="sub-menu_item">
                                                <a href="">
                                                    <span class="menu-item-text">Team</span>
                                                </a>
                                            </li>
                                            <li class="sub-menu_item">
                                                <a href="">
                                                    <span class="menu-item-text">Services</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li> -->


                            </ul>
                        </nav>
                    </div>

                    <div class="mobile-menu-trigger">
                        <span></span>
                    </div>

                    <div class="header-cta-btn-wrapper">

                        <a href="chatwidget/chatform.php" class="btn-masco btn-masco--header btn-primary-l07 rounded-pill btn-shadow"
                            id="requestDemoBtn">
                            <span>Launch your ChatBot</span></a>
                    </div>
                </nav>
            </div>
        </header>