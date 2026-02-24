<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// get last payment by this user
$q = mysqli_query($conn, 
    "SELECT * FROM payments WHERE user_id='$user_id' ORDER BY id DESC LIMIT 1"
);

$payment = mysqli_fetch_assoc($q);

// If no payment found, return user to application page
if (!$payment) {
    header("Location: apply.php");
    exit;
}

$status = $payment['status'];
$loan_id = $payment['loan_id'];

// Redirect based on payment status
if ($status === "Success") {
    header("Location: confirmation.php");
    exit;
}

if ($status === "Failed") {
    header("Location: payment_failed.php");
    exit;
}

// If still pending, display waiting page below
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Processing Payment...</title>
    <meta http-equiv="refresh" content="4"> <!-- Refresh every 4 seconds -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            text-align: center;
            padding-top: 100px;
        }
        .box {
            background: #fff;
            width: 400px;
            margin: auto;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .loader {
            border: 8px solid #e3e3e3;
            border-top: 8px solid #28a745;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            margin: 20px auto;
            animation: spin 1.2s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>

<div class="box">
    <h2>Please Complete Payment</h2>
    <div class="loader"></div>
    <p>We sent an M-Pesa STK Push to your number.</p>
    <p>Enter your M-Pesa PIN to continue.</p>
    <p><small>This page will refresh automatically.</small></p>
</div>

</body>
</html>
