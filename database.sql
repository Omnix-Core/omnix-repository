
CREATE DATABASE IF NOT EXISTS tienda_tecnologica
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;

USE tienda_tecnologica;


-- TABLA ADMINISTRADORES
CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'editor') DEFAULT 'editor',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- TABLA USUARIOS WEB
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- TABLA CATEGORÍAS
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE
);

-- TABLA PRODUCTOS
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255),
    category_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_category
        FOREIGN KEY (category_id)
        REFERENCES categories(id)
        ON DELETE CASCADE
);




-- INSERTS DE PRUEBA

-- Categorías
INSERT INTO categories (name) VALUES
('TV'),
('Telefonos'),
('Monitores'),
('Ordenadores Premontados');

-- Admins
INSERT INTO admins (username, password, role) VALUES
('root', 'daw', 'admin'),
('editor1', 'editor1_daw', 'editor'),
('editor2', 'editor1_daw', 'editor');

-- Productos de ejemplo
INSERT INTO products (name, description, price, image, category_id) VALUES
('Smart TV 55"', 'Televisor 4K UHD', 599.99, 'tv55.jpg', 1),
('iPhone 14', 'Smartphone Apple', 999.99, 'iphone14.jpg', 2),
('Monitor Gaming 27"', '144Hz Full HD', 299.99, 'monitor27.jpg', 3),
('PC Gaming', 'Ryzen 7, 16GB RAM, RTX 4060', 1299.99, 'pcgaming.jpg', 4);


INSERT INTO products (name, description, price, image, category_id) VALUES
('Smart TV LG 65"', 'Televisor OLED 4K HDR', 1499.99, 'tv_lg_65.jpg', 1),
('Smart TV Sony 50"', 'Android TV Full HD', 529.99, 'tv_sony_50.jpg', 1),
('Smart TV Xiaomi 55"', '4K Ultra HD Android TV', 499.99, 'tv_xiaomi_55.jpg', 1),
('Smart TV Philips 43"', 'Ambilight Full HD', 399.99, 'tv_philips_43.jpg', 1);


INSERT INTO products (name, description, price, image, category_id) VALUES
('iPhone 13', '128GB, iOS', 799.99, 'iphone_13.jpg', 2),
('Samsung Galaxy S23', 'Android, 256GB', 899.99, 'galaxy_s23.jpg', 2),
('Samsung Galaxy A54', 'Android, gama media', 379.99, 'galaxy_a54.jpg', 2),
('Xiaomi Redmi Note 12', 'Android, 128GB', 249.99, 'redmi_note_12.jpg', 2),
('Google Pixel 7', 'Android puro, 128GB', 649.99, 'pixel_7.jpg', 2),
('OnePlus Nord 3', '5G, 256GB', 499.99, 'oneplus_nord3.jpg', 2);


INSERT INTO products (name, description, price, image, category_id) VALUES
('Monitor Gaming ASUS 27"', '144Hz, Full HD', 299.99, 'monitor_asus_27.jpg', 3),
('Monitor LG UltraWide 34"', 'QHD, IPS', 449.99, 'monitor_lg_34.jpg', 3),
('Monitor Samsung 24"', 'Full HD, 75Hz', 159.99, 'monitor_samsung_24.jpg', 3),
('Monitor BenQ 27"', '2K, diseño gráfico', 379.99, 'monitor_benq_27.jpg', 3),
('Monitor Dell 24"', 'IPS, Full HD', 199.99, 'monitor_dell_24.jpg', 3),
('Monitor MSI Gaming 32"', '165Hz, QHD', 499.99, 'monitor_msi_32.jpg', 3);


INSERT INTO products (name, description, price, image, category_id) VALUES
('PC Gaming Ryzen 5', 'Ryzen 5, 16GB RAM, RTX 3060', 1199.99, 'pc_ryzen5.jpg', 4),
('PC Gaming Ryzen 7', 'Ryzen 7, 32GB RAM, RTX 4070', 1799.99, 'pc_ryzen7.jpg', 4),
('PC Oficina Intel i5', 'Intel i5, 16GB RAM, SSD', 699.99, 'pc_i5_oficina.jpg', 4),
('PC Gaming Intel i7', 'Intel i7, 32GB RAM, RTX 4080', 2499.99, 'pc_i7_gaming.jpg', 4),
('PC Compacto', 'Mini PC, 8GB RAM, SSD', 449.99, 'mini_pc.jpg', 4),
('PC Workstation', 'Xeon, 64GB RAM, GPU profesional', 2999.99, 'workstation.jpg', 4);



--------------------------------------------------------------------------------------------------------------------------
CREATE TABLE cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    CONSTRAINT fk_cart_user
        FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE,
    
    CONSTRAINT fk_cart_product
        FOREIGN KEY (product_id)
        REFERENCES products(id)
        ON DELETE CASCADE,
    
    UNIQUE KEY unique_user_product (user_id, product_id)
);

-- TABLA PEDIDOS
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
    shipping_address TEXT NOT NULL,
    payment_method VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    CONSTRAINT fk_order_user
        FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE
);

-- TABLA DETALLES DE PEDIDOS
CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    
    CONSTRAINT fk_order_item_order
        FOREIGN KEY (order_id)
        REFERENCES orders(id)
        ON DELETE CASCADE,
    
    CONSTRAINT fk_order_item_product
        FOREIGN KEY (product_id)
        REFERENCES products(id)
        ON DELETE CASCADE
);

-- TABLA WISHLIST (LISTA DE DESEOS)
CREATE TABLE wishlist (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    CONSTRAINT fk_wishlist_user
        FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE,
    
    CONSTRAINT fk_wishlist_product
        FOREIGN KEY (product_id)
        REFERENCES products(id)
        ON DELETE CASCADE,
    
    UNIQUE KEY unique_wishlist_item (user_id, product_id)
);