# ArtisanCraft - Handcrafted Excellence

A beautiful e-commerce website for artisan crafts, built with PHP, MySQL, and modern web technologies.

## 🌟 Features

- **User Authentication System** - Customer, Artisan, and Admin roles
- **Product Management** - Add, edit, and manage artisan products
- **Category System** - Organize products by craft type
- **Responsive Design** - Beautiful design that works on all devices
- **Contact Form** - Integrated contact system with database storage
- **Modern UI/UX** - Artisan-themed design with smooth animations
- **Database Integration** - Full MySQL database with proper relationships

## 🛠️ Technology Stack

- **Backend**: PHP 7.4+
- **Database**: MySQL 5.7+ / MariaDB 10.3+
- **Frontend**: HTML5, CSS3, JavaScript (ES6+)
- **Styling**: Custom CSS with modern design principles
- **Fonts**: Google Fonts (Cormorant Garamond, Crimson Text)
- **Icons**: Font Awesome 6.0

## 📋 Prerequisites

Before you begin, ensure you have the following installed:
- PHP 7.4 or higher
- MySQL 5.7 or higher (or MariaDB 10.3+)
- Web server (Apache/Nginx)
- Composer (optional, for dependency management)

## 🚀 Installation

### 1. Clone or Download the Project
```bash
git clone <repository-url>
cd artisancraft
```

### 2. Database Setup
1. Create a new MySQL database:
```sql
CREATE DATABASE artisancraft_db;
```

2. Import the database structure:
```bash
mysql -u your_username -p artisancraft_db < database.sql
```

### 3. Configure Database Connection
1. Open `config/database.php`
2. Update the database credentials:
```php
private $host = 'localhost';
private $db_name = 'artisancraft_db';
private $username = 'your_username';
private $password = 'your_password';
```

### 4. Web Server Configuration
- Place the project in your web server's document root
- Ensure PHP has write permissions for uploads (if needed)
- Configure your web server to serve PHP files

### 5. Test the Setup
Visit `http://your-domain/setup.php` to test your database connection and configuration.

## 👤 Default Admin Account

After setup, you can login with the default admin account:
- **Email**: admin@artisancraft.com
- **Password**: admin123
- **User Type**: admin

**Important**: Change the default password after first login!

## 📁 Project Structure

```
artisancraft/
├── config/
│   └── database.php          # Database configuration
├── auth/
│   ├── login.php            # Login page
│   └── logout.php           # Logout handler
├── uploads/
│   └── products/            # Product images (create this folder)
├── index.php                # Main homepage
├── signup.php               # User registration
├── contact-handler.php      # Contact form processor
├── setup.php                # Setup and testing script
├── database.sql             # Database structure
├── styles.css               # Main stylesheet
├── README.md                # This file
└── [other assets]
```

## 🎨 Customization

### Colors and Styling
The main color scheme is defined in `styles.css`:
- Primary Brown: `#8B4513`
- Secondary Brown: `#A0522D`
- Background: Cream gradients
- Text: Dark browns for readability

### Adding New Features
1. **New Product Categories**: Add to the `categories` table
2. **User Roles**: Extend the `user_type` enum in the `users` table
3. **Custom Fields**: Add columns to relevant tables as needed

## 🔧 Database Schema

### Main Tables
- **users** - User accounts (customers, artisans, admins)
- **categories** - Product categories
- **products** - Artisan products
- **orders** - Customer orders
- **order_items** - Individual items in orders
- **reviews** - Product reviews
- **wishlist** - Customer wishlists
- **contact_messages** - Contact form submissions

### Key Relationships
- Products belong to categories and artisans
- Orders belong to customers
- Reviews belong to products and customers
- Wishlist items link customers to products

## 🚀 Deployment

### Production Checklist
- [ ] Update database credentials for production
- [ ] Set up proper file permissions
- [ ] Configure web server security
- [ ] Enable HTTPS
- [ ] Set up backup procedures
- [ ] Configure error logging
- [ ] Test all functionality

### Security Considerations
- All user inputs are sanitized
- Passwords are hashed using PHP's `password_hash()`
- SQL injection protection with prepared statements
- XSS protection with `htmlspecialchars()`

## 🐛 Troubleshooting

### Common Issues

1. **Database Connection Failed**
   - Check database credentials in `config/database.php`
   - Ensure MySQL service is running
   - Verify database exists

2. **Page Not Loading**
   - Check PHP is installed and configured
   - Verify web server configuration
   - Check file permissions

3. **Images Not Displaying**
   - Ensure `uploads/products/` directory exists
   - Check file permissions
   - Verify image paths in database

### Getting Help
1. Check the setup script at `setup.php`
2. Review error logs
3. Test database connection manually
4. Verify all required files are present

## 📝 License

This project is open source and available under the [MIT License](LICENSE).

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## 📞 Support

For support, please:
1. Check the troubleshooting section
2. Review the setup script output
3. Create an issue with detailed information

---

**ArtisanCraft** - Where tradition meets modern craftsmanship. 