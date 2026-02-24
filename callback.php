<?php
include 'config.php';
$data = file_get_contents('php://input');
$callback = json_decode($data, true);

if (isset($callback['Body']['stkCallback'])) {
    $callbackData = $callback['Body']['stkCallback'];
    $checkoutRequestID = $callbackData['CheckoutRequestID'];
    $resultCode = $callbackData['ResultCode'];
    $resultDesc = $callbackData['ResultDesc'];

    // Update payments table
    if ($resultCode == 0) { // success
        mysqli_query($conn, "UPDATE payments SET status='Success' WHERE checkout_request_id='$checkoutRequestID'");
    } else {
        mysqli_query($conn, "UPDATE payments SET status='Failed' WHERE checkout_request_id='$checkoutRequestID'");
    }
}
?>
