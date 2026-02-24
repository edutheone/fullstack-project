<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $fullname = trim($_POST['fullname']);
    $phone = trim($_POST['phone']);
    $password = trim($_POST['password']);

    // Check empty fields
    if (empty($fullname) || empty($phone) || empty($password)) {
        echo "<script>
                alert('Please fill all fields.');
                window.history.back();
              </script>";
        exit;
    }

    // Check if phone already exists
    $check = $conn->prepare("SELECT id FROM users WHERE phone = ?");
    $check->bind_param("s", $phone);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        echo "<script>
                alert('Phone number already used. Try another phone number.');
                window.history.back();
              </script>";
        exit;
    }

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert user
    $stmt = $conn->prepare("INSERT INTO users (fullname, phone, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $fullname, $phone, $hashedPassword);

    if ($stmt->execute()) {
        echo "<script>
                alert('Account created successfully. Continue to login.');
                window.location.href = 'login.php';
              </script>";
    } else {
        echo "<script>
                alert('Unexpected error occurred. Please try again.');
                window.history.back();
              </script>";
    }

    $stmt->close();
    $conn->close();
}
?>
