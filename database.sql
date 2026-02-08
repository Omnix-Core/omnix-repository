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

INSERT INTO categories (name) VALUES ('TV'), ('Telefonos'), ('Monitores'), ('Ordenadores');

INSERT INTO products (name, description, price, image, category_id, stock) VALUES
('Samsung QLED 55"', 'Televisor QLED 4K UHD con Quantum HDR y Smart TV. Resolucion 3840x2160, HDR10+, 120Hz', 799.99, 'tv-samsung.jpg', 1, 10),
('LG OLED 65"', 'Televisor OLED 4K con tecnologia AI ThinQ. Negro perfecto, Dolby Vision IQ y Dolby Atmos', 1799.99, 'tv-lg.jpg', 1, 5),
('Sony Bravia XR 50"', 'Android TV 4K HDR con procesador Cognitive XR. Google TV, compatible con Apple AirPlay 2', 899.99, 'tv-sony.jpg', 1, 8),
('Xiaomi Mi TV 55"', 'Smart TV 4K Ultra HD Android TV 11. Dolby Vision, Chromecast integrado', 449.99, 'tv-xiaomi.jpg', 1, 15),
('Philips Ambilight 58"', 'TV LED 4K UHD con Ambilight 3 lados. Saphi Smart TV, HDR10+, Pixel Precise Ultra HD', 599.99, 'tv-philips.jpg', 1, 12),
('Hisense ULED 43"', 'Smart TV 4K con Quantum Dot. Dolby Vision, HDR10+, VIDAA U6, Game Mode Plus', 379.99, 'tv-hisense.jpg', 1, 20),
('TCL QLED 50"', 'Android TV 4K UHD QLED. Quantum Dot, Dolby Vision, manos libres con Google Assistant', 499.99, 'tv-tcl.jpg', 1, 18),
('Panasonic 4K 55"', 'Smart TV LED 4K HDR. My Home Screen 6.0, HDR10+, compatible con Alexa', 549.99, 'tv-panasonic.jpg', 1, 10),

('iPhone 15 Pro Max', 'Smartphone Apple con chip A17 Pro. Pantalla Super Retina XDR 6.7", camara 48MP, 5G, titanio', 1299.99, 'iphone-15.jpg', 2, 15),
('Samsung Galaxy S24 Ultra', 'Android flagship con S Pen. Pantalla Dynamic AMOLED 2X 6.8", Snapdragon 8 Gen 3, camara 200MP', 1199.99, 'samsung-s24.jpg', 2, 12),
('Google Pixel 8 Pro', 'Smartphone con IA avanzada. Pantalla LTPO OLED 6.7", Google Tensor G3, camara 50MP', 999.99, 'pixel-8.jpg', 2, 10),
('Xiaomi 14 Pro', 'Flagship con Snapdragon 8 Gen 3. Pantalla AMOLED 6.73", camara Leica 50MP, carga 120W', 899.99, 'xiaomi-14.jpg', 2, 20),
('OnePlus 12', 'Android premium con OxygenOS 14. Pantalla AMOLED 120Hz 6.82", Snapdragon 8 Gen 3, carga 100W', 799.99, 'oneplus-12.jpg', 2, 18),
('iPhone 14', 'Apple con chip A15 Bionic. Pantalla Super Retina XDR 6.1", camara dual 12MP, 5G', 799.99, 'iphone-14.jpg', 2, 25),
('Samsung Galaxy A54', 'Gama media premium. Pantalla Super AMOLED 6.4", Exynos 1380, camara 50MP, bateria 5000mAh', 399.99, 'samsung-a54.jpg', 2, 30),
('Xiaomi Redmi Note 13 Pro', 'Mejor calidad-precio. Pantalla AMOLED 120Hz, Snapdragon 7s Gen 2, camara 200MP, carga 67W', 329.99, 'redmi-note-13.jpg', 2, 35),
('Motorola Edge 40', 'Android One con Dimensity 8020. Pantalla pOLED 144Hz, camara 50MP OIS, carga 68W', 499.99, 'moto-edge.jpg', 2, 22),
('Realme GT 5', 'Gaming phone con Snapdragon 8 Gen 2. Pantalla AMOLED 144Hz, camara 50MP, carga 240W', 699.99, 'realme-gt5.jpg', 2, 15),
('Nothing Phone 2', 'Diseno unico con Glyph Interface. Snapdragon 8+ Gen 1, pantalla OLED 120Hz, camara 50MP', 649.99, 'nothing-phone.jpg', 2, 18),
('OPPO Find X6 Pro', 'Flagship con Snapdragon 8 Gen 2. Triple camara Hasselblad 50MP, pantalla AMOLED 120Hz', 949.99, 'oppo-find.jpg', 2, 12),

