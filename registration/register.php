<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root"; // Change if you have a different username
$password = "Apk@12345"; // Default is empty in XAMPP/WAMP
$dbname = "my_website"; // Make sure this matches your database in MySQL Workbench

// Connect to MySQL
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Get form data
$user = $_POST['username'];
$email = $_POST['email'];
$pass = $_POST['password'];

// Hash the password for security
$pass_hashed = password_hash($pass, PASSWORD_DEFAULT);

// Use prepared statements to prevent SQL injection
$stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $user, $email, $pass_hashed);

if ($stmt->execute()) {
    echo "Registration successful!";
} else {
    echo "Error: " . $stmt->error;
}

// Close connection
$stmt->close();
$conn->close();
?>
