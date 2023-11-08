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
</head>
<body>

<h2><?php echo $quiz_title; ?></h2>

<form action="submit_quiz.php" method="post">
    <input type="hidden" name="quiz_id" value="<?php echo $quiz_id; ?>">
    <ul>
        <?php while ($row = $questions_result->fetch_assoc()): ?>
            <li>
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

</body>
</html>

<?php
$conn->close();
?>
