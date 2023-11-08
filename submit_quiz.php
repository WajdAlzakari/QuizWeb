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

$quiz_id = $_POST['quiz_id'];
$answers = $_POST['answers'];

$correct_answers = 0;

foreach ($answers as $question_id => $answer_id) {
    $check_answer_sql = "SELECT is_correct FROM answers WHERE id = $answer_id";
    $check_answer_result = $conn->query($check_answer_sql);
    $is_correct = $check_answer_result->fetch_assoc()['is_correct'];

    if ($is_correct) {
        $correct_answers++;
    }
}

$total_questions_sql = "SELECT COUNT(*) as total FROM questions WHERE quiz_id = $quiz_id";
$total_questions_result = $conn->query($total_questions_sql);
$total_questions = $total_questions_result->fetch_assoc()['total'];

$result_percentage = ($correct_answers / $total_questions) * 100;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Quiz Result</title>
</head>
<body>

<h2>Quiz Result</h2>

<p>You got <?php echo $correct_answers; ?> out of <?php echo $total_questions; ?> correct.</p>
<p>Percentage: <?php echo $result_percentage; ?>%</p>

</body>
</html>

<?php
$conn->close();
?>
