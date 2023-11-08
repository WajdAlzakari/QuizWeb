<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BrainyBuzz - Sign In</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="signup-form">
    <h2>Wlcome Back!</h2>
    <form action="" method="post">
        <select id="role" name="role">
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select>

        <input type="text" id="username" name="username" placeholder="Username" required>
        <input type="password" id="password" name="password" placeholder="Password" required>
        <button type="submit">Sign In</button>
    </form>
</div>

</body>
</html>

<?php
session_start();

// Set session cookie to HTTPS only if you are using HTTPS
// session_set_cookie_params(['secure' => true, 'httponly' => true, 'samesite' => 'Strict']);

// Error reporting for debugging (remove this in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $row['role']; // Assuming 'role' is a column in your 'users' table

            if ($row['role'] == 'admin') {
                header("Location: dashboard.php");
                exit();
            } else {
                header("Location:../quizMenu.html");
                exit();
            }
        } else {
            echo "<script>alert('Incorrect password.');</script>";
        }
    } else {
        echo "<script>alert('Username does not exist.');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
