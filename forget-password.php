<?php
// Configuration
$db_host = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name = 'login';

// Connect to database
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle password reset request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $token = $_POST["token"];
    $new_password = $_POST["new_password"];

    // Validate input
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address.";
        exit;
    }

    if (strlen($token) < 32) { // Assuming a 32-character token
        echo "Invalid token.";
        exit;
    }

    if (strlen($new_password) < 8) { // Assuming a minimum password length of 8 characters
        echo "Password must be at least 8 characters long.";
        exit;
    }

    // Sanitize input
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $token = filter_var($token, FILTER_SANITIZE_STRING);
    $new_password = filter_var($new_password, FILTER_SANITIZE_STRING);

    // Verify token and email address
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND password_reset_token = ?");
    $stmt->bind_param("ss", $email, $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Update user's password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET password = ?, password_reset_token = NULL WHERE email = ?");
        $stmt->bind_param("ss", $hashed_password, $email);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Password updated successfully!";
        } else {
            echo "Error updating password.";
        }
    } else {
        echo "Invalid token or email address.";
    }
}

// Close database connection
$conn->close();
?>