('ASUS ROG Swift 27"', 'Monitor gaming QHD 240Hz. Panel IPS, 1ms, G-SYNC Compatible, HDR400', 599.99, 'monitor-asus.jpg', 3, 8),
('LG UltraGear 32"', 'Gaming UHD 144Hz con Nano IPS. 1ms, HDR600, FreeSync Premium Pro, altura ajustable', 749.99, 'monitor-lg.jpg', 3, 6),
('Dell UltraSharp 27"', 'Monitor profesional 4K IPS. Color calibrado, USB-C 90W, altura/pivote, DisplayHDR 400', 649.99, 'monitor-dell.jpg', 3, 10),
('Samsung Odyssey G7 28"', 'Gaming 4K 144Hz curvo. Panel VA, FreeSync Premium Pro, HDR600', 699.99, 'monitor-samsung.jpg', 3, 7),
('BenQ SW270C 27"', 'Monitor fotografia 2K IPS. 99% Adobe RGB, calibracion hardware, USB-C', 799.99, 'monitor-benq.jpg', 3, 5),
('AOC 24G2 24"', 'Gaming economico Full HD 165Hz. IPS, 1ms, FreeSync Premium, altura ajustable', 179.99, 'monitor-aoc.jpg', 3, 20),
('MSI Optix MAG274QRF 27"', 'Gaming QHD 165Hz Rapid IPS. 1ms, G-SYNC Compatible, RGB Mystic Light', 379.99, 'monitor-msi.jpg', 3, 12),
('ViewSonic VP2468 24"', 'Monitor profesional Full HD IPS. Calibrado, Pantone, Rec. 709, altura/pivote', 299.99, 'monitor-viewsonic.jpg', 3, 15),
('Acer Predator X34 34"', 'Ultrawide gaming QHD 180Hz. Curvo IPS, 1ms, G-SYNC Ultimate, HDR400', 1099.99, 'monitor-acer.jpg', 3, 4),
('HP E24 G5 24"', 'Monitor oficina Full HD IPS. Altura ajustable, DisplayPort + VGA, antireflejos', 159.99, 'monitor-hp.jpg', 3, 25),
('Gigabyte M32U 32"', 'Gaming 4K 144Hz. Panel SS IPS, 1ms, FreeSync Premium Pro, KVM integrado', 699.99, 'monitor-gigabyte.jpg', 3, 8),
('Philips 276E8VJSB 27"', 'Monitor IPS 4K economico. Ultra Narrow Border, Flicker-free, Low Blue Mode', 249.99, 'monitor-philips.jpg', 3, 18),

('PC Gaming Ryzen 7 7800X3D', 'Ryzen 7 7800X3D, RTX 4070 12GB, 32GB DDR5 6000MHz, SSD 1TB NVMe Gen4, torre RGB', 1899.99, 'pc-ryzen7.jpg', 4, 5),
('PC Gaming Intel i7-14700K', 'i7-14700K, RTX 4080 16GB, 32GB DDR5, SSD 2TB Gen4, refrigeracion liquida AIO 360mm', 2799.99, 'pc-i7.jpg', 4, 3),
('PC Gaming Ryzen 5 7600X', 'Ryzen 5 7600X, RTX 4060 Ti 8GB, 16GB DDR5, SSD 1TB NVMe, torre ATX con ventiladores RGB', 1299.99, 'pc-ryzen5.jpg', 4, 8),
('PC Workstation Ryzen 9', 'Ryzen 9 7950X, RTX 4000 Ada 20GB, 64GB DDR5, SSD 2TB + 4TB HDD, torre profesional', 3499.99, 'workstation.jpg', 4, 2),
('PC Oficina Intel i5', 'i5-13400, 16GB DDR4, SSD 512GB, iGPU UHD 730, torre micro ATX silenciosa', 699.99, 'pc-oficina.jpg', 4, 15),
('Mini PC Intel i7', 'i7-13700H, Iris Xe, 32GB DDR4, SSD 1TB, WiFi 6E, Bluetooth 5.2, 4x USB-C', 899.99, 'mini-pc.jpg', 4, 10),
('PC Gaming AMD RX 7600', 'Ryzen 5 5600, RX 7600 8GB, 16GB DDR4, SSD 500GB, perfecto para 1080p gaming', 899.99, 'pc-amd.jpg', 4, 12),
('PC Creador Intel i9', 'i9-14900K, RTX 4070 Ti, 64GB DDR5, SSD 2TB Gen4, capturadora 4K incluida', 3199.99, 'pc-creator.jpg', 4, 4),
('PC Gaming Blanco RGB', 'Ryzen 7 7700X, RTX 4070, 32GB DDR5, SSD 1TB, torre blanca NZXT con panel cristal', 1999.99, 'pc-blanco.jpg', 4, 6),
('PC Todo en Uno 27"', 'i7-1355U, 16GB DDR4, SSD 512GB, pantalla QHD IPS tactil, webcam 1080p, altavoces integrados', 1199.99, 'pc-aio.jpg', 4, 8),
('PC Compacto SFF', 'i5-12400, 16GB DDR4, SSD 256GB, iGPU UHD 730, formato ultra compacto 5L', 549.99, 'pc-sff.jpg', 4, 14),
('Server Rack 1U', 'Xeon E-2314, 32GB ECC, SSD 2TB NVMe, doble fuente redundante, IPMI', 1899.99, 'server.jpg', 4, 3);