-- Vytvoření nové databáze a výběr pro použití
DROP DATABASE IF EXISTS sphere_base;
CREATE DATABASE IF NOT EXISTS sphere_base;
USE sphere_base;

-- Products Table
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    description TEXT,
    price DECIMAL(10,2),
    image_url VARCHAR(255)
);

DROP TABLE IF EXISTS payments;
CREATE TABLE payments (
  idpayments INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY UNIQUE,
  name VARCHAR(255) NOT NULL
);

INSERT INTO payments (name) VALUES
('Card payment online');


DROP TABLE IF EXISTS shipping;
CREATE TABLE shipping (
  idshipping INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY UNIQUE,
  name VARCHAR(255) NOT NULL
);

INSERT INTO shipping (name) VALUES
('Packeta'),
('PPL');

-- Orders Table
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    surname VARCHAR(255),
    city VARCHAR(255),
    street VARCHAR(255),
    cardd VARCHAR(255),
    cvv int(3),
    expiry VARCHAR(255),
    shipping_idshipping int,
    payments_idpayments int,
    order_date DATETIME,
    total_price DECIMAL(10,2),
    FOREIGN KEY (shipping_idshipping) REFERENCES shipping(idshipping),
    FOREIGN KEY (payments_idpayments) REFERENCES payments(idpayments)
);

-- Order Items Table
CREATE TABLE order_items (
    order_id INT,
    product_id INT,
    quantity INT,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);


-- Sample product data
INSERT INTO products (name, description, price, image_url) VALUES
('Product 1', 'Description of product 1.', 19.99, 'uploads/image1.webp'),
('Product 2', 'Description of product 2.', 29.99, 'uploads/image2.webp'),
('Product 3', 'Description of product 3.', 39.99, 'uploads/image2.webp'),
('Product 4', 'Description of product 4.', 49.99, 'uploads/image2.webp'),
('Product 5', 'Description of product 5.', 59.99, 'uploads/image2.webp'),
('Product 6', 'Description of product 6.', 69.99, 'uploads/image2.webp');

