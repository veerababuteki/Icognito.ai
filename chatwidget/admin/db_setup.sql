-- Create database if not exists
CREATE DATABASE IF NOT EXISTS icognito_new;
USE icognito_new;

-- Create admin_users table with improved security
CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'subscriber') NOT NULL DEFAULT 'subscriber',
    status TINYINT(1) DEFAULT 1,
    last_login DATETIME,
    password_reset_token VARCHAR(100),
    password_reset_expires DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create login_attempts table for rate limiting
CREATE TABLE IF NOT EXISTS login_attempts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    ip_address VARCHAR(45) NOT NULL,
    success TINYINT(1) DEFAULT 0,
    attempt_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email_ip (email, ip_address),
    INDEX idx_attempt_time (attempt_time)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create audit_logs table for tracking admin actions
CREATE TABLE IF NOT EXISTS audit_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    action VARCHAR(255) NOT NULL,
    entity_type VARCHAR(50),
    entity_id INT,
    old_values TEXT,
    new_values TEXT,
    ip_address VARCHAR(45),
    user_agent VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES admin_users(id) ON DELETE SET NULL,
    INDEX idx_user_action (user_id, action),
    INDEX idx_entity (entity_type, entity_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create settings table with improved structure
CREATE TABLE IF NOT EXISTS settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    company_name VARCHAR(255) NOT NULL,
    background_img VARCHAR(255),
    api_url VARCHAR(255),
    api_key VARCHAR(255),
    initial_message TEXT,
    theme_type ENUM('default', 'custom') NOT NULL DEFAULT 'default',
    status TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES admin_users(id) ON DELETE CASCADE,
    INDEX idx_user_status (user_id, status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create custom_themes table with improved structure
CREATE TABLE IF NOT EXISTS custom_themes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    settings_id INT NOT NULL,
    primary_color VARCHAR(20),
    secondary_color VARCHAR(20),
    header_bg VARCHAR(20),
    header_text VARCHAR(20),
    button_bg VARCHAR(20),
    button_text VARCHAR(20),
    chat_bubble_user VARCHAR(20),
    chat_bubble_bot VARCHAR(20),
    input_border VARCHAR(20),
    input_focus VARCHAR(20),
    font_family VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (settings_id) REFERENCES settings(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create user_sessions table for better session management
CREATE TABLE IF NOT EXISTS user_sessions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    session_id VARCHAR(255) NOT NULL,
    ip_address VARCHAR(45),
    user_agent VARCHAR(255),
    last_activity TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES admin_users(id) ON DELETE CASCADE,
    INDEX idx_session (session_id),
    INDEX idx_user_activity (user_id, last_activity)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create password_history table for password policy enforcement
CREATE TABLE IF NOT EXISTS password_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES admin_users(id) ON DELETE CASCADE,
    INDEX idx_user_created (user_id, created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert default admin user (password: Admin@123)
INSERT IGNORE INTO admin_users (username, email, password, role) 
VALUES ('admin', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'); 