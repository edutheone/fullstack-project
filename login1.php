<?php
include 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $phone = trim($_POST['phone']);
    $password = trim($_POST['password']);

    // Check empty fields
    if (empty($phone) || empty($password)) {
        echo "<script>alert('Please fill all fields.'); window.history.back();</script>";
        exit; 
    }

    // Prepare statement
    $stmt = $conn->prepare("SELECT id, fullname, password FROM users WHERE phone = ?");
    $stmt->bind_param("s", $phone);
    $stmt->execute();

    // Get result
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        echo "<script>alert('Phone number not found'); window.history.back();</script>";
        exit;
    }

    $user = $result->fetch_assoc();

    // Check password
    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['fullname'] = $user['fullname'];  // ✅ store fullname
        $_SESSION['phone'] = $phone;

        echo "<script>alert('Login successful'); window.location.href='dashboard.php';</script>";
    } else {
        echo "<script>alert('Incorrect password'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
