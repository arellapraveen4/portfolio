<?php
session_start(); // Start the session

$servername = "localhost"; // Your MySQL server
$username = "root"; // Your MySQL username
$password = "Apk@12345"; // Your MySQL password
$dbname = "my_website"; // Change to your actual database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Secure query using prepared statements
    $stmt = $conn->prepare("SELECT id, username, email, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $username, $email, $hashed_password);
        $stmt->fetch();

        if (password_verify($pass, $hashed_password)) { // Verify hashed password
            // Store user details in session
            $_SESSION['id'] = $id;
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;

            // Redirect to home page
            header("Location: home.php");
            exit();
        } else {
            echo "Invalid username or password.";
        }
    } else {
        echo "Invalid username or password.";
    }

    $stmt->close();
}

$conn->close();
?>
