<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

// Dummy data for example, in real scenarios, fetch from database
$units_used = 350;
$connection_type = 'domestic';
$amount = 0;

// Bill calculation logic
if ($connection_type == 'domestic') {
    if ($units_used <= 100) {
        $amount = $units_used * 1;
    } elseif ($units_used <= 200) {
        $amount = (100 * 1) + (($units_used - 100) * 2.50);
    } elseif ($units_used <= 500) {
        $amount = (100 * 1) + (100 * 2.50) + (($units_used - 200) * 4);
    } else {
        $amount = (100 * 1) + (100 * 2.50) + (300 * 4) + (($units_used - 500) * 6);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay Bill - Electricity Bill Payment</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Your Bill Details</h2>
        <p>Units Used: <?php echo $units_used; ?> units</p>
        <p>Amount to Pay: Rs. <?php echo $amount; ?></p>
        <form action="process_payment.php" method="POST">
            <label for="payment_method">Select Payment Method:</label>
            <select id="payment_method" name="payment_method">
                <option value="credit_card">Credit Card</option>
                <option value="debit_card">Debit Card</option>
                <option value="net_banking">Net Banking</option>
                <option value="digital_wallet">Digital Wallet</option>
            </select>
            <button type="submit">Pay Now</button>
        </form>
    </div>
</body>
</html>
