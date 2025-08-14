<?php
/**
 * ArtisanCraft Setup Script
 * This script helps you configure and test your database connection
 */

// Check if database configuration exists
if (file_exists('config/database.php')) {
    require_once 'config/database.php';
    $database = new Database();
    
    echo "<h2>ArtisanCraft Database Setup</h2>";
    
    // Test database connection
    if ($database->testConnection()) {
        echo "<div style='color: green; padding: 10px; background: #d4edda; border-radius: 5px; margin: 10px 0;'>";
        echo "✅ Database connection successful!";
        echo "</div>";
        
        // Check if tables exist
        try {
            $conn = $database->getConnection();
            $stmt = $conn->query("SHOW TABLES");
            $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
            
            if (count($tables) > 0) {
                echo "<div style='color: green; padding: 10px; background: #d4edda; border-radius: 5px; margin: 10px 0;'>";
                echo "✅ Database tables found: " . implode(', ', $tables);
                echo "</div>";
            } else {
                echo "<div style='color: orange; padding: 10px; background: #fff3cd; border-radius: 5px; margin: 10px 0;'>";
                echo "⚠️ No tables found. Please import the database.sql file.";
                echo "</div>";
            }
        } catch (Exception $e) {
            echo "<div style='color: red; padding: 10px; background: #f8d7da; border-radius: 5px; margin: 10px 0;'>";
            echo "❌ Error checking tables: " . $e->getMessage();
            echo "</div>";
        }
        
    } else {
        echo "<div style='color: red; padding: 10px; background: #f8d7da; border-radius: 5px; margin: 10px 0;'>";
        echo "❌ Database connection failed!";
        echo "</div>";
        
        echo "<h3>Configuration Instructions:</h3>";
        echo "<ol>";
        echo "<li>Make sure MySQL/MariaDB is running</li>";
        echo "<li>Create a database named 'artisancraft_db'</li>";
        echo "<li>Update the database credentials in config/database.php</li>";
        echo "<li>Import the database.sql file into your database</li>";
        echo "</ol>";
    }
    
} else {
    echo "<h2>ArtisanCraft Setup</h2>";
    echo "<div style='color: red; padding: 10px; background: #f8d7da; border-radius: 5px; margin: 10px 0;'>";
    echo "❌ Database configuration file not found!";
    echo "</div>";
    
    echo "<h3>Setup Instructions:</h3>";
    echo "<ol>";
    echo "<li>Create a 'config' folder in your project root</li>";
    echo "<li>Create 'database.php' file in the config folder</li>";
    echo "<li>Configure your database connection settings</li>";
    echo "<li>Create the database and import database.sql</li>";
    echo "</ol>";
}

echo "<h3>Next Steps:</h3>";
echo "<ul>";
echo "<li><a href='index.php'>Go to Homepage</a></li>";
echo "<li><a href='signup.php'>Create Account</a></li>";
echo "<li><a href='auth/login.php'>Login</a></li>";
echo "</ul>";

echo "<h3>Default Admin Account:</h3>";
echo "<p><strong>Email:</strong> admin@artisancraft.com</p>";
echo "<p><strong>Password:</strong> admin123</p>";
echo "<p><strong>User Type:</strong> admin</p>";
?>

<style>
body {
    font-family: Arial, sans-serif;
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    background: #f5f5f5;
}

h2, h3 {
    color: #8B4513;
}

div {
    margin: 10px 0;
}

a {
    color: #8B4513;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}
</style> 