CREATE DATABASE IF NOT EXISTS omnix CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE omnix;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255) DEFAULT 'default.jpg',
    category_id INT NOT NULL,
    stock INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

CREATE TABLE cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    UNIQUE KEY (user_id, product_id)
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
    shipping_address TEXT NOT NULL,
    payment_method VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

INSERT INTO users (username, email, password, role) VALUES
('admin', 'admin@omnix.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('usuario1', 'usuario1@test.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
('usuario2', 'usuario2@test.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user');

INSERT INTO categories (name) VALUES ('TV'), ('Teléfonos'), ('Monitores'), ('Ordenadores');

INSERT INTO products (name, description, price, image, category_id, stock) VALUES
('Samsung QLED 55"', 'TV QLED 4K con Smart TV y HDR', 799.99, 'tv-samsung.jpg', 1, 10),
('LG OLED 65"', 'TV OLED 4K con Dolby Vision', 1799.99, 'tv-lg.jpg', 1, 5),
('Sony Bravia 50"', 'Android TV 4K HDR', 899.99, 'tv-sony.jpg', 1, 8),
('iPhone 15 Pro', 'Smartphone Apple A17 Pro 256GB', 1299.99, 'iphone-15.jpg', 2, 15),
('Samsung S24 Ultra', 'Android Snapdragon 8 Gen 3 512GB', 1199.99, 'samsung-s24.jpg', 2, 12),
('Xiaomi 14', 'Smartphone Snapdragon 8 Gen 3 256GB', 799.99, 'xiaomi-14.jpg', 2, 20),
('ASUS ROG 27"', 'Monitor gaming 240Hz QHD', 599.99, 'monitor-asus.jpg', 3, 7),
('LG UltraWide 34"', 'Monitor ultrawide QHD IPS', 749.99, 'monitor-lg.jpg', 3, 6),
('Dell 27" 4K', 'Monitor profesional 4K IPS', 649.99, 'monitor-dell.jpg', 3, 10),
('PC Gaming Ryzen 7', 'Ryzen 7 7800X3D + RTX 4070 32GB', 1899.99, 'pc-gaming.jpg', 4, 3),
('PC Oficina i5', 'Intel i5-13400 16GB SSD 512GB', 699.99, 'pc-oficina.jpg', 4, 8),
('Mini PC', 'Intel i7 32GB SSD 1TB WiFi 6E', 899.99, 'mini-pc.jpg', 4, 5);