<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $user_id = $_SESSION['user_id'];
    $phone = $_POST['phone'];
    $amount = $_POST['amount'];
    $purpose = $_POST['purpose'];
    $processing_fee = 100; // fixed processing fee

    // Save loan application with status "Pending Payment"
    $loan_query = "INSERT INTO loan_applications (user_id, amount, purpose, phone, status) 
                   VALUES ('$user_id', '$amount', '$purpose', '$phone', 'Pending Payment')";
    mysqli_query($conn, $loan_query);
    $loan_id = mysqli_insert_id($conn);

    // STK Push to pay processing fee
    $consumerKey = 'ql6ZSa5eDCndvDecIIH83FUpG2o1DAgp3t0BJH5ADPXRueGt';
    $consumerSecret = 'pkoHvzSCg1JYjfypcTMgJz1LqTOfa7AoFvhzp8AYjut6yDxhCAZgtfUA7ScArXv3';
    $shortCode = '174379';
    $passkey = 'bfb279f9aa9bdbcf158e97dd71a467cd2b';
    $callbackUrl = 'https://localhost/tuvuke/callback.php'; // public URL
    $timestamp = date('YmdHis');
    $password = base64_encode($shortCode . $passkey . $timestamp);

    // Get access token
    $credentials = base64_encode($consumerKey . ':' . $consumerSecret);
    $token_url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $token_url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Basic ' . $credentials]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    $data = json_decode($result);
    $accessToken = $data->access_token;

    // Prepare STK Push request
    $stk_url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
    $stkRequest = [
        'BusinessShortCode' => $shortCode,
        'Password' => $password,
        'Timestamp' => $timestamp,
        'TransactionType' => 'CustomerPayBillOnline',
        'Amount' => $processing_fee,
        'PartyA' => $phone,
        'PartyB' => $shortCode,
        'PhoneNumber' => $phone,
        'CallBackURL' => $callbackUrl,
        'AccountReference' => 'TuvukePamoja',
        'TransactionDesc' => 'Processing Fee'
    ];

    $ch2 = curl_init();
    curl_setopt($ch2, CURLOPT_URL, $stk_url);
    curl_setopt($ch2, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $accessToken
    ]);
    curl_setopt($ch2, CURLOPT_POST, true);
    curl_setopt($ch2, CURLOPT_POSTFIELDS, json_encode($stkRequest));
    curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch2);
    curl_close($ch2);

    $result2 = json_decode($response, true);
    $checkoutRequestID = $result2['CheckoutRequestID'] ?? null;

    // Store payment request in DB
    $payment_query = "INSERT INTO payments (user_id, loan_id, checkout_request_id, amount, status) 
                      VALUES ('$user_id', '$loan_id', '$checkoutRequestID', '$processing_fee', 'Pending')";
    mysqli_query($conn, $payment_query);

    echo "<script>
            alert('Processing fee request sent! Please check your phone to complete payment.');
            window.location.href='confirmation.php';
          </script>";
}
?>
