<?php
session_start();
require_once 'config/database.php';

// Get featured products from database with error handling
try {
    $featured_products = get_products(8, null, true);
    $categories = get_categories();
} catch (Exception $e) {
    // If database fails, use empty arrays to prevent errors
    $featured_products = [];
    $categories = [];
    error_log("Database error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ArtisanCraft - Handcrafted Excellence</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Crimson+Text:wght@400;600&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-logo">
                <a href="#home">
                    <img src="logog.jpeg" alt="ArtisanCraft Logo" class="logo-img">
                    <span class="logo-text">ArtisanCraft</span>
                </a>
            </div>
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="#home" class="nav-link">Home</a>
                </li>
                <li class="nav-item">
                    <a href="#about" class="nav-link">About</a>
                </li>
                <li class="nav-item">
                    <a href="#products" class="nav-link">Products</a>
                </li>
                <li class="nav-item">
                    <a href="#gallery" class="nav-link">Gallery</a>
                </li>
                <li class="nav-item">
                    <a href="#contact" class="nav-link">Contact</a>
                </li>
                <?php if (is_logged_in()): ?>
                    <li class="nav-item">
                        <a href="profile.php" class="nav-link">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a href="auth/logout.php" class="nav-link">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a href="auth/login.php" class="nav-link">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
            <div class="hamburger">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="hero-content">
            <h1 class="hero-title">Handcrafted Excellence</h1>
            <p class="hero-subtitle">Discover unique, artisanal creations crafted with passion and precision</p>
            <div class="hero-buttons">
                <a href="#products" class="btn btn-primary">Explore Collection</a>
                <a href="#about" class="btn btn-secondary">Learn More</a>
            </div>
        </div>
        <div class="hero-image">
            <div class="hero-photo">
                <img src="logo1.jpeg" alt="Artisan Crafting" class="floating-image">
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about">
        <div class="container">
            <div class="section-header">
                <h2>Our Story</h2>
                <p>Passion meets craftsmanship in every piece we create</p>
            </div>
            <div class="about-content">
                <div class="about-text">
                    <h3>Traditional Techniques, Modern Design</h3>
                    <p>At ArtisanCraft, we believe in preserving traditional craftsmanship while embracing contemporary design principles. Our artisans bring decades of experience and a deep understanding of materials to create pieces that are both beautiful and functional.</p>
                    <p>Each creation tells a story - from the careful selection of materials to the final finishing touches. We take pride in producing unique, handcrafted items that will become cherished heirlooms for generations to come.</p>
                    <div class="stats">
                        <div class="stat">
                            <h4>25+</h4>
                            <p>Years Experience</p>
                        </div>
                        <div class="stat">
                            <h4>500+</h4>
                            <p>Happy Customers</p>
                        </div>
                        <div class="stat">
                            <h4>100%</h4>
                            <p>Handcrafted</p>
                        </div>
                    </div>
                </div>
                <div class="about-image">
                    <div class="image-placeholder">
                        <i class="fas fa-tools"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section id="products" class="products">
        <div class="container">
            <div class="section-header">
                <h2>Our Collections</h2>
                <p>Explore our carefully curated selection of artisanal pieces</p>
            </div>
            <div class="product-grid">
                <?php if (!empty($featured_products)): ?>
                    <?php foreach ($featured_products as $product): ?>
                        <div class="product-card">
                            <div class="product-image">
                                <img src="uploads/products/<?php echo htmlspecialchars($product['main_image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                            </div>
                            <div class="product-info">
                                <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                                <p><?php echo htmlspecialchars($product['description']); ?></p>
                                <div class="product-price"><?php echo format_price($product['price']); ?></div>
                                <a href="product.php?id=<?php echo $product['id']; ?>" class="btn btn-outline">View Details</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no-products">
                        <p>No featured products available at the moment.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section id="gallery" class="gallery">
        <div class="container">
            <div class="section-header">
                <h2>Gallery</h2>
                <p>A glimpse into our creative process and finished pieces</p>
            </div>
            <div class="gallery-grid">
                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1586023492125-27b2c045efd7?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" alt="Artisan Workshop">
                </div>
                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" alt="Handwoven Textiles">
                </div>
                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1515562141207-7a88fb7ce338?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" alt="Jewelry Making">
                </div>
                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1578662996442-48f60103fc96?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" alt="Ceramic Art">
                </div>
                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1555041469-a586c61ea9bc?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" alt="Wooden Furniture">
                </div>
                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1586023492125-27b2c045efd7?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" alt="Craftsmanship">
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="contact">
        <div class="container">
            <div class="section-header">
                <h2>Get In Touch</h2>
                <p>Ready to start your custom project? Let's create something beautiful together</p>
            </div>
            <div class="contact-content">
                <div class="contact-info">
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div>
                            <h4>Visit Our Studio</h4>
                            <p>123 Craft Street, Artisan District<br>Creative City, CC 12345</p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <div>
                            <h4>Call Us</h4>
                            <p>+1 (555) 123-4567</p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <div>
                            <h4>Email Us</h4>
                            <p>hello@artisancraft.com</p>
                        </div>
                    </div>
                </div>
                <form class="contact-form" id="contactForm">
                    <div class="form-group">
                        <input type="text" name="name" placeholder="Your Name" required>
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" placeholder="Your Email" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="subject" placeholder="Subject">
                    </div>
                    <div class="form-group">
                        <textarea name="message" placeholder="Your Message" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Send Message</button>
                </form>
                <div id="contactMessage"></div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>ArtisanCraft</h3>
                    <p>Handcrafted excellence for discerning collectors and art lovers.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-pinterest"></i></a>
                    </div>
                </div>
                <div class="footer-section">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="#home">Home</a></li>
                        <li><a href="#about">About</a></li>
                        <li><a href="#products">Products</a></li>
                        <li><a href="#gallery">Gallery</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Collections</h4>
                    <ul>
                        <li><a href="#">Furniture</a></li>
                        <li><a href="#">Jewelry</a></li>
                        <li><a href="#">Textiles</a></li>
                        <li><a href="#">Ceramics</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Contact Info</h4>
                    <p><i class="fas fa-map-marker-alt"></i> 123 Craft Street, Creative City</p>
                    <p><i class="fas fa-phone"></i> +1 (555) 123-4567</p>
                    <p><i class="fas fa-envelope"></i> hello@artisancraft.com</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 ArtisanCraft. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Contact form submission
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const messageDiv = document.getElementById('contactMessage');
            
            fetch('contact-handler.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    messageDiv.innerHTML = '<div class="alert alert-success">' + data.message + '</div>';
                    document.getElementById('contactForm').reset();
                } else {
                    messageDiv.innerHTML = '<div class="alert alert-danger">' + data.message + '</div>';
                }
            })
            .catch(error => {
                messageDiv.innerHTML = '<div class="alert alert-danger">An error occurred. Please try again.</div>';
            });
        });

        // Mobile menu toggle
        const hamburger = document.querySelector('.hamburger');
        const navMenu = document.querySelector('.nav-menu');

        hamburger.addEventListener('click', () => {
            hamburger.classList.toggle('active');
            navMenu.classList.toggle('active');
        });

        document.querySelectorAll('.nav-link').forEach(n => n.addEventListener('click', () => {
            hamburger.classList.remove('active');
            navMenu.classList.remove('active');
        }));
    </script>
</body>
</html> 