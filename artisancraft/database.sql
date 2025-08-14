-- ArtisanCraft Database Structure
-- Created for the artisan craft website

-- Create database
CREATE DATABASE IF NOT EXISTS artisancraft_db;
USE artisancraft_db;

-- Users table (for customers, artisans, and admins)
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    user_type ENUM('customer', 'artisan', 'admin') DEFAULT 'customer',
    phone VARCHAR(20),
    address TEXT,
    city VARCHAR(50),
    state VARCHAR(50),
    zip_code VARCHAR(20),
    country VARCHAR(50) DEFAULT 'USA',
    profile_image VARCHAR(255),
    bio TEXT,
    is_active BOOLEAN DEFAULT TRUE,
    email_verified BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Categories table
CREATE TABLE categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    image VARCHAR(255),
    slug VARCHAR(100) UNIQUE NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Products table
CREATE TABLE products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    artisan_id INT,
    category_id INT,
    name VARCHAR(200) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    sale_price DECIMAL(10,2),
    stock_quantity INT DEFAULT 0,
    images JSON,
    main_image VARCHAR(255),
    dimensions VARCHAR(100),
    weight DECIMAL(8,2),
    materials TEXT,
    is_featured BOOLEAN DEFAULT FALSE,
    is_active BOOLEAN DEFAULT TRUE,
    views_count INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (artisan_id) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

-- Orders table
CREATE TABLE orders (
    id INT PRIMARY KEY AUTO_INCREMENT,
    customer_id INT,
    order_number VARCHAR(50) UNIQUE NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    shipping_address TEXT NOT NULL,
    billing_address TEXT NOT NULL,
    status ENUM('pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
    payment_status ENUM('pending', 'paid', 'failed', 'refunded') DEFAULT 'pending',
    payment_method VARCHAR(50),
    shipping_method VARCHAR(50),
    tracking_number VARCHAR(100),
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Order items table
CREATE TABLE order_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT,
    product_id INT,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE SET NULL
);

-- Reviews table
CREATE TABLE reviews (
    id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT,
    customer_id INT,
    rating INT NOT NULL CHECK (rating >= 1 AND rating <= 5),
    title VARCHAR(200),
    comment TEXT,
    is_approved BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (customer_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Wishlist table
CREATE TABLE wishlist (
    id INT PRIMARY KEY AUTO_INCREMENT,
    customer_id INT,
    product_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    UNIQUE KEY unique_wishlist (customer_id, product_id)
);

-- Contact messages table
CREATE TABLE contact_messages (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(200),
    message TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default categories
INSERT INTO categories (name, description, slug) VALUES
('Furniture', 'Handcrafted wooden furniture with timeless designs', 'furniture'),
('Jewelry', 'Unique jewelry pieces crafted with precious materials', 'jewelry'),
('Textiles', 'Handwoven fabrics and artisanal textiles', 'textiles'),
('Ceramics', 'Beautiful pottery and ceramic creations', 'ceramics'),
('Leather Goods', 'Premium leather bags, wallets, and accessories', 'leather-goods'),
('Metalwork', 'Hand-forged metal sculptures and decorative pieces', 'metalwork'),
('Glass Art', 'Hand-blown glass vases and decorative objects', 'glass-art'),
('Wood Carving', 'Intricate wooden sculptures and decorative carvings', 'wood-carving');

-- Insert default admin user (password: admin123)
INSERT INTO users (username, email, password, first_name, last_name, user_type, is_active, email_verified) VALUES
('admin', 'admin@artisancraft.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin', 'User', 'admin', TRUE, TRUE);

-- Insert sample products
INSERT INTO products (artisan_id, category_id, name, description, price, stock_quantity, main_image, is_featured) VALUES
(1, 1, 'Handcrafted Oak Dining Table', 'Beautiful handcrafted oak dining table with traditional joinery techniques', 899.99, 5, 'furniture1.jpg', TRUE),
(1, 2, 'Sterling Silver Necklace', 'Elegant sterling silver necklace with hand-carved pendant', 299.99, 10, 'jewelry1.jpg', TRUE),
(1, 3, 'Handwoven Cotton Throw', 'Soft handwoven cotton throw blanket in natural colors', 89.99, 15, 'textiles1.jpg', FALSE),
(1, 4, 'Ceramic Vase Set', 'Set of 3 hand-thrown ceramic vases in earth tones', 149.99, 8, 'ceramics1.jpg', TRUE),
(1, 5, 'Leather Messenger Bag', 'Premium full-grain leather messenger bag with brass hardware', 399.99, 3, 'leather1.jpg', TRUE),
(1, 6, 'Copper Wall Art', 'Hand-forged copper wall art with geometric patterns', 199.99, 7, 'metalwork1.jpg', FALSE),
(1, 7, 'Hand-blown Glass Vase', 'Unique hand-blown glass vase in blue and green tones', 179.99, 6, 'glass1.jpg', TRUE),
(1, 8, 'Wooden Sculpture', 'Intricately carved wooden sculpture of a forest scene', 599.99, 2, 'woodcarving1.jpg', TRUE); 