<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BrainyBuzz - Sign Up</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="signup-form">
    <h2>Join BrainyBuzz!</h2>
    <form action="" method="post">
        <select id="role" name="role">
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select>

        <input type="text" id="username" name="username" placeholder="Username" required>
        <input type="password" id="password" name="password" placeholder="Password" required>
        <button type="submit">Sign Up</button>
    </form>
</div>

</body>
</html>

<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Establish database connection
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "quiz_app";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get user input from form
    $username = $_POST['username'];
    $role = $_POST['role'];
    $password = $_POST['password'];

    // Hash the password (for security)
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare a parameterized query
    $stmt = $conn->prepare("INSERT INTO users (username, role, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $role, $hashed_password);

    // Execute the statement
    if ($stmt->execute()) {
        echo "<script>alert('You have signed up successfully');</script>";
        echo '<script>window.location.href = "../SignIn/SignIn.php";</script>';
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>

