<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'electricity_bill');

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the customer ID based on the logged-in user
$username = $_SESSION['username'];
$customer_query = "SELECT customer_id FROM customers WHERE username = '$username'";
$customer_result = $conn->query($customer_query);

if ($customer_result->num_rows == 1) {
    $customer = $customer_result->fetch_assoc();
    $customer_id = $customer['customer_id'];
} else {
    die("Customer not found.");
}

// Get the selected payment method and bill details from the form
$payment_method = $_POST['payment_method'];
$bill_query = "SELECT * FROM bills WHERE customer_id = $customer_id AND payment_status = 'unpaid' LIMIT 1";
$bill_result = $conn->query($bill_query);

if ($bill_result->num_rows == 1) {
    $bill = $bill_result->fetch_assoc();
    $bill_id = $bill['bill_id'];
    $amount_to_pay = $bill['amount'];
    
    // Update the bill to mark it as paid, record the payment method and date
    $payment_date = date('Y-m-d');
    $update_bill_query = "UPDATE bills SET payment_status = 'paid', payment_method = '$payment_method', payment_date = '$payment_date' WHERE bill_id = $bill_id";
    
    if ($conn->query($update_bill_query) === TRUE) {
        // Display success message and show receipt
        echo "<h2>Payment Successful!</h2>";
        echo "<p>Amount Paid: Rs. " . $amount_to_pay . "</p>";
        echo "<p>Payment Method: " . $payment_method . "</p>";
        echo "<p>Payment Date: " . $payment_date . "</p>";
        echo "<a href='dashboard.php'>Go back to Dashboard</a>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    echo "<p>No unpaid bills found.</p>";
}

$conn->close();
?>
