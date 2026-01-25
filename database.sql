
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
