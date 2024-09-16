<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'electricity_bill');
if ($conn->connect_error) 
{
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $username = $_POST['username'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM customers WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0)
    {
        $_SESSION['username'] = $username;
        header("Location: dashboard.php");
    } 
    else 
    {
        echo "Invalid login credentials.";
    }
}
$conn->close();
?>
