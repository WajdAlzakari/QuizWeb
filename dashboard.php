<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "quiz_app";;

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in as admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Retrieve quizzes
$quizzes_sql = "SELECT * FROM quizzes";
$quizzes_result = $conn->query($quizzes_sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            color: #333333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            max-width: 80%;
            padding: 5%;
            background-color: #f0f8ff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
        }

        h2 {
            color: #000080;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        ul li {
            margin-bottom: 10px;
        }

        a {
            text-decoration: none;
            color: #000080;
        }

        a:hover {
            color: #0000a0;
        }
        
      #add  {background-color: #000080; /* Dark blue button */
    color: #ffffff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;}
    </style>
</head>
<body>
<div class="container">
          <h2>Admin Dashboard</h2><br>

<h3>Quizzes</h3>
<ul>
    <?php while ($row = $quizzes_result->fetch_assoc()): ?>
        <li>
            <a href="quiz_details.php?quiz_id=<?php echo $row['id']; ?>">View - <?php echo $row['title']; ?></a>
        </li>
    <?php endwhile; ?>
</ul><br>
<a href="add_quiz.php" id="add">Add Quiz</a><!-- comment --><br>
<br> <br>
<h3>Users</h3>
<ul>
    <?php
    $users_with_role_user_sql = "SELECT username FROM users WHERE role = 'user'";
    $users_with_role_user_result = $conn->query($users_with_role_user_sql);

    while ($user_row = $users_with_role_user_result->fetch_assoc()): ?>
        <li><?php echo $user_row['username']; ?></li>
    <?php endwhile; ?>
</ul>
</div>
</body>
</html>

<?php
$conn->close();
?>