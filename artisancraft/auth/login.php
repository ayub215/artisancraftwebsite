<?php
session_start();
require_once '../config/database.php';

// Check if user is already logged in
if (is_logged_in()) {
    redirect('../index.php');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize_input($_POST['email']);
    $password = $_POST['password'];
    $user_type = sanitize_input($_POST['usertype']);

    // Validate input
    if (empty($email) || empty($password)) {
        $error = 'Please fill in all fields.';
    } else {
        try {
            $conn = db_connect();
            
            // Get user by email and user type
            $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND user_type = ? AND is_active = 1");
            $stmt->execute([$email, $user_type]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                // Login successful
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['user_type'] = $user['user_type'];
                $_SESSION['first_name'] = $user['first_name'];
                $_SESSION['last_name'] = $user['last_name'];

                // Update last login time
                $stmt = $conn->prepare("UPDATE users SET updated_at = CURRENT_TIMESTAMP WHERE id = ?");
                $stmt->execute([$user['id']]);

                // Redirect based on user type
                switch ($user_type) {
                    case 'admin':
                        redirect('../admin/dashboard.php');
                        break;
                    case 'artisan':
                        redirect('../artisan/dashboard.php');
                        break;
                    default:
                        redirect('../index.php');
                        break;
                }
            } else {
                $error = 'Invalid email, password, or user type.';
            }
        } catch (Exception $e) {
            $error = 'An error occurred. Please try again.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ArtisanCraft</title>
    <link rel="stylesheet" href="../styles.css">
    <style>
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .login-form {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(139, 69, 19, 0.2);
            max-width: 400px;
            width: 100%;
        }
        
        .login-form h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #8B4513;
        }
        
        .error-message {
            background: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #5d4037;
            font-weight: 600;
        }
        
        .form-group input, .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }
        
        .form-group input:focus, .form-group select:focus {
            outline: none;
            border-color: #8B4513;
        }
        
        .login-btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #8B4513, #A0522D);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.3s ease;
        }
        
        .login-btn:hover {
            transform: translateY(-2px);
        }
        
        .signup-link {
            text-align: center;
            margin-top: 20px;
        }
        
        .signup-link a {
            color: #8B4513;
            text-decoration: none;
            font-weight: 600;
        }
        
        .signup-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-form">
            <h2>Login to ArtisanCraft</h2>
            
            <?php if ($error): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <div class="form-group">
                    <label for="usertype">User Type</label>
                    <select id="usertype" name="usertype" required>
                        <option value="">Select User Type</option>
                        <option value="customer" <?php echo (isset($_POST['usertype']) && $_POST['usertype'] === 'customer') ? 'selected' : ''; ?>>Customer</option>
                        <option value="artisan" <?php echo (isset($_POST['usertype']) && $_POST['usertype'] === 'artisan') ? 'selected' : ''; ?>>Artisan</option>
                        <option value="admin" <?php echo (isset($_POST['usertype']) && $_POST['usertype'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
                    </select>
                </div>
                
                <button type="submit" class="login-btn">Login</button>
            </form>
            
            <div class="signup-link">
                <p>Don't have an account? <a href="../signup.php">Sign up here</a></p>
            </div>
        </div>
    </div>
</body>
</html> 