<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "quiz_app";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$quiz_id = $_GET['quiz_id'];

$questions_sql = "SELECT * FROM questions WHERE quiz_id = $quiz_id";
$questions_result = $conn->query($questions_sql);

$quiz_title_sql = "SELECT title FROM quizzes WHERE id = $quiz_id";
$quiz_title_result = $conn->query($quiz_title_sql);
$quiz_title = $quiz_title_result->fetch_assoc()['title'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Take Quiz</title>
    <style> body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    text-align: center;
    margin: 0;
    padding: 20px;
}

.container {
    max-width: 600px;
    margin: 0 auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

h2 {
    color: #000080;
}

ul {
    list-style: none;
    padding: 0;
}

li {
    font-size: 18px;
    margin-bottom: 10px;
}

ul ul li {
    margin-left: 20px;
    margin-top: 5px;
    font-size: 16px;
    color: #333333;
}

input[type="radio"] {
    margin-right: 10px;
}

input[type="submit"] {
    padding: 10px 20px;
    font-size: 16px;
    background-color: #000080;
    color: #ffffff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #0000a0;
}
</style>
</head>
<body>
<div class="container">
<h2><?php echo $quiz_title; ?></h2>

<form action="submit_quiz.php" method="post">
    <input type="hidden" name="quiz_id" value="<?php echo $quiz_id; ?>">
    <ul>
        <?php while ($row = $questions_result->fetch_assoc()): ?>
        <li><br>
                <?php echo $row['text']; ?>
                <ul>
                    <?php
                    $question_id = $row['id'];
                    $answers_sql = "SELECT * FROM answers WHERE question_id = $question_id";
                    $answers_result = $conn->query($answers_sql);

                    while ($answer = $answers_result->fetch_assoc()): ?>
                        <li>
                           
                            <input type="radio" name="answers[<?php echo $question_id; ?>]" value="<?php echo $answer['id']; ?>">
                            <?php echo $answer['text']; ?>
                        </li>
                    <?php endwhile; ?>
                </ul>
            </li>
        <?php endwhile; ?>
    </ul>

    <input type="submit" value="Submit Quiz">
</form>
</div>
</body>
</html>

<?php
$conn->close();
?>
