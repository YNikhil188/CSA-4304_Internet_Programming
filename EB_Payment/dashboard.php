<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Electricity Bill Payment</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Welcome to your Dashboard, <?php echo $_SESSION['username']; ?></h2>
        <p>Here you can view your current bill, payment history, and set up automatic payments.</p>
        <a href="pay_bill.php" align:center>Pay Bill </a> |
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>
