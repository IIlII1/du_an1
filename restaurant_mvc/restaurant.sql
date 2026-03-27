
DROP DATABASE IF EXISTS restaurant;
CREATE DATABASE restaurant;
USE restaurant;

-- Bảng users
CREATE TABLE users(
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) DEFAULT 'customer' CHECK (role IN ('customer', 'admin')),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Bảng categories
CREATE TABLE categories(
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Bảng foods
CREATE TABLE foods(
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255),
    category_id INT,
    status VARCHAR(20) DEFAULT 'active' CHECK (status IN ('active', 'inactive')),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

-- Bảng tables
CREATE TABLE tables(
    id INT AUTO_INCREMENT PRIMARY KEY,
    table_number VARCHAR(10) NOT NULL UNIQUE,
    capacity INT NOT NULL DEFAULT 2 CHECK (capacity > 0),
    status VARCHAR(20) DEFAULT 'available' CHECK (status IN ('available', 'occupied')),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Bảng reservations
CREATE TABLE reservations(
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    table_id INT,
    customer_name VARCHAR(100) NOT NULL,
    customer_phone VARCHAR(20) NOT NULL,
    reservation_time DATETIME NOT NULL,
    guest_count INT NOT NULL CHECK (guest_count > 0),
    status VARCHAR(20) DEFAULT 'pending' CHECK (status IN ('pending', 'confirmed', 'completed', 'cancelled')),
    special_requests TEXT,
    cancellation_reason VARCHAR(255),
    cancelled_at DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (table_id) REFERENCES tables(id) ON DELETE SET NULL,
    INDEX idx_reservation_time (reservation_time),
    INDEX idx_reservation_status (status),
    INDEX idx_reservation_table (table_id)
);

-- Bảng reservation_tables (junction table - một đặt bàn có thể gắn nhiều bàn)
CREATE TABLE reservation_tables(
    id INT AUTO_INCREMENT PRIMARY KEY,
    reservation_id INT NOT NULL,
    table_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (reservation_id) REFERENCES reservations(id) ON DELETE CASCADE,
    FOREIGN KEY (table_id) REFERENCES tables(id) ON DELETE CASCADE,
    UNIQUE KEY unique_reservation_table (reservation_id, table_id)
);

-- Bảng orders
CREATE TABLE orders(
    id INT AUTO_INCREMENT PRIMARY KEY,
    reservation_id INT,
    user_id INT,
    total_price DECIMAL(10,2),
    status VARCHAR(20) DEFAULT 'pending' CHECK (status IN ('pending', 'completed', 'cancelled')),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (reservation_id) REFERENCES reservations(id) ON DELETE SET NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_order_reservation (reservation_id),
    INDEX idx_order_user (user_id),
    INDEX idx_order_status (status)
);

-- Bảng order_details
CREATE TABLE order_details(
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    food_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1 CHECK (quantity > 0),
    price DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (food_id) REFERENCES foods(id) ON DELETE RESTRICT,
    INDEX idx_orderdetail_order (order_id)
);

-- Bảng payments
CREATE TABLE payments(
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    payment_method VARCHAR(50),
    payment_status VARCHAR(20) DEFAULT 'pending' CHECK (payment_status IN ('pending', 'completed', 'failed', 'refunded')),
    refund_amount DECIMAL(10,2) DEFAULT 0,
    refund_status VARCHAR(20) NULL CHECK (refund_status IN ('pending', 'completed', 'failed')),
    paid_at DATETIME,
    refunded_at DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    INDEX idx_payment_order (order_id),
    INDEX idx_payment_status (payment_status)
);

-- Bảng audit_logs - Tracking user actions for security
CREATE TABLE audit_logs(
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    entity_type VARCHAR(50) NOT NULL,
    entity_id INT,
    action VARCHAR(50) NOT NULL CHECK (action IN ('create', 'update', 'delete', 'view')),
    old_values JSON,
    new_values JSON,
    ip_address VARCHAR(45),
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_audit_user (user_id),
    INDEX idx_audit_entity (entity_type, entity_id),
    INDEX idx_audit_date (created_at)
);

-- Bảng csrf_tokens - CSRF protection
CREATE TABLE csrf_tokens(
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    token VARCHAR(255) NOT NULL UNIQUE,
    expires_at DATETIME NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_csrf_expires (expires_at)
);

-- Bảng rate_limits - Rate limiting for API/form submission
CREATE TABLE rate_limits(
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    action VARCHAR(100) NOT NULL,
    attempt_count INT DEFAULT 1,
    last_attempt_at DATETIME NOT NULL,
    locked_until DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_action (user_id, action),
    INDEX idx_rate_locked (locked_until)
);

-- Bảng notifications - Email/SMS notification tracking
CREATE TABLE notifications(
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    reservation_id INT,
    type VARCHAR(50) NOT NULL CHECK (type IN ('reservation_confirmed', 'reservation_cancelled', 'reservation_reminder', 'order_ready', 'payment_received')),
    channel VARCHAR(20) NOT NULL CHECK (channel IN ('email', 'sms', 'in_app')),
    subject VARCHAR(255),
    message TEXT NOT NULL,
    is_sent BOOLEAN DEFAULT FALSE,
    sent_at DATETIME,
    error_message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (reservation_id) REFERENCES reservations(id) ON DELETE SET NULL,
    INDEX idx_notification_user (user_id),
    INDEX idx_notification_sent (is_sent),
    INDEX idx_notification_type (type)
);

-- Bảng user_profiles - Customer preferences and additional info
CREATE TABLE user_profiles(
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL UNIQUE,
    phone_verified BOOLEAN DEFAULT FALSE,
    dietary_restrictions VARCHAR(255),
    preferred_reservation_time VARCHAR(50),
    preferred_table_location VARCHAR(100),
    special_occasions JSON,
    loyalty_points INT DEFAULT 0,
    total_reservations INT DEFAULT 0,
    total_spent DECIMAL(10,2) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Bảng settings - Restaurant configuration
CREATE TABLE settings(
    id INT AUTO_INCREMENT PRIMARY KEY,
    key_name VARCHAR(100) NOT NULL UNIQUE,
    value TEXT NOT NULL,
    data_type VARCHAR(20) DEFAULT 'string',
    description VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_settings_key (key_name)
);

-- Thêm index để tối ưu truy vấn
CREATE INDEX idx_reservations_user ON reservations(user_id);
CREATE INDEX idx_reservations_phone ON reservations(customer_phone);
CREATE INDEX idx_reservations_time ON reservations(reservation_time);
CREATE INDEX idx_orders_reservation ON orders(reservation_id);
CREATE INDEX idx_orders_user ON orders(user_id);
CREATE INDEX idx_order_details_order ON order_details(order_id);
CREATE INDEX idx_foods_category ON foods(category_id);
CREATE INDEX idx_foods_status ON foods(status);
CREATE INDEX idx_tables_status ON tables(status);
