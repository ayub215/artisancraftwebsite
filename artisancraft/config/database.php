<?php
/**
 * Database Configuration and Connection
 * ArtisanCraft Website
 */

class Database {
    private $host = 'localhost';
    private $db_name = 'artisancraft_db';
    private $username = 'root';
    private $password = '';
    private $conn;

    // Get database connection
    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch(PDOException $exception) {
            error_log("Database connection error: " . $exception->getMessage());
            return null;
        }

        return $this->conn;
    }

    // Test database connection
    public function testConnection() {
        try {
            $conn = $this->getConnection();
            if ($conn) {
                return true;
            }
        } catch (Exception $e) {
            return false;
        }
        return false;
    }
}

// Database helper functions
function db_connect() {
    try {
        $database = new Database();
        return $database->getConnection();
    } catch (Exception $e) {
        error_log("db_connect error: " . $e->getMessage());
        return null;
    }
}

function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function generate_order_number() {
    return 'AC-' . date('Ymd') . '-' . strtoupper(uniqid());
}

function format_price($price) {
    return '$' . number_format($price, 2);
}

function get_user_by_id($user_id) {
    $conn = db_connect();
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    return $stmt->fetch();
}

function get_user_by_email($email) {
    $conn = db_connect();
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    return $stmt->fetch();
}

function get_products($limit = null, $category_id = null, $featured = false) {
    try {
        $conn = db_connect();
        
        if (!$conn) {
            return [];
        }
        
        $sql = "SELECT p.*, c.name as category_name, u.first_name, u.last_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                LEFT JOIN users u ON p.artisan_id = u.id 
                WHERE p.is_active = 1";
        
        $params = [];
        
        if ($category_id) {
            $sql .= " AND p.category_id = ?";
            $params[] = $category_id;
        }
        
        if ($featured) {
            $sql .= " AND p.is_featured = 1";
        }
        
        $sql .= " ORDER BY p.created_at DESC";
        
        if ($limit && is_numeric($limit)) {
            $sql .= " LIMIT " . (int)$limit;
        }
        
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->execute($params);
            return $stmt->fetchAll();
        }
        
        return [];
    } catch (Exception $e) {
        error_log("get_products error: " . $e->getMessage());
        return [];
    }
}

function get_categories() {
    try {
        $conn = db_connect();
        
        if (!$conn) {
            return [];
        }
        
        $stmt = $conn->prepare("SELECT * FROM categories WHERE is_active = 1 ORDER BY name");
        if ($stmt) {
            $stmt->execute();
            return $stmt->fetchAll();
        }
        
        return [];
    } catch (Exception $e) {
        error_log("get_categories error: " . $e->getMessage());
        return [];
    }
}

function get_product_by_id($product_id) {
    $conn = db_connect();
    $stmt = $conn->prepare("
        SELECT p.*, c.name as category_name, u.first_name, u.last_name 
        FROM products p 
        LEFT JOIN categories c ON p.category_id = c.id 
        LEFT JOIN users u ON p.artisan_id = u.id 
        WHERE p.id = ? AND p.is_active = 1
    ");
    $stmt->execute([$product_id]);
    return $stmt->fetch();
}

function update_product_views($product_id) {
    $conn = db_connect();
    $stmt = $conn->prepare("UPDATE products SET views_count = views_count + 1 WHERE id = ?");
    $stmt->execute([$product_id]);
}

function get_product_reviews($product_id) {
    $conn = db_connect();
    $stmt = $conn->prepare("
        SELECT r.*, u.first_name, u.last_name 
        FROM reviews r 
        LEFT JOIN users u ON r.customer_id = u.id 
        WHERE r.product_id = ? AND r.is_approved = 1 
        ORDER BY r.created_at DESC
    ");
    $stmt->execute([$product_id]);
    return $stmt->fetchAll();
}

function get_average_rating($product_id) {
    $conn = db_connect();
    $stmt = $conn->prepare("SELECT AVG(rating) as avg_rating FROM reviews WHERE product_id = ? AND is_approved = 1");
    $stmt->execute([$product_id]);
    $result = $stmt->fetch();
    return $result['avg_rating'] ? round($result['avg_rating'], 1) : 0;
}

function create_contact_message($name, $email, $subject, $message) {
    $conn = db_connect();
    $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$name, $email, $subject, $message]);
}

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function is_admin() {
    return isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin';
}

function is_artisan() {
    return isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'artisan';
}

function redirect($url) {
    header("Location: $url");
    exit();
}

function set_flash_message($type, $message) {
    $_SESSION['flash_message'] = [
        'type' => $type,
        'message' => $message
    ];
}

function get_flash_message() {
    if (isset($_SESSION['flash_message'])) {
        $message = $_SESSION['flash_message'];
        unset($_SESSION['flash_message']);
        return $message;
    }
    return null;
}

function display_flash_message() {
    $flash = get_flash_message();
    if ($flash) {
        $type = $flash['type'];
        $message = $flash['message'];
        echo "<div class='alert alert-$type'>$message</div>";
    }
}
?> 