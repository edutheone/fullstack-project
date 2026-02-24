<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$fullname = $_SESSION['fullname'];
$user_id = $_SESSION['user_id'];

// Fetch the latest payment for this user
$payQuery = mysqli_query($conn, 
    "SELECT * FROM payments WHERE user_id='$user_id' ORDER BY id DESC LIMIT 1"
);

$payment = mysqli_fetch_assoc($payQuery);

// If no payment exists
if (!$payment) {
    header("Location: apply.php");
    exit;
}

// If payment is NOT successful
if ($payment['status'] !== "Success") {
    header("Location: confirmation_wait.php"); // This is the waiting page I will create for you
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Confirmed - Tuvuke Pamoja</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>

<div class="container confirmation-container">
    <h2>Thank You, <?php echo htmlspecialchars($fullname); ?>!</h2>

    <p>Your loan application has been successfully submitted and payment has been confirmed.</p>
    <p>You will be contacted shortly regarding your application.</p>

    <a href="dashboard.php" class="btn">Back to Dashboard</a>
</div>

</body>
</html>
