<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$fullname = $_SESSION['fullname'];
$phone = $_SESSION['phone'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for Loan - Tuvuke Pamoja</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>

<div class="container">
    <h2>Hello, <?php echo $fullname; ?>! Apply for a Loan</h2>

    <form action="pay1.php" method="POST">
        <label>Loan Amount (Ksh)</label>
        <input type="number" name="amount" placeholder="Enter amount" required>

        <label>Loan Purpose</label>
        <input type="text" name="purpose" placeholder="Enter purpose of loan" required>
        <label>Monthly income (Ksh)</label>
        <input type="number" name="amount" placeholder="Enter amount" required>

        <label>Phone Number</label>
        <input type="text" name="phone" value="<?php echo $phone; ?>" readonly>

        <p>Processing Fee: <strong>Ksh 100</strong>. You will be prompted to pay via M-PESA immediately after submission.</p>

        <button type="submit" class="btn">Submit Application & Pay Fee</button>
    </form>
</div>

</body>
</html>
