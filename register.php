<?php
include 'connect.php';

if (isset($_POST['signUp'])) {
    $firstName = $_POST['fname'];
    $lastName = $_POST['lName'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash the password using password_hash
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $checkEmail = "SELECT * From users where email=?";
    $stmt = $conn->prepare($checkEmail);
    if (!$stmt) {
        echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
    } else {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            echo "Email Address Already Exists ! ";
        } else {
            $insertQuery = "INSERT INTO users(firstName, lastName, email, password)
                        VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($insertQuery);
            if (!$stmt) {
                echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
            } else {
                $stmt->bind_param("ssss", $firstName, $lastName, $email, $hashedPassword);
                if ($stmt->execute()) {
                    header("location: index.php");
                } else {
                    echo "Error:" . $conn->error;
                }
            }
        }
    }
}

if (isset($_POST['signIn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email=?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
    } else {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hashedPassword = $row['password'];

            // Verify the password using password_verify
            if (password_verify($password, $hashedPassword)) {
                session_start();
                $_SESSION['email'] = $row['email'];
                header("location: homepage.php");
                exit();
            } else {
                echo "Not Found, Incorrect Email or Password";
            }
        } else {
            echo "Not Found, Incorrect Email or Password";
        }
    }
}
?>