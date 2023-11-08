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

// Get quiz_id from query parameter
$quiz_id = $_GET['quiz_id'];

// Retrieve quiz details
$quiz_sql = "SELECT * FROM quizzes WHERE id = $quiz_id";
$quiz_result = $conn->query($quiz_sql);
$quiz = $quiz_result->fetch_assoc();

// Retrieve questions and answers for the quiz
$questions_sql = "SELECT * FROM questions WHERE quiz_id = $quiz_id";
$questions_result = $conn->query($questions_sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Quiz Details</title>
    <style> body {
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
    max-width: 80%; /* Set the max-width to 80% */
    padding: 20px;
    background-color: #f0f8ff;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    text-align: center;
    width: 50vw;
}

h2 {
    color: #085399;
}

h3 {
    margin-top: 20px;
    color: #085399;
}

ul {
    list-style: none;
    padding: 0;
}

ul li {
    margin-bottom: 10px;
}

ul ul li {
    margin-left: 20px;
    margin-top: 5px;
    color: #333333;
}

ul ul li.correct {
    color: #085399; /* Green for correct answers */
}

ul ul li.incorrect {
    color: #FF0000; /* Red for incorrect answers */
}
ul li.question {
    font-weight: bold;
    color: #085399; /* Dark blue color */
}
</style>
</head>

<body>
    <div class="container">
        <h2>Quiz Details</h2>

        <h3>Quiz Name: <?php echo $quiz['title']; ?></h3>
        <br> 

        <h3>Questions:</h3>
        <ul>
            <?php while ($row = $questions_result->fetch_assoc()): ?>
            <li class="question"><?php echo $row['text']; ?></li>
                <ul>
                    <?php
                    $question_id = $row['id'];
                    $answers_sql = "SELECT * FROM answers WHERE question_id = $question_id";
                    $answers_result = $conn->query($answers_sql);
                    while ($answer = $answers_result->fetch_assoc()): ?>
                        <li><?php echo $answer['text']; ?> - <?php echo $answer['is_correct'] ? 'Correct' : 'Incorrect'; ?></li>
                    <?php endwhile; ?>
                    <br>
                </ul>
            <?php endwhile; ?>
        </ul>
    </div>
</body>
</html>

<?php
$conn->close();
?>
