<?php
/**
 * Simple Database Test Script
 * This will help identify any database connection issues
 */

echo "<h2>Database Connection Test</h2>";

// Test 1: Check if config file exists
if (file_exists('config/database.php')) {
    echo "✅ Config file found<br>";
} else {
    echo "❌ Config file not found<br>";
    exit;
}

// Test 2: Try to include the config
try {
    require_once 'config/database.php';
    echo "✅ Config file loaded successfully<br>";
} catch (Exception $e) {
    echo "❌ Error loading config: " . $e->getMessage() . "<br>";
    exit;
}

// Test 3: Test database connection
try {
    $database = new Database();
    echo "✅ Database class created<br>";
    
    $conn = $database->getConnection();
    if ($conn) {
        echo "✅ Database connection successful<br>";
    } else {
        echo "❌ Database connection failed<br>";
        exit;
    }
} catch (Exception $e) {
    echo "❌ Database connection error: " . $e->getMessage() . "<br>";
    exit;
}

// Test 4: Test basic query
try {
    $stmt = $conn->query("SELECT COUNT(*) as count FROM products");
    $result = $stmt->fetch();
    echo "✅ Products table accessible. Found " . $result['count'] . " products<br>";
} catch (Exception $e) {
    echo "❌ Query error: " . $e->getMessage() . "<br>";
}

// Test 5: Test get_products function
try {
    $products = get_products(5, null, true);
    echo "✅ get_products function works. Found " . count($products) . " featured products<br>";
} catch (Exception $e) {
    echo "❌ get_products error: " . $e->getMessage() . "<br>";
}

// Test 6: Test get_categories function
try {
    $categories = get_categories();
    echo "✅ get_categories function works. Found " . count($categories) . " categories<br>";
} catch (Exception $e) {
    echo "❌ get_categories error: " . $e->getMessage() . "<br>";
}

echo "<br><strong>All tests completed!</strong><br>";
echo "<a href='index.php'>Go to Homepage</a>";
?>

<style>
body {
    font-family: Arial, sans-serif;
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
    background: #f5f5f5;
}

h2 {
    color: #8B4513;
}

a {
    color: #8B4513;
    text-decoration: none;
    font-weight: bold;
}

a:hover {
    text-decoration: underline;
}
</style>
