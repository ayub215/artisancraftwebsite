<?php
session_start();

$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'artisancraft';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Collect form input
$email    = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$usertype = $_POST['usertype'] ?? '';

// Basic validation
if (empty($email) || empty($password) || !in_array($usertype, ['customer', 'artisan', 'admin'])) {
    die("Invalid login details.");
}

// Map table and password field
$tableMap = [
    'customer' => 'customers',
    'artisan'  => 'artisans',
    'admin'    => 'admins'
];

$table = $tableMap[$usertype];
$passwordColumn = 'password_hash';

// Build SQL with artisan approval check
if ($usertype === 'artisan') {
    $sql = "SELECT id, name, email, $passwordColumn, approved FROM $table WHERE email = ?";
} else {
    $sql = "SELECT id, name, email, $passwordColumn FROM $table WHERE email = ?";
}

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();

    if (password_verify($password, $row[$passwordColumn])) {
        // Check approval status for artisans
        if ($usertype === 'artisan' && $row['approved'] != 1) {
            echo "<script>
                alert('Your artisan registration has been received and is pending admin approval. You will be able to log in once it is approved.');
                window.location.href = 'Login2.html';
            </script>";
            exit;
        }

        // Login success
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['name'] = $row['name'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['usertype'] = $usertype;

        header("Location: dashboard.php");
        exit;

    } else {
        echo "<script>
            alert('Incorrect password. Please try again.');
            window.location.href = 'login.php';
        </script>";
    }

} else {
    echo "<script>
        alert('No account found with this email.');
        window.location.href = 'login.php';
    </script>";
}

$stmt->close();
$conn->close();
?>
